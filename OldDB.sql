-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20250927.af95a2e028
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 12, 2026 at 04:01 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nutriroute`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laporan_sekolah`
--

CREATE TABLE `laporan_sekolah` (
  `id` bigint UNSIGNED NOT NULL,
  `pengiriman_id` bigint UNSIGNED NOT NULL,
  `porsi_diterima` int UNSIGNED NOT NULL COMMENT 'Jumlah fisik kotak layak konsumsi',
  `food_waste` int UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Sisa porsi tidak termakan',
  `rating` tinyint UNSIGNED NOT NULL COMMENT 'Kepuasan kualitas 1-5',
  `foto_makanan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Path foto bukti akuntabilitas',
  `komentar` text COLLATE utf8mb4_unicode_ci COMMENT 'Ulasan kualitas makanan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporan_sekolah`
--

INSERT INTO `laporan_sekolah` (`id`, `pengiriman_id`, `porsi_diterima`, `food_waste`, `rating`, `foto_makanan`, `komentar`, `created_at`, `updated_at`) VALUES
(1, 1, 498, 12, 4, NULL, 'Makanan segar dan enak. 2 box rusak saat pengiriman.', '2026-06-12 08:47:00', '2026-06-12 08:47:00');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint UNSIGNED NOT NULL,
  `dapur_id` bigint UNSIGNED NOT NULL,
  `target_sekolah_id` bigint UNSIGNED NOT NULL,
  `nama_menu` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Rincian makanan sesuai kriteria Isi Piringku',
  `kalori` int UNSIGNED NOT NULL COMMENT 'Estimasi kalori dalam kkal',
  `protein` int UNSIGNED NOT NULL COMMENT 'Estimasi protein dalam gram',
  `porsi_rencana` int UNSIGNED NOT NULL COMMENT 'Jumlah kotak yang akan diproduksi',
  `status` enum('Pending Verification','Ready to Cook','Rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending Verification',
  `catatan_gizi` text COLLATE utf8mb4_unicode_ci COMMENT 'Wajib diisi jika status Rejected',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `dapur_id`, `target_sekolah_id`, `nama_menu`, `kalori`, `protein`, `porsi_rencana`, `status`, `catatan_gizi`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'Nasi Putih, Ayam Goreng Lengkuas, Tumis Buncis, Buah Jeruk', 650, 25, 500, 'Ready to Cook', NULL, '2026-06-12 08:47:00', '2026-06-12 08:47:00'),
(2, 1, 4, 'Nasi Merah, Ikan Bakar Bumbu Kuning, Sayur Bayam, Buah Pisang', 580, 22, 350, 'Ready to Cook', NULL, '2026-06-12 08:47:00', '2026-06-12 08:59:12'),
(3, 1, 3, 'Nasi Putih, Rendang Sapi, Lalapan Mentimun, Buah Semangka', 720, 30, 500, 'Rejected', 'Sayuran kurang bervariasi. Ganti lalapan mentimun dengan tumis kangkung yang tinggi serat dan zat besi.', '2026-06-12 08:47:00', '2026-06-12 08:47:00'),
(4, 1, 3, 'Nasi Putih, Telur Balado, Capcay Sayuran, Buah Apel', 550, 18, 500, 'Ready to Cook', NULL, '2026-06-12 08:47:00', '2026-06-12 08:59:17'),
(5, 1, 4, 'Nasi Putih, Soto Ayam, Perkedel Kentang, Buah Melon', 610, 20, 350, 'Ready to Cook', NULL, '2026-06-12 08:47:00', '2026-06-12 08:47:00'),
(6, 1, 4, 'hhgyfuyfuyf', 555, 45, 800, 'Ready to Cook', NULL, '2026-06-12 08:58:35', '2026-06-12 08:59:03');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_09_000001_create_menus_table', 1),
(5, '2026_06_09_000002_create_pengiriman_table', 1),
(6, '2026_06_09_000003_create_laporan_sekolah_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman`
--

CREATE TABLE `pengiriman` (
  `id` bigint UNSIGNED NOT NULL,
  `menu_id` bigint UNSIGNED NOT NULL,
  `nama_kurir` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_logistik` enum('Sedang Dimasak','Dalam Perjalanan','Diterima') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Sedang Dimasak',
  `dispatched_at` timestamp NULL DEFAULT NULL COMMENT 'Waktu katering klik Kirim Makanan',
  `received_at` timestamp NULL DEFAULT NULL COMMENT 'Waktu sekolah klik Konfirmasi',
  `is_synced` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'FALSE jika input offline PWA',
  `device_info` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'User-agent untuk audit digital',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengiriman`
--

INSERT INTO `pengiriman` (`id`, `menu_id`, `nama_kurir`, `status_logistik`, `dispatched_at`, `received_at`, `is_synced`, `device_info`, `created_at`, `updated_at`) VALUES
(1, 1, 'Andi Prasetyo', 'Diterima', '2026-06-12 03:00:00', '2026-06-12 03:45:00', 1, 'Chrome/Android 14 - Samsung A54', '2026-06-12 08:47:00', '2026-06-12 08:47:00'),
(2, 5, 'Budi Santoso', 'Dalam Perjalanan', '2026-06-12 05:47:00', NULL, 1, 'Safari/iOS 18 - iPhone 15', '2026-06-12 08:47:00', '2026-06-12 08:47:00'),
(3, 1, 'Cahyo Wibowo', 'Sedang Dimasak', NULL, NULL, 1, NULL, '2026-06-12 08:47:00', '2026-06-12 08:47:00'),
(4, 6, 'prasetyo', 'Dalam Perjalanan', '2026-06-12 09:00:25', NULL, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-12 09:00:25', '2026-06-12 09:00:25');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('4STKUBBEQWnB3rZKnToNN37us442pzyV8YPlyQfw', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJuNVlmazVBUHY4cWVBU2g5dEk3Y3FDZ2U4VExIRzFFNmNRb1hrbnVEIiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1781279999),
('5kVhDKo3ojrF46Bo1gva1GYRczfox37RVGndhX8n', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJ2ek1odGdETnBLa2ppc0NUVnJUem5Zc3NZR2o4YVFmTFNoU29Ka3NPIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDBcL2RhcHVyIiwicm91dGUiOiJkYXB1ci5kYXNoYm9hcmQifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9', 1781280083),
('AQCoEJZ5WF5uZqF4tMpppuYTJTdSOANJ2Bbs2HPG', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJQZFlubVZZOU4waEI3TEpJbWdjN0ZPMjV4bDR2Tlh0dUJ0eEJvN09TIiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1781279994),
('EwE5VFlD3Kow4KbmXt8Nkm5NUkLoDKwUcDMj1Rkj', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJyY2luazNkVk9lWWJncnNFTk1HNGhaam92R0Z2M3F0ajluYVpUeERNIiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjYsIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9rdXJpciIsInJvdXRlIjoia3VyaXIuZGFzaGJvYXJkIn19', 1781280083),
('FcM0Rk41NXgijGf3XZtTFBG1qm3Ymu3QgnSSzW6f', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiI0TmVWSHZ3Wm9WS2h0S20zU0NjQ2sxdlRYNjhwcUxSbm12UVR3MUcwIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1781279879),
('jeqmMgaMMHQ7kbyuwnPpbXZMbKUgM9r1mV5vmCGF', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJ6cWRmZFNkdG5md0FQTmpIUmFxRTY1N2xKSE11b25qbnRsdXJtbGdSIiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1781279992),
('KQS9PWeGqkrxfizKSctzop9Qvp4MVIOiQr9o1mm8', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJMOERtV2daQmhYTDhyR2NQTldyZFBVUDVrUlhObmN2V0lGWjR5T0pLIiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1781279998),
('l3gO5b16Tpiip4slAWCx1bJRKWHYRNEr2X7KUR3Q', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJjbjgyejN4Z0JtTVliVW9SclRTVlFua1BOeU9sMkRrdDJTODdyVk02IiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDBcL2t1cmlyIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1781279353),
('mI83U4uD726bszTlEEtvSKTikKfBmfkr4CVNhgDD', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJuMUlBTE9lOGVQajJ5YXFZM1dsZ2lBNEtFT1BOR3ZpRGlTUXV6TmRzIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1781279881),
('rUMBt8wC2WtIIM41hwRvyKFKdC6TkodloGQsgmGX', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiI5dmpSYzl3QXhiU0YwUmRPeHJ2SzJxWTlsVGgzVUNhOTVmUzhwRDJmIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2RhcHVyIiwicm91dGUiOiJkYXB1ci5kYXNoYm9hcmQifSwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2RhcHVyIn0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==', 1781279991),
('tkOxH59rpQadpOwLkLcJc3nGvNxPeMuOcqnTHwxD', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJJNk5LN1p4d0VYNUZYUGMyRFc0d2ZFOGdqTU1TaWdkNHpFS2xRd2V4IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1781279880),
('tYvgqnjrrCBRWm8ehVsKdqvfVMZ7tvMlyiWZEtpc', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiI4bmpRRWVZb1NFQ0NZaHRoamVlUk5Ic25hbWxEQWJuaEtjQzVLQ1hxIiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1781279996),
('WTn9g5Raj2TlXQjTbqF0D3WsGAvmTf4EDQ4vPOzt', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJOVUc0RE5YdWdMNlQwbXE4MlRESmlyU1dDTDQ4OGRnOVAwR3p0bnZiIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1781279878),
('YocOvobSfdl52mkwrxnst0edWArXCM7Bf3wSa5Xn', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJIdlVaVFpXdk9KeVlJUFBWYUFnWm5GNjlyUmpaczNLajZOaFU0VFRnIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDBcL2t1cmlyIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1781279710);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('dapur','ahli_gizi','sekolah','admin','kurir') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_entitas` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nama katering / sekolah / dinas',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `nama_entitas`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'dapur1', '$2y$12$6zsEGK5xO4Q1mJSKdrbU1.lg4w7q5uKK632v.FoqiWRMVKwlXjxCa', 'dapur', 'Katering Sukses Makmur', NULL, '2026-06-12 08:46:58', '2026-06-12 08:46:58'),
(2, 'gizi1', '$2y$12$37W7D6THiUVq.SrsPkQsE.RIaXCSTirIC.TV5LneRa2LstjRYKWby', 'ahli_gizi', 'Dinas Kesehatan Kota Depok', NULL, '2026-06-12 08:46:59', '2026-06-12 08:46:59'),
(3, 'sekolah1', '$2y$12$sGZpOxrhCsairc0XjGxB8uh1ReQsCb5yb8xhMr9UlEzcEZp//Vm9.', 'sekolah', 'SDN 01 Cinere', NULL, '2026-06-12 08:46:59', '2026-06-12 08:46:59'),
(4, 'sekolah2', '$2y$12$zY/hx/58GZgYE.QCURaytOjtf1OdRCdQJBImTeFOkqQTynB30d97W', 'sekolah', 'SDN 05 Beji', NULL, '2026-06-12 08:46:59', '2026-06-12 08:46:59'),
(5, 'admin1', '$2y$12$jcAhcmH5PrNOudFAIuwyeunKP/9PejFMn2Y5nDFwG2GKpGutnT.vm', 'admin', 'Dinas Pendidikan Kota Depok', NULL, '2026-06-12 08:47:00', '2026-06-12 08:47:00'),
(6, 'kurir1', '$2y$12$jtMuRd3nIxq1yk.EJxY8fODHtWhjhGFpOrV1DSgBtTdF0fpv71HHu', 'kurir', 'Andi Prasetyo', NULL, '2026-06-12 08:47:00', '2026-06-12 08:47:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporan_sekolah`
--
ALTER TABLE `laporan_sekolah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporan_sekolah_pengiriman_id_foreign` (`pengiriman_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_dapur_id_foreign` (`dapur_id`),
  ADD KEY `menus_target_sekolah_id_foreign` (`target_sekolah_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengiriman_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laporan_sekolah`
--
ALTER TABLE `laporan_sekolah`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengiriman`
--
ALTER TABLE `pengiriman`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `laporan_sekolah`
--
ALTER TABLE `laporan_sekolah`
  ADD CONSTRAINT `laporan_sekolah_pengiriman_id_foreign` FOREIGN KEY (`pengiriman_id`) REFERENCES `pengiriman` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_dapur_id_foreign` FOREIGN KEY (`dapur_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menus_target_sekolah_id_foreign` FOREIGN KEY (`target_sekolah_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD CONSTRAINT `pengiriman_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
