<?php

namespace Models;

use Core\Database;
use PDO;

class UserModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function getAll(int $page = 1, int $perPage = 20): array
    {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->db->prepare(
            'SELECT id, name, email, role, university_verified, weekly_limit, student_number, phone, is_active, created_at
             FROM users ORDER BY created_at DESC LIMIT ? OFFSET ?'
        );
        $stmt->execute([$perPage, $offset]);
        return $stmt->fetchAll();
    }

    public function countAll(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM users')->fetchColumn();
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO users (name, email, password, role, university_verified, student_number, phone)
             VALUES (:name, :email, :password, :role, :university_verified, :student_number, :phone)'
        );
        $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]),
            'role' => $data['role'],
            'university_verified' => $data['university_verified'] ?? 0,
            'student_number' => $data['student_number'] ?? null,
            'phone' => $data['phone'] ?? null,
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function setWeeklyLimit(int $id, ?int $limit): void
    {
        $this->db->prepare('UPDATE users SET weekly_limit = ? WHERE id = ?')->execute([$limit, $id]);
    }

    public function toggleActive(int $id): void
    {
        $this->db->prepare('UPDATE users SET is_active = NOT is_active WHERE id = ?')->execute([$id]);
    }

    public function countByRole(string $role): int
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM users WHERE role = ?');
        $stmt->execute([$role]);
        return (int) $stmt->fetchColumn();
    }

    public function getVenueUsers(int $venueId): array
    {
        $stmt = $this->db->prepare(
            'SELECT u.id, u.name, u.email, u.role FROM users u
             INNER JOIN venue_user vu ON vu.user_id = u.id
             WHERE vu.venue_id = ?'
        );
        $stmt->execute([$venueId]);
        return $stmt->fetchAll();
    }

    public function assignVenue(int $userId, int $venueId): void
    {
        $stmt = $this->db->prepare(
            'INSERT IGNORE INTO venue_user (user_id, venue_id) VALUES (?, ?)'
        );
        $stmt->execute([$userId, $venueId]);
    }

    public function removeVenueAssignment(int $userId): void
    {
        $stmt = $this->db->prepare('DELETE FROM venue_user WHERE user_id = ?');
        $stmt->execute([$userId]);
    }

    public function getVenueIdForUser(int $userId): ?int
    {
        $stmt = $this->db->prepare('SELECT venue_id FROM venue_user WHERE user_id = ? LIMIT 1');
        $stmt->execute([$userId]);
        $row = $stmt->fetch();
        return $row ? (int) $row['venue_id'] : null;
    }
}
