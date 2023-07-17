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
-- Database: `module`
--

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE `chapters` (
  `coursename` varchar(100) NOT NULL,
  `modulename` varchar(100) NOT NULL,
  `chapterID` varchar(10) NOT NULL,
  `chaptername` varchar(100) NOT NULL,
  `datecreated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `chapters`
--

INSERT INTO `chapters` (`coursename`, `modulename`, `chapterID`, `chaptername`, `datecreated`) VALUES
('backend', 'Introduction To Backend Tools And PHP Fundamentals', 'PHP1.C1:', 'PHP Introduction, Syntax And Basics', '2023-07-14 13:23:25'),
('backend', 'Introduction To Backend Tools And PHP Fundamentals', 'PHP1.C2:', 'The Version Control System Git', '2023-07-14 13:28:55'),
('backend', 'Introduction To Backend Tools And PHP Fundamentals', 'PHP1.C3:', 'Developer Tools And Frontend Introduction', '2023-07-14 13:31:58'),
('backend', 'Introduction To Backend Tools And PHP Fundamentals', 'PHP1.C4:', 'Web UI, The Basics Of HTML, CSS And Javascript', '2023-07-14 13:33:14'),
('backend', 'Web Application And Database Basics', 'PHP2.C1:', 'About Teamwork And Some PHP Features', '2023-07-14 13:34:05'),
('backend', 'Web Application And Database Basics', 'PHP2.C2:', 'The Web Ecosystem And PHP', '2023-07-14 13:35:17'),
('backend', 'Web Application And Database Basics', 'PHP2.C3:', 'Introduction To Relational Database And SQL', '2023-07-14 13:36:01'),
('backend', 'Web Application And Database Basics', 'PHP2.C4:', 'Creating A CRUD Application', '2023-07-14 13:36:28'),
('backend', 'Object Oriented Programming', 'PHP3.C1:', 'Introduction To OOP', '2023-07-14 13:36:56'),
('backend', 'Object Oriented Programming', 'PHP3.C2:', 'Applying OOP Concepts Using PHP', '2023-07-14 13:39:56'),
('backend', 'Object Oriented Programming', 'PHP3.C3:', 'Handling Database With PDO', '2023-07-14 13:40:31'),
('backend', 'Object Oriented Programming', 'PHP3.C4:', 'Code Design And MVC Overview', '2023-07-14 13:41:04'),
('backend', 'REST API And Frameworks', 'PHP4.C1:', 'Composer, Standards', '2023-07-14 13:42:39'),
('backend', 'REST API And Frameworks', 'PHP4.C2:', 'More About PDO And Databases', '2023-07-14 13:43:29'),
('backend', 'REST API And Frameworks', 'PHP4.C3:', 'Introduction To Web Services And Unit Tests', '2023-07-14 13:43:57'),
('backend', 'REST API And Frameworks', 'PHP4.C4:', 'Creating API Using A Framework', '2023-07-14 13:44:22'),
('backend', 'Managing PHP Applications', 'PHP5.C1:', 'Docker, SPL And Web Security', '2023-07-14 13:44:59'),
('backend', 'Managing PHP Applications', 'PHP5.C2:', 'Object-relational Mapper, Patterns And Tests', '2023-07-14 13:53:30'),
('backend', 'Managing PHP Applications', 'PHP5.C3:', 'Errors, Exceptions And Debugging', '2023-07-14 13:49:01'),
('backend', 'Managing PHP Applications', 'PHP5.C4:', 'CI/CD, And Deploying A PHP Application', '2023-07-14 13:53:04'),
('backend', 'Introduction To Symphony Framework', 'PHP6.C1:', 'Symphony Introduction', '2023-07-14 13:54:55'),
('backend', 'Introduction To Symphony Framework', 'PHP6.C2:', 'Modules And REST APIs In Symphony', '2023-07-14 13:51:22'),
('backend', 'Introduction To Symphony Framework', 'PHP6.C3:', 'Creating An Application With Symphony', '2023-07-14 13:51:52'),
('backend', 'Introduction To Symphony Framework', 'PHP6.C4:', 'HR Support Section', '2023-07-14 13:52:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chapters`
--
ALTER TABLE `chapters`
  ADD UNIQUE KEY `chapterID` (`chapterID`),
  ADD UNIQUE KEY `chaptername` (`chaptername`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
