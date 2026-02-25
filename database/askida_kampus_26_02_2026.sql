-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 25 Şub 2026, 22:27:16
-- Sunucu sürümü: 10.4.28-MariaDB
-- PHP Sürümü: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `askida_kampus`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `model_type` varchar(100) DEFAULT NULL,
  `model_id` int(10) UNSIGNED DEFAULT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `model_type`, `model_id`, `old_values`, `new_values`, `ip_address`, `created_at`) VALUES
(1, 5, 'reservation.create', 'reservation', 1, NULL, '{\"student_id\":5,\"venue_id\":1}', '::1', '2026-02-25 00:49:09'),
(2, 5, 'reservation.create', 'reservation', 2, NULL, '{\"student_id\":5,\"venue_id\":1}', '::1', '2026-02-25 23:23:31');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `donations`
--

CREATE TABLE `donations` (
  `id` int(10) UNSIGNED NOT NULL,
  `donor_id` int(10) UNSIGNED NOT NULL,
  `donor_name` varchar(100) DEFAULT NULL,
  `donor_email` varchar(150) DEFAULT NULL,
  `is_guest` tinyint(1) NOT NULL DEFAULT 0,
  `venue_id` int(10) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` enum('iban','pos') NOT NULL DEFAULT 'iban',
  `status` enum('waiting_approval','paid','failed') NOT NULL DEFAULT 'waiting_approval',
  `payment_reference` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `donation_items`
--

CREATE TABLE `donation_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `donation_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `price_snapshot` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `created_at`) VALUES
(7, 'ogrenci@askidakampus.com', '645e79c20d552b2f9b0914d704948b5fd250a99f8615aa713fbe289574db9f9e', '2026-02-25 21:22:41');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `venue_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `price_snapshot` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`id`, `venue_id`, `name`, `category`, `price_snapshot`, `description`, `image_url`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Çay', 'İçecek', 5.00, '1 bardak çay', NULL, 1, '2026-02-24 15:10:36', '2026-02-24 15:25:46'),
(2, 1, 'Türk Kahvesi', 'İçecek', 15.00, 'Sade veya şekerli', NULL, 1, '2026-02-24 15:10:36', '2026-02-24 15:25:46'),
(3, 1, 'Sandviç', 'Yiyecek', 30.00, 'Karışık sandviç', NULL, 1, '2026-02-24 15:10:36', '2026-02-24 15:25:46'),
(4, 1, 'Tost', 'Yiyecek', 25.00, 'Kaşarlı tost', NULL, 1, '2026-02-24 15:10:36', '2026-02-24 15:25:46'),
(5, 1, 'Simit', 'Yiyecek', 8.00, 'Günlük taze simit', NULL, 1, '2026-02-24 15:10:36', '2026-02-24 15:25:46'),
(6, 1, 'Su (0.5L)', 'İçecek', 5.00, '0.5 litre pet su', NULL, 1, '2026-02-24 15:10:36', '2026-02-24 15:25:46'),
(7, 2, 'Nescafe', 'İçecek', 20.00, 'Sıcak nescafe', NULL, 1, '2026-02-24 15:10:36', '2026-02-24 15:25:46'),
(8, 2, 'Börek', 'Yiyecek', 20.00, 'Peynirli börek', NULL, 1, '2026-02-24 15:10:36', '2026-02-24 15:25:46'),
(9, 2, 'Poğaça', 'Yiyecek', 12.00, 'Zeytinli poğaça', NULL, 1, '2026-02-24 15:10:36', '2026-02-24 15:25:46'),
(10, 3, 'Çay', 'İçecek', 5.00, '1 bardak çay', NULL, 1, '2026-02-24 15:10:36', '2026-02-24 15:25:46'),
(11, 3, 'Bisküvi', 'Atıştırmalık', 10.00, 'Paket bisküvi', NULL, 1, '2026-02-24 15:10:36', '2026-02-24 15:25:46');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `reservations`
--

CREATE TABLE `reservations` (
  `id` int(10) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `venue_id` int(10) UNSIGNED NOT NULL,
  `status` enum('reserved','claimed','expired','cancelled') NOT NULL DEFAULT 'reserved',
  `qr_token` varchar(512) NOT NULL,
  `claim_code` char(8) NOT NULL,
  `expires_at` datetime NOT NULL,
  `claimed_at` datetime DEFAULT NULL,
  `claimed_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `reservations`
--

INSERT INTO `reservations` (`id`, `student_id`, `venue_id`, `status`, `qr_token`, `claim_code`, `expires_at`, `claimed_at`, `claimed_by`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 'reserved', '5e8cab07eb1e7d5c0ee5b193f0e093fe92bc99727275f49914a39767b55500f6', 'SBXWXUQ7', '2026-02-24 23:19:09', NULL, NULL, '2026-02-25 00:49:09', '2026-02-25 00:49:09'),
(2, 5, 1, 'reserved', 'cbe17fea6f0a9762196f40b8433aa3dbc46b6203d022201da38ab7d5d20c27c9', '6J3VKD5N', '2026-02-25 21:53:31', NULL, NULL, '2026-02-25 23:23:31', '2026-02-25 23:23:31');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `reservation_items`
--

CREATE TABLE `reservation_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `reservation_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `price_snapshot` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `reservation_items`
--

INSERT INTO `reservation_items` (`id`, `reservation_id`, `product_id`, `quantity`, `price_snapshot`) VALUES
(1, 1, 1, 1, 5.00),
(2, 2, 5, 1, 8.00);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES
(1, 'email_donation_subject', 'Bağışınız İçin Teşekkür Ederiz - AYBÜ Askıda Kampüs', 'Ba??ş teşekkür emailinin konu başl???', '2026-02-25 21:21:47'),
(2, 'email_donation_greeting', 'Sayın {{donor_name}},', 'Email selamlama metni', '2026-02-25 21:21:47'),
(3, 'email_donation_body', 'Ankara Yıldırım Beyazıt Üniversitesi İktisadi İşletmeler Müdürlüğü olarak, Askıda Kampüs projemize yapmış olduğunuz değerli katkınız için en içten teşekkürlerimizi sunarız.\r\n\r\nGöstermiş olduğunuz bu duyarlılık ve sosyal sorumluluk bilinci, öğrencilerimizin kampüs yaşamına anlamlı bir katkı sağlamaktadır.', 'Email ana içerik metni', '2026-02-25 21:21:47'),
(4, 'email_donation_footer_text', 'Bağışınız onaylandıktan sonra, belirlediğiniz ürünler işletme stoğuna eklenecek ve öğrencilerimiz tarafından rezerve edilebilecektir.\r\n\r\nDestekleriniz için tekrar teşekkür eder, saygılarımızı sunarız.', 'Email alt bilgi metni', '2026-02-25 21:21:47'),
(5, 'email_donation_signature', 'Ankara Yıldırım Beyazıt Üniversitesi\r\nİktisadi işletmeler Müdürlüğü\r\nAskıda Kampüs Projesi', 'Email imza', '2026-02-25 21:21:47');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `suspended_stocks`
--

CREATE TABLE `suspended_stocks` (
  `id` int(10) UNSIGNED NOT NULL,
  `venue_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `available_quantity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `reserved_quantity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `suspended_stocks`
--

INSERT INTO `suspended_stocks` (`id`, `venue_id`, `product_id`, `available_quantity`, `reserved_quantity`, `updated_at`) VALUES
(1, 1, 1, 20, 1, '2026-02-25 00:49:09'),
(2, 1, 3, 10, 0, '2026-02-24 15:10:36'),
(3, 1, 5, 15, 1, '2026-02-25 23:23:31'),
(4, 2, 7, 8, 0, '2026-02-24 15:10:36'),
(5, 2, 8, 5, 0, '2026-02-24 15:10:36');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('super-admin','university-admin','venue-admin','cashier','student','donor') NOT NULL,
  `university_verified` tinyint(1) NOT NULL DEFAULT 0,
  `daily_limit` tinyint(3) UNSIGNED NOT NULL DEFAULT 3,
  `student_number` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `university_verified`, `daily_limit`, `student_number`, `phone`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Süper Admin', 'admin@askidakampus.com', '$2y$10$O1/xY/gNoy/lbjR./gfNaOY2cC1zeJQNk/wTkl8K7Zqc/jymtCEfS', 'super-admin', 1, 3, NULL, NULL, 1, '2026-02-24 15:10:36', '2026-02-24 22:01:35'),
(2, 'Üniversite Admin', 'universite@askidakampus.com', '$2y$10$vAalyIfQCsfi7y.1z9wLpuHYevIrROXEmp959dxtenqCebkhNRLqa', 'university-admin', 1, 3, NULL, NULL, 1, '2026-02-24 15:10:36', '2026-02-24 22:01:35'),
(3, 'İşletme Yöneticisi', 'admin.merkez@askidakampus.com', '$2y$10$/zlLNdExd338cQSTB9raQeQ2.5M64nZqA3U40abdiQrIbMNrcGHQa', 'venue-admin', 1, 3, NULL, NULL, 1, '2026-02-24 15:10:36', '2026-02-24 22:01:36'),
(4, 'Kasa Görevlisi', 'kasiyer.merkez@askidakampus.com', '$2y$10$vKxiYMvHjYmhcaJWt3ohNO8Ax5uW2La.IQhjDwCPvgnzh26wI2f56', 'cashier', 1, 3, NULL, NULL, 1, '2026-02-24 15:10:36', '2026-02-24 22:01:36'),
(5, 'Ali Yılmaz', 'ogrenci@askidakampus.com', '$2y$10$ZGUKD4Bzq3Wflw2ajZxMS.JeXS6j2X8fJpfC/X9z9KL2VG94ezh1q', 'student', 1, 3, '20210001', NULL, 1, '2026-02-24 15:10:36', '2026-02-24 22:01:36'),
(6, 'Ayşe Kaya', 'bagisci@askidakampus.com', '$2y$10$HKquxjI9qg3NG3WRNpiFM.qNMwZPB63en3cJInj.sHZDRf/QGB.Ma', 'donor', 1, 3, NULL, NULL, 1, '2026-02-24 15:10:36', '2026-02-24 22:01:36');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `venues`
--

CREATE TABLE `venues` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `campus_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `opens_at` time DEFAULT NULL,
  `closes_at` time DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `venues`
--

INSERT INTO `venues` (`id`, `name`, `campus_name`, `slug`, `description`, `location`, `phone`, `is_active`, `opens_at`, `closes_at`, `created_at`, `updated_at`) VALUES
(1, 'Merkez Kafeterya', 'Esenboğa Kampüsü', 'merkez-kafeterya', 'Merkez kafeterya ve yemekhane', 'A Blok Zemin Kat', '0312 000 00 01', 1, '08:00:00', '20:00:00', '2026-02-24 15:10:36', '2026-02-24 15:25:46'),
(2, 'Mühendislik Kantini', 'Esenboğa Kampüsü', 'muhendislik-kantini', 'Mühendislik Fakültesi kantini', 'B Blok Giriş', '0312 000 00 02', 1, '08:30:00', '17:30:00', '2026-02-24 15:10:36', '2026-02-24 15:25:46'),
(3, 'Kütüphane Büfesi', 'Keçiören Kampüsü', 'kutuphane-bufesi', 'Kütüphane içi büfe', 'Kütüphane Giriş', '0312 000 00 03', 1, '09:00:00', '18:00:00', '2026-02-24 15:10:36', '2026-02-24 15:25:46');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `venue_user`
--

CREATE TABLE `venue_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `venue_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `venue_user`
--

INSERT INTO `venue_user` (`user_id`, `venue_id`) VALUES
(3, 1),
(4, 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_action` (`action`),
  ADD KEY `idx_model` (`model_type`,`model_id`);

--
-- Tablo için indeksler `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venue_id` (`venue_id`),
  ADD KEY `approved_by` (`approved_by`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_donor_id` (`donor_id`);

--
-- Tablo için indeksler `donation_items`
--
ALTER TABLE `donation_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donation_id` (`donation_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Tablo için indeksler `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_venue_active` (`venue_id`,`is_active`);

--
-- Tablo için indeksler `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `qr_token` (`qr_token`),
  ADD UNIQUE KEY `claim_code` (`claim_code`),
  ADD KEY `venue_id` (`venue_id`),
  ADD KEY `claimed_by` (`claimed_by`),
  ADD KEY `idx_student_status` (`student_id`,`status`),
  ADD KEY `idx_expires_at` (`expires_at`),
  ADD KEY `idx_claim_code` (`claim_code`);

--
-- Tablo için indeksler `reservation_items`
--
ALTER TABLE `reservation_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_id` (`reservation_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Tablo için indeksler `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Tablo için indeksler `suspended_stocks`
--
ALTER TABLE `suspended_stocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_venue_product` (`venue_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `student_number` (`student_number`),
  ADD KEY `idx_role` (`role`);

--
-- Tablo için indeksler `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Tablo için indeksler `venue_user`
--
ALTER TABLE `venue_user`
  ADD PRIMARY KEY (`user_id`,`venue_id`),
  ADD KEY `venue_id` (`venue_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `donation_items`
--
ALTER TABLE `donation_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `reservation_items`
--
ALTER TABLE `reservation_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `suspended_stocks`
--
ALTER TABLE `suspended_stocks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `venues`
--
ALTER TABLE `venues`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Tablo kısıtlamaları `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`donor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `donations_ibfk_2` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `donations_ibfk_3` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Tablo kısıtlamaları `donation_items`
--
ALTER TABLE `donation_items`
  ADD CONSTRAINT `donation_items_ibfk_1` FOREIGN KEY (`donation_id`) REFERENCES `donations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `donation_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`claimed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Tablo kısıtlamaları `reservation_items`
--
ALTER TABLE `reservation_items`
  ADD CONSTRAINT `reservation_items_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservation_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `suspended_stocks`
--
ALTER TABLE `suspended_stocks`
  ADD CONSTRAINT `suspended_stocks_ibfk_1` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `suspended_stocks_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `venue_user`
--
ALTER TABLE `venue_user`
  ADD CONSTRAINT `venue_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `venue_user_ibfk_2` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
