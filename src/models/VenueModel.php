<?php

namespace Models;

use Core\Database;
use PDO;

class VenueModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(bool $activeOnly = false): array
    {
        $sql = 'SELECT * FROM venues';
        if ($activeOnly) {
            $sql .= ' WHERE is_active = 1';
        }
        $sql .= ' ORDER BY name ASC';
        return $this->db->query($sql)->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM venues WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM venues WHERE slug = ? LIMIT 1');
        $stmt->execute([$slug]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO venues (name, campus_name, slug, description, location, phone, opens_at, closes_at, is_active)
             VALUES (:name, :campus_name, :slug, :description, :location, :phone, :opens_at, :closes_at, :is_active)'
        );
        $stmt->execute([
            'name'        => $data['name'],
            'campus_name' => $data['campus_name'],
            'slug'        => $data['slug'],
            'description' => $data['description'] ?? null,
            'location'    => $data['location'] ?? null,
            'phone'       => $data['phone'] ?? null,
            'opens_at'    => $data['opens_at'] ?? null,
            'closes_at'   => $data['closes_at'] ?? null,
            'is_active'   => $data['is_active'] ?? 1,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare(
            'UPDATE venues SET name=:name, campus_name=:campus_name, slug=:slug,
             description=:description, location=:location, phone=:phone,
             opens_at=:opens_at, closes_at=:closes_at, is_active=:is_active
             WHERE id=:id'
        );
        $stmt->execute([
            'name'        => $data['name'],
            'campus_name' => $data['campus_name'],
            'slug'        => $data['slug'],
            'description' => $data['description'] ?? null,
            'location'    => $data['location'] ?? null,
            'phone'       => $data['phone'] ?? null,
            'opens_at'    => $data['opens_at'] ?? null,
            'closes_at'   => $data['closes_at'] ?? null,
            'is_active'   => $data['is_active'] ?? 1,
            'id'          => $id,
        ]);
    }

    public function countAll(): int
    {
        return (int)$this->db->query('SELECT COUNT(*) FROM venues')->fetchColumn();
    }

    public function generateSlug(string $name): string
    {
        $slug = mb_strtolower($name, 'UTF-8');
        $trMap = ['ç'=>'c','ğ'=>'g','ı'=>'i','ö'=>'o','ş'=>'s','ü'=>'u',
                  'Ç'=>'c','Ğ'=>'g','İ'=>'i','Ö'=>'o','Ş'=>'s','Ü'=>'u'];
        $slug = strtr($slug, $trMap);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }
}
