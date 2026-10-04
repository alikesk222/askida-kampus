<?php

namespace Models;

use Core\Database;

class StudentDocumentModel
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create(int $studentId, string $filePath, string $fileName): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO student_documents (student_id, file_path, file_name) VALUES (?, ?, ?)'
        );
        $stmt->execute([$studentId, $filePath, $fileName]);
        return (int) $this->db->lastInsertId();
    }

    public function getByStudent(int $studentId): array
    {
        $stmt = $this->db->prepare(
            'SELECT d.*, u.name AS reviewer_name
             FROM student_documents d
             LEFT JOIN users u ON u.id = d.reviewed_by
             WHERE d.student_id = ?
             ORDER BY d.created_at DESC'
        );
        $stmt->execute([$studentId]);
        return $stmt->fetchAll();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare(
            'SELECT d.*, u.name AS student_name, u.email AS student_email,
                    r.name AS reviewer_name
             FROM student_documents d
             JOIN users u ON u.id = d.student_id
             LEFT JOIN users r ON r.id = d.reviewed_by
             WHERE d.id = ?'
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getAllPending(): array
    {
        $stmt = $this->db->query(
            'SELECT d.*, u.name AS student_name, u.email AS student_email
             FROM student_documents d
             JOIN users u ON u.id = d.student_id
             WHERE d.status = "pending"
             ORDER BY d.created_at ASC'
        );
        return $stmt->fetchAll();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query(
            'SELECT d.*, u.name AS student_name, u.email AS student_email,
                    r.name AS reviewer_name
             FROM student_documents d
             JOIN users u ON u.id = d.student_id
             LEFT JOIN users r ON r.id = d.reviewed_by
             ORDER BY d.created_at DESC'
        );
        return $stmt->fetchAll();
    }

    public function approve(int $id, int $reviewerId): void
    {
        $this->db->prepare(
            'UPDATE student_documents
             SET status = "approved", reviewed_by = ?, reviewed_at = NOW(), rejection_reason = NULL
             WHERE id = ?'
        )->execute([$reviewerId, $id]);
    }

    public function reject(int $id, int $reviewerId, string $reason): void
    {
        $this->db->prepare(
            'UPDATE student_documents
             SET status = "rejected", reviewed_by = ?, reviewed_at = NOW(), rejection_reason = ?
             WHERE id = ?'
        )->execute([$reviewerId, $reason, $id]);
    }

    public function markBonusApplied(int $id): void
    {
        $this->db->prepare(
            'UPDATE student_documents SET bonus_applied = 1 WHERE id = ?'
        )->execute([$id]);
    }

    public function countPending(): int
    {
        return (int) $this->db->query(
            'SELECT COUNT(*) FROM student_documents WHERE status = "pending"'
        )->fetchColumn();
    }
}
