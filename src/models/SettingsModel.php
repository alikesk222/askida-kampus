<?php

namespace Models;

use Core\Database;

class SettingsModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Ayar değerini getir
     */
    public function get(string $key, $default = null)
    {
        $stmt = $this->db->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        $result = $stmt->fetch();
        
        return $result ? $result['setting_value'] : $default;
    }

    /**
     * Ayar değerini kaydet/güncelle
     */
    public function set(string $key, $value, ?string $description = null): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO settings (setting_key, setting_value, description) 
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)
        ");
        $stmt->execute([$key, $value, $description]);
    }

    /**
     * Tüm ayarları getir
     */
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM settings ORDER BY setting_key");
        return $stmt->fetchAll();
    }

    /**
     * Belirli prefix ile başlayan ayarları getir
     */
    public function getByPrefix(string $prefix): array
    {
        $stmt = $this->db->prepare("SELECT * FROM settings WHERE setting_key LIKE ? ORDER BY setting_key");
        $stmt->execute([$prefix . '%']);
        return $stmt->fetchAll();
    }

    /**
     * SMTP ayarlarını getir
     */
    public function getMailSettings(): array
    {
        $settings = $this->getByPrefix('mail_');
        $result = [];
        
        foreach ($settings as $setting) {
            $key = str_replace('mail_', '', $setting['setting_key']);
            $result[$key] = $setting['setting_value'];
        }
        
        return $result;
    }
}
