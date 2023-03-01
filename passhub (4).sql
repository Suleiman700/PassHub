-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2023 at 09:49 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `passhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` mediumint(9) NOT NULL,
  `user_id` smallint(6) DEFAULT NULL,
  `name` char(50) DEFAULT NULL,
  `description` char(100) NOT NULL,
  `color` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `user_id`, `name`, `description`, `color`) VALUES
(0, 0, 'Friends', 'Friends passwords', '#39cdfe'),
(1, 0, 'Family', 'Family passwords', '#ff0000'),
(2, 0, 'Personal Social', 'Personal social passwords', '#ff9494');

-- --------------------------------------------------------

--
-- Table structure for table `failed_logins`
--

CREATE TABLE `failed_logins` (
  `id` int(11) NOT NULL,
  `user_id` smallint(6) DEFAULT NULL,
  `used_password` char(255) DEFAULT NULL,
  `used_pin_code` char(255) DEFAULT NULL,
  `fail_reason` char(255) DEFAULT NULL,
  `ip_address` char(100) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `failed_logins`
--

INSERT INTO `failed_logins` (`id`, `user_id`, `used_password`, `used_pin_code`, `fail_reason`, `ip_address`, `user_agent`, `login_time`) VALUES
(35, 0, '1234', '1233', 'Invalid pin code', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36', '2023-02-24 13:34:33'),
(36, 0, '1234', '1233', 'Invalid pin code', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36', '2023-02-24 13:44:29'),
(37, 0, '1234', '1233', 'Invalid pin code', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36', '2023-02-24 16:12:37'),
(38, 0, '1234', '1234', 'Invalid password', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36', '2023-02-27 18:54:02'),
(39, 0, '123', '1234', 'Invalid password', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36', '2023-02-27 18:56:16'),
(40, 0, '123', '1234', 'Invalid password', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36', '2023-02-27 18:57:38'),
(41, 0, '1234', '1234', 'Invalid pin code', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36', '2023-02-27 19:45:30');

-- --------------------------------------------------------

--
-- Table structure for table `passwords`
--

CREATE TABLE `passwords` (
  `id` mediumint(9) NOT NULL,
  `user_id` smallint(6) NOT NULL,
  `category_id` mediumint(9) NOT NULL,
  `username` char(255) NOT NULL,
  `password` char(255) NOT NULL,
  `website` char(255) DEFAULT NULL,
  `description` char(255) DEFAULT NULL,
  `note` char(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `passwords`
--

INSERT INTO `passwords` (`id`, `user_id`, `category_id`, `username`, `password`, `website`, `description`, `note`, `created_at`, `updated_at`) VALUES
(0, 0, 0, 'jhad facebook 2fa backup codes', 'yd4lhNnyRTMKDqH6onJdxSPSBK4/JOPp22k8o0nJbV4=', 'https://facebook.com/', 'jhad facebook 2fa backup codes', '00543125\\n12310948\\n30074240\\n31307317\\n42053022\\n47403520\\n52299222\\n55068670\\n67673043\\n85074813', '2023-02-12 22:25:55', '2023-02-12 23:22:16'),
(1, 0, 1, 'soleman167@gmail.com', '9rPcj5Hff7NYwssHqVuquIKGJlZt5ri3EpkR5WWm8cI=', 'https://facebook.com/', 'Father facebook', '', '2023-02-12 23:22:46', '2023-02-12 23:24:15'),
(2, 0, 2, 'xapigun@zdfpost.net', '4X20q1N2PWuqLJg50Sa6TQ==', 'https://facebook.com/', 'Marah Hijazi Facebook', '', '2023-02-14 20:31:42', '2023-02-14 20:31:42');

-- --------------------------------------------------------

--
-- Table structure for table `smtp_settings`
--

CREATE TABLE `smtp_settings` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `smtp_server` char(255) NOT NULL,
  `smtp_username` char(255) NOT NULL,
  `smtp_password` char(255) NOT NULL,
  `smtp_auth` char(10) DEFAULT NULL,
  `smtp_secure` char(10) NOT NULL,
  `smtp_port` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `smtp_settings`
--

INSERT INTO `smtp_settings` (`id`, `smtp_server`, `smtp_username`, `smtp_password`, `smtp_auth`, `smtp_secure`, `smtp_port`) VALUES
(1, 'smtp.hostinger.com', 'passhub@nicurb.com', 'A4%stP72Uu31', 'true', 'tls', 587);

-- --------------------------------------------------------

--
-- Table structure for table `successful_logins`
--

CREATE TABLE `successful_logins` (
  `id` int(11) NOT NULL,
  `user_id` smallint(6) DEFAULT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip_address` char(100) NOT NULL,
  `user_agent` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `successful_logins`
--

INSERT INTO `successful_logins` (`id`, `user_id`, `login_time`, `ip_address`, `user_agent`) VALUES
(41, 0, '2023-02-19 23:25:37', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36'),
(42, 0, '2023-02-20 18:35:29', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36'),
(43, 0, '2023-02-24 13:46:01', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36'),
(44, 0, '2023-02-24 13:53:34', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36'),
(45, 0, '2023-02-24 16:12:40', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36'),
(46, 0, '2023-02-24 16:16:12', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36'),
(47, 0, '2023-02-26 22:08:52', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36'),
(48, 0, '2023-02-27 18:33:20', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36'),
(49, 0, '2023-02-27 18:54:26', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36'),
(50, 0, '2023-02-27 18:56:18', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36'),
(51, 0, '2023-02-27 18:57:40', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36'),
(52, 0, '2023-02-27 19:43:07', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36'),
(53, 0, '2023-02-27 19:45:32', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36'),
(54, 0, '2023-03-01 20:05:34', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` smallint(6) NOT NULL,
  `fullname` char(50) DEFAULT NULL,
  `email` char(50) DEFAULT NULL,
  `password` char(100) DEFAULT NULL,
  `pin_code` char(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `pin_code`) VALUES
(0, 'Jaber Suleiman', 'soleman630@gmail.com', '$2y$10$cA0e8HLCRfVu7e1yZlyz2u7ceV38w.RcKNqOqoxn5EmPnVYFT8CTq', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `users_keys`
--

CREATE TABLE `users_keys` (
  `id` smallint(6) NOT NULL,
  `user_id` smallint(6) NOT NULL,
  `secret_key` char(100) DEFAULT NULL,
  `secret_iv` char(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users_keys`
--

INSERT INTO `users_keys` (`id`, `user_id`, `secret_key`, `secret_iv`) VALUES
(0, 0, 'YSvaZKQdbzljPzeWVE2qYnrDcdOVprg53yYgYzHbbqo=', '855sOQEHTbjWV3g79YMz0w==');

-- --------------------------------------------------------

--
-- Table structure for table `users_settings`
--

CREATE TABLE `users_settings` (
  `id` smallint(6) NOT NULL,
  `user_id` smallint(6) DEFAULT NULL,
  `enable_2fa` char(1) DEFAULT '0',
  `twofactor_code` char(6) DEFAULT NULL,
  `enable_login_alerts` char(1) DEFAULT '0',
  `enable_password_change_alert` char(1) DEFAULT '0',
  `enabled_pin_code_change_alert` char(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users_settings`
--

INSERT INTO `users_settings` (`id`, `user_id`, `enable_2fa`, `twofactor_code`, `enable_login_alerts`, `enable_password_change_alert`, `enabled_pin_code_change_alert`) VALUES
(0, 0, '1', '877158', '1', '1', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `failed_logins`
--
ALTER TABLE `failed_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `passwords`
--
ALTER TABLE `passwords`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `smtp_settings`
--
ALTER TABLE `smtp_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `successful_logins`
--
ALTER TABLE `successful_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_keys`
--
ALTER TABLE `users_keys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users_settings`
--
ALTER TABLE `users_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_logins`
--
ALTER TABLE `failed_logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `smtp_settings`
--
ALTER TABLE `smtp_settings`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `successful_logins`
--
ALTER TABLE `successful_logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `failed_logins`
--
ALTER TABLE `failed_logins`
  ADD CONSTRAINT `failed_logins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `passwords`
--
ALTER TABLE `passwords`
  ADD CONSTRAINT `passwords_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `passwords_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `successful_logins`
--
ALTER TABLE `successful_logins`
  ADD CONSTRAINT `successful_logins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users_keys`
--
ALTER TABLE `users_keys`
  ADD CONSTRAINT `users_keys_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users_settings`
--
ALTER TABLE `users_settings`
  ADD CONSTRAINT `users_settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
