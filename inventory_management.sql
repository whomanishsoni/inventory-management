-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 07, 2025 at 04:50 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `user` text NOT NULL,
  `ip_address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `title`, `user`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 'New Permission #21 Created by User: #1', '1', '::1', '2023-12-06 15:19:23', '2023-12-06 15:19:23'),
(2, 'Role #1 Updated by User: #1', '1', '::1', '2023-12-06 15:19:34', '2023-12-06 15:19:34'),
(3, 'Company Settings Updated by User: #1', '1', '::1', '2023-12-07 05:12:19', '2023-12-07 05:12:19'),
(4, 'New Permission #22 Created by User: #1', '1', '::1', '2023-12-07 05:15:31', '2023-12-07 05:15:31'),
(5, 'Role #1 Updated by User: #1', '1', '::1', '2023-12-07 05:15:42', '2023-12-07 05:15:42'),
(6, 'New Role #4 Created by User: #1', '1', '::1', '2023-12-07 05:17:26', '2023-12-07 05:17:26'),
(7, 'Role #4 Deleted by User:Administrator', '1', '::1', '2023-12-07 05:18:59', '2023-12-07 05:18:59'),
(8, 'New Permission #23 Created by User: #1', '1', '::1', '2023-12-07 05:24:07', '2023-12-07 05:24:07'),
(9, 'Role #1 Updated by User: #1', '1', '::1', '2023-12-07 05:24:17', '2023-12-07 05:24:17'),
(10, 'Permission #23 Updated by User: #1', '1', '::1', '2023-12-10 07:59:22', '2023-12-10 07:59:22'),
(11, 'Role #1 Updated by User: #1', '1', '::1', '2023-12-10 07:59:38', '2023-12-10 07:59:38'),
(12, 'Permission #23 Updated by User: #1', '1', '::1', '2023-12-10 09:55:00', '2023-12-10 09:55:00'),
(13, 'Permission #23 Updated by User: #1', '1', '::1', '2023-12-10 09:56:03', '2023-12-10 09:56:03'),
(14, 'Role #1 Updated by User: #1', '1', '::1', '2023-12-10 09:56:12', '2023-12-10 09:56:12'),
(15, 'New Permission #24 Created by User: #1', '1', '::1', '2023-12-13 11:05:58', '2023-12-13 11:05:58'),
(16, 'Role #1 Updated by User: #1', '1', '::1', '2023-12-13 11:06:06', '2023-12-13 11:06:06'),
(17, 'New Permission #25 Created by User: #1', '1', '::1', '2023-12-13 11:30:10', '2023-12-13 11:30:10'),
(18, 'Role #1 Updated by User: #1', '1', '::1', '2023-12-13 11:30:21', '2023-12-13 11:30:21'),
(19, 'New Permission #26 Created by User: #1', '1', '::1', '2023-12-13 11:37:53', '2023-12-13 11:37:53'),
(20, 'New Permission #27 Created by User: #1', '1', '::1', '2023-12-13 11:38:16', '2023-12-13 11:38:16'),
(21, 'Role #1 Updated by User: #1', '1', '::1', '2023-12-13 11:38:30', '2023-12-13 11:38:30'),
(22, 'New Brand #3 Created by User: #1', '1', '::1', '2023-12-14 08:33:38', '2023-12-14 08:33:38'),
(23, 'Brand #3 Deleted by User:Administrator', '1', '::1', '2023-12-14 08:34:04', '2023-12-14 08:34:04'),
(24, 'New Brand #4 Created by User: #1', '1', '::1', '2023-12-14 08:34:15', '2023-12-14 08:34:15'),
(25, 'Brand #4 Deleted by User:Administrator', '1', '::1', '2023-12-14 08:35:21', '2023-12-14 08:35:21'),
(26, 'New Brand #5 Created by User: #1', '1', '::1', '2023-12-14 08:38:19', '2023-12-14 08:38:19'),
(27, 'Brand #5 Deleted by User:Administrator', '1', '::1', '2023-12-14 08:38:24', '2023-12-14 08:38:24'),
(28, 'New Brand #6 Created by User: #1', '1', '::1', '2023-12-14 08:38:35', '2023-12-14 08:38:35'),
(29, 'New Brand #7 Created by User: #1', '1', '::1', '2023-12-14 08:39:12', '2023-12-14 08:39:12'),
(30, 'Brand #7 Deleted by User:Administrator', '1', '::1', '2023-12-14 08:39:18', '2023-12-14 08:39:18'),
(31, 'New Brand #8 Created by User: #1', '1', '::1', '2023-12-14 08:43:15', '2023-12-14 08:43:15'),
(32, 'New Brand #9 Created by User: #1', '1', '::1', '2023-12-14 08:43:30', '2023-12-14 08:43:30'),
(33, 'Brand #9 Deleted by User:Administrator', '1', '::1', '2023-12-14 08:43:40', '2023-12-14 08:43:40'),
(34, 'Brand #8 Deleted by User:Administrator', '1', '::1', '2023-12-14 08:43:45', '2023-12-14 08:43:45'),
(35, 'New Role #5 Created by User: #1', '1', '::1', '2023-12-15 05:01:14', '2023-12-15 05:01:14'),
(36, 'Role #5 Deleted by User:Administrator', '1', '::1', '2023-12-15 05:01:26', '2023-12-15 05:01:26'),
(37, 'Brand #1 Updated by User: #1', '1', '::1', '2023-12-15 05:30:06', '2023-12-15 05:30:06'),
(38, 'Brand #1 Updated by User: #1', '1', '::1', '2023-12-15 05:30:18', '2023-12-15 05:30:18'),
(39, 'Brand #1 Updated by User: #1', '1', '::1', '2023-12-15 05:36:23', '2023-12-15 05:36:23'),
(40, 'New Brand #10 Created by User: #1', '1', '::1', '2023-12-15 05:37:12', '2023-12-15 05:37:12'),
(41, 'Brand #10 Deleted by User:Administrator', '1', '::1', '2023-12-15 05:39:57', '2023-12-15 05:39:57'),
(42, 'New Brand #11 Created by User: #1', '1', '::1', '2023-12-15 05:40:10', '2023-12-15 05:40:10'),
(43, 'Brand #11 Updated by User: #1', '1', '::1', '2023-12-15 05:40:43', '2023-12-15 05:40:43'),
(44, 'Brand #11 Updated by User: #1', '1', '::1', '2023-12-15 05:41:10', '2023-12-15 05:41:10'),
(45, 'Brand #11 Deleted by User:Administrator', '1', '::1', '2023-12-15 05:41:44', '2023-12-15 05:41:44'),
(46, 'New User $7 Created by User:Administrator', '1', '::1', '2023-12-18 15:30:25', '2023-12-18 15:30:25'),
(47, 'Role #2 Updated by User: #1', '1', '::1', '2023-12-18 15:31:05', '2023-12-18 15:31:05'),
(48, 'Role #2 Updated by User: #1', '1', '::1', '2023-12-18 15:31:53', '2023-12-18 15:31:53'),
(49, 'Role #2 Updated by User: #1', '1', '::1', '2023-12-18 15:43:58', '2023-12-18 15:43:58'),
(50, 'Permission #23 Deleted by User: #1', '1', '::1', '2024-02-19 08:42:44', '2024-02-19 08:42:44'),
(51, 'Permission #27 Deleted by User: #1', '1', '::1', '2024-02-19 08:42:50', '2024-02-19 08:42:50'),
(52, 'Permission #26 Deleted by User: #1', '1', '::1', '2024-02-19 08:42:55', '2024-02-19 08:42:55'),
(53, 'Permission #25 Deleted by User: #1', '1', '::1', '2024-02-19 08:43:00', '2024-02-19 08:43:00'),
(54, 'Permission #24 Deleted by User: #1', '1', '::1', '2024-02-19 08:43:06', '2024-02-19 08:43:06'),
(55, 'Permission #21 Deleted by User: #1', '1', '::1', '2024-02-19 09:44:22', '2024-02-19 09:44:22'),
(56, 'New Permission #28 Created by User: #1', '1', '::1', '2024-02-19 10:02:09', '2024-02-19 10:02:09'),
(57, 'Role #1 Updated by User: #1', '1', '::1', '2024-02-19 10:02:26', '2024-02-19 10:02:26'),
(58, 'New Permission #29 Created by User: #1', '1', '::1', '2024-02-19 10:59:59', '2024-02-19 10:59:59'),
(59, 'New Permission #30 Created by User: #1', '1', '::1', '2024-02-19 11:01:04', '2024-02-19 11:01:04'),
(60, 'Permission #30 Updated by User: #1', '1', '::1', '2024-02-19 11:01:18', '2024-02-19 11:01:18'),
(61, 'New Permission #31 Created by User: #1', '1', '::1', '2024-02-19 11:01:53', '2024-02-19 11:01:53'),
(62, 'New Permission #32 Created by User: #1', '1', '::1', '2024-02-19 11:02:37', '2024-02-19 11:02:37'),
(63, 'Role #1 Updated by User: #1', '1', '::1', '2024-02-19 11:05:37', '2024-02-19 11:05:37'),
(64, 'New Permission #33 Created by User: #1', '1', '::1', '2024-02-20 14:46:41', '2024-02-20 14:46:41'),
(65, 'New Permission #34 Created by User: #1', '1', '::1', '2024-02-20 14:47:41', '2024-02-20 14:47:41'),
(66, 'New Permission #35 Created by User: #1', '1', '::1', '2024-02-20 14:48:25', '2024-02-20 14:48:25'),
(67, 'New Permission #36 Created by User: #1', '1', '::1', '2024-02-20 14:48:55', '2024-02-20 14:48:55'),
(68, 'Role #1 Updated by User: #1', '1', '::1', '2024-02-20 14:49:17', '2024-02-20 14:49:17'),
(69, 'New Permission #37 Created by User: #1', '1', '::1', '2024-02-21 14:39:58', '2024-02-21 14:39:58'),
(70, 'New Permission #38 Created by User: #1', '1', '::1', '2024-02-21 14:40:32', '2024-02-21 14:40:32'),
(71, 'New Permission #39 Created by User: #1', '1', '::1', '2024-02-21 14:40:56', '2024-02-21 14:40:56'),
(72, 'New Permission #40 Created by User: #1', '1', '::1', '2024-02-21 14:41:14', '2024-02-21 14:41:14'),
(73, 'Role #1 Updated by User: #1', '1', '::1', '2024-02-21 14:41:26', '2024-02-21 14:41:26'),
(74, 'New Permission #41 Created by User: #1', '1', '::1', '2024-02-22 14:07:36', '2024-02-22 14:07:36'),
(75, 'New Permission #42 Created by User: #1', '1', '::1', '2024-02-22 14:08:06', '2024-02-22 14:08:06'),
(76, 'New Permission #43 Created by User: #1', '1', '::1', '2024-02-22 14:08:24', '2024-02-22 14:08:24'),
(77, 'New Permission #44 Created by User: #1', '1', '::1', '2024-02-22 14:08:40', '2024-02-22 14:08:40'),
(78, 'New Permission #45 Created by User: #1', '1', '::1', '2024-02-22 14:09:30', '2024-02-22 14:09:30'),
(79, 'New Permission #46 Created by User: #1', '1', '::1', '2024-02-22 14:10:11', '2024-02-22 14:10:11'),
(80, 'New Permission #47 Created by User: #1', '1', '::1', '2024-02-22 14:10:33', '2024-02-22 14:10:33'),
(81, 'New Permission #48 Created by User: #1', '1', '::1', '2024-02-22 14:10:51', '2024-02-22 14:10:51'),
(82, 'Role #1 Updated by User: #1', '1', '::1', '2024-02-22 14:11:32', '2024-02-22 14:11:32'),
(83, 'New Permission #49 Created by User: #1', '1', '::1', '2024-02-27 15:23:53', '2024-02-27 15:23:53'),
(84, 'New Permission #50 Created by User: #1', '1', '::1', '2024-02-27 15:33:56', '2024-02-27 15:33:56'),
(85, 'New Permission #51 Created by User: #1', '1', '::1', '2024-02-27 15:34:24', '2024-02-27 15:34:24'),
(86, 'New Permission #52 Created by User: #1', '1', '::1', '2024-02-27 15:34:46', '2024-02-27 15:34:46'),
(87, 'Role #1 Updated by User: #1', '1', '::1', '2024-02-27 15:35:09', '2024-02-27 15:35:09'),
(88, 'New Permission #53 Created by User: #1', '1', '::1', '2024-03-24 05:47:48', '2024-03-24 05:47:48'),
(89, 'New Permission #54 Created by User: #1', '1', '::1', '2024-03-24 05:48:36', '2024-03-24 05:48:36'),
(90, 'New Permission #55 Created by User: #1', '1', '::1', '2024-03-24 05:48:59', '2024-03-24 05:48:59'),
(91, 'New Permission #56 Created by User: #1', '1', '::1', '2024-03-24 05:49:18', '2024-03-24 05:49:18'),
(92, 'New Permission #57 Created by User: #1', '1', '::1', '2024-03-24 05:49:18', '2024-03-24 05:49:18'),
(93, 'Permission #57 Deleted by User: #1', '1', '::1', '2024-03-24 05:50:20', '2024-03-24 05:50:20'),
(94, 'Permission #56 Deleted by User: #1', '1', '::1', '2024-03-24 05:50:28', '2024-03-24 05:50:28'),
(95, 'New Permission #58 Created by User: #1', '1', '::1', '2024-03-24 05:50:48', '2024-03-24 05:50:48'),
(96, 'Role #1 Updated by User: #1', '1', '::1', '2024-03-24 05:51:05', '2024-03-24 05:51:05'),
(97, 'New Permission #59 Created by User: #1', '1', '::1', '2024-03-31 10:15:35', '2024-03-31 10:15:35'),
(98, 'New Permission #60 Created by User: #1', '1', '::1', '2024-03-31 10:15:36', '2024-03-31 10:15:36'),
(99, 'New Permission #61 Created by User: #1', '1', '::1', '2024-03-31 10:15:37', '2024-03-31 10:15:37'),
(100, 'Permission #59 Deleted by User: #1', '1', '::1', '2024-03-31 10:15:51', '2024-03-31 10:15:51'),
(101, 'Permission #60 Deleted by User: #1', '1', '::1', '2024-03-31 10:16:01', '2024-03-31 10:16:01'),
(102, 'Permission #61 Deleted by User: #1', '1', '::1', '2024-03-31 10:16:08', '2024-03-31 10:16:08'),
(103, 'New Permission #62 Created by User: #1', '1', '::1', '2024-03-31 10:16:40', '2024-03-31 10:16:40'),
(104, 'New Permission #63 Created by User: #1', '1', '::1', '2024-03-31 10:17:16', '2024-03-31 10:17:16'),
(105, 'New Permission #64 Created by User: #1', '1', '::1', '2024-03-31 10:17:49', '2024-03-31 10:17:49'),
(106, 'New Permission #65 Created by User: #1', '1', '::1', '2024-03-31 10:18:09', '2024-03-31 10:18:09'),
(107, 'New Permission #66 Created by User: #1', '1', '::1', '2024-03-31 10:18:42', '2024-03-31 10:18:42'),
(108, 'New Permission #67 Created by User: #1', '1', '::1', '2024-03-31 10:19:29', '2024-03-31 10:19:29'),
(109, 'New Permission #68 Created by User: #1', '1', '::1', '2024-03-31 10:19:59', '2024-03-31 10:19:59'),
(110, 'New Permission #69 Created by User: #1', '1', '::1', '2024-03-31 10:20:29', '2024-03-31 10:20:29'),
(111, 'Permission #69 Updated by User: #1', '1', '::1', '2024-03-31 10:20:46', '2024-03-31 10:20:46'),
(112, 'Role #1 Updated by User: #1', '1', '::1', '2024-03-31 10:21:22', '2024-03-31 10:21:22'),
(113, 'Role #1 Updated by User: #1', '1', '::1', '2024-03-31 10:52:01', '2024-03-31 10:52:01'),
(114, 'Permission #66 Updated by User: #1', '1', '::1', '2024-03-31 10:57:36', '2024-03-31 10:57:36'),
(115, 'Permission #66 Updated by User: #1', '1', '::1', '2024-03-31 10:57:55', '2024-03-31 10:57:55'),
(116, 'Permission #66 Updated by User: #1', '1', '::1', '2024-03-31 10:57:55', '2024-03-31 10:57:55'),
(117, 'Permission #66 Deleted by User: #1', '1', '::1', '2024-03-31 11:04:55', '2024-03-31 11:04:55'),
(118, 'New Permission #70 Created by User: #1', '1', '::1', '2024-03-31 11:05:26', '2024-03-31 11:05:26'),
(119, 'Permission #70 Updated by User: #1', '1', '::1', '2024-03-31 11:07:45', '2024-03-31 11:07:45'),
(120, 'Role #1 Updated by User: #1', '1', '::1', '2024-03-31 11:08:17', '2024-03-31 11:08:17'),
(121, 'Permission #70 Deleted by User: #1', '1', '::1', '2024-03-31 11:34:29', '2024-03-31 11:34:29'),
(122, 'Permission #69 Deleted by User: #1', '1', '::1', '2024-03-31 11:34:38', '2024-03-31 11:34:38'),
(123, 'Permission #68 Deleted by User: #1', '1', '::1', '2024-03-31 11:34:44', '2024-03-31 11:34:44'),
(124, 'Permission #67 Deleted by User: #1', '1', '::1', '2024-03-31 11:35:05', '2024-03-31 11:35:05'),
(125, 'New Permission #71 Created by User: #1', '1', '::1', '2024-03-31 11:36:43', '2024-03-31 11:36:43'),
(126, 'Role #1 Updated by User: #1', '1', '::1', '2024-03-31 11:36:58', '2024-03-31 11:36:58'),
(127, 'Permission #71 Updated by User: #1', '1', '::1', '2024-03-31 11:37:36', '2024-03-31 11:37:36'),
(128, 'New Permission #72 Created by User: #1', '1', '::1', '2024-03-31 11:38:09', '2024-03-31 11:38:09'),
(129, 'New Permission #73 Created by User: #1', '1', '::1', '2024-03-31 11:38:28', '2024-03-31 11:38:28'),
(130, 'New Permission #74 Created by User: #1', '1', '::1', '2024-03-31 11:39:01', '2024-03-31 11:39:01'),
(131, 'Role #1 Updated by User: #1', '1', '::1', '2024-03-31 11:40:24', '2024-03-31 11:40:24'),
(132, 'New Permission #75 Created by User: #1', '1', '::1', '2024-04-06 12:33:57', '2024-04-06 12:33:57'),
(133, 'Role #1 Updated by User: #1', '1', '::1', '2024-04-06 12:51:48', '2024-04-06 12:51:48'),
(134, 'New Permission #76 Created by User: #1', '1', '::1', '2024-04-06 12:52:58', '2024-04-06 12:52:58'),
(135, 'Role #1 Updated by User: #1', '1', '::1', '2024-04-06 12:53:12', '2024-04-06 12:53:12'),
(136, 'Company Settings Updated by User: #1', '1', '::1', '2024-04-21 05:10:37', '2024-04-21 05:10:37'),
(137, 'New Permission #77 Created by User: #1', '1', '::1', '2024-06-24 08:43:56', '2024-06-24 08:43:56'),
(138, 'Role #1 Updated by User: #1', '1', '::1', '2024-06-24 08:44:08', '2024-06-24 08:44:08'),
(139, 'New Permission #78 Created by User: #1', '1', '::1', '2024-06-24 08:48:46', '2024-06-24 08:48:46'),
(140, 'New Permission #79 Created by User: #1', '1', '::1', '2024-06-24 08:49:01', '2024-06-24 08:49:01'),
(141, 'New Permission #80 Created by User: #1', '1', '::1', '2024-06-24 08:49:21', '2024-06-24 08:49:21'),
(142, 'New Permission #81 Created by User: #1', '1', '::1', '2024-06-24 08:49:37', '2024-06-24 08:49:37'),
(143, 'New Permission #82 Created by User: #1', '1', '::1', '2024-06-24 08:50:26', '2024-06-24 08:50:26'),
(144, 'New Permission #83 Created by User: #1', '1', '::1', '2024-06-24 08:50:49', '2024-06-24 08:50:49'),
(145, 'New Permission #84 Created by User: #1', '1', '::1', '2024-06-24 08:51:11', '2024-06-24 08:51:11'),
(146, 'New Permission #85 Created by User: #1', '1', '::1', '2024-06-24 08:51:26', '2024-06-24 08:51:26'),
(147, 'New Permission #86 Created by User: #1', '1', '::1', '2024-06-24 08:51:48', '2024-06-24 08:51:48'),
(148, 'New Permission #87 Created by User: #1', '1', '::1', '2024-06-24 08:52:17', '2024-06-24 08:52:17'),
(149, 'New Permission #88 Created by User: #1', '1', '::1', '2024-06-24 08:53:41', '2024-06-24 08:53:41'),
(150, 'New Permission #89 Created by User: #1', '1', '::1', '2024-06-24 08:54:05', '2024-06-24 08:54:05'),
(151, 'Role #1 Updated by User: #1', '1', '::1', '2024-06-24 08:54:24', '2024-06-24 08:54:24'),
(152, 'New Permission #90 Created by User: #1', '1', '::1', '2024-06-24 10:48:35', '2024-06-24 10:48:35'),
(153, 'New Permission #91 Created by User: #1', '1', '::1', '2024-06-24 10:48:56', '2024-06-24 10:48:56'),
(154, 'New Permission #92 Created by User: #1', '1', '::1', '2024-06-24 10:49:45', '2024-06-24 10:49:45'),
(155, 'New Permission #93 Created by User: #1', '1', '::1', '2024-06-24 10:50:01', '2024-06-24 10:50:01'),
(156, 'New Permission #94 Created by User: #1', '1', '::1', '2024-06-24 10:51:08', '2024-06-24 10:51:08'),
(157, 'Role #1 Updated by User: #1', '1', '::1', '2024-06-24 10:51:28', '2024-06-24 10:51:28'),
(158, 'New Permission #95 Created by User: #1', '1', '::1', '2024-06-24 10:52:13', '2024-06-24 10:52:13'),
(159, 'Permission #95 Deleted by User: #1', '1', '::1', '2024-06-24 10:52:33', '2024-06-24 10:52:33'),
(160, 'New Permission #96 Created by User: #1', '1', '::1', '2024-06-24 10:53:03', '2024-06-24 10:53:03'),
(161, 'New Permission #97 Created by User: #1', '1', '::1', '2024-06-24 10:53:28', '2024-06-24 10:53:28'),
(162, 'New Permission #98 Created by User: #1', '1', '::1', '2024-06-24 10:53:48', '2024-06-24 10:53:48'),
(163, 'New Permission #99 Created by User: #1', '1', '::1', '2024-06-24 10:54:29', '2024-06-24 10:54:29'),
(164, 'New Permission #100 Created by User: #1', '1', '::1', '2024-06-24 10:55:03', '2024-06-24 10:55:03'),
(165, 'New Permission #101 Created by User: #1', '1', '::1', '2024-06-24 10:55:43', '2024-06-24 10:55:43'),
(166, 'New Permission #102 Created by User: #1', '1', '::1', '2024-06-24 10:56:07', '2024-06-24 10:56:07'),
(167, 'New Permission #103 Created by User: #1', '1', '::1', '2024-06-24 10:56:42', '2024-06-24 10:56:42'),
(168, 'New Permission #104 Created by User: #1', '1', '::1', '2024-06-24 10:57:14', '2024-06-24 10:57:14'),
(169, 'Role #1 Updated by User: #1', '1', '::1', '2024-06-24 10:57:52', '2024-06-24 10:57:52'),
(170, 'New Permission #105 Created by User: #1', '1', '::1', '2024-06-24 11:05:19', '2024-06-24 11:05:19'),
(171, 'New Permission #106 Created by User: #1', '1', '::1', '2024-06-24 11:05:58', '2024-06-24 11:05:58'),
(172, 'Permission #106 Updated by User: #1', '1', '::1', '2024-06-24 11:06:10', '2024-06-24 11:06:10'),
(173, 'New Permission #107 Created by User: #1', '1', '::1', '2024-06-24 11:06:46', '2024-06-24 11:06:46'),
(174, 'New Permission #108 Created by User: #1', '1', '::1', '2024-06-24 11:07:05', '2024-06-24 11:07:05'),
(175, 'New Permission #109 Created by User: #1', '1', '::1', '2024-06-24 11:07:37', '2024-06-24 11:07:37'),
(176, 'Role #1 Updated by User: #1', '1', '::1', '2024-06-24 11:08:15', '2024-06-24 11:08:15'),
(177, 'New Permission #110 Created by User: #1', '1', '::1', '2024-07-12 05:36:30', '2024-07-12 05:36:30'),
(178, 'Role #1 Updated by User: #1', '1', '::1', '2024-07-12 05:37:29', '2024-07-12 05:37:29');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
CREATE TABLE IF NOT EXISTS `brands` (
  `id` int NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(255) NOT NULL,
  `brand_status` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand_name`, `brand_status`, `created_at`, `updated_at`) VALUES
