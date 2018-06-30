-- MySQL dump 10.13  Distrib 5.7.22, for Linux (x86_64)
--
-- Host: localhost    Database: markopelago
-- ------------------------------------------------------
-- Server version	5.7.22-0ubuntu18.04.1

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
-- Table structure for table `a_backoffice_menu`
--

DROP TABLE IF EXISTS `a_backoffice_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `a_backoffice_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seqno` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `a_backoffice_menu`
--

LOCK TABLES `a_backoffice_menu` WRITE;
/*!40000 ALTER TABLE `a_backoffice_menu` DISABLE KEYS */;
INSERT INTO `a_backoffice_menu` VALUES (1,1,0,'Home','index.php','2016-04-11 18:31:28','superuser@jalurkerja.com','127.0.0.1','2016-10-28 16:10:37','superuser','127.0.0.1','2016-10-28 02:10:37'),(2,2,0,'Master Data','#','2016-04-11 18:31:28','superuser@jalurkerja.com','127.0.0.1','2016-04-11 18:31:28','superuser@jalurkerja.com','127.0.0.1','2016-04-11 04:31:28'),(3,4,0,'General','#','2016-04-11 18:31:28','superuser@jalurkerja.com','127.0.0.1','2016-11-07 08:01:39','superuser','127.0.0.1','2018-06-23 06:35:34'),(4,1,8,'Users','users_list.php','2016-11-07 08:08:09','superuser','127.0.0.1','2016-11-07 08:08:09','superuser','127.0.0.1','2018-06-23 06:35:34'),(5,1,2,'Groups','groups_list.php','2017-03-27 09:59:48','superuser','127.0.0.1','2017-03-27 09:59:48','superuser','127.0.0.1','2018-06-23 06:35:35'),(6,1,3,'Change Password','change_password.php','2016-11-07 08:08:39','superuser','127.0.0.1','2016-11-07 08:08:39','superuser','127.0.0.1','2017-07-30 18:54:05'),(7,2,2,'Goods','goods_list.php',NULL,'',NULL,NULL,'',NULL,'2018-06-23 06:35:35'),(8,3,0,'Subject','#',NULL,'',NULL,NULL,'',NULL,'2018-06-23 06:35:34'),(9,2,8,'Surveys','surveys_list.php',NULL,'',NULL,NULL,'',NULL,'2018-06-23 06:35:34');
/*!40000 ALTER TABLE `a_backoffice_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `a_backoffice_menu_privileges`
--

DROP TABLE IF EXISTS `a_backoffice_menu_privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `a_backoffice_menu_privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `a_backoffice_menu_id` int(11) NOT NULL,
  `privilege` smallint(6) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `a_backoffice_menu_privileges`
--

