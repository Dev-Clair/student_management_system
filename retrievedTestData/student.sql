-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2023 at 12:37 PM
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
-- Database: `student`
--

-- --------------------------------------------------------

--
-- Table structure for table `backend`
--

CREATE TABLE `backend` (
  `studentname` varchar(50) NOT NULL,
  `regno.` int(20) NOT NULL,
  `coursename` varchar(100) NOT NULL,
  `datecreated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `backend`
--

INSERT INTO `backend` (`studentname`, `regno.`, `coursename`, `datecreated`) VALUES
('Samuel Aniogbu', 1689325187, 'backend', '2023-07-14 08:59:47'),
('Alex Nwokorie', 1689325391, 'backend', '2023-07-14 09:03:11'),
('Jonathan Audu', 1689325406, 'backend', '2023-07-14 09:03:26'),
('Sunidhi Chauhan', 1689325424, 'backend', '2023-07-14 09:03:44'),
('Leon Albert', 1689336908, 'backend', '2023-07-14 12:15:08'),
('Raul Adrian', 1689457825, 'backend', '2023-07-15 21:50:25'),
('Wendy Uche', 1689518501, 'backend', '2023-07-16 14:41:41'),
('Tosin Akinbowa', 1689518533, 'backend', '2023-07-16 14:42:13');

-- --------------------------------------------------------

--
-- Table structure for table `cloud`
--

CREATE TABLE `cloud` (
  `studentname` varchar(50) NOT NULL,
  `regno.` int(20) NOT NULL,
  `coursename` varchar(100) NOT NULL,
  `datecreated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `devops`
--

CREATE TABLE `devops` (
  `studentname` varchar(50) NOT NULL,
  `regno.` int(20) NOT NULL,
  `coursename` varchar(100) NOT NULL,
  `datecreated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frontend`
--

CREATE TABLE `frontend` (
  `studentname` varchar(50) NOT NULL,
  `regno.` int(20) NOT NULL,
  `coursename` varchar(100) NOT NULL,
  `datecreated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `frontend`
--

INSERT INTO `frontend` (`studentname`, `regno.`, `coursename`, `datecreated`) VALUES
('Eden Mary', 1689325309, 'frontend', '2023-07-14 09:01:49');

-- --------------------------------------------------------

--
-- Table structure for table `fullstack`
--

CREATE TABLE `fullstack` (
  `studentname` varchar(50) NOT NULL,
  `regno.` int(20) NOT NULL,
  `coursename` varchar(100) NOT NULL,
  `datecreated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backend`
--
ALTER TABLE `backend`
  ADD UNIQUE KEY `regno.` (`regno.`);

--
-- Indexes for table `cloud`
--
ALTER TABLE `cloud`
  ADD UNIQUE KEY `regno.` (`regno.`);

--
-- Indexes for table `devops`
--
ALTER TABLE `devops`
  ADD UNIQUE KEY `regno.` (`regno.`);

--
-- Indexes for table `frontend`
--
ALTER TABLE `frontend`
  ADD UNIQUE KEY `regno.` (`regno.`);

--
-- Indexes for table `fullstack`
--
ALTER TABLE `fullstack`
  ADD UNIQUE KEY `regno.` (`regno.`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
