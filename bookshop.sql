-- MySQL dump 10.13  Distrib 5.6.31, for osx10.8 (x86_64)
--
-- Host: localhost    Database: rexx
-- ------------------------------------------------------
-- Server version	5.6.31

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
-- Table structure for table `bookshop`
--

DROP TABLE IF EXISTS `bookshop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookshop` (
  `sale_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `customer_mail` varchar(100) NOT NULL,
  `product_id` mediumint(8) unsigned NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_price` varchar(100) NOT NULL,
  `sale_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`sale_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookshop`
--

LOCK TABLES `bookshop` WRITE;
/*!40000 ALTER TABLE `bookshop` DISABLE KEYS */;
INSERT INTO `bookshop` VALUES (1,'Reto Fanzen','reto.fanzen@no-reply.rexx-systems.com',1,'Refactoring: Improving the Design of Existing Code','49.99','2019-04-02 06:05:12'),(2,'Reto Fanzen','reto.fanzen@no-reply.rexx-systems.com',2,'Clean Architecture: A Craftsman\'s Guide to Software Structure and Design','24.99','2019-05-01 09:07:18'),(3,'Leandro BuÃŸmann','leandro.bussmann@no-reply.rexx-systems.com',2,'Clean Architecture: A Craftsman\'s Guide to Software Structure and Design','19.99','2019-05-06 12:26:14'),(4,'Hans SchÃ¤fer','hans.schaefer@no-reply.rexx-systems.com',1,'Refactoring: Improving the Design of Existing Code','37.98','2019-06-07 09:38:39'),(5,'Mia Wyss','mia.wyss@no-reply.rexx-systems.com',1,'Refactoring: Improving the Design of Existing Code','37.98','2019-07-01 13:01:13'),(6,'Mia Wyss','mia.wyss@no-reply.rexx-systems.com',2,'Clean Architecture: A Craftsman\'s Guide to Software Structure and Design','19.99','2019-08-07 17:08:56');
/*!40000 ALTER TABLE `bookshop` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-07-14 16:01:09
