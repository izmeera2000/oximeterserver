-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 21, 2023 at 08:28 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

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
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `sensor` varchar(30) NOT NULL,
  `bpm` varchar(10) DEFAULT NULL,
  `o2` varchar(10) DEFAULT NULL,
  `reading_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `sensordata`
--

INSERT INTO `sensordata` (`id`, `sensor`, `bpm`, `o2`, `reading_time`) VALUES
(1, 'asdasd', '89', '99', '2023-01-06 10:05:57'),
(2, 'asdasd', '89', '100', '2023-01-06 10:48:37'),
(3, 'asdasd', '77', '100', '2023-01-07 11:19:28'),
(4, 'asdasd', '77', '100', '2023-01-07 11:19:33'),
(5, 'asdasd', '55', '99', '2023-01-07 12:32:51'),
(6, 'asdasd', '55', '99', '2023-01-07 12:32:54'),
(7, 'asdasd', '160', '99', '2023-01-07 13:10:47'),
(8, 'asdasd', '160', '99', '2023-01-07 13:12:13'),
(9, 'asdasd', '160', '99', '2023-01-07 13:12:26'),
(10, 'asdasd', '97', '99', '2023-01-07 14:40:08'),
(11, 'asdasd', '77', '95', '2023-01-07 14:41:13'),
(12, 'asdasd', '77', '89', '2023-01-07 14:41:09'),
(13, 'qweqwe', NULL, '12', '2023-02-15 14:20:07'),
(14, 'qweqwe', NULL, '12', '2023-02-15 14:20:10'),
(15, '', NULL, NULL, '2023-02-15 14:26:17'),
(16, '', NULL, NULL, '2023-02-15 14:26:20'),
(17, 'asdasdd', '99', '', '2023-02-16 07:14:02'),
(18, 'asdasdd', '99', '122', '2023-02-16 07:14:08'),
(19, 'asdasdd', '99', '122', '2023-02-16 07:15:19'),
(20, 'asdasdd', '99', '122', '2023-02-16 07:15:21'),
(21, 'asdasdd', '99', '122', '2023-02-16 07:15:45'),
(22, 'asdasdd', '99', '122', '2023-02-16 07:15:47'),
(23, 'asdasdd', '99', '122', '2023-02-16 07:16:11'),
(24, 'asdasdd', '99', '122', '2023-02-16 07:16:47'),
(25, 'asdasd', '99', '75', '2023-02-15 14:34:37'),
(28, 'asdasd', '89', '99', '2023-01-06 10:05:57'),
(27, 'asdasdd', '99', '122', '2023-02-19 16:20:03'),
(29, 'asdasd', '89', '100', '2023-01-06 10:48:37'),
(30, 'asdasd', '77', '100', '2023-01-07 11:19:28'),
(31, 'asdasd', '77', '100', '2023-01-07 11:19:33'),
(32, 'asdasd', '55', '99', '2023-01-07 12:32:51'),
(33, 'asdasd', '55', '99', '2023-01-07 12:32:54'),
(34, 'asdasd', '160', '99', '2023-01-07 13:10:47'),
(35, 'asdasd', '160', '99', '2023-01-07 13:12:13'),
(36, 'asdasd', '160', '99', '2023-01-07 13:12:26'),
(37, 'asdasd', '97', '99', '2023-01-07 14:40:08'),
(38, 'asdasd', '77', '95', '2023-01-07 14:41:13'),
(39, 'asdasd', '77', '89', '2023-01-07 14:41:09'),
(40, 'qweqwe', NULL, '12', '2023-02-15 14:20:07'),
(41, 'qweqwe', NULL, '12', '2023-02-15 14:20:10'),
(42, '', NULL, NULL, '2023-02-15 14:26:17'),
(43, '', NULL, NULL, '2023-02-15 14:26:20'),
(44, 'asdasdd', '99', '', '2023-02-16 07:14:02'),
(45, 'asdasdd', '99', '122', '2023-02-16 07:14:08'),
(46, 'asdasdd', '99', '122', '2023-02-16 07:15:19'),
(47, 'asdasdd', '99', '122', '2023-02-16 07:15:21'),
(48, 'asdasdd', '99', '122', '2023-02-16 07:15:45'),
(49, 'asdasdd', '99', '122', '2023-02-16 07:15:47'),
(50, 'asdasdd', '99', '122', '2023-02-16 07:16:11'),
(51, 'asdasdd', '99', '122', '2023-02-16 07:16:47'),
(52, 'asdasd', '99', '75', '2023-02-15 14:34:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `accesslevel` int NOT NULL DEFAULT '0',
  `username` varchar(100) NOT NULL,
  `sensor` varchar(100) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `accesslevel`, `username`, `sensor`, `name`, `password`) VALUES
(15, 1, 'asdasd', 'asdasdd', 'asdasd', 'a8f5f167f44f4964e6c998dee827110c'),
(17, 0, 'gaga', 'gagagaga', 'gaga', '811584043b844704c9bb9a6e99dd05d3'),
(18, 1, 'fafa', 'asdasd', 'fafa', '05d251ea28c5be9426611a121db0c92a');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
