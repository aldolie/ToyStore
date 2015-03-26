-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2015 at 09:02 AM
-- Server version: 5.6.11
-- PHP Version: 5.5.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ts`
--
CREATE DATABASE IF NOT EXISTS `ts` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ts`;

-- --------------------------------------------------------

--
-- Table structure for table `order_supply`
--

CREATE TABLE IF NOT EXISTS `order_supply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `order_supply`
--

INSERT INTO `order_supply` (`id`, `orderid`, `productid`, `price`, `quantity`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 1, 199.99, 20, '2015-03-26 07:46:48', NULL, 1, NULL),
(2, 2, 19, 99.99, 5, '2015-03-26 07:47:41', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_supply_header`
--

CREATE TABLE IF NOT EXISTS `order_supply_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier` varchar(255) NOT NULL,
  `currency` varchar(50) NOT NULL,
  `transactiondate` int(11) NOT NULL,
  `shipped_by` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `order_supply_header`
--

INSERT INTO `order_supply_header` (`id`, `supplier`, `currency`, `transactiondate`, `shipped_by`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'RTO', 'USD', 3, 'JNE', '2015-03-26 07:46:48', NULL, 1, NULL),
(2, 'RTO', 'USD', 3, 'JNE', '2015-03-26 07:47:41', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productname` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `productname`, `quantity`, `price`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Playstation', 20, 2000000, '2015-03-25 11:17:20', NULL, 1, NULL),
(2, 'PS Vita', 0, 1000000, '2015-03-25 11:20:29', NULL, 1, NULL),
(3, 'Nintendo 3DS', 0, 2000000, '2015-03-25 11:21:20', NULL, 1, NULL),
(4, 'XBOX 360', 0, 3600000, '2015-03-25 11:21:40', NULL, 1, NULL),
(5, 'Nintendo New 3DS', 0, 3400000, '2015-03-25 11:22:06', NULL, 1, NULL),
(19, 'Kinect XBOX360', 5, 0, '2015-03-26 07:47:41', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin', '098f6bcd4621d373cade4e832627b4f6', 'admin', '2015-03-25 11:19:40');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