(1, 'Nike', 'active', '2024-07-14 15:43:11', '2024-07-14 15:43:11'),
(2, 'Adidas', 'active', '2024-07-14 15:43:11', '2024-07-14 15:43:11'),
(3, 'Apple', 'active', '2024-07-14 15:43:11', '2024-07-14 15:43:11'),
(4, 'Samsung', 'active', '2024-07-14 15:43:11', '2024-07-14 15:43:11'),
(5, 'Sony', 'active', '2024-07-14 15:43:11', '2024-07-15 04:35:09'),
(6, 'LG', 'active', '2024-07-14 15:43:11', '2024-07-14 15:43:11'),
(7, 'Microsoft', 'active', '2024-07-14 15:43:11', '2024-07-14 15:43:11'),
(8, 'Toyota', 'active', '2024-07-14 15:43:11', '2024-07-14 15:43:11'),
(9, 'Honda', 'active', '2024-07-14 15:43:11', '2024-07-15 04:35:07'),
(10, 'Ford', 'active', '2024-07-14 15:43:11', '2024-07-14 15:43:11');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `category_description` text,
  `category_status` varchar(50) DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `category_description`, `category_status`, `created_at`, `updated_at`) VALUES
(1, 'Electronics', NULL, 'active', '2024-07-14 15:44:14', '2024-07-14 15:44:14'),
(2, 'Clothing', NULL, 'active', '2024-07-14 15:44:14', '2024-07-14 15:44:14'),
(3, 'Automobile', NULL, 'active', '2024-07-14 15:44:14', '2024-07-14 15:44:14'),
(4, 'Furniture', NULL, 'active', '2024-07-14 15:44:14', '2024-07-15 04:27:43'),
(5, 'Sports', NULL, 'active', '2024-07-14 15:44:14', '2024-07-14 15:44:14');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `city_name` varchar(255) NOT NULL,
  `state_id` int UNSIGNED NOT NULL,
  `country_id` int UNSIGNED NOT NULL,
  `city_status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `state_id` (`state_id`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `city_name`, `state_id`, `country_id`, `city_status`, `created_at`, `updated_at`) VALUES
(7, 'bhilwara', 3, 1, 'active', '2024-06-25 13:03:49', '2024-06-25 13:04:39'),
(6, 'pune', 5, 1, 'active', '2024-06-25 13:02:45', '2024-06-25 13:03:19');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `country_name` varchar(255) NOT NULL,
  `country_status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_name`, `country_status`, `created_at`, `updated_at`) VALUES
(1, 'India', 'active', '2024-06-24 08:55:44', '2024-06-24 08:55:44');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `customer_address` text NOT NULL,
  `customer_pincode` varchar(20) NOT NULL,
  `city_id` int UNSIGNED NOT NULL,
  `state_id` int UNSIGNED NOT NULL,
  `country_id` int UNSIGNED NOT NULL,
  `customer_status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `city_id` (`city_id`),
  KEY `state_id` (`state_id`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `customer_pincode`, `city_id`, `state_id`, `country_id`, `customer_status`, `created_at`, `updated_at`) VALUES
