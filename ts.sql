-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2015 at 02:27 AM
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
-- Table structure for table `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `username`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Kenrick', 'Jl Kemanggisan Raya No 96', '2015-05-25 23:08:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `username` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`username`, `created_at`, `updated_at`) VALUES
('Kenrick', '2015-05-25 22:56:34', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `order_purchase`
--

INSERT INTO `order_purchase` (`id`, `purchaseid`, `productid`, `quantity`, `price`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 10, 1000000, 2, NULL, '2015-05-01 00:22:46', NULL),
(2, 2, 3, 3, 1990000, 2, 2, '2015-05-01 09:09:47', NULL),
(3, 3, 3, 2, 2990000, 2, NULL, '2015-05-01 10:17:24', NULL),
(5, 2, 1, 2, 2000000, 2, 2, '2015-05-05 21:54:50', NULL),
(6, 2, 6, 6, 400000, 2, 2, '2015-05-05 21:56:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_purchase_header`
--

CREATE TABLE IF NOT EXISTS `order_purchase_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transactiondate` date NOT NULL,
  `address` varchar(255) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `order_purchase_header`
--

INSERT INTO `order_purchase_header` (`id`, `transactiondate`, `address`, `customer`, `is_sales_order`, `dp`, `discount`, `created_by`, `updated_by`, `created_at`, `updated_at`, `invoice`) VALUES
(1, '2015-01-05', 'Jl Kemanggisan Raya No 96', 'Kenrick', 1, 0, 0, 2, NULL, '2015-05-01 00:22:46', NULL, 'Testing'),
(2, '2015-01-05', 'Jl Kemanggisan Raya No 96', 'Kenrick', 0, 500000, 100000, 2, 2, '2015-05-01 09:09:47', '2015-05-05 15:16:04', 'PENJ0001'),
(3, '2015-01-05', 'Jl Kemanggisan Raya No 96', 'Kenrick', 0, 0, 0, 2, NULL, '2015-05-01 10:17:24', NULL, 'PENJ0003');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `order_supply`
--

INSERT INTO `order_supply` (`id`, `orderid`, `productid`, `price`, `quantity`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 2, 199.99, 12, '2015-05-01 09:06:25', NULL, 1, NULL),
(2, 1, 3, 199.99, 20, '2015-05-01 09:06:25', NULL, 1, NULL),
(3, 1, 4, 499, 30, '2015-05-01 09:06:25', NULL, 1, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `order_supply_header`
--

INSERT INTO `order_supply_header` (`id`, `invoice`, `supplier`, `currency`, `transactiondate`, `shipped_by`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'PEMB0001', 'Reindeer', 'USD', '2015-05-01', 'JNE', '2015-05-01 09:06:25', NULL, 1, NULL);

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
  `rop` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `productname`, `quantity`, `price`, `rop`, `created_at`, `updated_at`, `created_by`, `updated_by`, `code`) VALUES
