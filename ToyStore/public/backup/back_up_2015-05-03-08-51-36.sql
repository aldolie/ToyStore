-- MySQL dump 10.13  Distrib 5.6.14, for Win32 (x86)
--
-- Host: localhost    Database: ts
-- ------------------------------------------------------
-- Server version	5.6.14

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `order_purchase`
--

DROP TABLE IF EXISTS `order_purchase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_purchase` (
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_purchase`
--

LOCK TABLES `order_purchase` WRITE;
/*!40000 ALTER TABLE `order_purchase` DISABLE KEYS */;
INSERT INTO `order_purchase` VALUES (1,1,1,10,1000000,2,NULL,'2015-05-01 00:22:46',NULL),(2,2,3,2,1990000,2,NULL,'2015-05-01 09:09:47',NULL),(3,3,3,2,2990000,2,NULL,'2015-05-01 10:17:24',NULL);
/*!40000 ALTER TABLE `order_purchase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_purchase_header`
--

DROP TABLE IF EXISTS `order_purchase_header`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_purchase_header` (
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_purchase_header`
--

LOCK TABLES `order_purchase_header` WRITE;
/*!40000 ALTER TABLE `order_purchase_header` DISABLE KEYS */;
INSERT INTO `order_purchase_header` VALUES (1,'2015-01-05','Kenrick',1,0,0,2,NULL,'2015-05-01 00:22:46',NULL,'Testing'),(2,'2015-01-05','Kenrick',0,500000,100000,2,NULL,'2015-05-01 09:09:47',NULL,'PENJ0001'),(3,'2015-01-05','Kenrick',0,0,0,2,NULL,'2015-05-01 10:17:24',NULL,'PENJ0003');
/*!40000 ALTER TABLE `order_purchase_header` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_supply`
--

DROP TABLE IF EXISTS `order_supply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_supply` (
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_supply`
--

LOCK TABLES `order_supply` WRITE;
/*!40000 ALTER TABLE `order_supply` DISABLE KEYS */;
INSERT INTO `order_supply` VALUES (1,1,2,199.99,12,'2015-05-01 09:06:25',NULL,1,NULL),(2,1,3,199.99,20,'2015-05-01 09:06:25',NULL,1,NULL),(3,1,4,499,30,'2015-05-01 09:06:25',NULL,1,NULL);
/*!40000 ALTER TABLE `order_supply` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_supply_header`
--

DROP TABLE IF EXISTS `order_supply_header`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_supply_header` (
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_supply_header`
--

LOCK TABLES `order_supply_header` WRITE;
/*!40000 ALTER TABLE `order_supply_header` DISABLE KEYS */;
INSERT INTO `order_supply_header` VALUES (1,'PEMB0001','Reindeer','USD','2015-05-01','JNE','2015-05-01 09:06:25',NULL,1,NULL);
/*!40000 ALTER TABLE `order_supply_header` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` int(11) NOT NULL,
  `paymentdate` date NOT NULL,
  `paid` double NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_purchase`
--

DROP TABLE IF EXISTS `payment_purchase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_purchase` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_purchase`
--

LOCK TABLES `payment_purchase` WRITE;
/*!40000 ALTER TABLE `payment_purchase` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_purchase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productname` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'Playstation 5',-10,1000000,'2015-05-01 00:22:46',NULL,2,NULL,'KD0001'),(2,'PS Vita',12,0,'2015-05-01 09:06:25',NULL,1,NULL,NULL),(3,'Kinect 2',16,0,'2015-05-01 09:06:25',NULL,1,NULL,NULL),(4,'Playstation 2',30,0,'2015-05-01 09:06:25',NULL,1,NULL,NULL);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sending`
--

DROP TABLE IF EXISTS `sending`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sending` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sendingid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sending`
--

LOCK TABLES `sending` WRITE;
/*!40000 ALTER TABLE `sending` DISABLE KEYS */;
INSERT INTO `sending` VALUES (1,1,3,2,2,NULL,'2015-05-01 09:12:31',NULL);
/*!40000 ALTER TABLE `sending` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sending_header`
--

DROP TABLE IF EXISTS `sending_header`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sending_header` (
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sending_header`
--

LOCK TABLES `sending_header` WRITE;
/*!40000 ALTER TABLE `sending_header` DISABLE KEYS */;
INSERT INTO `sending_header` VALUES (1,'SJ00001',2,'Kenrick','Jl Kemanggisan Raya No 96','2015-05-01','JEK0123SD',30000,2,NULL,'2015-05-01 09:12:31',NULL);
/*!40000 ALTER TABLE `sending_header` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session_storage`
--

DROP TABLE IF EXISTS `session_storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session_storage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payload` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payload` (`payload`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session_storage`
--

LOCK TABLES `session_storage` WRITE;
/*!40000 ALTER TABLE `session_storage` DISABLE KEYS */;
INSERT INTO `session_storage` VALUES (1,'$2y$10$YGhvXnMS0vUEdX3Sr.WQpukVOLyTYa/GR86XUM5m5omApOASq8PoW',2,'2015-04-30 23:57:56'),(2,'$2y$10$xSfPC6hY0Gv7McJMzCADGOV/Ypd44L.jIG5hFASHum0RhwBxCk6vO',1,'2015-05-01 09:03:58'),(3,'$2y$10$eKDiZS86EMCon9N7vfBYVe/zYvDqWIgVq20rS3HyjxdiVgjQEofyy',2,'2015-05-01 09:04:09'),(4,'$2y$10$JqUgCI4G5CMovTcr0s3h.uaQry9JLqlMlYx3KRCxKDS4bJc/BOpp.',1,'2015-05-01 09:04:21'),(5,'$2y$10$T656x.VJ0qI3uJ.GMi0noOWbWfqt6uft/qlFfX4Ptx56nAxPtFxQG',2,'2015-05-01 09:06:35'),(6,'$2y$10$V9ujs2Or0WW32UJQfZAHSuk9ji55uboxMkPUMm1vAnlDoO5E2jTDe',1,'2015-05-01 09:22:10'),(7,'$2y$10$GntA5K4sF16RtYXr8h2GMeUF3TMl1XK.B6rtyWFZhO1yRk.ZDrrMe',2,'2015-05-01 10:12:56'),(8,'$2y$10$19/XlEaiwHeCu.KRq3iDk.NJlyNzvWPzyhebx3JMby/QQk01jLDRK',1,'2015-05-03 08:21:46'),(9,'$2y$10$MBuxmjlvJcxcFAo6rZr3IuKyyGZ6WRDEkRIF/LxAWy63owHD/Mk26',1,'2015-05-03 08:45:52');
/*!40000 ALTER TABLE `session_storage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','admin','admin','21232f297a57a5a743894a0e4a801fc3','admin','2015-03-25 11:19:40'),(2,'sales','sales','sales','9ed083b1436e5f40ef984b28255eef18','sales','2015-04-30 23:57:52');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-03 15:51:36