(1, 'abc', 'abc@gmail.com', '9460966996', 'bhilwara', '311001', 7, 3, 1, 'active', '2024-07-12 05:34:28', '2024-07-12 05:34:28'),
(2, 'aaaa', 'asdasdas@gmail.com', '9444555000', 'sdfsdf', '310011', 7, 3, 1, 'active', '2024-10-25 12:19:47', '2024-10-25 12:19:47');

-- --------------------------------------------------------

--
-- Table structure for table `customer_transactions`
--

DROP TABLE IF EXISTS `customer_transactions`;
CREATE TABLE IF NOT EXISTS `customer_transactions` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` int UNSIGNED NOT NULL,
  `transaction_type` enum('credit','debit') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `transaction_date` datetime NOT NULL,
  `description` text,
  `reference_id` varchar(255) DEFAULT NULL,
  `created_by` int UNSIGNED NOT NULL,
  `updated_by` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer_transactions`
--

INSERT INTO `customer_transactions` (`id`, `customer_id`, `transaction_type`, `amount`, `balance`, `transaction_date`, `description`, `reference_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(8, 1, 'debit', 11.00, -11.00, '2024-10-25 00:00:00', 'asdasd', 'asdasd', 1, NULL, '2024-10-25 12:20:41', '2024-10-25 12:20:41'),
(7, 2, 'credit', 111.00, 111.00, '2024-10-25 00:00:00', '1111qsdasd', 'asdasdasd', 1, NULL, '2024-10-25 12:20:11', '2024-10-25 12:20:11');

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

DROP TABLE IF EXISTS `email_templates`;
CREATE TABLE IF NOT EXISTS `email_templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `code` text NOT NULL,
  `data` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `name`, `code`, `data`, `created_at`) VALUES
