<?php

namespace Models;

use Core\Database;
use PDO;

class DonationModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(int $page = 1, int $perPage = 20, ?string $status = null): array
    {
        $offset = ($page - 1) * $perPage;
        $where  = $status ? 'WHERE d.status = ?' : '';
        $params = $status ? [$status, $perPage, $offset] : [$perPage, $offset];
        $stmt = $this->db->prepare(
            "SELECT d.*,
                    COALESCE(d.donor_name, u.name, 'Misafir') AS donor_name,
                    COALESCE(d.donor_email, u.email, '') AS donor_email,
                    v.name AS venue_name
             FROM donations d
             LEFT JOIN users u  ON u.id = d.donor_id
             INNER JOIN venues v ON v.id = d.venue_id
             $where ORDER BY d.created_at DESC LIMIT ? OFFSET ?"
        );
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function countAll(?string $status = null): int
    {
        if ($status) {
            $stmt = $this->db->prepare('SELECT COUNT(*) FROM donations WHERE status = ?');
            $stmt->execute([$status]);
        } else {
            $stmt = $this->db->query('SELECT COUNT(*) FROM donations');
        }
        return (int)$stmt->fetchColumn();
    }

    public function getByVenue(int $venueId, int $page = 1, int $perPage = 20): array
    {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->db->prepare(
            'SELECT d.*,
                    COALESCE(d.donor_name, u.name, \'Misafir\') AS donor_name,
                    COALESCE(d.donor_email, u.email, \'\') AS donor_email
             FROM donations d
             LEFT JOIN users u ON u.id = d.donor_id
             WHERE d.venue_id = ?
             ORDER BY d.created_at DESC LIMIT ? OFFSET ?'
        );
        $stmt->execute([$venueId, $perPage, $offset]);
        return $stmt->fetchAll();
    }

    public function countByVenue(int $venueId): int
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM donations WHERE venue_id = ?');
        $stmt->execute([$venueId]);
        return (int)$stmt->fetchColumn();
    }

    public function getByDonor(int $donorId): array
    {
        $stmt = $this->db->prepare(
            'SELECT d.*, v.name AS venue_name FROM donations d
             INNER JOIN venues v ON v.id = d.venue_id
             WHERE d.donor_id = ? ORDER BY d.created_at DESC'
        );
        $stmt->execute([$donorId]);
        return $stmt->fetchAll();
    }

    public function getByEmail(string $email): array
    {
        $stmt = $this->db->prepare(
            'SELECT d.*, v.name AS venue_name FROM donations d
             INNER JOIN venues v ON v.id = d.venue_id
             WHERE d.donor_email = ? ORDER BY d.created_at DESC'
        );
        $stmt->execute([$email]);
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT d.*,
                    COALESCE(d.donor_name, u.name, \'Misafir\') AS donor_name,
                    v.name AS venue_name
             FROM donations d
             LEFT JOIN users u  ON u.id = d.donor_id
             INNER JOIN venues v ON v.id = d.venue_id
             WHERE d.id = ? LIMIT 1'
        );
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO donations (donor_id, venue_id, total_amount, payment_method, status, notes, donor_name, donor_email, is_guest)
             VALUES (:donor_id, :venue_id, :total_amount, :payment_method, :status, :notes, :donor_name, :donor_email, :is_guest)'
        );
        $stmt->execute([
            'donor_id'       => $data['donor_id'] ?? null,
            'venue_id'       => $data['venue_id'],
            'total_amount'   => $data['total_amount'],
            'payment_method' => $data['payment_method'] ?? 'iban',
            'status'         => 'waiting_approval',
            'notes'          => $data['notes'] ?? null,
            'donor_name'     => $data['donor_name'] ?? null,
            'donor_email'    => $data['donor_email'] ?? null,
            'is_guest'       => $data['is_guest'] ?? 0,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function createItem(array $data): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO donation_items (donation_id, product_id, quantity, price_snapshot)
             VALUES (:donation_id, :product_id, :quantity, :price_snapshot)'
        );
        $stmt->execute([
            'donation_id'    => $data['donation_id'],
            'product_id'     => $data['product_id'],
            'quantity'       => $data['quantity'],
            'price_snapshot' => $data['price_snapshot'],
        ]);
    }

    public function approve(int $id, int $approvedBy): void
    {
        $stmt = $this->db->prepare(
            "UPDATE donations SET status='paid', approved_by=?, approved_at=NOW() WHERE id=?"
        );
        $stmt->execute([$approvedBy, $id]);
    }

    public function getItems(int $donationId): array
    {
        $stmt = $this->db->prepare(
            'SELECT di.*, p.name AS product_name FROM donation_items di
             INNER JOIN products p ON p.id = di.product_id
             WHERE di.donation_id = ?'
        );
        $stmt->execute([$donationId]);
        return $stmt->fetchAll();
    }

    public function countWaiting(): int
    {
        return (int)$this->db->query("SELECT COUNT(*) FROM donations WHERE status='waiting_approval'")->fetchColumn();
    }

    public function sumPaid(): float
    {
        return (float)$this->db->query("SELECT COALESCE(SUM(total_amount),0) FROM donations WHERE status='paid'")->fetchColumn();
    }
}
