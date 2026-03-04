CREATE DATABASE IF NOT EXISTS askida_kampus
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE askida_kampus;

-- KULLANICILAR
CREATE TABLE IF NOT EXISTS users (
    id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name                VARCHAR(255) NOT NULL,
    email               VARCHAR(255) NOT NULL UNIQUE,
    password            VARCHAR(255) NOT NULL,
    role                ENUM('super-admin','university-admin','venue-admin',
                             'student','donor') NOT NULL,
    university_verified TINYINT(1) NOT NULL DEFAULT 0,
    daily_limit         TINYINT UNSIGNED NOT NULL DEFAULT 3,
    student_number      VARCHAR(50) NULL UNIQUE,
    phone               VARCHAR(20) NULL,
    is_active           TINYINT(1) NOT NULL DEFAULT 1,
    created_at          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                          ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- İŞLETMELER
CREATE TABLE IF NOT EXISTS venues (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(255) NOT NULL,
    campus_name VARCHAR(255) NOT NULL,
    slug        VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    location    VARCHAR(255) NULL,
    phone       VARCHAR(20) NULL,
    is_active   TINYINT(1) NOT NULL DEFAULT 1,
    opens_at    TIME NULL,
    closes_at   TIME NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                  ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- KULLANICI ↔ İŞLETME
CREATE TABLE IF NOT EXISTS venue_user (
    user_id  INT UNSIGNED NOT NULL,
    venue_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (user_id, venue_id),
    FOREIGN KEY (user_id)  REFERENCES users(id)  ON DELETE CASCADE,
    FOREIGN KEY (venue_id) REFERENCES venues(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ÜRÜNLER
CREATE TABLE IF NOT EXISTS products (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    venue_id       INT UNSIGNED NOT NULL,
    name           VARCHAR(255) NOT NULL,
    category       VARCHAR(100) NULL,
    price_snapshot DECIMAL(10,2) NOT NULL,
    description    TEXT NULL,
    is_active      TINYINT(1) NOT NULL DEFAULT 1,
    created_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                     ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (venue_id) REFERENCES venues(id) ON DELETE CASCADE,
    INDEX idx_venue_active (venue_id, is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ASKIDA STOK
CREATE TABLE IF NOT EXISTS suspended_stocks (
    id                 INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    venue_id           INT UNSIGNED NOT NULL,
    product_id         INT UNSIGNED NOT NULL,
    available_quantity INT UNSIGNED NOT NULL DEFAULT 0,
    reserved_quantity  INT UNSIGNED NOT NULL DEFAULT 0,
    updated_at         DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                         ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_venue_product (venue_id, product_id),
    FOREIGN KEY (venue_id)   REFERENCES venues(id)   ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- BAĞIŞLAR
CREATE TABLE IF NOT EXISTS donations (
    id                INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    donor_id          INT UNSIGNED NOT NULL,
    venue_id          INT UNSIGNED NOT NULL,
    total_amount      DECIMAL(10,2) NOT NULL,
    payment_method    ENUM('iban','pos') NOT NULL DEFAULT 'iban',
    status            ENUM('waiting_approval','paid','failed')
                        NOT NULL DEFAULT 'waiting_approval',
    payment_reference VARCHAR(255) NULL,
    notes             TEXT NULL,
    approved_by       INT UNSIGNED NULL,
    approved_at       DATETIME NULL,
    created_at        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                        ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (donor_id)    REFERENCES users(id)  ON DELETE CASCADE,
    FOREIGN KEY (venue_id)    REFERENCES venues(id) ON DELETE CASCADE,
    FOREIGN KEY (approved_by) REFERENCES users(id)  ON DELETE SET NULL,
    INDEX idx_status   (status),
    INDEX idx_donor_id (donor_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- BAĞIŞ KALEMLERİ
CREATE TABLE IF NOT EXISTS donation_items (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    donation_id    INT UNSIGNED NOT NULL,
    product_id     INT UNSIGNED NOT NULL,
    quantity       INT UNSIGNED NOT NULL,
    price_snapshot DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (donation_id) REFERENCES donations(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id)  REFERENCES products(id)  ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- REZERVASYONLAR
CREATE TABLE IF NOT EXISTS reservations (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id INT UNSIGNED NOT NULL,
    venue_id   INT UNSIGNED NOT NULL,
    status     ENUM('reserved','claimed','expired','cancelled')
                 NOT NULL DEFAULT 'reserved',
    qr_token   VARCHAR(512) NOT NULL UNIQUE,
    claim_code CHAR(8)      NOT NULL UNIQUE,
    expires_at DATETIME NOT NULL,
    claimed_at DATETIME NULL,
    claimed_by INT UNSIGNED NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                 ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id)  ON DELETE CASCADE,
    FOREIGN KEY (venue_id)   REFERENCES venues(id) ON DELETE CASCADE,
    FOREIGN KEY (claimed_by) REFERENCES users(id)  ON DELETE SET NULL,
    INDEX idx_student_status (student_id, status),
    INDEX idx_expires_at     (expires_at),
    INDEX idx_claim_code     (claim_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- REZERVASYON KALEMLERİ
CREATE TABLE IF NOT EXISTS reservation_items (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT UNSIGNED NOT NULL,
    product_id     INT UNSIGNED NOT NULL,
    quantity       INT UNSIGNED NOT NULL,
    price_snapshot DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id)     REFERENCES products(id)     ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- DENETİM KAYITLARI
CREATE TABLE IF NOT EXISTS audit_logs (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id    INT UNSIGNED NULL,
    action     VARCHAR(100) NOT NULL,
    model_type VARCHAR(100) NULL,
    model_id   INT UNSIGNED NULL,
    old_values JSON NULL,
    new_values JSON NULL,
    ip_address VARCHAR(45) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_action (action),
    INDEX idx_model  (model_type, model_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
