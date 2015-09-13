-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 13, 2015 at 10:51 AM
-- Server version: 5.5.44-0+deb8u1
-- PHP Version: 5.6.13-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `esp8266t`
--
CREATE DATABASE IF NOT EXISTS `esp8266t` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `esp8266t`;

-- --------------------------------------------------------

--
-- Table structure for table `Addresses`
--

DROP TABLE IF EXISTS `Addresses`;
CREATE TABLE IF NOT EXISTS `Addresses` (
  `ipAddress` varchar(20) NOT NULL,
  `udpPort` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

DROP TABLE IF EXISTS `device`;
CREATE TABLE IF NOT EXISTS `device` (
  `ipaddress` varchar(20) NOT NULL,
  `port` int(11) NOT NULL,
  `time` bigint(20) NOT NULL,
  `setTemp` varchar(1) NOT NULL,
  `temp0` float NOT NULL,
  `temp1` float NOT NULL,
  `temp2` float NOT NULL,
  `temp3` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Addresses`
--
ALTER TABLE `Addresses`
 ADD UNIQUE KEY `ipAddress` (`ipAddress`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
