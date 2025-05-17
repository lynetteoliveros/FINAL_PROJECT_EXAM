-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2025 at 04:29 PM
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
-- Database: `users_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(10) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `severity` varchar(50) NOT NULL DEFAULT 'low',
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `assigned` varchar(50) DEFAULT 'Admin 1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `subject`, `description`, `status`, `created_at`, `severity`, `name`, `email`, `assigned`) VALUES
(1, 'cant login', 'cant login my fb', 'Open', '2025-05-16 02:36:44', 'low', '', '', 'Admin 2'),
(2, 'try', 'try', 'Open', '2025-05-16 02:42:46', 'low', 'lynette', 'lynetteoliveros1@gmail.com', 'Admin 2'),
(3, 'try 2', 'try', 'Open', '2025-05-16 02:42:52', 'low', 'lynette', 'lynetteoliveros1@gmail.com', 'Admin 3'),
(4, 'try ulit', '2', 'Closed', '2025-05-16 02:43:13', 'medium', 'lynette', 'lynetteoliveros1@gmail.com', 'Admin 3'),
(5, 'bagong subok', 'new', 'Closed', '2025-05-16 03:04:13', 'high', 'lynette', 'lynetteoliveros1@gmail.com', 'Admin 1'),
(6, 'ticket', 'ticket lang', 'Resolved', '2025-05-16 03:06:54', 'critical', 'mikaella', 'mika@gmail.com', 'Admin 1'),
(7, 'ticket', 'ulit ulit', 'Resolved', '2025-05-16 05:50:58', 'high', 'lynette', 'lynetteoliveros1@gmail.com', 'Admin 1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
