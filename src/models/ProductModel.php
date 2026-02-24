<?php

namespace Models;

use Core\Database;
use PDO;

class ProductModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getByVenue(int $venueId, bool $activeOnly = true): array
    {
        $sql = 'SELECT * FROM products WHERE venue_id = ?';
        if ($activeOnly) {
            $sql .= ' AND is_active = 1';
        }
        $sql .= ' ORDER BY name ASC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$venueId]);
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO products (venue_id, name, category, price_snapshot, description, image_url, is_active)
             VALUES (:venue_id, :name, :category, :price_snapshot, :description, :image_url, :is_active)'
        );
        $stmt->execute([
            'venue_id'       => $data['venue_id'],
            'name'           => $data['name'],
            'category'       => $data['category'] ?? null,
            'price_snapshot' => $data['price_snapshot'],
            'description'    => $data['description'] ?? null,
            'image_url'      => $data['image_url'] ?? null,
            'is_active'      => $data['is_active'] ?? 1,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare(
            'UPDATE products SET name=:name, category=:category, price_snapshot=:price_snapshot,
             description=:description, image_url=:image_url, is_active=:is_active WHERE id=:id'
        );
        $stmt->execute([
            'name'           => $data['name'],
            'category'       => $data['category'] ?? null,
            'price_snapshot' => $data['price_snapshot'],
            'description'    => $data['description'] ?? null,
            'image_url'      => $data['image_url'] ?? null,
            'is_active'      => $data['is_active'] ?? 1,
            'id'             => $id,
        ]);
    }

    public function delete(int $id): void
    {
        $this->db->prepare('DELETE FROM products WHERE id = ?')->execute([$id]);
    }

    public function getByIds(array $ids): array
    {
        if (empty($ids)) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
        $stmt->execute($ids);
        return $stmt->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);
    }
}