LOCK TABLES `a_backoffice_menu_privileges` WRITE;
/*!40000 ALTER TABLE `a_backoffice_menu_privileges` DISABLE KEYS */;
INSERT INTO `a_backoffice_menu_privileges` VALUES (11,1,1,1,'2017-08-13 17:52:53','admin','127.0.0.1','2017-08-13 10:52:53'),(12,1,2,1,'2017-08-13 17:52:53','admin','127.0.0.1','2017-08-13 10:52:53'),(13,1,4,1,'2017-08-13 17:52:53','admin','127.0.0.1','2017-08-13 10:52:53'),(14,1,5,1,'2017-08-13 17:52:53','admin','127.0.0.1','2017-08-13 10:52:53'),(15,1,3,1,'2017-08-13 17:52:53','admin','127.0.0.1','2017-08-13 10:52:53'),(16,1,6,1,'2017-08-13 17:52:53','admin','127.0.0.1','2017-08-13 10:52:53');
/*!40000 ALTER TABLE `a_backoffice_menu_privileges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `a_groups`
--

DROP TABLE IF EXISTS `a_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `a_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `a_groups`
--

LOCK TABLES `a_groups` WRITE;
/*!40000 ALTER TABLE `a_groups` DISABLE KEYS */;
INSERT INTO `a_groups` VALUES (1,'Administrator','2017-08-13 17:30:16','superuser','127.0.0.1','2017-08-13 17:53:30','admin','127.0.0.1','2017-08-13 10:53:30'),(2,'BOD','0000-00-00 00:00:00','',NULL,'0000-00-00 00:00:00','',NULL,'2018-06-19 16:34:23'),(3,'CSO Leader','0000-00-00 00:00:00','',NULL,'0000-00-00 00:00:00','',NULL,'2018-06-19 16:34:23'),(4,'CSO Team','0000-00-00 00:00:00','',NULL,'0000-00-00 00:00:00','',NULL,'2018-06-19 16:34:23'),(5,'Surveyor Leader','0000-00-00 00:00:00','',NULL,'0000-00-00 00:00:00','',NULL,'2018-06-19 16:34:23'),(6,'Surveyor Team','0000-00-00 00:00:00','',NULL,'0000-00-00 00:00:00','',NULL,'2018-06-19 16:34:23'),(7,'Finance Leader','0000-00-00 00:00:00','',NULL,'0000-00-00 00:00:00','',NULL,'2018-06-19 16:34:23'),(8,'Finance Team','0000-00-00 00:00:00','',NULL,'0000-00-00 00:00:00','',NULL,'2018-06-19 16:34:23');
/*!40000 ALTER TABLE `a_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `a_log_histories`
--

DROP TABLE IF EXISTS `a_log_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `a_log_histories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `x_mode` smallint(6) NOT NULL,
  `log_at` datetime DEFAULT NULL,
  `log_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `a_log_histories`
--

LOCK TABLES `a_log_histories` WRITE;
/*!40000 ALTER TABLE `a_log_histories` DISABLE KEYS */;
INSERT INTO `a_log_histories` VALUES (1,1,'superuser',1,'2018-05-27 11:35:27','127.0.0.1','2018-05-27 04:35:27'),(2,1,'superuser',1,'2018-05-28 21:02:26','127.0.0.1','2018-05-28 14:02:26'),(3,1,'superuser',1,'2018-06-03 00:30:07','127.0.0.1','2018-06-02 17:30:07'),(4,1,'superuser',2,'2018-06-03 01:19:26','127.0.0.1','2018-06-02 18:19:26'),(5,1,'superuser',1,'2018-06-03 01:42:08','127.0.0.1','2018-06-02 18:42:08'),(6,1,'superuser',1,'2018-06-03 01:48:46','192.168.0.14','2018-06-02 18:48:46'),(7,1,'superuser',2,'2018-06-03 01:50:07','192.168.0.14','2018-06-02 18:50:07'),(8,1,'superuser',2,'2018-06-03 01:59:05','127.0.0.1','2018-06-02 18:59:05'),(9,1,'superuser',1,'2018-06-03 02:21:28','127.0.0.1','2018-06-02 19:21:28'),(10,1,'superuser',2,'2018-06-03 02:22:17','127.0.0.1','2018-06-02 19:22:17'),(11,1,'superuser',1,'2018-06-03 02:23:32','127.0.0.1','2018-06-02 19:23:32'),(12,1,'superuser',1,'2018-06-03 02:50:15','192.168.0.14','2018-06-02 19:50:15'),(13,1,'superuser',2,'2018-06-03 02:50:23','192.168.0.14','2018-06-02 19:50:23'),(14,1,'superuser',2,'2018-06-06 21:13:31','127.0.0.1','2018-06-06 14:13:31'),(15,1,'superuser',2,'2018-06-09 14:57:18','127.0.0.1','2018-06-09 07:57:18'),(16,3,'arif@markopelago.com',1,'2018-06-19 23:57:14','127.0.0.1','2018-06-19 16:57:14'),(17,3,'arif@markopelago.com',2,'2018-06-19 23:57:27','127.0.0.1','2018-06-19 16:57:27'),(18,3,'arif@markopelago.com',1,'2018-06-19 23:57:45','127.0.0.1','2018-06-19 16:57:45'),(19,3,'arif@markopelago.com',2,'2018-06-20 00:25:14','127.0.0.1','2018-06-19 17:25:14'),(20,3,'arif@markopelago.com',1,'2018-06-20 00:25:21','127.0.0.1','2018-06-19 17:25:22'),(21,3,'arif@markopelago.com',2,'2018-06-20 00:25:38','127.0.0.1','2018-06-19 17:25:38'),(22,1,'superuser',1,'2018-06-20 00:25:46','127.0.0.1','2018-06-19 17:25:47'),(23,1,'superuser',2,'2018-06-20 00:31:00','127.0.0.1','2018-06-19 17:31:00'),(24,3,'arif@markopelago.com',1,'2018-06-20 00:32:00','127.0.0.1','2018-06-19 17:32:00'),(25,3,'arif@markopelago.com',2,'2018-06-20 01:51:46','127.0.0.1','2018-06-19 18:51:46'),(26,3,'arif@markopelago.com',1,'2018-06-20 01:52:16','127.0.0.1','2018-06-19 18:52:16'),(27,3,'arif@markopelago.com',2,'2018-06-20 02:12:07','127.0.0.1','2018-06-19 19:12:07'),(28,3,'arif@markopelago.com',1,'2018-06-20 02:12:34','127.0.0.1','2018-06-19 19:12:34'),(29,3,'arif@markopelago.com',2,'2018-06-20 02:17:32','127.0.0.1','2018-06-19 19:17:32'),(30,3,'arif@markopelago.com',1,'2018-06-20 02:17:42','127.0.0.1','2018-06-19 19:17:42'),(31,3,'arif@markopelago.com',2,'2018-06-20 02:18:34','127.0.0.1','2018-06-19 19:18:34'),(32,3,'arif@markopelago.com',1,'2018-06-20 02:18:44','127.0.0.1','2018-06-19 19:18:44'),(33,3,'arif@markopelago.com',2,'2018-06-20 02:23:06','127.0.0.1','2018-06-19 19:23:06'),(34,3,'arif@markopelago.com',1,'2018-06-20 02:23:14','127.0.0.1','2018-06-19 19:23:14'),(35,3,'arif@markopelago.com',1,'2018-06-20 02:27:05','192.168.0.12','2018-06-19 19:27:05'),(36,3,'arif@markopelago.com',1,'2018-06-20 12:44:01','127.0.0.1','2018-06-20 05:44:01'),(37,3,'arif@markopelago.com',1,'2018-06-20 12:45:10','192.168.0.12','2018-06-20 05:45:10'),(38,3,'arif@markopelago.com',1,'2018-06-20 13:09:58','192.168.0.12','2018-06-20 06:09:58'),(39,3,'arif@markopelago.com',1,'2018-06-20 13:14:43','192.168.0.12','2018-06-20 06:14:43'),(40,3,'arif@markopelago.com',1,'2018-06-20 15:54:07','192.168.0.12','2018-06-20 08:54:07'),(41,3,'arif@markopelago.com',1,'2018-06-20 16:04:37','192.168.0.12','2018-06-20 09:04:37'),(42,3,'arif@markopelago.com',1,'2018-06-20 16:08:13','192.168.0.12','2018-06-20 09:08:13'),(43,1,'superuser',2,'2018-06-21 14:33:12','127.0.0.1','2018-06-21 07:33:12'),(44,3,'arif@markopelago.com',1,'2018-06-21 14:33:21','127.0.0.1','2018-06-21 07:33:21'),(45,3,'arif@markopelago.com',1,'2018-06-21 14:40:25','192.168.1.13','2018-06-21 07:40:25'),(46,3,'arif@markopelago.com',1,'2018-06-21 14:42:46','192.168.1.13','2018-06-21 07:42:46'),(47,3,'arif@markopelago.com',1,'2018-06-22 05:40:18','127.0.0.1','2018-06-21 22:40:18'),(48,3,'arif@markopelago.com',1,'2018-06-22 08:19:26','127.0.0.1','2018-06-22 01:19:26'),(49,3,'arif@markopelago.com',1,'2018-06-22 16:56:56','192.168.1.19','2018-06-22 09:56:56'),(50,3,'arif@markopelago.com',1,'2018-06-22 19:36:40','192.168.0.12','2018-06-22 12:36:40'),(51,3,'arif@markopelago.com',1,'2018-06-23 05:36:49','192.168.0.12','2018-06-22 22:36:49'),(52,3,'arif@markopelago.com',2,'2018-06-23 06:46:06','127.0.0.1','2018-06-22 23:46:06'),(53,3,'arif@markopelago.com',1,'2018-06-23 06:46:12','127.0.0.1','2018-06-22 23:46:12'),(54,3,'arif@markopelago.com',1,'2018-06-22 22:38:25','111.95.48.124','2018-06-23 03:38:25'),(55,3,'arif@markopelago.com',2,'2018-06-22 22:47:11','111.95.48.124','2018-06-23 03:47:11'),(56,3,'arif@markopelago.com',1,'2018-06-22 22:47:17','111.95.48.124','2018-06-23 03:47:17'),(57,3,'arif@markopelago.com',1,'2018-06-22 22:49:28','111.95.48.124','2018-06-23 03:49:28'),(58,3,'arif@markopelago.com',1,'2018-06-22 22:51:12','111.95.48.124','2018-06-23 03:51:12'),(59,3,'arif@markopelago.com',2,'2018-06-22 22:55:19','111.95.48.124','2018-06-23 03:55:19'),(60,1,'superuser',1,'2018-06-23 09:35:04','111.95.48.124','2018-06-23 14:35:04'),(61,1,'superuser',2,'2018-06-23 09:35:31','111.95.48.124','2018-06-23 14:35:31'),(62,3,'arif@markopelago.com',1,'2018-06-23 09:35:39','111.95.48.124','2018-06-23 14:35:39'),(63,3,'arif@markopelago.com',1,'2018-06-23 09:36:20','111.95.48.124','2018-06-23 14:36:20'),(64,3,'arif@markopelago.com',2,'2018-06-23 09:45:58','111.95.48.124','2018-06-23 14:45:58'),(65,1,'superuser',1,'2018-06-23 09:46:05','111.95.48.124','2018-06-23 14:46:05'),(66,3,'arif@markopelago.com',1,'2018-06-23 17:35:48','111.95.48.124','2018-06-23 22:35:48'),(67,3,'arif@markopelago.com',1,'2018-06-23 17:38:45','111.95.48.124','2018-06-23 22:38:45'),(68,3,'arif@markopelago.com',1,'2018-06-24 06:21:22','192.168.0.12','2018-06-23 23:21:22'),(69,3,'arif@markopelago.com',1,'2018-06-24 11:25:36','127.0.0.1','2018-06-24 04:25:36'),(70,3,'arif@markopelago.com',1,'2018-06-24 13:11:26','192.168.1.103','2018-06-24 06:11:26'),(71,3,'arif@markopelago.com',2,'2018-06-24 13:20:17','192.168.1.103','2018-06-24 06:20:17'),(72,3,'arif@markopelago.com',1,'2018-06-24 13:20:34','192.168.1.103','2018-06-24 06:20:34'),(73,1,'superuser',1,'2018-06-24 13:31:06','127.0.0.1','2018-06-24 06:31:07'),(74,3,'arif@markopelago.com',1,'2018-06-26 05:16:38','127.0.0.1','2018-06-25 22:16:38'),(75,3,'arif@markopelago.com',2,'2018-06-26 05:19:44','127.0.0.1','2018-06-25 22:19:44'),(76,1,'superuser',1,'2018-06-26 05:19:50','127.0.0.1','2018-06-25 22:19:50'),(77,1,'superuser',2,'2018-06-26 05:31:25','127.0.0.1','2018-06-25 22:31:25'),(78,8,'widi@markopelago.com',1,'2018-06-26 05:31:30','127.0.0.1','2018-06-25 22:31:30'),(79,8,'widi@markopelago.com',2,'2018-06-26 05:31:47','127.0.0.1','2018-06-25 22:31:47'),(80,1,'superuser',1,'2018-06-30 20:02:40','127.0.0.1','2018-06-30 13:02:40'),(81,1,'superuser',2,'2018-06-30 20:52:42','127.0.0.1','2018-06-30 13:52:42'),(82,7,'arif@markopelago.com',1,'2018-06-30 20:52:47','127.0.0.1','2018-06-30 13:52:47');
/*!40000 ALTER TABLE `a_log_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `a_users`
--

DROP TABLE IF EXISTS `a_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `a_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `sign_in_count` int(11) NOT NULL,
  `current_sign_in_at` datetime DEFAULT NULL,
  `last_sign_in_at` datetime DEFAULT NULL,
  `current_sign_in_ip` varchar(20) DEFAULT NULL,
  `last_sign_in_ip` varchar(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `a_users`
--

LOCK TABLES `a_users` WRITE;
/*!40000 ALTER TABLE `a_users` DISABLE KEYS */;
INSERT INTO `a_users` VALUES (1,1,'superuser','MTIzNDU2','superuser',22,'2018-06-30 20:02:40','2018-06-26 05:19:50','127.0.0.1','127.0.0.1','2017-04-27 08:39:07','127.0.0.1','superuser','2018-06-30 20:08:59','superuser','127.0.0.1','2018-06-30 13:08:59'),(2,1,'admin','MTIzMTIz','Administrator',37,'2017-08-13 18:51:11','2017-08-13 18:43:14','127.0.0.1','127.0.0.1','2017-08-13 17:31:44','superuser','127.0.0.1','2017-08-13 17:53:47','admin','127.0.0.1','2017-08-13 11:51:11'),(3,6,'junaedi@markopelago.com','MTIzNDU2','Junaedi',39,'2018-06-26 05:16:38','2018-06-24 13:20:34','127.0.0.1','192.168.1.103','0000-00-00 00:00:00','',NULL,'2018-06-26 05:16:38','arif@markopelago.com','127.0.0.1','2018-06-25 22:31:10'),(4,6,'herni@markopelago.com','MTIzNDU2','Herni',0,NULL,NULL,NULL,NULL,'0000-00-00 00:00:00','',NULL,'0000-00-00 00:00:00','',NULL,'2018-06-25 22:31:10'),(5,6,'septy@markopelago.com','MTIzNDU2','Septy Kamsuri',0,NULL,NULL,NULL,NULL,'0000-00-00 00:00:00','',NULL,'0000-00-00 00:00:00','',NULL,'2018-06-25 22:31:10'),(6,6,'dory@markopelago.com','MTIzNDU2','Dory Indra Nugraha',0,NULL,NULL,NULL,NULL,'0000-00-00 00:00:00','',NULL,'0000-00-00 00:00:00','',NULL,'2018-06-25 22:31:10'),(7,6,'arif@markopelago.com','MTIzNDU2','M Arif',1,'2018-06-30 20:52:47','0000-00-00 00:00:00','127.0.0.1','','0000-00-00 00:00:00','',NULL,'2018-06-30 20:52:47','arif@markopelago.com','127.0.0.1','2018-06-30 13:52:47'),(8,6,'widi@markopelago.com','MTIzNDU2','Widi Hartono B Joko S',1,'2018-06-26 05:31:30','0000-00-00 00:00:00','127.0.0.1','','0000-00-00 00:00:00','',NULL,'2018-06-26 05:31:30','widi@markopelago.com','127.0.0.1','2018-06-25 22:31:30'),(9,6,'agung@markopelago.com','MTIzNDU2','Agung Maulana',0,NULL,NULL,NULL,NULL,'0000-00-00 00:00:00','',NULL,'0000-00-00 00:00:00','',NULL,'2018-06-25 22:31:10'),(10,6,'krisdianto@markopelago.com','MTIzNDU2','Krisdianto Putra',0,NULL,NULL,NULL,NULL,'0000-00-00 00:00:00','',NULL,'0000-00-00 00:00:00','',NULL,'2018-06-25 22:31:10'),(11,6,'marhusin@markopelago.com','MTIzNDU2','Marhusin',0,NULL,NULL,NULL,NULL,'0000-00-00 00:00:00','',NULL,'0000-00-00 00:00:00','',NULL,'2018-06-25 22:31:10'),(12,6,'aziz@markopelago.com','MTIzNDU2','Abdul Aziz',0,NULL,NULL,NULL,NULL,'0000-00-00 00:00:00','',NULL,'0000-00-00 00:00:00','',NULL,'2018-06-25 22:31:10'),(13,6,'agungbw@markopelago.com','MTIzNDU2','Agung Budi Wibowo',0,NULL,NULL,NULL,NULL,'0000-00-00 00:00:00','',NULL,'0000-00-00 00:00:00','',NULL,'2018-06-25 22:31:10'),(14,-1,'rizky@gmail.com','MTIzNDU2','Rizky Store',0,NULL,NULL,NULL,NULL,'0000-00-00 00:00:00','',NULL,'0000-00-00 00:00:00','',NULL,'2018-06-25 22:31:10');
/*!40000 ALTER TABLE `a_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backofficers`
--

DROP TABLE IF EXISTS `backofficers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backofficers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backofficers`
--

LOCK TABLES `backofficers` WRITE;
/*!40000 ALTER TABLE `backofficers` DISABLE KEYS */;
INSERT INTO `backofficers` VALUES (1,3,'Junaedi','0858 1161 4152',NULL,'',NULL,NULL,'',NULL,'2018-06-25 22:37:03'),(2,4,'Herni','0838 0428 1759',NULL,'',NULL,NULL,'',NULL,'2018-06-25 22:37:03'),(3,5,'Septy Kamsuri','0896 2794 9003',NULL,'',NULL,NULL,'',NULL,'2018-06-25 22:37:03'),(4,6,'Dory Indra Nugraha','',NULL,'',NULL,NULL,'',NULL,'2018-06-25 22:36:26'),(5,7,'M Arif','',NULL,'',NULL,NULL,'',NULL,'2018-06-25 22:36:26'),(6,8,'Widi Hartono B Joko S','',NULL,'',NULL,NULL,'',NULL,'2018-06-25 22:36:26'),(7,9,'Agung Maulana','',NULL,'',NULL,NULL,'',NULL,'2018-06-25 22:36:26'),(8,10,'Krisdianto Putra','',NULL,'',NULL,NULL,'',NULL,'2018-06-25 22:36:26'),(9,11,'Marhusin','',NULL,'',NULL,NULL,'',NULL,'2018-06-25 22:36:26'),(10,12,'Abdul Aziz','',NULL,'',NULL,NULL,'',NULL,'2018-06-25 22:36:26'),(11,13,'Agung Budi Wibowo','',NULL,'',NULL,NULL,'',NULL,'2018-06-25 22:36:26'),(12,14,'Rigen Wildanu Hadadi','085233063966','2018-06-30 21:16:35','arif@markopelago.com','127.0.0.1','2018-06-30 21:22:08','arif@markopelago.com','127.0.0.1','2018-06-30 14:22:08'),(13,15,'Ian','081290870123','2018-06-30 21:16:35','arif@markopelago.com','127.0.0.1','2018-06-30 21:16:35','arif@markopelago.com','127.0.0.1','2018-06-30 14:16:35'),(14,16,'endro','0895350539368','2018-06-30 21:16:35','arif@markopelago.com','127.0.0.1','2018-06-30 21:16:35','arif@markopelago.com','127.0.0.1','2018-06-30 14:16:35'),(15,17,'endro2','0895350539368','2018-06-30 21:23:42','arif@markopelago.com','127.0.0.1','2018-06-30 21:23:42','arif@markopelago.com','127.0.0.1','2018-06-30 14:23:42');
/*!40000 ALTER TABLE `backofficers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `name_id` varchar(255) NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `promo_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,0,'Fashion','Fashion',0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 16:51:44'),(2,0,'Bahan Makanan','Groceries',0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 16:51:44'),(3,0,'Aksesoris','Accessories',0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 16:51:44'),(4,0,'Ibu & Bayi','Mother & Baby',0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 16:51:44'),(5,0,'Properti','Property',0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 16:51:44'),(6,0,'Peralatan Rumah Tangga','Home Appliances',0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 16:51:44'),(7,0,'Bags & Travel Luggage','Bags & Travel Luggage',0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 16:51:44'),(8,0,'Kesehatan & Kecantikan','Health & Beauty',0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 16:51:44'),(9,0,'Otomotif','Automotive',0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 16:51:44'),(10,1,'Mode & Pakaian','Fashion & Apparel',0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:03:14'),(11,1,'Batik','Mode & Pakaian',0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:03:14'),(12,2,'Sembako & Pangan','Grocery & Food',0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:03:14'),(13,2,'Kebutuhan Rumah Tangga','Home Appliances',0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:03:14'),(14,3,'Mebel & Kerajinan Tangan','Furniture & Handicraft',0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:03:14'),(15,4,'Ibu & Bayi','Mother & Baby',0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:03:14'),(16,5,'Bahan Bangunan','Building Material',0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:03:14'),(17,2,'Kopi, Susu & Teh','Coffee, Milk & Tea',0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:03:14'),(18,6,'Gadget & Elektronik','Gadgets & Electronics',0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:03:14'),(19,7,'Tas','Bags',0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:03:14'),(20,2,'Makanan & Minuman','Food & Beverages',0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:03:14'),(21,8,'Kesehatan & Kecantikan','Health & Beauty',0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:03:14'),(22,9,'Otomotif','Outomotive',0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:03:14');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goods`
--

DROP TABLE IF EXISTS `goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `barcode` varchar(150) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `category_ids` varchar(255) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `promo_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `weight` double NOT NULL,
  `dimension` varchar(150) NOT NULL,
  `is_new` smallint(6) NOT NULL,
  `price` double NOT NULL,
  `disc` double NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods`
--

LOCK TABLES `goods` WRITE;
/*!40000 ALTER TABLE `goods` DISABLE KEYS */;
INSERT INTO `goods` VALUES (1,'ASDXCA',1,'|1||3||5|',1,0,'Sepatu Adidas','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',1000,'100 x 100 x 100',1,250000,0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:19:49'),(2,'ASDXCA',1,'|1||3||5|',1,0,'Sepatu Adidas','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',1000,'100 x 100 x 100',1,250000,0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:24:32'),(3,'ASDXC1',1,'|2||3||5|',1,0,'Keyboard Dell','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',2000,'100 x 100 x 100',1,240000,0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:24:32'),(4,'ASDXC2',1,'|3||4||5|',1,0,'Mouse HP','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',4000,'100 x 100 x 100',1,200000,0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:24:32'),(5,'ASDXC3',1,'|1||3|',1,0,'Handphone Oppo','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',1000,'100 x 100 x 100',1,3500000,0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:24:32'),(6,'ASDXC4',1,'|1|',1,0,'Tas Export','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',1000,'100 x 100 x 100',1,200000,0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:24:32'),(7,'ASDXC5',1,'|1||3||6|',1,0,'MOnitor JUC','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',1000,'100 x 100 x 100',1,500000,0,NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:24:32');
/*!40000 ALTER TABLE `goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goods_photos`
--

DROP TABLE IF EXISTS `goods_photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goods_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL,
  `seqno` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `caption` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods_photos`
--

LOCK TABLES `goods_photos` WRITE;
/*!40000 ALTER TABLE `goods_photos` DISABLE KEYS */;
INSERT INTO `goods_photos` VALUES (1,1,1,'001.jpg','',NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:31:15'),(2,1,2,'002.jpg','',NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:31:15'),(3,1,3,'003.jpg','',NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:31:15'),(4,2,1,'004.jpg','',NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:31:15'),(5,2,2,'005.jpg','',NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:31:15'),(6,3,1,'006.jpg','',NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:31:15'),(7,4,1,'007.jpg','',NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:31:15'),(8,5,1,'008.jpg','',NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:31:15'),(9,6,1,'009.jpg','',NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:31:15'),(10,7,1,'010.jpg','',NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:31:15'),(11,7,2,'004.jpg','',NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:31:15');
/*!40000 ALTER TABLE `goods_photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `seqno` int(11) NOT NULL,
  `name_id` varchar(150) NOT NULL,
  `name_en` varchar(150) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,0,1,'Seluruh Indonesia','All Around Indonesia',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:47:02'),(2,1,1,'Seluruh Pulau Sumatera','All Around Sumatera Island',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:47:02'),(3,1,2,'Seluruh Pulau Jawa','All Around Java Island',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:47:02'),(4,1,3,'Seluruh Pulau Kalimantan','All Around Borneo Island',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:47:02'),(5,1,4,'Seluruh Pulau Sulawesi','All Around Sulawesi Island',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:47:02'),(6,2,1,'DI-Aceh','DI-Aceh',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:49:40'),(7,2,2,'Sumatera Utara','Sumatra, North',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:49:42'),(8,2,3,'Sumatera Barat','Sumatra, West',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:49:44'),(9,2,5,'Riau','Riau',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:50:27'),(10,2,6,'Jambi','Jambi',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:50:30'),(11,2,7,'Sumatera Selatan','Sumatra, South',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:50:33'),(12,2,8,'Bengkulu','Bengkulu',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:50:37'),(13,2,10,'Lampung','Lampung',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:52:17'),(14,3,1,'Jakarta','Jakarta',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:53:14'),(15,3,3,'Jawa Barat','Java, West',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:53:26'),(16,3,4,'Jawa Tengah','Java, Central',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:47:02'),(17,3,5,'DI-Yogyakarta','DI-Yogyakarta',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:53:31'),(18,3,6,'Jawa Timur','Java, East',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:53:34'),(19,0,2,'Bali','Bali',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:47:31'),(20,0,3,'Nusa Tenggara Barat','Nusa Tenggara, West',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:47:34'),(21,0,4,'Nusa Tenggara Timur','Nusa Tenggara, East',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:47:02'),(22,4,1,'Kalimantan Barat','Kalimantan, West',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:53:56'),(23,4,2,'Kalimantan Timur','Kalimantan, East',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:54:00'),(24,4,4,'Kalimantan Selatan','Kalimantan, South',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:47:02'),(25,4,3,'Kalimantan Tengah','Kalimantan, Central',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:54:36'),(26,5,1,'Sulawesi Utara','Sulawesi, North',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:55:11'),(27,5,5,'Sulawesi Selatan','Sulawesi, South',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:56:37'),(28,5,6,'Sulawesi Tenggara','Sulawesi, South East',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:57:04'),(29,5,3,'Sulawesi Tengah','Sulawesi, Central',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:56:32'),(30,0,5,'Maluku','Maluku',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:57:40'),(31,0,7,'Papua','Papua',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:57:46'),(32,3,2,'Banten','Banten',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:53:22'),(33,2,9,'Bangka - Belitung','Bangka - Belitung',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:52:21'),(34,0,6,'Maluku Utara','North Maluku',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:57:42'),(35,5,2,'Gorontalo','Gorontalo',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:56:28'),(36,2,4,'Riau Kepulauan','Riau Island',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:50:24'),(37,5,4,'Sulawesi Barat','Sulawesi, West',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:56:35'),(38,0,8,'Papua Barat','Papua, West',NULL,'',NULL,NULL,'',NULL,'2018-06-20 12:57:49');
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promo`
--

DROP TABLE IF EXISTS `promo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_id` varchar(150) NOT NULL,
  `name_en` varchar(150) NOT NULL,
  `price` double NOT NULL,
  `disc` double NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promo`
--

LOCK TABLES `promo` WRITE;
/*!40000 ALTER TABLE `promo` DISABLE KEYS */;
/*!40000 ALTER TABLE `promo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sellers`
--

DROP TABLE IF EXISTS `sellers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sellers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `header_image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `address` text NOT NULL,
  `location_id` int(11) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `pic` varchar(100) NOT NULL,
  `status` smallint(6) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sellers`
--

LOCK TABLES `sellers` WRITE;
/*!40000 ALTER TABLE `sellers` DISABLE KEYS */;
INSERT INTO `sellers` VALUES (1,14,0,'logo_14.jpg','header_14.jpg','Rizky Store','Always provide what you need','Jl kamera I no 11 komp tvri, kemanggisan, jakarta barat\r\n\r\nJakarta Barat, DKI Jakarta, 11480, Indonesia',14,'081987657876','Rizky',1,NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:14:35');
/*!40000 ALTER TABLE `sellers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `survey_details`
--

DROP TABLE IF EXISTS `survey_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `survey_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `seqno` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `question` text NOT NULL,
  `answers` text NOT NULL,
  `answer` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `survey_id` (`survey_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=346 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_details`
--

LOCK TABLES `survey_details` WRITE;
/*!40000 ALTER TABLE `survey_details` DISABLE KEYS */;
INSERT INTO `survey_details` VALUES (1,3,0,1,'Detail Bisnis','','','','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-21 22:14:21'),(2,3,1,1,'','Nama Perusahaan','','PT Markopelago','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:48:38','arif@markopelago.com','114.124.237.1','2018-06-23 14:48:38'),(3,3,1,2,'','Alamat Perusahaan','','Tangerang','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:48:38','arif@markopelago.com','114.124.237.1','2018-06-23 14:48:38'),(4,3,1,3,'','Posisi anda di perusahaan','','Manager','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:48:38','arif@markopelago.com','114.124.237.1','2018-06-23 14:48:38'),(5,3,1,4,'','Jenis Usaha','','IT','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:48:38','arif@markopelago.com','114.124.237.1','2018-06-23 14:48:38'),(6,3,1,5,'','Apa jenis produk anda?','','Software','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:48:38','arif@markopelago.com','114.124.237.1','2018-06-23 14:48:38'),(7,3,1,6,'','Apa Merk Produk anda?','','Markopelago.com','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:48:38','arif@markopelago.com','114.124.237.1','2018-06-23 14:48:38'),(8,3,1,7,'','Apakah usaha/bisnis anda dibawah PT atau CV?','','PT','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:48:38','arif@markopelago.com','114.124.237.1','2018-06-23 14:48:38'),(9,3,1,8,'','Alamat Website','','www.markopelago.com','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:48:38','arif@markopelago.com','114.124.237.1','2018-06-23 14:48:38'),(10,3,1,9,'','Bank yang digunakan perusahaan anda dalam bertransaksi','','mandiri','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:48:38','arif@markopelago.com','114.124.237.1','2018-06-23 14:48:38'),(11,3,1,10,'','Apakah perusahaan anda mendapatkan kredit/pembiayaan dari Bank/Badan lain?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:48:38','arif@markopelago.com','114.124.237.1','2018-06-23 14:48:38'),(12,3,1,11,'','Apakah anda bisa menjual produk anda hingga beberapa bulan kedepan dengan sistem kontrak?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:48:38','arif@markopelago.com','114.124.237.1','2018-06-23 14:48:38'),(13,3,1,12,'','Apakah produk anda tahan lama?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:48:38','arif@markopelago.com','114.124.237.1','2018-06-23 14:48:38'),(14,3,1,13,'','Apakah usaha anda memiliki akun Medsos (FB,Instagram dll)','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:48:38','arif@markopelago.com','114.124.237.1','2018-06-23 14:48:38'),(15,3,1,14,'','Apakah anda memberikan tempo kredit untuk customer anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:48:39','arif@markopelago.com','114.124.237.1','2018-06-23 14:48:39'),(16,3,1,15,'','Apakah anda memiliki teman yang bersedia menjadi seller/transporter di markopelago ?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:48:39','arif@markopelago.com','114.124.237.1','2018-06-23 14:48:39'),(17,3,0,2,'Pengalaman e-Commerce','','','','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-21 22:14:21'),(18,3,17,1,'','Apakah anda pernah mendengar tentang e-commerce/jual online sebelumnya?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:07','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:07'),(19,3,17,2,'','Apakah mudah  untuk menggunakan e-commerce/jual online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:07','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:07'),(20,3,17,3,'','Apakah anda pernah menjual melalui aplikasi Marketplace/Jual Beli online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:07','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:07'),(21,3,17,4,'','Apakah anda pernah membeli melalui aplikasi  Marketplace/Jual Beli online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:07','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:07'),(22,3,17,5,'','Apakah anda puas bertransaksi di aplikasi Marketplace/Jual Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:07','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:07'),(23,3,17,6,'','Apakah anda pernah menjual melalui Medsos; Medsos apa?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:07','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:07'),(24,3,17,7,'','Apakah anda pernah membeli melalui Medsos; Medsos apa?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:07','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:07'),(25,3,17,8,'','Apa aplikasi Jual Beli Online favorit anda?','','tokopedia.com','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:07','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:07'),(26,3,17,9,'','Sudah berapa lama usaha anda berjalan dan berkembang?','','5 tahun','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:07','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:07'),(27,3,17,10,'','Apakah anda memiliki karyawan?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:08','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:08'),(28,3,17,11,'','Apakah anda mau menjual di aplikasi Marketplace/Jual  Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:08','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:08'),(29,3,17,12,'','Apakah anda mau membeli di aplikasi Marketplace/Jual  Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:08','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:08'),(30,3,17,13,'','Apakah membeli dari aplikasi Marketplace/Jual Beli Online memberikan keuntungan bagi anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:08','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:08'),(31,3,17,14,'','Apakah menjual dari aplikasi Marketplace/Jual Beli Online memberikan keuntungan bagi anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:08','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:08'),(32,3,0,3,'Logistik dan Pengiriman','','','','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-21 22:14:21'),(33,3,32,1,'','Apakah bisnis anda memiliki gudang/tempat penyimpanan stok sendiri?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:13','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:13'),(34,3,32,2,'','Apabila tidak memiliki sendiri, apakah anda menyewanya?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:13','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:13'),(35,3,32,3,'','Apakah anda memiliki armada pengiriman sendiri?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:13','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:13'),(36,3,32,4,'','Apakah anda menggunakan jasa JNE, TIKI, J&T dll untuk pengiriman produk anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:13','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:13'),(37,3,32,5,'','Apakah anda menggunakan jasa truk/kereta/kapal laut  untuk pengiriman produk anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:13','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:13'),(38,3,32,6,'','Apakah anda memiliki langganan jasa trucking/pengangkutan produk anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:13','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:13'),(39,3,32,7,'','Apakah terkadang anda mengalami kesulitan dalam hal pengiriman dikarenakan tujuan tidak bisa dijangkau?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:13','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:13'),(40,3,32,8,'','Apakah pernah mendapatkan produk anda rusak selama pengiriman?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:13','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:13'),(41,3,32,9,'','Apakah pihak kurir/transporter mengganti kerugian tersebut?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:13','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:13'),(42,3,32,10,'','Apakah produk anda memerlukan perlakuan khusus selama delivery? Misal didinginkan, mudah pecah dll','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:13','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:13'),(43,3,32,11,'','Apakah jenis perlakuan khusus yang diperlukan?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-22 05:14:21','arif@markopelago.com','127.0.0.1','2018-06-23 09:49:14','arif@markopelago.com','114.124.207.17','2018-06-23 14:49:14'),(130,4,0,1,'Detail Bisnis','','','','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-23 22:59:48'),(131,4,130,1,'','Nama Perusahaan','','Fahmi Jaya','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-24 13:15:08','arif@markopelago.com','192.168.1.103','2018-06-24 06:15:08'),(132,4,130,2,'','Alamat Perusahaan','','Kp Pasir Awi','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-24 13:15:08','arif@markopelago.com','192.168.1.103','2018-06-24 06:15:08'),(133,4,130,3,'','Posisi anda di perusahaan','','Owner','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-24 13:15:08','arif@markopelago.com','192.168.1.103','2018-06-24 06:15:08'),(134,4,130,4,'','Jenis Usaha','','Jaket Kulit','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-24 13:15:08','arif@markopelago.com','192.168.1.103','2018-06-24 06:15:08'),(135,4,130,5,'','Apa jenis produk anda?','','Jaket Kulit dan aksesoris kulit','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-24 13:15:08','arif@markopelago.com','192.168.1.103','2018-06-24 06:15:08'),(136,4,130,6,'','Apa Merk Produk anda?','','Fahmi Jaya','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-24 13:15:08','arif@markopelago.com','192.168.1.103','2018-06-24 06:15:08'),(137,4,130,7,'','Apakah usaha/bisnis anda dibawah PT atau CV?','','PT','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-24 13:15:08','arif@markopelago.com','192.168.1.103','2018-06-24 06:15:08'),(138,4,130,8,'','Alamat Website','','','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-24 13:15:08','arif@markopelago.com','192.168.1.103','2018-06-24 06:15:08'),(139,4,130,9,'','Bank yang digunakan perusahaan anda dalam bertransaksi','','BRI','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-24 13:15:08','arif@markopelago.com','192.168.1.103','2018-06-24 06:15:08'),(140,4,130,10,'','Apakah perusahaan anda mendapatkan kredit/pembiayaan dari Bank/Badan lain?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-24 13:15:08','arif@markopelago.com','192.168.1.103','2018-06-24 06:15:08'),(141,4,130,11,'','Apakah anda bisa menjual produk anda hingga beberapa bulan kedepan dengan sistem kontrak?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-24 13:15:08','arif@markopelago.com','192.168.1.103','2018-06-24 06:15:08'),(142,4,130,12,'','Apakah produk anda tahan lama?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-24 13:15:08','arif@markopelago.com','192.168.1.103','2018-06-24 06:15:08'),(143,4,130,13,'','Apakah usaha anda memiliki akun Medsos (FB,Instagram dll)','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-24 13:15:08','arif@markopelago.com','192.168.1.103','2018-06-24 06:15:08'),(144,4,130,14,'','Apakah anda memberikan tempo kredit untuk customer anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-24 13:15:08','arif@markopelago.com','192.168.1.103','2018-06-24 06:15:08'),(145,4,130,15,'','Apakah anda memiliki teman yang bersedia menjadi seller/transporter di markopelago ?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-24 13:15:08','arif@markopelago.com','192.168.1.103','2018-06-24 06:15:08'),(146,4,0,2,'Pengalaman e-Commerce','','','','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-23 22:59:48'),(147,4,146,1,'','Apakah anda pernah mendengar tentang e-commerce/jual online sebelumnya?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:21','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:21'),(148,4,146,2,'','Apakah mudah  untuk menggunakan e-commerce/jual online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:21','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:21'),(149,4,146,3,'','Apakah anda pernah menjual melalui aplikasi Marketplace/Jual Beli online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:21','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:21'),(150,4,146,4,'','Apakah anda pernah membeli melalui aplikasi  Marketplace/Jual Beli online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:21','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:21'),(151,4,146,5,'','Apakah anda puas bertransaksi di aplikasi Marketplace/Jual Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 17:59:48','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:21','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:21'),(152,4,146,6,'','Apakah anda pernah menjual melalui Medsos; Medsos apa?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 17:59:49','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:21','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:21'),(153,4,146,7,'','Apakah anda pernah membeli melalui Medsos; Medsos apa?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 17:59:49','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:21','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:21'),(154,4,146,8,'','Apa aplikasi Jual Beli Online favorit anda?','','IG, FB','2018-06-23 17:59:49','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:21','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:21'),(155,4,146,9,'','Sudah berapa lama usaha anda berjalan dan berkembang?','','16 tahun','2018-06-23 17:59:49','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:21','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:21'),(156,4,146,10,'','Apakah anda memiliki karyawan?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 17:59:49','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:22','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:22'),(157,4,146,11,'','Apakah anda mau menjual di aplikasi Marketplace/Jual  Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 17:59:49','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:22','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:22'),(158,4,146,12,'','Apakah anda mau membeli di aplikasi Marketplace/Jual  Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 17:59:49','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:22','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:22'),(159,4,146,13,'','Apakah membeli dari aplikasi Marketplace/Jual Beli Online memberikan keuntungan bagi anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 17:59:49','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:22','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:22'),(160,4,146,14,'','Apakah menjual dari aplikasi Marketplace/Jual Beli Online memberikan keuntungan bagi anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 17:59:49','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:22','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:22'),(161,4,0,3,'Logistik dan Pengiriman','','','','2018-06-23 17:59:49','arif@markopelago.com','111.95.48.124','2018-06-23 17:59:49','arif@markopelago.com','111.95.48.124','2018-06-23 22:59:49'),(162,4,161,1,'','Apakah bisnis anda memiliki gudang/tempat penyimpanan stok sendiri?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 17:59:49','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:28','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:28'),(163,4,161,2,'','Apabila tidak memiliki sendiri, apakah anda menyewanya?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-23 17:59:49','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:28','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:28'),(164,4,161,3,'','Apakah anda memiliki armada pengiriman sendiri?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-23 17:59:49','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:28','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:28'),(165,4,161,4,'','Apakah anda menggunakan jasa JNE, TIKI, J&T dll untuk pengiriman produk anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 17:59:49','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:28','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:28'),(166,4,161,5,'','Apakah anda menggunakan jasa truk/kereta/kapal laut  untuk pengiriman produk anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 17:59:49','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:28','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:28'),(167,4,161,6,'','Apakah anda memiliki langganan jasa trucking/pengangkutan produk anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 17:59:49','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:28','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:28'),(168,4,161,7,'','Apakah terkadang anda mengalami kesulitan dalam hal pengiriman dikarenakan tujuan tidak bisa dijangkau?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 17:59:49','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:28','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:28'),(169,4,161,8,'','Apakah pernah mendapatkan produk anda rusak selama pengiriman?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-23 17:59:49','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:28','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:28'),(170,4,161,9,'','Apakah pihak kurir/transporter mengganti kerugian tersebut?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-23 17:59:49','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:28','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:28'),(171,4,161,10,'','Apakah produk anda memerlukan perlakuan khusus selama delivery? Misal didinginkan, mudah pecah dll','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-23 17:59:49','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:28','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:28'),(172,4,161,11,'','Apakah jenis perlakuan khusus yang diperlukan?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-23 17:59:49','arif@markopelago.com','111.95.48.124','2018-06-23 18:05:28','arif@markopelago.com','111.95.48.124','2018-06-23 23:05:28'),(173,6,0,1,'Detail Bisnis','','','','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-23 23:09:30'),(174,6,173,1,'','Nama Perusahaan','','aziz bike shop','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:11:47','arif@markopelago.com','192.168.1.103','2018-06-24 06:11:47'),(175,6,173,2,'','Alamat Perusahaan','','kp tegal parung','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:11:47','arif@markopelago.com','192.168.1.103','2018-06-24 06:11:47'),(176,6,173,3,'','Lama berdiri (thn)','','3','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:11:47','arif@markopelago.com','192.168.1.103','2018-06-24 06:11:47'),(177,6,173,4,'','Posisi anda di perusahaan','','owner','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:11:47','arif@markopelago.com','192.168.1.103','2018-06-24 06:11:47'),(178,6,173,5,'','Jenis Usaha','','sparepart sepeda','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:11:47','arif@markopelago.com','192.168.1.103','2018-06-24 06:11:47'),(179,6,173,6,'','Apakah usaha/bisnis anda dibawah PT atau CV?','','cv','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:11:47','arif@markopelago.com','192.168.1.103','2018-06-24 06:11:47'),(180,6,173,7,'','Alamat Website','','','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:11:47','arif@markopelago.com','192.168.1.103','2018-06-24 06:11:47'),(181,6,173,8,'','Bank yang digunakan perusahaan anda dalam bertransaksi','','BRI, Cimb niaga','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:11:47','arif@markopelago.com','192.168.1.103','2018-06-24 06:11:47'),(182,6,173,9,'','Total Armada yang anda miliki','','10','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:11:47','arif@markopelago.com','192.168.1.103','2018-06-24 06:11:47'),(183,6,173,10,'','Jenis-jenis armada anda (Bisa lebih dari 1)','','picup','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:11:47','arif@markopelago.com','192.168.1.103','2018-06-24 06:11:47'),(184,6,173,11,'','Jangkauan Pelayanan (Kota, bisa lebih dari 1)','','surabaya','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:11:47','arif@markopelago.com','192.168.1.103','2018-06-24 06:11:47'),(185,6,173,12,'','Lokasi Pool (Kota, Bisa lebih dari 1)','','garut','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:11:47','arif@markopelago.com','192.168.1.103','2018-06-24 06:11:47'),(186,6,173,13,'','Apakah perusahaan anda mendapatkan kredit/pembiayaan dari Bank/Badan lain?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:11:47','arif@markopelago.com','192.168.1.103','2018-06-24 06:11:47'),(187,6,173,14,'','Apakah anda bisa menjual produk anda hingga beberapa bulan kedepan dengan sistem kontrak?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:11:47','arif@markopelago.com','192.168.1.103','2018-06-24 06:11:47'),(188,6,173,15,'','Apakah usaha anda memiliki akun Medsos (FB,Instagram dll)','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:11:47','arif@markopelago.com','192.168.1.103','2018-06-24 06:11:47'),(189,6,173,16,'','Apakah anda memberikan tempo kredit untuk customer anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:11:47','arif@markopelago.com','192.168.1.103','2018-06-24 06:11:47'),(190,6,173,17,'','Apakah anda dapat memberikan rate/harga untuk ke masing-masing kota tujuan?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:11:47','arif@markopelago.com','192.168.1.103','2018-06-24 06:11:47'),(191,6,173,18,'','Bila tidak, Bersediakah anda jika markopelago memberikan rekomendasi rate/harga ?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:11:47','arif@markopelago.com','192.168.1.103','2018-06-24 06:11:47'),(192,6,173,19,'','Bersediakah anda menjadi bundling transportasi dari setiap seller yang telah direkomendasikan ?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:11:47','arif@markopelago.com','192.168.1.103','2018-06-24 06:11:47'),(193,6,173,20,'','Apakah anda memiliki teman yang bersedia menjadi seller/transporter di markopelago ?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:11:47','arif@markopelago.com','192.168.1.103','2018-06-24 06:11:47'),(194,6,0,2,'Pengalaman e-Commerce','','','','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-23 23:09:30'),(195,6,194,1,'','Apakah anda pernah mendengar tentang e-commerce/jual online sebelumnya?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:12:46','arif@markopelago.com','192.168.1.103','2018-06-24 06:12:46'),(196,6,194,2,'','Apakah mudah  untuk menggunakan e-commerce/jual online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:12:46','arif@markopelago.com','192.168.1.103','2018-06-24 06:12:46'),(197,6,194,3,'','Apakah anda pernah menjual melalui aplikasi Marketplace/Jual Beli online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:12:46','arif@markopelago.com','192.168.1.103','2018-06-24 06:12:46'),(198,6,194,4,'','Apakah anda pernah membeli melalui aplikasi  Marketplace/Jual Beli online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:12:46','arif@markopelago.com','192.168.1.103','2018-06-24 06:12:46'),(199,6,194,5,'','Apakah anda puas bertransaksi di aplikasi Marketplace/Jual Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:12:46','arif@markopelago.com','192.168.1.103','2018-06-24 06:12:46'),(200,6,194,6,'','Apakah anda pernah menjual melalui Medsos; Medsos apa?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:12:46','arif@markopelago.com','192.168.1.103','2018-06-24 06:12:46'),(201,6,194,7,'','Apakah anda pernah membeli melalui Medsos; Medsos apa?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:12:46','arif@markopelago.com','192.168.1.103','2018-06-24 06:12:46'),(202,6,194,8,'','Apa aplikasi Jual Beli Online favorit anda?','','IG, FB','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:12:46','arif@markopelago.com','192.168.1.103','2018-06-24 06:12:46'),(203,6,194,9,'','Apakah anda memiliki karyawan?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:12:46','arif@markopelago.com','192.168.1.103','2018-06-24 06:12:46'),(204,6,194,10,'','Apakah anda mau menjadi partner transportasi di aplikasi Marketplace/Jual  Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:12:46','arif@markopelago.com','192.168.1.103','2018-06-24 06:12:46'),(205,6,194,11,'','Apakah anda mau membeli di aplikasi Marketplace/Jual  Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:12:46','arif@markopelago.com','192.168.1.103','2018-06-24 06:12:46'),(206,6,194,12,'','Apakah membeli dari aplikasi Marketplace/Jual Beli Online memberikan keuntungan bagi anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:12:46','arif@markopelago.com','192.168.1.103','2018-06-24 06:12:46'),(207,6,194,13,'','Apakah menjadi partner transportasi dari aplikasi Marketplace/Jual Beli Online memberikan keuntungan bagi anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:12:46','arif@markopelago.com','192.168.1.103','2018-06-24 06:12:46'),(208,6,0,3,'Logistik dan Pengiriman','','','','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-23 23:09:30'),(209,6,208,1,'','Apakah anda memiliki pelanggan yang sudah terpercaya ?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:12:52','arif@markopelago.com','192.168.1.103','2018-06-24 06:12:52'),(210,6,208,2,'','Apakah produk yang anda kirim pernah rusak selama perjalanan ?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 18:09:31','arif@markopelago.com','114.124.132.109','2018-06-24 13:12:52','arif@markopelago.com','192.168.1.103','2018-06-24 06:12:52'),(211,6,208,3,'','Apakah anda mengganti kerugian tersebut?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-23 18:09:31','arif@markopelago.com','114.124.132.109','2018-06-24 13:12:52','arif@markopelago.com','192.168.1.103','2018-06-24 06:12:52'),(212,6,208,4,'','Apakah armada anda hanya melayani pengiriman khusus ? Contoh : Ayam, Es, Barang pecah belah,\r\njika iya, apakah itu ?','','telur','2018-06-23 18:09:31','arif@markopelago.com','114.124.132.109','2018-06-24 13:12:52','arif@markopelago.com','192.168.1.103','2018-06-24 06:12:52'),(213,7,0,1,'Detail Bisnis','','','','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 06:24:35'),(214,7,213,1,'','Nama Perusahaan','','pt abc','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:11','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:11'),(215,7,213,2,'','Alamat Perusahaan','','tangerang','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:11','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:11'),(216,7,213,3,'','Posisi anda di perusahaan','','manager','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:11','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:11'),(217,7,213,4,'','Jenis Usaha','','kecap','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:11','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:11'),(218,7,213,5,'','Apa jenis produk anda?','','saos','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:11','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:11'),(219,7,213,6,'','Apa Merk Produk anda?','','abc','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:11','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:11'),(220,7,213,7,'','Apakah usaha/bisnis anda dibawah PT atau CV?','','cv','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:11','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:11'),(221,7,213,8,'','Alamat Website','','','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:11','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:11'),(222,7,213,9,'','Bank yang digunakan perusahaan anda dalam bertransaksi','','bri','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:11','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:11'),(223,7,213,10,'','Apakah perusahaan anda mendapatkan kredit/pembiayaan dari Bank/Badan lain?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:11','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:11'),(224,7,213,11,'','Apakah anda bisa menjual produk anda hingga beberapa bulan kedepan dengan sistem kontrak?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:11','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:11'),(225,7,213,12,'','Apakah produk anda tahan lama?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:11','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:11'),(226,7,213,13,'','Apakah usaha anda memiliki akun Medsos (FB,Instagram dll)','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:11','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:11'),(227,7,213,14,'','Apakah anda memberikan tempo kredit untuk customer anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:11','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:11'),(228,7,213,15,'','Apakah anda memiliki teman yang bersedia menjadi seller/transporter di markopelago ?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:11','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:11'),(229,7,0,2,'Pengalaman e-Commerce','','','','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 06:24:35'),(230,7,229,1,'','Apakah anda pernah mendengar tentang e-commerce/jual online sebelumnya?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:32','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:32'),(231,7,229,2,'','Apakah mudah  untuk menggunakan e-commerce/jual online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:32','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:32'),(232,7,229,3,'','Apakah anda pernah menjual melalui aplikasi Marketplace/Jual Beli online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:32','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:32'),(233,7,229,4,'','Apakah anda pernah membeli melalui aplikasi  Marketplace/Jual Beli online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:32','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:32'),(234,7,229,5,'','Apakah anda puas bertransaksi di aplikasi Marketplace/Jual Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:32','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:32'),(235,7,229,6,'','Apakah anda pernah menjual melalui Medsos; Medsos apa?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:32','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:32'),(236,7,229,7,'','Apakah anda pernah membeli melalui Medsos; Medsos apa?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:32','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:32'),(237,7,229,8,'','Apa aplikasi Jual Beli Online favorit anda?','','ig','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:32','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:32'),(238,7,229,9,'','Sudah berapa lama usaha anda berjalan dan berkembang?','','15 tahun','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:32','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:32'),(239,7,229,10,'','Apakah anda memiliki karyawan?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:32','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:32'),(240,7,229,11,'','Apakah anda mau menjual di aplikasi Marketplace/Jual  Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:32','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:32'),(241,7,229,12,'','Apakah anda mau membeli di aplikasi Marketplace/Jual  Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:32','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:32'),(242,7,229,13,'','Apakah membeli dari aplikasi Marketplace/Jual Beli Online memberikan keuntungan bagi anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:32','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:32'),(243,7,229,14,'','Apakah menjual dari aplikasi Marketplace/Jual Beli Online memberikan keuntungan bagi anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:32','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:32'),(244,7,0,3,'Logistik dan Pengiriman','','','','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 06:24:35'),(245,7,244,1,'','Apakah bisnis anda memiliki gudang/tempat penyimpanan stok sendiri?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:45','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:45'),(246,7,244,2,'','Apabila tidak memiliki sendiri, apakah anda menyewanya?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:45','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:45'),(247,7,244,3,'','Apakah anda memiliki armada pengiriman sendiri?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:45','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:45'),(248,7,244,4,'','Apakah anda menggunakan jasa JNE, TIKI, J&T dll untuk pengiriman produk anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:45','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:45'),(249,7,244,5,'','Apakah anda menggunakan jasa truk/kereta/kapal laut  untuk pengiriman produk anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:45','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:45'),(250,7,244,6,'','Apakah anda memiliki langganan jasa trucking/pengangkutan produk anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:45','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:45'),(251,7,244,7,'','Apakah terkadang anda mengalami kesulitan dalam hal pengiriman dikarenakan tujuan tidak bisa dijangkau?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:45','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:45'),(252,7,244,8,'','Apakah pernah mendapatkan produk anda rusak selama pengiriman?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:45','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:45'),(253,7,244,9,'','Apakah pihak kurir/transporter mengganti kerugian tersebut?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:45','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:45'),(254,7,244,10,'','Apakah produk anda memerlukan perlakuan khusus selama delivery? Misal didinginkan, mudah pecah dll','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:45','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:45'),(255,7,244,11,'','Apakah jenis perlakuan khusus yang diperlukan?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:27:45','arif@markopelago.com','192.168.1.103','2018-06-24 06:27:45'),(256,8,0,1,'Detail Bisnis','','','','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-25 22:17:04'),(257,8,256,1,'','Nama Perusahaan','','Nama Perusahaan','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:20','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:20'),(258,8,256,2,'','Alamat Perusahaan','','Alamat Perusahaan','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:20','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:20'),(259,8,256,3,'','Posisi anda di perusahaan','','Posisi','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:20','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:20'),(260,8,256,4,'','Jenis Usaha','','Jenis Usaha','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:20','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:20'),(261,8,256,5,'','Apa jenis produk anda?','','Jenis Produk','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:20','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:20'),(262,8,256,6,'','Apa Merk Produk anda?','','MErk','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:20','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:20'),(263,8,256,7,'','Apakah usaha/bisnis anda dibawah PT atau CV?','','PT','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:20','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:20'),(264,8,256,8,'','Alamat Website','','Website','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:20','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:20'),(265,8,256,9,'','Bank yang digunakan perusahaan anda dalam bertransaksi','','BRI','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:20','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:20'),(266,8,256,10,'','Apakah perusahaan anda mendapatkan kredit/pembiayaan dari Bank/Badan lain?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:20','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:20'),(267,8,256,11,'','Apakah anda bisa menjual produk anda hingga beberapa bulan kedepan dengan sistem kontrak?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:20','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:20'),(268,8,256,12,'','Apakah produk anda tahan lama?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:20','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:20'),(269,8,256,13,'','Apakah usaha anda memiliki akun Medsos (FB,Instagram dll)','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:20','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:20'),(270,8,256,14,'','Apakah anda memberikan tempo kredit untuk customer anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:20','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:20'),(271,8,256,15,'','Apakah anda memiliki teman yang bersedia menjadi seller/transporter di markopelago ?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:20','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:20'),(272,8,0,2,'Pengalaman e-Commerce','','','','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-25 22:17:04'),(273,8,272,1,'','Apakah anda pernah mendengar tentang e-commerce/jual online sebelumnya?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:22','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:22'),(274,8,272,2,'','Apakah mudah  untuk menggunakan e-commerce/jual online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:22','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:22'),(275,8,272,3,'','Apakah anda pernah menjual melalui aplikasi Marketplace/Jual Beli online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:22','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:22'),(276,8,272,4,'','Apakah anda pernah membeli melalui aplikasi  Marketplace/Jual Beli online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:22','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:22'),(277,8,272,5,'','Apakah anda puas bertransaksi di aplikasi Marketplace/Jual Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:22','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:22'),(278,8,272,6,'','Apakah anda pernah menjual melalui Medsos; Medsos apa?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:22','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:22'),(279,8,272,7,'','Apakah anda pernah membeli melalui Medsos; Medsos apa?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:22','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:22'),(280,8,272,8,'','Apa aplikasi Jual Beli Online favorit anda?','','FG,IG','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:22','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:22'),(281,8,272,9,'','Sudah berapa lama usaha anda berjalan dan berkembang?','','15 Tahun','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:22','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:22'),(282,8,272,10,'','Apakah anda memiliki karyawan?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:22','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:22'),(283,8,272,11,'','Apakah anda mau menjual di aplikasi Marketplace/Jual  Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:22','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:22'),(284,8,272,12,'','Apakah anda mau membeli di aplikasi Marketplace/Jual  Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:22','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:22'),(285,8,272,13,'','Apakah membeli dari aplikasi Marketplace/Jual Beli Online memberikan keuntungan bagi anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:22','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:22'),(286,8,272,14,'','Apakah menjual dari aplikasi Marketplace/Jual Beli Online memberikan keuntungan bagi anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:22','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:22'),(287,8,0,3,'Logistik dan Pengiriman','','','','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-25 22:17:04'),(288,8,287,1,'','Apakah bisnis anda memiliki gudang/tempat penyimpanan stok sendiri?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:24','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:24'),(289,8,287,2,'','Apabila tidak memiliki sendiri, apakah anda menyewanya?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:24','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:24'),(290,8,287,3,'','Apakah anda memiliki armada pengiriman sendiri?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:24','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:24'),(291,8,287,4,'','Apakah anda menggunakan jasa JNE, TIKI, J&T dll untuk pengiriman produk anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:24','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:24'),(292,8,287,5,'','Apakah anda menggunakan jasa truk/kereta/kapal laut  untuk pengiriman produk anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:24','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:24'),(293,8,287,6,'','Apakah anda memiliki langganan jasa trucking/pengangkutan produk anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:24','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:24'),(294,8,287,7,'','Apakah terkadang anda mengalami kesulitan dalam hal pengiriman dikarenakan tujuan tidak bisa dijangkau?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:24','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:24'),(295,8,287,8,'','Apakah pernah mendapatkan produk anda rusak selama pengiriman?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:24','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:24'),(296,8,287,9,'','Apakah pihak kurir/transporter mengganti kerugian tersebut?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:24','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:24'),(297,8,287,10,'','Apakah produk anda memerlukan perlakuan khusus selama delivery? Misal didinginkan, mudah pecah dll','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','2','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:24','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:24'),(298,8,287,11,'','Apakah jenis perlakuan khusus yang diperlukan?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','1','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:24','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:24'),(299,8,0,4,'Info Tambahan','','','','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-25 22:17:04'),(300,8,299,1,'','','','Info Tambahan\r\ndjgkladsjgfklasd\r\ndnkjadfsjgknafdslk\r\nsdnfjkangkjnfad','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:02','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:02'),(301,9,0,1,'Detail Bisnis','','','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(302,9,301,1,'','Nama Perusahaan','','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(303,9,301,2,'','Alamat Perusahaan','','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(304,9,301,3,'','Posisi anda di perusahaan','','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(305,9,301,4,'','Jenis Usaha','','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(306,9,301,5,'','Apa jenis produk anda?','','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(307,9,301,6,'','Apa Merk Produk anda?','','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(308,9,301,7,'','Apakah usaha/bisnis anda dibawah PT atau CV?','','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(309,9,301,8,'','Alamat Website','','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(310,9,301,9,'','Bank yang digunakan perusahaan anda dalam bertransaksi','','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(311,9,301,10,'','Apakah perusahaan anda mendapatkan kredit/pembiayaan dari Bank/Badan lain?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(312,9,301,11,'','Apakah anda bisa menjual produk anda hingga beberapa bulan kedepan dengan sistem kontrak?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(313,9,301,12,'','Apakah produk anda tahan lama?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(314,9,301,13,'','Apakah usaha anda memiliki akun Medsos (FB,Instagram dll)','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(315,9,301,14,'','Apakah anda memberikan tempo kredit untuk customer anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(316,9,301,15,'','Apakah anda memiliki teman yang bersedia menjadi seller/transporter di markopelago ?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(317,9,0,2,'Pengalaman e-Commerce','','','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(318,9,317,1,'','Apakah anda pernah mendengar tentang e-commerce/jual online sebelumnya?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(319,9,317,2,'','Apakah mudah  untuk menggunakan e-commerce/jual online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(320,9,317,3,'','Apakah anda pernah menjual melalui aplikasi Marketplace/Jual Beli online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(321,9,317,4,'','Apakah anda pernah membeli melalui aplikasi  Marketplace/Jual Beli online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(322,9,317,5,'','Apakah anda puas bertransaksi di aplikasi Marketplace/Jual Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(323,9,317,6,'','Apakah anda pernah menjual melalui Medsos; Medsos apa?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(324,9,317,7,'','Apakah anda pernah membeli melalui Medsos; Medsos apa?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(325,9,317,8,'','Apa aplikasi Jual Beli Online favorit anda?','','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(326,9,317,9,'','Sudah berapa lama usaha anda berjalan dan berkembang?','','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(327,9,317,10,'','Apakah anda memiliki karyawan?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(328,9,317,11,'','Apakah anda mau menjual di aplikasi Marketplace/Jual  Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(329,9,317,12,'','Apakah anda mau membeli di aplikasi Marketplace/Jual  Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(330,9,317,13,'','Apakah membeli dari aplikasi Marketplace/Jual Beli Online memberikan keuntungan bagi anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(331,9,317,14,'','Apakah menjual dari aplikasi Marketplace/Jual Beli Online memberikan keuntungan bagi anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(332,9,0,3,'Logistik dan Pengiriman','','','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(333,9,332,1,'','Apakah bisnis anda memiliki gudang/tempat penyimpanan stok sendiri?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(334,9,332,2,'','Apabila tidak memiliki sendiri, apakah anda menyewanya?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(335,9,332,3,'','Apakah anda memiliki armada pengiriman sendiri?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(336,9,332,4,'','Apakah anda menggunakan jasa JNE, TIKI, J&T dll untuk pengiriman produk anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(337,9,332,5,'','Apakah anda menggunakan jasa truk/kereta/kapal laut  untuk pengiriman produk anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(338,9,332,6,'','Apakah anda memiliki langganan jasa trucking/pengangkutan produk anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(339,9,332,7,'','Apakah terkadang anda mengalami kesulitan dalam hal pengiriman dikarenakan tujuan tidak bisa dijangkau?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(340,9,332,8,'','Apakah pernah mendapatkan produk anda rusak selama pengiriman?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(341,9,332,9,'','Apakah pihak kurir/transporter mengganti kerugian tersebut?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(342,9,332,10,'','Apakah produk anda memerlukan perlakuan khusus selama delivery? Misal didinginkan, mudah pecah dll','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(343,9,332,11,'','Apakah jenis perlakuan khusus yang diperlukan?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(344,9,0,4,'Info Tambahan','','','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04'),(345,9,344,1,'','','','','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 20:04:04','superuser','127.0.0.1','2018-06-30 13:04:04');
/*!40000 ALTER TABLE `survey_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `survey_photos`
--

DROP TABLE IF EXISTS `survey_photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `survey_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_id` int(11) NOT NULL,
  `seqno` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `caption` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `survey_id` (`survey_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_photos`
--

LOCK TABLES `survey_photos` WRITE;
/*!40000 ALTER TABLE `survey_photos` DISABLE KEYS */;
INSERT INTO `survey_photos` VALUES (27,3,1,'8086ROLUP1H9U9MV0UZ4MLW63_3.jpg','test 1234','2018-06-22 22:52:56','arif@markopelago.com','111.95.48.124','2018-06-22 22:55:09','arif@markopelago.com','111.95.48.124','2018-06-23 03:55:09'),(28,3,1,'Y09E00K93JJ5LG3F148NVR8H5_3.jpg','jam tangan','2018-06-23 09:37:37','arif@markopelago.com','111.95.48.124','2018-06-24 06:42:44','arif@markopelago.com','127.0.0.1','2018-06-23 23:42:44'),(31,4,1,'210858PM90S767O1K84O15H13_3.jpg','produk 1','2018-06-23 18:06:00','arif@markopelago.com','111.95.48.124','2018-06-23 18:06:12','arif@markopelago.com','111.95.48.124','2018-06-23 23:06:12'),(32,4,1,'L5331J8123M2LG10NQT1QY963_3.jpg','warung','2018-06-23 18:07:22','arif@markopelago.com','114.124.165.252','2018-06-24 06:42:44','arif@markopelago.com','127.0.0.1','2018-06-23 23:42:44'),(33,6,1,'DX53Y072ML1Z7RIY5LTH27UR1_3.jpg','mas bas','2018-06-24 13:13:11','arif@markopelago.com','192.168.1.103','2018-06-24 13:13:52','arif@markopelago.com','192.168.1.103','2018-06-24 06:13:52'),(34,7,1,'LU8BR4S9PG682S138310C342W_3.jpg','lokasi kerja','2018-06-24 13:28:29','arif@markopelago.com','192.168.1.103','2018-06-24 13:29:05','arif@markopelago.com','192.168.1.103','2018-06-24 06:29:05'),(35,8,1,'OZ8KS8947LT3HD77MGL93DPL2_3.jpg','','2018-06-26 05:19:11','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:11','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:11');
/*!40000 ALTER TABLE `survey_photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `survey_template_details`
--

DROP TABLE IF EXISTS `survey_template_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `survey_template_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_template_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `seqno` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `question` text NOT NULL,
  `answers` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `survey_template_id` (`survey_template_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_template_details`
--

LOCK TABLES `survey_template_details` WRITE;
/*!40000 ALTER TABLE `survey_template_details` DISABLE KEYS */;
INSERT INTO `survey_template_details` VALUES (1,1,0,1,'Detail Bisnis','','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(2,1,1,1,'','Nama Perusahaan','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(3,1,1,2,'','Alamat Perusahaan','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(4,1,1,3,'','Posisi anda di perusahaan','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(5,1,1,4,'','Jenis Usaha','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(6,1,1,5,'','Apa jenis produk anda?','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(7,1,1,6,'','Apa Merk Produk anda?','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(8,1,1,7,'','Apakah usaha/bisnis anda dibawah PT atau CV?','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(9,1,1,8,'','Alamat Website','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(10,1,1,9,'','Bank yang digunakan perusahaan anda dalam bertransaksi','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(11,1,1,10,'','Apakah perusahaan anda mendapatkan kredit/pembiayaan dari Bank/Badan lain?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:08'),(12,1,1,11,'','Apakah anda bisa menjual produk anda hingga beberapa bulan kedepan dengan sistem kontrak?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:10'),(13,1,1,12,'','Apakah produk anda tahan lama?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:11'),(14,1,1,13,'','Apakah usaha anda memiliki akun Medsos (FB,Instagram dll)','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:13'),(15,1,1,14,'','Apakah anda memberikan tempo kredit untuk customer anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:14'),(16,1,1,15,'','Apakah anda memiliki teman yang bersedia menjadi seller/transporter di markopelago ?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:26'),(17,1,0,2,'Pengalaman e-Commerce','','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:58'),(18,1,17,1,'','Apakah anda pernah mendengar tentang e-commerce/jual online sebelumnya?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:28'),(19,1,17,2,'','Apakah mudah  untuk menggunakan e-commerce/jual online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:29'),(20,1,17,3,'','Apakah anda pernah menjual melalui aplikasi Marketplace/Jual Beli online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:30'),(21,1,17,4,'','Apakah anda pernah membeli melalui aplikasi  Marketplace/Jual Beli online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:31'),(22,1,17,5,'','Apakah anda puas bertransaksi di aplikasi Marketplace/Jual Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:33'),(23,1,17,6,'','Apakah anda pernah menjual melalui Medsos; Medsos apa?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:34'),(24,1,17,7,'','Apakah anda pernah membeli melalui Medsos; Medsos apa?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:43'),(25,1,17,8,'','Apa aplikasi Jual Beli Online favorit anda?','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(26,1,17,9,'','Sudah berapa lama usaha anda berjalan dan berkembang?','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(27,1,17,10,'','Apakah anda memiliki karyawan?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:44'),(28,1,17,11,'','Apakah anda mau menjual di aplikasi Marketplace/Jual  Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:45'),(29,1,17,12,'','Apakah anda mau membeli di aplikasi Marketplace/Jual  Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:46'),(30,1,17,13,'','Apakah membeli dari aplikasi Marketplace/Jual Beli Online memberikan keuntungan bagi anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:47'),(31,1,17,14,'','Apakah menjual dari aplikasi Marketplace/Jual Beli Online memberikan keuntungan bagi anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:56'),(32,1,0,3,'Logistik dan Pengiriman','','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:03:03'),(33,1,32,1,'','Apakah bisnis anda memiliki gudang/tempat penyimpanan stok sendiri?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:58'),(34,1,32,2,'','Apabila tidak memiliki sendiri, apakah anda menyewanya?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:59'),(35,1,32,3,'','Apakah anda memiliki armada pengiriman sendiri?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:10:00'),(36,1,32,4,'','Apakah anda menggunakan jasa JNE, TIKI, J&T dll untuk pengiriman produk anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:10:01'),(37,1,32,5,'','Apakah anda menggunakan jasa truk/kereta/kapal laut  untuk pengiriman produk anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:10:03'),(38,1,32,6,'','Apakah anda memiliki langganan jasa trucking/pengangkutan produk anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:10:03'),(39,1,32,7,'','Apakah terkadang anda mengalami kesulitan dalam hal pengiriman dikarenakan tujuan tidak bisa dijangkau?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:10:04'),(40,1,32,8,'','Apakah pernah mendapatkan produk anda rusak selama pengiriman?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:10:05'),(41,1,32,9,'','Apakah pihak kurir/transporter mengganti kerugian tersebut?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:10:06'),(42,1,32,10,'','Apakah produk anda memerlukan perlakuan khusus selama delivery? Misal didinginkan, mudah pecah dll','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:10:08'),(43,1,32,11,'','Apakah jenis perlakuan khusus yang diperlukan?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:10:09'),(44,2,0,1,'Detail Bisnis','','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(45,2,44,1,'','Nama Perusahaan','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(46,2,44,2,'','Alamat Perusahaan','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(47,2,44,3,'','Lama berdiri (thn)','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(48,2,44,4,'','Posisi anda di perusahaan','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(49,2,44,5,'','Jenis Usaha','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(50,2,44,6,'','Apakah usaha/bisnis anda dibawah PT atau CV?','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(51,2,44,7,'','Alamat Website','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(52,2,44,8,'','Bank yang digunakan perusahaan anda dalam bertransaksi','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(53,2,44,9,'','Total Armada yang anda miliki','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(54,2,44,10,'','Jenis-jenis armada anda (Bisa lebih dari 1)','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(55,2,44,11,'','Jangkauan Pelayanan (Kota, bisa lebih dari 1)','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(56,2,44,12,'','Lokasi Pool (Kota, Bisa lebih dari 1)','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(57,2,44,13,'','Apakah perusahaan anda mendapatkan kredit/pembiayaan dari Bank/Badan lain?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:26:51'),(58,2,44,14,'','Apakah anda bisa menjual produk anda hingga beberapa bulan kedepan dengan sistem kontrak?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:26:56'),(59,2,44,15,'','Apakah usaha anda memiliki akun Medsos (FB,Instagram dll)','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:26:58'),(60,2,44,16,'','Apakah anda memberikan tempo kredit untuk customer anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:26:59'),(61,2,44,17,'','Apakah anda dapat memberikan rate/harga untuk ke masing-masing kota tujuan?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:00'),(62,2,44,18,'','Bila tidak, Bersediakah anda jika markopelago memberikan rekomendasi rate/harga ?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:01'),(63,2,44,19,'','Bersediakah anda menjadi bundling transportasi dari setiap seller yang telah direkomendasikan ?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:02'),(64,2,44,20,'','Apakah anda memiliki teman yang bersedia menjadi seller/transporter di markopelago ?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:13'),(65,2,0,2,'Pengalaman e-Commerce','','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(66,2,65,1,'','Apakah anda pernah mendengar tentang e-commerce/jual online sebelumnya?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:14'),(67,2,65,2,'','Apakah mudah  untuk menggunakan e-commerce/jual online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:15'),(68,2,65,3,'','Apakah anda pernah menjual melalui aplikasi Marketplace/Jual Beli online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:16'),(69,2,65,4,'','Apakah anda pernah membeli melalui aplikasi  Marketplace/Jual Beli online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:17'),(70,2,65,5,'','Apakah anda puas bertransaksi di aplikasi Marketplace/Jual Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:18'),(71,2,65,6,'','Apakah anda pernah menjual melalui Medsos; Medsos apa?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:20'),(72,2,65,7,'','Apakah anda pernah membeli melalui Medsos; Medsos apa?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:24'),(73,2,65,8,'','Apa aplikasi Jual Beli Online favorit anda?','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(74,2,65,9,'','Apakah anda memiliki karyawan?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:25'),(75,2,65,10,'','Apakah anda mau menjadi partner transportasi di aplikasi Marketplace/Jual  Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:26'),(76,2,65,11,'','Apakah anda mau membeli di aplikasi Marketplace/Jual  Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:28'),(77,2,65,12,'','Apakah membeli dari aplikasi Marketplace/Jual Beli Online memberikan keuntungan bagi anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:30'),(78,2,65,13,'','Apakah menjadi partner transportasi dari aplikasi Marketplace/Jual Beli Online memberikan keuntungan bagi anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:39'),(79,2,0,3,'Logistik dan Pengiriman','','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(80,2,79,1,'','Apakah anda memiliki pelanggan yang sudah terpercaya ?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:40'),(81,2,79,2,'','Apakah produk yang anda kirim pernah rusak selama perjalanan ?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:41'),(82,2,79,3,'','Apakah anda mengganti kerugian tersebut?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:42'),(83,2,79,4,'','Apakah armada anda hanya melayani pengiriman khusus ? Contoh : Ayam, Es, Barang pecah belah,\r\njika iya, apakah itu ?','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(84,1,0,4,'Info Tambahan','','',NULL,'',NULL,NULL,'',NULL,'2018-06-25 22:15:57'),(85,1,84,1,'','','',NULL,'',NULL,NULL,'',NULL,'2018-06-25 22:15:57');
/*!40000 ALTER TABLE `survey_template_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `survey_templates`
--

DROP TABLE IF EXISTS `survey_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `survey_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_templates`
--

LOCK TABLES `survey_templates` WRITE;
/*!40000 ALTER TABLE `survey_templates` DISABLE KEYS */;
INSERT INTO `survey_templates` VALUES (1,'Penjual',NULL,'',NULL,NULL,'',NULL,'2018-06-20 14:13:04'),(2,'Ekspeditur',NULL,'',NULL,NULL,'',NULL,'2018-06-20 14:13:24');
/*!40000 ALTER TABLE `survey_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surveys`
--

DROP TABLE IF EXISTS `surveys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `surveys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `survey_template_id` int(11) NOT NULL,
  `survey_name` varchar(100) NOT NULL,
  `surveyed_at` date NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `location_id` int(11) NOT NULL,
  `coordinate` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `survey_template_id` (`survey_template_id`),
  KEY `location_id` (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surveys`
--

LOCK TABLES `surveys` WRITE;
/*!40000 ALTER TABLE `surveys` DISABLE KEYS */;
INSERT INTO `surveys` VALUES (1,3,1,'Penjual','2018-05-21','H ENDANG','','0813 1335 3733','KP PASIR AWI RT.003/002 DESA SUKAJAYA GARUT',15,'',NULL,'',NULL,NULL,'',NULL,'2018-06-23 13:13:21'),(2,3,1,'Penjual','2018-05-22','ABDUL AZIZ RAMDANI','abdulazizramdani@gmail.com','0822 1801 4950','KP TEGAL PARUNG RT.004/007 KEL CIBURUNG KAB GARUT',15,'',NULL,'',NULL,NULL,'',NULL,'2018-06-23 13:13:25'),(3,3,1,'Penjual','2018-06-23','Warih','warih@corphr.com','0219999999','Ciledug Indah 1, Tangerang',32,'-6.221796899999999 ; 106.8355488','2018-06-21 05:59:35','arif@markopelago.com','127.0.0.1','2018-06-23 09:48:31','arif@markopelago.com','114.124.237.1','2018-06-23 14:48:31'),(4,3,1,'Penjual','2018-06-24','Suwandi','suwandi@gmail.com','086497676767','tigaraksa',32,'-6.2197023 ; 106.6934525','2018-06-23 17:40:00','arif@markopelago.com','111.95.48.124','2018-06-24 13:14:44','arif@markopelago.com','192.168.1.103','2018-06-24 06:14:44'),(6,3,2,'Ekspeditur','2018-06-24','Abdul Aziz Ramdani','abdulazizramdani@gmail.com','082218014950','Kp Tegal Parung',15,'-6.2164085 ; 106.69399179999999','2018-06-23 18:09:30','arif@markopelago.com','114.124.132.109','2018-06-24 13:11:40','arif@markopelago.com','192.168.1.103','2018-06-24 06:11:40'),(7,3,1,'Penjual','2018-06-24','Sutino','sut@gmail.com','085466767','tangerang',32,'','2018-06-24 13:24:35','arif@markopelago.com','192.168.1.103','2018-06-24 13:26:43','arif@markopelago.com','192.168.1.103','2018-06-24 06:26:43'),(8,3,1,'Penjual','2018-06-26','TEst123','email@test123.com','083432423','Alamat',19,'','2018-06-26 05:17:04','arif@markopelago.com','127.0.0.1','2018-06-26 05:19:18','arif@markopelago.com','127.0.0.1','2018-06-25 22:19:18'),(9,1,1,'Penjual','2018-06-30','warih','warih@markopelago.com','083423423','ciledug',32,'','2018-06-30 20:04:03','superuser','127.0.0.1','2018-06-30 20:04:03','superuser','127.0.0.1','2018-06-30 13:04:03');
/*!40000 ALTER TABLE `surveys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_id` varchar(150) NOT NULL,
  `name_en` varchar(150) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (1,'Pcs','Pcs',NULL,'',NULL,NULL,'',NULL,'2018-06-30 17:54:04');
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-07-01  1:13:14
