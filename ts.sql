-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2015 at 12:49 AM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ts`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `order_purchase`
--

INSERT INTO `order_purchase` (`id`, `purchaseid`, `productid`, `quantity`, `price`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 2, 1000000, 1, NULL, '2015-04-16 05:01:31', NULL);

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
  `invoice` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice` (`invoice`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `order_purchase_header`
--

INSERT INTO `order_purchase_header` (`id`, `transactiondate`, `customer`, `is_sales_order`, `dp`, `discount`, `created_by`, `updated_by`, `created_at`, `updated_at`, `invoice`) VALUES
(1, '2015-04-16', 'Kenrick', 1, 0, 0, 1, NULL, '2015-04-16 05:01:31', NULL, 'PC2015/04/16/1');

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
(1, 1, 2, 99.99, 5, '2015-04-16 05:55:43', NULL, 1, NULL),
(2, 2, 1, 199.99, 10, '2015-04-16 07:41:27', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_supply_header`
--

CREATE TABLE IF NOT EXISTS `order_supply_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice` varchar(255) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `currency` varchar(50) NOT NULL,
  `transactiondate` date NOT NULL,
  `shipped_by` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice` (`invoice`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `order_supply_header`
--

INSERT INTO `order_supply_header` (`id`, `invoice`, `supplier`, `currency`, `transactiondate`, `shipped_by`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'PS2015/04/16/1', 'Kenrick', 'USD', '2015-04-16', 'JNE', '2015-04-16 05:55:43', NULL, 1, NULL),
(2, 'PS2015/04/16/2', 'Febrian', 'USD', '2015-04-16', 'JNE', '2015-04-16 07:41:27', NULL, 1, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payment_purchase`
--

CREATE TABLE IF NOT EXISTS `payment_purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchaseid` int(11) NOT NULL,
  `paymentdate` date NOT NULL,
  `paymenttype` varchar(255) NOT NULL,
  `paid` double NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
(1, 'Playstation', 15, 2000000, '2015-04-09 04:09:27', NULL, 1, NULL),
(2, 'Kinect For XBox 360', 27, 1000000, '2015-04-09 04:09:27', NULL, 1, NULL),
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sending`
--

INSERT INTO `sending` (`id`, `sendingid`, `productid`, `quantity`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, 1, NULL, '2015-04-16 06:20:25', NULL),
(2, 2, 2, 1, 1, NULL, '2015-04-16 07:31:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sending_header`
--

CREATE TABLE IF NOT EXISTS `sending_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice` varchar(255) NOT NULL,
  `purchaseid` int(11) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `transactiondate` date NOT NULL,
  `tracking_number` varchar(255) DEFAULT NULL,
  `ongkos_kirim` double DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice` (`invoice`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sending_header`
--

INSERT INTO `sending_header` (`id`, `invoice`, `purchaseid`, `destination`, `address`, `transactiondate`, `tracking_number`, `ongkos_kirim`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'SD2015/04/16/1', 1, 'Kenrick', 'Jl Gedong Panjang No 96', '2015-04-16', 'asdad', 12312, 1, NULL, '2015-04-16 06:20:25', NULL),
(2, 'SD2015/04/16/2', 1, 'Kenrick', 'Jalan Kemanggisan Raya No 26', '2015-04-16', NULL, NULL, 1, NULL, '2015-04-16 07:31:22', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `session_storage`
--

INSERT INTO `session_storage` (`id`, `payload`, `userid`, `created_at`) VALUES
(1, '$2y$10$kcGueA5KpJ.MEpPV4zZQheZVn2pDlOeqBx/FvU22xSR5wymAGiwHO', 1, '2015-04-15 02:31:12'),
(2, '$2y$10$a8gYQo4kJjuPloSvSgjZJOaWjESTp9sR6FbkYFtyDfrLLUAVDLxMe', 1, '2015-04-15 02:34:40'),
(3, '$2y$10$CSJUEspvVlpIgA4xglxzAuU81/99Eov25fNNTaPJ.XzZHKjfgILae', 1, '2015-04-15 02:34:47'),
(4, '$2y$10$K7A8Dw.4yyVO7OpKlsEH4eohkdvvoe8N3ogAadHKloeN68JgOO4CC', 1, '2015-04-16 01:11:24'),
(5, '$2y$10$yhP6jQP2vhxXw53/B58BeuK3bEcMlKNNmdNizb84pYHKwcql.yjXG', 1, '2015-04-16 01:40:20');

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
