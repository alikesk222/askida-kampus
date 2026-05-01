-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 30 Nis 2026, 18:20:10
-- Sunucu sürümü: 10.6.21-MariaDB
-- PHP Sürümü: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `rgdvuvbe_askida_kampus`
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
(2, 5, 'reservation.create', 'reservation', 2, NULL, '{\"student_id\":5,\"venue_id\":11}', '::1', '2026-02-26 23:13:39'),
(3, 24, 'reservation.create', 'reservation', 3, NULL, '{\"student_id\":24,\"venue_id\":13}', '::1', '2026-02-26 23:57:33'),
(4, 19, 'reservation.claim', 'reservation', 3, '{\"status\":\"reserved\"}', '{\"status\":\"claimed\",\"cashier_id\":19}', '::1', '2026-02-26 23:58:33'),
(5, 24, 'reservation.create', 'reservation', 4, NULL, '{\"student_id\":24,\"venue_id\":13}', '::1', '2026-02-26 23:59:27'),
(6, 19, 'reservation.claim', 'reservation', 4, '{\"status\":\"reserved\"}', '{\"status\":\"claimed\",\"cashier_id\":19}', '::1', '2026-02-26 23:59:50'),
(7, 24, 'reservation.create', 'reservation', 5, NULL, '{\"student_id\":24,\"venue_id\":13}', '::1', '2026-02-27 13:52:48'),
(8, 19, 'reservation.claim', 'reservation', 5, '{\"status\":\"reserved\"}', '{\"status\":\"claimed\",\"cashier_id\":19}', '::1', '2026-02-27 13:53:12'),
(9, 24, 'reservation.create', 'reservation', 6, NULL, '{\"student_id\":24,\"venue_id\":13}', '::1', '2026-03-04 16:42:17'),
(10, 19, 'reservation.claim', 'reservation', 6, '{\"status\":\"reserved\"}', '{\"status\":\"claimed\",\"cashier_id\":19}', '::1', '2026-03-04 16:43:39'),
(11, 24, 'reservation.create', 'reservation', 7, NULL, '{\"student_id\":24,\"venue_id\":13}', '::1', '2026-03-04 16:47:52'),
(12, 19, 'reservation.claim', 'reservation', 7, '{\"status\":\"reserved\"}', '{\"status\":\"claimed\",\"cashier_id\":19}', '::1', '2026-03-04 16:52:51'),
(13, 26, 'reservation.create', 'reservation', 8, NULL, '{\"student_id\":26,\"venue_id\":13}', '95.183.210.170', '2026-03-24 13:50:46'),
(14, 26, 'reservation.create', 'reservation', 9, NULL, '{\"student_id\":26,\"venue_id\":11}', '46.106.150.1', '2026-03-24 13:56:01'),
(15, 17, 'reservation.claim', 'reservation', 9, '{\"status\":\"reserved\"}', '{\"status\":\"claimed\",\"cashier_id\":17}', '46.106.150.1', '2026-03-24 13:56:21'),
(16, 17, 'donation.approve', 'donation', 1, '{\"status\":\"waiting_approval\"}', '{\"status\":\"paid\",\"approved_by\":17}', '46.106.150.1', '2026-03-24 14:01:39'),
(17, 26, 'reservation.create', 'reservation', 10, NULL, '{\"student_id\":26,\"venue_id\":13}', '176.216.180.230', '2026-03-27 12:15:03'),
(18, 19, 'reservation.claim', 'reservation', 10, '{\"status\":\"reserved\"}', '{\"status\":\"claimed\",\"cashier_id\":19}', '176.216.180.230', '2026-03-27 12:15:31');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `donations`
--

