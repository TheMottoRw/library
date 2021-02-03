-- MySQL dump 10.13  Distrib 5.7.32, for Linux (x86_64)
--
-- Host: localhost    Database: library
-- ------------------------------------------------------
-- Server version	5.7.32

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FullName` varchar(100) DEFAULT NULL,
  `AdminEmail` varchar(120) DEFAULT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'Mire','mire@gmail.com','admin','827ccb0eea8a706c4c34a16891f84e7b','2021-01-02 07:38:18');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `StudentId` varchar(10) NOT NULL,
  `Full_Name` varchar(30) NOT NULL,
  `Department` varchar(10) NOT NULL,
  `EntryDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `LeavingDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance`
--

LOCK TABLES `attendance` WRITE;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
INSERT INTO `attendance` VALUES (1,'17rp01095','Tuyishimire Raban','IT','2020-11-16 09:18:45','2020-11-16 12:14:07'),(3,'16rp00001','BIRAHIYE Gilbert','ET','2020-11-16 12:06:42','2020-11-17 18:51:34'),(4,'17rp01010','Kamana Emille','RE','2020-11-16 12:08:47','2020-11-17 18:51:41'),(11,'17rp00992','Abe sharma','IT','2020-11-16 12:58:43','2020-11-17 18:51:15'),(12,'14RP01096','Kanakuze Domithille','IT','2020-11-18 09:47:35','2020-11-17 18:52:20'),(13,'12RP01010','KABANDA','ET','2020-11-18 10:01:51','2020-11-17 19:02:51'),(14,'16rp00111','ROGER KAMANA','IT','2020-11-18 11:02:00','2020-11-17 23:34:19'),(15,'17RP00012','NDAMAGE EMILLE','ET','2020-11-18 11:06:21','2020-11-17 19:54:35'),(16,'11RP01010','NGANYIRA LOUISE','ET','2020-11-18 11:46:49','2020-11-17 20:18:04'),(17,'13RP01000','ROGER MATAMA','RE','2020-11-18 12:03:47','2020-11-17 20:04:47'),(18,'17rp01010','KABERUKA Mathiew','ET','2020-11-25 04:21:19',NULL),(19,'17rp00992','Abe sharma','IT','2020-12-01 13:36:32','2020-12-04 01:24:52'),(20,'17rp00001','Twiyeye Aime','RE','2020-11-30 21:19:19','2020-12-04 01:25:08'),(21,'17rp00992','Abe Sharma','IT','2020-12-04 17:24:25','2020-12-04 01:24:40');
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Dep_Name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,'ICT'),(3,'ET'),(4,'RE');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblauthors`
--

DROP TABLE IF EXISTS `tblauthors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblauthors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `AuthorName` varchar(159) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblauthors`
--

LOCK TABLES `tblauthors` WRITE;
/*!40000 ALTER TABLE `tblauthors` DISABLE KEYS */;
INSERT INTO `tblauthors` VALUES (11,'Smith','2020-11-16 10:27:34',NULL),(12,'Winny','2020-11-16 11:03:48',NULL),(14,'Kamana Emmy harris','2020-12-07 07:30:18','2021-01-02 07:40:56');
/*!40000 ALTER TABLE `tblauthors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblbooks`
--

DROP TABLE IF EXISTS `tblbooks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblbooks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `BookName` varchar(255) DEFAULT NULL,
  `CatId` int(11) DEFAULT NULL,
  `AuthorId` int(11) DEFAULT NULL,
  `ISBNNumber` int(11) DEFAULT NULL,
  `BookPrice` int(11) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'available',
  `RegDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblbooks`
--