(1, 'Playstation 5', -12, 1000000, 0, '2015-05-01 00:22:46', NULL, 2, NULL, 'KD0001'),
(2, 'PS Vita', 12, 0, 0, '2015-05-01 09:06:25', NULL, 1, NULL, NULL),
(3, 'Kinect 2', 14, 1990000, 0, '2015-05-01 09:06:25', NULL, 1, NULL, NULL),
(4, 'Playstation 2', 30, 0, 0, '2015-05-01 09:06:25', NULL, 1, NULL, NULL),
(6, 'Charger PS Vita', -6, 400000, 0, '2015-05-05 21:56:14', NULL, 2, NULL, NULL);

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
(2, 2, 3, 1, 2, NULL, '2015-05-05 21:32:10', NULL);

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
(2, 'SJ0001', 2, 'Kenrick', 'Jl Kemanggisan No 96', '2015-05-05', 'AD2123', 40000, 2, NULL, '2015-05-05 21:32:10', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `session_storage`
--

INSERT INTO `session_storage` (`id`, `payload`, `userid`, `created_at`) VALUES
(1, '$2y$10$YGhvXnMS0vUEdX3Sr.WQpukVOLyTYa/GR86XUM5m5omApOASq8PoW', 2, '2015-04-30 23:57:56'),
(2, '$2y$10$xSfPC6hY0Gv7McJMzCADGOV/Ypd44L.jIG5hFASHum0RhwBxCk6vO', 1, '2015-05-01 09:03:58'),
(3, '$2y$10$eKDiZS86EMCon9N7vfBYVe/zYvDqWIgVq20rS3HyjxdiVgjQEofyy', 2, '2015-05-01 09:04:09'),
(4, '$2y$10$JqUgCI4G5CMovTcr0s3h.uaQry9JLqlMlYx3KRCxKDS4bJc/BOpp.', 1, '2015-05-01 09:04:21'),
(5, '$2y$10$T656x.VJ0qI3uJ.GMi0noOWbWfqt6uft/qlFfX4Ptx56nAxPtFxQG', 2, '2015-05-01 09:06:35'),
(6, '$2y$10$V9ujs2Or0WW32UJQfZAHSuk9ji55uboxMkPUMm1vAnlDoO5E2jTDe', 1, '2015-05-01 09:22:10'),
(7, '$2y$10$GntA5K4sF16RtYXr8h2GMeUF3TMl1XK.B6rtyWFZhO1yRk.ZDrrMe', 2, '2015-05-01 10:12:56'),
(8, '$2y$10$A3Djh2nJCCm9Jf3tqfauzeX.TXplFiL8vVsesQm5rylz2649.y.oS', 1, '2015-05-03 08:59:13'),
(9, '$2y$10$ePjowuX0rHIFY4FrK6xI4exqCRP/QdVJ3mrhKJlVH06vzwM.61n6y', 1, '2015-05-03 08:59:19'),
(10, '$2y$10$MWmQYtewbv1tgwta3ru4xO05j9Et2B/i20ftqcZHe44eMeW/iA9Fu', 1, '2015-05-03 09:21:50'),
(11, '$2y$10$2NDwbKKBYK4hBelRPjPFfOEuD10M8cbgdeIaCuXVPO1D00uTUZSOC', 1, '2015-05-03 09:22:40'),
(12, '$2y$10$XQKWCkXLFKayWZCO2zuJvOfRvbt90Gt4Q3wAooETNuUx9CtzYJGOe', 1, '2015-05-03 09:22:45'),
(13, '$2y$10$D3pO91dRC9GX3LCrjqBlMuf0GOSE0FdktaZTuhEjf1DaLTfTvqxZC', 1, '2015-05-03 09:24:30'),
(14, '$2y$10$4z/lBwU8vGN3/l6yuTsTMuWpIiID/cd/G/H3TfY03YovMc4ZJay4y', 1, '2015-05-03 09:25:29'),
(15, '$2y$10$0bXOPh3bDFCRdVWO3K39C.riURQgjerOOHFyE4PO7C.MwJaEm8hEi', 2, '2015-05-05 21:19:48'),
(16, '$2y$10$PTNKUliQF4f7rsoqVMJjteyoW4oVtya0JRT8VpmWkfa6yJPQ0Nh3K', 1, '2015-05-25 22:32:16'),
(17, '$2y$10$uSLd0deW1gQIBpdZUwfdd.D2LO5V/tlNkoq8oeCXMjgOvxsfrYgFG', 2, '2015-05-25 22:32:32'),
(18, '$2y$10$6bxD481vlq8CCvI5/BE8c.a.MvgRTRkb7PI5YFS4Hh0E7CGw3kI2S', 1, '2015-05-26 00:02:55');

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
  `active` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `username`, `password`, `role`, `active`, `created_at`) VALUES
(1, 'admin', 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 1, '2015-03-25 11:19:40'),
(2, 'sales', 'sales', 'sales', '9ed083b1436e5f40ef984b28255eef18', 'sales', 1, '2015-04-30 23:57:52');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
