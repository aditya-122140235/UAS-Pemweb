-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2024 at 05:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reset`
--

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `teacher_name` varchar(100) NOT NULL,
  `day_of_week` varchar(20) NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `subject_name`, `teacher_name`, `day_of_week`, `time_start`, `time_end`, `created_at`) VALUES
(1, 'KSI', 'Mugi Praseptiawan', 'Kamis', '15:00:00', '17:00:00', '2024-12-23 13:28:42'),
(3, 'Pemrograman Web', 'Muhammad Habib Algifari, S.Kom., M.T.I.', 'Selasa', '13:00:00', '14:00:00', '2024-12-24 16:50:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `contact`, `password`, `created_at`) VALUES
(3, 'aditya', 'wahyusuhendaraditya@gmail.com', '085842816810', '$2y$10$3fnyqbC4ISVdMzL/tPfEx.DWmfK02Tc7nYcNbcCt9QBNvTENCCQii', '2024-12-23 08:43:45'),
(6, 'aditya', 'aditya@gmail.com', '123', '$2y$10$FmtA0GNZD/y6KA4VOna2HubfGyllRl8.iNHlW4TPCZw4/R4qJsDcG', '2024-12-23 12:23:28'),
(7, 'aditya', 'guru@sch.id', '123', '$2y$10$aX.G1icyT1JtVHEUGsWhq.kImdyhT0mBvlNwHd26clxcjfzDIwfKm', '2024-12-23 13:17:50'),
(9, 'admin', 'admin@gmail.com', '123', '$2y$10$5woNpHJnt4g5abXkItkCZOoXEWUifyvQQUpaAFQZYzjqHVngOrmuq', '2024-12-24 16:24:29'),
(10, 'zahran', 'zahran@gmail.com', '123', '$2y$10$kqdlYPVyql4IZF2SPVKxdeFnDdCCP7qjYDe.d87MuAvwMcYsUk0Be', '2024-12-24 16:25:14'),
(13, 'bas', 'bas@gmail.com', '123', '$2y$10$5.1my5GE4xl92VrwNvteAuIkWv1Ons7B9Fx7DjFZrD2zIxu19ZZzO', '2024-12-24 16:38:18'),
(15, 'admin', 'adminnn@gmail.com', '123', '$2y$10$dNIyhX1/KT2ooUKxKwVcS.CPTbb4/d1FRaPcX/t748vvZljSIDiDK', '2024-12-24 16:47:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
