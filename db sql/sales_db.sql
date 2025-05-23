-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2025 at 12:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sales_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_05_22_164714_create_products_table', 1),
(5, '2025_05_22_164716_create_notes_table', 1),
(6, '2025_05_22_174006_create_sales_table', 1),
(7, '2025_05_22_174034_create_sale_items_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `note` text NOT NULL,
  `noteable_type` varchar(255) NOT NULL,
  `noteable_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Laptop', 75000.00, '2025-05-23 03:51:34', '2025-05-23 03:51:34'),
(2, 'Mouse', 500.00, '2025-05-23 03:51:34', '2025-05-23 03:51:34'),
(3, 'Keyboard', 1200.00, '2025-05-23 03:51:34', '2025-05-23 03:51:34'),
(4, 'Monitor', 15000.00, '2025-05-23 03:51:34', '2025-05-23 03:51:34'),
(5, 'Printer', 8500.00, '2025-05-23 03:51:34', '2025-05-23 03:51:34'),
(6, 'Scanner', 6000.00, '2025-05-23 03:51:34', '2025-05-23 03:51:34'),
(7, 'Webcam', 2500.00, '2025-05-23 03:51:34', '2025-05-23 03:51:34'),
(8, 'Speaker', 1800.00, '2025-05-23 03:51:34', '2025-05-23 03:51:34'),
(9, 'Router', 3200.00, '2025-05-23 03:51:34', '2025-05-23 03:51:34'),
(10, 'External Hard Drive', 10500.00, '2025-05-23 03:51:34', '2025-05-23 03:51:34');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `user_id`, `date`, `total`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, '2025-05-23', 84500.00, NULL, '2025-05-23 03:53:44', '2025-05-23 03:53:44'),
(2, 8, '2025-05-23', 21000.00, NULL, '2025-05-23 04:09:33', '2025-05-23 04:09:33'),
(3, 9, '2025-05-23', 5700.00, NULL, '2025-05-23 04:10:31', '2025-05-23 04:10:31'),
(4, 10, '2025-05-23', 19000.00, NULL, '2025-05-23 04:11:10', '2025-05-23 04:11:10'),
(5, 6, '2025-05-23', 15000.00, NULL, '2025-05-23 04:11:48', '2025-05-23 04:11:48');

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `quantity`, `price`, `discount`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 75000.00, 0.00, NULL, '2025-05-23 03:53:44', '2025-05-23 03:53:44'),
(2, 1, 2, 2, 500.00, 0.00, NULL, '2025-05-23 03:53:44', '2025-05-23 03:53:44'),
(3, 1, 5, 1, 8500.00, 0.00, NULL, '2025-05-23 03:53:44', '2025-05-23 03:53:44'),
(4, 2, 4, 1, 15000.00, 0.00, NULL, '2025-05-23 04:09:33', '2025-05-23 04:09:33'),
(5, 2, 6, 1, 6000.00, 0.00, NULL, '2025-05-23 04:09:33', '2025-05-23 04:09:33'),
(6, 3, 7, 1, 2500.00, 0.00, NULL, '2025-05-23 04:10:31', '2025-05-23 04:10:31'),
(7, 3, 9, 1, 3200.00, 0.00, NULL, '2025-05-23 04:10:31', '2025-05-23 04:10:31'),
(8, 4, 10, 1, 10500.00, 0.00, NULL, '2025-05-23 04:11:10', '2025-05-23 04:11:10'),
(9, 4, 5, 1, 8500.00, 0.00, NULL, '2025-05-23 04:11:10', '2025-05-23 04:11:10'),
(10, 5, 3, 5, 1200.00, 0.00, NULL, '2025-05-23 04:11:48', '2025-05-23 04:11:48'),
(11, 5, 8, 5, 1800.00, 0.00, NULL, '2025-05-23 04:11:48', '2025-05-23 04:11:48');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('tKRyk30690W5xfJgGx0uCdFCvJdMOhmDU9T7HbAN', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVW5Sc0p1ajk2MWFDMGNiQ1k1RWVHZnZscWZvU2VaaUhybGJ1SERHWSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvc2FsZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1747995139);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '2025-05-23 03:51:32', '$2y$12$i6octXDoExuKAeOJKHC3we3x1Q3LhG1VlHUijgb9MfF/XeoAclFty', NULL, '2025-05-23 03:51:32', '2025-05-23 03:51:32'),
(2, 'Nazrul Islam', 'nsuzon02@gmail.com', '2025-05-23 03:51:32', '$2y$12$zkMEA0xuNI4um1f4Ky9kMOrGbVqUkH0g1KHI43j0mYdlMgrZkuWS2', NULL, '2025-05-23 03:51:32', '2025-05-23 03:51:32'),
(3, 'Rahim Uddin', 'rahim@gmail.com', '2025-05-23 03:51:33', '$2y$12$J39KabgKlVHyxynAxOi4KO./tOFA8eDnAzNXm82OsXSf3jy1jcv0a', NULL, '2025-05-23 03:51:33', '2025-05-23 03:51:33'),
(4, 'Karim Hossain', 'karim@gmail.com', '2025-05-23 03:51:33', '$2y$12$Tj/nS.xqrWqIyTnH5ayKiurI39UvV2csj8PZKCtmSzTTSKI3agoWS', NULL, '2025-05-23 03:51:33', '2025-05-23 03:51:33'),
(5, 'Shakil Ahmed', 'shakil@gmail.com', '2025-05-23 03:51:33', '$2y$12$P/RIQ3d6rulWwSNG9L0C4uXKftVkjNq.RnmmcthgoziJ4wqlB5Cxe', NULL, '2025-05-23 03:51:33', '2025-05-23 03:51:33'),
(6, 'Sumaiya Akter', 'sumaiya@gmail.com', '2025-05-23 03:51:33', '$2y$12$CIJiNQ/PvBz9A/PDkCTAy.HX9XyXejqaUUkeukO/Cd0afuxTKHCNS', NULL, '2025-05-23 03:51:33', '2025-05-23 03:51:33'),
(7, 'Jannatul Ferdous', 'jannatul@gmail.com', '2025-05-23 03:51:34', '$2y$12$GOqISIeNYkERuHp0sMeO/u/BqUdY2QcEnE6d993sqbm13swoYsTwK', NULL, '2025-05-23 03:51:34', '2025-05-23 03:51:34'),
(8, 'Rasel Miah', 'rasel@gmail.com', '2025-05-23 03:51:34', '$2y$12$cEwub3ZGW12DKTWanXdCJe2Nc/arOA5iCZeO80UFr9jLHC376t3P2', NULL, '2025-05-23 03:51:34', '2025-05-23 03:51:34'),
(9, 'Fahim Chowdhury', 'fahim@gmail.com', '2025-05-23 03:51:34', '$2y$12$CBN7sUiJkP3DSv4uEPfcteOMrRHFTH/BWR5GHaFqVopphTCiSoPnS', NULL, '2025-05-23 03:51:34', '2025-05-23 03:51:34'),
(10, 'Tania Sultana', 'tania@gmail.com', '2025-05-23 03:51:34', '$2y$12$D.jKLmxtTNJ70KROv/o77e7GGHgK7kgB.qBoMEANaP6LuziJzVst.', NULL, '2025-05-23 03:51:34', '2025-05-23 03:51:34'),
(11, 'Mamunur Rashid', 'mamun@gmail.com', '2025-05-23 03:51:34', '$2y$12$PDViMbKCysmryYE5.t2c0uCODkJLKhV09F7cKQo/HfDHG6XR0ew86', NULL, '2025-05-23 03:51:34', '2025-05-23 03:51:34');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notes_noteable_type_noteable_id_index` (`noteable_type`,`noteable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_user_id_foreign` (`user_id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_items_sale_id_foreign` (`sale_id`),
  ADD KEY `sale_items_product_id_foreign` (`product_id`);

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
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_items_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