CREATE TABLE `donations` (
  `id` int(10) UNSIGNED NOT NULL,
  `donor_id` int(10) UNSIGNED DEFAULT NULL,
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

--
-- Tablo döküm verisi `donations`
--

INSERT INTO `donations` (`id`, `donor_id`, `donor_name`, `donor_email`, `is_guest`, `venue_id`, `total_amount`, `payment_method`, `status`, `payment_reference`, `notes`, `approved_by`, `approved_at`, `created_at`, `updated_at`) VALUES
(1, NULL, 'ali Kesik', 'ali.kesik76@gmail.com', 1, 11, 188.00, 'iban', 'paid', NULL, '', 17, '2026-03-24 14:01:39', '2026-03-24 13:58:04', '2026-03-24 14:01:39');

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

--
-- Tablo döküm verisi `donation_items`
--

INSERT INTO `donation_items` (`id`, `donation_id`, `product_id`, `quantity`, `price_snapshot`) VALUES
(1, 1, 102, 5, 10.00),
(2, 1, 109, 5, 10.00),
(3, 1, 107, 4, 22.00);

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
(12, 12, 'çay', 'içecek', 10.00, '', NULL, 1, '2026-02-26 23:08:35', '2026-02-26 23:08:35'),
(13, 12, 'kahve', 'içecek', 15.00, '', NULL, 1, '2026-02-26 23:08:43', '2026-02-26 23:08:43'),
(14, 4, 'Çay', 'İçecek', 5.00, '1 bardak çay', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(15, 4, 'Türk Kahvesi', 'İçecek', 15.00, 'Sade veya şekerli', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(16, 4, 'Nescafe', 'İçecek', 20.00, 'Sıcak nescafe', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(17, 4, 'Su (0.5L)', 'İçecek', 5.00, '0.5 litre pet su', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(18, 4, 'Ayran', 'İçecek', 10.00, 'Soğuk ayran', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(19, 4, 'Sandviç', 'Yiyecek', 35.00, 'Karışık sandviç', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(20, 4, 'Tost', 'Yiyecek', 28.00, 'Kaşarlı tost', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(21, 4, 'Simit', 'Yiyecek', 8.00, 'Günlük taze simit', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(22, 4, 'Poğaça', 'Yiyecek', 12.00, 'Zeytinli/peynirli poğaça', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(23, 4, 'Börek', 'Yiyecek', 22.00, 'Peynirli börek', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(24, 4, 'Gözleme', 'Yiyecek', 40.00, 'Peynirli/patatesli gözleme', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(25, 4, 'Bisküvi', 'Atıştırmalık', 10.00, 'Paket bisküvi', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(26, 5, 'Çay', 'İçecek', 5.00, '1 bardak çay', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(27, 5, 'Türk Kahvesi', 'İçecek', 15.00, 'Sade veya şekerli', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(28, 5, 'Nescafe', 'İçecek', 20.00, 'Sıcak nescafe', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(29, 5, 'Su (0.5L)', 'İçecek', 5.00, '0.5 litre pet su', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(30, 5, 'Ayran', 'İçecek', 10.00, 'Soğuk ayran', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(31, 5, 'Sandviç', 'Yiyecek', 35.00, 'Karışık sandviç', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(32, 5, 'Tost', 'Yiyecek', 28.00, 'Kaşarlı tost', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(33, 5, 'Simit', 'Yiyecek', 8.00, 'Günlük taze simit', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(34, 5, 'Poğaça', 'Yiyecek', 12.00, 'Zeytinli/peynirli poğaça', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(35, 5, 'Börek', 'Yiyecek', 22.00, 'Peynirli börek', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(36, 5, 'Gözleme', 'Yiyecek', 40.00, 'Peynirli/patatesli gözleme', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(37, 5, 'Bisküvi', 'Atıştırmalık', 10.00, 'Paket bisküvi', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(38, 6, 'Çay', 'İçecek', 5.00, '1 bardak çay', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(39, 6, 'Türk Kahvesi', 'İçecek', 15.00, 'Sade veya şekerli', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(40, 6, 'Nescafe', 'İçecek', 20.00, 'Sıcak nescafe', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(41, 6, 'Su (0.5L)', 'İçecek', 5.00, '0.5 litre pet su', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(42, 6, 'Ayran', 'İçecek', 10.00, 'Soğuk ayran', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(43, 6, 'Sandviç', 'Yiyecek', 35.00, 'Karışık sandviç', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(44, 6, 'Tost', 'Yiyecek', 28.00, 'Kaşarlı tost', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(45, 6, 'Simit', 'Yiyecek', 8.00, 'Günlük taze simit', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(46, 6, 'Poğaça', 'Yiyecek', 12.00, 'Zeytinli/peynirli poğaça', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(47, 6, 'Börek', 'Yiyecek', 22.00, 'Peynirli börek', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(48, 6, 'Gözleme', 'Yiyecek', 40.00, 'Peynirli/patatesli gözleme', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(49, 6, 'Bisküvi', 'Atıştırmalık', 10.00, 'Paket bisküvi', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(50, 7, 'Çay', 'İçecek', 5.00, '1 bardak çay', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(51, 7, 'Türk Kahvesi', 'İçecek', 15.00, 'Sade veya şekerli', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(52, 7, 'Nescafe', 'İçecek', 20.00, 'Sıcak nescafe', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(53, 7, 'Su (0.5L)', 'İçecek', 5.00, '0.5 litre pet su', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(54, 7, 'Ayran', 'İçecek', 10.00, 'Soğuk ayran', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(55, 7, 'Sandviç', 'Yiyecek', 35.00, 'Karışık sandviç', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(56, 7, 'Tost', 'Yiyecek', 28.00, 'Kaşarlı tost', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(57, 7, 'Simit', 'Yiyecek', 8.00, 'Günlük taze simit', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(58, 7, 'Poğaça', 'Yiyecek', 12.00, 'Zeytinli/peynirli poğaça', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(59, 7, 'Börek', 'Yiyecek', 22.00, 'Peynirli börek', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(60, 7, 'Gözleme', 'Yiyecek', 40.00, 'Peynirli/patatesli gözleme', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(61, 7, 'Bisküvi', 'Atıştırmalık', 10.00, 'Paket bisküvi', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(62, 8, 'Çay', 'İçecek', 5.00, '1 bardak çay', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(63, 8, 'Türk Kahvesi', 'İçecek', 15.00, 'Sade veya şekerli', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(64, 8, 'Nescafe', 'İçecek', 20.00, 'Sıcak nescafe', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(65, 8, 'Su (0.5L)', 'İçecek', 5.00, '0.5 litre pet su', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(66, 8, 'Ayran', 'İçecek', 10.00, 'Soğuk ayran', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(67, 8, 'Sandviç', 'Yiyecek', 35.00, 'Karışık sandviç', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(68, 8, 'Tost', 'Yiyecek', 28.00, 'Kaşarlı tost', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(69, 8, 'Simit', 'Yiyecek', 8.00, 'Günlük taze simit', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(70, 8, 'Poğaça', 'Yiyecek', 12.00, 'Zeytinli/peynirli poğaça', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(71, 8, 'Börek', 'Yiyecek', 22.00, 'Peynirli börek', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(72, 8, 'Gözleme', 'Yiyecek', 40.00, 'Peynirli/patatesli gözleme', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(73, 8, 'Bisküvi', 'Atıştırmalık', 10.00, 'Paket bisküvi', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(74, 9, 'Çay', 'İçecek', 5.00, '1 bardak çay', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(75, 9, 'Türk Kahvesi', 'İçecek', 15.00, 'Sade veya şekerli', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(76, 9, 'Nescafe', 'İçecek', 20.00, 'Sıcak nescafe', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(77, 9, 'Su (0.5L)', 'İçecek', 5.00, '0.5 litre pet su', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(78, 9, 'Ayran', 'İçecek', 10.00, 'Soğuk ayran', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(79, 9, 'Sandviç', 'Yiyecek', 35.00, 'Karışık sandviç', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(80, 9, 'Tost', 'Yiyecek', 28.00, 'Kaşarlı tost', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(81, 9, 'Simit', 'Yiyecek', 8.00, 'Günlük taze simit', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(82, 9, 'Poğaça', 'Yiyecek', 12.00, 'Zeytinli/peynirli poğaça', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(83, 9, 'Börek', 'Yiyecek', 22.00, 'Peynirli börek', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(84, 9, 'Gözleme', 'Yiyecek', 40.00, 'Peynirli/patatesli gözleme', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(85, 9, 'Bisküvi', 'Atıştırmalık', 10.00, 'Paket bisküvi', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(86, 10, 'Çay', 'İçecek', 5.00, '1 bardak çay', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(87, 10, 'Türk Kahvesi', 'İçecek', 15.00, 'Sade veya şekerli', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(88, 10, 'Nescafe', 'İçecek', 20.00, 'Sıcak nescafe', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(89, 10, 'Su (0.5L)', 'İçecek', 5.00, '0.5 litre pet su', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(90, 10, 'Ayran', 'İçecek', 10.00, 'Soğuk ayran', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(91, 10, 'Sandviç', 'Yiyecek', 35.00, 'Karışık sandviç', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(92, 10, 'Tost', 'Yiyecek', 28.00, 'Kaşarlı tost', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(93, 10, 'Simit', 'Yiyecek', 8.00, 'Günlük taze simit', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(94, 10, 'Poğaça', 'Yiyecek', 12.00, 'Zeytinli/peynirli poğaça', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(95, 10, 'Börek', 'Yiyecek', 22.00, 'Peynirli börek', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(96, 10, 'Gözleme', 'Yiyecek', 40.00, 'Peynirli/patatesli gözleme', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(97, 10, 'Bisküvi', 'Atıştırmalık', 10.00, 'Paket bisküvi', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(98, 11, 'Çay', 'İçecek', 5.00, '1 bardak çay', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(99, 11, 'Türk Kahvesi', 'İçecek', 15.00, 'Sade veya şekerli', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(100, 11, 'Nescafe', 'İçecek', 20.00, 'Sıcak nescafe', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(101, 11, 'Su (0.5L)', 'İçecek', 5.00, '0.5 litre pet su', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(102, 11, 'Ayran', 'İçecek', 10.00, 'Soğuk ayran', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(103, 11, 'Sandviç', 'Yiyecek', 35.00, 'Karışık sandviç', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(104, 11, 'Tost', 'Yiyecek', 28.00, 'Kaşarlı tost', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(105, 11, 'Simit', 'Yiyecek', 8.00, 'Günlük taze simit', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(106, 11, 'Poğaça', 'Yiyecek', 12.00, 'Zeytinli/peynirli poğaça', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(107, 11, 'Börek', 'Yiyecek', 22.00, 'Peynirli börek', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(108, 11, 'Gözleme', 'Yiyecek', 40.00, 'Peynirli/patatesli gözleme', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(109, 11, 'Bisküvi', 'Atıştırmalık', 10.00, 'Paket bisküvi', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(110, 13, 'Çay', 'İçecek', 5.00, '1 bardak çay', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(111, 13, 'Ayran', 'İçecek', 10.00, 'Soğuk ayran', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(112, 13, 'Su (0.5L)', 'İçecek', 5.00, '0.5 litre pet su', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(113, 13, 'Günlük Yemek', 'Ana Yemek', 80.00, 'Günlük tabldot (çorba+ana yemek+ekmek)', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(114, 13, 'Çorba', 'Yiyecek', 25.00, 'Günlük çorba', NULL, 1, '2026-02-26 23:12:30', '2026-02-26 23:12:30'),
(115, 13, 'Pilav', 'Yiyecek', 20.00, 'Yanında pilav', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(116, 13, 'Salata', 'Yiyecek', 20.00, 'Mevsim salatası', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(117, 13, 'Sandviç', 'Yiyecek', 35.00, 'Karışık sandviç', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(118, 13, 'Tost', 'Yiyecek', 28.00, 'Kaşarlı tost', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(119, 13, 'Simit', 'Yiyecek', 8.00, 'Günlük taze simit', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(120, 13, 'Börek', 'Yiyecek', 22.00, 'Peynirli börek', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(121, 13, 'Meyve Suyu', 'İçecek', 15.00, 'Kutu meyve suyu', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(122, 14, 'Çay', 'İçecek', 5.00, '1 bardak çay', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(123, 14, 'Türk Kahvesi', 'İçecek', 15.00, 'Sade veya şekerli', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(124, 14, 'Nescafe', 'İçecek', 20.00, 'Sıcak nescafe', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(125, 14, 'Su (0.5L)', 'İçecek', 5.00, '0.5 litre pet su', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(126, 14, 'Ayran', 'İçecek', 10.00, 'Soğuk ayran', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(127, 14, 'Sandviç', 'Yiyecek', 35.00, 'Karışık sandviç', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(128, 14, 'Tost', 'Yiyecek', 28.00, 'Kaşarlı tost', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(129, 14, 'Simit', 'Yiyecek', 8.00, 'Günlük taze simit', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(130, 14, 'Poğaça', 'Yiyecek', 12.00, 'Zeytinli/peynirli poğaça', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(131, 14, 'Börek', 'Yiyecek', 22.00, 'Peynirli börek', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(132, 14, 'Gözleme', 'Yiyecek', 40.00, 'Peynirli/patatesli gözleme', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(133, 14, 'Bisküvi', 'Atıştırmalık', 10.00, 'Paket bisküvi', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(134, 15, 'Çay', 'İçecek', 5.00, '1 bardak çay', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(135, 15, 'Türk Kahvesi', 'İçecek', 15.00, 'Sade veya şekerli', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(136, 15, 'Nescafe', 'İçecek', 20.00, 'Sıcak nescafe', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(137, 15, 'Su (0.5L)', 'İçecek', 5.00, '0.5 litre pet su', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(138, 15, 'Ayran', 'İçecek', 10.00, 'Soğuk ayran', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(139, 15, 'Sandviç', 'Yiyecek', 35.00, 'Karışık sandviç', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(140, 15, 'Tost', 'Yiyecek', 28.00, 'Kaşarlı tost', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(141, 15, 'Simit', 'Yiyecek', 8.00, 'Günlük taze simit', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(142, 15, 'Poğaça', 'Yiyecek', 12.00, 'Zeytinli/peynirli poğaça', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(143, 15, 'Börek', 'Yiyecek', 22.00, 'Peynirli börek', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(144, 15, 'Gözleme', 'Yiyecek', 40.00, 'Peynirli/patatesli gözleme', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(145, 15, 'Bisküvi', 'Atıştırmalık', 10.00, 'Paket bisküvi', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(146, 16, 'Çay', 'İçecek', 5.00, '1 bardak çay', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(147, 16, 'Türk Kahvesi', 'İçecek', 15.00, 'Sade veya şekerli', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(148, 16, 'Nescafe', 'İçecek', 20.00, 'Sıcak nescafe', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(149, 16, 'Su (0.5L)', 'İçecek', 5.00, '0.5 litre pet su', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(150, 16, 'Ayran', 'İçecek', 10.00, 'Soğuk ayran', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(151, 16, 'Sandviç', 'Yiyecek', 35.00, 'Karışık sandviç', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(152, 16, 'Tost', 'Yiyecek', 28.00, 'Kaşarlı tost', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(153, 16, 'Simit', 'Yiyecek', 8.00, 'Günlük taze simit', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(154, 16, 'Poğaça', 'Yiyecek', 12.00, 'Zeytinli/peynirli poğaça', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(155, 16, 'Börek', 'Yiyecek', 22.00, 'Peynirli börek', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(156, 16, 'Gözleme', 'Yiyecek', 40.00, 'Peynirli/patatesli gözleme', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31'),
(157, 16, 'Bisküvi', 'Atıştırmalık', 10.00, 'Paket bisküvi', NULL, 1, '2026-02-26 23:12:31', '2026-02-26 23:12:31');

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
(2, 5, 11, 'reserved', 'aab2374201593de8cfccdbc9b19e5987ea78fec40539b08ee4860213e43e43ac', 'YV35LAPR', '2026-02-26 21:43:39', NULL, NULL, '2026-02-26 23:13:39', '2026-02-26 23:13:39'),
(3, 24, 13, 'claimed', '76208b7ee4790e4da73b6a0a2111c91849fe767ae1eb7aab0d9be76f30cda4ea', 'UMV23QZN', '2026-02-26 22:27:33', '2026-02-26 23:58:33', 19, '2026-02-26 23:57:33', '2026-02-26 23:58:33'),
(4, 24, 13, 'claimed', '52623aad85c484a88a7f49a5ac4ad91b3cbc4ee3bb00d2325f0b22c4499a7bc7', 'JHMWF5ZX', '2026-02-26 22:29:27', '2026-02-26 23:59:50', 19, '2026-02-26 23:59:27', '2026-02-26 23:59:50'),
(5, 24, 13, 'claimed', 'b3d85d7d6131c8faa1bbf58af9eee37695ddd582758024baf438952e19448f80', 'R6X2T8IN', '2026-02-27 12:22:48', '2026-02-27 13:53:12', 19, '2026-02-27 13:52:48', '2026-02-27 13:53:12'),
(6, 24, 13, 'claimed', '3c0602900bf54b4f43efad4c9cca062ea4ed3cadd06ea0663d31cc1bad3a3bfd', 'TH4R7GVY', '2026-03-04 15:12:17', '2026-03-04 16:43:39', 19, '2026-03-04 16:42:17', '2026-03-04 16:43:39'),
(7, 24, 13, 'claimed', 'a2e8004152a8922bc8927fb0219c4aef6a4beacae2cd0cfbdffb6f71d02dec68', 'B8WQUAZB', '2026-03-04 15:17:52', '2026-03-04 16:52:51', 19, '2026-03-04 16:47:52', '2026-03-04 16:52:51'),
(8, 26, 13, 'reserved', '6642f95ded3c5214387cd30cf97aec48409481f8cde0197d9f056b7a793fc2fb', 'HBF75Y23', '2026-03-24 11:20:46', NULL, NULL, '2026-03-24 13:50:46', '2026-03-24 13:50:46'),
(9, 26, 11, 'claimed', '03c46bc4ac269477e92c6e1e2bde7a33d3cc60d6f525e210affdd8615b4c06a7', 'EE9V5NRW', '2026-03-24 11:26:01', '2026-03-24 13:56:21', 17, '2026-03-24 13:56:01', '2026-03-24 13:56:21'),
(10, 26, 13, 'claimed', 'bf5e0d85725a2c6df54b88555b52c739accb9ac6792032bd4a7a85f53a277e97', 'V7U7AKZU', '2026-03-27 09:45:03', '2026-03-27 12:15:31', 19, '2026-03-27 12:15:03', '2026-03-27 12:15:31');

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
(2, 2, 98, 2, 5.00),
(3, 2, 108, 1, 40.00),
(4, 3, 110, 2, 5.00),
(5, 3, 114, 2, 25.00),
(6, 4, 120, 4, 22.00),
(7, 5, 120, 1, 22.00),
(8, 5, 110, 1, 5.00),
(9, 6, 111, 2, 10.00),
(10, 7, 120, 1, 22.00),
(11, 7, 110, 2, 5.00),
(12, 8, 120, 1, 22.00),
(13, 8, 110, 2, 5.00),
(14, 9, 109, 2, 10.00),
(15, 9, 107, 1, 22.00),
(16, 10, 120, 1, 22.00),
(17, 10, 110, 1, 5.00);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES
(1, 'mail_host', '', 'SMTP sunucu adresi', '2026-03-04 13:32:13'),
(2, 'mail_port', '587', 'SMTP port numarası', '2026-03-04 13:32:13'),
(3, 'mail_username', '', 'SMTP kullanıcı adı', '2026-03-04 13:32:13'),
(4, 'mail_password', '', 'SMTP şifresi', '2026-03-04 13:32:13'),
(5, 'mail_encryption', 'tls', 'Şifreleme türü (tls/ssl)', '2026-03-04 13:32:13'),
(6, 'mail_from_address', 'noreply@aybu.edu.tr', 'Gönderen email adresi', '2026-03-04 13:32:13'),
(7, 'mail_from_name', 'AYBÜ Askıda Kampüs', 'Gönderen adı', '2026-03-04 13:32:13'),
(8, 'email_donation_subject', 'Bağışınız için teşekkürler!', 'Bağış teşekkür emaili konusu', '2026-03-04 13:32:13'),
(9, 'email_donation_greeting', 'Sayın Bağışçımız,', 'Email selamlama', '2026-03-04 13:32:13'),
(10, 'email_donation_body', 'Değerli bağışınız için teşekkür ederiz. Katkınız kampüs öğrencileri için büyük önem taşımaktadır.', 'Email ana içerik', '2026-03-04 13:32:13'),
(11, 'email_donation_footer_text', 'AYBU Askıda Kampüs Sistemi', 'Email alt bilgi', '2026-03-04 13:32:13'),
(12, 'email_donation_signature', 'İktisadi İşletmeler Müdürlüğü', 'Email imza', '2026-03-04 13:32:13');

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
(6, 4, 14, 19, 0, '2026-02-26 23:12:30'),
(7, 4, 15, 28, 0, '2026-02-26 23:12:30'),
(8, 4, 16, 14, 0, '2026-02-26 23:12:30'),
(9, 4, 17, 13, 0, '2026-02-26 23:12:30'),
(10, 4, 18, 29, 0, '2026-02-26 23:12:30'),
(11, 4, 19, 13, 0, '2026-02-26 23:12:30'),
(12, 4, 20, 15, 0, '2026-02-26 23:12:30'),
(13, 4, 21, 30, 0, '2026-02-26 23:12:30'),
(14, 4, 22, 23, 0, '2026-02-26 23:12:30'),
(15, 4, 23, 13, 0, '2026-02-26 23:12:30'),
(16, 4, 24, 20, 0, '2026-02-26 23:12:30'),
(17, 4, 25, 13, 0, '2026-02-26 23:12:30'),
(18, 5, 26, 29, 0, '2026-02-26 23:12:30'),
(19, 5, 27, 13, 0, '2026-02-26 23:12:30'),
(20, 5, 28, 16, 0, '2026-02-26 23:12:30'),
(21, 5, 29, 24, 0, '2026-02-26 23:12:30'),
(22, 5, 30, 11, 0, '2026-02-26 23:12:30'),
(23, 5, 31, 22, 0, '2026-02-26 23:12:30'),
(24, 5, 32, 22, 0, '2026-02-26 23:12:30'),
(25, 5, 33, 22, 0, '2026-02-26 23:12:30'),
(26, 5, 34, 17, 0, '2026-02-26 23:12:30'),
(27, 5, 35, 18, 0, '2026-02-26 23:12:30'),
(28, 5, 36, 23, 0, '2026-02-26 23:12:30'),
(29, 5, 37, 18, 0, '2026-02-26 23:12:30'),
(30, 6, 38, 21, 0, '2026-02-26 23:12:30'),
(31, 6, 39, 18, 0, '2026-02-26 23:12:30'),
(32, 6, 40, 10, 0, '2026-02-26 23:12:30'),
(33, 6, 41, 24, 0, '2026-02-26 23:12:30'),
(34, 6, 42, 18, 0, '2026-02-26 23:12:30'),
(35, 6, 43, 14, 0, '2026-02-26 23:12:30'),
(36, 6, 44, 18, 0, '2026-02-26 23:12:30'),
(37, 6, 45, 24, 0, '2026-02-26 23:12:30'),
(38, 6, 46, 30, 0, '2026-02-26 23:12:30'),
(39, 6, 47, 11, 0, '2026-02-26 23:12:30'),
(40, 6, 48, 25, 0, '2026-02-26 23:12:30'),
(41, 6, 49, 26, 0, '2026-02-26 23:12:30'),
(42, 7, 50, 27, 0, '2026-02-26 23:12:30'),
(43, 7, 51, 24, 0, '2026-02-26 23:12:30'),
(44, 7, 52, 12, 0, '2026-02-26 23:12:30'),
(45, 7, 53, 30, 0, '2026-02-26 23:12:30'),
(46, 7, 54, 25, 0, '2026-02-26 23:12:30'),
(47, 7, 55, 26, 0, '2026-02-26 23:12:30'),
(48, 7, 56, 17, 0, '2026-02-26 23:12:30'),
(49, 7, 57, 19, 0, '2026-02-26 23:12:30'),
(50, 7, 58, 12, 0, '2026-02-26 23:12:30'),
(51, 7, 59, 12, 0, '2026-02-26 23:12:30'),
(52, 7, 60, 19, 0, '2026-02-26 23:12:30'),
(53, 7, 61, 20, 0, '2026-02-26 23:12:30'),
(54, 8, 62, 14, 0, '2026-02-26 23:12:30'),
(55, 8, 63, 25, 0, '2026-02-26 23:12:30'),
(56, 8, 64, 10, 0, '2026-02-26 23:12:30'),
(57, 8, 65, 30, 0, '2026-02-26 23:12:30'),
(58, 8, 66, 15, 0, '2026-02-26 23:12:30'),
(59, 8, 67, 18, 0, '2026-02-26 23:12:30'),
(60, 8, 68, 17, 0, '2026-02-26 23:12:30'),
(61, 8, 69, 25, 0, '2026-02-26 23:12:30'),
(62, 8, 70, 18, 0, '2026-02-26 23:12:30'),
(63, 8, 71, 16, 0, '2026-02-26 23:12:30'),
(64, 8, 72, 11, 0, '2026-02-26 23:12:30'),
(65, 8, 73, 27, 0, '2026-02-26 23:12:30'),
(66, 9, 74, 21, 0, '2026-02-26 23:12:30'),
(67, 9, 75, 28, 0, '2026-02-26 23:12:30'),
(68, 9, 76, 17, 0, '2026-02-26 23:12:30'),
(69, 9, 77, 13, 0, '2026-02-26 23:12:30'),
(70, 9, 78, 11, 0, '2026-02-26 23:12:30'),
(71, 9, 79, 25, 0, '2026-02-26 23:12:30'),
(72, 9, 80, 10, 0, '2026-02-26 23:12:30'),
(73, 9, 81, 20, 0, '2026-02-26 23:12:30'),
(74, 9, 82, 20, 0, '2026-02-26 23:12:30'),
(75, 9, 83, 26, 0, '2026-02-26 23:12:30'),
(76, 9, 84, 12, 0, '2026-02-26 23:12:30'),
(77, 9, 85, 17, 0, '2026-02-26 23:12:30'),
(78, 10, 86, 10, 0, '2026-02-26 23:12:30'),
(79, 10, 87, 30, 0, '2026-02-26 23:12:30'),
(80, 10, 88, 26, 0, '2026-02-26 23:12:30'),
(81, 10, 89, 17, 0, '2026-02-26 23:12:30'),
(82, 10, 90, 21, 0, '2026-02-26 23:12:30'),
(83, 10, 91, 16, 0, '2026-02-26 23:12:30'),
(84, 10, 92, 29, 0, '2026-02-26 23:12:30'),
(85, 10, 93, 13, 0, '2026-02-26 23:12:30'),
(86, 10, 94, 13, 0, '2026-02-26 23:12:30'),
(87, 10, 95, 17, 0, '2026-02-26 23:12:30'),
(88, 10, 96, 17, 0, '2026-02-26 23:12:30'),
(89, 10, 97, 11, 0, '2026-02-26 23:12:30'),
(90, 11, 98, 15, 2, '2026-02-26 23:13:39'),
(91, 11, 99, 18, 0, '2026-02-26 23:12:30'),
(92, 11, 100, 29, 0, '2026-02-26 23:12:30'),
(93, 11, 101, 19, 0, '2026-02-26 23:12:30'),
(94, 11, 102, 30, 0, '2026-03-24 14:01:39'),
(95, 11, 103, 15, 0, '2026-02-26 23:12:30'),
(96, 11, 104, 21, 0, '2026-02-26 23:12:30'),
(97, 11, 105, 30, 0, '2026-02-26 23:12:30'),
(98, 11, 106, 28, 0, '2026-02-26 23:12:30'),
(99, 11, 107, 28, 0, '2026-03-24 14:01:39'),
(100, 11, 108, 11, 1, '2026-02-26 23:13:39'),
(101, 11, 109, 16, 0, '2026-03-24 14:01:39'),
(102, 13, 110, 24, 2, '2026-03-27 12:15:31'),
(103, 13, 111, 17, 0, '2026-03-04 16:43:39'),
(104, 13, 112, 22, 0, '2026-02-26 23:12:30'),
(105, 13, 113, 13, 0, '2026-02-26 23:12:30'),
(106, 13, 114, 23, 0, '2026-02-26 23:58:33'),
(107, 13, 115, 16, 0, '2026-02-26 23:12:31'),
(108, 13, 116, 19, 0, '2026-02-26 23:12:31'),
(109, 13, 117, 29, 0, '2026-02-26 23:12:31'),
(110, 13, 118, 17, 0, '2026-02-26 23:12:31'),
(111, 13, 119, 27, 0, '2026-02-26 23:12:31'),
(112, 13, 120, 7, 1, '2026-03-27 12:15:31'),
(113, 13, 121, 14, 0, '2026-02-26 23:12:31'),
(114, 14, 122, 21, 0, '2026-02-26 23:12:31'),
(115, 14, 123, 19, 0, '2026-02-26 23:12:31'),
(116, 14, 124, 28, 0, '2026-02-26 23:12:31'),
(117, 14, 125, 30, 0, '2026-02-26 23:12:31'),
(118, 14, 126, 19, 0, '2026-02-26 23:12:31'),
(119, 14, 127, 26, 0, '2026-02-26 23:12:31'),
(120, 14, 128, 11, 0, '2026-02-26 23:12:31'),
(121, 14, 129, 13, 0, '2026-02-26 23:12:31'),
(122, 14, 130, 21, 0, '2026-02-26 23:12:31'),
(123, 14, 131, 12, 0, '2026-02-26 23:12:31'),
(124, 14, 132, 22, 0, '2026-02-26 23:12:31'),
(125, 14, 133, 28, 0, '2026-02-26 23:12:31'),
(126, 15, 134, 20, 0, '2026-02-26 23:12:31'),
(127, 15, 135, 11, 0, '2026-02-26 23:12:31'),
(128, 15, 136, 29, 0, '2026-02-26 23:12:31'),
(129, 15, 137, 19, 0, '2026-02-26 23:12:31'),
(130, 15, 138, 12, 0, '2026-02-26 23:12:31'),
(131, 15, 139, 16, 0, '2026-02-26 23:12:31'),
(132, 15, 140, 15, 0, '2026-02-26 23:12:31'),
(133, 15, 141, 27, 0, '2026-02-26 23:12:31'),
(134, 15, 142, 17, 0, '2026-02-26 23:12:31'),
(135, 15, 143, 24, 0, '2026-02-26 23:12:31'),
(136, 15, 144, 26, 0, '2026-02-26 23:12:31'),
(137, 15, 145, 28, 0, '2026-02-26 23:12:31'),
(138, 16, 146, 20, 0, '2026-02-26 23:12:31'),
(139, 16, 147, 15, 0, '2026-02-26 23:12:31'),
(140, 16, 148, 22, 0, '2026-02-26 23:12:31'),
(141, 16, 149, 28, 0, '2026-02-26 23:12:31'),
(142, 16, 150, 22, 0, '2026-02-26 23:12:31'),
(143, 16, 151, 21, 0, '2026-02-26 23:12:31'),
(144, 16, 152, 17, 0, '2026-02-26 23:12:31'),
(145, 16, 153, 16, 0, '2026-02-26 23:12:31'),
(146, 16, 154, 21, 0, '2026-02-26 23:12:31'),
(147, 16, 155, 20, 0, '2026-02-26 23:12:31'),
(148, 16, 156, 15, 0, '2026-02-26 23:12:31'),
(149, 16, 157, 13, 0, '2026-02-26 23:12:31');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('super-admin','university-admin','venue-admin','student','donor') NOT NULL,
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
(1, 'Süper Admin', 'admin@askidakampus.com', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'super-admin', 1, 3, NULL, NULL, 1, '2026-02-24 15:10:36', '2026-03-24 11:37:57'),
(2, 'Üniversite Admin', 'universite@askidakampus.com', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'university-admin', 1, 3, NULL, NULL, 1, '2026-02-24 15:10:36', '2026-03-24 11:37:57'),
(3, 'İşletme Yöneticisi', 'admin.merkez@askidakampus.com', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'venue-admin', 1, 3, NULL, NULL, 1, '2026-02-24 15:10:36', '2026-03-24 11:37:57'),
(4, 'Kasa Görevlisi', 'kasiyer.merkez@askidakampus.com', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'venue-admin', 1, 3, NULL, NULL, 1, '2026-02-24 15:10:36', '2026-03-24 11:37:57'),
(5, 'Ali Yılmaz', 'ogrenci@askidakampus.com', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'student', 1, 3, '20210001', NULL, 1, '2026-02-24 15:10:36', '2026-03-24 11:37:57'),
(6, 'Ayşe Kaya', 'bagisci@askidakampus.com', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'donor', 1, 3, NULL, NULL, 1, '2026-02-24 15:10:36', '2026-03-24 11:37:57'),
(7, 'Mehmet Yıldız', 'mehmet.yildiz@aybu.edu.tr', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'university-admin', 1, 3, NULL, NULL, 1, '2026-02-26 23:42:10', '2026-03-24 11:37:57'),
(8, 'Fatma Arslan', 'fatma.arslan@aybu.edu.tr', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'university-admin', 1, 3, NULL, NULL, 1, '2026-02-26 23:42:10', '2026-03-24 11:37:57'),
(9, 'Hasan Demir', 'hasan.demir@aybu.edu.tr', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'university-admin', 1, 3, NULL, NULL, 1, '2026-02-26 23:42:10', '2026-03-24 11:37:57'),
(10, 'Zeynep Koç', 'yonetici.kulliyek.a@aybu.edu.tr', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'venue-admin', 1, 3, NULL, NULL, 1, '2026-02-26 23:42:10', '2026-03-24 11:37:57'),
(11, 'Mustafa Şahin', 'yonetici.kulliyek.b@aybu.edu.tr', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'venue-admin', 1, 3, NULL, NULL, 1, '2026-02-26 23:42:10', '2026-03-24 11:37:57'),
(12, 'Ayşe Erdoğan', 'yonetici.kulliyek.c@aybu.edu.tr', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'venue-admin', 1, 3, NULL, NULL, 1, '2026-02-26 23:42:10', '2026-03-24 11:37:57'),
(13, 'İbrahim Çelik', 'yonetici.kulliyek.d@aybu.edu.tr', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'venue-admin', 1, 3, NULL, NULL, 1, '2026-02-26 23:42:10', '2026-03-24 11:37:57'),
(14, 'Elif Aydın', 'yonetici.bilkent.yeni@aybu.edu.tr', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'venue-admin', 1, 3, NULL, NULL, 1, '2026-02-26 23:42:10', '2026-03-24 11:37:57'),
(15, 'Serkan Polat', 'yonetici.bilkent@aybu.edu.tr', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'venue-admin', 1, 3, NULL, NULL, 1, '2026-02-26 23:42:10', '2026-03-24 11:37:57'),
(16, 'Hülya Yıldırım', 'yonetici.dogu@aybu.edu.tr', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'venue-admin', 1, 3, NULL, NULL, 1, '2026-02-26 23:42:10', '2026-03-24 11:37:57'),
(17, 'Burak Kaya', 'yonetici.bati.giris@aybu.edu.tr', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'venue-admin', 1, 3, NULL, NULL, 1, '2026-02-26 23:42:10', '2026-03-24 11:37:57'),
(18, 'Selin Güneş', 'yonetici.bati.bahce@aybu.edu.tr', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'venue-admin', 1, 3, NULL, NULL, 1, '2026-02-26 23:42:10', '2026-03-24 11:37:57'),
(19, 'Cengiz Yılmaz', 'yonetici.bati.rest@aybu.edu.tr', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'venue-admin', 1, 3, NULL, NULL, 1, '2026-02-26 23:42:10', '2026-03-24 11:37:57'),
(20, 'Nurcan Öztürk', 'yonetici.ovacik@aybu.edu.tr', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'venue-admin', 1, 3, NULL, NULL, 1, '2026-02-26 23:42:10', '2026-03-24 11:37:57'),
(21, 'Taner Doğan', 'yonetici.cinnah1@aybu.edu.tr', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'venue-admin', 1, 3, NULL, NULL, 1, '2026-02-26 23:42:10', '2026-03-24 11:37:57'),
(22, 'Merve Avcı', 'yonetici.cinnah2@aybu.edu.tr', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'venue-admin', 1, 3, NULL, NULL, 1, '2026-02-26 23:42:10', '2026-03-24 11:37:57'),
(24, 'Buse Demirci', 'buse.demirci@ogr.aybu.edu.tr', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'student', 1, 3, '20210002', NULL, 1, '2026-02-26 23:42:10', '2026-03-24 11:37:57'),
(25, 'Emre Kılıç', 'emre.kilic@ogr.aybu.edu.tr', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'student', 1, 3, '20220001', NULL, 1, '2026-02-26 23:42:10', '2026-03-24 11:37:57'),
(26, 'Seda Güler', 'seda.guler@ogr.aybu.edu.tr', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'student', 1, 3, '20220002', NULL, 1, '2026-02-26 23:42:10', '2026-03-24 11:37:57'),
(27, 'Onur Başaran', 'onur.basaran@ogr.aybu.edu.tr', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'student', 1, 3, '20230001', NULL, 1, '2026-02-26 23:42:10', '2026-03-24 11:37:57'),
(28, 'Tuğba Yüksel', 'tugba.yuksel@ogr.aybu.edu.tr', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'student', 1, 3, '20230002', NULL, 1, '2026-02-26 23:42:10', '2026-03-24 11:37:57'),
(29, 'Furkan Ateş', 'furkan.ates@ogr.aybu.edu.tr', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'student', 1, 3, '20240001', NULL, 1, '2026-02-26 23:42:10', '2026-03-24 11:37:57'),
(30, 'Yasemin Bulut', 'yasemin.bulut@ogr.aybu.edu.tr', '$2y$10$2.l.d8qQjiCeHdEsmMX/Cu7Cz7kNV21eYzKYdtqZFXJBL0wMMTn9q', 'student', 1, 3, '20240002', NULL, 1, '2026-02-26 23:42:10', '2026-03-24 11:37:57');

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
(4, 'Külliye A', 'AYBU Külliye Kampüsü', 'kulliye-a', 'K?lliye A Kafeterya', 'Külliye A Binası', NULL, 1, '08:00:00', '20:00:00', '2026-02-26 14:40:51', '2026-02-26 14:42:31'),
(5, 'Külliye B', 'AYBU Külliye Kampüsü', 'kulliye-b', 'K?lliye B Kafeterya', 'Külliye B Binası', NULL, 1, '08:00:00', '20:00:00', '2026-02-26 14:40:51', '2026-02-26 14:42:31'),
(6, 'Külliye C', 'AYBU Külliye Kampüsü', 'kulliye-c', 'K?lliye C Kafeterya', 'Külliye C Binası', NULL, 1, '08:00:00', '20:00:00', '2026-02-26 14:40:51', '2026-02-26 14:42:31'),
(7, 'Külliye D', 'AYBU Külliye Kampüsü', 'kulliye-d', 'K?lliye D Kafeterya', 'Külliye D Binası', NULL, 1, '08:00:00', '20:00:00', '2026-02-26 14:40:51', '2026-02-26 14:42:31'),
(8, 'Bilkent Yeni', 'AYBU Bilkent Kampüsü', 'bilkent-yeni', 'Bilkent Yeni Kafeterya', 'Bilkent Yeni Bina', NULL, 1, '08:00:00', '20:00:00', '2026-02-26 14:40:51', '2026-02-26 14:42:31'),
(9, 'Bilkent', 'AYBU Bilkent Kampüsü', 'bilkent', 'Bilkent Kafeterya', 'Bilkent Bina', NULL, 1, '08:00:00', '20:00:00', '2026-02-26 14:40:51', '2026-02-26 14:42:31'),
(10, 'Doğu', 'AYBU Merkez Kampüsü', 'dogu', 'Do?u Kafeterya', 'Doğu Blok', NULL, 1, '08:00:00', '20:00:00', '2026-02-26 14:40:51', '2026-02-26 14:42:31'),
(11, 'Batı Giriş', 'AYBU Merkez Kampüsü', 'bati-giris', 'Bat? Giri? Kafeterya', 'Batı Giriş Kapısı', NULL, 1, '08:00:00', '20:00:00', '2026-02-26 14:40:51', '2026-02-26 14:42:31'),
(12, 'Batı Bahçe', 'AYBU Merkez Kampüsü', 'bati-bahce', 'Bat? Bah?e Kafeterya', 'Batı Bahçe Alanı', NULL, 1, '08:00:00', '20:00:00', '2026-02-26 14:40:51', '2026-02-26 14:42:31'),
(13, 'Batı Restoran', 'AYBU Merkez Kampüsü', 'bati-restoran', 'Bat? Restoran', 'Batı Blok Restoran', NULL, 1, '08:00:00', '20:00:00', '2026-02-26 14:40:51', '2026-02-26 14:42:31'),
(14, 'Ovacık', 'AYBU Ovacık Kampüsü', 'ovacik', 'Ovac?k Kafeterya', 'Ovacık Yerleşkesi', NULL, 1, '08:00:00', '20:00:00', '2026-02-26 14:40:51', '2026-02-26 14:42:31'),
(15, 'Cinnah 1', 'AYBU Cinnah Kampüsü', 'cinnah-1', 'Cinnah 1 Kafeterya', 'Cinnah Cad. No:16', NULL, 1, '08:00:00', '20:00:00', '2026-02-26 14:40:51', '2026-02-26 14:42:31'),
(16, 'Cinnah 2', 'AYBU Cinnah Kampüsü', 'cinnah-2', 'Cinnah 2 Kafeterya', 'Cinnah Cad. No:16', NULL, 1, '08:00:00', '20:00:00', '2026-02-26 14:40:51', '2026-02-26 14:42:31');

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
(10, 4),
(11, 5),
(12, 6),
(13, 7),
(14, 8),
(15, 9),
(16, 10),
(17, 11),
(18, 12),
(19, 13),
(20, 14),
(21, 15),
(22, 16);

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
  ADD UNIQUE KEY `setting_key` (`setting_key`),
  ADD KEY `idx_key` (`setting_key`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Tablo için AUTO_INCREMENT değeri `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `donation_items`
--
ALTER TABLE `donation_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- Tablo için AUTO_INCREMENT değeri `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `reservation_items`
--
ALTER TABLE `reservation_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Tablo için AUTO_INCREMENT değeri `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `suspended_stocks`
--
ALTER TABLE `suspended_stocks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Tablo için AUTO_INCREMENT değeri `venues`
--
ALTER TABLE `venues`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  ADD CONSTRAINT `donations_donor_fk` FOREIGN KEY (`donor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
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