(1, 'Reset Password Template', 'reset_password', '<h1><strong>{company_name}</strong></h1>\r\n\r\n<h3>Click on Reset Link to Proceed : <a href=\"{reset_link}\">Reset Now</a></h3>\r\n', '2020-01-03 00:10:14');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2023-12-13-111332', 'App\\Database\\Migrations\\CreateBrandsTable', 'default', 'App', 1702466073, 1);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `code` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `title`, `code`) VALUES
(1, 'Users List', 'users_list'),
(2, 'Add Users', 'users_add'),
(3, 'Edit Users', 'users_edit'),
(4, 'Delete Users', 'users_delete'),
(5, 'Users View', 'users_view'),
(6, 'Activity Logs List', 'activity_log_list'),
(7, 'Acivity Log View', 'activity_log_view'),
(8, 'Roles List', 'roles_list'),
(9, 'Add Roles', 'roles_add'),
(10, 'Edit Roles', 'roles_edit'),
(11, 'Permissions List', 'permissions_list'),
(12, 'Add Permissions', 'permissions_add'),
(13, 'Permissions Edit', 'permissions_edit'),
(14, 'Delete Permissions', 'permissions_delete'),
(15, 'Company Settings', 'company_settings'),
(16, 'Backup', 'backup_db'),
(17, 'Manage Email Templates', 'email_templates'),
(18, 'General Settings', 'general_settings'),
(22, 'Delete Roles', 'roles_delete'),
(28, 'Product Management', 'product_management'),
(29, 'Products List', 'products_list'),
(30, 'Add Products', 'products_add'),
(31, 'Edit Products', 'products_edit'),
(32, 'Delete Products', 'products_delete'),
(33, 'Brands List', 'brands_list'),
(34, 'Add Brands', 'brands_add'),
(35, 'Edit Brands', 'brands_edit'),
(36, 'Delete Brands', 'brands_delete'),
(37, 'Units List', 'units_list'),
(38, 'Add Units', 'units_add'),
(39, 'Edit Units', 'units_edit'),
(40, 'Delete Units', 'units_delete'),
(41, 'Categories List', 'categories_list'),
(42, 'Add Categories', 'categories_add'),
(43, 'Edit Categories', 'categories_edit'),
(44, 'Delete Categories', 'categories_delete'),
(45, 'Sub Categories List', 'sub_categories_list'),
(46, 'Add Sub Categories', 'sub_categories_add'),
(47, 'Edit Sub Categories', 'sub_categories_edit'),
(48, 'Delete Sub Categories', 'sub_categories_delete'),
(49, 'Variations List', 'variations_list'),
(50, 'Add Variations', 'variations_add'),
(51, 'Edit Variations', 'variations_edit'),
(52, 'Delete Variations', 'variations_delete'),
(53, 'Variation Values List', 'variation_values_list'),
(54, 'Add Variation Values', 'variation_values_add'),
(55, 'Edit Variation Values', 'variation_values_edit'),
(58, 'Delete Variation Values', 'variation_values_delete'),
(62, 'Tax Groups List', 'tax_groups_list'),
(63, 'Add Tax Groups', 'tax_groups_add'),
(64, 'Edit Tax Groups', 'tax_groups_edit'),
(65, 'Delete Tax Groups', 'tax_groups_delete'),
(71, 'Tax Rates List', 'tax_rates_list'),
(72, 'Add Tax Rates', 'tax_rates_add'),
(73, 'Edit Tax Rates', 'tax_rates_edit'),
(74, 'Delete Tax Rates', 'tax_rates_delete'),
(75, 'Users Management', 'users_management'),
(76, 'Logout', 'logout'),
(77, 'Location Management', 'location_management'),
(78, 'Cities List', 'cities_list'),
(79, 'Add Cities', 'cities_add'),
(80, 'Edit Cities', 'cities_edit'),
(81, 'Delete Cities', 'cities_delete'),
(82, 'States List', 'states_list'),
(83, 'Add States', 'states_add'),
(84, 'Edit States', 'states_edit'),
(85, 'Delete States', 'states_delete'),
(86, 'Countries List', 'countries_list'),
(87, 'Add Countries', 'countries_add'),
(88, 'Edit Countries', 'countries_edit'),
(89, 'Delete Countries', 'countries_delete'),
(90, 'Supplier Management', 'supplier_management'),
(91, 'Suppliers List', 'suppliers_list'),
(92, 'Add Suppliers', 'suppliers_add'),
(93, 'Edit Suppliers', 'suppliers_edit'),
(94, 'Delete Suppliers', 'suppliers_delete'),
(96, 'Customer Management', 'customer_management'),
(97, 'Customers List', 'customers_list'),
(98, 'Add Customers', 'customers_add'),
(99, 'Edit Customers', 'customers_edit'),
(100, 'Delete Customers', 'customers_delete'),
(101, 'Customer Transactions List', 'customer_transactions_list'),
(102, 'Add Customer Transactions', 'customer_transactions_add'),
(103, 'Edit Customer Transactions', 'customer_transactions_edit'),
(104, 'Delete Customer Transactions', 'customer_transactions_delete'),
(105, 'Purchase Management', 'purchase_management'),
(106, 'Purchases List', 'purchases_list'),
(107, 'Add Purchases', 'purchases_add'),
(108, 'Edit Purchases', 'purchases_edit'),
(109, 'Delete Purchases', 'purchases_delete'),
(110, 'Customer Balances', 'customer_balances');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `sku_code` varchar(255) NOT NULL,
  `brand_id` int UNSIGNED NOT NULL,
  `unit_id` int UNSIGNED NOT NULL,
  `category_id` int UNSIGNED NOT NULL,
  `sub_category_id` int UNSIGNED NOT NULL,
  `tax_group_id` int UNSIGNED NOT NULL,
  `product_status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `has_variation` tinyint(1) NOT NULL DEFAULT '0',
  `buying_price` decimal(10,2) NOT NULL,
  `customer_price` decimal(10,2) NOT NULL,
  `tax_amount` decimal(10,2) DEFAULT NULL,
  `sale_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `brand_id` (`brand_id`),
  KEY `unit_id` (`unit_id`),
  KEY `category_id` (`category_id`),
  KEY `sub_category_id` (`sub_category_id`),
  KEY `tax_group_id` (`tax_group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `sku_code`, `brand_id`, `unit_id`, `category_id`, `sub_category_id`, `tax_group_id`, `product_status`, `has_variation`, `buying_price`, `customer_price`, `tax_amount`, `sale_price`, `created_at`, `updated_at`) VALUES
(1, 'Basic T-Shirt', 'BTS001', 1, 1, 1, 1, 1, 'active', 0, 5.00, 10.00, NULL, 15.00, '2024-07-15 05:17:54', '2024-07-17 14:58:01'),
(2, 'Water Bottle', 'WB001', 2, 2, 2, 2, 2, 'active', 0, 1.00, 2.00, NULL, 3.00, '2024-07-15 05:17:54', '2024-07-17 05:05:49'),
(69, 'running shoes', '83205', 2, 1, 5, 11, 0, '', 1, 0.00, 0.00, 0.00, 0.00, '2024-09-04 07:21:23', '2024-09-04 09:13:54'),
(70, 'aalu', '58579', 1, 1, 1, 1, 0, 'active', 1, 0.00, 0.00, 0.00, 0.00, '2024-09-05 09:48:03', '2024-09-05 09:48:03');

-- --------------------------------------------------------

--
-- Table structure for table `product_variations`
--

DROP TABLE IF EXISTS `product_variations`;
CREATE TABLE IF NOT EXISTS `product_variations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int UNSIGNED NOT NULL,
  `variation_sku_code` varchar(255) NOT NULL,
  `variation_product_name` varchar(255) NOT NULL,
  `variation_id` int UNSIGNED NOT NULL,
  `variation_value_id` int UNSIGNED NOT NULL,
  `variation_brand_id` int UNSIGNED NOT NULL,
  `variation_unit_id` int UNSIGNED NOT NULL,
  `variation_category_id` int UNSIGNED NOT NULL,
  `variation_sub_category_id` int UNSIGNED NOT NULL,
  `variation_tax_group_id` int UNSIGNED NOT NULL,
  `variation_buying_price` decimal(10,2) NOT NULL,
  `variation_customer_price` decimal(10,2) NOT NULL,
  `variation_tax_amount` decimal(10,2) DEFAULT NULL,
  `variation_sale_price` decimal(10,2) NOT NULL,
  `variation_product_status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `variation_id` (`variation_id`),
  KEY `variation_value_id` (`variation_value_id`),
  KEY `variation_brand_id` (`variation_brand_id`),
  KEY `variation_unit_id` (`variation_unit_id`),
  KEY `variation_category_id` (`variation_category_id`),
  KEY `variation_sub_category_id` (`variation_sub_category_id`),
  KEY `variation_tax_group_id` (`variation_tax_group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=134 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_variations`
--

INSERT INTO `product_variations` (`id`, `product_id`, `variation_sku_code`, `variation_product_name`, `variation_id`, `variation_value_id`, `variation_brand_id`, `variation_unit_id`, `variation_category_id`, `variation_sub_category_id`, `variation_tax_group_id`, `variation_buying_price`, `variation_customer_price`, `variation_tax_amount`, `variation_sale_price`, `variation_product_status`, `created_at`, `updated_at`) VALUES
(132, 70, '58579-1001', 'aalu - small', 1, 1, 1, 1, 1, 1, 1, 100.00, 120.00, 22.00, 142.00, 'active', '2024-09-05 09:48:03', '2024-09-05 09:48:03'),
(133, 70, '58579-1002', 'aalu - medium', 1, 2, 1, 1, 1, 1, 1, 100.00, 120.00, 22.00, 142.00, 'active', '2024-09-05 09:48:03', '2024-09-05 09:48:03'),
(131, 69, '83205-1002', 'running shoes - medium', 1, 2, 2, 1, 5, 11, 1, 2000.00, 2000.00, 720.00, 920.00, 'active', '2024-09-04 09:13:54', '2024-09-04 09:13:54'),
(130, 69, '83205-1001', 'running shoes - small', 1, 1, 2, 1, 5, 11, 1, 1000.00, 1000.00, 1800.00, 2800.00, 'active', '2024-09-04 09:13:54', '2024-09-04 09:13:54');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

DROP TABLE IF EXISTS `purchases`;
CREATE TABLE IF NOT EXISTS `purchases` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `supplier_id` int UNSIGNED NOT NULL,
  `reference_no` varchar(100) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL,
  `remaining_amount` decimal(10,2) NOT NULL,
  `purchase_date` date NOT NULL,
  `payment_status` enum('paid','unpaid','partial') NOT NULL,
  `purchase_status` enum('ordered','received','canceled') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `supplier_id` (`supplier_id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `supplier_id`, `reference_no`, `total_amount`, `paid_amount`, `remaining_amount`, `purchase_date`, `payment_status`, `purchase_status`, `created_at`, `updated_at`) VALUES
