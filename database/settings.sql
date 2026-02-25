-- Sistem ayarları tablosu
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    description VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_key (setting_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Varsayılan SMTP ayarları
INSERT INTO settings (setting_key, setting_value, description) VALUES
('mail_host', '', 'SMTP sunucu adresi'),
('mail_port', '587', 'SMTP port numarası'),
('mail_username', '', 'SMTP kullanıcı adı'),
('mail_password', '', 'SMTP şifresi'),
('mail_encryption', 'tls', 'Şifreleme türü (tls/ssl)'),
('mail_from_address', 'noreply@aybu.edu.tr', 'Gönderen email adresi'),
('mail_from_name', 'AYBÜ Askıda Kampüs', 'Gönderen adı')
ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value);
