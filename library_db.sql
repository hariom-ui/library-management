-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 23, 2025 at 05:26 PM
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
-- Database: `library_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `quantity` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `category`, `quantity`) VALUES
(1, 'phy', 'hk', 'CSE', 30),
(2, 'Web Technologies', 'ak', 'CSE', 53);

-- --------------------------------------------------------

--
-- Table structure for table `book_requests`
--

DROP TABLE IF EXISTS `book_requests`;
CREATE TABLE IF NOT EXISTS `book_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int DEFAULT NULL,
  `book_id` int DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `request_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_returned` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `book_id` (`book_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `book_requests`
--

INSERT INTO `book_requests` (`id`, `student_id`, `book_id`, `status`, `request_date`, `is_returned`) VALUES
(1, 2, 1, 'approved', '2025-04-22 11:31:33', 1),
(2, 2, 1, 'approved', '2025-04-22 11:48:54', 1),
(3, 2, 1, 'approved', '2025-04-22 11:54:32', 1),
(4, 2, 1, 'rejected', '2025-04-22 11:57:46', 0),
(5, 2, 2, 'approved', '2025-04-22 15:01:22', 1),
(6, 2, 1, 'approved', '2025-04-22 15:17:49', 1),
(7, 2, 2, 'approved', '2025-04-22 15:17:57', 1),
(8, 2, 1, 'approved', '2025-04-22 15:22:21', 1),
(9, 2, 2, 'approved', '2025-04-22 15:24:26', 1),
(10, 2, 1, 'approved', '2025-04-22 15:48:56', 1),
(11, 2, 1, 'approved', '2025-04-23 16:13:03', 1),
(12, 2, 2, 'approved', '2025-04-23 16:24:37', 1),
(13, 2, 1, 'approved', '2025-04-23 16:48:17', 1),
(14, 2, 2, 'approved', '2025-04-23 16:48:20', 1),
(15, 2, 1, 'approved', '2025-04-23 16:50:49', 1),
(16, 2, 2, 'approved', '2025-04-23 16:50:53', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','student') DEFAULT 'student',
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `password`, `role`, `name`, `email`) VALUES
(1, 'hari1234', 'student', 'Hariom', 'hari007@gmail.com'),
(2, 'hari0123', 'student', 'hk', 'hk777@gmail.com'),
(3, 'hari1234', 'student', 'utk', 'utk@gmail.com');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
