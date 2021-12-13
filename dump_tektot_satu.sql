-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.18-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for tekno
DROP DATABASE IF EXISTS `tekno`;
CREATE DATABASE IF NOT EXISTS `tekno` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `tekno`;

-- Dumping structure for table tekno.bundles
DROP TABLE IF EXISTS `bundles`;
CREATE TABLE IF NOT EXISTS `bundles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` bigint(20) unsigned NOT NULL,
  `stock` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tags` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tekno.bundles: ~2 rows (approximately)
/*!40000 ALTER TABLE `bundles` DISABLE KEYS */;
INSERT INTO `bundles` (`id`, `uuid`, `name`, `photo`, `description`, `price`, `stock`, `status`, `created_at`, `updated_at`, `tags`) VALUES
	(10, '1510aadf-1dca-4498-9699-9e6815f38b26', 'Hampers Snack Ulang Tahun', 'http://127.0.0.1:8000/storage/bundle_photos/bundle-31510aadf-1dca-4498-9699-9e6815f38b26.jpg', 'Hampers paling cocok untuk kerabat anda yang sedang berulang tahun!', 70000, 10, 'open', '2021-12-05 07:04:19', '2021-12-05 07:04:19', 'promo'),
	(11, 'ca690329-51e1-4e06-941e-95a9ac8dc24e', 'Hampers #1 Limited', 'http://127.0.0.1:8000/storage/bundle_photos/bundle-3ca690329-51e1-4e06-941e-95a9ac8dc24e.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in vulputate libero, sed porttitor quam. Maecenas at erat eget diam dictum sodales in vitae arcu.', 50000, 3, 'open', '2021-12-05 07:07:14', '2021-12-05 07:07:14', '');
/*!40000 ALTER TABLE `bundles` ENABLE KEYS */;

-- Dumping structure for table tekno.bundle_items
DROP TABLE IF EXISTS `bundle_items`;
CREATE TABLE IF NOT EXISTS `bundle_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bundle_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bundle_items_bundle_id_foreign` (`bundle_id`),
  CONSTRAINT `bundle_items_bundle_id_foreign` FOREIGN KEY (`bundle_id`) REFERENCES `bundles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tekno.bundle_items: ~8 rows (approximately)
/*!40000 ALTER TABLE `bundle_items` DISABLE KEYS */;
INSERT INTO `bundle_items` (`id`, `name`, `photo`, `description`, `created_at`, `updated_at`, `bundle_id`) VALUES
	(10, 'Coklat Silverqueen', 'http://127.0.0.1:8000/storage/bundle_item_photos/bundle-item-3fa26e27b-f139-4de4-9b59-d735fa318a3d.jpg', 'Coklat silverqueen med size (x2)', '2021-12-05 07:04:19', '2021-12-05 07:04:19', 10),
	(11, 'Gantungan Kunci Custom', 'http://127.0.0.1:8000/storage/bundle_item_photos/bundle-item-342606f78-cb60-4931-b08a-a925f4cc8ebb.jpg', 'Gantungan Kunci Cutom dengan inisial custom', '2021-12-05 07:04:19', '2021-12-05 07:04:19', 10),
	(12, 'Susu Coklat', 'http://127.0.0.1:8000/storage/bundle_item_photos/bundle-item-340979514-fef1-471f-a8fb-5f91f1192bb8.jpg', 'Susu coklat UHT 250mg (x2)', '2021-12-05 07:04:19', '2021-12-05 07:04:19', 10),
	(13, 'Ciki Ciki', 'http://127.0.0.1:8000/storage/bundle_item_photos/bundle-item-3d0103b13-02ec-4b05-88a8-d6de24056e96.jpg', 'Ciki Coklat Rasa Coklat', '2021-12-05 07:04:19', '2021-12-05 07:04:19', 10),
	(14, 'item pertama', 'http://127.0.0.1:8000/storage/bundle_item_photos/bundle-item-3bc3a3ab9-c310-40f2-8fc2-7f6d8b0fece1.jpg', 'Deskripsi item hampers pertama', '2021-12-05 07:07:14', '2021-12-05 07:07:14', 11),
	(15, 'item kedua', 'http://127.0.0.1:8000/storage/bundle_item_photos/bundle-item-3d50e9703-485b-4567-906c-f6dd7fcac92e.jpg', 'Deskripsi item kedua', '2021-12-05 07:07:14', '2021-12-05 07:07:14', 11),
	(16, 'item ketiga', 'http://127.0.0.1:8000/storage/bundle_item_photos/bundle-item-3c7f3337d-a4dd-47e6-8311-c6f645369b43.jpg', 'Deskripsi item ketiga', '2021-12-05 07:07:14', '2021-12-05 07:07:14', 11),
	(17, 'item keempat', 'http://127.0.0.1:8000/storage/bundle_item_photos/bundle-item-3db7ffbd1-48a2-4340-a675-ad5c4574a69a.jpg', 'Deskripsi item ketiga', '2021-12-05 07:07:14', '2021-12-05 07:07:14', 11);
