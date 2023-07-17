-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2023 at 12:39 PM
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
-- Database: `course`
--

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `coursename` varchar(100) NOT NULL,
  `moduleID` varchar(10) NOT NULL,
  `modulename` varchar(100) NOT NULL,
  `datecreated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`coursename`, `moduleID`, `modulename`, `datecreated`) VALUES
('backend', 'Module 1', 'Introduction To Backend Tools And PHP Fundamentals', '2023-07-14 09:08:37'),
('backend', 'Module 2', 'Web Application And Database Basics', '2023-07-14 10:13:17'),
('backend', 'Module 3', 'Object Oriented Programming', '2023-07-14 10:14:16'),
('backend', 'Module 4', 'REST API And Frameworks', '2023-07-14 10:14:51'),
('backend', 'Module 5', 'Managing PHP Applications', '2023-07-14 10:15:18'),
('backend', 'Module 6', 'Introduction To Symphony Framework', '2023-07-14 10:15:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD UNIQUE KEY `moduleID` (`moduleID`),
  ADD UNIQUE KEY `modulename` (`modulename`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