(45, 1, 'PUR0001', 200.00, 100.00, 100.00, '2024-12-20', 'unpaid', 'received', '2024-12-20 07:01:21', '2024-12-20 07:01:21');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

DROP TABLE IF EXISTS `purchase_items`;
CREATE TABLE IF NOT EXISTS `purchase_items` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `purchase_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `variation_id` int UNSIGNED DEFAULT NULL,
  `variation_value_id` int UNSIGNED DEFAULT NULL,
  `brand_id` int UNSIGNED NOT NULL,
  `unit_id` int UNSIGNED NOT NULL,
  `category_id` int UNSIGNED NOT NULL,
  `sub_category_id` int UNSIGNED NOT NULL,
  `sku_code` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int UNSIGNED NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `manufacture_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `purchase_id` (`purchase_id`),
  KEY `product_id` (`product_id`),
  KEY `variation_id` (`variation_id`),
  KEY `variation_value_id` (`variation_value_id`),
  KEY `brand_id` (`brand_id`),
  KEY `unit_id` (`unit_id`),
  KEY `category_id` (`category_id`),
  KEY `sub_category_id` (`sub_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `purchase_items`
--

INSERT INTO `purchase_items` (`id`, `purchase_id`, `product_id`, `variation_id`, `variation_value_id`, `brand_id`, `unit_id`, `category_id`, `sub_category_id`, `sku_code`, `product_name`, `quantity`, `unit_price`, `total_price`, `manufacture_date`, `expiry_date`, `created_at`, `updated_at`) VALUES
(58, 45, 70, 1, 2, 0, 0, 0, 0, '58579-1002', 'aalu - medium', 1, 100.00, 100.00, '0000-00-00', '0000-00-00', '2024-12-20 07:01:21', '2024-12-20 07:01:21'),
(57, 45, 70, 1, 1, 0, 0, 0, 0, '58579-1001', 'aalu - small', 1, 100.00, 100.00, '0000-00-00', '0000-00-00', '2024-12-20 07:01:21', '2024-12-20 07:01:21');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`) VALUES
(1, 'Admin'),
(2, 'Manager');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE IF NOT EXISTS `role_permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role` int NOT NULL,
  `permission` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role`, `permission`) VALUES
(1, 1, 'users_list'),
(2, 1, 'users_add'),
(3, 1, 'users_edit'),
(4, 1, 'users_delete'),
(5, 1, 'users_view'),
(40, 3, 'users_list'),
(41, 3, 'users_add'),
(42, 3, 'users_edit'),
(43, 3, 'users_delete'),
(44, 3, 'users_view'),
(50, 1, 'roles_list'),
(51, 1, 'roles_add'),
(52, 1, 'roles_edit'),
(55, 1, 'roles_list'),
(56, 1, 'roles_add'),
(57, 1, 'roles_edit'),
(58, 1, 'activity_log_list'),
(59, 1, 'activity_log_view'),
(60, 1, 'permissions_list'),
(61, 1, 'permissions_add'),
(62, 1, 'permissions_edit'),
(63, 1, 'permissions_delete'),
(64, 1, 'company_settings'),
(65, 1, 'backup_db'),
(66, 1, 'email_templates'),
(67, 1, 'general_settings'),
(68, 3, 'roles_list'),
(69, 3, 'roles_add'),
(70, 3, 'roles_edit'),
(72, 1, 'roles_delete'),
(73, 4, 'roles_delete'),
(81, 5, 'brands_delete'),
(82, 2, 'brands_list'),
(84, 1, 'product_management'),
(85, 1, 'products_list'),
(86, 1, 'products_add'),
(87, 1, 'products_edit'),
(88, 1, 'products_delete'),
(89, 1, 'brands_list'),
(90, 1, 'brands_add'),
(91, 1, 'brands_edit'),
(92, 1, 'brands_delete'),
(93, 1, 'units_list'),
(94, 1, 'units_add'),
(95, 1, 'units_edit'),
(96, 1, 'units_delete'),
(97, 1, 'categories_list'),
(98, 1, 'categories_add'),
(99, 1, 'categories_edit'),
(100, 1, 'categories_delete'),
(101, 1, 'sub_categories_list'),
(102, 1, 'sub_categories_add'),
(103, 1, 'sub_categories_edit'),
(104, 1, 'sub_categories_delete'),
(105, 1, 'variations_list'),
(106, 1, 'variations_add'),
(107, 1, 'variations_edit'),
(108, 1, 'variations_delete'),
(109, 1, 'variation_values_list'),
(110, 1, 'variation_values_add'),
(111, 1, 'variation_values_edit'),
(112, 1, 'variation_values_delete'),
(113, 1, 'tax_groups_list'),
(114, 1, 'tax_groups_add'),
(115, 1, 'tax_groups_edit'),
(116, 1, 'tax_groups_delete'),
(123, 1, 'tax_rates_list'),
(124, 1, 'tax_rates_add'),
(125, 1, 'tax_rates_edit'),
(126, 1, 'tax_rates_delete'),
(127, 1, 'users_management'),
(128, 1, 'logout'),
(129, 1, 'location_management'),
(130, 1, 'cities_list'),
(131, 1, 'cities_add'),
(132, 1, 'cities_edit'),
(133, 1, 'cities_delete'),
(134, 1, 'states_list'),
(135, 1, 'states_add'),
(136, 1, 'states_edit'),
(137, 1, 'states_delete'),
(138, 1, 'countries_list'),
(139, 1, 'countries_add'),
(140, 1, 'countries_edit'),
(141, 1, 'countries_delete'),
(142, 1, 'supplier_management'),
(143, 1, 'suppliers_list'),
(144, 1, 'suppliers_add'),
(145, 1, 'suppliers_edit'),
(146, 1, 'suppliers_delete'),
(147, 1, 'customer_management'),
(148, 1, 'customers_list'),
(149, 1, 'customers_add'),
(150, 1, 'customers_edit'),
(151, 1, 'customers_delete'),
(152, 1, 'customer_transactions_list'),
(153, 1, 'customer_transactions_add'),
(154, 1, 'customer_transactions_edit'),
(155, 1, 'customer_transactions_delete'),
(156, 1, 'purchase_management'),
(157, 1, 'purchases_list'),
(158, 1, 'purchases_add'),
(159, 1, 'purchases_edit'),
(160, 1, 'purchases_delete'),
(161, 1, 'customer_balances');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
CREATE TABLE IF NOT EXISTS `sales` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` int UNSIGNED NOT NULL,
  `reference_no` varchar(100) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL,
  `remaining_amount` decimal(10,2) NOT NULL,
  `sale_date` date NOT NULL,
  `payment_status` enum('paid','unpaid','partial') NOT NULL,
  `sale_status` enum('completed','pending','canceled') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `customer_id`, `reference_no`, `total_amount`, `discount_amount`, `paid_amount`, `remaining_amount`, `sale_date`, `payment_status`, `sale_status`, `created_at`, `updated_at`) VALUES
