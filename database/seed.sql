-- Encoding: UTF-8
USE askida_kampus;

-- Önce bağımlı tablolar temizlenir
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE audit_logs;
TRUNCATE TABLE reservation_items;
TRUNCATE TABLE reservations;
TRUNCATE TABLE donation_items;
TRUNCATE TABLE donations;
TRUNCATE TABLE suspended_stocks;
TRUNCATE TABLE products;
TRUNCATE TABLE venue_user;
TRUNCATE TABLE venues;
TRUNCATE TABLE users;
SET FOREIGN_KEY_CHECKS = 1;

-- Test kullanıcıları
INSERT INTO users (name, email, password, role, university_verified, daily_limit, student_number, is_active) VALUES
('Süper Admin', 'admin@askidakampus.com', '$2y$10$DdE/TfpFC6boWCwdfXAGBOBdBAuIFjd2MAmE0Hvs5HQo6ixuTHtaO', 'super-admin', 1, 3, NULL, 1),
('Üniversite Admin', 'universite@askidakampus.com', '$2y$10$kj04Zj1JFDptdFKaXxX6qe4kbI57vE7Sorqy/oC4CxGP5YVuK1uV.', 'university-admin', 1, 3, NULL, 1),
('İşletme Yöneticisi', 'admin.merkez@askidakampus.com', '$2y$10$fbmi9LdDKAleUlCwKPeyVuCWjqQRDqgus5Ay2eDTSzJtWrJUvWpYa', 'venue-admin', 1, 3, NULL, 1),
('Ali Yılmaz', 'ogrenci@askidakampus.com', '$2y$10$WciiorIMIOV3O.mIPxX9aO9.sWxzPw5Ab7PaES1iM3CykSQCy60K6', 'student', 1, 3, '20210001', 1),
('Ayşe Kaya', 'bagisci@askidakampus.com', '$2y$10$yvJ.wkPXtgD7D2yjIGM45evNzM.D6qzVtZ5.0e7YtLSEuRR13mHmy', 'donor', 1, 3, NULL, 1);

-- İşletmeler
INSERT INTO venues (name, campus_name, slug, description, location, phone, opens_at, closes_at, is_active) VALUES
('Merkez Kafeterya', 'Esenboğa Kampüsü', 'merkez-kafeterya', 'Merkez kafeterya ve yemekhane', 'A Blok Zemin Kat', '0312 000 00 01', '08:00', '20:00', 1),
('Mühendislik Kantini', 'Esenboğa Kampüsü', 'muhendislik-kantini', 'Mühendislik Fakültesi kantini', 'B Blok Giriş', '0312 000 00 02', '08:30', '17:30', 1),
('Kütüphane Büfesi', 'Keçiören Kampüsü', 'kutuphane-bufesi', 'Kütüphane içi büfe', 'Kütüphane Giriş', '0312 000 00 03', '09:00', '18:00', 1);

-- Atamalar
INSERT INTO venue_user (user_id, venue_id) VALUES (3, 1);

-- Ürünler
INSERT INTO products (venue_id, name, category, price_snapshot, description, is_active) VALUES
(1, 'Çay', 'İçecek', 5.00, '1 bardak çay', 1),
(1, 'Türk Kahvesi', 'İçecek', 15.00, 'Sade veya şekerli', 1),
(1, 'Sandviç', 'Yiyecek', 30.00, 'Karışık sandviç', 1),
(1, 'Tost', 'Yiyecek', 25.00, 'Kaşarlı tost', 1),
(1, 'Simit', 'Yiyecek', 8.00, 'Günlük taze simit', 1),
(1, 'Su (0.5L)', 'İçecek', 5.00, '0.5 litre pet su', 1),
(2, 'Nescafe', 'İçecek', 20.00, 'Sıcak nescafe', 1),
(2, 'Börek', 'Yiyecek', 20.00, 'Peynirli börek', 1),
(2, 'Poğaça', 'Yiyecek', 12.00, 'Zeytinli poğaça', 1),
(3, 'Çay', 'İçecek', 5.00, '1 bardak çay', 1),
(3, 'Bisküvi', 'Atıştırmalık', 10.00, 'Paket bisküvi', 1);

-- Demo stok
INSERT INTO suspended_stocks (venue_id, product_id, available_quantity, reserved_quantity) VALUES
(1, 1, 20, 0),
(1, 3, 10, 0),
(1, 5, 15, 0),
(2, 7, 8, 0),
(2, 8, 5, 0);
