-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2026 at 05:50 AM
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
-- Database: `game_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `highscores`
--

CREATE TABLE `highscores` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `score` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `highscores`
--

INSERT INTO `highscores` (`id`, `user_id`, `score`, `created_at`) VALUES
(4, 3, 6400, '2025-12-31 04:03:50'),
(5, 4, 16000, '2025-12-31 04:15:37'),
(6, 4, 5600, '2025-12-31 04:17:43'),
(7, 4, 7200, '2025-12-31 04:19:02'),
(8, 2, 27200, '2025-12-31 04:21:21'),
(9, 2, 12800, '2025-12-31 04:27:34'),
(10, 2, 8400, '2025-12-31 04:28:32'),
(11, 2, 400, '2025-12-31 04:29:23'),
(12, 2, 13600, '2025-12-31 04:30:33'),
(13, 2, 12800, '2025-12-31 04:31:46'),
(14, 5, 12800, '2025-12-31 04:34:24'),
(15, 5, 19200, '2025-12-31 04:40:25'),
(16, 5, 8800, '2025-12-31 04:42:32'),
(17, 5, 10800, '2025-12-31 04:44:16'),
(18, 5, 800, '2025-12-31 05:24:43'),
(19, 5, 3600, '2025-12-31 05:25:22'),
(20, 6, 3200, '2025-12-31 05:28:22'),
(21, 7, 4400, '2026-01-03 02:27:04'),
(22, 9, 26000, '2026-01-03 02:30:01'),
(23, 10, 11200, '2026-01-03 02:33:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`) VALUES
(1, 'testuser', '$2y$10$GNQ.VP4dYcf8Ir/aA8VKFu.zTjMGIrGPRlaAbw5NMCwRb1jvvRzRq'),
(2, 'jad123', '$2y$10$AxQRANgv9AwuLXtCggqLdeSMyNVc3FZSf86rMUV4IVdkbCPpMOXg.'),
(3, 'jad', '$2y$10$D5CLd54u27YVJG91G91O9ORkrJ184nIg0c.jyDtU33UtR5BKp/eKe'),
(4, 'jadhamad20', '$2y$10$JUMbKkcpaCJ/8Z26c55b/.V4iLdWlROHewFMMkaBf8Vbw7vkPm7ZK'),
(5, 'gamedev', '$2y$10$VzI6CkurdsTj7aXsp28R2OB8whVFSI6MSYmmwvBZQeFMcOO7mRWuO'),
(6, 'jad1', '$2y$10$kxTZj4mbPHkAdYZM3Vxz.eSKRh6ouX4q0qMBl9gFpoCw8.84mx5ma'),
(7, 'test12', '$2y$10$ScxOFy7qDQDfyv5eiY8FouBHU5LaFkMbBoSoX/fr3Bm.XNEinAQbS'),
(9, 'ali', '$2y$10$Yyz58kGN6CXCMLSahZzgouqQwdNsG0O0btqNZVwUGTCjcejA1Uqki'),
(10, 'ahmed', '$2y$10$DjuG7MG.9xy8cazXDtAoNub7tqOfjfa26LS.uS.ILs8rhaUaBPv4m');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `highscores`
--
ALTER TABLE `highscores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `highscores`
--
ALTER TABLE `highscores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `highscores`
--
ALTER TABLE `highscores`
  ADD CONSTRAINT `highscores_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
