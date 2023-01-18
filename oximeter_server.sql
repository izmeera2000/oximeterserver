-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 18, 2023 at 04:26 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oximeter_server`
--

-- --------------------------------------------------------

--
-- Table structure for table `sensordata`
--

DROP TABLE IF EXISTS `sensordata`;
CREATE TABLE IF NOT EXISTS `sensordata` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sensor` varchar(30) NOT NULL,
  `location` varchar(30) NOT NULL,
  `bpm` varchar(10) DEFAULT NULL,
  `o2` varchar(10) DEFAULT NULL,
  `reading_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sensordata`
--

INSERT INTO `sensordata` (`id`, `sensor`, `location`, `bpm`, `o2`, `reading_time`) VALUES
(1, 'asdasd', '12312312', '89', '99', '2023-01-06 10:05:57'),
(2, 'asdasd', '12312312', '89', '100', '2023-01-06 10:48:37'),
(3, 'asdasd', 'dasdasdsa', '77', '100', '2023-01-07 11:19:28'),
(4, 'asdasd', 'dasdasdsa', '77', '100', '2023-01-07 11:19:33'),
(5, 'asdasd', 'asdasd', '55', '99', '2023-01-07 12:32:51'),
(6, 'asdasd', 'asdasd', '55', '99', '2023-01-07 12:32:54'),
(7, 'asdasd', 'asdasda', '160', '99', '2023-01-07 13:10:47'),
(8, 'asdasd', 'asdasda', '160', '99', '2023-01-07 13:12:13'),
(9, 'asdasd', 'asdasda', '160', '99', '2023-01-07 13:12:26'),
(10, 'asdasd', 'asdasda', '97', '99', '2023-01-07 14:40:08'),
(11, 'asdasd', 'asdasd', '77', '95', '2023-01-07 14:41:13'),
(12, 'asdasd', 'asdasd', '77', '89', '2023-01-07 14:41:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `sensor` varchar(100) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `sensor`, `name`, `password`) VALUES
(15, 'asdasd', 'asdasd', 'asdasd', 'a8f5f167f44f4964e6c998dee827110c');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
