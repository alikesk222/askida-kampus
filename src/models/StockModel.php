<?php

namespace Models;

use Core\Database;
use PDO;

class StockModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getByVenue(int $venueId): array
    {
        $stmt = $this->db->prepare(
            'SELECT ss.*, p.name AS product_name, p.category, p.price_snapshot,
                    (ss.available_quantity - ss.reserved_quantity) AS free_quantity
             FROM suspended_stocks ss
             INNER JOIN products p ON p.id = ss.product_id
             WHERE ss.venue_id = ?
             ORDER BY p.name ASC'
        );
        $stmt->execute([$venueId]);
        return $stmt->fetchAll();
    }

    public function findByVenueProduct(int $venueId, int $productId): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM suspended_stocks WHERE venue_id = ? AND product_id = ? LIMIT 1'
        );
        $stmt->execute([$venueId, $productId]);
        return $stmt->fetch() ?: null;
    }

    public function findByVenueProductForUpdate(int $venueId, int $productId): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM suspended_stocks WHERE venue_id = ? AND product_id = ? LIMIT 1 FOR UPDATE'
        );
        $stmt->execute([$venueId, $productId]);
        return $stmt->fetch() ?: null;
    }

    public function increaseAvailable(int $venueId, int $productId, int $qty): void
    {
        $existing = $this->findByVenueProduct($venueId, $productId);
        if ($existing) {
            $stmt = $this->db->prepare(
                'UPDATE suspended_stocks SET available_quantity = available_quantity + ?
                 WHERE venue_id = ? AND product_id = ?'
            );
            $stmt->execute([$qty, $venueId, $productId]);
        } else {
            $stmt = $this->db->prepare(
                'INSERT INTO suspended_stocks (venue_id, product_id, available_quantity, reserved_quantity)
                 VALUES (?, ?, ?, 0)'
            );
            $stmt->execute([$venueId, $productId, $qty]);
        }
    }

    public function increaseReserved(int $venueId, int $productId, int $qty): void
    {
        $stmt = $this->db->prepare(
            'UPDATE suspended_stocks SET reserved_quantity = reserved_quantity + ?
             WHERE venue_id = ? AND product_id = ?'
        );
        $stmt->execute([$qty, $venueId, $productId]);
    }

    public function decreaseReserved(int $venueId, int $productId, int $qty): void
    {
        $stmt = $this->db->prepare(
            'UPDATE suspended_stocks SET reserved_quantity = GREATEST(0, reserved_quantity - ?)
             WHERE venue_id = ? AND product_id = ?'
        );
        $stmt->execute([$qty, $venueId, $productId]);
    }

    public function decreaseAvailableAndReserved(int $venueId, int $productId, int $qty): void
    {
        $stmt = $this->db->prepare(
            'UPDATE suspended_stocks
             SET available_quantity = GREATEST(0, available_quantity - ?),
                 reserved_quantity  = GREATEST(0, reserved_quantity - ?)
             WHERE venue_id = ? AND product_id = ?'
        );
        $stmt->execute([$qty, $qty, $venueId, $productId]);
    }

    public function getFreeQuantity(int $venueId, int $productId): int
    {
        $stmt = $this->db->prepare(
            'SELECT (available_quantity - reserved_quantity) AS free
             FROM suspended_stocks WHERE venue_id = ? AND product_id = ? LIMIT 1'
        );
        $stmt->execute([$venueId, $productId]);
        $row = $stmt->fetch();
        return $row ? max(0, (int)$row['free']) : 0;
    }

    public function getTotalAvailable(int $venueId): int
    {
        $stmt = $this->db->prepare(
            'SELECT COALESCE(SUM(available_quantity - reserved_quantity), 0)
             FROM suspended_stocks WHERE venue_id = ?'
        );
        $stmt->execute([$venueId]);
        return max(0, (int)$stmt->fetchColumn());
    }
}
