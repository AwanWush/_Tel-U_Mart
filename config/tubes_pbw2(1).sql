-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 02, 2025 at 10:18 AM
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
-- Database: `tubes_pbw2`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `gaji` decimal(12,2) DEFAULT '0.00',
  `tanggal_gaji` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-admin@example.com|127.0.0.1', 'i:1;', 1764488694),
('laravel-cache-admin@example.com|127.0.0.1:timer', 'i:1764488694;', 1764488694),
('laravel-cache-tata@gmail.com|127.0.0.1', 'i:2;', 1764487072),
('laravel-cache-tata@gmail.com|127.0.0.1:timer', 'i:1764487072;', 1764487072),
('laravel-cache-tata@gmiall.com|127.0.0.1', 'i:1;', 1764487321),
('laravel-cache-tata@gmiall.com|127.0.0.1:timer', 'i:1764487321;', 1764487321);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id` bigint UNSIGNED NOT NULL,
  `penjualan_id` bigint UNSIGNED NOT NULL,
  `produk_id` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL,
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `detail_penjualan`
--
DELIMITER $$
CREATE TRIGGER `kurangi_stok_setelah_penjualan` AFTER INSERT ON `detail_penjualan` FOR EACH ROW BEGIN
  UPDATE produk 
  SET stok = stok - NEW.jumlah 
  WHERE id = NEW.produk_id;

  IF (SELECT stok FROM produk WHERE id = NEW.produk_id) <= 0 THEN
      UPDATE produk SET status_ketersediaan = 'Habis' WHERE id = NEW.produk_id;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id` bigint UNSIGNED NOT NULL,
  `pesanan_id` bigint UNSIGNED NOT NULL,
  `produk_id` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL,
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `detail_pesanan`
--
DELIMITER $$
CREATE TRIGGER `kurangi_stok_setelah_pesanan` AFTER INSERT ON `detail_pesanan` FOR EACH ROW BEGIN
  UPDATE produk 
  SET stok = stok - NEW.jumlah 
  WHERE id = NEW.produk_id;

  IF (SELECT stok FROM produk WHERE id = NEW.produk_id) <= 0 THEN
      UPDATE produk SET status_ketersediaan = 'Habis' WHERE id = NEW.produk_id;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_produk`
--

CREATE TABLE `kategori_produk` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori_produk`
--

INSERT INTO `kategori_produk` (`id`, `nama_kategori`) VALUES
(4, 'Alat Dapur'),
(3, 'Alat Tulis'),
(6, 'Elektronik'),
(8, 'Galon'),
(9, 'Lainnya'),
(1, 'Makanan'),
(2, 'Minuman'),
(5, 'Sabun'),
(7, 'Token Listrik');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi_delivery`
--

CREATE TABLE `lokasi_delivery` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_lokasi` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `lokasi_delivery`
--

INSERT INTO `lokasi_delivery` (`id`, `nama_lokasi`) VALUES
(7, 'Gedung 1'),
(16, 'Gedung 10'),
(17, 'Gedung 11'),
(18, 'Gedung 12'),
(8, 'Gedung 2'),
(9, 'Gedung 3'),
(10, 'Gedung 4'),
(11, 'Gedung 5'),
(12, 'Gedung 6'),
(13, 'Gedung 7'),
(14, 'Gedung 8'),
(15, 'Gedung 9'),
(1, 'Gedung A'),
(2, 'Gedung B'),
(3, 'Gedung C'),
(4, 'Gedung D'),
(5, 'Gedung E'),
(6, 'Gedung F');

-- --------------------------------------------------------

--
-- Table structure for table `mart`
--

CREATE TABLE `mart` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_mart` varchar(100) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mart`
--

INSERT INTO `mart` (`id`, `nama_mart`, `alamat`, `created_at`) VALUES
(1, 'TJ Mart', 'Deket Gedung 1', '2025-10-24 11:55:01'),
(2, 'T Mart 1', 'Dekat Gedung A-B', '2025-10-24 11:55:01'),
(3, 'T Mart 2', 'Dekat Gedung 11-12', '2025-10-24 11:55:01');

-- --------------------------------------------------------

--
-- Table structure for table `metode_pembayaran`
--

CREATE TABLE `metode_pembayaran` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `metode_pembayaran`
--

