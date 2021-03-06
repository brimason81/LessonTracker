-- MySQL dump 10.16  Distrib 10.1.31-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: students
-- ------------------------------------------------------
-- Server version	10.1.31-MariaDB

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
  `Admin_ID` int(11) NOT NULL,
  `First_Name` varchar(20) DEFAULT NULL,
  `Last_Name` varchar(40) DEFAULT NULL,
  `Password` varchar(100) NOT NULL,
  `Salt` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Admin_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lesson_update`
--

DROP TABLE IF EXISTS `lesson_update`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lesson_update` (
  `lesson_change_ID` int(11) NOT NULL AUTO_INCREMENT,
  `oldInst` varchar(200) DEFAULT NULL,
  `newInst` varchar(200) DEFAULT NULL,
  `Student_ID` int(11) unsigned DEFAULT NULL,
  `oldTeacher_ID` int(11) DEFAULT NULL,
  `newTeacher_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`lesson_change_ID`),
  KEY `Student_ID` (`Student_ID`),
  CONSTRAINT `lesson_update_ibfk_1` FOREIGN KEY (`Student_ID`) REFERENCES `studentinfo` (`Student_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lesson_update`
--

LOCK TABLES `lesson_update` WRITE;
/*!40000 ALTER TABLE `lesson_update` DISABLE KEYS */;
/*!40000 ALTER TABLE `lesson_update` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_archive`
--

DROP TABLE IF EXISTS `student_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_archive` (
  `Student_ID` int(11) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Student_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_archive`
--

LOCK TABLES `student_archive` WRITE;
/*!40000 ALTER TABLE `student_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_contact_update`
--

DROP TABLE IF EXISTS `student_contact_update`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_contact_update` (
  `contact_change_ID` int(11) NOT NULL AUTO_INCREMENT,
  `oldPhone` varchar(100) DEFAULT NULL,
  `newPhone` varchar(100) DEFAULT NULL,
  `oldEmail` varchar(100) DEFAULT NULL,
  `newEmail` varchar(100) DEFAULT NULL,
  `Student_ID` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`contact_change_ID`),
  KEY `Student_ID` (`Student_ID`),
  CONSTRAINT `student_contact_update_ibfk_1` FOREIGN KEY (`Student_ID`) REFERENCES `studentinfo` (`Student_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_contact_update`
--

LOCK TABLES `student_contact_update` WRITE;
/*!40000 ALTER TABLE `student_contact_update` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_contact_update` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_schedule_update`
--

DROP TABLE IF EXISTS `student_schedule_update`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_schedule_update` (
  `change_ID` int(11) NOT NULL AUTO_INCREMENT,
  `oldLessonTime` datetime DEFAULT NULL,
  `newLessonTime` datetime DEFAULT NULL,
  `oldLessonDay` varchar(50) DEFAULT NULL,
  `newLessonDay` varchar(50) DEFAULT NULL,
  `Student_ID` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`change_ID`),
  KEY `Student_ID` (`Student_ID`),
  CONSTRAINT `student_schedule_update_ibfk_1` FOREIGN KEY (`Student_ID`) REFERENCES `studentinfo` (`Student_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_schedule_update`
--

LOCK TABLES `student_schedule_update` WRITE;
/*!40000 ALTER TABLE `student_schedule_update` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_schedule_update` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `studentinfo`
--

DROP TABLE IF EXISTS `studentinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `studentinfo` (
  `Student_ID` int(40) unsigned NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(20) NOT NULL,
  `LastName` varchar(20) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `Notes` varchar(100) DEFAULT NULL,
  `DateStarted` date DEFAULT NULL,
  `LessonTime` datetime DEFAULT NULL,
  `LessonDay` varchar(10) NOT NULL,
  `Instrument` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `Teacher_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`Student_ID`),
  KEY `Teacher_ID` (`Teacher_ID`),
  CONSTRAINT `studentinfo_ibfk_1` FOREIGN KEY (`Teacher_ID`) REFERENCES `teachers` (`Teacher_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `studentinfo`
--

LOCK TABLES `studentinfo` WRITE;
/*!40000 ALTER TABLE `studentinfo` DISABLE KEYS */;
INSERT INTO `studentinfo` VALUES (25,'Tim','Weiner','919-428-1415','Surgeon','0000-00-00','0000-00-00 00:00:00','Wednesday','Guitar','',NULL),(27,'Sandy','Rutherford','555-555-5555','80+ yrs old\r\n\r\n','2020-12-08','0000-00-00 00:00:00','Wednesday','Drum Set','',NULL),(29,'Some','One','123-456-7890','','2020-02-17','0000-00-00 00:00:00','Monday','Guitar','',NULL),(30,'Some','OneElse','123-123-1234','','2020-02-18','0000-00-00 00:00:00','Monday','Bass','',NULL),(31,'woeijf','woeifj','weoifj','we','2020-12-17','0000-00-00 00:00:00','weofij','weoifj','',NULL),(32,'wepofk','weprofk','wepofk','','0000-00-00','0000-00-00 00:00:00','wepfok','wepofk','',NULL),(33,'wpreofk','erp','wrpofk','w','2020-02-25','0000-00-00 00:00:00','wepofk','wepfok','',NULL),(34,'New','Student','333-333-3333','','2020-12-17','0000-00-00 00:00:00','Monday','Ukelele','',NULL),(35,'','','','','2020-12-17','0000-00-00 00:00:00','Monday','Ukelele','',NULL),(36,'','','','','2020-12-17','0000-00-00 00:00:00','Tuesday','Drums','',NULL),(37,'Brian','Mason','9103521048','','2020-12-21','0000-00-00 00:00:00','Tuesday','Guitar','',NULL),(38,'Matt','Mason','9103521048','','2020-12-20','0000-00-00 00:00:00','Tuesday','Bass','',NULL),(39,'','','','','2020-12-22','0000-00-00 00:00:00','','','',NULL),(40,'','','','','2020-12-22','0000-00-00 00:00:00','','','',NULL),(41,'','','','','2020-12-22','0000-00-00 00:00:00','','','',NULL),(42,'','','','','2020-12-22','0000-00-00 00:00:00','','','',NULL),(43,'Brian','Mason','9103521048','','0000-00-00','0000-00-00 00:00:00','Monday','Drums','',NULL),(44,'Brian','Mason','9103521048','','0000-00-00','0000-00-00 00:00:00','','Drums','',NULL),(45,'Brian','Mason','9103521048','','0000-00-00','0000-00-00 00:00:00','','Drums','',NULL),(46,'Brian','Mason','9103521048','','0000-00-00','0000-00-00 00:00:00','','Drums','',NULL),(47,'Brian','Mason','9103521048','','0000-00-00','0000-00-00 00:00:00','Thursday','Drums','',NULL),(48,'Frances','Carter','222-222-222','','0000-00-00','0000-00-00 00:00:00','Tuesday','Electric Bass','',NULL),(49,'Frances','Carter','222-222-222','','0000-00-00','0000-00-00 00:00:00','Tuesday','Electric Bass','',NULL),(50,'weoif','weiofj','123-123-1234','','2020-12-22','0000-00-00 00:00:00','Monday','Drum Set','',NULL),(51,'weoif','weiofj','123-123-1234','','0000-00-00','0000-00-00 00:00:00','Monday','Drum Set','',NULL),(52,'bwe','weio','2222','','2020-12-30','0000-00-00 00:00:00','','','',NULL);
/*!40000 ALTER TABLE `studentinfo` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = cp850 */ ;
/*!50003 SET character_set_results = cp850 */ ;
/*!50003 SET collation_connection  = cp850_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER student_update
AFTER UPDATE
ON studentinfo FOR EACH ROW
BEGIN
IF OLD.LessonTime <> NEW.LessonTime THEN
INSERT INTO student_schedule_update (Student_ID, oldLessonTime, newLessonTime)
VALUES (Student_ID, OLD.LessonTime, NEW.LessonTime);
ELSEIF OLD.Phone <> NEW.Phone THEN
INSERT INTO student_contact_update (Student_ID, oldPhone, newPhone)
VALUES (Student_ID, OLD.Phone, NEW.Phone);
ELSEIF OLD.email <> NEW.email THEN
INSERT INTO student_contact_update (Student_ID, oldEmail, newEmail)
VALUES (Student_ID, OLD.email, NEW.email);
ELSEIF OLD.Teacher_ID <> NEW.Teacher_ID THEN
INSERT INTO lesson_update (Student_ID, oldTeacher_ID, newTeacher_ID)
VALUES (Student_ID, OLD.Teacher_ID, NEW.Teacher_ID);
ELSEIF OLD.Instrument <> NEW.Instrument THEN
INSERT INTO lesson_update (Student_ID, oldInst, newInst)
VALUES (Student_ID, OLD.Instrument, NEW.Instrument);
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = cp850 */ ;
/*!50003 SET character_set_results = cp850 */ ;
/*!50003 SET collation_connection  = cp850_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER after_student_update
AFTER DELETE ON studentinfo FOR EACH ROW
INSERT INTO Student_Archive (Student_ID, FirstName, LastName, StartDate)
VALUES (Student_ID, FirstName, LastName, DateStarted) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `teacher_archive`
--

DROP TABLE IF EXISTS `teacher_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teacher_archive` (
  `Teacher_ID` int(11) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `StartDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `EndDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Teacher_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teacher_archive`
--

LOCK TABLES `teacher_archive` WRITE;
/*!40000 ALTER TABLE `teacher_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `teacher_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teachers` (
  `Teacher_ID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(100) DEFAULT NULL,
  `LastName` varchar(100) DEFAULT NULL,
  `Instruments` varchar(100) DEFAULT NULL,
  `TeachingDays` varchar(100) DEFAULT NULL,
  `StartDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Password` varchar(100) NOT NULL,
  `Salt` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Teacher_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teachers`
--

LOCK TABLES `teachers` WRITE;
/*!40000 ALTER TABLE `teachers` DISABLE KEYS */;
INSERT INTO `teachers` VALUES (2,'','','','','2020-12-30 02:18:01','$2y$11$Ku9y6wHiPtt6wLR6uVxmP.eyxmIG1NBodH4lvmbny.vOhzYqAXkvi','kÚ <ç¨M®hég¶!?Õøj','',''),(3,'','','','','2020-12-31 02:09:32','$2y$11$8piXwERZU5Iuq7JLT0z/ouE9a4AqMebO9BI8P4U3d4LtrNd01P756','nÞàÖäÊYÜ\"É†ñwwùËtƒ|I','',''),(4,'','','','','2020-12-31 02:22:54','$2y$11$TqtW5eJ/2cszUo/M9z37RuXmaboZma0g4eX4MG1ZSiD6WOhXN7HpK','q}´¸.¦£!áª}(µþN¾7d','',''),(5,'','','','','2020-12-31 02:26:27','$2y$11$zN1VFYusM6.PJDtFfBVxfuTxMqSXLeyapFufKVGw1y4d/fJ7Kksnm','jÈoGÄ’ÙËéšËÒ­×­—ü','',''),(6,'','','','','2020-12-31 02:27:43','$2y$11$xf72ieciCTNNYmEFuET6aebhhy3f3TwgPUzS3teXhOnt/CC5seYfu','ù¢!˜;†<Ô_ãÍ\0þÓçV\r','',''),(7,'','','','','2020-12-31 02:29:50','$2y$11$A1nZmG1TWWV.LQdYZ9CdnO37jJIg4roA/Awc0GF9ErOzgrm.SIaGK','ãÆ×ž[UÙÒÕS»é3Eë-.†˜','',''),(8,'ewoifj`weoij','erfoj','','','2020-12-31 02:32:19','$2y$11$zr73QYVRZeQI/mO3L1A3oeYACPeteZHC8pHFEFbtuFj12pBl621EO','îc§q\0ŒÖæê*”˜YI¼8_w±','wefj','weoifj'),(9,'Carter','Williams','Array','Array','2020-12-31 15:35:28','$2y$11$9FaOn2CcKtEsTYS52EhCX.r7u4wJA5qOEGdROXRgao4h1A0r7H8VO','~RÂ-Åï¦,Ów±á¥ô†‡sG‰•','333-555-5555','cwilliams@art.gov'),(10,'Carter','Willia','','','2020-12-31 15:49:53','$2y$11$ZZnJikmbxJJ6aH4EHRSryubRIAVaU82IVq6CbOcZtRj0yPbN.oCZC','TœœåÃŸÛâÔö¶¾^ùŽl‹#žO','',''),(11,'Carter','Williams','','','2020-12-31 15:51:16','$2y$11$P.4oQejDpd1ZjPZrgYGwtu.WwuFTc3tmplbxmYoK.l.eERWg8tYkK','Œmdë%‰5Íóæ/<qÔ&…õ³®ÔÕ','555-555-5555','birddog@ball.edu'),(12,'Carter','Williams','Piano','mon, tues, wed, th, fri','2020-12-31 16:01:12','$2y$11$qMOY5VdjY1dn./TE.Z5Z..fGXHifm4TU6vu10W.2F8oKM2Et6aUia','\06|ö©Eä1J´ ØBÏ)RÐ\r','555-555-5555','birddog@ball.edu'),(13,'Brian','Mason','','','2021-01-01 16:20:56','$2y$11$vWS.M8Q0F9jgGkQk95ozeeRrruBJ6bkNdRrQK1nUIF9w1ec1Ms5VW','ÄjJÏ-ˆoA}üÓªÔ_žƒ','9103521048','bcmason404@mail.gov'),(14,'Brian','Mason','Drum Set, Electric Bass, Guitar','mon, wed, th','2021-01-01 16:21:17','$2y$11$I9wkySbhiUiMN3VlVDE5XOVzwcxOjVxIgmiHYQnGJaNbb696ue.Ca',',yîfä†„äA…)s£œ®C	bIÄp','9103521048','bcmason404@mail.gov');
/*!40000 ALTER TABLE `teachers` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = cp850 */ ;
/*!50003 SET character_set_results = cp850 */ ;
/*!50003 SET collation_connection  = cp850_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER after_teacher_delete 
AFTER DELETE ON teachers FOR EACH ROW
INSERT INTO Teacher_Archive (Teacher_ID, FirstName, LastName, StartDate)
VALUES (Teacher_ID, FirstName, LastName, StartDate) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-01-01 11:31:14
