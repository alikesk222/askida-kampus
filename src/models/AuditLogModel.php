<?php

namespace Models;

use Core\Database;
use Core\Auth;
use PDO;

class AuditLogModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function log(string $action, ?string $modelType = null, ?int $modelId = null,
                        ?array $oldValues = null, ?array $newValues = null): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO audit_logs (user_id, action, model_type, model_id, old_values, new_values, ip_address)
             VALUES (:user_id, :action, :model_type, :model_id, :old_values, :new_values, :ip_address)'
        );
        $stmt->execute([
            'user_id'    => Auth::id(),
            'action'     => $action,
            'model_type' => $modelType,
            'model_id'   => $modelId,
            'old_values' => $oldValues ? json_encode($oldValues, JSON_UNESCAPED_UNICODE) : null,
            'new_values' => $newValues ? json_encode($newValues, JSON_UNESCAPED_UNICODE) : null,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
        ]);
    }

    public function countSince(string $action, int $minutes, ?string $ip = null, ?int $userId = null, ?string $emailHash = null): int
    {
        $minutes = max(1, min($minutes, 1440));
        $sql = 'SELECT COUNT(*) FROM audit_logs WHERE action = ? AND created_at > DATE_SUB(NOW(), INTERVAL ' . $minutes . ' MINUTE)';
        $params = [$action];
        if ($ip !== null) {
            $sql .= ' AND ip_address = ?';
            $params[] = $ip;
        }
        if ($userId !== null) {
            $sql .= ' AND user_id = ?';
            $params[] = $userId;
        }
        if ($emailHash !== null) {
            $sql .= " AND JSON_UNQUOTE(JSON_EXTRACT(new_values, '$.email_hash')) = ?";
            $params[] = $emailHash;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public function getRecent(int $limit = 50): array
    {
        $stmt = $this->db->prepare(
            'SELECT al.*, u.name AS user_name FROM audit_logs al
             LEFT JOIN users u ON u.id = al.user_id
             ORDER BY al.created_at DESC LIMIT ?'
        );
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}