INSERT INTO `metode_pembayaran` (`id`, `user_id`, `jenis`, `keterangan`, `created_at`, `updated_at`) VALUES
(5, 5, 'QRIS', 'QRIS', '2025-11-24 05:49:17', '2025-11-24 05:49:17'),
(6, 5, 'COD', 'COD', '2025-11-24 05:52:40', '2025-11-24 05:52:40');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_roles_table', 1),
(2, '0001_01_01_000000_create_users_table', 1),
(3, '0001_01_01_000001_create_cache_table', 1),
(4, '0001_01_01_000002_create_jobs_table', 1),
(5, '2025_10_14_135458_create_personal_access_tokens_table', 1),
(6, '2025_10_27_050259_add_profile_fields_to_users_table', 2),
(7, '2025_10_27_051359_create_lokasi_delivery_table', 2),
(8, '2025_10_27_062725_add_alamat_gedung_to_users_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('dil@gmail.com', '$2y$12$STFJf1PRn7YnKeuMA1vtIu6GRWibb3ZGHPSul2fql7Q0dcova7ViO', '2025-10-24 05:20:40');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id` bigint UNSIGNED NOT NULL,
  `admin_id` bigint UNSIGNED DEFAULT NULL,
  `mart_id` bigint UNSIGNED DEFAULT NULL,
  `tanggal_penjualan` date NOT NULL,
  `total` decimal(12,2) DEFAULT '0.00',
  `metode_pembayaran` enum('Cash','QRIS') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `penjualan_bulanan`
-- (See below for the actual view)
--
CREATE TABLE `penjualan_bulanan` (
`bulan` int
,`mart_id` bigint unsigned
,`tahun` year
,`total_bulanan` decimal(34,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `penjualan_tahunan`
-- (See below for the actual view)
--
CREATE TABLE `penjualan_tahunan` (
`mart_id` bigint unsigned
,`tahun` year
,`total_tahunan` decimal(34,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'api_token', '02ed2a96c8c744c5cd6a3af7662309769a5129a5939793410bf71eef81c1da7c', '[\"*\"]', NULL, NULL, '2025-10-18 08:37:20', '2025-10-18 08:37:20');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `admin_id` bigint UNSIGNED DEFAULT NULL,
  `mart_id` bigint UNSIGNED NOT NULL,
  `lokasi_id` bigint UNSIGNED DEFAULT NULL,
  `tanggal_pesan` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `jenis_pesanan` enum('Take Away','Delivery') NOT NULL,
  `status` enum('Menunggu','Dikonfirmasi','Dikirim','Selesai','Dibatalkan') DEFAULT 'Menunggu',
  `total` decimal(12,2) DEFAULT '0.00',
  `metode_pembayaran` enum('Cash','QRIS') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` bigint UNSIGNED NOT NULL,
  `kategori_id` bigint UNSIGNED NOT NULL,
  `mart_id` bigint UNSIGNED NOT NULL,
  `nama_produk` varchar(150) NOT NULL,
  `deskripsi` text,
  `harga` decimal(12,2) NOT NULL,
  `stok` int DEFAULT '0',
  `gambar` varchar(255) DEFAULT NULL,
  `status_ketersediaan` enum('Tersedia','Habis') DEFAULT 'Tersedia',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `produk_laris`
-- (See below for the actual view)
--
CREATE TABLE `produk_laris` (
`nama_produk` varchar(150)
,`produk_id` bigint unsigned
,`total_terjual` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_pembelian`
--

CREATE TABLE `riwayat_pembelian` (
  `id` bigint NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `produk_id` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL,
  `total_harga` decimal(12,2) NOT NULL,
  `metode_pembayaran` enum('qris','cash') DEFAULT 'qris',
  `jenis_pemesanan` enum('takeaway','delivery') DEFAULT 'takeaway',
  `lokasi_pengantaran` varchar(50) DEFAULT NULL,
  `status` enum('pending','diproses','selesai','batal') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `role_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', '2025-10-18 08:36:26', '2025-10-18 08:36:26'),
(2, 'admin', '2025-10-18 08:36:26', '2025-10-18 08:36:26'),
(3, 'user', '2025-10-18 08:36:26', '2025-10-18 08:36:26');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ZwTpWaPtApoFOv1Y0BVGEMZAACGYFc3HwSsUYVMl', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:145.0) Gecko/20100101 Firefox/145.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaXZTQ3V2YWpYa0ZMbjJ5dmFWaUljcmJ3YVJrNDBKTlBBQnNzdUVYUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9maWxlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTt9', 1764582355);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `produk_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('Bayar','Diproses','Dikirim','Sudah Tiba','Ulasan') DEFAULT 'Bayar',
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penghuni_asrama` enum('ya','tidak') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_gedung` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lokasi_id` bigint UNSIGNED DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `no_telp`, `penghuni_asrama`, `alamat_gedung`, `gambar`, `lokasi_id`, `email_verified_at`, `password`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'superadmin@gmail.com', '0225 1115', NULL, NULL, NULL, NULL, '2025-10-18 09:25:45', '$2y$12$zbJUuyjHTqlQqXdywWPSc.2MMYu2tLrPvmUVyayheU2czGDHq4sea', 1, '7JgitOwYzAIFf7DOyGMTTJpD7ciB3G8FAlitY70sG6QQQRIDTW3mjEArP37B', '2025-10-18 09:25:45', '2025-10-18 09:25:45'),
(2, 'Admin', 'admin@gmail.com', '0229 1254', NULL, NULL, NULL, NULL, '2025-10-18 09:25:45', '$2y$12$cc1YffNQL3k9RO1N3A61Aek2Db16Sxa2PFm52eDrK7dGl6N.keuyi', 2, 'QuGFwX2nZAHlbzyAY19ZPI5CdQpbNrNqZRZLnml6B2wzV9i7RbRdk7p4Soms', '2025-10-18 09:25:45', '2025-10-18 09:25:45'),
(5, 'tata', 'tata@gmial.com', '08717894563', 'ya', 'Gedung 2', 'profil/6FYVZW0xO7DHyg9FpMvazd7JYftxV4MbLXJn0e9E.jpg', NULL, NULL, '$2y$12$n61fyR8s1zNFfWtyWY1j9eP4vE6eoCKtXeNnHxeMHWL4I/AjnJ5fa', 3, NULL, '2025-10-27 00:36:46', '2025-11-30 02:45:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penjualan_id` (`penjualan_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanan_id` (`pesanan_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_kategori` (`nama_kategori`);

--
-- Indexes for table `lokasi_delivery`
--
ALTER TABLE `lokasi_delivery`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_lokasi` (`nama_lokasi`);

--
-- Indexes for table `mart`
--
ALTER TABLE `mart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_pembayaran` (`user_id`);

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
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `mart_id` (`mart_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `mart_id` (`mart_id`),
  ADD KEY `lokasi_id` (`lokasi_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`),
  ADD KEY `mart_id` (`mart_id`);

--
-- Indexes for table `riwayat_pembelian`
--
ALTER TABLE `riwayat_pembelian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`),
  ADD KEY `fk_produk` (`produk_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_role_name_unique` (`role_name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `fk_user_lokasi` (`lokasi_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `lokasi_delivery`
--
ALTER TABLE `lokasi_delivery`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `mart`
--
ALTER TABLE `mart`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `riwayat_pembelian`
--
ALTER TABLE `riwayat_pembelian`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

-- --------------------------------------------------------

--
-- Structure for view `penjualan_bulanan`
--
DROP TABLE IF EXISTS `penjualan_bulanan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `penjualan_bulanan`  AS SELECT `penjualan`.`mart_id` AS `mart_id`, month(`penjualan`.`tanggal_penjualan`) AS `bulan`, year(`penjualan`.`tanggal_penjualan`) AS `tahun`, sum(`penjualan`.`total`) AS `total_bulanan` FROM `penjualan` GROUP BY `penjualan`.`mart_id`, year(`penjualan`.`tanggal_penjualan`), month(`penjualan`.`tanggal_penjualan`) ;

-- --------------------------------------------------------

--
-- Structure for view `penjualan_tahunan`
--
DROP TABLE IF EXISTS `penjualan_tahunan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `penjualan_tahunan`  AS SELECT `penjualan`.`mart_id` AS `mart_id`, year(`penjualan`.`tanggal_penjualan`) AS `tahun`, sum(`penjualan`.`total`) AS `total_tahunan` FROM `penjualan` GROUP BY `penjualan`.`mart_id`, year(`penjualan`.`tanggal_penjualan`) ;

-- --------------------------------------------------------

--
-- Structure for view `produk_laris`
--
DROP TABLE IF EXISTS `produk_laris`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `produk_laris`  AS SELECT `p`.`id` AS `produk_id`, `p`.`nama_produk` AS `nama_produk`, sum(`dp`.`jumlah`) AS `total_terjual` FROM (`produk` `p` left join `detail_penjualan` `dp` on((`dp`.`produk_id` = `p`.`id`))) GROUP BY `p`.`id` ORDER BY `total_terjual` DESC ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD CONSTRAINT `detail_penjualan_ibfk_1` FOREIGN KEY (`penjualan_id`) REFERENCES `penjualan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_penjualan_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  ADD CONSTRAINT `fk_user_pembayaran` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `fk_penjualan_admin` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_penjualan_mart` FOREIGN KEY (`mart_id`) REFERENCES `mart` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`mart_id`) REFERENCES `mart` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pesanan_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pesanan_ibfk_3` FOREIGN KEY (`mart_id`) REFERENCES `mart` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pesanan_ibfk_4` FOREIGN KEY (`lokasi_id`) REFERENCES `lokasi_delivery` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_produk` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `produk_ibfk_2` FOREIGN KEY (`mart_id`) REFERENCES `mart` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `riwayat_pembelian`
--
ALTER TABLE `riwayat_pembelian`
  ADD CONSTRAINT `fk_produk` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_lokasi` FOREIGN KEY (`lokasi_id`) REFERENCES `lokasi_delivery` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