/*!40000 ALTER TABLE `bundle_items` ENABLE KEYS */;

-- Dumping structure for table tekno.carts
DROP TABLE IF EXISTS `carts`;
CREATE TABLE IF NOT EXISTS `carts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `item_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` bigint(20) unsigned NOT NULL,
  `total_price` bigint(20) unsigned NOT NULL,
  `amount` int(11) NOT NULL,
  `additional_note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carts_user_id_foreign` (`user_id`),
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tekno.carts: ~1 rows (approximately)
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` (`id`, `user_id`, `item_type`, `item_id`, `price`, `total_price`, `amount`, `additional_note`, `created_at`, `updated_at`) VALUES
	(7, 1, 'bundle', '9', 100000, 100000, 1, 'adasdasdasdasd', '2021-10-07 17:09:54', '2021-10-07 17:09:54');
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;

-- Dumping structure for table tekno.failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tekno.failed_jobs: ~0 rows (approximately)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Dumping structure for table tekno.items
DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `price` bigint(20) unsigned NOT NULL,
  `tags` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tekno.items: ~5 rows (approximately)
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` (`id`, `uuid`, `name`, `photo`, `description`, `stock`, `price`, `tags`, `status`, `created_at`, `updated_at`) VALUES
	(1, '56e23b9e-cd77-4330-a587-e014448ba2f6', 'item baru satu edited', 'http://127.0.0.1:8000/storage/item_photos/item-356e23b9e-cd77-4330-a587-e014448ba2f6.PNG', 'deskripsi item satu edited', 251, 10000, NULL, 'open', '2021-11-02 09:01:15', '2021-11-02 15:01:47'),
	(8, '4786448f-125f-4c19-8be5-a65d19907670', 'Gantungan Kunci', 'http://127.0.0.1:8000/storage/item_photos/item-34786448f-125f-4c19-8be5-a65d19907670.jpg', 'Gantungan Kunci Print Custom', 20, 25000, NULL, 'open', '2021-12-05 15:10:46', '2021-12-05 15:10:46'),
	(9, 'a445724d-eb3c-4da4-a966-f4e57b6cbbdc', 'Keycaps Custom (1u)', 'http://127.0.0.1:8000/storage/item_photos/item-3a445724d-eb3c-4da4-a966-f4e57b6cbbdc.jpg', 'Keycapscetak custom ukuran 1u', 16, 20000, NULL, 'open', '2021-12-05 15:12:14', '2021-12-05 15:12:14'),
	(10, '5738d069-22f8-44a5-a562-f70adeabbf96', 'Keycaps Custom (1.25u)', 'http://127.0.0.1:8000/storage/item_photos/item-35738d069-22f8-44a5-a562-f70adeabbf96.jpg', 'Keycapscetak custom ukuran 1.25u', 20, 20000, NULL, 'open', '2021-12-05 15:12:40', '2021-12-05 15:12:40'),
	(11, '33ba8f13-2066-449a-a151-19fd92fadf6d', 'Keycaps Custom (1.5u)', 'http://127.0.0.1:8000/storage/item_photos/item-333ba8f13-2066-449a-a151-19fd92fadf6d.jpg', 'Keycapscetak custom ukuran 1.5u', 20, 25000, NULL, 'open', '2021-12-05 15:13:18', '2021-12-05 15:13:18');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;

-- Dumping structure for table tekno.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tekno.migrations: ~9 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2021_09_19_071032_create_services_table', 2),
	(6, '2021_09_19_071818_create_products_table', 3),
	(7, '2021_10_07_093427_create_bundles_table', 4),
	(8, '2021_10_07_093559_create_bundle_items_table', 4),
	(9, '2021_10_07_132058_add_foreign_bundle_id', 5),
	(10, '2021_10_07_164903_create_carts_table', 6),
	(11, '2021_11_02_074632_create_items_table', 7),
	(12, '2021_11_02_083151_add_tags_column', 8),
	(13, '2021_12_05_085355_add_fixedlink_column', 9);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table tekno.password_resets
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tekno.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table tekno.personal_access_tokens
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tekno.personal_access_tokens: ~0 rows (approximately)
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

-- Dumping structure for table tekno.products
DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` bigint(20) unsigned NOT NULL,
  `stock` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tekno.products: ~0 rows (approximately)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Dumping structure for table tekno.services
DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` bigint(20) unsigned NOT NULL,
  `max_revision` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fixed_link` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tekno.services: ~2 rows (approximately)
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` (`id`, `uuid`, `name`, `photo`, `description`, `price`, `max_revision`, `status`, `created_at`, `updated_at`, `fixed_link`) VALUES
	(3, 'fd490192-92cb-4768-bf40-0e76b3dae1ee', 'Jasa Print 3D', 'http://127.0.0.1:8000/storage/product_photos/3fd490192-92cb-4768-bf40-0e76b3dae1ee.jpg', 'Jasa print model 3D', 500, 1, 'open', '2021-12-05 08:50:00', '2021-12-05 08:50:00', '/print'),
	(4, '3ebebaec-8c69-44ea-8078-3d2840b3321e', 'Buat Hampers Custom!', 'http://127.0.0.1:8000/storage/product_photos/33ebebaec-8c69-44ea-8078-3d2840b3321e.jpg', 'Buat hampers dengan isi sesukamu!', 100, 1, 'open', '2021-12-05 08:51:14', '2021-12-05 08:51:14', '/bundle/custom');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;

-- Dumping structure for table tekno.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tekno.users: ~3 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `is_admin`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'freds the gay', 'fredi@gay.com', NULL, 1, '$2y$10$H1iCk7J/IahekarwITUDqOAtGuF6ohZ4ySu5x6hRo65CAQ2iYQUXe', NULL, '2021-09-19 06:26:19', '2021-09-19 06:26:19'),
	(2, 'Akun Admin', 'admin@gmail.com', NULL, 1, '$2y$10$NImYFfnim2QHxRN4qCNG7e8XNvY2EbDjl73b9NtTWKRG/XX2SC2Fu', NULL, NULL, NULL),
	(3, 'Akun Admin', 'admin@email.com', NULL, 1, '$2y$10$2EdoTSo4Eh0wr4k3iPPi0.r/rnXk8f0tTtciZWnqKF70KxdNih9tu', NULL, NULL, NULL),
	(4, 'Akun Biasa', 'biasa@email.com', NULL, 0, '$2y$10$A8d21iLSYSCb4TrbpTut4ut0Bk.qwKbNkq61X./nZsUpKrASws58W', NULL, NULL, NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