(1, 1, 'SALE001', 2000.00, 200.00, 1800.00, 0.00, '2024-07-01', 'paid', 'completed', '2024-07-15 05:47:01', '2024-07-15 05:47:01'),
(2, 2, 'SALE002', 3000.00, 300.00, 2700.00, 0.00, '2024-07-02', 'paid', 'completed', '2024-07-15 05:47:01', '2024-07-15 05:47:01'),
(3, 3, 'SALE003', 1500.00, 0.00, 0.00, 1500.00, '2024-07-03', 'unpaid', 'pending', '2024-07-15 05:47:01', '2024-07-15 05:47:01'),
(4, 1, 'SALE001', 2000.00, 200.00, 1800.00, 0.00, '2024-07-01', 'paid', 'completed', '2024-07-15 05:47:10', '2024-07-15 05:47:10'),
(5, 2, 'SALE002', 3000.00, 300.00, 2700.00, 0.00, '2024-07-02', 'paid', 'completed', '2024-07-15 05:47:10', '2024-07-15 05:47:10'),
(6, 3, 'SALE003', 1500.00, 0.00, 0.00, 1500.00, '2024-07-03', 'unpaid', 'pending', '2024-07-15 05:47:10', '2024-07-15 05:47:10');

-- --------------------------------------------------------

