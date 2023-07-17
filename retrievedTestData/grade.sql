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
-- Database: `grade`
--

-- --------------------------------------------------------

--
-- Table structure for table `backend`
--

CREATE TABLE `backend` (
  `studentname` varchar(50) NOT NULL,
  `coursename` varchar(100) NOT NULL,
  `modulename` varchar(100) NOT NULL,
  `chaptername` varchar(100) NOT NULL,
  `exercisescore` int(3) DEFAULT NULL,
  `projectscore` int(3) DEFAULT NULL,
  `datecreated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `backend`
--

INSERT INTO `backend` (`studentname`, `coursename`, `modulename`, `chaptername`, `exercisescore`, `projectscore`, `datecreated`) VALUES
('Sam Jones', 'backend', 'Introduction To Backend Tools And PHP Fundamentals', 'PHP Introduction, Syntax And Basics', 25, 65, '2023-07-16 11:28:52'),
('Wendy Uche', 'backend', 'Introduction To Backend Tools And PHP Fundamentals', 'PHP Introduction, Syntax And Basics', 20, 60, '2023-07-16 14:40:23'),
('Leon Albert', 'backend', 'Introduction To Backend Tools And PHP Fundamentals', 'PHP Introduction, Syntax And Basics', 27, 61, '2023-07-16 15:03:10'),
('Sunidhi Chauhan', 'backend', 'Introduction To Backend Tools And PHP Fundamentals', 'PHP Introduction, Syntax And Basics', 26, 55, '2023-07-16 15:07:57'),
('Alex Nwokorie', 'backend', 'Introduction To Backend Tools And PHP Fundamentals', 'PHP Introduction, Syntax And Basics', 24, 67, '2023-07-16 15:49:43'),
('Jonathan Audu', 'backend', 'Introduction To Backend Tools And PHP Fundamentals', 'PHP Introduction, Syntax And Basics', 18, 55, '2023-07-16 18:15:26'),
('Raul Adrian', 'backend', 'Introduction To Backend Tools And PHP Fundamentals', 'PHP Introduction, Syntax And Basics', 15, 30, '2023-07-17 10:17:30');

-- --------------------------------------------------------

--
-- Table structure for table `cloud`
--

CREATE TABLE `cloud` (
  `studentname` varchar(50) NOT NULL,
  `coursename` varchar(100) NOT NULL,
  `modulename` varchar(100) NOT NULL,
  `chaptername` varchar(100) NOT NULL,
  `exercisescore` int(3) DEFAULT NULL,
  `projectscore` int(3) DEFAULT NULL,
  `datecreated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `devops`
--

CREATE TABLE `devops` (
  `studentname` varchar(50) NOT NULL,
  `coursename` varchar(100) NOT NULL,
  `modulename` varchar(100) NOT NULL,
  `chaptername` varchar(100) NOT NULL,
  `exercisescore` int(3) DEFAULT NULL,
  `projectscore` int(3) DEFAULT NULL,
  `datecreated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frontend`
--

CREATE TABLE `frontend` (
  `studentname` varchar(50) NOT NULL,
  `coursename` varchar(100) NOT NULL,
  `modulename` varchar(100) NOT NULL,
  `chaptername` varchar(100) NOT NULL,
  `exercisescore` int(3) DEFAULT NULL,
  `projectscore` int(3) DEFAULT NULL,
  `datecreated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fullstack`
--

CREATE TABLE `fullstack` (
  `studentname` varchar(50) NOT NULL,
  `coursename` varchar(100) NOT NULL,
  `modulename` varchar(100) NOT NULL,
  `chaptername` varchar(100) NOT NULL,
  `exercisescore` int(3) DEFAULT NULL,
  `projectscore` int(3) DEFAULT NULL,
  `datecreated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
