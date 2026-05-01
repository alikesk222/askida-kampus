<?php

namespace Models;

use Core\Database;
use PDO;

class ReservationModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(int $page = 1, int $perPage = 20): array
    {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->db->prepare(
            'SELECT r.*, u.name AS student_name, u.email AS student_email, v.name AS venue_name
             FROM reservations r
             INNER JOIN users u  ON u.id = r.student_id
             INNER JOIN venues v ON v.id = r.venue_id
             ORDER BY r.created_at DESC LIMIT ? OFFSET ?'
        );
        $stmt->execute([$perPage, $offset]);
        return $stmt->fetchAll();
    }

    public function countAll(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM reservations')->fetchColumn();
    }

    public function countByVenue(int $venueId): int
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM reservations WHERE venue_id = ?');
        $stmt->execute([$venueId]);
        return (int) $stmt->fetchColumn();
    }

    public function getByVenue(int $venueId, int $page = 1, int $perPage = 20): array
    {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->db->prepare(
            'SELECT r.*, u.name AS student_name, u.email AS student_email
             FROM reservations r
             INNER JOIN users u ON u.id = r.student_id
             WHERE r.venue_id = ?
             ORDER BY r.created_at DESC LIMIT ? OFFSET ?'
        );
        $stmt->execute([$venueId, $perPage, $offset]);
        return $stmt->fetchAll();
    }

    public function getByStudent(int $studentId): array
    {
        $stmt = $this->db->prepare(
            'SELECT r.*, v.name AS venue_name FROM reservations r
             INNER JOIN venues v ON v.id = r.venue_id
             WHERE r.student_id = ?
             ORDER BY r.created_at DESC'
        );
        $stmt->execute([$studentId]);
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT r.*, u.name AS student_name, v.name AS venue_name
             FROM reservations r
             INNER JOIN users u  ON u.id = r.student_id
             INNER JOIN venues v ON v.id = r.venue_id
             WHERE r.id = ? LIMIT 1'
        );
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function findByClaimCode(string $code): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT r.*, v.name AS venue_name, u.name AS student_name FROM reservations r
             INNER JOIN venues v ON v.id = r.venue_id
             LEFT JOIN users u ON u.id = r.student_id
             WHERE r.claim_code = ? LIMIT 1'
        );
        $stmt->execute([$code]);
        return $stmt->fetch() ?: null;
    }

    public function findByQrToken(string $token): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT r.*, v.name AS venue_name FROM reservations r
             INNER JOIN venues v ON v.id = r.venue_id
             WHERE r.qr_token = ? LIMIT 1'
        );
        $stmt->execute([$token]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO reservations (student_id, venue_id, status, qr_token, claim_code, expires_at)
             VALUES (:student_id, :venue_id, :status, :qr_token, :claim_code, :expires_at)'
        );
        $stmt->execute([
            'student_id' => $data['student_id'],
            'venue_id' => $data['venue_id'],
            'status' => 'reserved',
            'qr_token' => $data['qr_token'],
            'claim_code' => $data['claim_code'],
            'expires_at' => $data['expires_at'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function createItem(array $data): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO reservation_items (reservation_id, product_id, quantity, price_snapshot)
             VALUES (:reservation_id, :product_id, :quantity, :price_snapshot)'
        );
        $stmt->execute([
            'reservation_id' => $data['reservation_id'],
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity'],
            'price_snapshot' => $data['price_snapshot'],
        ]);
    }

    public function updateStatus(int $id, string $status, array $extra = []): void
    {
        $set = 'status = ?';
        $params = [$status];
        if (!empty($extra['claimed_by'])) {
            $set .= ', claimed_at = NOW(), claimed_by = ?';
            $params[] = $extra['claimed_by'];
        }
        $params[] = $id;
        $this->db->prepare("UPDATE reservations SET $set WHERE id = ?")->execute($params);
    }

    public function getItems(int $reservationId): array
    {
        $stmt = $this->db->prepare(
            'SELECT ri.*, p.name AS product_name FROM reservation_items ri
             INNER JOIN products p ON p.id = ri.product_id
             WHERE ri.reservation_id = ?'
        );
        $stmt->execute([$reservationId]);
        return $stmt->fetchAll();
    }

    public function countTodayByStudent(int $studentId): int
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM reservations
             WHERE student_id = ? AND status IN ('reserved','claimed')
             AND DATE(created_at) = CURDATE()"
        );
        $stmt->execute([$studentId]);
        return (int) $stmt->fetchColumn();
    }

    public function countWeekItemsByStudent(int $studentId): int
    {
        $stmt = $this->db->prepare(
            "SELECT COALESCE(SUM(ri.quantity), 0)
             FROM reservation_items ri
             INNER JOIN reservations r ON r.id = ri.reservation_id
             WHERE r.student_id = ? AND r.status IN ('reserved','claimed')
             AND YEARWEEK(r.created_at, 1) = YEARWEEK(CURDATE(), 1)"
        );
        $stmt->execute([$studentId]);
        return (int) $stmt->fetchColumn();
    }

    public function getExpired(): array
    {
        $stmt = $this->db->prepare(
            "SELECT r.*, ri.product_id, ri.quantity, r.venue_id
             FROM reservations r
             INNER JOIN reservation_items ri ON ri.reservation_id = r.id
             WHERE r.status = 'reserved' AND r.expires_at < NOW()"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countActive(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM reservations WHERE status='reserved'")->fetchColumn();
    }

    public function countClaimed(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM reservations WHERE status='claimed'")->fetchColumn();
    }

    /**
     * Rezervasyon kalemlerini özet string olarak getir
     * Örnek: "Çay x2, Simit x1"
     */
    public function getItemsSummary(int $reservationId): string
    {
        $items = $this->getItems($reservationId);
        $parts = [];
        foreach ($items as $item) {
            $parts[] = e($item['product_name']) . ' ×' . $item['quantity'];
        }
        return implode(', ', $parts);
    }

    /**
     * Tüm rezervasyonları ürünleriyle getir (admin için)
     */
    public function getAllWithItems(int $page = 1, int $perPage = 20): array
    {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->db->prepare(
            'SELECT r.*, u.name AS student_name, u.email AS student_email, v.name AS venue_name,
                    GROUP_CONCAT(CONCAT(p.name, " ×", ri.quantity) ORDER BY p.name SEPARATOR ", ") AS items_summary
             FROM reservations r
             INNER JOIN users u  ON u.id = r.student_id
             INNER JOIN venues v ON v.id = r.venue_id
             LEFT JOIN reservation_items ri ON ri.reservation_id = r.id
             LEFT JOIN products p ON p.id = ri.product_id
             GROUP BY r.id
             ORDER BY r.created_at DESC LIMIT ? OFFSET ?'
        );
        $stmt->execute([$perPage, $offset]);
        return $stmt->fetchAll();
    }

    /**
     * İşletmeye ait AKTİF (teslim bekleyen, süresi dolmamış) rezervasyonları ürünleriyle getir
     */
    public function getActiveByVenueWithItems(int $venueId, int $limit = 50): array
    {
        $stmt = $this->db->prepare(
            "SELECT r.*, u.name AS student_name, u.email AS student_email,
                    GROUP_CONCAT(CONCAT(p.name, ' ×', ri.quantity) ORDER BY p.name SEPARATOR ', ') AS items_summary
             FROM reservations r
             INNER JOIN users u ON u.id = r.student_id
             LEFT JOIN reservation_items ri ON ri.reservation_id = r.id
             LEFT JOIN products p ON p.id = ri.product_id
             WHERE r.venue_id = ?
               AND r.status = 'reserved'
               AND r.expires_at > NOW()
             GROUP BY r.id
             ORDER BY r.expires_at ASC
             LIMIT ?"
        );
        $stmt->bindValue(1, $venueId, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * İşletmeye ait aktif rezervasyon sayısı
     */
    public function countActiveByVenue(int $venueId): int
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM reservations
             WHERE venue_id = ? AND status = 'reserved' AND expires_at > NOW()"
        );
        $stmt->execute([$venueId]);
        return (int) $stmt->fetchColumn();
    }

    /**
     * İşletmeye ait rezervasyonları ürünleriyle getir (venue-admin için)
     */
    public function getByVenueWithItems(int $venueId, int $page = 1, int $perPage = 20): array
    {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->db->prepare(
            'SELECT r.*, u.name AS student_name, u.email AS student_email,
                    GROUP_CONCAT(CONCAT(p.name, " ×", ri.quantity) ORDER BY p.name SEPARATOR ", ") AS items_summary
             FROM reservations r
             INNER JOIN users u ON u.id = r.student_id
             LEFT JOIN reservation_items ri ON ri.reservation_id = r.id
             LEFT JOIN products p ON p.id = ri.product_id
             WHERE r.venue_id = ?
             GROUP BY r.id
             ORDER BY r.created_at DESC LIMIT ? OFFSET ?'
        );
        $stmt->execute([$venueId, $perPage, $offset]);
        return $stmt->fetchAll();
    }
}
