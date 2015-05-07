-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2015 at 10:16 AM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `order_purchase`
--

INSERT INTO `order_purchase` (`id`, `purchaseid`, `productid`, `quantity`, `price`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 6000000, 8, 9, '2015-05-07 03:12:52', NULL),
(2, 1, 6, 5, 800000, 8, 9, '2015-05-07 03:12:52', NULL),
(3, 2, 4, 2, 4000000, 9, NULL, '2015-05-07 03:15:53', NULL),
(4, 3, 1, 1, 5800000, 9, NULL, '2015-05-07 03:17:35', NULL),
(5, 4, 10, 3, 6800000, 9, NULL, '2015-05-07 03:27:36', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `order_purchase_header`
--

INSERT INTO `order_purchase_header` (`id`, `transactiondate`, `customer`, `is_sales_order`, `dp`, `discount`, `created_by`, `updated_by`, `created_at`, `updated_at`, `invoice`) VALUES
(1, '2015-05-07', 'Kenrick', 0, 4000000, 300000, 8, 9, '2015-05-07 03:12:52', '2015-05-06 21:45:54', 'PJ000001'),
(2, '2015-05-07', 'Sri Utami', 0, 0, 0, 9, NULL, '2015-05-07 03:15:53', NULL, 'PJ000002'),
(3, '2015-05-07', 'Kenrick', 0, 0, 0, 9, NULL, '2015-05-07 03:17:35', NULL, 'PJ000003'),
(4, '2015-05-07', 'Mestika', 1, 2000000, 0, 9, NULL, '2015-05-07 03:27:36', NULL, 'PJ000004');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `order_supply`
--

INSERT INTO `order_supply` (`id`, `orderid`, `productid`, `price`, `quantity`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 1, 499, 20, '2015-05-07 02:47:00', NULL, 1, NULL),
(2, 1, 2, 399, 40, '2015-05-07 02:47:00', NULL, 1, NULL),
(3, 1, 3, 245, 24, '2015-05-07 02:47:00', NULL, 1, NULL),
(4, 2, 4, 3800000, 20, '2015-05-07 02:51:51', NULL, 1, NULL),
(5, 2, 5, 2500000, 5, '2015-05-07 02:51:51', NULL, 1, NULL),
(6, 4, 6, 45, 10, '2015-05-07 02:54:35', NULL, 1, NULL),
(7, 5, 7, 66, 5, '2015-05-07 02:55:53', NULL, 1, NULL),
(8, 6, 8, 28, 6, '2015-05-07 02:57:55', NULL, 1, NULL),
(9, 6, 9, 38, 10, '2015-05-07 02:57:55', NULL, 1, NULL),
(10, 7, 6, 46, 10, '2015-05-07 02:59:07', NULL, 1, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `order_supply_header`
--

INSERT INTO `order_supply_header` (`id`, `invoice`, `supplier`, `currency`, `transactiondate`, `shipped_by`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'PB000001', 'GLOBAL PERSADA', 'USD', '2015-05-07', 'FED EX', '2015-05-07 02:47:00', NULL, 1, NULL),
(2, 'PB000002', 'Maxsoft', 'IDR', '2015-05-07', 'DHL', '2015-05-07 02:51:51', NULL, 1, NULL),
(4, 'PB000003', 'GLOBAL PERSADA', 'USD', '2015-05-05', 'FED EX', '2015-05-07 02:54:35', NULL, 1, NULL),
(5, 'PB000004', 'GLOBAL PERSADA', 'USD', '2015-05-07', 'FED EX', '2015-05-07 02:55:53', NULL, 1, NULL),
(6, 'PB000005', 'Maxsoft', 'USD', '2015-05-07', 'DHL', '2015-05-07 02:57:55', NULL, 1, NULL),
(7, 'PB000006', 'GLOBAL PERSADA', 'USD', '2015-05-07', 'FED EX', '2015-05-07 02:59:07', NULL, 1, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `orderid`, `paymentdate`, `paid`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 2, '2015-07-05', 20000000, 1, NULL, '2015-05-07 03:04:59', NULL),
(2, 5, '2015-07-05', 330, 1, NULL, '2015-05-07 03:06:58', NULL),
(3, 4, '2015-07-05', 450, 1, NULL, '2015-05-07 03:07:15', NULL),
(4, 7, '2015-07-05', 100, 1, NULL, '2015-05-07 03:07:34', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `payment_purchase`
--

INSERT INTO `payment_purchase` (`id`, `purchaseid`, `paymentdate`, `paymenttype`, `paid`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 2, '2015-05-07', 'Debit', 8000000, 9, NULL, '2015-05-07 03:25:10', NULL),
(4, 1, '2015-05-07', 'Cash', 4000000, 9, NULL, '2015-05-07 04:43:53', NULL);

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
  `code` varchar(255) DEFAULT NULL,
  `rop` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `productname`, `quantity`, `price`, `created_at`, `updated_at`, `created_by`, `updated_by`, `code`, `rop`) VALUES
(1, 'Sony Playstation 4', 17, 6000000, '2015-05-07 02:47:00', NULL, 1, NULL, 'KB000001', 5),
(2, 'Sony Playstation 3', 40, 0, '2015-05-07 02:47:00', NULL, 1, NULL, NULL, 5),
(3, 'Sony PS Vita', 24, 0, '2015-05-07 02:47:00', NULL, 1, NULL, 'KB000003', 5),
(4, 'Nintendo 3DS XL', 18, 0, '2015-05-07 02:51:51', NULL, 1, NULL, NULL, 10),
(5, 'Black Wii U Deluxe w/Nintendo Land Bundle', 5, 0, '2015-05-07 02:51:51', NULL, 1, NULL, NULL, 7),
(6, 'Dualshock 4 Wireless Controller', 15, 800000, '2015-05-07 02:54:35', NULL, 1, NULL, 'KB000002', 5),
(7, 'Playstation Camera', 5, 0, '2015-05-07 02:55:53', NULL, 1, NULL, NULL, 8),
(8, 'Wii Remote Plus/Wii Nunchuk - Refurbished (Wii U, Wii mini, Wii)', 6, 0, '2015-05-07 02:57:55', NULL, 1, NULL, NULL, 5),
(9, 'New Super Mario Bros U./New Super Luigi U - Refurbished (Wii U)', 10, 0, '2015-05-07 02:57:55', NULL, 1, NULL, NULL, 5),
(10, 'Sony Playstation 5', -3, 0, '2015-05-07 03:27:36', NULL, 9, NULL, NULL, 0);

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
(3, 3, 1, 2, 9, NULL, '2015-05-07 04:45:14', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sending_header`
--

INSERT INTO `sending_header` (`id`, `invoice`, `purchaseid`, `destination`, `address`, `transactiondate`, `tracking_number`, `ongkos_kirim`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(3, 'SJ00001', 1, 'Kenrick', 'Jl Pejogolan No 34', '2015-05-07', 'PJDA0013454', 150000, 9, NULL, '2015-05-07 04:45:14', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

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
(14, '$2y$10$Ygq8vNDRM8Cv5A9ZVw7EPOFvBM52Jxog9oCcmQaGMXnLjkpMnREae', 1, '2015-05-05 07:55:11'),
(15, '$2y$10$2Npn3i96ONsApkrMqBa4Beggrr8wHFuQv07ZNSSbnNc3qFULJ5ZIK', 1, '2015-05-05 07:56:13'),
(16, '$2y$10$5Ad8QgeZq6CYSVP5WPlw5Oe5m/qYuog3M5Bk18Tzl7jtIjMBciLAW', 1, '2015-05-05 07:56:38'),
(17, '$2y$10$C4Maiast4k8QV5yl9IKLTO.Ed4BlcW8IXbpFGfXvuiJrHDPGT3Jjy', 2, '2015-05-05 07:56:47'),
(18, '$2y$10$O/lOo3COoG7TFdFrtzUMe.1bSs8m9qaMcqhURdUv.pJtjtzD2HXxq', 1, '2015-05-06 00:36:55'),
(19, '$2y$10$U27x2GVIJU931H8hebDmOuJWr2Rsaj01MdCTXWAojAyaZS5vV1yCW', 2, '2015-05-06 00:48:15'),
(20, '$2y$10$Bzvv8OXSmoCb1VM5GpAt5OolMwSAoBb1YgGG84VuFf5vK3Mko1yZO', 1, '2015-05-06 00:51:12'),
(21, '$2y$10$wy7xItJvDF3siLe0l/jxbego/Pc3p5AeBx81o7a1LXHdvoaOpR0nu', 1, '2015-05-06 01:12:07'),
(22, '$2y$10$q6xpwo63P6tYMHyl0.dAp.sxVeOyI875GdptuXMdZb4dfAhhItRdO', 2, '2015-05-06 02:08:18'),
(23, '$2y$10$xhabdt56XdMDaI8Qz.URqeUjOYVlZrQfzlyWiAX9t2oiJ6HCGRfCq', 1, '2015-05-06 02:14:52'),
(24, '$2y$10$RLjS3sxXiYvFAivSZ0vpLeMvsAcGw0i8kv.m9SpsUV08De/ZUfqpq', 2, '2015-05-06 07:36:29'),
(25, '$2y$10$3t80UGLVPkovcVLk8r2mGeOz9Og0iGeyfGw4FxCUD2hMBz79aeHpm', 1, '2015-05-06 07:36:36'),
(26, '$2y$10$sBX1NvEqyvicTUGlvUU0lOPBDTBkQl7f0tb4vaoC7AcDp5RIrQs6W', 1, '2015-05-06 07:37:30'),
(27, '$2y$10$NRqP0tsvzgFEpYBLb9VIEOsNaVK48v.32GCd6Ja8K5FxJx.K9hITy', 2, '2015-05-06 07:38:00'),
(28, '$2y$10$3FCnHN7pk/c/DOKJUXWoau4W9mcuFIhkoTD6oloC1KfY0tgUZ1uOK', 1, '2015-05-06 07:38:10'),
(29, '$2y$10$zImH1c8E8NOnyyYR725Ot.CZKfFj5T.zmj9dEicmj3B6AKKHZIenW', 1, '2015-05-07 01:17:28'),
(30, '$2y$10$znMzs6rCq2BNI.U.klsGeO2QOsk95M8iIYHQnwY7WHY2jQxQnzyIe', 1, '2015-05-07 02:26:57'),
(31, '$2y$10$8tG6ZdoKNbPvgfKV98XBrewZ0bsoMdSYVWHY6nui1ha/W.USeDiqO', 2, '2015-05-07 02:27:07'),
(32, '$2y$10$PAZUvnBw9JriKa1Waz7BOe/41uBKDyk8SBigHOb900hJWu0rOCEje', 1, '2015-05-07 02:42:48'),
(33, '$2y$10$AYNtY2Nk9LqL59pltH/jEeFva.76zodHmtDc0r3S9emY1Lq4.irb2', 1, '2015-05-07 03:03:25'),
(34, '$2y$10$QJUj8i.zXxWqL7I0iU7YVeMpATzcMIxZS4fjwAoiejIes5kl0yuQO', 8, '2015-05-07 03:03:50'),
(35, '$2y$10$uaWGE5BxtihjRyRypEYnhuQ.F030HhoHLKdrKdr2hw3uF/Ls/0G1a', 1, '2015-05-07 03:04:04'),
(36, '$2y$10$lZy.RPhiAWAov6AdC8vWluJTiM2xEzjiYI5JSfiWbBu2QXAgPGnpy', 8, '2015-05-07 03:08:19'),
(37, '$2y$10$kP0rR49EjQgVbVAkni9BxufbNefhg/..Ufsu1WaNDnrGTVbEGlzum', 1, '2015-05-07 03:09:41'),
(38, '$2y$10$K6jWo.sJRn77JeDGxOd5oefoo0lnLmnh42urmBSxLYaBQpmKJQeOm', 8, '2015-05-07 03:09:55'),
(39, '$2y$10$nxdiJeuakRiIhlJTPhI0Su6hxm4KG4G1UW5xRoZIcARfSQ7gDrmBG', 1, '2015-05-07 03:11:47'),
(40, '$2y$10$N30LCO2kmImz3FaFBGWcb.zXj7d8rdROMOd.LQSdwT64ZdMYjgUR2', 9, '2015-05-07 03:15:10'),
(41, '$2y$10$7qcsLGD9Gb4evMPwHHeVs.G7MIMqj9vLN6z5xwc/m.2YvUH.SqZ86', 1, '2015-05-07 07:21:00'),
(42, '$2y$10$u0Q3EHf51VKFYh/6lCTpEOpLm.UIE8zmxwlAh6amT4pQMPloCq7Zi', 1, '2015-05-07 08:04:49'),
(43, '$2y$10$X6Rsy6q/uHosIkc1vpjv5Or4AzVNBBq94DXb/I3Bmk68DWRtDPAqu', 8, '2015-05-07 08:05:53'),
(44, '$2y$10$//cPWiR07AtfPAJKsYH1pOLSYglHUPplojkYVk/i2UQ1a1kW7Dz1y', 8, '2015-05-07 08:06:14'),
(45, '$2y$10$pdEcUc.tmzMHBFm7ILa.r.tiADH/2pQtxlXSlD7zIPCGp8DHhjXmu', 1, '2015-05-07 08:06:24'),
(46, '$2y$10$e94xLYM7jvE8fqjxulNJ3.adpzgTsis9R0PjzvLldenUlGwx0rRT2', 8, '2015-05-07 08:06:35'),
(47, '$2y$10$N.SV7RCHZwmIlgcZkjRT6OH7wpDizut.ZkBFgNKPwKC7auOOGUPuG', 1, '2015-05-07 08:08:24'),
(48, '$2y$10$OZ5.JHrBu796wL96tkSXFO/8MTPUlQe/bvMKkFDb.VAksiWtSgj.e', 1, '2015-05-07 08:08:25');

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
  `active` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `username`, `password`, `role`, `created_at`, `active`) VALUES
(1, 'admin', 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '2015-03-25 11:19:40', 1),
(2, 'sales', 'sales', 'sales', '9ed083b1436e5f40ef984b28255eef18', 'sales', '2015-04-30 23:57:52', 1),
(8, 'Budi', 'Irwansyah', 'budi', '9c5fa085ce256c7c598f6710584ab25d', 'sales', '2015-05-07 03:03:43', 1),
(9, 'Cantika', 'Permata Sari', 'cantika', '5f52a10f22935c00f60666c7dd4d7a68', 'sales', '2015-05-07 03:04:22', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
