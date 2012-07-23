-- MySQL dump 10.13  Distrib 5.5.25, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: diplom
-- ------------------------------------------------------
-- Server version	5.5.25-1~dotdeb.0-log

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
-- Table structure for table `data`
--

DROP TABLE IF EXISTS `data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sector_id` int(11) unsigned DEFAULT NULL,
  `metric_id` int(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data`
--

LOCK TABLES `data` WRITE;
/*!40000 ALTER TABLE `data` DISABLE KEYS */;
INSERT INTO `data` VALUES (1,1,1,'10'),(2,2,1,'20'),(3,3,1,'30'),(4,4,1,'40'),(5,5,1,'30'),(7,1,6,'9900'),(8,2,6,'9900'),(9,3,6,'12000'),(10,4,6,'7200'),(11,5,6,'10200'),(12,1,3,'1'),(13,2,3,'1'),(14,3,3,'1'),(15,4,3,'1'),(16,5,3,'1'),(22,1,5,'58'),(23,2,5,'71'),(24,3,5,'82'),(25,4,5,'54'),(26,5,5,'76'),(27,1,4,'4'),(28,2,4,'4'),(29,3,4,'3'),(30,4,4,'1'),(31,5,4,'7'),(32,1,7,NULL),(33,2,7,NULL),(34,3,7,NULL),(35,4,7,NULL),(36,5,7,NULL),(37,1,2,'0'),(38,2,2,'0'),(39,3,2,'1'),(40,4,2,'0'),(41,5,2,'0'),(42,6,1,'1'),(43,6,2,'0'),(44,6,3,'0'),(45,6,4,'3'),(46,6,5,'67\r\n'),(47,6,6,'5700'),(48,6,7,NULL);
/*!40000 ALTER TABLE `data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `squares`
--

DROP TABLE IF EXISTS `squares`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `squares` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `squares`
--

LOCK TABLES `squares` WRITE;
/*!40000 ALTER TABLE `squares` DISABLE KEYS */;
INSERT INTO `squares` VALUES (1,'Алматинский');
/*!40000 ALTER TABLE `squares` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sectors`
--

DROP TABLE IF EXISTS `sectors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sectors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `square_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sectors`
--

LOCK TABLES `sectors` WRITE;
/*!40000 ALTER TABLE `sectors` DISABLE KEYS */;
INSERT INTO `sectors` VALUES (1,'1-й',1),(2,'2-й',1),(3,'3-й',1),(4,'4-й',1),(5,'5-й',1),(6,'ТЦ \"Евразия\"',1);
/*!40000 ALTER TABLE `sectors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metrics`
--

DROP TABLE IF EXISTS `metrics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `metrics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `formula` text,
  `min` varchar(255) DEFAULT NULL,
  `norma` varchar(255) DEFAULT NULL,
  `max` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metrics`
--

LOCK TABLES `metrics` WRITE;
/*!40000 ALTER TABLE `metrics` DISABLE KEYS */;
INSERT INTO `metrics` VALUES (1,'Детские сады','detsad','peoples * 0.06 * (3 / 5) / metric','1','300','450','2'),(2,'Поликлиники','policlinic',NULL,NULL,NULL,NULL,'2'),(3,'Школы','school','peoples *  0.2/ metric','1','1200','2000','2'),(4,'Спорт площадки','sportplace',NULL,NULL,NULL,NULL,'2'),(5,'Мусорные контейнеры','garbagecontainer','metric * 1.1 * 365','peoples * 1.4 / 2','peoples * 1.4','peoples * 1.4 * 2','1'),(6,'Население','peoples',NULL,NULL,NULL,NULL,NULL),(7,'Количество участковых','policemans','peoples / metric','2000','3000','4000','1');
/*!40000 ALTER TABLE `metrics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `polygons`
--

DROP TABLE IF EXISTS `polygons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `polygons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sector_id` int(11) DEFAULT NULL,
  `lat` decimal(16,10) DEFAULT NULL,
  `lng` decimal(16,10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `LatLng` (`lat`,`lng`,`sector_id`)
) ENGINE=MyISAM AUTO_INCREMENT=306 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `polygons`
--

LOCK TABLES `polygons` WRITE;
/*!40000 ALTER TABLE `polygons` DISABLE KEYS */;
INSERT INTO `polygons` VALUES (120,1,51.1512212709,71.4561081639),(119,1,51.1524864645,71.4607859365),(118,1,51.1490407494,71.4635754338),(117,1,51.1489330667,71.4656353704),(116,1,51.1461130353,71.4655495397),(115,1,51.1461063048,71.4598847142),(177,2,51.1490542097,71.4636183492),(176,2,51.1489061459,71.4657212010),(175,2,51.1461063048,71.4656353703),(174,2,51.1457832353,71.4697123281),(173,2,51.1463755277,71.4721585027),(172,2,51.1540746372,71.4666653386),(171,2,51.1525133832,71.4608717672),(45,3,51.1461197660,71.4598847142),(46,3,51.1460389988,71.4655495397),(47,3,51.1457428514,71.4696264974),(48,3,51.1463889888,71.4722014180),(49,3,51.1445313195,71.4734030477),(50,3,51.1416504382,71.4629317037),(208,5,51.1463755277,71.4722121469),(207,5,51.1489869080,71.4702916852),(206,5,51.1498820121,71.4740575067),(205,5,51.1518538720,71.4806986562),(197,4,51.1544312958,71.4740306846),(196,4,51.1557973392,71.4730811826),(195,4,51.1540477195,71.4665365926),(194,4,51.1567124982,71.4761496297),(193,4,51.1563625865,71.4774370900),(204,5,51.1475735504,71.4837885610),(203,5,51.1446120893,71.4733601323),(148,NULL,51.1488792252,71.4703131429),(149,NULL,51.1498483620,71.4738322011),(150,NULL,51.1473985603,71.4757204763),(151,NULL,51.1464293721,71.4721585027),(305,6,51.1488792252,71.4703560582),(304,6,51.1464832164,71.4720726720),(303,6,51.1541823079,71.4667082539),(302,6,51.1558780891,71.4730597249),(192,4,51.1517865749,71.4808274022),(191,4,51.1499022026,71.4741326086),(198,4,51.1529575386,71.4739502184),(301,6,51.1544111074,71.4739824048),(300,6,51.1523451414,71.4741218797),(299,6,51.1499560425,71.4740896932),(298,6,51.1495286836,71.4722389690),(297,6,51.1489667175,71.4704740754),(296,6,51.1541116490,71.4668209067),(295,6,51.1557031304,71.4732099286),(294,6,51.1542024962,71.4665473214);
/*!40000 ALTER TABLE `polygons` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-07-19 17:06:21
