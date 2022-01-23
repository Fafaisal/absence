-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2022 at 03:50 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `SpAbsenceEmployee` (IN `absenceId` INT, IN `userId` INT, IN `imgSelfie` VARCHAR(250), IN `absenceIn` DATETIME, IN `absenceOut` DATETIME, IN `ipAddress` VARCHAR(250), IN `cityName` VARCHAR(250), IN `regionName` VARCHAR(250), IN `countryCode` VARCHAR(250), IN `countryName` VARCHAR(250), IN `Latitude` VARCHAR(250), IN `Longitude` VARCHAR(250))  IF(absenceId IS NULL OR absenceId = '') THEN
INSERT INTO absence (userid, img_selfie, absence_in, ip_address) 
VALUES(userId, imgSelfie, absenceIn, ipAddress);

SET @last_insert_id = last_insert_id();

INSERT INTO absence_location(absence_id, city_name, region_name, country_code, country_name, latitude, longitude, absence_desc)
VALUES(@last_insert_id, cityName, regionName, countryCode, countryName, Latitude, Longitude, 1);
SELECT ROW_COUNT();

ELSE

UPDATE absence SET absence_out = absenceOut, img_selfie_out = imgSelfie, absence_sts=1 WHERE id = absenceId;

INSERT INTO absence_location(absence_id, city_name, region_name, country_code, country_name, latitude, longitude, absence_desc)
VALUES(Id, cityName, regionName, countryCode, countryName, Latitude, Longitude, 2);
SELECT ROW_COUNT();

END IF$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `absence`
--

CREATE TABLE `absence` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `img_selfie` varchar(255) DEFAULT NULL,
  `img_selfie_out` varchar(255) NOT NULL,
  `absence_in` datetime NOT NULL,
  `absence_out` datetime DEFAULT NULL,
  `ip_address` varchar(255) NOT NULL,
  `absence_sts` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `absence`
--

INSERT INTO `absence` (`id`, `userid`, `img_selfie`, `img_selfie_out`, `absence_in`, `absence_out`, `ip_address`, `absence_sts`) VALUES
(2, 20180308, 'TEST2', 'selfie/XUzx0UCmm9.jpeg', '2022-01-23 13:57:25', '2022-01-23 18:58:25', '180.252.83.113', 1),
(3, 20180308, 'TEST2', 'selfie/mwJGchTfXA.jpeg', '2022-01-22 13:57:25', '2022-01-23 18:57:25', '180.252.83.113', 3),
(4, 20180308, 'TEST', 'selfie/mwJGchTfXA.jpeg', '2022-01-22 13:57:25', '2022-01-23 18:57:25', '180.252.83.113', 3),
(5, 20180308, 'TEST', 'selfie/mwJGchTfXA.jpeg', '2022-01-22 13:57:25', '2022-01-23 18:57:25', '180.252.83.113', 3),
(6, 20180308, 'TEST', 'selfie/mwJGchTfXA.jpeg', '2022-01-22 13:57:25', '2022-01-23 18:57:25', '180.252.83.113', 3),
(7, 20180308, 'TEST', 'selfie/mwJGchTfXA.jpeg', '2022-01-22 13:57:25', '2022-01-23 18:57:25', '180.252.83.113', 3),
(8, 20180308, 'TEST', 'selfie/mwJGchTfXA.jpeg', '2022-01-22 13:57:25', '2022-01-23 18:57:25', '180.252.83.113', 3),
(9, 20180308, 'TEST', 'selfie/mwJGchTfXA.jpeg', '2022-01-22 13:57:25', '2022-01-23 18:57:25', '180.252.83.113', 3),
(10, 20180308, 'TEST', 'selfie/mwJGchTfXA.jpeg', '2022-01-22 13:57:25', '2022-01-23 18:57:25', '180.252.83.113', 3),
(11, 20180308, 'TEST', 'selfie/mwJGchTfXA.jpeg', '2022-01-22 13:57:25', '2022-01-23 18:57:25', '180.252.83.113', 3);

-- --------------------------------------------------------

