-- ============================================================
-- Migration: cashier rolünü venue-admin ile birleştir
-- Çalıştırmadan önce yedeğini al!
-- ============================================================

USE askida_kampus;

-- 1. cashier rolündeki kullanıcıları venue-admin yap
UPDATE users SET role = 'venue-admin' WHERE role = 'cashier';

-- 2. ENUM'dan 'cashier' seçeneğini kaldır
ALTER TABLE users
  MODIFY COLUMN role ENUM('super-admin','university-admin','venue-admin','student','donor') NOT NULL;
