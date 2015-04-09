-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2015 at 11:12 AM
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
-- Table structure for table `order_purchase`
--

CREATE TABLE IF NOT EXISTS `order_purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchaseid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `order_purchase`
--

INSERT INTO `order_purchase` (`id`, `purchaseid`, `productid`, `quantity`, `price`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 2, 2990000, 1, NULL, '2015-04-09 04:12:08', NULL),
(2, 1, 1, 4, 2000000, 1, NULL, '2015-04-09 04:12:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_purchase_header`
--

CREATE TABLE IF NOT EXISTS `order_purchase_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transactiondate` date NOT NULL,
  `customer` varchar(255) NOT NULL,
  `is_sales_order` tinyint(4) NOT NULL,
  `dp` double NOT NULL,
  `discount` double NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `order_purchase_header`
--

INSERT INTO `order_purchase_header` (`id`, `transactiondate`, `customer`, `is_sales_order`, `dp`, `discount`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '2015-04-09', 'Kenrick', 1, 1000000, 50000, 1, NULL, '2015-04-09 04:12:08', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `order_supply`
--

INSERT INTO `order_supply` (`id`, `orderid`, `productid`, `price`, `quantity`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 1, 199.99, 10, '2015-04-09 04:09:27', NULL, 1, NULL),
(2, 1, 2, 99.99, 20, '2015-04-09 04:09:27', NULL, 1, NULL),
(3, 1, 3, 355, 25, '2015-04-09 04:09:27', NULL, 1, NULL),
(4, 2, 3, 200, 6, '2015-04-09 04:10:36', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_supply_header`
--

CREATE TABLE IF NOT EXISTS `order_supply_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier` varchar(255) NOT NULL,
  `currency` varchar(50) NOT NULL,
  `transactiondate` date NOT NULL,
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
(1, 'RTO', 'USD', '2015-04-09', 'JNE', '2015-04-09 04:09:27', NULL, 1, NULL),
(2, 'RTA', 'USD', '2015-04-09', 'JNE', '2015-04-09 04:10:36', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` int(11) NOT NULL,
  `paymentdate` date NOT NULL,
  `paid` double NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `orderid`, `paymentdate`, `paid`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, '2015-04-09', 5000, 1, NULL, '2015-04-09 04:09:50', NULL),
(2, 2, '2015-04-09', 1200, 1, NULL, '2015-04-09 04:10:47', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `productname`, `quantity`, `price`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Playstation', 6, 2000000, '2015-04-09 04:09:27', NULL, 1, NULL),
(2, 'Kinect For XBox 360', 20, 0, '2015-04-09 04:09:27', NULL, 1, NULL),
(3, 'PS Vita', 29, 2990000, '2015-04-09 04:09:27', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sending`
--

CREATE TABLE IF NOT EXISTS `sending` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sendingid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sending`
--

INSERT INTO `sending` (`id`, `sendingid`, `productid`, `quantity`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 1, NULL, '2015-04-09 06:59:45', NULL),
(2, 2, 1, 1, 1, NULL, '2015-04-09 07:23:08', NULL),
(3, 2, 3, 1, 1, NULL, '2015-04-09 07:23:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sending_header`
--

CREATE TABLE IF NOT EXISTS `sending_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchaseid` int(11) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `transactiondate` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sending_header`
--

INSERT INTO `sending_header` (`id`, `purchaseid`, `destination`, `address`, `transactiondate`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Kenrick', 'Jalan Kemanggisan Raya No 96', '2015-04-10', 1, NULL, '2015-04-09 06:58:08', NULL),
(2, 1, 'Kenrick', 'Jalan Kemanggisan Raya No 96', '2015-04-10', 1, NULL, '2015-04-09 07:22:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `session_storage`
--

CREATE TABLE IF NOT EXISTS `session_storage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payload` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payload` (`payload`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
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

INSERT INTO `user` (`id`, `firstname`, `lastname`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '2015-03-25 11:19:40');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