--
-- Table structure for table `absence_location`
--

CREATE TABLE `absence_location` (
  `id` int(11) NOT NULL,
  `absence_id` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `region_name` varchar(255) NOT NULL,
  `country_code` varchar(10) NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `latitude` varchar(20) NOT NULL,
  `longitude` varchar(20) NOT NULL,
  `absence_desc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `absence_location`
--

INSERT INTO `absence_location` (`id`, `absence_id`, `city_name`, `region_name`, `country_code`, `country_name`, `latitude`, `longitude`, `absence_desc`) VALUES
(2, 2, 'Bogor', 'West Java', 'ID', 'Indonesia', '-6.5945', '106.789', 1),
(3, 3, 'Bogor', 'West Java', 'ID', 'Indonesia', '-6.5945', '106.789', 1),
(4, 4, 'Bogor', 'West Java', 'ID', 'Indonesia', '-6.5945', '106.789', 1),
(5, 5, 'Bogor', 'West Java', 'ID', 'Indonesia', '-6.5945', '106.789', 1),
(6, 6, 'Bogor', 'West Java', 'ID', 'Indonesia', '-6.5945', '106.789', 1),
(7, 7, 'Bogor', 'West Java', 'ID', 'Indonesia', '-6.5945', '106.789', 1),
(8, 8, 'Bogor', 'West Java', 'ID', 'Indonesia', '-6.5945', '106.789', 1),
(9, 9, 'Bogor', 'West Java', 'ID', 'Indonesia', '-6.5945', '106.789', 1),
(10, 10, 'Bogor', 'West Java', 'ID', 'Indonesia', '-6.5945', '106.789', 1),
(11, 11, 'Bogor', 'West Java', 'ID', 'Indonesia', '-6.5945', '106.789', 1),
(12, 2, 'Bogor', 'West Java', 'ID', 'Indonesia', '-6.5945', '106.789', 2),
(13, 2, 'Bogor', 'West Java', 'ID', 'Indonesia', '-6.5945', '106.789', 2),
(14, 2, 'Bogor', 'West Java', 'ID', 'Indonesia', '-6.5945', '106.789', 2),
(15, 2, 'Bogor', 'West Java', 'ID', 'Indonesia', '-6.5945', '106.789', 2),
(16, 2, 'Bogor', 'West Java', 'ID', 'Indonesia', '-6.5945', '106.789', 2),
(17, 2, 'Bogor', 'West Java', 'ID', 'Indonesia', '-6.5945', '106.789', 2),
(18, 2, 'Bogor', 'West Java', 'ID', 'Indonesia', '-6.5945', '106.789', 2),
(19, 0, 'Bogor', 'West Java', 'ID', 'Indonesia', '-6.5945', '106.789', 2),
(20, 0, 'Bogor', 'West Java', 'ID', 'Indonesia', '-6.5945', '106.789', 2);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `dep_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `dep_name`) VALUES
(1, 'Accounting'),
(2, 'Human Resource');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `gender` enum('M','F') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `userid`, `email`, `email_verified_at`, `phone_number`, `dept_id`, `gender`, `birthdate`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(5, 'Faisal', 20180308, '6hmadfaisal@gmail.com', NULL, '085692077010', 1, 'M', '1995-06-10', '$2y$10$M..vCkwlvflybX4ZIIZGYu2xWviJZeTlXR3eMRcoozgc7DgdzOg76', NULL, '2022-01-21 22:06:32', '2022-01-21 22:06:32'),
(6, 'Faisal', 20180309, 'ahmad7aisal@gmail.com', NULL, '085692077010', 1, 'M', '1995-06-10', '$2y$10$VpUC9LqqQrJGm8T0pVa5kORJtVb4QjIIwj/tarM0AEnLDO8JkB/Q6', NULL, '2022-01-21 22:12:19', '2022-01-21 22:12:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absence`
--
ALTER TABLE `absence`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `absence_location`
--
ALTER TABLE `absence_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `userid` (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absence`
--
ALTER TABLE `absence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `absence_location`
--
ALTER TABLE `absence_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
