<?php

namespace Models;

use Core\Database;

class FaqModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM faq_items ORDER BY category, sort_order, id");
        return $stmt->fetchAll();
    }

    public function getAllActive(): array
    {
        $stmt = $this->db->query("SELECT * FROM faq_items WHERE is_active=1 ORDER BY category, sort_order, id");
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM faq_items WHERE id=?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO faq_items (category, question_tr, answer_tr, question_en, answer_en, sort_order, is_active)
            VALUES (:category, :question_tr, :answer_tr, :question_en, :answer_en, :sort_order, :is_active)
        ");
        $stmt->execute([
            'category'    => $data['category'],
            'question_tr' => $data['question_tr'],
            'answer_tr'   => $data['answer_tr'],
            'question_en' => $data['question_en'],
            'answer_en'   => $data['answer_en'],
            'sort_order'  => (int) ($data['sort_order'] ?? 0),
            'is_active'   => (int) ($data['is_active'] ?? 1),
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare("
            UPDATE faq_items SET
                category    = :category,
                question_tr = :question_tr,
                answer_tr   = :answer_tr,
                question_en = :question_en,
                answer_en   = :answer_en,
                sort_order  = :sort_order,
                is_active   = :is_active
            WHERE id = :id
        ");
        $stmt->execute([
            'category'    => $data['category'],
            'question_tr' => $data['question_tr'],
            'answer_tr'   => $data['answer_tr'],
            'question_en' => $data['question_en'],
            'answer_en'   => $data['answer_en'],
            'sort_order'  => (int) ($data['sort_order'] ?? 0),
            'is_active'   => (int) ($data['is_active'] ?? 1),
            'id'          => $id,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM faq_items WHERE id=?");
        $stmt->execute([$id]);
    }

    public function toggleActive(int $id): void
    {
        $stmt = $this->db->prepare("UPDATE faq_items SET is_active = 1 - is_active WHERE id=?");
        $stmt->execute([$id]);
    }
}
