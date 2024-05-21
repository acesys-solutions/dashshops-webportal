SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `dashshops` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `dashshops`;

CREATE TABLE `ads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` blob NOT NULL,
  `url` varchar(191) NOT NULL,
  `total_clicks` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `modified_by` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ads` (`id`, `image`, `url`, `total_clicks`, `start_date`, `end_date`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 0x313730343133393935342e6a7067, 'https://bankstips.com/gtbank-sort-code-for-lagos-state/', 10, '2024-01-02 00:00:01', '2024-02-28 23:59:59', 2, 2, '2024-01-01 20:12:34', '2024-01-27 10:38:09'),
(2, 0x313730363230303831352e6a7067, 'https://www.pinterest.com/', 16, '2024-01-22 00:00:01', '2024-02-29 23:59:59', 2, 2, '2024-01-25 16:40:15', '2024-01-27 10:40:20'),
(3, 0x313730363230303834352e6a7067, 'https://www.pinterest.com/', 10, '2024-01-18 00:00:01', '2024-02-29 23:59:59', 2, 2, '2024-01-25 16:40:45', '2024-01-27 10:39:15'),
(4, 0x313730363230303839302e6a7067, 'https://www.pinterest.com/', 16, '2024-01-16 00:00:01', '2024-02-29 23:59:59', 2, 2, '2024-01-25 16:41:30', '2024-01-27 10:39:34');

CREATE TABLE `ad_clicks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ad_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `city` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `country` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `app_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `push_notification` tinyint(4) NOT NULL DEFAULT 1,
  `location` tinyint(4) NOT NULL DEFAULT 1,
  `disable_caching` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `app_settings` (`id`, `user_id`, `push_notification`, `location`, `disable_caching`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 0, '2024-04-29 16:54:05', '2024-04-29 16:54:05'),
(2, 2, 1, 1, 0, '2024-04-29 16:54:05', '2024-04-29 16:54:05'),
(3, 4, 1, 1, 0, '2024-04-29 17:28:41', '2024-04-29 17:28:41'),
(4, 15, 1, 1, 0, '2024-05-01 13:48:06', '2024-05-01 13:48:06'),
(5, 8, 1, 1, 0, '2024-05-01 18:16:25', '2024-05-01 18:16:25');

CREATE TABLE `cart` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_variation_id` int(11) NOT NULL,
  `quantity` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `badge` varchar(191) DEFAULT NULL,
  `banner_image` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories` (`id`, `name`, `badge`, `banner_image`, `created_at`, `updated_at`) VALUES
(1, 'Food & Drinks', '1701660679.png', '1701660903.jpg', '2023-11-09 21:15:37', '2023-12-04 02:46:03'),
(2, 'Electronics', '1701661252.png', '1701661252.jpg', '2023-12-04 02:25:26', '2023-12-04 02:40:52'),
(3, 'Health & Beauty', '1701661526.png', '1703174695.jpg', '2023-12-04 02:25:26', '2023-12-21 16:04:55'),
(4, 'Events', '1701661340.png', '1703174847.jpg', '2023-12-04 02:25:26', '2023-12-21 16:07:27'),
(5, 'Sports & Fitness', '1701661324.png', '1703175110.jpg', '2023-12-04 02:25:26', '2023-12-21 16:11:50'),
(6, 'Home & Garden', '1701661367.png', '1703176916.jpg', '2023-12-04 02:25:26', '2023-12-21 16:41:56'),
(7, 'Gifts & Flowers', '1701661405.png', '1703175678.jpg', '2023-12-04 02:25:26', '2023-12-21 16:21:18'),
(8, 'Pet Supplies', '1701661426.png', '1703176582.jpg', '2023-12-04 02:25:26', '2023-12-21 16:36:22'),
(9, 'Toys & Games', '1701661439.png', '1703176237.jpg', '2023-12-04 02:25:26', '2023-12-21 16:30:37'),
(10, 'Baby & Kids', '1702442179.png', '1703616313.jpg', '2023-12-04 02:25:26', '2023-12-26 18:45:13'),
(11, 'Office Supplies', '1701661389.png', '1703176171.jpg', '2023-12-04 02:25:26', '2023-12-21 16:29:31'),
(12, 'Auto & Tires', '1701661473.png', '1703176620.jpg', '2023-12-04 02:25:26', '2023-12-21 16:37:00'),
(13, 'RETAIL', '1704077883.jpg', '1704077909.jpg', '2023-12-04 02:25:26', '2024-01-01 02:58:29'),
(14, 'Clothing', '1701661540.png', '1703176286.jpg', '2023-12-04 02:25:26', '2023-12-21 16:31:26'),
(15, 'Travel', '1701661505.png', '1703176683.jpg', '2023-12-04 02:25:26', '2023-12-21 16:38:03'),
(16, 'Outdoor Activities', '1701661641.png', '1703615557.jpg', '2023-12-04 02:25:26', '2023-12-26 18:33:00'),
(17, 'Bath & Body', '1701661590.png', '1703176307.jpg', '2023-12-04 02:25:26', '2023-12-21 16:31:47'),
(18, 'Accessories', '1701661606.png', '1703175886.jpg', '2023-12-04 02:25:26', '2023-12-21 16:24:46');

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` blob DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `price` double(8,2) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `download_limit` int(11) NOT NULL,
  `retailer_id` int(10) UNSIGNED NOT NULL,
  `retail_price` double(8,2) NOT NULL,
  `discount_now_price` double(8,2) NOT NULL,
  `discount_percentage` varchar(191) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `qr_code` varchar(191) DEFAULT NULL,
  `discount_description` varchar(191) DEFAULT NULL,
  `discount_code` varchar(191) DEFAULT NULL,
  `offer_type` varchar(191) NOT NULL,
  `approval_status` varchar(191) NOT NULL DEFAULT 'New',
  `created_by` int(10) UNSIGNED NOT NULL,
  `modified_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `coupons` (`id`, `image`, `name`, `price`, `category_id`, `download_limit`, `retailer_id`, `retail_price`, `discount_now_price`, `discount_percentage`, `start_date`, `end_date`, `qr_code`, `discount_description`, `discount_code`, `offer_type`, `approval_status`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 0x313731323736313535372e6a7067, 'to the dw', 2280.30, 8, 10, 1, 3455.00, 34.00, 'Discount Percent', '2024-07-12 15:05:57', '2024-05-30 15:05:57', 'c8P7zHd7aIbSkP', 'wefweew', 'oMoz656j', 'Exclusive Offers', 'NEW', 2, 2, NULL, NULL),
(2, 0x313730313737373136312e6a7067, 'Discount iPhone 14 Pro', 679.15, 7, 10, 1, 799.00, 15.00, 'Discount Percent', '2023-12-06 20:25:46', '2024-05-31 20:25:46', '7fppUlFodFQlor', 'The iPhone 15 and 15 Plus start at $799 and offer a good balance between functionality, longevity, and price, but if cost is the major factor for you.', '7rQP2qkH', 'Weekly Offers', 'Approved', 2, 2, NULL, NULL),
(3, 0x313730313737373937362e6a7067, '2023 MacBook Pro Exclusive Offer', 1949.35, 7, 10, 1, 2999.00, 35.00, 'Discount Percent', '2023-12-05 20:25:22', '2024-08-02 20:25:22', 'GSvIWC5UxLS3FT', 'If you’re a creative professional or a hardcore power user, or you simply feel like splurging on the best that Apple has to offer, especially with this discount', 'Z7hNLUmw', 'Exclusive Offers', 'Approved', 2, 2, NULL, NULL),
(4, 0x313730313737383433302e6a7067, 'Sony WH-1000XM5 Wireless Headphones', 0.00, 11, 10, 1, 98.76, 0.00, 'Buy one get free ear pods', '2023-12-05 20:24:11', '2024-06-27 20:24:11', '8g0RmXzXUEk6Y1', 'The Sony WH-1000XM5 is the successor to the WH-1000XM4, and has a refreshed design and improved sound quality and ANC.', 'BlxpEbFo', 'Weekly Offers', 'Approved', 2, 2, NULL, NULL),
(5, 0x313730313737383631322e706e67, 'PS5 gaming Console', 540.00, 24, 10, 1, 900.00, 40.00, 'Discount Percent', '2023-12-05 20:24:36', '2024-07-20 20:24:36', 'YoneuXarl91ed5', 'PS5 consoles have seen a first-time discount. Come take advantage of this offer while stock lasts', '6rPKPWzU', 'Exclusive Offers', 'Approved', 2, 2, NULL, NULL),
(6, 0x313730323337313637352e6a7067, 'test coupon', 43.12, 8, 10, 1, 56.00, 23.00, 'Discount Percent', '2023-12-12 20:25:01', '2024-07-06 20:25:01', 'hVruQ5qvdwKADu', 'test', 'FmhMeHwq', 'Weekly Offers', 'Approved', 2, 2, NULL, NULL);

CREATE TABLE `coupons_clicks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `clicks` int(11) NOT NULL,
  `city` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `coupons_download` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `coupon_code` varchar(191) NOT NULL,
  `downloads` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `coupon_redemption` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `coupon_download_id` int(11) NOT NULL,
  `redemption_code` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `deliveries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sales_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `delivery_fee` double NOT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'Pending',
  `picked_at` datetime DEFAULT NULL,
  `delivered_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `deliveries` (`id`, `sales_id`, `driver_id`, `delivery_fee`, `status`, `picked_at`, `delivered_at`, `created_at`, `updated_at`) VALUES
(1, 1, 8, 2.543333333333333, 'Picked', '2024-05-17 00:36:37', NULL, '2024-05-16 19:23:33', '2024-05-16 23:36:37');

CREATE TABLE `drivers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `approval_status` varchar(191) NOT NULL DEFAULT 'Pending',
  `available` tinyint(1) NOT NULL DEFAULT 0,
  `driver_licence` text DEFAULT NULL,
  `car_reg_details` text DEFAULT NULL,
  `acceptance_rating` text NOT NULL,
  `bank_details` text DEFAULT NULL,
  `hourly_delivery_rate` double NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `current_location` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `drivers` (`id`, `user_id`, `approval_status`, `available`, `driver_licence`, `car_reg_details`, `acceptance_rating`, `bank_details`, `hourly_delivery_rate`, `start_time`, `end_time`, `current_location`, `created_at`, `updated_at`) VALUES
(1, 3, 'Pending', 0, '{\"number\":\"dkajfd38374748\",\"expiry_date\":\"2024-10-02\",\"country\":\"US\",\"front\":\"driver_licence\\/3ZKipMs4QjFrkKo9CWWQ19SAe7l2ZEJCzPrfcyot.png\",\"back\":\"driver_licence\\/u5cSEWNHlNfjqAUERZtYGW8kJRkgnQcXu3TdNbGJ.png\"}', '{\"image\":\"car_registration\\/MXgmD6iRikdxWmIiB40ER2QGH3VcY4OItzwrUBj5.png\",\"model\":\"Toyota\",\"model_type\":\"Corolla\",\"year\":\"2024\",\"color\":\"Red\",\"registration_number\":\"GH-YIU89\",\"date_of_registration\":\"2023-10-25\",\"front\":\"car_registration\\/qEtRqSeh96w3gPKVOcHcYDq9Fezgo40UrfJVdoOs.png\",\"back\":\"car_registration\\/E86yaTbcV9T1egq9B5Lju7HhypycrwleIKT4T6lF.png\"}', '{\"total\":0,\"count\":0}', '{\"beneficiary_name\":\"John Doe\",\"bank_name\":\"Example Bank\",\"account_number\":\"123456789\",\"swift_code\":\"ABCD1234\"}', 10, NULL, NULL, NULL, '2024-04-29 16:54:07', '2024-04-29 17:25:59'),
(8, 15, 'Approved', 0, '{\"number\":\"3YU4I1U2314\",\"expiry_date\":\"2027-05-27T00:00:01.000\",\"country\":\"United States\",\"front\":\"driver_licence\\/Q9IKjI11y64bHaQskThXjpUOPalvzQlUMIQGS1ud.jpg\",\"back\":\"driver_licence\\/UUWbY6asZGWQ1y2U4n0JO1mwQ2G2ABrljB72u35H.jpg\"}', '{\"image\":\"car_registration\\/cQbd1qK0ETRTrz5iDjrX6paP14TmAEfNIPvfufMo.jpg\",\"model\":\"Ford\",\"model_type\":\"Focus\",\"year\":\"2014\",\"color\":\"Blue\",\"registration_number\":\"9JRI205\",\"date_of_registration\":\"2023-04-19\",\"front\":\"car_registration\\/eQJMAMPtFs1IoSr8FQkVgfqbh2gbYuI80cjdXD2j.png\",\"back\":\"car_registration\\/AyeLlBdW6TctLWZu8CC6oDrpSL7Ha9gGbyeyQQ0s.jpg\"}', '{\"total\":5,\"count\":5}', '{\"beneficiary_name\":\"Dexter Paul\",\"bank_name\":\"Bank Of America\",\"account_number\":\"1234567890\",\"swift_code\":\"SD-15263\"}', 12, '01:00:00', '23:00:00', '{\"latitude\":\"6.835942645563591\",\"longitude\":\"3.6267240252379573\",\"bearing\":27.947627893449805,\"city\":\"Sagamu\",\"state\":\"Ogun State\",\"zip\":\"121102\"}', '2024-05-01 13:25:58', '2024-05-16 22:46:08'),
(9, 8, 'Pending', 0, NULL, NULL, '{\"total\":0,\"count\":0}', NULL, 0, NULL, NULL, NULL, '2024-05-09 09:02:53', '2024-05-09 09:02:53'),
(10, 16, 'Approved', 1, '{\"number\":\"YHDK38224\",\"expiry_date\":\"2026-07-29T00:00:01.000\",\"country\":\"United States\",\"front\":\"driver_licence\\/B17C6lsr843i4RWuFKVzK3L8Gq5TVQgvN9LxY0sX.jpg\",\"back\":\"driver_licence\\/7wiP2h6p8Kya2pUMD0MY2DZk3OykIJeADtVYvRU7.jpg\"}', '{\"image\":\"car_registration\\/uNCrcw0Ch7iDjpBwHo9GHuDpnjvt2UdapA89YZHT.jpg\",\"model\":\"Nissan\",\"model_type\":\"Altima\",\"year\":\"2022\",\"color\":\"Grey\",\"registration_number\":\"827UEUS\",\"date_of_registration\":\"2022-05-27\",\"front\":\"car_registration\\/ntY2IylHeonBxba1BP566uNLzA0RfJTltfknAFCs.png\",\"back\":\"car_registration\\/tDFzQ6Xp3E5f5xK6d9YFtTGQTHJ7ixoY12PN93KM.jpg\"}', '{\"total\":0,\"count\":0}', '{\"beneficiary_name\":\"Akin Adeshola\",\"bank_name\":\"Bank Of America\",\"account_number\":\"12345678\",\"swift_code\":\"NABH-2342\"}', 11, '01:00:00', '23:59:00', '{\"latitude\":\"37.785834\",\"longitude\":\"-122.406417\",\"bearing\":-72.84498175495315,\"city\":\"San Francisco\",\"state\":\"California\",\"zip\":\"94102\"}', '2024-05-09 19:45:39', '2024-05-11 14:14:19');

CREATE TABLE `drivers_payouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `status` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `driver_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `driver_id` int(11) NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `source_id` int(11) NOT NULL DEFAULT 0,
  `type` varchar(191) NOT NULL,
  `has_read` tinyint(4) NOT NULL DEFAULT 0,
  `trash` tinyint(4) NOT NULL DEFAULT 0,
  `content` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `driver_notifications` (`id`, `driver_id`, `title`, `source_id`, `type`, `has_read`, `trash`, `content`, `created_at`, `updated_at`) VALUES
(1, 8, 'You have a pending delivery #1715550112', 1, 'sale_order', 0, 0, 'Alexander Fleming has just selected you to help pickup and deliver #1715550112. You can reach the customer via +2347032949789.', '2024-05-12 20:41:55', '2024-05-12 20:41:55'),
(2, 0, 'Order #1715550112. has been delivered', 1, 'Sale Order Delivered', 0, 0, 'PackageLenovo Ideapad 3 15ITL05 Intel Core I5-1135G7 4GB RAM 1TB HDD FreeDos-Platinum Grey (81X8009HUE) from Acesys Solutions has just been confirmed delivered by you. Thank you for using Dash Shop', '2024-05-15 01:08:43', '2024-05-15 01:08:43'),
(3, 0, 'Order #1715550112. has been delivered', 1, 'Sale Order Delivered', 0, 0, 'PackageLenovo Ideapad 3 15ITL05 Intel Core I5-1135G7 4GB RAM 1TB HDD FreeDos-Platinum Grey (81X8009HUE) from Acesys Solutions has just been confirmed delivered by you. Thank you for using Dash Shop', '2024-05-15 01:08:52', '2024-05-15 01:08:52'),
(4, 0, 'Order #1715550112. has been delivered', 1, 'Sale Order Delivered', 0, 0, 'PackageApple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Model from Acesys Solutions has just been confirmed delivered by you. Thank you for using Dash Shop', '2024-05-15 01:12:58', '2024-05-15 01:12:58');

CREATE TABLE `driver_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `driver_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `push_notification` tinyint(4) NOT NULL DEFAULT 1,
  `location` tinyint(4) NOT NULL DEFAULT 1,
  `disable_caching` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `driver_settings` (`id`, `user_id`, `push_notification`, `location`, `disable_caching`, `created_at`, `updated_at`) VALUES
(1, 15, 1, 1, 0, '2024-05-06 18:04:55', '2024-05-16 22:29:00'),
(2, 8, 1, 1, 0, '2024-05-09 09:03:01', '2024-05-09 09:03:01'),
(3, 16, 1, 0, 0, '2024-05-09 19:45:41', '2024-05-09 20:11:01');

CREATE TABLE `driver_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `driver_id` int(11) NOT NULL,
  `token` varchar(191) NOT NULL,
  `device_token` text DEFAULT NULL,
  `device_type` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `driver_tokens` (`id`, `driver_id`, `token`, `device_token`, `device_type`, `created_at`, `updated_at`) VALUES
