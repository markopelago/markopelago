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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `a_backoffice_menu`
--

LOCK TABLES `a_backoffice_menu` WRITE;
/*!40000 ALTER TABLE `a_backoffice_menu` DISABLE KEYS */;
INSERT INTO `a_backoffice_menu` VALUES (1,1,0,'Home','index.php','2016-04-11 18:31:28','superuser@jalurkerja.com','127.0.0.1','2016-10-28 16:10:37','superuser','127.0.0.1','2016-10-28 02:10:37'),(2,2,0,'Master Data','#','2016-04-11 18:31:28','superuser@jalurkerja.com','127.0.0.1','2016-04-11 18:31:28','superuser@jalurkerja.com','127.0.0.1','2016-04-11 04:31:28'),(3,3,0,'General','#','2016-04-11 18:31:28','superuser@jalurkerja.com','127.0.0.1','2016-11-07 08:01:39','superuser','127.0.0.1','2017-07-30 18:54:05'),(4,1,2,'Users','users_list.php','2016-11-07 08:08:09','superuser','127.0.0.1','2016-11-07 08:08:09','superuser','127.0.0.1','2016-11-06 18:10:09'),(5,2,2,'Groups','groups_list.php','2017-03-27 09:59:48','superuser','127.0.0.1','2017-03-27 09:59:48','superuser','127.0.0.1','2017-04-12 18:00:56'),(6,1,3,'Change Password','change_password.php','2016-11-07 08:08:39','superuser','127.0.0.1','2016-11-07 08:08:39','superuser','127.0.0.1','2017-07-30 18:54:05'),(7,3,2,'Goods','goods_list.php',NULL,'',NULL,NULL,'',NULL,'2018-05-27 05:44:07');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `a_groups`
--

LOCK TABLES `a_groups` WRITE;
/*!40000 ALTER TABLE `a_groups` DISABLE KEYS */;
INSERT INTO `a_groups` VALUES (1,'Administrator','2017-08-13 17:30:16','superuser','127.0.0.1','2017-08-13 17:53:30','admin','127.0.0.1','2017-08-13 10:53:30');
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `a_log_histories`
--

LOCK TABLES `a_log_histories` WRITE;
/*!40000 ALTER TABLE `a_log_histories` DISABLE KEYS */;
INSERT INTO `a_log_histories` VALUES (1,1,'superuser',1,'2018-05-27 11:35:27','127.0.0.1','2018-05-27 04:35:27'),(2,1,'superuser',1,'2018-05-28 21:02:26','127.0.0.1','2018-05-28 14:02:26'),(3,1,'superuser',1,'2018-06-03 00:30:07','127.0.0.1','2018-06-02 17:30:07'),(4,1,'superuser',2,'2018-06-03 01:19:26','127.0.0.1','2018-06-02 18:19:26'),(5,1,'superuser',1,'2018-06-03 01:42:08','127.0.0.1','2018-06-02 18:42:08'),(6,1,'superuser',1,'2018-06-03 01:48:46','192.168.0.14','2018-06-02 18:48:46'),(7,1,'superuser',2,'2018-06-03 01:50:07','192.168.0.14','2018-06-02 18:50:07'),(8,1,'superuser',2,'2018-06-03 01:59:05','127.0.0.1','2018-06-02 18:59:05'),(9,1,'superuser',1,'2018-06-03 02:21:28','127.0.0.1','2018-06-02 19:21:28'),(10,1,'superuser',2,'2018-06-03 02:22:17','127.0.0.1','2018-06-02 19:22:17'),(11,1,'superuser',1,'2018-06-03 02:23:32','127.0.0.1','2018-06-02 19:23:32'),(12,1,'superuser',1,'2018-06-03 02:50:15','192.168.0.14','2018-06-02 19:50:15'),(13,1,'superuser',2,'2018-06-03 02:50:23','192.168.0.14','2018-06-02 19:50:23'),(14,1,'superuser',2,'2018-06-06 21:13:31','127.0.0.1','2018-06-06 14:13:31'),(15,1,'superuser',2,'2018-06-09 14:57:18','127.0.0.1','2018-06-09 07:57:18');
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
  `role` int(11) NOT NULL DEFAULT '999',
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `a_users`
--

LOCK TABLES `a_users` WRITE;
/*!40000 ALTER TABLE `a_users` DISABLE KEYS */;
INSERT INTO `a_users` VALUES (1,0,'superuser','MTIzNDU2','superuser',0,16,'2018-06-03 02:50:15','2018-06-03 02:23:32','192.168.0.14','127.0.0.1','2017-04-27 08:39:07','127.0.0.1','superuser','2018-06-03 02:50:15','superuser','192.168.0.14','2018-06-02 19:50:15'),(2,1,'admin','MTIzMTIz','Administrator',999,37,'2017-08-13 18:51:11','2017-08-13 18:43:14','127.0.0.1','127.0.0.1','2017-08-13 17:31:44','superuser','127.0.0.1','2017-08-13 17:53:47','admin','127.0.0.1','2017-08-13 11:51:11');
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backofficers`
--

LOCK TABLES `backofficers` WRITE;
/*!40000 ALTER TABLE `backofficers` DISABLE KEYS */;
/*!40000 ALTER TABLE `backofficers` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_details`
--

LOCK TABLES `survey_details` WRITE;
/*!40000 ALTER TABLE `survey_details` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_photos`
--

LOCK TABLES `survey_photos` WRITE;
/*!40000 ALTER TABLE `survey_photos` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_template_details`
--

LOCK TABLES `survey_template_details` WRITE;
/*!40000 ALTER TABLE `survey_template_details` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_templates`
--

LOCK TABLES `survey_templates` WRITE;
/*!40000 ALTER TABLE `survey_templates` DISABLE KEYS */;
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
  `surveyed_at` datetime NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `location_id` int(11) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surveys`
--

LOCK TABLES `surveys` WRITE;
/*!40000 ALTER TABLE `surveys` DISABLE KEYS */;
/*!40000 ALTER TABLE `surveys` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-19 21:29:53