--
-- Table structure for table `sales_items`
--

DROP TABLE IF EXISTS `sales_items`;
CREATE TABLE IF NOT EXISTS `sales_items` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `sale_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `variation_id` int UNSIGNED DEFAULT NULL,
  `variation_value_id` int UNSIGNED DEFAULT NULL,
  `brand_id` int UNSIGNED NOT NULL,
  `unit_id` int UNSIGNED NOT NULL,
  `category_id` int UNSIGNED NOT NULL,
  `sub_category_id` int UNSIGNED NOT NULL,
  `sku_code` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int UNSIGNED NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sale_id` (`sale_id`),
  KEY `product_id` (`product_id`),
  KEY `variation_id` (`variation_id`),
  KEY `variation_value_id` (`variation_value_id`),
  KEY `brand_id` (`brand_id`),
  KEY `unit_id` (`unit_id`),
  KEY `category_id` (`category_id`),
  KEY `sub_category_id` (`sub_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sales_items`
--

INSERT INTO `sales_items` (`id`, `sale_id`, `product_id`, `variation_id`, `variation_value_id`, `brand_id`, `unit_id`, `category_id`, `sub_category_id`, `sku_code`, `product_name`, `quantity`, `unit_price`, `total_price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL, 1, 1, 1, 1, 'BTS001', 'Basic T-Shirt', 50, 20.00, 1000.00, '2024-07-15 05:47:28', '2024-07-15 05:47:28'),
(2, 1, 2, 1, 1, 2, 2, 2, 2, 'WB001-V001', 'Water Bottle - Blue', 20, 15.00, 300.00, '2024-07-15 05:47:28', '2024-07-15 05:47:28'),
(3, 2, 3, 2, 1, 3, 3, 3, 3, 'SPX001-V001', 'Smartphone X - Black - 64GB', 2, 500.00, 1000.00, '2024-07-15 05:47:28', '2024-07-15 05:47:28');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` text NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`) VALUES
(1, 'company_name', 'Pos', '2018-06-21 01:07:59'),
(2, 'company_email', 'admin@gmail.com', '2018-07-10 18:39:58'),
(3, 'timezone', 'Asia/Kolkata', '2018-07-15 03:24:17'),
(4, 'login_theme', '1', '2019-06-05 21:34:28'),
(5, 'date_format', 'd F, Y', '2020-01-03 09:01:45'),
(6, 'datetime_format', 'h:m a - d M, Y ', '2020-01-03 09:02:24'),
(7, 'google_recaptcha_enabled', '0', '2020-01-04 08:14:03'),
(8, 'google_recaptcha_sitekey', '6LdIWswUAAAAAMRp6xt2wBu7V59jUvZvKWf_rbJc', '2020-01-04 08:14:17'),
(9, 'google_recaptcha_secretkey', '6LdIWswUAAAAAIsdboq_76c63PHFsOPJHNR-z-75', '2020-01-04 08:14:40'),
(10, 'bg_img_type', 'jpeg', '2020-01-06 07:23:33'),
(11, 'default_lang', 'en', '2021-04-11 23:23:06'),
(12, 'version', 'v2.0', '2022-03-19 09:56:05');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
CREATE TABLE IF NOT EXISTS `states` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `state_name` varchar(255) NOT NULL,
  `country_id` int UNSIGNED NOT NULL,
  `state_status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `state_name`, `country_id`, `state_status`, `created_at`, `updated_at`) VALUES
(3, 'Rajasthan', 1, 'active', '2024-06-24 15:26:59', '2024-06-24 15:26:59'),
(5, 'maharastra', 1, 'active', '2024-06-25 12:21:49', '2024-06-25 12:21:49');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

DROP TABLE IF EXISTS `sub_categories`;
CREATE TABLE IF NOT EXISTS `sub_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `sub_category_name` varchar(255) NOT NULL,
  `sub_category_description` text,
  `sub_category_status` varchar(50) DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `sub_category_name`, `sub_category_description`, `sub_category_status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Smartphones', NULL, 'active', '2024-07-14 15:46:20', '2024-07-14 15:46:20'),
(2, 1, 'Laptops', NULL, 'active', '2024-07-14 15:46:20', '2024-07-14 15:46:20'),
(3, 1, 'Televisions', NULL, 'active', '2024-07-14 15:46:20', '2024-07-15 04:27:52'),
(4, 2, 'Shirts', NULL, 'active', '2024-07-14 15:46:20', '2024-07-14 15:46:20'),
(5, 2, 'Jeans', NULL, 'active', '2024-07-14 15:46:20', '2024-07-14 15:46:20'),
(6, 3, 'SUVs', NULL, 'active', '2024-07-14 15:46:20', '2024-07-14 15:46:20'),
(7, 3, 'Sedans', NULL, 'active', '2024-07-14 15:46:20', '2024-07-14 15:46:20'),
(8, 3, 'Motorcycles', NULL, 'active', '2024-07-14 15:46:20', '2024-07-15 04:28:02'),
(9, 4, 'Desks', NULL, 'active', '2024-07-14 15:46:20', '2024-07-15 04:28:01'),
(10, 4, 'Chairs', NULL, 'active', '2024-07-14 15:46:20', '2024-07-14 15:46:20'),
(11, 5, 'Basketball', NULL, 'active', '2024-07-14 15:46:20', '2024-07-14 15:46:20'),
(12, 5, 'Soccer', NULL, 'inactive', '2024-07-14 15:46:20', '2024-07-14 15:46:20');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_contact_person` varchar(255) NOT NULL,
  `supplier_email` varchar(255) NOT NULL,
  `supplier_phone` varchar(20) NOT NULL,
  `supplier_address` text NOT NULL,
  `supplier_pincode` varchar(20) NOT NULL,
  `city_id` int UNSIGNED NOT NULL,
  `state_id` int UNSIGNED NOT NULL,
  `country_id` int UNSIGNED NOT NULL,
  `supplier_notes` text,
  `supplier_status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `city_id` (`city_id`),
  KEY `state_id` (`state_id`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `supplier_contact_person`, `supplier_email`, `supplier_phone`, `supplier_address`, `supplier_pincode`, `city_id`, `state_id`, `country_id`, `supplier_notes`, `supplier_status`, `created_at`, `updated_at`) VALUES
(1, 'manish soni', 'manish soni', 'whomanishsoni@gmail.com', '9460966996', 'Bhilwara, Rajasthan', '311001', 7, 3, 1, 'Nothing', 'active', '2024-06-30 15:27:56', '2024-06-30 15:27:56');

-- --------------------------------------------------------

--
-- Table structure for table `tax_groups`
--

DROP TABLE IF EXISTS `tax_groups`;
CREATE TABLE IF NOT EXISTS `tax_groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tax_group_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tax_group_status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tax_groups`
--

INSERT INTO `tax_groups` (`id`, `tax_group_name`, `tax_group_status`, `created_at`, `updated_at`) VALUES
(1, 'GST 9%', 'active', '2024-03-31 12:19:47', '2024-03-31 13:19:27'),
(2, 'GST 15%', 'active', '2024-03-31 12:19:47', '2024-03-31 13:19:09');

-- --------------------------------------------------------

--
-- Table structure for table `tax_rates`
--

DROP TABLE IF EXISTS `tax_rates`;
CREATE TABLE IF NOT EXISTS `tax_rates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tax_name` varchar(50) NOT NULL,
  `tax_rate` decimal(10,2) NOT NULL,
  `tax_status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `group_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tax_rates`
--

INSERT INTO `tax_rates` (`id`, `tax_name`, `tax_rate`, `tax_status`, `group_id`, `created_at`, `updated_at`) VALUES
(1, 'SGST', 9.00, 'active', 1, '2024-03-31 08:01:52', '2024-04-01 13:55:28'),
(2, 'CGST', 9.00, 'active', 1, '2024-03-31 08:01:52', '2024-03-31 08:01:52'),
(3, 'SGST', 15.00, 'active', 2, '2024-03-31 08:01:52', '2024-04-01 08:29:25'),
(4, 'CGST', 15.00, 'active', 2, '2024-03-31 08:01:52', '2024-04-01 08:29:23');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
CREATE TABLE IF NOT EXISTS `units` (
  `id` int NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(255) NOT NULL,
  `unit_abbreviation` varchar(50) NOT NULL,
  `unit_status` varchar(50) DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit_name`, `unit_abbreviation`, `unit_status`, `created_at`, `updated_at`) VALUES