(5, 8, '$2y$10$vy6RPm57dhR8sacLCtkCJecRi2c1f6Qo5Ev3NH6VI9Y7oyxpVX15K', 'e_LU4fppL0oohxpONe0l31:APA91bEayROS8JMJSlauzWw3NxCfSgH21atThwznQps88fEY7Sr2ZnZr7g2MmrBduhPUzkTtjNKqp5rXyt20l98sojuOIRG2NbpxY88-FbWFvrHTyOU5vzBMv5dKC-XYYpp4tWMDdMPF', 'ios', '2024-05-11 14:58:54', '2024-05-15 18:15:32'),
(6, 8, '$2y$10$tC7xMwz1cOAnai8c7oAGXeGBcCcKFbtxtqUcEcZs3xqvzxnT4YyUG', 'esHLzQnf40A_g_vVdtcH7x:APA91bHbEHxaApb9dGi0KnYFFlmQE8nb9bxjiCFkCoeWW4Hzp9GPe0rJKMr4_vsXFH8XGrTm5Z_0GjIUsm6LPYx3GsDcOCvIbubeHMqPKxeDc9EzUECTwVaLlirMrxm_M0jLAwF9Lx__', 'ios', '2024-05-16 15:41:58', '2024-05-16 15:48:21'),
(7, 8, '$2y$10$G8lxUNwDfbpFhsyBbAHRn.Uw9ur8Q7XN58cboif24oTU37MKszKje', 'fra6cKLrS05dh-yeMQ4F9G:APA91bGqocFDLf_Wr0EWpc8eTYVojaQOTJhK0zBVhbv9DNWeuAq9lrVe5POgL636PnM_efzdEXpt1fpIgxd5Jws13CCHCdjfjhzzthwWioLbHlTgXfYS_bX3D_OD4qEzjA9KeYyyWqps', 'ios', '2024-05-16 16:05:11', '2024-05-16 16:05:53'),
(8, 8, '$2y$10$FkbS9je6URF4kyvJ9F7kNON.2bhh0u0PoDXWqNNzdpRVY8EDof/8i', 'eJlo8oUEQ0zErRQw80Cw0f:APA91bF8OtCPbIITtqnbZ6i59Xg6Rc4Vpopu_OPbGRABTRPvjSLzJL6Vx5BoTnu11PtTJcnxgVlq9nOisOMsLKFwWT6qfzS9l0htymjz6ssnkyP7OvOKcTpMKqXz-oe_uRLOOAFyOTSm', 'ios', '2024-05-16 16:19:11', '2024-05-16 16:19:18'),
(9, 8, '$2y$10$9JDzNAmiG6TG9S3wLr1Q0eiSH3aSfdnDeSNcKDi1gXIU7RkpKXUZO', 'femTIV8MNk4ihLjulm4ED8:APA91bGhrYmr9gSuHSb8nncm-rTTx7V5HWbG5TdqQ_A-hk9ykfJuD0zmWMaO489EzGuhXks3LHRsRi8im33HaoUx707gHEFdEGreX_xmn-SObIHwtuCL8B3YTmNbyXGyq-F7y-Wyri43', 'ios', '2024-05-16 22:26:24', '2024-05-16 22:26:30'),
(10, 8, '$2y$10$ojn5oCRFQ5rbRxwbGNw5h.Si6aCubyFGH4K/vfvhdGUqbzJhKRpom', 'ciPI5sKRGk0GpoWf0v9a0O:APA91bH-4uYCV63NyEsir7flOfEDjEQs6NztkdZcEDjqX4eafbFrYHnFGWqcZA3Cp-YuLvimUdXNJ4Vu-6HDnzHKju7ilMr6xIUlc8fgwDEVL4Oo4haIO8UjhkgOLC5ONkes8GaqGzIl', 'ios', '2024-05-16 22:43:14', '2024-05-16 22:43:22');

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `retailer_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `file_uploads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `filename` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `login_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(191) NOT NULL,
  `device_token` text DEFAULT NULL,
  `device_type` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `login_tokens` (`id`, `user_id`, `token`, `device_token`, `device_type`, `created_at`, `updated_at`) VALUES
(1, 4, '$2y$10$UO4RTui6XWfbvFjZGFqAre.jPDzUOnI0R3GdDuYK90xyNJuJbQFku', 'fpXZZVF9E0LYlM2ADxVyNb:APA91bGEGGBYasxscR8r9-uLE9JOijjRIYqJTdOw-3usdMgvrjD6TU6Cbw6jhVALMUT7p4IsxtIkkIg_81YZseDpOqrCOhno7plnKGJM4-DsE--2LfltxBly57onHBoCsmiHCNKAH1qa', 'ios', '2024-04-29 17:28:40', '2024-05-01 17:38:10'),
(2, 8, '$2y$10$BC32ZvTdudEopdCkUtm6VubQviqE89SPN9ERcyJgBL9Zp8lmg3m8y', 'fpXZZVF9E0LYlM2ADxVyNb:APA91bFdERN2l_CXtDkLBYYzXaM7r5eCJZ4Fm64QWtmP9Wz2JbDmFIeq9TFQOhcCe5bh9m7spS-v4t4zX_ZgMh_5ms8-XXfLRnFD-62TVQcK6RkTY2sjMVAulo8GrxQyEbhc89G4tg76', 'ios', '2024-05-01 18:16:24', '2024-05-12 11:06:00'),
(3, 8, '$2y$10$Sjv1h1v81cZbxP/Z7CjrN.Os4W73qryUnaSctzhAGr6klX/gEVNue', 'd5njemw8KUHXutboCVIfNP:APA91bFiIKYd1d2nte2XNNqIxocTx0NDHu8J6inkfuVQtW5yg8xqP4vz4GnV4XugxwmI8prbmHenSK5L4NmR9Dvw2UBxS8RULyrRwm1oMIsAyemVp8eldjeEy3cRRgZDvy8kbRZH9NzC', 'ios', '2024-05-08 22:48:38', '2024-05-12 10:53:33'),
(4, 8, '$2y$10$r8fruAffFdpKhknLiEYOoug4cfr8TMgBSSlid.OdSczX/Y5T4QU5q', 'e-t-EuFDeUfypsuh3M4_aC:APA91bH-aUOUEjxPheDg2pmT8B8t5NeWsVhbv2_ueIJ0CVWWydq3i4aoWlWXYCJCHQFliXZZ5qnaGYlCbExLGSTey7Y-OIr9STJ65bl3sjj9aEnkTp_I_nlt0T5LWIFOKMCKHS4wJtir', 'ios', '2024-05-09 10:17:56', '2024-05-09 10:18:00'),
(5, 8, '$2y$10$IUkzWlRMqMp5dBfpQsZyze.lKzYinkTow/e5XoPR8BoAudIIztC8O', NULL, NULL, '2024-05-11 11:49:01', '2024-05-11 11:49:01'),
(6, 4, '$2y$10$ydYo/Zd.H.Jrq4qMVLn1bupzq3MiOh3a2WnJgB5pZelbIi2Ok9iBe', 'fpXZZVF9E0LYlM2ADxVyNb:APA91bFdERN2l_CXtDkLBYYzXaM7r5eCJZ4Fm64QWtmP9Wz2JbDmFIeq9TFQOhcCe5bh9m7spS-v4t4zX_ZgMh_5ms8-XXfLRnFD-62TVQcK6RkTY2sjMVAulo8GrxQyEbhc89G4tg76', 'ios', '2024-05-13 03:56:50', '2024-05-13 03:56:54'),
(7, 4, '$2y$10$TlslBqMFKsc9w0mQcAGthuEx32k1oIN6M2Deu2rs9VASsOjDN8V36', NULL, NULL, '2024-05-13 09:37:27', '2024-05-13 09:37:27'),
(8, 8, '$2y$10$Sl.JRdyBDHOyJ1eaS4j6fe5O.DhydOGhb6zXWqi3VImjdWC9U3rMG', 'fpXZZVF9E0LYlM2ADxVyNb:APA91bFQzp9VURZttCBPn-MiKrgfzQDsNgpeZ-Lop_CRirxGKEjFzD2nm58F1C6I6Y6rw20FYCpeJD4SMaHjmefXKmu8_wmPKXFro4FGPx4yRUciexFkspLWa460Qz6TR_ER9ag5ENpc', 'ios', '2024-05-13 12:53:30', '2024-05-14 21:10:32'),
(9, 15, '$2y$10$cCbpFn7KEgJiF745u8cqZ.5WSnxmmmPEevSG3bPE7u9LE5YG4ni3O', NULL, NULL, '2024-05-13 20:43:20', '2024-05-13 20:43:20'),
(10, 15, '$2y$10$a8H/ksbpFxncLT1bSswq9uoaBEg9X6H1NE4V2P8rf4uF4zyz4r1kq', NULL, NULL, '2024-05-14 14:49:24', '2024-05-14 14:49:24'),
(11, 4, '$2y$10$vxloAMDcZ5eEb2MHGViooO/LeWXZv258aRSgBQjEBmMZMC8kM7cPq', NULL, NULL, '2024-05-14 21:38:51', '2024-05-14 21:38:51'),
(12, 15, '$2y$10$S5VeXObzvdQuUqk84vzQ1uA8L59xP8WFnYhz5nyqmJ61QFkci0b.i', NULL, NULL, '2024-05-14 22:04:26', '2024-05-14 22:04:26'),
(13, 4, '$2y$10$B9YX9krMs9/yV0oUNC6DT.THZl8PGPZQquFxCBvIlgCDsCvqHWuO2', NULL, NULL, '2024-05-14 22:26:00', '2024-05-14 22:26:00'),
(14, 8, '$2y$10$FBwdKI29EKNPAz8.GZIy7eT8bqmUxLAuHqMnAAaNl/Ei6PDGnffq6', NULL, NULL, '2024-05-15 00:59:17', '2024-05-15 00:59:17'),
(15, 4, '$2y$10$4nNbCw7MwApMvohBniMlo.6A6LrfZI5G6MJq6.7dry8fMxH3F8FxC', 'fpXZZVF9E0LYlM2ADxVyNb:APA91bHetzvb2Gv17VWp2mXal7BEYBFHzvztBCjuZNAyoGOvr0CYeKoUtDvHJG5f9yufy4IN3GX4naBp_UzaAyYIu5_MOm9wNmHxfYyf-RwJ8rsSnqH78HOa6sh0zS84YeI22YuHm3d6', 'ios', '2024-05-15 05:43:33', '2024-05-16 22:31:40');

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(586, '2014_10_12_000000_create_users_table', 1),
(587, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(588, '2017_06_16_140051_create_nikolag_customers_table', 1),
(589, '2017_06_16_140942_create_nikolag_customer_user_table', 1),
(590, '2017_06_16_140943_create_nikolag_transactions_table', 1),
(591, '2018_02_07_140944_create_nikolag_taxes_table', 1),
(592, '2018_02_07_140945_create_nikolag_discounts_table', 1),
(593, '2018_02_07_140946_create_nikolag_deductible_table', 1),
(594, '2018_02_07_140947_create_nikolag_products_table', 1),
(595, '2018_02_07_140948_create_nikolag_orders_table', 1),
(596, '2018_02_07_140949_create_nikolag_product_order_table', 1),
(597, '2019_08_19_000000_create_failed_jobs_table', 1),
(598, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(599, '2021_01_04_140949_add_scope_nikolag_deductible_table', 1),
(600, '2024_04_21_173204_create_ads_table', 1),
(601, '2024_04_21_173611_create_ad_clicks_table', 1),
(602, '2024_04_21_173907_create_app_settings_table', 1),
(603, '2024_04_21_174320_create_cart_table', 1),
(604, '2024_04_21_174621_create_categories_table', 1),
(605, '2024_04_21_174820_create_coupons_table', 1),
(606, '2024_04_21_175218_create_coupon_clicks_table', 1),
(607, '2024_04_21_175458_create_coupons_download_table', 1),
(608, '2024_04_21_175703_create_coupon_redemption_table', 1),
(609, '2024_04_21_175858_create_favorites_table', 1),
(610, '2024_04_21_180017_create_file_uploads_table', 1),
(611, '2024_04_24_085111_create_login_tokens_table', 1),
(612, '2024_04_24_085341_create_model_has_permissions_table', 1),
(613, '2024_04_24_085556_create_model_has_roles_table', 1),
(614, '2024_04_24_085715_create_notifications_table', 1),
(615, '2024_04_24_085918_create_permissions_table', 1),
(616, '2024_04_24_090121_create_products_table', 1),
(617, '2024_04_24_091120_create_product_favorites_table', 1),
(618, '2024_04_24_091427_create_product_variation_table', 1),
(619, '2024_04_24_091640_create_ratings_table', 1),
(620, '2024_04_24_091817_create_retailers_table', 1),
(621, '2024_04_24_092213_create_roles_table', 1),
(622, '2024_04_24_092344_create_role_has_permissions_table', 1),
(623, '2024_04_24_092623_create_sales_retailers_table', 1),
(624, '2024_04_24_092746_create_states_table', 1),
(625, '2024_04_24_093225_create_vips_table', 1),
(626, '2024_04_26_094706_create_drivers_table', 1),
(627, '2024_04_26_094834_create_deliveries_table', 1),
(628, '2024_04_26_095040_create_tracking_table', 1),
(629, '2024_04_26_095519_create_driver_ratings_table', 1),
(630, '2024_04_26_095637_create_rejected_deliveries_table', 1),
(631, '2024_04_29_174409_add_current_location_to_drivers_table', 2),
(632, '2024_04_29_182352_product_click', 3),
(633, '2024_04_29_184101_change_coupon_clicks_table_to_coupons_clicks', 4),
(634, '2024_04_29_193136_create_sales_table', 4),
(635, '2024_04_29_191524_add_available_column_to_drivers', 5),
(636, '2024_04_30_140136_remove_username_column_from_drivers_table', 5),
(637, '2024_05_06_174120_add_start_end_times_to_drivers_table', 6),
(638, '2024_05_06_175841_add_status_to_deliveries_table', 6),
(639, '2024_05_06_182000_create_driver_settings_table', 6),
(640, '2024_05_09_115342_add_lng_lat_to_user', 7),
(641, '2024_05_07_090725_change_sales_table', 8),
(642, '2024_05_07_091322_create_payments_table', 8),
(643, '2024_05_07_091518_create_retailers_payouts_table', 8),
(644, '2024_05_07_091735_create_drivers_payouts_table', 8),
(645, '2024_05_11_095547_create_sale_orders_table', 9),
(646, '2024_05_11_101000_create_sale_delivery_status_table', 9),
(647, '2024_05_11_103755_create_driver_notifications_table', 9),
(648, '2024_05_11_115356_add_city_state_address_to_sale_orders', 10),
(649, '2024_05_11_115417_remove_city_state_address_from_sales', 10),
(650, '2024_05_11_135541_create_driver_tokens_table', 11),
(651, '2024_05_12_011912_add_product_id_to_sales_table', 12),
(652, '2024_05_12_145740_add_driver_location_to_sale_orders_table', 13),
(653, '2024_05_12_205910_add_time_duration_to_sale_orders_table', 14),
(654, '2024_05_14_051714_add_total_distance_to_sale_orders_table', 15),
(655, '2024_05_14_052318_modify_total_distance_to_sale_orders_table', 16),
(656, '2024_05_14_153033_add_delivery_fee_to_rejected_deliveries_table', 17);

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `nikolag_customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `payment_service_id` varchar(191) DEFAULT NULL,
  `payment_service_type` varchar(25) NOT NULL,
  `first_name` varchar(191) DEFAULT NULL,
  `last_name` varchar(191) DEFAULT NULL,
  `company_name` varchar(191) DEFAULT NULL,
  `nickname` varchar(191) DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `note` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `nikolag_customer_user` (
  `owner_id` varchar(191) NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `nikolag_deductibles` (
  `deductible_type` varchar(191) NOT NULL,
  `deductible_id` bigint(20) UNSIGNED NOT NULL,
  `featurable_type` varchar(191) NOT NULL,
  `featurable_id` bigint(20) UNSIGNED NOT NULL,
  `scope` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `nikolag_discounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `percentage` double(8,2) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `reference_id` varchar(25) DEFAULT NULL,
  `reference_type` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `nikolag_orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `payment_service_id` varchar(191) DEFAULT NULL,
  `payment_service_type` varchar(25) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `nikolag_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `variation_name` varchar(100) DEFAULT NULL,
  `note` varchar(50) DEFAULT NULL,
  `price` double(8,2) NOT NULL,
  `reference_type` varchar(191) DEFAULT NULL,
  `reference_id` varchar(25) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `nikolag_product_order` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `order_id` varchar(25) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `nikolag_taxes` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `type` varchar(191) NOT NULL,
  `percentage` double(8,2) NOT NULL,
  `reference_id` varchar(25) DEFAULT NULL,
  `reference_type` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `nikolag_transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` varchar(50) NOT NULL,
  `amount` varchar(191) NOT NULL,
  `currency` varchar(191) NOT NULL,
  `customer_id` int(10) UNSIGNED DEFAULT NULL,
  `payment_service_id` varchar(191) DEFAULT NULL,
  `payment_service_type` varchar(25) NOT NULL,
  `merchant_id` varchar(191) DEFAULT NULL,
  `order_id` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `source_id` int(11) NOT NULL DEFAULT 0,
  `type` varchar(191) NOT NULL,
  `has_read` tinyint(4) NOT NULL DEFAULT 0,
  `trash` tinyint(4) NOT NULL DEFAULT 0,
  `content` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `notifications` (`id`, `user_id`, `title`, `source_id`, `type`, `has_read`, `trash`, `content`, `created_at`, `updated_at`) VALUES
(1, 8, 'Order #1715550112 Created', 1, 'sale_order', 1, 0, 'Your order with order number 1715550112 has been created successful. Drivery should be made by Dexterx Paul. You can reach him on +2349038606601 concerning your delivery', '2024-05-12 20:41:52', '2024-05-13 12:57:04'),
(2, 8, 'Order #1715550112 Delivery Was Accepted', 1, 'Sale Order', 0, 0, 'Your order delivery request was accepted by the driver. You can open the order to track the status of your delivery. Thanks for using Dash Shops', '2024-05-14 13:34:04', '2024-05-14 13:34:04'),
(3, 8, 'Order #1715550112 Item Pickup Confirmed', 1, 'Sale Order', 0, 0, 'Your package, Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Model, has just been picked up from Acesys Solutions by the driver. You can track the movement from the order page', '2024-05-14 22:43:25', '2024-05-14 22:43:25'),
(4, 4, 'Order #1715550112 Item Pickup Confirmed', 1, 'Retailer Sale', 0, 0, 'The package, Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Model, has just been picked up from your store by the delivery driver. You can track the movement from the order page', '2024-05-14 22:43:26', '2024-05-14 22:43:26'),
(5, 8, 'Order #1715550112. has been delivered', 1, 'Sale Order', 0, 0, 'Your package, Lenovo Ideapad 3 15ITL05 Intel Core I5-1135G7 4GB RAM 1TB HDD FreeDos-Platinum Grey (81X8009HUE), has just been delivered to you fromAcesys Solutions by the driver. Thank you for using Dash Shop', '2024-05-15 01:08:41', '2024-05-15 01:08:41'),
(6, 4, 'Order #1715550112. has been delivered', 1, 'Retail Delivery', 0, 0, 'Package, Lenovo Ideapad 3 15ITL05 Intel Core I5-1135G7 4GB RAM 1TB HDD FreeDos-Platinum Grey (81X8009HUE), has just been delivered to the customer by the driver. Thank you for using Dash Shop', '2024-05-15 01:08:42', '2024-05-15 01:08:42'),
(7, 8, 'Order #1715550112. has been delivered', 1, 'Sale Order', 0, 0, 'Your package, Lenovo Ideapad 3 15ITL05 Intel Core I5-1135G7 4GB RAM 1TB HDD FreeDos-Platinum Grey (81X8009HUE), has just been delivered to you fromAcesys Solutions by the driver. Thank you for using Dash Shop', '2024-05-15 01:08:51', '2024-05-15 01:08:51'),
(8, 4, 'Order #1715550112. has been delivered', 1, 'Retail Delivery', 0, 0, 'Package, Lenovo Ideapad 3 15ITL05 Intel Core I5-1135G7 4GB RAM 1TB HDD FreeDos-Platinum Grey (81X8009HUE), has just been delivered to the customer by the driver. Thank you for using Dash Shop', '2024-05-15 01:08:52', '2024-05-15 01:08:52'),
(9, 8, 'Order #1715550112. has been delivered', 1, 'Sale Order', 0, 0, 'Your package, Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Model, has just been delivered to you fromAcesys Solutions by the driver. Thank you for using Dash Shop', '2024-05-15 01:12:57', '2024-05-15 01:12:57'),
(10, 4, 'Order #1715550112. has been delivered', 1, 'Retail Delivery', 0, 0, 'Package, Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Model, has just been delivered to the customer by the driver. Thank you for using Dash Shop', '2024-05-15 01:12:58', '2024-05-15 01:12:58'),
(11, 8, 'Order #1715550112. Picked up by you', 1, 'Sale Order', 0, 0, 'Your package, Lenovo Ideapad 3 15ITL05 Intel Core I5-1135G7 4GB RAM 1TB HDD FreeDos-Platinum Grey (81X8009HUE), has just been picked up from Acesys Solutions by you. Thank you for using Dash Shop', '2024-05-15 05:19:33', '2024-05-15 05:19:33'),
(12, 4, 'Order #1715550112 Item Pickup Confirmed', 1, 'Retailer Sale Pickup', 0, 0, 'The package, Lenovo Ideapad 3 15ITL05 Intel Core I5-1135G7 4GB RAM 1TB HDD FreeDos-Platinum Grey (81X8009HUE), has just been picked up from your store by the delivery driver. You can track the movement from the order page', '2024-05-15 05:19:35', '2024-05-15 05:19:35'),
(13, 8, 'Order #1715550112. Picked up by you', 1, 'Sale Order', 0, 0, 'Your package, Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Model, has just been picked up from Acesys Solutions by you. Thank you for using Dash Shop', '2024-05-15 05:22:02', '2024-05-15 05:22:02'),
(14, 4, 'Order #1715550112 Item Pickup Confirmed', 1, 'Retailer Sale Pickup', 0, 0, 'The package, Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Model, has just been picked up from your store by the delivery driver. You can track the movement from the order page', '2024-05-15 05:22:02', '2024-05-15 05:22:02'),
(15, 8, 'Order #1715550112 Delivery Was Accepted', 1, 'Sale Order', 0, 0, 'Your order delivery request was accepted by the driver. You can open the order to track the status of your delivery. Thanks for using Dash Shops', '2024-05-16 18:04:59', '2024-05-16 18:04:59'),
(16, 8, 'Order #1715550112 Delivery Was Accepted', 1, 'Sale Order', 0, 0, 'Your order delivery request was accepted by the driver. You can open the order to track the status of your delivery. Thanks for using Dash Shops', '2024-05-16 19:02:49', '2024-05-16 19:02:49'),
(17, 8, 'Order #1715550112 Delivery Was Accepted', 1, 'Sale Order', 0, 0, 'Your order delivery request was accepted by the driver. You can open the order to track the status of your delivery. Thanks for using Dash Shops', '2024-05-16 19:07:35', '2024-05-16 19:07:35'),
(18, 8, 'Order #1715550112 Delivery Was Accepted', 1, 'Sale Order', 0, 0, 'Your order delivery request was accepted by the driver. You can open the order to track the status of your delivery. Thanks for using Dash Shops', '2024-05-16 19:23:33', '2024-05-16 19:23:33'),
(19, 8, 'Order #1715550112 Item Pickup Confirmed', 1, 'Sale Order', 0, 0, 'Your package, Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Model, has just been picked up from Acesys Solutions by the driver. You can track the movement from the order page', '2024-05-16 23:36:36', '2024-05-16 23:36:36'),
(20, 8, 'Order #1715550112 Item Pickup Confirmed', 1, 'Sale Order', 0, 0, 'Your package, Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Model, has just been picked up from Acesys Solutions by the driver. You can track the movement from the order page', '2024-05-16 23:36:36', '2024-05-16 23:36:36'),
(21, 8, 'Order #1715550112 Item Pickup Confirmed', 1, 'Sale Order', 0, 0, 'Your package, Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Model, has just been picked up from Acesys Solutions by the driver. You can track the movement from the order page', '2024-05-16 23:36:36', '2024-05-16 23:36:36'),
(22, 8, 'Order #1715550112 Item Pickup Confirmed', 1, 'Sale Order', 0, 0, 'Your package, Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Model, has just been picked up from Acesys Solutions by the driver. You can track the movement from the order page', '2024-05-16 23:36:36', '2024-05-16 23:36:36'),
(23, 8, 'Order #1715550112 Item Pickup Confirmed', 1, 'Sale Order', 0, 0, 'Your package, Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Model, has just been picked up from Acesys Solutions by the driver. You can track the movement from the order page', '2024-05-16 23:36:36', '2024-05-16 23:36:36'),
(24, 4, 'Order #1715550112 Item Pickup Confirmed', 1, 'Retailer Sale', 0, 0, 'The package, Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Model, has just been picked up from your store by the delivery driver. You can track the movement from the order page', '2024-05-16 23:36:37', '2024-05-16 23:36:37'),
(25, 4, 'Order #1715550112 Item Pickup Confirmed', 1, 'Retailer Sale', 0, 0, 'The package, Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Model, has just been picked up from your store by the delivery driver. You can track the movement from the order page', '2024-05-16 23:36:37', '2024-05-16 23:36:37'),
(26, 4, 'Order #1715550112 Item Pickup Confirmed', 1, 'Retailer Sale', 0, 0, 'The package, Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Model, has just been picked up from your store by the delivery driver. You can track the movement from the order page', '2024-05-16 23:36:37', '2024-05-16 23:36:37'),
(27, 4, 'Order #1715550112 Item Pickup Confirmed', 1, 'Retailer Sale', 0, 0, 'The package, Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Model, has just been picked up from your store by the delivery driver. You can track the movement from the order page', '2024-05-16 23:36:37', '2024-05-16 23:36:37'),
(28, 4, 'Order #1715550112 Item Pickup Confirmed', 1, 'Retailer Sale', 0, 0, 'The package, Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Model, has just been picked up from your store by the delivery driver. You can track the movement from the order page', '2024-05-16 23:36:37', '2024-05-16 23:36:37'),
(29, 8, 'Order #1715550112. Driver is now enroute to you', 1, 'Sale Order', 0, 0, 'Your package, Lenovo Ideapad 3 15ITL05 Intel Core I5-1135G7 4GB RAM 1TB HDD FreeDos-Platinum Grey (81X8009HUE), has just been picked up from Acesys Solutions by the driver and is on its way to you. You can track the move from the order page', '2024-05-16 23:42:24', '2024-05-16 23:42:24'),
(30, 8, 'Order #1715550112. Driver is now enroute to you', 1, 'Sale Order', 0, 0, 'Your package, Lenovo Ideapad 3 15ITL05 Intel Core I5-1135G7 4GB RAM 1TB HDD FreeDos-Platinum Grey (81X8009HUE), has just been picked up from Acesys Solutions by the driver and is on its way to you. You can track the move from the order page', '2024-05-16 23:42:24', '2024-05-16 23:42:24'),
(31, 4, 'Order #1715550112 Item Pickup Confirmed', 1, 'Retailer Sale', 0, 0, 'The package, Lenovo Ideapad 3 15ITL05 Intel Core I5-1135G7 4GB RAM 1TB HDD FreeDos-Platinum Grey (81X8009HUE), has just been picked up from your store by the delivery driver. You can track the movement from the order page', '2024-05-16 23:42:24', '2024-05-16 23:42:24'),
(32, 4, 'Order #1715550112 Item Pickup Confirmed', 1, 'Retailer Sale', 0, 0, 'The package, Lenovo Ideapad 3 15ITL05 Intel Core I5-1135G7 4GB RAM 1TB HDD FreeDos-Platinum Grey (81X8009HUE), has just been picked up from your store by the delivery driver. You can track the movement from the order page', '2024-05-16 23:42:24', '2024-05-16 23:42:24');

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `retailers_total` decimal(8,2) NOT NULL,
  `drivers_total` decimal(8,2) NOT NULL,
  `total_service_charge` decimal(8,2) NOT NULL,
  `payment_method` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 3, 'API TOKEN', 'add789df558e0589097f41b922f2ca607c7cc4a523987a7de6cc6e7b256e16cc', '[\"*\"]', NULL, NULL, '2024-04-29 16:54:07', '2024-04-29 16:54:07'),
(2, 'App\\Models\\User', 3, 'API TOKEN', 'e1ded7a02ad2783182556ee220ccd860057bddcf9594e28dc97b8d8e7f9c298c', '[\"*\"]', '2024-04-29 17:26:13', NULL, '2024-04-29 16:54:10', '2024-04-29 17:26:13'),
(3, 'App\\Models\\User', 4, 'API TOKEN', 'fd87ecfe4d138fd2a339df99b4783939f2b5d6e34e7f15d6c76789f1ca0d37ec', '[\"*\"]', '2024-05-01 17:38:10', NULL, '2024-04-29 17:28:39', '2024-05-01 17:38:10'),
(4, 'App\\Models\\User', 9, 'API TOKEN', '14cbbad55af221653f8a621c9730406dead6970066b61dfda89c3c30bb2dc5fd', '[\"*\"]', NULL, NULL, '2024-05-01 13:15:30', '2024-05-01 13:15:30'),
(5, 'App\\Models\\User', 10, 'API TOKEN', '841ad989b7d7c2decd43dfd717aac68025ce639fa02f967dc33354d0c53fa864', '[\"*\"]', NULL, NULL, '2024-05-01 13:18:37', '2024-05-01 13:18:37'),
(6, 'App\\Models\\User', 11, 'API TOKEN', '10d5f9fd2c168518a3987fc178556c6caf8178d2771310e3cedb7a3ed5f9bb38', '[\"*\"]', NULL, NULL, '2024-05-01 13:19:36', '2024-05-01 13:19:36'),
(7, 'App\\Models\\User', 12, 'API TOKEN', '4233a984cee9a8db266cbfaec2431c0d0e42dcb5f1480ed81727cd6f0f13209e', '[\"*\"]', NULL, NULL, '2024-05-01 13:22:14', '2024-05-01 13:22:14'),
(8, 'App\\Models\\User', 13, 'API TOKEN', '56d838cfcbb520301b2cec80464c6a3f832103ee5a9c1223db9d29b60c433612', '[\"*\"]', NULL, NULL, '2024-05-01 13:23:54', '2024-05-01 13:23:54'),
(9, 'App\\Models\\User', 14, 'API TOKEN', 'b3158f50da22207375f2743a856a6699ab8db65bb82b26e9bb7fec0ba5909ced', '[\"*\"]', NULL, NULL, '2024-05-01 13:25:33', '2024-05-01 13:25:33'),
(10, 'App\\Models\\User', 15, 'API TOKEN', '30b44ca8b9e9079d0596a2ced270a83a6a4179eca8d29b76e0de5d8edce315dc', '[\"*\"]', '2024-05-01 13:48:06', NULL, '2024-05-01 13:25:58', '2024-05-01 13:48:06'),
(11, 'App\\Models\\User', 15, 'API TOKEN', '609d11abcdb6e1f60f6a5e9c4d1ee987714ff323ebb493b61ed3a6f2fcaee6d3', '[\"*\"]', '2024-05-01 13:59:39', NULL, '2024-05-01 13:59:39', '2024-05-01 13:59:39'),
(12, 'App\\Models\\User', 8, 'API TOKEN', 'ac02545c744bcad80a8c807953dd6bd8b6bd33ea0d32ef0db7ff3f5c35fb8a45', '[\"*\"]', '2024-05-12 22:05:20', NULL, '2024-05-01 18:16:24', '2024-05-12 22:05:20'),
(13, 'App\\Models\\User', 15, 'API TOKEN', '5fa561de3418f37187d34717b277fd2031b1c59d9e88b46f0a3400df6017f9c5', '[\"*\"]', NULL, NULL, '2024-05-05 13:55:33', '2024-05-05 13:55:33'),
(14, 'App\\Models\\User', 15, 'API TOKEN', 'a87605f39651c98c585dc9db2c3ac44e02ede38f10711096296fa1ca02aa037a', '[\"*\"]', NULL, NULL, '2024-05-05 13:57:50', '2024-05-05 13:57:50'),
(15, 'App\\Models\\User', 15, 'API TOKEN', 'fcb8426531e2d4660f098071e3fbe427ac80d26b03cce9bdbf672442e3e7126c', '[\"*\"]', '2024-05-07 15:16:24', NULL, '2024-05-05 13:58:46', '2024-05-07 15:16:24'),
(16, 'App\\Models\\User', 15, 'API TOKEN', 'a9a2d4910902d40ebb6fd430dd1ac90d19dfefca8f407e660c1505ceca9e954b', '[\"*\"]', '2024-05-08 22:18:46', NULL, '2024-05-07 18:10:32', '2024-05-08 22:18:46'),
(17, 'App\\Models\\User', 8, 'API TOKEN', 'a034b72945c369711a0cfe06c72306f2e7d3cfd35e2474bbbdf0975f70cbe245', '[\"*\"]', '2024-05-12 10:53:32', NULL, '2024-05-08 22:48:37', '2024-05-12 10:53:32'),
(18, 'App\\Models\\User', 15, 'API TOKEN', 'a93c8dd2205990e4e027d5a6cab76d9dceef1163d310bca4096d72f9cc538ac3', '[\"*\"]', '2024-05-09 07:51:54', NULL, '2024-05-09 07:46:12', '2024-05-09 07:51:54'),
(19, 'App\\Models\\User', 8, 'API TOKEN', '6182c3f5760a4dbe997c6cf78022543c517105eb96f5344365fa51dbc7f8d129', '[\"*\"]', NULL, NULL, '2024-05-09 08:42:34', '2024-05-09 08:42:34'),
(20, 'App\\Models\\User', 8, 'API TOKEN', '228d4e16f5f4566ebaa78347f030f2ef340bc17cda4803578e22cd367e4360c4', '[\"*\"]', '2024-05-09 09:03:01', NULL, '2024-05-09 09:02:53', '2024-05-09 09:03:01'),
(21, 'App\\Models\\User', 8, 'API TOKEN', 'c93ad7317b6c8813991c3b3feea0dea00c9a8e5e6c817ab6e284663e2ae8d2e1', '[\"*\"]', '2024-05-09 10:20:04', NULL, '2024-05-09 09:53:16', '2024-05-09 10:20:04'),
(22, 'App\\Models\\User', 8, 'API TOKEN', 'c76df50b614b076fdec0b9db446b722a20ca0bf5979fb0b4cf13ad4cc19314ab', '[\"*\"]', '2024-05-09 10:18:51', NULL, '2024-05-09 10:17:56', '2024-05-09 10:18:51'),
(23, 'App\\Models\\User', 15, 'API TOKEN', '04c392783a57c54123374db12304baaed3f67f92fb88d4e17f39760d2b65ab56', '[\"*\"]', '2024-05-09 19:43:19', NULL, '2024-05-09 10:42:07', '2024-05-09 19:43:19'),
(24, 'App\\Models\\User', 16, 'API TOKEN', '3d5c47c73f21324e6d9a7084f972ce6a5f1da6bcd969d6541d9eb8e38060b930', '[\"*\"]', '2024-05-11 14:31:31', NULL, '2024-05-09 19:45:39', '2024-05-11 14:31:31'),
(25, 'App\\Models\\User', 8, 'API TOKEN', '05e8aacd4c84103843aa4a0831c6b95aa4a7df0d387266febb7ab1919e5c24c1', '[\"*\"]', '2024-05-13 09:36:50', NULL, '2024-05-11 11:49:00', '2024-05-13 09:36:50'),
(26, 'App\\Models\\User', 15, 'API TOKEN', '1d4712315e878d6418ad9a9e2236bd6b65933fc8ce11807e42a344ad687bc786', '[\"*\"]', '2024-05-11 14:32:16', NULL, '2024-05-11 14:32:12', '2024-05-11 14:32:16'),
(27, 'App\\Models\\User', 15, 'API TOKEN', 'af75738f73dbff67f669f9cdd7b30dc99dd9f02b157c7edb5da4dad88b7720f5', '[\"*\"]', '2024-05-11 14:42:25', NULL, '2024-05-11 14:42:21', '2024-05-11 14:42:25'),
(28, 'App\\Models\\User', 15, 'API TOKEN', '16fcef6d00110f3db6f9c81890f25d587cb98882c868f84c3ca0ae34f6084b9f', '[\"*\"]', '2024-05-11 14:51:12', NULL, '2024-05-11 14:51:10', '2024-05-11 14:51:12'),
(29, 'App\\Models\\User', 15, 'API TOKEN', 'f7023b1f81f0c05231a48581bfd838577c202a7daf49412825ace836ca5ac221', '[\"*\"]', '2024-05-11 14:55:23', NULL, '2024-05-11 14:55:02', '2024-05-11 14:55:23'),
(30, 'App\\Models\\User', 15, 'API TOKEN', '1c6f0eccf818450ea05a0bfd28ab67c66602528ea6a6a4b0d1e05a0665fdb6d7', '[\"*\"]', '2024-05-16 15:36:27', NULL, '2024-05-11 14:58:53', '2024-05-16 15:36:27'),
(31, 'App\\Models\\User', 4, 'API TOKEN', 'cf3314334916ad6c04962b5d74e9a9a4f5d903cf4ee6319798ce24e244a35efb', '[\"*\"]', '2024-05-13 12:51:47', NULL, '2024-05-13 03:56:50', '2024-05-13 12:51:47'),
(32, 'App\\Models\\User', 4, 'API TOKEN', 'f540e2ef399521c5c56e6a0a9ccefcf49be8fb3398c62dbf766e6cfc6c27a626', '[\"*\"]', '2024-05-13 09:56:40', NULL, '2024-05-13 09:37:26', '2024-05-13 09:56:40'),
(33, 'App\\Models\\User', 8, 'API TOKEN', '1ada5d1f9d99a6fc5f4af50f8231c50fe4f017fe9abb5adc7dfdca5db302bde5', '[\"*\"]', '2024-05-15 05:43:02', NULL, '2024-05-13 12:53:30', '2024-05-15 05:43:02'),
(34, 'App\\Models\\User', 15, 'API TOKEN', 'f9314bfd8725c4ac2df6b40633d433c4cc83e46584d8128956615bab76584eda', '[\"*\"]', '2024-05-13 20:45:02', NULL, '2024-05-13 20:43:20', '2024-05-13 20:45:02'),
(35, 'App\\Models\\User', 15, 'API TOKEN', '250d76afa7acc80e7bdf012dfa8108e4a21a819eedd7159fddec0b4582585722', '[\"*\"]', '2024-05-14 21:37:14', NULL, '2024-05-14 14:49:24', '2024-05-14 21:37:14'),
(36, 'App\\Models\\User', 4, 'API TOKEN', '5bd7f759a17bdc0168d472c8f9ab3c5aaad359db74b162149075afce411db677', '[\"*\"]', '2024-05-14 22:04:11', NULL, '2024-05-14 21:38:51', '2024-05-14 22:04:11'),
(37, 'App\\Models\\User', 15, 'API TOKEN', 'b0c0cb581b2611cf24bdc64a5bb759074781af6cc0c7462c9f904596a7cbe12c', '[\"*\"]', '2024-05-15 01:12:17', NULL, '2024-05-14 22:04:26', '2024-05-15 01:12:17'),
(38, 'App\\Models\\User', 4, 'API TOKEN', '16bb0a38405969307406f662f2394f025a8e566ac8ba99e9b48999addee5184d', '[\"*\"]', '2024-05-15 05:21:06', NULL, '2024-05-14 22:26:00', '2024-05-15 05:21:06'),
(39, 'App\\Models\\User', 8, 'API TOKEN', 'cd3ddb89dcb32251526f67fa713685f4229fff28040cfb060bda9c4f51095307', '[\"*\"]', '2024-05-15 05:22:02', NULL, '2024-05-15 00:59:17', '2024-05-15 05:22:02'),
(40, 'App\\Models\\User', 4, 'API TOKEN', '613d7c67c8a10e104db3144bc0be6d8dfd6ba0267c7e391353cea92b025f4608', '[\"*\"]', '2024-05-16 23:43:38', NULL, '2024-05-15 05:43:33', '2024-05-16 23:43:38'),
(41, 'App\\Models\\User', 15, 'API TOKEN', '3eb1cd6c1008e4474dd8d9f539254ec38a6b9125447144b4bdcc252cebcc46bf', '[\"*\"]', '2024-05-16 16:00:20', NULL, '2024-05-16 15:41:58', '2024-05-16 16:00:20'),
(42, 'App\\Models\\User', 15, 'API TOKEN', '6d6b3f64e1d26b99c1275c8c3e2e8dba0df6bc7a64f58260f622b85b9c5ae438', '[\"*\"]', '2024-05-16 16:13:45', NULL, '2024-05-16 16:05:11', '2024-05-16 16:13:45'),
(43, 'App\\Models\\User', 15, 'API TOKEN', '4e5b8fbf0e4c8aceed94af2e25c0b68a441dd059290e9914763948a5a3b89315', '[\"*\"]', '2024-05-16 21:49:15', NULL, '2024-05-16 16:19:11', '2024-05-16 21:49:15'),
(44, 'App\\Models\\User', 15, 'API TOKEN', '5ee4dac449c89b8c3d3e7531fd2215f1978b103de1f3c95d99724aba1ec39854', '[\"*\"]', '2024-05-16 22:35:29', NULL, '2024-05-16 22:26:24', '2024-05-16 22:35:29'),
(45, 'App\\Models\\User', 15, 'API TOKEN', '1bf77438a5bf26c799383e4de2cf691defe212a71b7e9364f04dceb5d0951a78', '[\"*\"]', '2024-05-16 23:44:30', NULL, '2024-05-16 22:43:14', '2024-05-16 23:44:30');

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_name` text NOT NULL,
  `alias` varchar(250) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `images` longtext DEFAULT NULL,
  `store_id` int(11) NOT NULL,
  `description` longtext DEFAULT NULL,
  `overview` text DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `waranty` varchar(191) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT -1,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `products` (`id`, `product_name`, `alias`, `image`, `images`, `store_id`, `description`, `overview`, `tags`, `waranty`, `status`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Asus X415JA-BV192T 14\" HD Intel® Core™ I3-1005G1 4GB RAM 1TB HDD Win10- Transparent Silver', 'asus-x415ja-bv192t-14\"-hd-intel®-core™-i3-1005g1-4gb-ram-1tb-hdd-win10--transparent-silver_1', 'products/1/hotlink-ok/main.png', '[\"products\\/1\\/hotlink-ok\\/0.png\",\"products\\/1\\/hotlink-ok\\/1.png\",\"products\\/1\\/hotlink-ok\\/2.png\",\"products\\/1\\/hotlink-ok\\/3.png\",\"products\\/1\\/hotlink-ok\\/4.png\"]', 1, '<figure class=\"table\"><table><tbody><tr><td>Wireless</td><td>WiFi 802.11 bgn, Bluetooth</td></tr><tr><td>USB Ports</td><td>3</td></tr><tr><td>Battery</td><td>3 CELL Battery</td></tr><tr><td>Graphics Processor</td><td>Intel Integrated Graphics</td></tr><tr><td>Brand</td><td><a href=\"https://www.konga.com/brand/asus\">Asus</a></td></tr><tr><td>Screen size</td><td>14 inches</td></tr><tr><td>Resolution (Display)</td><td>1366 x 768</td></tr><tr><td>RAM</td><td>4 GB</td></tr><tr><td>Hard Drive</td><td>1 TB</td></tr><tr><td>Number of Cores</td><td>2 Cores</td></tr><tr><td>Storage Type</td><td>HDD</td></tr><tr><td>Display Technology</td><td>Not Specified</td></tr><tr><td>Warranty Period</td><td>1 Year</td></tr><tr><td>Colour</td><td>Silver</td></tr></tbody></table></figure><p>Asus Laptop Series | 14″ HD (1366×768) | Number Pad |Intel® Core™ i3-1005G1 Processor|4GB DDR4 (on board) |1TB HDD |Intel® UHD Graphics | VGA webcam | UK Keyboard | Windows 10 || Transparent Silver&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><h2>DESCRIPTION</h2><p>&nbsp;</p><p>Asus Laptop Series<br>14″ HD (1366×768)<br>Number Pad<br>Intel® Core™ i3-1005G1 Processor<br>4GB DDR4 (on board)<br>1TB HDD<br>Intel® UHD Graphics<br>VGA webcam<br>UK Keyboard<br>Windows 10<br>Transparent Silver</p>', 'Asus Laptop Series | 14″ HD (1366×768) | Number Pad |Intel® Core™ i3-1005G1 Processor|4GB DDR4 (on board) |1TB HDD |Intel® UHD Graphics | VGA webcam | UK Keyboard | Windows 10 ||', 'laptops,notebooks,asus', '1 Year', 1, 2, NULL, NULL),
(2, 'Lenovo Ideapad 3 15ITL05 Intel Core I5-1135G7 4GB RAM 1TB HDD FreeDos-Platinum Grey (81X8009HUE)', 'lenovo-ideapad-3-15itl05-intel-core-i5-1135g7-4gb-ram-1tb-hdd-freedos-platinum-grey-(81x8009hue)_2', 'products/2/hotlink-ok/main.png', '[\"products\\/2\\/hotlink-ok\\/0.png\",\"products\\/2\\/hotlink-ok\\/1.png\",\"products\\/2\\/hotlink-ok\\/2.png\"]', 1, '<figure class=\"table\"><table><tbody><tr><td>Storage Type</td><td>HDD</td></tr><tr><td>Display Technology</td><td>Not Specified</td></tr><tr><td>Number of Cores</td><td>4 Cores</td></tr><tr><td>Resolution (Display)</td><td>1920 x 1080</td></tr><tr><td>RAM</td><td>4 GB</td></tr><tr><td>Hard Drive</td><td>1 TB</td></tr><tr><td>Wireless</td><td>WiFi 802.11 bgn, Bluetooth</td></tr><tr><td>USB Ports</td><td>3</td></tr><tr><td>Battery</td><td>65W AC power adapter</td></tr><tr><td>Graphics Processor</td><td>Intel Integrated Graphics</td></tr><tr><td>Brand</td><td><a href=\"https://www.konga.com/brand/lenovo\">Lenovo</a></td></tr><tr><td>Screen size</td><td>15.6 inches</td></tr><tr><td>Warranty Period</td><td>1 Year</td></tr><tr><td>Colour</td><td>Grey</td></tr></tbody></table></figure><p><strong>PERFORMANCE</strong><br>Processor&nbsp;<br>Intel Core i5-1135G7 (4C / 8T, 2.4 / 4.2GHz, 8MB)<br>Graphics&nbsp;<br>Integrated Intel Iris Xe Graphics functions as UHD Graphics<br>Chipset&nbsp;<br>Intel SoC Platform<br>Memory&nbsp;<br>4GB Soldered DDR4-2666<br>Memory Slots&nbsp;<br>One memory soldered to systemboard, one DDR4 SO-DIMM slot, dual-channel capable<br>Max Memory&nbsp;<br>Up to 12GB (4GB soldered + 8GB SO-DIMM) DDR4-2666 offering<br>Storage&nbsp;<br>1TB HDD 5400rpm 2.5\"<br>Storage Support&nbsp;<br>Up to two drives, 1x 2.5\" HDD + 1x M.2 2242/2280 SSD<br>• 2.5\" HDD up to 1TB<br>• M.2 2242 SSD up to 512GB<br>• M.2 2280 SSD up to 1TB<br>Card Reader&nbsp;<br>4-in-1 Card Reader<br>Optical&nbsp;<br>None<br>Audio Chip&nbsp;<br>High Definition (HD) Audio<br>Speakers&nbsp;<br>Stereo speakers, 1.5W x2, Dolby Audio<br>Camera&nbsp;<br>0.3MP with Privacy Shutter<br>Microphone&nbsp;<br>2x, Array<br>Battery&nbsp;<br>Integrated 35Wh<br>Max Battery Life&nbsp;<br>MobileMark 2014: 5.5 hr (35Wh)<br>Power Adapter&nbsp;<br>65W Round Tip Wall-mount<br>DESIGN<br>Display&nbsp;<br>15.6\" FHD (1920x1080) TN 220nits Anti-glare<br>Touchscreen&nbsp;<br>None<br>Keyboard&nbsp;<br>Non-backlit, English (UK)<br>Case Color&nbsp;<br>Platinum Grey<br>Surface Treatment&nbsp;<br>IMR<br>Case Material&nbsp;<br>PC + ABS (Top), PC + ABS (Bottom)<br>Dimensions (WxDxH)&nbsp;<br>362.2 x 253.4 x 19.9 mm (14.26 x 9.98 x 0.78 inches)<br>Weight&nbsp;<br>1.7 kg (3.75 lbs)<br>SOFTWARE<br>Operating System&nbsp;<br>None<br>Bundled Software&nbsp;<br>None<br>CONNECTIVITY<br>Ethernet&nbsp;<br>None<br>WLAN + Bluetooth&nbsp;<br>11ac, 2x2 + BT5.0<br>Standard Ports&nbsp;<br>1x card reader<br>1x headphone / microphone combo jack (3.5mm)<br>2x USB 3.2 Gen 1<br>1x power connector<br>1x USB 2.0<br>1x HDMI 1.4</p>', 'Processor Intel Core i5-1135G7 (4C / 8T, 2.4 / 4.2GHz, 8MB) Graphics Integrated Intel Iris Xe Graphics functions as UHD Graphics Chipset Intel SoC Platform Memory 4GB Soldered DDR4-2666 Memory Slots O', 'lenovo,laptop', '1 Year', 1, 2, NULL, NULL),
(3, 'Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Model', 'Apple-Macbook-Pro-With-Apple-M1-Chip--13\'\'--8GB-RAM---512GB-SSD-Storage---Space-Grey---Latest-Model_3', 'products/3/hotlink-ok/main.png', '[\"products\\/3\\/hotlink-ok\\/0.png\",\"products\\/3\\/hotlink-ok\\/1.png\"]', 1, '<figure class=\"table\"><table><tbody><tr><td>Activity</td><td>Personal h</td></tr><tr><td>Resolution (Display)</td><td>-</td></tr><tr><td>RAM</td><td>8 GB</td></tr><tr><td>Hard Drive</td><td>256 GB</td></tr><tr><td>Graphics</td><td>VGA</td></tr><tr><td>Wireless</td><td>-</td></tr><tr><td>USB Ports</td><td>-</td></tr><tr><td>Battery</td><td>-</td></tr><tr><td>Operating System</td><td>Mac OS</td></tr><tr><td>Graphics Processor</td><td>Intel Integrated Graphics</td></tr><tr><td>Brand</td><td><a href=\"https://www.konga.com/brand/apple\">Apple</a></td></tr><tr><td>Screen size</td><td>13 inches</td></tr><tr><td>Display Technology</td><td>Not Specified</td></tr><tr><td>Number of Cores</td><td>8 Cores</td></tr><tr><td>Storage Type</td><td>SSD</td></tr><tr><td>Warranty Period</td><td>1 Year</td></tr><tr><td>Colour</td><td>Grey</td></tr></tbody></table></figure><ul><li>Apple M1 8-Core CPU</li><li>8GB Unified RAM | 512GB SSD</li><li>13.3\" 2560 x 1600 IPS Retina Display</li><li>8-Core GPU | 16-Core Neural Engine</li><li>P3 Color Gamut | True Tone Technology</li><li>Wi-Fi 6 (802.11ax) | Bluetooth 5.0</li><li>Touch Bar | Touch ID Sensor</li><li>2 x Thunderbolt 3 / USB4 Ports</li><li>Magic Keyboard | Force Touch Trackpad</li><li>macOS</li></ul><figure class=\"table\"><table><tbody><tr><td>Operating System</td><td>macOS</td></tr><tr><td>Model Year</td><td>Late 2020</td></tr></tbody></table></figure><p>Performance</p><figure class=\"table\"><table><tbody><tr><td>Chipset</td><td>Apple M1</td></tr><tr><td>CPU</td><td>Octa-Core</td></tr><tr><td>Memory Type</td><td>Embedded DRAM</td></tr><tr><td>Total Installed Memory</td><td>8 GB</td></tr><tr><td>Memory Configuration</td><td>8 GB (Onboard)</td></tr><tr><td>Graphics Type</td><td>Integrated</td></tr><tr><td>GPU</td><td>Apple (8Core)</td></tr></tbody></table></figure><p>Display</p><figure class=\"table\"><table><tbody><tr><td>Panel Type</td><td>IPS-Type LCD</td></tr><tr><td>Size</td><td>13.3\"</td></tr><tr><td>Aspect Ratio</td><td>16:10</td></tr><tr><td>Resolution</td><td>2560 x 1600</td></tr><tr><td>Touchscreen</td><td>No</td></tr><tr><td>Finish</td><td>Glossy</td></tr><tr><td>Maximum Brightness</td><td>500 cd/m2</td></tr><tr><td>Color Gamut</td><td>100% DCI-P3</td></tr></tbody></table></figure><p>Storage and Expansion</p><figure class=\"table\"><table><tbody><tr><td>Total Installed Capacity</td><td>512 GB</td></tr><tr><td>Solid State Storage</td><td>1 x&nbsp;512 GB Integrated PCIe</td></tr></tbody></table></figure><p>I/O</p><figure class=\"table\"><table><tbody><tr><td>USB Type-C Ports</td><td>2 x&nbsp;Thunderbolt 3 / USB4</td></tr><tr><td>Audio</td><td>1 x&nbsp;1/8\" / 3.5 mm Headphone Output</td></tr><tr><td>Built-In Speakers</td><td>Yes</td></tr><tr><td>Built-In Microphones</td><td>Yes</td></tr><tr><td>Media/Memory Card Slot</td><td><i>None</i></td></tr></tbody></table></figure><p>Communications</p><figure class=\"table\"><table><tbody><tr><td>Ethernet</td><td><i>None</i></td></tr><tr><td>Wi-Fi</td><td>Wi-Fi 6 (802.11ax)</td></tr><tr><td>MU-MIMO Support</td><td>Yes</td></tr><tr><td>Bluetooth</td><td>5.0</td></tr><tr><td>GPS</td><td><i>None</i></td></tr><tr><td>NFC</td><td>No</td></tr><tr><td>Webcam</td><td>User-Facing: 720p</td></tr></tbody></table></figure><p>Battery</p><figure class=\"table\"><table><tbody><tr><td>Battery Chemistry</td><td>Lithium-Ion Polymer (LiPo)</td></tr><tr><td>Capacity</td><td>Non-Removable: 58.2 Wh</td></tr><tr><td>Maximum Runtime</td><td>20 Hours</td></tr></tbody></table></figure><p>Keyboard &amp; Mouse</p><figure class=\"table\"><table><tbody><tr><td>Keyboard</td><td>Notebook Keyboard with Backlight</td></tr><tr><td>Pointing Device</td><td>Force Touch Trackpad</td></tr></tbody></table></figure><p>General</p><figure class=\"table\"><table><tbody><tr><td>Security</td><td>Fingerprint Reader</td></tr><tr><td>Power Supply</td><td>61 W</td></tr><tr><td>AC Input Power</td><td>100 to 240 VAC, 50 / 60 Hz</td></tr><tr><td>Operating Temperature</td><td>50 to 95°F / 10 to 35°C</td></tr><tr><td>Operating Humidity</td><td>0 to 90%</td></tr><tr><td>Dimensions</td><td>11.97 x 8.36 x 0.61\" / 30.4 x 21.23 x 1.55&nbsp;cm</td></tr></tbody></table></figure>', 'MACBOOK PRO RETINA 13\'\' M1 CHIP 512GB 8GB', '', '1 Year', 1, 2, NULL, NULL),
(4, 'Microsoft Surface Pro Core i7 - 512GB - 16GB - 2017 Ed', 'microsoft-surface-pro-core-i7---512gb---16gb---2017-ed_4', 'products/4/hotlink-ok/main.png', '[\"products\\/4\\/hotlink-ok\\/0.png\",\"products\\/4\\/hotlink-ok\\/1.png\"]', 1, '<figure class=\"table\"><table><tbody><tr><td>Activity</td><td>Personal</td></tr><tr><td>USB Ports</td><td>(3) USB 2.0</td></tr><tr><td>Battery</td><td>Yes</td></tr><tr><td>Operating System</td><td>Windows 8.1</td></tr><tr><td>Graphics Processor</td><td>Intel Integrated Graphics</td></tr><tr><td>Brand</td><td><a href=\"https://www.konga.com/brand/microsoft\">Microsoft</a></td></tr><tr><td>Screen size</td><td>14 inches</td></tr><tr><td>Resolution (Display)</td><td>1366 x 768</td></tr><tr><td>RAM</td><td>16 GB</td></tr><tr><td>Hard Drive</td><td>512 GB</td></tr><tr><td>Graphics</td><td>VGA</td></tr><tr><td>Wireless</td><td>Yes, Bluetooth,</td></tr><tr><td>Number of Cores</td><td>2 Cores</td></tr><tr><td>Storage Type</td><td>HDD</td></tr><tr><td>Display Technology</td><td>3D</td></tr><tr><td>Colour</td><td>Grey</td></tr></tbody></table></figure><p><br>The latest Microsoft Surface Pro Features a 7th generation Intel Core i7 Processor, 1 TB of storage, 16 GB RAM, and up to 13.5 hours of video playback<br>Our fastest Surface Pro ever* thanks to a powerful Intel Core laptop-grade processor.Bluetooth 4.0<br>Go all day with up to 13.5 hours of battery life. * 50% more battery life than the previous generation<br>Our lightest Surface Pro yet*, starting at 1.69 lbs (m3 model).<br>Surface Pro Signature Type cover and Microsoft Surface Pen sold separately</p><ul><li>A best-in-class laptop with the versatility of a studio and tablet</li><li>More power — now with the new 8th Generation Intel Core processor</li><li>Ultra-slim and light, starting at just 1.7 pounds</li><li>All-day battery life, with up to 13.5 hours of video playback</li><li>Pair with our Signature Type Cover* in luxurious Alcantara material and rich colors for a full keyboard experience. Sensors :Ambient light sensor, Accelerometer, Gyroscope</li></ul>', 'BRAND NEW', '', '1 Year', 1, 2, NULL, NULL),
(5, 'Black Wrap Midi Dress', 'black-wrap-midi-dress_6', 'products/6/hotlink-ok/main.png', '[\"products\\/6\\/hotlink-ok\\/0.png\",\"products\\/6\\/hotlink-ok\\/1.png\"]', 1, '<p>We at Escetera Stores pride ourselves in giving you the very best that makes you stand out and be noticed, as we bring you great assortments of high premium quality fashion items like dresses, tops etc at optimal price.</p><p>This <strong>Black Wrap Midi Dress</strong> is a fine outfit which accentuates your figure, giving you that superior feminist look in it. This dress is a wardrobe essential for every woman that wants to look her best.</p><p>It comes as a <strong>midi wrap dress</strong> and perfectly body fitting. The dress is <strong>short sleeve dress with buttons ensemble</strong> and the smooth contours and solid colour of the dress helps to compliment its alluring looks and brings out that trendy and classy style.</p><p>The dress is crafted from carefully selected quality material to hug your body for that comfortable fit.</p><p>This dress is the perfect fit for that formal business and office outings, weddings, evening and cocktail party events for ladies with class and style.</p><p>The black colour, creates an aura of beauty, stability and greatness and when paired with a high heel, you definitely will turn heads and cause a stare in this outfit.</p>', 'Midi dress\nWrap dress\nShort sleeve\nButton ensemble\nZipper to back\nSolid colour fabric\nTrendy and classy', 'midi dress', NULL, 1, 14, NULL, NULL),
(6, 'Boyfriend Jeans', 'boyfriend-jeans_7', 'products/7/hotlink-ok/main.png', '[\"products\\/7\\/hotlink-ok\\/0.png\"]', 1, '<p>This quality boyfriend jeans is available in different sizes, fits both slim and thick&nbsp;people</p><p>You can rock it with any kind of top whether bodysuit, polo top, blouse, or chiffon top</p><p>Konga gives you the best fashion ideal.</p>', 'Brand new', 'jeans', NULL, 1, 14, NULL, NULL),
(7, 'AWW Front Slit Denim Skirt- Blue', 'aww-front-slit-denim-skirt--blue_8', 'products/8/hotlink-ok/main.png', '[\"products\\/8\\/hotlink-ok\\/0.png\",\"products\\/8\\/hotlink-ok\\/1.png\",\"products\\/8\\/hotlink-ok\\/2.png\"]', 1, '<p>Introducing our stylish High Waist Front Slit Denim Skirt, this skirt is so edgy pair with our tops and mules and go from day to night. All the details in this skirt gives you that alluring look all day.</p>', 'High Waist, Front Slit, Edgy, Stylish, Denim', 'slit skirt,slit denim,denim', NULL, 1, 14, NULL, NULL),
(8, 'Dell Poweredge T40 Server, Intel Xeon Quad Core - E-2224g - 3.5GHZ, 8GB, 1TB, DVDRW', 'dell-poweredge-t40-server,-intel-xeon-quad-core---e-2224g---3.5ghz,-8gb,-1tb,-dvdrw_9', 'products/9/hotlink-ok/main.png', '[\"products\\/9\\/hotlink-ok\\/0.png\"]', 1, '<figure class=\"table\"><table><tbody><tr><td>Brand</td><td><a href=\"https://www.konga.com/brand/dell\">Dell</a></td></tr></tbody></table></figure><p>Specification<br>Brand Dell<br>Form Factor Tower<br>Processor manufacturer Intel<br>Processor Model E-2224G<br>tooltip<br>RAM 8GB<br>Internal Bays 4<br>Depth 36cm<br>Height 34cm<br>Weight 8.4kg<br>Width 18cm<br>Processor<br>Processor manufacturer Intel<br>Processor Model E-2224G<br>Number of Cores 4<br>Clock Speed 3.5GHz<br>Installed Qty 1<br>Max Supported Qty 1<br>Server Scalability 1-way<br>Cache Memory<br>Installed Size 8MB<br>Per Processor Size 8MB<br>RAM<br>Installed Size 8GB<br>Technology DDR4<br>Memory Speed 2666MHz<br>Form Factor DIMM 288-pin<br>Slots Qty 4<br>Max Supported Size 64GB<br>Empty Slots 3<br>Hard drive<br>HDD Capacity 1TB<br>Disk Speed 7200rpm<br>Type HDD<br>Interface Class Serial ATA<br>Graphics Processor<br>Processor Type Intel UHD Graphics P630<br>Networking<br>Data link protocol Gigabit Ethernet</p>', 'Dell server', '', NULL, 1, 2, NULL, NULL),
(9, 'Tecno Spark 7p kf7 6.8\" Hd+ - 64GB ROM - 4GB RAM - 16MP - 8MP - 5000mAh - 4G LTE - Black', 'tecno-spark-7p-kf7-6.8\"-hd+---64gb-rom---4gb-ram---16mp---8mp---5000mah---4g-lte---black_10', 'products/10/hotlink-ok/main.png', '[\"products\\/10\\/hotlink-ok\\/0.png\",\"products\\/10\\/hotlink-ok\\/1.png\"]', 1, '<figure class=\"table\"><table><tbody><tr><td>Battery Capacity</td><td>5000mAh</td></tr><tr><td>Sim Type</td><td>Dual SIM</td></tr><tr><td>OS</td><td>Android OS</td></tr><tr><td>Sim Slots</td><td>Dual Sim</td></tr><tr><td>Warranty Period</td><td>1 Year</td></tr><tr><td>Colour</td><td>Black</td></tr><tr><td>Brand</td><td><a href=\"https://www.konga.com/brand/tecno\">Tecno</a></td></tr><tr><td>Screen size</td><td>7 inches</td></tr><tr><td>Connectivity</td><td>Wired</td></tr><tr><td>RAM</td><td>4 GB</td></tr><tr><td>Internal Memory</td><td>64 GB</td></tr></tbody></table></figure><p>OS Android OS<br>Sim Slots Dual Sim<br>Battery Capacity 5000mAh<br>Sim Type Dual SIM<br>RAM 4 GB<br>Internal Memory 64 GB<br>Warranty Period 1 Year<br>Colour Black<br>Brand &nbsp;<br>Screen size Others<br>Connectivity WiFi + 4G<br>Tecno Spark 7P - SPECIFICATIONS<br>General<br>Model:&nbsp;Tecno Spark 7P<br>Released:&nbsp;April, 2021<br>Status:&nbsp;Available<br>Design<br>Type:&nbsp;Bar<br>Dimensions:&nbsp;171.9 x 77.9 x 9.2 mm<br>Weight:&nbsp;Grams<br>Waterproof:&nbsp;No<br>Display<br>Display Type:&nbsp;IPS LCD<br>Size:&nbsp;6.8 inches<br>Resolution:&nbsp;720 x 1640 pixels<br>Display Colors:&nbsp;16M Colors<br>Pixel Density:&nbsp;263 PPI (pixels per inch)<br>Touch Screen:&nbsp;Yes<br>Hardware<br>CPU:&nbsp;Octa-core (2x2.0 GHz Cortex-A75 + 6x1.7 GHz Cortex-A55)<br>GPU:&nbsp;Mali-G52 2EEMC2<br>RAM (Memory):&nbsp;4 GB<br>Internal Storage:&nbsp;64 GB, 128 GB<br>Memory Card Slot:&nbsp;microSDXC<br>Sensors:&nbsp;Fingerprint (rear-mounted), accelerometer, proximity<br>Software<br>Operating System:&nbsp;Android 11 + HIOS 7.5<br>User Interface:&nbsp;Yes<br>Camera<br>Rear Camera:&nbsp;16 MP + Secondary unspecified camera + Third unknown camera<br>Image:&nbsp;1080p<br>Video:&nbsp;1080p@30fps<br>Flash:&nbsp;Quad-LED flash<br>Front Camera:&nbsp;8 MP<br>Network<br>SIM:&nbsp;Nano SIM<br>Dual SIM:&nbsp;Dual SIM (Nano-SIM, dual stand-by)<br>Connectivity<br>Wi-fi:&nbsp;Wi-Fi 802.11 b/g/n, hotspot<br>USB:&nbsp;microUSB 2.0, USB On-The-Go<br>GPS:&nbsp;Yes, with A-GPS<br>NFC:&nbsp;No<br>Wireless Charging:&nbsp;No<br>Headphone Jack:&nbsp;Yes<br>Battery<br>Capacity:&nbsp;Li-Po 5000 mAh<br>Placement:&nbsp;Non-removable<br>Media<br>Video Playback:&nbsp;Yes<br>Video Out:&nbsp;Yes<br>FM Radio:&nbsp;Yes<br>Ring Tones:&nbsp;Yes<br>Loudspeaker:&nbsp;Yes<br>Handsfree:&nbsp;Yes<br>Data<br>4G LTE:&nbsp;LTE<br>5G NR Bands:&nbsp;No<br>Speed:&nbsp;HSPA 42.2/5.76 Mbps, LTE Cat4 150/50 Mbps</p>', '6.8\" HD+ DOT-NOTCH SCREEN DISPLAY-64GB ROM/ 4GB RAM-16MP TRIPPLE REAR CAMERA/8MP FRONT CAMERA WITH DUAL FLASH-HELIO G70 OCTA-CORE PROCESSOR -5000MAH -4G LTE-RESOLUTION 720*1640', 'techno', '6 Months', 1, 2, NULL, NULL),
(10, 'iPhone X - 64GB ROM - 3GB RAM - iOs 12 - Nano Sim - Black', 'iphone-x---64gb-rom---3gb-ram---ios-12---nano-sim---black_11', 'products/11/hotlink-ok/main.png', '[\"products\\/11\\/hotlink-ok\\/0.png\",\"products\\/11\\/hotlink-ok\\/1.png\"]', 1, '<figure class=\"table\"><table><tbody><tr><td>Colour</td><td>Black</td></tr><tr><td>Screen size</td><td>5.88 inches</td></tr><tr><td>Sim Type</td><td>Nano SIM</td></tr><tr><td>OS</td><td>iOS</td></tr><tr><td>Sim Slots</td><td>Single Nano Sim</td></tr><tr><td>Battery Capacity</td><td>1000mAh - 3000mAh</td></tr><tr><td>RAM</td><td>3 GB</td></tr><tr><td>Internal Memory</td><td>64 GB</td></tr></tbody></table></figure><figure class=\"table\"><table><tbody><tr><td>Colour</td><td>Black</td></tr><tr><td>Brand</td><td>&nbsp;</td></tr><tr><td>Screen size</td><td>5.88 inches</td></tr><tr><td>Sim Type</td><td>Nano SIM</td></tr><tr><td>OS</td><td>Android OS</td></tr><tr><td>Sim Slots</td><td>Single Nano Sim</td></tr><tr><td>Battery Capacity</td><td>3000mAh - 5000mAh</td></tr><tr><td>RAM</td><td>3 GB</td></tr><tr><td>Internal Memory</td><td>64 GB</td></tr></tbody></table></figure><figure class=\"table\"><table><tbody><tr><td>Sim Slots</td><td>Single Nano Sim</td></tr><tr><td>Battery Capacity</td><td>3000mAh - 5000mAh</td></tr><tr><td>Sim Type</td><td>Nano SIM</td></tr><tr><td>OS</td><td>iOS</td></tr><tr><td>Colour</td><td>Black</td></tr><tr><td>Brand</td><td>&nbsp;</td></tr><tr><td>Screen size</td><td>5.88 inches</td></tr><tr><td>Connectivity</td><td>WiFi + 4G</td></tr><tr><td>RAM</td><td>3 GB</td></tr><tr><td>Internal Memory</td><td>64 GB</td></tr></tbody></table></figure><h2><i>Apple</i>&nbsp;iPhone X</h2><p><i>Apple</i>&nbsp;iPhone X smartphone comes with a 6.10-inch touchscreen display with a resolution of 828x1792 pixels at a pixel density of 326 pixels per inch (ppi) and an aspect ratio of 19.5:9.<i>&nbsp;Apple&nbsp;</i>iPhone XR is powered by a hexa-core<i>&nbsp;Apple&nbsp;</i>A12 Bionic processor. It comes with 3GB of RAM. The<i>&nbsp;Apple&nbsp;</i>iPhone XR runs iOS 12 and is powered by a 2942mAh non-removable battery. The<i>&nbsp;Apple&nbsp;</i>iPhone XR supports wireless charging, as well as proprietary fast charging.</p><p>As far as the cameras are concerned, the<i>&nbsp;Apple&nbsp;</i>iPhone X on the rear packs a 12-megapixel camera with an f/1.8 aperture. The rear camera setup has autofocus. It sports a 7-megapixel camera on the front for selfies, with an f/2.2 aperture.</p><p><i>Apple</i>&nbsp;iPhone XR based on iOS 12 and packs 64GB of inbuilt storage. The<i>&nbsp;Apple&nbsp;</i>iPhone XR is a single SIM (GSM) smartphone that accepts Nano-SIM card. The<i>&nbsp;Apple&nbsp;</i>iPhone XR measures 150.90 x 75.70 x 8.30mm (height x width x thickness) and weighs 194.00 grams. It was launched in Black, Blue, Coral, Red, White, and Yellow colours. It features an IP67 rating for dust and water protection.</p><p>Connectivity options on the<i>&nbsp;Apple&nbsp;</i>iPhone XR include Wi-Fi 802.11 a/b/g/n/ac, GPS, Bluetooth v5.00, NFC, Lightning, 3G, and 4G (with support for Band 40 used by some LTE networks in India) with active 4G on both SIM cards. Sensors on the phone include accelerometer, ambient light sensor, barometer, gyroscope, proximity sensor, and compass/ magnetometer. The<i>&nbsp;Apple&nbsp;</i>iPhone XR supports face unlock with 3D face recognition.</p>', 'Apple iPhone X smartApple iPhone X smartphone comes with a 6.10-inch touApple iPhone X smartphone comes with a 6.10-inch touApple iPhone X smartphone comes with a 6.10-inch touApple iPhone X smartphon', '', '1 Year', 1, 2, NULL, NULL);

CREATE TABLE `product_clicks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `clicks` int(11) NOT NULL,
  `city` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `product_favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_variation_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expired_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `product_variation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `variant_types` varchar(60) DEFAULT NULL,
  `variant_type_values` varchar(80) DEFAULT NULL,
  `price` double NOT NULL,
  `on_sale` tinyint(4) NOT NULL DEFAULT 0,
  `sale_price` double NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL,
  `low_stock_value` int(11) NOT NULL DEFAULT 1,
  `sku` varchar(50) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `product_variation` (`id`, `product_id`, `variant_types`, `variant_type_values`, `price`, `on_sale`, `sale_price`, `quantity`, `low_stock_value`, `sku`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '-;color;-', '-;pink;-', 227.5, 0, 0, 6, 4, '', 1, NULL, NULL),
(2, 1, '-;color;-', '-;light-blue;-', 228.5, 0, 0, 40, 10, '23423GHGT', 1, NULL, NULL),
(3, 2, '-;-;-', '-;-;-', 269.5, 1, 250, 31, 12, '5235YYWET', 1, NULL, '2024-05-12 20:41:52'),
(4, 3, '-;-;-', '-;-;-', 880, 1, 800, 2, 1, '', 1, NULL, '2024-05-12 20:41:52'),
(5, 4, '-;-;-', '-;-;-', 1300, 1, 1200, 2, 1, '', 1, NULL, NULL),
(6, 6, 'size;color;-', '10;black;-', 53, 0, 0, 3, 1, '', 1, NULL, NULL),
(7, 6, 'size;color;-', '12;black;-', 54, 0, 0, 3, 1, '', 1, NULL, '2024-05-12 15:40:33'),
(8, 6, 'size;color;-', '14;black;-', 55, 0, 0, 12, 1, '', 1, NULL, NULL),
(9, 6, 'size;color;-', '16;black;-', 56, 0, 0, 30, 1, '', 1, NULL, NULL),
(10, 7, 'size;color;-', '8;blue;-', 80, 0, 0, 4, 1, '', 1, NULL, NULL),
(11, 7, 'size;color;-', '10;blue;-', 80, 0, 0, 4, 1, '', 1, NULL, NULL),
(12, 7, 'size;color;-', '14;blue;-', 80, 0, 0, 10, 1, '', 1, NULL, '2024-05-12 15:24:49'),
(13, 7, 'size;color;-', '16;blue;-', 80, 0, 0, 6, 1, '', 1, NULL, NULL),
(14, 8, 'size;color;-', '14;blue;-', 90, 1, 75, 8, 2, '', 1, NULL, NULL),
(15, 9, '-;-;-', '-;-;-', 450, 0, 0, 2, 1, '', 1, NULL, NULL),
(16, 10, '-;-;-', '-;-;-', 70, 0, 0, 4, 1, '', 1, NULL, NULL),
(17, 7, '-;-;-', '-;-;-', 195, 0, 0, 2, -1, '', 1, NULL, NULL),
(18, 7, '-;-;-', '-;-;-', 4.5, 1, 3.4, 400, 10, '', 1, NULL, NULL),
(19, 8, '-;-;-', '-;-;-', 2.85, 1, 2.75, 15, 3, '', 1, NULL, NULL),
(20, 6, 'size;color;-', '12;pink;-', 5.4, 0, 0, 71, 2, '', 1, NULL, '2024-05-12 17:13:39'),
(21, 6, 'size;color;-', '14;pink;-', 55, 0, 0, 9, 3, '', 1, NULL, NULL);

CREATE TABLE `ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `retailer_id` int(11) NOT NULL,
  `rating` double NOT NULL,
  `comments` varchar(191) DEFAULT NULL,
  `approval_status` varchar(10) NOT NULL DEFAULT 'APPROVED',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `rejected_deliveries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `driver_id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `delivery_fee` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `retailers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_name` varchar(191) NOT NULL,
  `business_address` varchar(191) NOT NULL,
  `business_description` varchar(191) NOT NULL,
  `firstname` varchar(191) NOT NULL,
  `lastname` varchar(191) NOT NULL,
  `phone_number` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `type_of_business` int(11) NOT NULL,
  `business_hours_open` varchar(191) NOT NULL,
  `business_hours_close` varchar(191) NOT NULL,
  `city` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `zip_code` int(11) NOT NULL,
  `web_url` varchar(191) DEFAULT NULL,
  `banner_image` blob DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `longitude` double NOT NULL DEFAULT 0,
  `latitude` double NOT NULL DEFAULT 0,
  `island` varchar(191) DEFAULT NULL,
  `approval_status` varchar(191) NOT NULL DEFAULT 'New',
  `approved_at` timestamp NULL DEFAULT NULL,
  `from_mobile` int(11) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `retailers` (`id`, `business_name`, `business_address`, `business_description`, `firstname`, `lastname`, `phone_number`, `email`, `type_of_business`, `business_hours_open`, `business_hours_close`, `city`, `state`, `zip_code`, `web_url`, `banner_image`, `password`, `longitude`, `latitude`, `island`, `approval_status`, `approved_at`, `from_mobile`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'Acesys Solutions', '1774 Ottawa Dr, Las Vegas, NV 89169, USA', 'Acesys Solutions is a software development company that specializes in web and mobile applications.', 'Fleming', 'Usiomah', '+2348029563955', 'Fleming.paul@acesys.com.ng', 1, 'Monday-Friday:11am-11pm', 'Saturday-Sunday:9am-6pm', 'Las Vegas', 'Nevada', 21804, 'https://acesys.com.ng', 0x313731343436383439312e6a7067, '$2y$10$Jq5QPHD.XqZC4oH.EUAJgOnVTbi92DTHBvE2N7f7w8Cnd.BS7Qxs.', -115.1314907, 36.122983, NULL, 'Approved', '2024-04-29 16:54:05', 0, 2, 2, '2024-04-29 16:54:05', '2024-04-30 08:14:51');

CREATE TABLE `retailers_payouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` int(11) NOT NULL,
  `retailer_id` int(11) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `status` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) NOT NULL,
  `role_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_variation_id` int(11) NOT NULL,
  `product_id` varchar(191) NOT NULL,
  `retailer_id` int(11) NOT NULL,
  `business_name` varchar(191) NOT NULL,
  `product_name` varchar(191) NOT NULL,
  `product_image` varchar(191) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_cost` double NOT NULL,
  `variation_name` varchar(191) NOT NULL,
  `status` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sales` (`id`, `order_id`, `user_id`, `product_variation_id`, `product_id`, `retailer_id`, `business_name`, `product_name`, `product_image`, `quantity`, `unit_cost`, `variation_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 8, 3, '2', 1, 'Acesys Solutions', 'Lenovo Ideapad 3 15ITL05 Intel Core I5-1135G7 4GB RAM 1TB HDD FreeDos-Platinum Grey (81X8009HUE)', 'sales/1715550112_1.png', 1, 250, '-;-;-', 'Picked Up', '2024-05-12 20:41:52', '2024-05-16 23:42:24'),
(2, 1, 8, 4, '3', 1, 'Acesys Solutions', 'Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Model', 'sales/1715550112_2.png', 1, 800, '-;-;-', 'Picked Up', '2024-05-12 20:41:52', '2024-05-16 23:36:36');

CREATE TABLE `sales_retailers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sales_user_id` int(11) NOT NULL,
  `retailer_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sale_delivery_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` int(11) NOT NULL,
  `status` varchar(191) NOT NULL,
  `message` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sale_delivery_status` (`id`, `sale_id`, `status`, `message`, `created_at`, `updated_at`) VALUES
(1, 1, 'Delivered', 'Package Lenovo Ideapad 3 15ITL05 Intel Core I5-1135G7 4GB RAM 1TB HDD FreeDos-Platinum Grey (81X8009HUE) was delivered to the customer', '2024-05-15 01:08:43', '2024-05-15 01:08:43'),
(2, 1, 'Delivered', 'Package Lenovo Ideapad 3 15ITL05 Intel Core I5-1135G7 4GB RAM 1TB HDD FreeDos-Platinum Grey (81X8009HUE) was delivered to the customer', '2024-05-15 01:08:52', '2024-05-15 01:08:52'),
(3, 2, 'Delivered', 'Package Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Model was delivered to the customer', '2024-05-15 01:12:58', '2024-05-15 01:12:58'),
(4, 1, 'Package Pickup By Customer', 'Lenovo Ideapad 3 15ITL05 Intel Core I5-1135G7 4GB RAM 1TB HDD FreeDos-Platinum Grey (81X8009HUE)was picked up from the retailer by the customer', '2024-05-15 05:19:35', '2024-05-15 05:19:35'),
(5, 2, 'Package Pickup By Customer', 'Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Modelwas picked up from the retailer by the customer', '2024-05-15 05:22:02', '2024-05-15 05:22:02'),
(6, 2, 'Package Pickup', 'Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Modelwas picked up by the driver', '2024-05-16 23:36:37', '2024-05-16 23:36:37'),
(7, 2, 'Package Pickup', 'Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Modelwas picked up by the driver', '2024-05-16 23:36:37', '2024-05-16 23:36:37'),
(8, 2, 'Package Pickup', 'Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Modelwas picked up by the driver', '2024-05-16 23:36:37', '2024-05-16 23:36:37'),
(9, 2, 'Package Pickup', 'Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Modelwas picked up by the driver', '2024-05-16 23:36:37', '2024-05-16 23:36:37'),
(10, 2, 'Package Pickup', 'Apple Macbook Pro With Apple M1 Chip -13\'\'- 8GB RAM - 512GB SSD Storage - Space Grey - Latest Modelwas picked up by the driver', '2024-05-16 23:36:37', '2024-05-16 23:36:37'),
(11, 1, 'Package Pickup', 'Lenovo Ideapad 3 15ITL05 Intel Core I5-1135G7 4GB RAM 1TB HDD FreeDos-Platinum Grey (81X8009HUE)was picked up by the driver', '2024-05-16 23:42:24', '2024-05-16 23:42:24'),
(12, 1, 'Package Pickup', 'Lenovo Ideapad 3 15ITL05 Intel Core I5-1135G7 4GB RAM 1TB HDD FreeDos-Platinum Grey (81X8009HUE)was picked up by the driver', '2024-05-16 23:42:24', '2024-05-16 23:42:24');

CREATE TABLE `sale_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(191) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_store_pickup` tinyint(4) NOT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `total_time` varchar(191) DEFAULT NULL,
  `total_duration` int(11) DEFAULT NULL,
  `total_distance` varchar(191) DEFAULT NULL,
  `driver_location` varchar(191) NOT NULL,
  `status` varchar(191) NOT NULL,
  `service_charge` double NOT NULL DEFAULT 0,
  `total_discount` double NOT NULL DEFAULT 0,
  `total_cost` double NOT NULL DEFAULT 0,
  `delivery_fee` double NOT NULL,
  `proposed_route` longtext DEFAULT NULL,
  `address` varchar(191) NOT NULL,
  `city` varchar(191) NOT NULL,
  `state` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sale_orders` (`id`, `order_number`, `user_id`, `is_store_pickup`, `driver_id`, `total_time`, `total_duration`, `total_distance`, `driver_location`, `status`, `service_charge`, `total_discount`, `total_cost`, `delivery_fee`, `proposed_route`, `address`, `city`, `state`, `created_at`, `updated_at`) VALUES
(1, '1715550112', 8, 0, 8, '13 mins', 763, '3.43 miles', '\"{\\\"latitude\\\":36.1407906,\\\"longitude\\\":-115.1309931}\"', 'Enroute To Customer', 7.5, 0, 1149.5, 2.543333333333333, '\"[{\\\"latitude\\\":36.14085,\\\"longitude\\\":-115.13099},{\\\"latitude\\\":36.14084,\\\"longitude\\\":-115.13308},{\\\"latitude\\\":36.14074,\\\"longitude\\\":-115.13307},{\\\"latitude\\\":36.14033,\\\"longitude\\\":-115.13327},{\\\"latitude\\\":36.14019,\\\"longitude\\\":-115.13291},{\\\"latitude\\\":36.14009,\\\"longitude\\\":-115.13272},{\\\"latitude\\\":36.13997,\\\"longitude\\\":-115.13257},{\\\"latitude\\\":36.1398,\\\"longitude\\\":-115.13243},{\\\"latitude\\\":36.13963,\\\"longitude\\\":-115.13232},{\\\"latitude\\\":36.13943,\\\"longitude\\\":-115.13226},{\\\"latitude\\\":36.13786,\\\"longitude\\\":-115.13226},{\\\"latitude\\\":36.1377,\\\"longitude\\\":-115.13227},{\\\"latitude\\\":36.13743,\\\"longitude\\\":-115.13224},{\\\"latitude\\\":36.1369,\\\"longitude\\\":-115.13225},{\\\"latitude\\\":36.13616,\\\"longitude\\\":-115.1322},{\\\"latitude\\\":36.13582,\\\"longitude\\\":-115.13218},{\\\"latitude\\\":36.13524,\\\"longitude\\\":-115.13214},{\\\"latitude\\\":36.1338,\\\"longitude\\\":-115.1321},{\\\"latitude\\\":36.13329,\\\"longitude\\\":-115.13211},{\\\"latitude\\\":36.13275,\\\"longitude\\\":-115.13212},{\\\"latitude\\\":36.13149,\\\"longitude\\\":-115.13212},{\\\"latitude\\\":36.13029,\\\"longitude\\\":-115.13209},{\\\"latitude\\\":36.12983,\\\"longitude\\\":-115.13207},{\\\"latitude\\\":36.12983,\\\"longitude\\\":-115.13141},{\\\"latitude\\\":36.12985,\\\"longitude\\\":-115.1303},{\\\"latitude\\\":36.12987,\\\"longitude\\\":-115.12812},{\\\"latitude\\\":36.12953,\\\"longitude\\\":-115.12813},{\\\"latitude\\\":36.12943,\\\"longitude\\\":-115.12816},{\\\"latitude\\\":36.1293,\\\"longitude\\\":-115.12823},{\\\"latitude\\\":36.12922,\\\"longitude\\\":-115.12831},{\\\"latitude\\\":36.1291,\\\"longitude\\\":-115.12844},{\\\"latitude\\\":36.12895,\\\"longitude\\\":-115.12829},{\\\"latitude\\\":36.12885,\\\"longitude\\\":-115.12823},{\\\"latitude\\\":36.12879,\\\"longitude\\\":-115.12822},{\\\"latitude\\\":36.12817,\\\"longitude\\\":-115.12825},{\\\"latitude\\\":36.12802,\\\"longitude\\\":-115.12821},{\\\"latitude\\\":36.1279,\\\"longitude\\\":-115.12815},{\\\"latitude\\\":36.1278,\\\"longitude\\\":-115.12807},{\\\"latitude\\\":36.12767,\\\"longitude\\\":-115.12785},{\\\"latitude\\\":36.1264,\\\"longitude\\\":-115.12794},{\\\"latitude\\\":36.12497,\\\"longitude\\\":-115.12806},{\\\"latitude\\\":36.12376,\\\"longitude\\\":-115.12817},{\\\"latitude\\\":36.12299,\\\"longitude\\\":-115.12821},{\\\"latitude\\\":36.12299,\\\"longitude\\\":-115.12954},{\\\"latitude\\\":36.12298,\\\"longitude\\\":-115.1306},{\\\"latitude\\\":36.12303,\\\"longitude\\\":-115.13105},{\\\"latitude\\\":36.12312,\\\"longitude\\\":-115.13148},{\\\"latitude\\\":36.12317,\\\"longitude\\\":-115.13165},{\\\"latitude\\\":36.12327,\\\"longitude\\\":-115.13194},{\\\"latitude\\\":36.12334,\\\"longitude\\\":-115.13209},{\\\"latitude\\\":36.12375,\\\"longitude\\\":-115.13287},{\\\"latitude\\\":36.12364,\\\"longitude\\\":-115.13294},{\\\"latitude\\\":36.12344,\\\"longitude\\\":-115.13305},{\\\"latitude\\\":36.12325,\\\"longitude\\\":-115.13311},{\\\"latitude\\\":36.12298,\\\"longitude\\\":-115.13313},{\\\"latitude\\\":36.12248,\\\"longitude\\\":-115.13313},{\\\"latitude\\\":36.12225,\\\"longitude\\\":-115.13311},{\\\"latitude\\\":36.12172,\\\"longitude\\\":-115.13282},{\\\"latitude\\\":36.12147,\\\"longitude\\\":-115.13272},{\\\"latitude\\\":36.12129,\\\"longitude\\\":-115.1327},{\\\"latitude\\\":36.12029,\\\"longitude\\\":-115.13281},{\\\"latitude\\\":36.12029,\\\"longitude\\\":-115.13396},{\\\"latitude\\\":36.12027,\\\"longitude\\\":-115.13463},{\\\"latitude\\\":36.12027,\\\"longitude\\\":-115.13535},{\\\"latitude\\\":36.12026,\\\"longitude\\\":-115.13733},{\\\"latitude\\\":36.12025,\\\"longitude\\\":-115.13759},{\\\"latitude\\\":36.11929,\\\"longitude\\\":-115.13766},{\\\"latitude\\\":36.11859,\\\"longitude\\\":-115.13769},{\\\"latitude\\\":36.11796,\\\"longitude\\\":-115.13772},{\\\"latitude\\\":36.11575,\\\"longitude\\\":-115.13785},{\\\"latitude\\\":36.11466,\\\"longitude\\\":-115.13791},{\\\"latitude\\\":36.11447,\\\"longitude\\\":-115.13793},{\\\"latitude\\\":36.11398,\\\"longitude\\\":-115.13791},{\\\"latitude\\\":36.11366,\\\"longitude\\\":-115.13789},{\\\"latitude\\\":36.11344,\\\"longitude\\\":-115.13786},{\\\"latitude\\\":36.11294,\\\"longitude\\\":-115.13783},{\\\"latitude\\\":36.1125,\\\"longitude\\\":-115.13781},{\\\"latitude\\\":36.11183,\\\"longitude\\\":-115.13774},{\\\"latitude\\\":36.11114,\\\"longitude\\\":-115.1377},{\\\"latitude\\\":36.1112,\\\"longitude\\\":-115.13788},{\\\"latitude\\\":36.11137,\\\"longitude\\\":-115.13821},{\\\"latitude\\\":36.11167,\\\"longitude\\\":-115.13859},{\\\"latitude\\\":36.11176,\\\"longitude\\\":-115.13876},{\\\"latitude\\\":36.11181,\\\"longitude\\\":-115.13891},{\\\"latitude\\\":36.11189,\\\"longitude\\\":-115.13929},{\\\"latitude\\\":36.1119,\\\"longitude\\\":-115.13954},{\\\"latitude\\\":36.11191,\\\"longitude\\\":-115.14076},{\\\"latitude\\\":36.11162,\\\"longitude\\\":-115.14074},{\\\"latitude\\\":36.11163,\\\"longitude\\\":-115.14058},{\\\"latitude\\\":36.11158,\\\"longitude\\\":-115.14058},{\\\"latitude\\\":36.11086,\\\"longitude\\\":-115.14051},{\\\"latitude\\\":36.11073,\\\"longitude\\\":-115.14051},{\\\"latitude\\\":36.11073,\\\"longitude\\\":-115.14045},{\\\"latitude\\\":36.11075,\\\"longitude\\\":-115.14015},{\\\"latitude\\\":36.11075,\\\"longitude\\\":-115.1401},{\\\"latitude\\\":36.1112,\\\"longitude\\\":-115.14013}]\"', '1067 Cottage Grove Ave, Las Vegas, NV 89154, USA', 'Las Vegas', 'Nevada', '2024-05-12 20:41:52', '2024-05-16 23:42:24');

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `abbreviation` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `states` (`id`, `name`, `abbreviation`, `created_at`, `updated_at`) VALUES
(1, 'Alabama', 'AL', NULL, NULL),
(2, 'Alaska', 'AK', NULL, NULL),
(3, 'Arizona', 'AZ', NULL, NULL),
(4, 'Arkansas', 'AR', NULL, NULL),
(5, 'California', 'CA', NULL, NULL),
(6, 'Colorado', 'CO', NULL, NULL),
(7, 'Connecticut', 'CT', NULL, NULL),
(8, 'Delaware', 'DE', NULL, NULL),
(9, 'Florida', 'FL', NULL, NULL),
(10, 'Georgia', 'GA', NULL, NULL),
(11, 'Hawaii', 'HI', NULL, NULL),
(12, 'Idaho', 'ID', NULL, NULL),
(13, 'Illinois', 'IL', NULL, NULL),
(14, 'Indiana', 'IN', NULL, NULL),
(15, 'Iowa', 'IA', NULL, NULL),
(16, 'Kansas', 'KS', NULL, NULL),
(17, 'Kentucky', 'KY', NULL, NULL),
(18, 'Louisiana', 'LA', NULL, NULL),
(19, 'Maine', 'ME', NULL, NULL),
(20, 'Maryland', 'MD', NULL, NULL),
(21, 'Massachusetts', 'MA', NULL, NULL),
(22, 'Michigan', 'MI', NULL, NULL),
(23, 'Minnesota', 'MN', NULL, NULL),
(24, 'Mississippi', 'MS', NULL, NULL),
(25, 'Missouri', 'MO', NULL, NULL),
(26, 'Montana', 'MT', NULL, NULL),
(27, 'Nebraska', 'NE', NULL, NULL),
(28, 'Nevada', 'NV', NULL, NULL),
(29, 'New Hampshire', 'NH', NULL, NULL),
(30, 'New Jersey', 'NJ', NULL, NULL),
(31, 'New Mexico', 'NM', NULL, NULL),
(32, 'New York', 'NY', NULL, NULL),
(33, 'North Carolina', 'NC', NULL, NULL),
(34, 'North Dakota', 'ND', NULL, NULL),
(35, 'Ohio', 'OH', NULL, NULL),
(36, 'Oklahoma', 'OK', NULL, NULL),
(37, 'Oregon', 'OR', NULL, NULL),
(38, 'Pennsylvania', 'PA', NULL, NULL),
(39, 'Rhode Island', 'RI', NULL, NULL),
(40, 'South Carolina', 'SC', NULL, NULL),
(41, 'South Dakota', 'SD', NULL, NULL),
(42, 'Tennessee', 'TN', NULL, NULL),
(43, 'Texas', 'TX', NULL, NULL),
(44, 'Utah', 'UT', NULL, NULL),
(45, 'Vermont', 'VT', NULL, NULL),
(46, 'Virginia', 'VA', NULL, NULL),
(47, 'Washington', 'WA', NULL, NULL),
(48, 'West Virginia', 'WV', NULL, NULL),
(49, 'Wisconsin', 'WI', NULL, NULL),
(50, 'Wyoming', 'WY', NULL, NULL);

CREATE TABLE `tracking` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `latitude` varchar(191) NOT NULL,
  `longitude` varchar(191) NOT NULL,
  `city` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `zip` varchar(191) DEFAULT NULL,
  `location_log` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tracking` (`id`, `delivery_id`, `latitude`, `longitude`, `city`, `state`, `zip`, `location_log`, `created_at`, `updated_at`) VALUES
(1, 1, '36.1169958', '-115.1247674', 'Las Vegas', 'Nevada', '89119', '[{\"latitude\":\"36.1169958\",\"longitude\":\"-115.1247674\",\"timestamp\":\"2024-05-16T20:25:13.622762Z\"}]', '2024-05-16 19:25:13', '2024-05-16 19:25:13');

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_name` varchar(191) NOT NULL,
  `business_address` varchar(191) NOT NULL,
  `firstname` varchar(191) NOT NULL,
  `lastname` varchar(191) NOT NULL,
  `photo` varchar(191) NOT NULL DEFAULT 'users/user.png',
  `city` varchar(191) NOT NULL,
  `state` varchar(191) NOT NULL,
  `latitude` double NOT NULL DEFAULT 0,
  `longitude` double NOT NULL DEFAULT 0,
  `zip_code` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `phone_number` varchar(191) NOT NULL,
  `user_type` varchar(191) NOT NULL DEFAULT 'Consumer',
  `user_status` tinyint(4) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT 0,
  `is_vip` int(11) NOT NULL DEFAULT 0,
  `approved_at` timestamp NULL DEFAULT NULL,
  `retailer_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `business_name`, `business_address`, `firstname`, `lastname`, `photo`, `city`, `state`, `latitude`, `longitude`, `zip_code`, `email`, `phone_number`, `user_type`, `user_status`, `email_verified_at`, `password`, `remember_token`, `admin`, `is_vip`, `approved_at`, `retailer_id`, `created_at`, `updated_at`) VALUES
(1, 'ritsConsulting', 'vegas, Nevada', 'Admin', 'User', 'users/user.png', 'vegas', 'Nevada', 0, 0, '901210', 'admin@admin.com', '+17256663692', 'Admin', 0, '2024-04-29 16:54:04', '$2y$10$qwHvNWtg1miqdakJoqcrMuzr8A9jfxvxhysoXK5/H4WBlZSyRumJO', NULL, 1, 0, '2024-04-29 16:54:04', NULL, '2024-04-29 16:54:04', '2024-04-29 16:54:04'),
(2, 'Wilkinson Ltd', '4216 Harvey Terrace Apt. 304\nNew Gudrun, IA 07762', 'Luis', 'Mayert', 'users/user.png', 'East Shyann', 'California', 0, 0, '88923-4897', 'norwood.cormier@example.net', '+2348010203040', 'Consumer', 0, '2024-04-29 16:54:04', '$2y$10$vuVqJQ0DxgKC9teFp5d/0e6IEseiqflB6gnYhils0iFz9sOwIcEBG', NULL, 0, 0, '2024-04-29 16:54:04', NULL, '2024-04-29 16:54:04', '2024-04-29 16:54:04'),
(3, '', '', 'John', 'Doe', 'users/user.png', '', '', 0, 0, '', 'johndoe@example1.com', '+2349060107172', 'Consumer', 0, NULL, '$2y$10$gZEwISTqJXzpX3wwlNcqLuXPRTDQbbz.9s46G65VuD3EZbMM0o4XK', NULL, 0, 0, NULL, NULL, '2024-04-29 16:54:07', '2024-04-29 16:54:07'),
(4, 'Acesys Solutions', '275 Collier Rd NW UNIT 230, Atlanta, GA 30309, USA', 'Fleming Paul', 'Usiomah', '1714406560.jpg', 'Atlanta', 'Georgia', 0, 0, '30309', 'Fleming.paul@acesys.com.ng', '+2348029563955', 'Retailer', 0, NULL, '$2y$10$LrlSV.XU8Wt/4SWLw6It8ujqb/NyILUiWtM2W9O3hLXrv4Y.WEWK.', NULL, 0, 0, NULL, 1, '2024-04-09 16:25:09', '2024-04-29 14:59:14'),
(5, '', '', 'Olamide', 'Bello', 'users/user.png', '', '', 0, 0, '', 'belkid98@gmail.com', '+2347062482037', 'Retailer', 0, NULL, '$2y$10$soOj3lBTSsU0GTKxiabOAuOobuuy/DPNDz/h/tBCPzVv71Cs6LdPu', NULL, 0, 0, NULL, 3, '2024-04-18 14:59:47', '2024-04-18 14:59:47'),
(6, '', '', 'Olamide', 'Bello', 'users/user.png', '', '', 0, 0, '', 'cloobtechse@gmail.com', '+2347062482036', 'Retailer', 0, NULL, '$2y$10$IPx5wf.O4K/SYUIWU/c4/.iqzsKslYr5/io4WxfI7pP2xTbbn7MDu', NULL, 0, 0, NULL, 4, '2024-04-18 14:59:55', '2024-04-18 14:59:55'),
(7, '', '', 'Emmanuel', 'Agber', 'users/user.png', '', '', 0, 0, '', 'agberoryina@gmail.com', '+2347036093976', 'Consumer', 0, NULL, '$2y$10$AbLfnZT1eI/vAalOzbo61.roVT5p88i5eX0.X/dPPvFrRinMq.EMe', NULL, 0, 0, NULL, NULL, '2024-04-18 17:48:07', '2024-04-18 17:48:07'),
(8, '', '1067 Cottage Grove Ave, Las Vegas, NV 89154, USA', 'Alexander', 'Fleming', 'users/user.png', 'Las Vegas', 'Nevada', 36.111199, -115.1401373, '89154', 'info@acesyys.com.ng', '+2347032949789', 'Consumer', 0, NULL, '$2y$10$Mn/ZunnaM3hl5bNwK5rXMOOz2btD6uBM2/EFNIhC9099bb6UA06uu', NULL, 0, 0, NULL, NULL, '2024-04-26 11:44:10', '2024-05-09 10:58:37'),
(15, '', '275 Park Ave, Brooklyn, NY 11205, USA', 'Dexterx', 'Paul', '1715010303.jpg', '', 'New York', 0, 0, '11205', 'fpauldexter@gmail.com', '+2349038606601', 'Driver', 0, NULL, '$2y$10$qzyyJTqoyAFS6GCrZURseety0E6Seoy0iXZmwZu8gU0Cqb18Puac6', NULL, 0, 0, NULL, NULL, '2024-05-01 13:25:58', '2024-05-06 14:45:03'),
(16, '', '2901 S Las Vegas Blvd, Las Vegas, NV 89109, USA', 'Akin', 'Adeshola', '1715287687.jpg', 'Las Vegas', 'Nevada', 0, 0, '89109', 'Fleming.paul@ascensioncs.ng', '+2348186484581', 'Driver', 0, NULL, '$2y$10$eXJ5Vx1vvaEme5JsFJ.wKeYKbykleA3rQugdJJNyACy9YedLUJMTS', NULL, 0, 0, NULL, NULL, '2024-05-09 19:45:39', '2024-05-09 19:48:07');

CREATE TABLE `vips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `expiry_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ad_clicks`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `coupons_clicks`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `coupons_download`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `coupon_redemption`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `drivers_payouts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `driver_notifications`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `driver_ratings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `driver_settings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `driver_tokens`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `file_uploads`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `login_tokens`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`);

ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`);

ALTER TABLE `nikolag_customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nikolag_customers_email_unique` (`email`),
  ADD UNIQUE KEY `pstype_psid` (`payment_service_type`,`payment_service_id`),
  ADD KEY `nikolag_customers_email_index` (`email`);

ALTER TABLE `nikolag_customer_user`
  ADD UNIQUE KEY `oid_cid` (`owner_id`,`customer_id`);

ALTER TABLE `nikolag_deductibles`
  ADD KEY `nikolag_deductibles_index` (`deductible_type`,`deductible_id`),
  ADD KEY `nikolag_featurables_index` (`featurable_type`,`featurable_id`);

ALTER TABLE `nikolag_discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nikolag_discounts_name_index` (`name`);

ALTER TABLE `nikolag_orders`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `nikolag_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vname_name` (`name`,`variation_name`),
  ADD KEY `nikolag_products_name_index` (`name`),
  ADD KEY `nikolag_products_reference_id_index` (`reference_id`);

ALTER TABLE `nikolag_product_order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `prodid_ordid` (`product_id`,`order_id`);

ALTER TABLE `nikolag_taxes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_type` (`name`,`type`),
  ADD KEY `nikolag_taxes_name_index` (`name`),
  ADD KEY `nikolag_taxes_type_index` (`type`);

ALTER TABLE `nikolag_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nikolag_transactions_status_index` (`status`),
  ADD KEY `nikolag_transactions_payment_service_type_index` (`payment_service_type`),
  ADD KEY `cus_id` (`customer_id`);

ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `product_clicks`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `product_favorites`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `product_variation`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `rejected_deliveries`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `retailers`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `retailers_payouts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`);

ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `sales_retailers`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `sale_delivery_status`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `sale_orders`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tracking`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

ALTER TABLE `vips`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `ads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `ad_clicks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `app_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `cart`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `coupons_clicks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `coupons_download`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `coupon_redemption`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `deliveries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `drivers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `drivers_payouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `driver_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `driver_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `driver_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `driver_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `file_uploads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `login_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=657;

ALTER TABLE `nikolag_customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `nikolag_discounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `nikolag_orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `nikolag_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `nikolag_product_order`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `nikolag_taxes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `nikolag_transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `product_clicks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `product_favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `product_variation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

ALTER TABLE `ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `rejected_deliveries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `retailers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `retailers_payouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `sales_retailers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `sale_delivery_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

ALTER TABLE `sale_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

ALTER TABLE `tracking`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

ALTER TABLE `vips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;


ALTER TABLE `nikolag_product_order`
  ADD CONSTRAINT `prod_id` FOREIGN KEY (`product_id`) REFERENCES `nikolag_products` (`id`);

ALTER TABLE `nikolag_transactions`
  ADD CONSTRAINT `cus_id` FOREIGN KEY (`customer_id`) REFERENCES `nikolag_customers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
