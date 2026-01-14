-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2026 at 02:34 PM
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
-- Database: `hcc_drive`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `details` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `user_name`, `role`, `action`, `details`, `created_at`) VALUES
(1, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-02 03:18:56'),
(2, 15, 'Scite Chair', 'program_chair', 'Login', 'User logged into the system.', '2025-12-02 03:20:31'),
(3, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-02 03:20:39'),
(4, 10, 'Admin Admin', 'admin', 'Delete', 'Deleted a file (ID: 16)', '2025-12-02 03:20:53'),
(5, 15, 'Scite Chair', 'program_chair', 'Login', 'User logged into the system.', '2025-12-02 03:21:30'),
(6, 15, 'Scite Chair', 'program_chair', 'Delete', 'Deleted a file (ID: 17)', '2025-12-02 03:21:33'),
(7, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-02 03:21:41'),
(8, 19, 'Scj Program', 'faculty', 'Login', 'User logged into the system.', '2025-12-02 03:24:11'),
(9, 20, 'Scj Faculty', 'faculty', 'Login', 'User logged into the system.', '2025-12-02 03:24:36'),
(10, 19, 'Scj Program', 'faculty', 'Login', 'User logged into the system.', '2025-12-02 03:25:09'),
(11, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-02 03:25:25'),
(12, 19, 'Scj Program', 'program_chair', 'Login', 'User logged into the system.', '2025-12-02 03:26:32'),
(13, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-02 03:26:50'),
(14, 19, 'Scj Program', 'program_chair', 'Login', 'User logged into the system.', '2025-12-02 03:27:52'),
(15, 19, 'Scj Program', 'program_chair', 'Upload', 'Uploaded file: SCITE.docx to 201 File', '2025-12-02 03:27:58'),
(16, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-02 03:28:03'),
(17, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 01:00:26'),
(18, 15, 'Scite Chair', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 01:29:38'),
(19, 15, 'Scite Chair', 'program_chair', 'Upload', 'Uploaded file: SCITE.docx to 201 File', '2025-12-03 01:29:57'),
(20, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 01:31:16'),
(21, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 01:52:54'),
(22, 15, 'Scite Chair', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 02:22:11'),
(23, 16, 'Scite Faculty', 'faculty', 'Login', 'User logged into the system.', '2025-12-03 02:23:38'),
(24, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 02:24:42'),
(25, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 02:27:14'),
(26, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 02:33:40'),
(27, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 02:55:46'),
(28, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 03:00:15'),
(29, 10, 'Admin Admin', 'admin', 'Upload', 'Uploaded file: Certificate of Verification (1).pdf to 201 File', '2025-12-03 03:13:34'),
(30, 15, 'Scite Chair', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 03:25:58'),
(31, 16, 'Scite Faculty', 'faculty', 'Login', 'User logged into the system.', '2025-12-03 03:27:32'),
(32, 15, 'Scite Chair', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 03:28:35'),
(33, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 03:29:25'),
(34, 16, 'Scite Faculty', 'faculty', 'Login', 'User logged into the system.', '2025-12-03 03:35:00'),
(35, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 03:42:14'),
(36, 15, 'Scite Chair', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 03:42:51'),
(37, 16, 'Scite Faculty', 'faculty', 'Login', 'User logged into the system.', '2025-12-03 03:43:01'),
(38, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 05:11:42'),
(39, 16, 'Scite Faculty', 'faculty', 'Login', 'User logged into the system.', '2025-12-03 06:05:35'),
(40, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 06:05:56'),
(41, 10, 'Admin Admin', 'admin', 'Upload', 'Uploaded file: Certificate of Verification.docx to Root', '2025-12-03 06:14:33'),
(42, 10, 'Admin Admin', 'admin', 'Delete', 'Deleted a file (ID: 22)', '2025-12-03 06:14:41'),
(43, 10, 'Admin Admin', 'admin', 'Upload', 'Uploaded file: Explanation.docx to Folder ID: 1', '2025-12-03 06:14:55'),
(44, 15, 'Scite Chair', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 06:17:17'),
(45, 19, 'Scj Program', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 06:17:54'),
(46, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 06:21:25'),
(47, 15, 'Scite Chair', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 06:26:46'),
(48, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 06:27:15'),
(49, 10, 'Admin Admin', 'admin', 'Upload', 'Uploaded file: Explanation.docx to Root', '2025-12-03 06:28:18'),
(50, 15, 'Scite Chair', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 06:28:28'),
(51, 15, 'Scite Chair', 'program_chair', 'Upload', 'Uploaded file: Explanation.docx to Root', '2025-12-03 06:28:34'),
(52, 19, 'Scj Program', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 06:28:47'),
(53, 15, 'Scite Chair', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 06:29:17'),
(54, 16, 'Scite Faculty', 'faculty', 'Login', 'User logged into the system.', '2025-12-03 06:37:20'),
(55, 19, 'Scj Program', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 06:37:47'),
(56, 19, 'Scj Program', 'program_chair', 'Upload', 'Uploaded file: food api.txt to Folder ID: 7', '2025-12-03 06:38:04'),
(57, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 06:38:19'),
(58, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 06:38:59'),
(59, 16, 'Scite Faculty', 'faculty', 'Login', 'User logged into the system.', '2025-12-03 06:39:46'),
(60, 16, 'Scite Faculty', 'faculty', 'Login', 'User logged into the system.', '2025-12-03 06:42:12'),
(61, 15, 'Scite Chair', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 06:42:40'),
(62, 16, 'Scite Faculty', 'faculty', 'Login', 'User logged into the system.', '2025-12-03 06:48:52'),
(63, 15, 'Scite Chair', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 06:49:07'),
(64, 16, 'Scite Faculty', 'faculty', 'Login', 'User logged into the system.', '2025-12-03 06:49:26'),
(65, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 06:49:43'),
(66, 19, 'Scj Program', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 06:50:04'),
(67, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 06:50:28'),
(68, 19, 'Scj Program', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 07:10:11'),
(69, 19, 'Scj Program', 'program_chair', 'Create Folder', 'Created folder \'hahaaha\' in Root Directory', '2025-12-03 07:10:17'),
(70, 20, 'Scj Faculty', 'faculty', 'Login', 'User logged into the system.', '2025-12-03 07:10:34'),
(71, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 07:10:43'),
(72, 20, 'Scj Faculty', 'faculty', 'Login', 'User logged into the system.', '2025-12-03 07:11:02'),
(73, 20, 'Scj Faculty', 'faculty', 'Login', 'User logged into the system.', '2025-12-03 07:11:14'),
(74, 19, 'Scj Program', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 07:11:24'),
(75, 19, 'Scj Program', 'program_chair', 'Delete Folder', 'Deleted folder \'hahaaha\' (ID: 9)', '2025-12-03 07:11:27'),
(76, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 07:11:38'),
(77, 19, 'Scj Program', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 07:13:03'),
(78, 19, 'Scj Program', 'program_chair', 'Upload', 'Uploaded file \'features flow.docx\' to Folder ID: 6', '2025-12-03 07:13:15'),
(79, 19, 'Scj Program', 'program_chair', 'Delete File', 'Deleted file \'features flow.docx\'', '2025-12-03 07:13:18'),
(80, 19, 'Scj Program', 'program_chair', 'Delete Folder', 'Deleted folder \'scj\' (ID: 6)', '2025-12-03 07:13:29'),
(81, 19, 'Scj Program', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 07:13:37'),
(82, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 07:13:48'),
(83, 10, 'Admin Admin', 'admin', 'Delete File', 'Deleted file \'food api.txt\'', '2025-12-03 07:14:39'),
(84, 15, 'Scite Chair', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 07:21:22'),
(85, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 07:22:11'),
(86, 10, 'Admin Admin', 'admin', 'Delete File', 'Deleted file \'Explanation.docx\'', '2025-12-03 07:31:37'),
(87, 10, 'Admin Admin', 'admin', 'Delete Folder', 'Deleted folder \'lol\' (ID: 3)', '2025-12-03 07:31:53'),
(88, 10, 'Admin Admin', 'admin', 'Delete Folder', 'Deleted folder \'scite\' (ID: 4)', '2025-12-03 07:31:59'),
(89, 10, 'Admin Admin', 'admin', 'Delete Folder', 'Deleted folder \'scite2\' (ID: 5)', '2025-12-03 07:32:12'),
(90, 10, 'Admin Admin', 'admin', 'Delete File', 'Deleted file \'Explanation.docx\'', '2025-12-03 07:32:15'),
(91, 10, 'Admin Admin', 'admin', 'Delete File', 'Deleted file \'Explanation.docx\'', '2025-12-03 07:32:18'),
(92, 10, 'Admin Admin', 'admin', 'Delete File', 'Deleted file \'SCITE.docx\'', '2025-12-03 07:32:21'),
(93, 10, 'Admin Admin', 'admin', 'Delete File', 'Deleted file \'SCITE.docx\'', '2025-12-03 07:32:23'),
(94, 10, 'Admin Admin', 'admin', 'Delete File', 'Deleted file \'SBA.docx\'', '2025-12-03 07:32:26'),
(95, 15, 'Scite Chair', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 07:32:45'),
(96, 15, 'Scite Chair', 'program_chair', 'Create Folder', 'Created folder \'`\' in Root Directory', '2025-12-03 07:32:53'),
(97, 15, 'Scite Chair', 'program_chair', 'Upload', 'Uploaded file \'Explanation.docx\' to Folder ID: 10', '2025-12-03 07:33:03'),
(98, 15, 'Scite Chair', 'program_chair', 'Create Folder', 'Created folder \'..\' in Folder ID: 10', '2025-12-03 07:33:39'),
(99, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 07:42:33'),
(100, 15, 'Scite Chair', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 07:42:44'),
(101, 15, 'Scite Chair', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 07:45:13'),
(102, 15, 'Scite Chair', 'program_chair', 'Delete Folder', 'Deleted folder \'`\' (ID: 10)', '2025-12-03 07:45:36'),
(103, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 07:46:25'),
(104, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 07:47:47'),
(105, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 08:09:32'),
(106, 17, 'Sba Chair', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 08:09:50'),
(107, 17, 'Sba Chair', 'program_chair', 'Create Folder', 'Created folder \'sba\' in Root Directory', '2025-12-03 08:09:56'),
(108, 17, 'Sba Chair', 'program_chair', 'Create Folder', 'Created folder \'sba1\' in Folder ID: 12', '2025-12-03 08:10:01'),
(109, 17, 'Sba Chair', 'program_chair', 'Upload', 'Uploaded file \'SBA.docx\' to Folder ID: 12', '2025-12-03 08:10:08'),
(110, 17, 'Sba Chair', 'program_chair', 'Login', 'User logged into the system.', '2025-12-03 08:11:16'),
(111, 18, 'Sba Faculty', 'faculty', 'Login', 'User logged into the system.', '2025-12-03 08:11:42'),
(112, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-03 08:12:01'),
(113, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-04 00:09:43'),
(114, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-04 00:55:39'),
(115, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-04 05:40:02'),
(116, 10, 'Admin Admin', 'admin', 'Archive', 'Archived file \'SBA.docx\'', '2025-12-04 05:41:03'),
(117, 10, 'Admin Admin', 'admin', 'Restore', 'Restored file ID: 29 from archive', '2025-12-04 05:41:10'),
(118, 10, 'Admin Admin', 'admin', 'Archive', 'Archived file \'Explanation.docx\'', '2025-12-04 05:41:23'),
(119, 10, 'Admin Admin', 'admin', 'Restore', 'Restored file ID: 28 from archive', '2025-12-04 05:41:30'),
(120, 10, 'Admin Admin', 'admin', 'Archive', 'Archived file \'SBA.docx\'', '2025-12-04 05:41:38'),
(121, 10, 'Admin Admin', 'admin', 'Restore', 'Restored file ID: 29 from archive', '2025-12-04 05:41:43'),
(122, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-04 05:42:14'),
(123, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-04 07:37:47'),
(124, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-04 07:39:08'),
(125, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-05 00:19:22'),
(126, 10, 'Admin Admin', 'admin', 'Login', 'User logged into the system.', '2025-12-05 00:19:42'),
(127, 10, 'Admin Admin', 'admin', 'Archive User', 'Archived user: Scj Faculty', '2025-12-05 03:28:20'),
(128, 10, 'Admin Admin', 'admin', 'Restore', 'Restored user ID: 20', '2025-12-05 03:54:23'),
(129, 19, 'Scj Program', 'program_chair', 'Create Folder', 'Created folder \'scj\' in Root Directory', '2025-12-05 03:54:59'),
(130, 19, 'Scj Program', 'program_chair', 'Upload', 'Uploaded file \'Screenshot 2025-06-09 141747.png\' to Folder ID: 14', '2025-12-05 03:55:08'),
(131, 10, 'Admin Admin', 'admin', 'Archive User', 'Archived user: Scj Faculty', '2025-12-09 05:33:17'),
(132, 10, 'Admin Admin', 'admin', 'Restore', 'Restored user ID: 20', '2025-12-09 05:33:24'),
(133, 10, 'Admin Admin', 'admin', 'Archive User', 'Archived user: jlguevarra', '2025-12-09 05:42:12'),
(134, 10, 'Admin Admin', 'admin', 'Restore', 'Restored user ID: 21', '2025-12-09 05:42:33'),
(135, 10, 'Admin Admin', 'admin', 'Archive User', 'Archived user: jlguevarra', '2025-12-09 05:43:27'),
(136, 10, 'Admin Admin', 'admin', 'Create Department', 'Created department: sample', '2025-12-09 05:50:36'),
(137, 10, 'Admin Admin', 'admin', 'Update Department', 'Updated department ID: 12 (sample)', '2025-12-09 05:50:58'),
(138, 10, 'Admin Admin', 'admin', 'Archive Department', 'Archived department: sample', '2025-12-09 05:51:19'),
(139, 10, 'Admin Admin', 'admin', 'Archive User', 'Archived user: jlguevarraq', '2025-12-09 05:52:13'),
(140, 10, 'Admin Admin', 'admin', 'Restore', 'Restored user ID: 21', '2025-12-09 05:52:25'),
(141, 10, 'Admin Admin', 'admin', 'Update User', 'Updated user: jlguevarras (ID: 21)', '2025-12-09 06:04:04'),
(142, 10, 'Admin Admin', 'admin', 'Archive User', 'Archived user: jlguevarras', '2025-12-09 06:12:09'),
(143, 10, 'Admin Admin', 'admin', 'Archive User', 'Archived user: jlguevarras', '2025-12-09 06:12:29'),
(144, 10, 'Admin Admin', 'admin', 'Archive User', 'Archived user: jlguevarras', '2025-12-09 06:12:33'),
(145, 10, 'Admin Admin', 'admin', 'Archive User', 'Archived user: jlguevarras', '2025-12-09 06:12:38'),
(146, 10, 'Admin Admin', 'admin', 'Create Department', 'Created department: sample', '2025-12-09 06:13:44'),
(147, 10, 'Admin Admin', 'admin', 'Update Department', 'Updated department ID: 13 (samplews)', '2025-12-09 06:13:58'),
(148, 10, 'Admin Admin', 'admin', 'Archive Department', 'Archived department: samplews', '2025-12-09 06:14:09'),
(149, 10, 'Admin Admin', 'admin', 'Archive User', 'Archived user: jlguevarras', '2025-12-09 06:18:07'),
(150, 10, 'Admin Admin', 'admin', 'Update User', 'Updated user: jlguevarra (ID: 21)', '2025-12-09 06:18:15'),
(151, 10, 'Admin Admin', 'admin', 'Archive User', 'Archived user: jlguevarra', '2025-12-09 06:18:19'),
(152, 10, 'Admin Admin', 'admin', 'Restore', 'Restored user ID: 21', '2025-12-09 06:25:14'),
(153, 10, 'Admin Admin', 'admin', 'Archive User', 'Archived user: jlguevarra', '2025-12-09 06:25:19'),
(154, 10, 'Admin Admin', 'admin', 'Restore', 'Restored user ID: 21', '2025-12-09 06:26:17'),
(155, 10, 'Admin Admin', 'admin', 'Update User', 'Updated user: jlguevarras (ID: 21)', '2025-12-09 06:26:23'),
(156, 10, 'Admin Admin', 'admin', 'Archive User', 'Archived user: jlguevarras', '2025-12-09 06:26:31'),
(157, 10, 'Admin Admin', 'admin', 'Create User', 'Created user: jlguevarraada (faculty)', '2025-12-09 06:26:58'),
(158, 10, 'Admin Admin', 'admin', 'Archive User', 'Archived user: jlguevarraada', '2025-12-09 06:27:07'),
(159, 10, 'Admin Admin', 'admin', 'Update Department', 'Updated department ID: 5 (SASEDs)', '2025-12-09 06:28:02'),
(160, 10, 'Admin Admin', 'admin', 'Update Department', 'Updated department ID: 5 (SASED)', '2025-12-09 06:28:21'),
(161, 10, 'Admin Admin', 'admin', 'Create User', 'Created user: jlguevarraSDA (faculty)', '2025-12-09 06:45:25'),
(162, 10, 'Admin Admin', 'admin', 'Update User', 'Updated user: jlguevarraSDADAD (ID: 23)', '2025-12-09 06:45:38'),
(163, 10, 'Admin Admin', 'admin', 'Archive User', 'Archived user: jlguevarraSDADAD', '2025-12-09 06:45:47'),
(164, 10, 'Admin Admin', 'admin', 'Create Department', 'Created department: DADD', '2025-12-09 06:46:03'),
(165, 10, 'Admin Admin', 'admin', 'Update Department', 'Updated department ID: 14 (DADDDAAD)', '2025-12-09 06:46:20'),
(166, 10, 'Admin Admin', 'admin', 'Archive Department', 'Archived department: DADDDAAD', '2025-12-09 06:46:28'),
(167, 10, 'Admin Admin', 'admin', 'Archive', 'Archived folder \'sba\' (ID: 12)', '2025-12-09 06:47:00'),
(168, 10, 'Admin Admin', 'admin', 'Archive', 'Archived file \'Explanation.docx\'', '2025-12-09 06:47:08'),
(169, 10, 'Admin Admin', 'admin', 'Create User', 'Created user: hahaa (faculty)', '2025-12-09 07:07:48'),
(170, 10, 'Admin Admin', 'admin', 'Archive User', 'Archived user: hahaa', '2025-12-09 07:17:09'),
(171, 10, 'Admin Admin', 'admin', 'Update User', 'Updated user: Scj Faculty (ID: 20)', '2025-12-12 10:14:33'),
(172, 10, 'Admin Admin', 'admin', 'Update Department', 'Updated department ID: 5 (SASED)', '2025-12-12 10:14:46'),
(173, 10, 'John Lloyd Guevarra', 'admin', 'Restore', 'Restored user ID: 24', '2025-12-12 10:45:09'),
(174, 10, 'John Lloyd Guevarra', 'admin', 'Archive User', 'Archived user: hahaa', '2025-12-12 10:48:33'),
(175, 10, 'John Lloyd Guevarra', 'admin', 'Restore', 'Restored user ID: 24', '2025-12-12 10:48:39'),
(176, 10, 'John Lloyd Guevarra', 'admin', 'Create Department', 'Created department: SASED', '2025-12-12 10:51:57'),
(177, 10, 'John Lloyd Guevarra', 'admin', 'Archive Department', 'Archived department: SASED', '2025-12-12 10:52:02'),
(178, 10, 'John Lloyd Guevarra', 'admin', 'Update User', 'Updated user: hahaaa (ID: 24)', '2025-12-12 11:09:21'),
(179, 10, 'John Lloyd Guevarra', 'admin', 'Update User', 'Updated user: hahaaa (ID: 24)', '2025-12-12 11:09:29'),
(180, 10, 'John Lloyd Guevarra', 'admin', 'Update User', 'Updated user: hahaaa (ID: 24)', '2025-12-12 11:09:38'),
(181, 10, 'John Lloyd Guevarra', 'admin', 'Archive User', 'Archived user: hahaaa', '2025-12-12 13:08:56'),
(182, 10, 'John Lloyd Guevarra', 'admin', 'Archive User', 'Archived user: Scj Faculty', '2025-12-15 00:53:24'),
(183, 10, 'John Lloyd Guevarra', 'admin', 'Archive User', 'Archived user: Scj Program', '2025-12-15 01:02:00'),
(184, 10, 'John Lloyd Guevarra', 'admin', 'Restore', 'Restored user ID: 19', '2025-12-15 01:02:35'),
(185, 15, 'Scite Chair', 'program_chair', 'Folder Upload', 'Uploaded folder structure with 2 files.', '2025-12-15 03:00:06'),
(186, 15, 'Scite Chair', 'program_chair', 'Archive', 'Archived folder \'Pinning photos\' (ID: 15)', '2025-12-15 03:01:15'),
(187, 10, 'John Lloyd Guevarra', 'admin', 'Upload', 'Uploaded file \'IMG_9006.JPG\' to Root Directory', '2025-12-15 05:30:42'),
(188, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived file \'IMG_9006.JPG\'', '2025-12-15 05:33:55'),
(189, 10, 'John Lloyd Guevarra', 'admin', 'Upload', 'Uploaded folder structure with 2 files.', '2025-12-15 05:42:35'),
(190, 10, 'John Lloyd Guevarra', 'admin', 'Archive Folder', 'Archived folder \'Pinning photos\' (ID: 16)', '2025-12-15 05:46:53'),
(191, 10, 'John Lloyd Guevarra', 'admin', 'Archive File', 'Archived file \'Screenshot 2025-06-09 141747.png\'', '2025-12-15 05:47:09'),
(192, 10, 'John Lloyd Guevarra', 'admin', 'Create Folder', 'Created folder \'Midterm\' in Root Directory', '2025-12-15 05:47:21'),
(193, 10, 'John Lloyd Guevarra', 'admin', 'Upload Folder', 'Uploaded folder structure with 2 files.', '2025-12-15 05:47:42'),
(194, 10, 'John Lloyd Guevarra', 'admin', 'Upload File', 'Uploaded file \'IMG_9006.JPG\' to Root Directory', '2025-12-15 05:47:55'),
(195, 10, 'John Lloyd Guevarra', 'admin', 'Archive File', 'Archived file \'IMG_9006.JPG\'', '2025-12-15 05:48:13'),
(196, 10, 'John Lloyd Guevarra', 'admin', 'Archive Folder', 'Archived folder \'Midterm\' (ID: 17)', '2025-12-15 05:48:18'),
(197, 10, 'John Lloyd Guevarra', 'admin', 'Upload Folder', 'Uploaded folder structure with 2 files.', '2025-12-15 05:48:39'),
(198, 10, 'John Lloyd Guevarra', 'admin', 'Create Folder', 'Created folder \'scite\' in Root Directory', '2025-12-15 05:55:16'),
(199, 10, 'John Lloyd Guevarra', 'admin', 'Create Folder', 'Created folder \'scite\' in Root Directory', '2025-12-15 05:55:26'),
(200, 10, 'John Lloyd Guevarra', 'admin', 'Create Folder', 'Created folder \'scite\' in Root Directory', '2025-12-15 05:55:38'),
(201, 10, 'John Lloyd Guevarra', 'admin', 'Create Folder', 'Created folder \'Midterm\' in Root Directory', '2025-12-15 05:55:47'),
(202, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'scite\' (ID: 18)', '2025-12-15 06:00:33'),
(203, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'scite\' (ID: 19)', '2025-12-15 06:00:47'),
(204, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'scite\' (ID: 20)', '2025-12-15 06:00:55'),
(205, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'Midterm\' (ID: 21)', '2025-12-15 06:01:06'),
(206, 10, 'John Lloyd Guevarra', 'admin', 'Create Folder', 'Created folder \'scj\' in Root Directory', '2025-12-15 06:01:11'),
(207, 10, 'John Lloyd Guevarra', 'admin', 'Create Folder', 'Created folder \'scj (2)\' in Root Directory', '2025-12-15 06:01:14'),
(208, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'scj (2)\' (ID: 23)', '2025-12-15 06:01:18'),
(209, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'scj\' (ID: 22)', '2025-12-15 06:01:21'),
(210, 10, 'John Lloyd Guevarra', 'admin', 'Create Folder', 'Created folder \'Midterm (2)\' in Root Directory', '2025-12-15 06:03:07'),
(211, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'Midterm (2)\' (ID: 24)', '2025-12-15 06:03:24'),
(212, 10, 'John Lloyd Guevarra', 'admin', 'Create Folder', 'Created folder \'Midterm (3)\' in Root Directory', '2025-12-15 06:03:28'),
(213, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'Midterm (3)\' (ID: 25)', '2025-12-15 06:05:58'),
(214, 10, 'John Lloyd Guevarra', 'admin', 'Create Folder', 'Created folder \'Midterm\' in Root Directory', '2025-12-15 06:08:47'),
(215, 10, 'John Lloyd Guevarra', 'admin', 'Restore', 'Restored folder ID: 24', '2025-12-15 06:08:57'),
(216, 10, 'John Lloyd Guevarra', 'admin', 'Restore', 'Restored folder ID: 17 (Renamed to \'Midterm (3)\' due to conflict)', '2025-12-15 06:09:07'),
(217, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'Midterm (3)\' (ID: 17)', '2025-12-15 06:09:12'),
(218, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'Midterm (2)\' (ID: 24)', '2025-12-15 06:09:15'),
(219, 10, 'John Lloyd Guevarra', 'admin', 'Restore', 'Restored folder ID: 25', '2025-12-15 06:09:22'),
(220, 10, 'John Lloyd Guevarra', 'admin', 'Restore', 'Restored folder ID: 21 (Renamed to \'Midterm (2)\' due to conflict)', '2025-12-15 06:09:44'),
(221, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'Midterm (3)\' (ID: 25)', '2025-12-15 06:09:54'),
(222, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'Midterm (2)\' (ID: 21)', '2025-12-15 06:09:57'),
(223, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'Midterm\' (ID: 26)', '2025-12-15 06:11:51'),
(224, 10, 'John Lloyd Guevarra', 'admin', 'Upload', 'Uploaded file \'dp.jpg\' to Folder ID: 14', '2026-01-06 03:39:37'),
(225, 10, 'John Lloyd Guevarra', 'admin', 'Update User', 'Updated user: Scj Programs (ID: 19)', '2026-01-06 03:40:07'),
(226, 10, 'John Lloyd Guevarra', 'admin', 'Update User', 'Updated user: Scj Program (ID: 19)', '2026-01-06 03:40:27'),
(227, 15, 'Scite Chair', 'program_chair', 'Upload Folder', 'Bulk uploaded 2 files to Root Directory', '2026-01-06 06:27:18'),
(228, 15, 'Scite Chair', 'program_chair', 'Upload Folder', 'Bulk uploaded 2 files to Root Directory', '2026-01-06 06:27:39'),
(229, 15, 'Scite Chair', 'program_chair', 'Archive', 'Archived file \'Screenshot 2025-12-23 225922.png\'', '2026-01-06 06:27:53'),
(230, 15, 'Scite Chair', 'program_chair', 'Archive', 'Archived file \'Screenshot 2025-12-23 222155.png\'', '2026-01-06 06:27:55'),
(231, 15, 'Scite Chair', 'program_chair', 'Archive', 'Archived file \'Screenshot 2025-12-23 225922.png\'', '2026-01-06 06:27:58'),
(232, 15, 'Scite Chair', 'program_chair', 'Archive', 'Archived file \'Screenshot 2025-12-23 222155.png\'', '2026-01-06 06:28:00'),
(233, 15, 'Scite Chair', 'program_chair', 'Create Folder', 'Auto-created folder \'Screenshots\' from upload', '2026-01-06 06:40:38'),
(234, 15, 'Scite Chair', 'program_chair', 'Create Folder', 'Auto-created folder \'Screenshots\' from upload', '2026-01-06 06:40:55'),
(235, 15, 'Scite Chair', 'program_chair', 'Create Folder', 'Created folder \'dw\' in Root Directory', '2026-01-06 06:44:49'),
(236, 15, 'Scite Chair', 'program_chair', 'Create Folder', 'Created folder \'dawd\' in Root Directory', '2026-01-06 06:44:59'),
(237, 15, 'Scite Chair', 'program_chair', 'Create Folder', 'Created folder \'dawdawdw\' in Root Directory', '2026-01-06 06:45:08'),
(238, 15, 'Scite Chair', 'program_chair', 'Archive', 'Archived folder \'dawd\' (ID: 30)', '2026-01-06 06:45:16'),
(239, 15, 'Scite Chair', 'program_chair', 'Create Folder', 'Created folder \'dadadas\' in Root Directory', '2026-01-06 06:45:39'),
(240, 15, 'Scite Chair', 'program_chair', 'Archive', 'Archived folder \'dadadas\' (ID: 32)', '2026-01-06 06:45:58'),
(241, 15, 'Scite Chair', 'program_chair', 'Archive', 'Archived folder \'dawdawdw\' (ID: 31)', '2026-01-06 06:46:18'),
(242, 10, 'John Lloyd Guevarra', 'admin', 'Create Folder', 'Auto-created folder \'Screenshots (1)\' from upload', '2026-01-06 06:59:31'),
(243, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'Screenshots\' (ID: 27)', '2026-01-06 06:59:47'),
(244, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'Screenshots\' (ID: 28)', '2026-01-06 07:28:13'),
(245, 10, 'John Lloyd Guevarra', 'admin', 'Restore', 'Restored folder ID: 28', '2026-01-06 07:28:23'),
(246, 10, 'John Lloyd Guevarra', 'admin', 'Create User', 'Created user: jlguevarra (admin)', '2026-01-06 07:42:11'),
(247, 10, 'John Lloyd Guevarra', 'admin', 'Archive User', 'Archived user: jlguevarra', '2026-01-06 07:42:23'),
(248, 10, 'John Lloyd Guevarra', 'admin', 'Update User', 'Updated user: Scjs Program (ID: 19)', '2026-01-06 08:13:50'),
(249, 10, 'John Lloyd Guevarra', 'admin', 'Update User', 'Updated user: Scj Program (ID: 19)', '2026-01-06 08:14:01'),
(250, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'Screenshots\' (ID: 28)', '2026-01-06 08:22:07'),
(251, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'dw\' (ID: 29)', '2026-01-06 08:22:11'),
(252, 10, 'John Lloyd Guevarra', 'admin', 'Create User', 'Created user: chan (admin)', '2026-01-06 08:23:40'),
(253, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'Screenshots (1)\' (ID: 33)', '2026-01-06 08:23:51'),
(254, 10, 'John Lloyd Guevarra', 'admin', 'Update User', 'Updated user: chan (ID: 26)', '2026-01-06 08:24:32'),
(255, 10, 'John Lloyd Guevarra', 'admin', 'Archive User', 'Archived user: chan', '2026-01-06 08:26:17'),
(256, 10, 'John Lloyd Guevarra', 'admin', 'Update Department', 'Updated department ID: 5 (SASED)', '2026-01-06 08:58:37'),
(257, 10, 'John Lloyd Guevarra', 'admin', 'Upload', 'Uploaded file \'dp (1).jpg\' to Folder ID: 14', '2026-01-07 06:22:58'),
(258, 10, 'John Lloyd Guevarra', 'admin', 'Update User', 'Updated user: Scjs Program (ID: 19)', '2026-01-07 06:23:53'),
(259, 10, 'John Lloyd Guevarra', 'admin', 'Update User', 'Updated user: Scj Program (ID: 19)', '2026-01-07 06:24:05'),
(260, 10, 'John Lloyd Guevarra', 'admin', 'Upload', 'Uploaded file \'dp (2).jpg\' to Folder ID: 14', '2026-01-07 06:52:15'),
(261, 10, 'John Lloyd Guevarra', 'admin', 'Upload', 'Uploaded file \'Screenshot 2025-12-23 225922.png\' to Folder ID: 14', '2026-01-07 06:53:49'),
(262, 10, 'John Lloyd Guevarra', 'admin', 'Upload', 'Uploaded file \'Screenshot 2025-12-23 222155.png\' to Folder ID: 14', '2026-01-07 06:54:07'),
(263, 10, 'John Lloyd Guevarra', 'admin', 'Upload', 'Uploaded file \'Screenshot 2025-12-23 225922 - Copy.png\' to Folder ID: 14', '2026-01-07 06:54:19'),
(264, 10, 'John Lloyd Guevarra', 'admin', 'Upload', 'Uploaded file \'Screenshot 2025-12-23 225922 (1).png\' to Folder ID: 14', '2026-01-07 07:31:15'),
(265, 10, 'John Lloyd Guevarra', 'admin', 'Upload', 'Uploaded file \'Screenshot 2025-12-23 225922 (2).png\' to Folder ID: 14', '2026-01-07 07:31:22'),
(266, 10, 'John Lloyd Guevarra', 'admin', 'Upload', 'Uploaded file \'Screenshot 2025-12-23 225922 (3).png\' to Folder ID: 14', '2026-01-07 07:31:31'),
(267, 10, 'John Lloyd Guevarra', 'admin', 'Create Folder', 'Auto-created folder \'Screenshots\' from upload', '2026-01-07 08:02:01'),
(268, 10, 'John Lloyd Guevarra', 'admin', 'Create Folder', 'Auto-created folder \'Screenshots (1)\' from upload', '2026-01-07 08:02:17'),
(269, 10, 'John Lloyd Guevarra', 'admin', 'Create Folder', 'Created folder \'dawd\' in Root Directory', '2026-01-07 08:02:48'),
(270, 10, 'John Lloyd Guevarra', 'admin', 'Create Folder', 'Created folder \'s\' in Root Directory', '2026-01-07 08:03:49'),
(271, 10, 'John Lloyd Guevarra', 'admin', 'Create Folder', 'Created folder \'s (1)\' in Root Directory', '2026-01-07 08:03:52'),
(272, 10, 'John Lloyd Guevarra', 'admin', 'Create Folder', 'Created folder \'s (2)\' in Root Directory', '2026-01-07 08:03:56'),
(273, 10, 'John Lloyd Guevarra', 'admin', 'Upload', 'Uploaded file \'Screenshot 2025-12-23 225922 - Copy.png\' to Root Directory', '2026-01-07 08:08:14'),
(274, 19, 'Scj Program', 'program_chair', 'Upload', 'Uploaded file \'Screenshot 2025-12-23 225922 - Copy.png\' to Root Directory', '2026-01-07 08:16:36'),
(275, 19, 'Scj Program', 'program_chair', 'Upload', 'Uploaded file \'dp.jpg\' to Root Directory', '2026-01-07 08:17:13'),
(276, 10, 'John Lloyd Guevarra', 'admin', 'Restore', 'Restored user ID: 20', '2026-01-07 08:18:58'),
(277, 10, 'John Lloyd Guevarra', 'admin', 'Create Folder', 'Created folder \'h\' in Root Directory', '2026-01-07 08:19:29'),
(278, 10, 'John Lloyd Guevarra', 'admin', 'Update Department', 'Updated department ID: 5 (SASEDa)', '2026-01-07 08:29:38'),
(279, 10, 'John Lloyd Guevarra', 'admin', 'Update Department', 'Updated department ID: 5 (SASED)', '2026-01-07 08:29:48'),
(280, 10, 'John Lloyd Guevarra', 'admin', 'Update User', 'Updated user: Scj Facultys (ID: 20)', '2026-01-08 05:52:09'),
(281, 10, 'John Lloyd Guevarra', 'admin', 'Update User', 'Updated user: Scj Faculty (ID: 20)', '2026-01-08 05:53:44'),
(282, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived file \'dp.jpg\'', '2026-01-08 06:23:44'),
(283, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived file \'Screenshot 2025-12-23 225922 - Copy.png\'', '2026-01-08 06:23:48'),
(284, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived file \'Screenshot 2025-12-23 225922 - Copy.png\'', '2026-01-08 06:23:53'),
(285, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'h\' (ID: 40)', '2026-01-08 06:23:59'),
(286, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'s (2)\' (ID: 39)', '2026-01-08 06:24:02'),
(287, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'s (1)\' (ID: 38)', '2026-01-08 06:24:05'),
(288, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'dawd\' (ID: 36)', '2026-01-08 06:24:09'),
(289, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'s\' (ID: 37)', '2026-01-08 06:24:13'),
(290, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'Screenshots (1)\' (ID: 35)', '2026-01-08 06:24:49'),
(291, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'Screenshots\' (ID: 34)', '2026-01-08 06:24:55'),
(292, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'scj\' (ID: 14)', '2026-01-08 06:25:00'),
(293, 10, 'John Lloyd Guevarra', 'admin', 'Create Folder', 'Created folder \'s\' in Root Directory', '2026-01-08 06:26:51'),
(294, 10, 'John Lloyd Guevarra', 'admin', 'Update User', 'Updated user: Scj Facultyq (ID: 20)', '2026-01-08 06:27:00'),
(295, 10, 'John Lloyd Guevarra', 'admin', 'Archive', 'Archived folder \'s\' (ID: 41)', '2026-01-08 07:36:45'),
(296, 10, 'John Lloyd Guevarra', 'admin', 'Restore', 'Restored file ID: 45', '2026-01-08 07:50:36'),
(297, 10, 'John Lloyd Guevarra', 'admin', 'Restore', 'Restored file ID: 44', '2026-01-08 07:53:48');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_archived` int(11) DEFAULT 0,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `code`, `name`, `created_at`, `is_archived`, `updated_at`) VALUES
(1, 'SCITE', 'School of Computing, Information Technology and Engineering', '2025-11-25 05:41:15', 0, NULL),
(2, 'SBA', 'School of Business and Accountancy', '2025-11-25 05:41:15', 0, NULL),
(3, 'STHM', 'School of Tourism and Hospitality Management', '2025-11-25 05:41:15', 0, NULL),
(4, 'SCJ', 'School of Criminal Justice', '2025-11-25 05:41:15', 0, NULL),
(5, 'SASED', 'School of Arts, Sciences and Education', '2025-11-25 05:41:15', 0, '2026-01-07 08:29:48'),
(10, 'sample', 'sample', '2025-12-09 05:43:36', 1, NULL),
(13, 'samplews', 'samples', '2025-12-09 06:13:44', 1, NULL),
(14, 'DADDDAAD', 'DASDDASD', '2025-12-09 06:46:03', 1, NULL),
(15, 'SASED', 'admin admin', '2025-12-12 10:51:57', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_size` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `department_id` int(11) DEFAULT NULL,
  `folder_id` int(11) DEFAULT NULL,
  `is_archived` tinyint(1) DEFAULT 0,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `user_id`, `filename`, `file_path`, `file_size`, `created_at`, `department_id`, `folder_id`, `is_archived`, `updated_at`) VALUES
(28, 15, 'Explanation.docx', '1764747183_cf3afd5a9c49573ac822.docx', '15.784 KB', '2025-12-03 07:33:03', 1, NULL, 1, NULL),
(29, 17, 'SBA.docx', '1764749408_7382c1031d054cf0eb97.docx', '12.788 KB', '2025-12-03 08:10:08', 2, 12, 0, NULL),
(30, 19, 'Screenshot 2025-06-09 141747.png', '1764906908_ccbb8afb73817b254d17.png', '99.553 KB', '2025-12-05 03:55:08', 4, 14, 1, NULL),
(31, 15, 'IMG_9006.JPG', '1765767606_04c6a9388706893ada0b.jpg', '10,068.584 KB', '2025-12-15 03:00:06', 1, 15, 0, NULL),
(32, 15, 'IMG_9007.JPG', '1765767606_4e592b5385b684d7c12f.jpg', '10,725.248 KB', '2025-12-15 03:00:06', 1, 15, 0, NULL),
(33, 10, 'IMG_9006.JPG', '1765776642_2c8866854b49a0482c80.jpg', '10,068.584 KB', '2025-12-15 05:30:42', NULL, NULL, 1, NULL),
(34, 10, 'IMG_9006.JPG', '1765777355_077443f734d1c63ee932.jpg', '10,068.584 KB', '2025-12-15 05:42:35', NULL, 16, 0, NULL),
(35, 10, 'IMG_9007.JPG', '1765777355_360989924fddb7f95c3b.jpg', '10,725.248 KB', '2025-12-15 05:42:35', NULL, 16, 0, NULL),
(36, 10, 'IMG_9006.JPG', '1765777662_76ff59f025221c4a8540.jpg', '10,068.584 KB', '2025-12-15 05:47:42', NULL, 16, 0, NULL),
(37, 10, 'IMG_9007.JPG', '1765777662_3ddb463d937ab19de1b9.jpg', '10,725.248 KB', '2025-12-15 05:47:42', NULL, 16, 0, NULL),
(38, 10, 'IMG_9006.JPG', '1765777675_f3792454005e49e7b790.jpg', '10,068.584 KB', '2025-12-15 05:47:55', NULL, NULL, 1, NULL),
(39, 10, 'IMG_9006.JPG', '1765777719_929271e615aa68b50129.jpg', '10,068.584 KB', '2025-12-15 05:48:39', NULL, 16, 0, NULL),
(40, 10, 'IMG_9007.JPG', '1765777719_19ddec29c54df5960f6e.jpg', '10,725.248 KB', '2025-12-15 05:48:39', NULL, 16, 0, NULL),
(41, 10, 'dp.jpg', '1767670777_d5a9ab4f10d1ea670e16.jpg', '458.993 KB', '2026-01-06 03:39:37', NULL, 14, 0, NULL),
(42, 15, 'Screenshot 2025-12-23 222155.png', '1767680838_39396804a14f51432c82.png', '17.928 KB', '2026-01-06 06:27:18', 1, NULL, 1, NULL),
(43, 15, 'Screenshot 2025-12-23 225922.png', '1767680838_e82705d095f8c338119d.png', '28.498 KB', '2026-01-06 06:27:18', 1, NULL, 1, NULL),
(44, 15, 'Screenshot 2025-12-23 222155.png', '1767680859_5e4e391fe68fe4e49c16.png', '17.928 KB', '2026-01-06 06:27:39', 1, NULL, 0, '2026-01-08 07:53:48'),
(45, 15, 'Screenshot 2025-12-23 225922.png', '1767680859_ab19f48684fe6825eb50.png', '28.498 KB', '2026-01-06 06:27:39', 1, NULL, 0, '2026-01-08 07:50:36'),
(46, 15, 'Screenshot 2025-12-23 222155.png', '1767681638_6d05dc151509ab65e455.png', '17.928 KB', '2026-01-06 06:40:38', 1, 27, 0, NULL),
(47, 15, 'Screenshot 2025-12-23 225922.png', '1767681638_e0d52b5ca73d82529bfa.png', '28.498 KB', '2026-01-06 06:40:38', 1, 27, 0, NULL),
(48, 15, 'Screenshot 2025-12-23 222155.png', '1767681655_f1ea230453b353ba070d.png', '17.928 KB', '2026-01-06 06:40:55', 1, 28, 0, NULL),
(49, 15, 'Screenshot 2025-12-23 225922.png', '1767681655_26718e4ed23232323d98.png', '28.498 KB', '2026-01-06 06:40:55', 1, 28, 0, NULL),
(50, 10, 'Screenshot 2025-12-23 222155.png', '1767682771_20f14d125d3c7d8b419b.png', '17.928 KB', '2026-01-06 06:59:31', NULL, 33, 0, NULL),
(51, 10, 'Screenshot 2025-12-23 225922.png', '1767682771_2b558b315e43d2342087.png', '28.498 KB', '2026-01-06 06:59:31', NULL, 33, 0, NULL),
(52, 10, 'dp (1).jpg', '1767766978_8ea6f79d9c5626884917.jpg', '458.993 KB', '2026-01-06 22:22:58', NULL, 14, 0, '2026-01-07 06:22:58'),
(53, 10, 'dp (2).jpg', '1767768734_cebed94274ef7b82d544.jpg', '458.993 KB', '2026-01-06 22:52:14', NULL, 14, 0, '2026-01-07 06:52:14'),
(54, 10, 'Screenshot 2025-12-23 225922.png', '1767768829_5a1f676afca6a9a815a0.png', '28.498 KB', '2026-01-06 22:53:49', NULL, 14, 0, '2026-01-07 06:53:49'),
(55, 10, 'Screenshot 2025-12-23 222155.png', '1767768847_5d179e5479c1109c719a.png', '17.928 KB', '2026-01-06 22:54:07', NULL, 14, 0, '2026-01-07 06:54:07'),
(56, 10, 'Screenshot 2025-12-23 225922 - Copy.png', '1767768859_00a393c1d4b6f2516b47.png', '28.498 KB', '2026-01-06 22:54:19', NULL, 14, 0, '2026-01-07 06:54:19'),
(57, 10, 'Screenshot 2025-12-23 225922 (1).png', '1767771075_e7577d259792d3e06a49.png', '28.498 KB', '2026-01-06 23:31:15', NULL, 14, 0, '2026-01-07 07:31:15'),
(58, 10, 'Screenshot 2025-12-23 225922 (2).png', '1767771082_4c3e54bd275bd9926823.png', '28.498 KB', '2026-01-06 23:31:22', NULL, 14, 0, '2026-01-07 07:31:22'),
(59, 10, 'Screenshot 2025-12-23 225922 (3).png', '1767771091_00a5f7fdd250f2fa24dd.png', '28.498 KB', '2026-01-06 23:31:31', NULL, 14, 0, '2026-01-07 07:31:31'),
(60, 10, 'Screenshot 2025-12-23 222155.png', '1767772921_110eff55457000f32ee1.png', '17.928 KB', '2026-01-07 00:02:01', NULL, 34, 0, '2026-01-07 08:02:01'),
(61, 10, 'Screenshot 2025-12-23 225922 - Copy.png', '1767772921_7f18d54a74c479b598b7.png', '28.498 KB', '2026-01-07 00:02:01', NULL, 34, 0, '2026-01-07 08:02:01'),
(62, 10, 'Screenshot 2025-12-23 225922.png', '1767772921_fc2b81c09065ad126a1e.png', '28.498 KB', '2026-01-07 00:02:01', NULL, 34, 0, '2026-01-07 08:02:01'),
(63, 10, 'Screenshot 2025-12-23 222155.png', '1767772937_d4dbf75c87b33be0f9d5.png', '17.928 KB', '2026-01-07 00:02:17', NULL, 35, 0, '2026-01-07 08:02:17'),
(64, 10, 'Screenshot 2025-12-23 225922 - Copy.png', '1767772937_1bd4ba8930cebac16a07.png', '28.498 KB', '2026-01-07 00:02:17', NULL, 35, 0, '2026-01-07 08:02:17'),
(65, 10, 'Screenshot 2025-12-23 225922.png', '1767772937_ed97c736040b0e74d044.png', '28.498 KB', '2026-01-07 00:02:17', NULL, 35, 0, '2026-01-07 08:02:17'),
(66, 10, 'Screenshot 2025-12-23 225922 - Copy.png', '1767773294_532455b7ee3f7206c65b.png', '28.498 KB', '2026-01-07 00:08:14', NULL, NULL, 1, '2026-01-08 06:23:53'),
(67, 19, 'Screenshot 2025-12-23 225922 - Copy.png', '1767773796_205c570c6a78c63f5f2e.png', '28.498 KB', '2026-01-07 00:16:36', 4, NULL, 1, '2026-01-08 06:23:48'),
(68, 19, 'dp.jpg', '1767773832_356416108f79dae66b2c.jpg', '458.993 KB', '2026-01-07 00:17:13', 4, NULL, 1, '2026-01-08 06:23:44');

-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

CREATE TABLE `folders` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `department_id` int(11) DEFAULT NULL,
  `is_archived` tinyint(1) DEFAULT 0,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `folders`
--

INSERT INTO `folders` (`id`, `parent_id`, `name`, `created_at`, `department_id`, `is_archived`, `updated_at`) VALUES
(12, NULL, 'sba', '2025-12-03 16:09:56', 2, 1, NULL),
(13, 12, 'sba1', '2025-12-03 16:10:01', 2, 0, NULL),
(14, NULL, 'scj', '2025-12-05 11:54:59', 4, 1, '2026-01-08 06:25:00'),
(15, NULL, 'Pinning photos', '2025-12-15 11:00:06', 1, 1, NULL),
(16, NULL, 'Pinning photos', '2025-12-15 13:42:35', NULL, 1, NULL),
(17, NULL, 'Midterm (3)', '2025-12-15 13:47:21', NULL, 1, NULL),
(18, NULL, 'scite', '2025-12-15 13:55:16', NULL, 1, NULL),
(19, NULL, 'scite', '2025-12-15 13:55:26', NULL, 1, NULL),
(20, NULL, 'scite', '2025-12-15 13:55:38', NULL, 1, NULL),
(21, NULL, 'Midterm (2)', '2025-12-15 13:55:47', NULL, 1, NULL),
(22, NULL, 'scj', '2025-12-15 14:01:11', NULL, 1, NULL),
(23, NULL, 'scj (2)', '2025-12-15 14:01:14', NULL, 1, NULL),
(24, NULL, 'Midterm (2)', '2025-12-15 14:03:07', NULL, 1, NULL),
(25, NULL, 'Midterm (3)', '2025-12-15 14:03:28', NULL, 1, NULL),
(26, NULL, 'Midterm', '2025-12-15 14:08:47', NULL, 1, NULL),
(27, NULL, 'Screenshots', '2026-01-06 14:40:38', 1, 1, NULL),
(28, NULL, 'Screenshots', '2026-01-06 14:40:55', 1, 1, '2026-01-06 08:22:06'),
(29, NULL, 'dw', '2026-01-06 14:44:49', 1, 1, '2026-01-06 08:22:11'),
(30, NULL, 'dawd', '2026-01-06 14:44:59', 1, 1, NULL),
(31, NULL, 'dawdawdw', '2026-01-06 14:45:08', 1, 1, NULL),
(32, NULL, 'dadadas', '2026-01-06 14:45:39', 1, 1, NULL),
(33, NULL, 'Screenshots (1)', '2026-01-06 14:59:31', NULL, 1, '2026-01-06 08:23:51'),
(34, NULL, 'Screenshots', '2026-01-07 08:02:01', NULL, 1, '2026-01-08 06:24:55'),
(35, NULL, 'Screenshots (1)', '2026-01-07 08:02:17', NULL, 1, '2026-01-08 06:24:49'),
(36, NULL, 'dawd', '2026-01-07 08:02:48', NULL, 1, '2026-01-08 06:24:09'),
(37, NULL, 's', '2026-01-07 08:03:49', NULL, 1, '2026-01-08 06:24:13'),
(38, NULL, 's (1)', '2026-01-07 08:03:52', NULL, 1, '2026-01-08 06:24:05'),
(39, NULL, 's (2)', '2026-01-07 08:03:56', NULL, 1, '2026-01-08 06:24:02'),
(40, NULL, 'h', '2026-01-07 08:19:29', NULL, 1, '2026-01-08 06:23:59'),
(41, NULL, 's', '2026-01-08 06:26:51', NULL, 1, '2026-01-08 07:36:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','program_chair','faculty') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `department_id` int(11) DEFAULT NULL,
  `is_archived` tinyint(1) DEFAULT 0,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `department_id`, `is_archived`, `updated_at`) VALUES
(10, 'John Lloyd Guevarra', 'admin@hcc.edu.ph', '$2y$10$gRSjmRXulUle4/NoRU5fd.pbRTNyqZAxaTxoj7SXP5doVPsEpVpnK', 'admin', '2025-11-24 02:49:49', NULL, 0, NULL),
(15, 'Scite Chair', 'scite@hcc.edu.ph', '$2y$10$gpTEVF0VpPIPmd8dzJmKSeKKH6lqVG08mtAdkrEXcNRIy1VymIc6.', 'program_chair', '2025-11-27 05:42:18', 1, 0, NULL),
(16, 'Scite Faculty', 'scite1@hcc.edu.ph', '$2y$10$Bi5PNJdBUahPLDNOZOJIyu4eggyXpBwm7WhWVolDYDgtlXmcMpIai', 'faculty', '2025-11-27 05:43:06', 1, 0, NULL),
(17, 'Sba Chair', 'sba@hcc.edu.ph', '$2y$10$sNY/rYdQmb0AjxZ/t6UVNeh0dvgxakDerXi20yoj0bGNLD6iikMEG', 'program_chair', '2025-11-27 05:58:35', 2, 0, NULL),
(18, 'Sba Faculty', 'sba1@hcc.edu.ph', '$2y$10$YPcACN8GJurndkWoGdv48e0/vy6fP4DbWk/jJp4qTUu2CvdGTWDg2', 'faculty', '2025-11-27 05:58:58', 2, 0, NULL),
(19, 'Scj Program', 'scj@hcc.edu.ph', '$2y$10$z7qftaPXEhz4RAk5xRq.Iu1Mycym7z3wwkKovVfBkPxyKGoUd186S', 'program_chair', '2025-12-02 03:23:30', 4, 0, '2026-01-07 06:24:05'),
(20, 'Scj Facultyq', 'scj1@hcc.edu.ph', '$2y$10$UjgG6d6FBLL0bqEF3DI/0.P3BsVQiJF8PvgActOhWZneCRH0VzYPe', 'faculty', '2025-12-02 03:24:00', 4, 0, '2026-01-08 06:27:00'),
(21, 'jlguevarras', 'admin12@hcc.edu.ph', '$2y$10$kYeMdjgrv21sO9MMhGfGS.hsx/KJhTt0bfYOqe7PSw6QoQ2vJnvUW', 'faculty', '2025-12-09 05:42:01', 1, 1, NULL),
(22, 'jlguevarraada', 'admidadawdn@hcc.edu.ph', '$2y$10$O3DD1SPQhDrfo91eJmcsSeNPcJB3QjLBgXCtMrQX2ScPRK1e6waGG', 'faculty', '2025-12-09 06:26:58', 5, 1, NULL),
(23, 'jlguevarraSDADAD', 'adSDASDDin@hcc.edu.ph', '$2y$10$LGac4aANa.JAkvpH3jE.0.HwGbOCIwNvoInINXHaJxy9xssXKqO52', 'faculty', '2025-12-09 06:45:25', 10, 1, NULL),
(24, 'hahaaa', 'haha@gmail.com', '$2y$10$s32oXrJBjcHAZPNx13DfQetGGTptPkzpio6KfKCqX7AsAl9F0rt7i', 'faculty', '2025-12-09 07:07:48', 1, 1, NULL),
(25, 'jlguevarra', 'johnlloydguevarra0405@gmail.com', '$2y$10$EWu7unpSYTa79yOOxWc2/eGI7gnbcSZ82//se28NQAB4uOGsvhRlm', 'admin', '2026-01-05 23:42:11', 4, 1, '2026-01-06 07:42:11'),
(26, 'chan', 'chan@hcc.edu.ph', '$2y$10$SttLRMfmckJYCxSBSrTQduKSJN7J0liuzCXaI8YZ.Sq6NDSaN5FR6', 'admin', '2026-01-06 00:23:40', 3, 1, '2026-01-06 08:24:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `folder_id` (`folder_id`);

--
-- Indexes for table `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=298;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `folders`
--
ALTER TABLE `folders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `files_ibfk_2` FOREIGN KEY (`folder_id`) REFERENCES `folders` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `folders`
--
ALTER TABLE `folders`
  ADD CONSTRAINT `folders_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `folders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `folders_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
