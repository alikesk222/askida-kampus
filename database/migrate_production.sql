-- Production migration: eksik tablolar ve kolonlar
USE askida_kampus;

-- 1. settings tablosu
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    description VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_key (setting_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Varsayılan ayarlar
INSERT INTO settings (setting_key, setting_value, description) VALUES
('student_weekly_limit', '5', 'Öğrenci haftalık maksimum rezervasyon ürün sayısı'),
('mail_host', '', 'SMTP sunucu adresi'),
('mail_port', '587', 'SMTP port numarası'),
('mail_username', '', 'SMTP kullanıcı adı'),
('mail_password', '', 'SMTP şifresi'),
('mail_encryption', 'tls', 'Şifreleme türü'),
('mail_from_address', 'noreply@aybu.edu.tr', 'Gönderen email adresi'),
('mail_from_name', 'AYBÜ Askıda Kampüs', 'Gönderen adı')
ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value);

-- 3. users tablosuna weekly_limit kolonu (yoksa ekle)
SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = 'askida_kampus'
      AND TABLE_NAME   = 'users'
      AND COLUMN_NAME  = 'weekly_limit'
);

SET @sql = IF(@col_exists = 0,
    'ALTER TABLE users ADD COLUMN weekly_limit TINYINT UNSIGNED NULL DEFAULT NULL AFTER daily_limit',
    'SELECT 1'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 4. users tablosuna email_verify kolonları (yoksa ekle)
SET @col_ev = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = 'askida_kampus'
      AND TABLE_NAME   = 'users'
      AND COLUMN_NAME  = 'email_verify_token'
);
SET @sql_ev = IF(@col_ev = 0,
    'ALTER TABLE users ADD COLUMN email_verify_token CHAR(6) NULL AFTER phone, ADD COLUMN email_verify_expires DATETIME NULL AFTER email_verify_token',
    'SELECT 1'
);
PREPARE stmt2 FROM @sql_ev;
EXECUTE stmt2;
DEALLOCATE PREPARE stmt2;

-- Mevcut öğrencileri doğrulanmış say (admin tarafından oluşturulmuş)
UPDATE users SET university_verified = 1 WHERE role = 'student' AND university_verified = 0;

-- 5. faq_items tablosu
CREATE TABLE IF NOT EXISTS faq_items (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category    VARCHAR(100) NOT NULL DEFAULT '',
    question_tr TEXT NOT NULL,
    answer_tr   TEXT NOT NULL,
    question_en TEXT NULL,
    answer_en   TEXT NULL,
    sort_order  TINYINT UNSIGNED NOT NULL DEFAULT 0,
    is_active   TINYINT(1) NOT NULL DEFAULT 1,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_active   (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