(1, 'Piece', 'pcs', 'active', '2024-07-14 15:47:54', '2024-07-14 15:47:54'),
(2, 'Dozen', 'dz', 'active', '2024-07-14 15:47:54', '2024-07-14 15:47:54'),
(3, 'Meter', 'm', 'active', '2024-07-14 15:47:54', '2024-07-14 15:47:54'),
(4, 'Kilogram', 'kg', 'active', '2024-07-14 15:47:54', '2024-07-14 15:47:54'),
(5, 'Liter', 'L', 'active', '2024-07-14 15:47:54', '2024-07-15 04:28:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `phone` text NOT NULL,
  `address` longtext NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `role` int NOT NULL,
  `reset_token` text NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `img_type` varchar(3000) NOT NULL DEFAULT 'png',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `phone`, `address`, `last_login`, `role`, `reset_token`, `status`, `img_type`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', 'admin@gmail.com', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9', '123456', 'dsf', '2022-04-18 09:37:51', 1, '', 1, 'png', '2018-06-27 02:00:16', '0000-00-00 00:00:00'),
(7, 'manish', 'manish', 'manish@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '', '', '2023-12-18 15:30:25', 2, '', 1, 'png', '2023-12-18 15:30:25', '2023-12-18 15:30:25');

-- --------------------------------------------------------

--
-- Table structure for table `variations`
--

DROP TABLE IF EXISTS `variations`;
CREATE TABLE IF NOT EXISTS `variations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `variation_name` varchar(255) NOT NULL,
  `variation_status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `variations`
--

INSERT INTO `variations` (`id`, `variation_name`, `variation_status`, `created_at`, `updated_at`) VALUES
(1, 'Size', 'active', '2024-07-14 15:39:54', '2024-07-14 15:39:54'),
(2, 'Color', 'active', '2024-07-14 15:39:54', '2024-07-14 15:39:54'),
(3, 'Weight', 'active', '2024-07-14 15:39:54', '2024-07-15 04:25:26');

-- --------------------------------------------------------

--
-- Table structure for table `variation_values`
--

DROP TABLE IF EXISTS `variation_values`;
CREATE TABLE IF NOT EXISTS `variation_values` (
  `id` int NOT NULL AUTO_INCREMENT,
  `variation_id` int NOT NULL,
  `variation_value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `variation_value_status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `variation_id` (`variation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `variation_values`
--

INSERT INTO `variation_values` (`id`, `variation_id`, `variation_value`, `variation_value_status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Small', 'active', '2024-07-14 15:40:24', '2024-07-14 15:40:24'),
(2, 1, 'Medium', 'active', '2024-07-14 15:40:24', '2024-07-14 15:40:24'),
(3, 1, 'Large', 'active', '2024-07-14 15:40:24', '2024-07-15 04:25:31'),
(4, 2, 'Red', 'active', '2024-07-14 15:40:24', '2024-07-14 15:40:24'),
(5, 2, 'Blue', 'active', '2024-07-14 15:40:24', '2024-07-14 15:40:24'),
(6, 2, 'Green', 'active', '2024-07-14 15:40:24', '2024-07-15 04:25:37'),
(7, 3, '500g', 'active', '2024-07-15 04:37:06', '2024-07-15 04:37:06'),
(8, 3, '1kg', 'active', '2024-07-15 04:37:06', '2024-07-15 04:37:06'),
(9, 3, '2kg', 'active', '2024-07-15 04:37:06', '2024-07-15 04:37:06'),
(10, 3, '5kg', 'active', '2024-07-15 04:37:06', '2024-07-15 04:37:06'),
(11, 3, '10kg', 'active', '2024-07-15 04:37:06', '2024-07-15 04:37:06');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