LOCK TABLES `tblbooks` WRITE;
/*!40000 ALTER TABLE `tblbooks` DISABLE KEYS */;
INSERT INTO `tblbooks` VALUES (1,'PHP And MySql programming',5,1,222333,20,'available','2017-07-08 18:04:55','2017-07-15 03:54:41'),(5,'Linux Fundamental',8,11,1111,20000,'available','2020-11-16 10:28:29',NULL),(6,'Microsoft Excel',10,12,2222,12000,'available','2020-11-16 11:04:57',NULL),(18,'Mathematics Fundamental',11,11,1122,3000,'available','2020-12-04 21:09:12',NULL),(19,'Fundamental mathematics',12,14,3333,16000,'missing','2020-12-07 07:32:09','2021-02-03 21:07:11');
/*!40000 ALTER TABLE `tblbooks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblcategory`
--

DROP TABLE IF EXISTS `tblcategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(150) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblcategory`
--

LOCK TABLES `tblcategory` WRITE;
/*!40000 ALTER TABLE `tblcategory` DISABLE KEYS */;
INSERT INTO `tblcategory` VALUES (8,'OS',1,'2020-11-16 10:27:17','2021-02-02 18:39:29'),(9,'Programming Language',1,'2020-11-16 11:03:17','2021-02-02 18:39:29'),(10,'Offices',1,'2020-11-16 11:03:38','2021-02-02 18:39:29'),(11,'Science',1,'2020-12-04 15:10:52','2021-02-02 18:39:29'),(12,'Mathematics',1,'2020-12-07 07:29:48','2021-02-02 18:39:29');
/*!40000 ALTER TABLE `tblcategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblissuedbookdetails`
--

DROP TABLE IF EXISTS `tblissuedbookdetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblissuedbookdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `BookId` int(11) DEFAULT NULL,
  `StudentID` varchar(150) DEFAULT NULL,
  `IssuesDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ReturnDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `RetrunStatus` int(11) DEFAULT '0',
  `fine` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblissuedbookdetails`
--

LOCK TABLES `tblissuedbookdetails` WRITE;
/*!40000 ALTER TABLE `tblissuedbookdetails` DISABLE KEYS */;
INSERT INTO `tblissuedbookdetails` VALUES (17,6,'17RP01095','2020-12-04 21:56:05','2021-01-07 22:29:22',1,NULL),(18,6,'17RP01095','2020-12-04 22:01:17','2020-12-07 07:33:09',1,0),(20,NULL,'17RP01095','2020-12-05 04:59:44','2021-01-07 06:56:54',0,NULL),(21,NULL,'17RP01095','2020-12-05 05:00:25','2021-01-07 06:56:54',0,NULL),(22,NULL,'17RP01095','2020-12-05 05:00:58','2021-01-07 06:56:54',0,NULL),(23,5,'17RP01095','2020-12-05 05:04:17','2021-02-03 20:02:23',1,5700),(24,19,'17RP01095','2020-12-07 07:34:39','2021-02-03 21:07:11',2,16000),(25,6,'17RP01001','2021-01-07 22:18:23','2021-01-07 22:29:22',1,NULL);
/*!40000 ALTER TABLE `tblissuedbookdetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblreservedbooks`
--

DROP TABLE IF EXISTS `tblreservedbooks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblreservedbooks` (
  `id` int(11) NOT NULL,
  `BookName` varchar(255) NOT NULL,
  `CatId` int(11) NOT NULL,
  `AuthorId` int(11) NOT NULL,
  `ISBNNumber` int(11) NOT NULL,
  `BookPrice` int(11) NOT NULL,
  `RegDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UpdationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblreservedbooks`
--

LOCK TABLES `tblreservedbooks` WRITE;
/*!40000 ALTER TABLE `tblreservedbooks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblreservedbooks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblstudents`
--

DROP TABLE IF EXISTS `tblstudents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblstudents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `StudentId` varchar(100) DEFAULT NULL,
  `FullName` varchar(120) DEFAULT NULL,
  `EmailId` varchar(120) DEFAULT NULL,
  `MobileNumber` char(11) DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `Department` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `StudentId` (`StudentId`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblstudents`
--

LOCK TABLES `tblstudents` WRITE;
/*!40000 ALTER TABLE `tblstudents` DISABLE KEYS */;
INSERT INTO `tblstudents` VALUES (26,'17RP00001','Abe Sharma','abe@gmail.com','0787105337','827ccb0eea8a706c4c34a16891f84e7b',1,'2020-11-16 13:46:06','2021-01-02 07:40:05','RE\r\n'),(29,'17rp00006','Rabama','rabama@yahoo.fr','0789999999','827ccb0eea8a706c4c34a16891f84e7b',1,'2020-11-16 14:22:53','2021-01-02 07:40:05','IT'),(32,'17rp00002','Student Test','Student@gmail.com','0788888888','827ccb0eea8a706c4c34a16891f84e7b',1,'2020-11-18 09:44:27','2021-01-07 06:43:16','ET'),(33,'17rp01095','TUYISHIMIRE Raban','mireraban@gmail.com','0787252201','827ccb0eea8a706c4c34a16891f84e7b',1,'2020-12-01 14:29:53','2021-01-02 07:40:05','IT'),(34,'17RP01081','RWAREMA FULGENCE','MIRERABAN@GMAIL.COM','0788888888','827ccb0eea8a706c4c34a16891f84e7b',1,'2020-12-04 15:16:32','2021-01-02 07:40:05','IT'),(35,'16RP00111','TUYIZERE PATRICE','MIRERABAN@GMAIL.COM','0788888888','827ccb0eea8a706c4c34a16891f84e7b',1,'2020-12-04 15:19:01','2021-01-02 07:40:05','ET'),(37,'17RP01044','KAMANZI REGIS','KAMANZI@GMAIL.COM','0737777777','827ccb0eea8a706c4c34a16891f84e7b',1,'2020-12-04 21:02:43','2021-01-02 07:40:05','ET'),(38,'17RP01001','Manzi','manzi@gmail.com','0726183050','202cb962ac59075b964b07152d234b70',1,'2021-01-07 22:17:22','2021-02-03 18:55:28','ICT');
/*!40000 ALTER TABLE `tblstudents` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-02-04  0:39:09
