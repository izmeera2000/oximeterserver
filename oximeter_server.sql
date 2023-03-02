-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 02, 2023 at 10:25 AM
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
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `sensordata`
--

INSERT INTO `sensordata` (`id`, `sensor`, `bpm`, `o2`, `reading_time`) VALUES
(58, 'test1', '85', '99', '2023-02-25 18:52:13'),
(57, 'test1', '89', '100', '2023-02-25 18:52:05'),
(56, 'test1', '88', '99', '2023-02-25 18:51:13'),
(54, 'test1', '88', '99', '2023-02-25 18:50:26'),
(55, 'test1', '88', '99', '2023-02-25 18:50:32');

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
  `email` text,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `inserttime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `accesslevel`, `username`, `sensor`, `name`, `email`, `password`, `inserttime`) VALUES
(15, 1, 'asdasd', '', 'asdasd', NULL, 'a8f5f167f44f4964e6c998dee827110c', '2023-02-26 04:50:26'),
(17, 0, 'gaga', 'gagagaga', 'gaga', NULL, '811584043b844704c9bb9a6e99dd05d3', '2023-02-26 04:50:26'),
(18, 1, 'fafa', 'test1', 'fafa', NULL, '05d251ea28c5be9426611a121db0c92a', '2023-02-26 05:50:26'),
(22, 0, 'dsa', NULL, 'dsa', 'dsa', '5f039b4ef0058a1d652f13d612375a5b', '2023-03-02 08:50:26'),
(21, 1, 'izmeera2000', 'test2', 'Izmeer Aiman', 'izmeera2000@gmail.com', '476383da2ea21cb3b17a34f3336295ef', '2023-02-28 13:14:01');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
