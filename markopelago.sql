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
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_template_details`
--

LOCK TABLES `survey_template_details` WRITE;
/*!40000 ALTER TABLE `survey_template_details` DISABLE KEYS */;
INSERT INTO `survey_template_details` VALUES (1,1,0,1,'Detail Bisnis','','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(2,1,1,1,'','Nama Perusahaan','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(3,1,1,2,'','Alamat Perusahaan','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(4,1,1,3,'','Posisi anda di perusahaan','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(5,1,1,4,'','Jenis Usaha','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(6,1,1,5,'','Apa jenis produk anda?','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(7,1,1,6,'','Apa Merk Produk anda?','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(8,1,1,7,'','Apakah usaha/bisnis anda dibawah PT atau CV?','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(9,1,1,8,'','Alamat Website','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(10,1,1,9,'','Bank yang digunakan perusahaan anda dalam bertransaksi','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(11,1,1,10,'','Apakah perusahaan anda mendapatkan kredit/pembiayaan dari Bank/Badan lain?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:08'),(12,1,1,11,'','Apakah anda bisa menjual produk anda hingga beberapa bulan kedepan dengan sistem kontrak?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:10'),(13,1,1,12,'','Apakah produk anda tahan lama?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:11'),(14,1,1,13,'','Apakah usaha anda memiliki akun Medsos (FB,Instagram dll)','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:13'),(15,1,1,14,'','Apakah anda memberikan tempo kredit untuk customer anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:14'),(16,1,1,15,'','Apakah anda memiliki teman yang bersedia menjadi seller/transporter di markopelago ?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:26'),(17,1,0,2,'Pengalaman e-Commerce','','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:58'),(18,1,17,1,'','Apakah anda pernah mendengar tentang e-commerce/jual online sebelumnya?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:28'),(19,1,17,2,'','Apakah mudah  untuk menggunakan e-commerce/jual online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:29'),(20,1,17,3,'','Apakah anda pernah menjual melalui aplikasi Marketplace/Jual Beli online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:30'),(21,1,17,4,'','Apakah anda pernah membeli melalui aplikasi  Marketplace/Jual Beli online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:31'),(22,1,17,5,'','Apakah anda puas bertransaksi di aplikasi Marketplace/Jual Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:33'),(23,1,17,6,'','Apakah anda pernah menjual melalui Medsos; Medsos apa?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:34'),(24,1,17,7,'','Apakah anda pernah membeli melalui Medsos; Medsos apa?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:43'),(25,1,17,8,'','Apa aplikasi Jual Beli Online favorit anda?','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(26,1,17,9,'','Sudah berapa lama usaha anda berjalan dan berkembang?','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(27,1,17,10,'','Apakah anda memiliki karyawan?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:44'),(28,1,17,11,'','Apakah anda mau menjual di aplikasi Marketplace/Jual  Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:45'),(29,1,17,12,'','Apakah anda mau membeli di aplikasi Marketplace/Jual  Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:46'),(30,1,17,13,'','Apakah membeli dari aplikasi Marketplace/Jual Beli Online memberikan keuntungan bagi anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:47'),(31,1,17,14,'','Apakah menjual dari aplikasi Marketplace/Jual Beli Online memberikan keuntungan bagi anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:56'),(32,1,0,3,'Logistik dan Pengiriman','','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:03:03'),(33,1,32,1,'','Apakah bisnis anda memiliki gudang/tempat penyimpanan stok sendiri?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:58'),(34,1,32,2,'','Apabila tidak memiliki sendiri, apakah anda menyewanya?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:09:59'),(35,1,32,3,'','Apakah anda memiliki armada pengiriman sendiri?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:10:00'),(36,1,32,4,'','Apakah anda menggunakan jasa JNE, TIKI, J&T dll untuk pengiriman produk anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:10:01'),(37,1,32,5,'','Apakah anda menggunakan jasa truk/kereta/kapal laut  untuk pengiriman produk anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:10:03'),(38,1,32,6,'','Apakah anda memiliki langganan jasa trucking/pengangkutan produk anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:10:03'),(39,1,32,7,'','Apakah terkadang anda mengalami kesulitan dalam hal pengiriman dikarenakan tujuan tidak bisa dijangkau?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:10:04'),(40,1,32,8,'','Apakah pernah mendapatkan produk anda rusak selama pengiriman?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:10:05'),(41,1,32,9,'','Apakah pihak kurir/transporter mengganti kerugian tersebut?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:10:06'),(42,1,32,10,'','Apakah produk anda memerlukan perlakuan khusus selama delivery? Misal didinginkan, mudah pecah dll','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:10:08'),(43,1,32,11,'','Apakah jenis perlakuan khusus yang diperlukan?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:10:09'),(44,2,0,1,'Detail Bisnis','','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(45,2,44,1,'','Nama Perusahaan','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(46,2,44,2,'','Alamat Perusahaan','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(47,2,44,3,'','Lama berdiri (thn)','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(48,2,44,4,'','Posisi anda di perusahaan','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(49,2,44,5,'','Jenis Usaha','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(50,2,44,6,'','Apakah usaha/bisnis anda dibawah PT atau CV?','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(51,2,44,7,'','Alamat Website','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(52,2,44,8,'','Bank yang digunakan perusahaan anda dalam bertransaksi','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(53,2,44,9,'','Total Armada yang anda miliki','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(54,2,44,10,'','Jenis-jenis armada anda (Bisa lebih dari 1)','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(55,2,44,11,'','Jangkauan Pelayanan (Kota, bisa lebih dari 1)','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(56,2,44,12,'','Lokasi Pool (Kota, Bisa lebih dari 1)','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(57,2,44,13,'','Apakah perusahaan anda mendapatkan kredit/pembiayaan dari Bank/Badan lain?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:26:51'),(58,2,44,14,'','Apakah anda bisa menjual produk anda hingga beberapa bulan kedepan dengan sistem kontrak?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:26:56'),(59,2,44,15,'','Apakah usaha anda memiliki akun Medsos (FB,Instagram dll)','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:26:58'),(60,2,44,16,'','Apakah anda memberikan tempo kredit untuk customer anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:26:59'),(61,2,44,17,'','Apakah anda dapat memberikan rate/harga untuk ke masing-masing kota tujuan?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:00'),(62,2,44,18,'','Bila tidak, Bersediakah anda jika markopelago memberikan rekomendasi rate/harga ?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:01'),(63,2,44,19,'','Bersediakah anda menjadi bundling transportasi dari setiap seller yang telah direkomendasikan ?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:02'),(64,2,44,20,'','Apakah anda memiliki teman yang bersedia menjadi seller/transporter di markopelago ?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:13'),(65,2,0,2,'Pengalaman e-Commerce','','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(66,2,65,1,'','Apakah anda pernah mendengar tentang e-commerce/jual online sebelumnya?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:14'),(67,2,65,2,'','Apakah mudah  untuk menggunakan e-commerce/jual online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:15'),(68,2,65,3,'','Apakah anda pernah menjual melalui aplikasi Marketplace/Jual Beli online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:16'),(69,2,65,4,'','Apakah anda pernah membeli melalui aplikasi  Marketplace/Jual Beli online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:17'),(70,2,65,5,'','Apakah anda puas bertransaksi di aplikasi Marketplace/Jual Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:18'),(71,2,65,6,'','Apakah anda pernah menjual melalui Medsos; Medsos apa?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:20'),(72,2,65,7,'','Apakah anda pernah membeli melalui Medsos; Medsos apa?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:24'),(73,2,65,8,'','Apa aplikasi Jual Beli Online favorit anda?','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(74,2,65,9,'','Apakah anda memiliki karyawan?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:25'),(75,2,65,10,'','Apakah anda mau menjadi partner transportasi di aplikasi Marketplace/Jual  Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:26'),(76,2,65,11,'','Apakah anda mau membeli di aplikasi Marketplace/Jual  Beli Online?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:28'),(77,2,65,12,'','Apakah membeli dari aplikasi Marketplace/Jual Beli Online memberikan keuntungan bagi anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:30'),(78,2,65,13,'','Apakah menjadi partner transportasi dari aplikasi Marketplace/Jual Beli Online memberikan keuntungan bagi anda?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:39'),(79,2,0,3,'Logistik dan Pengiriman','','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26'),(80,2,79,1,'','Apakah anda memiliki pelanggan yang sudah terpercaya ?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:40'),(81,2,79,2,'','Apakah produk yang anda kirim pernah rusak selama perjalanan ?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:41'),(82,2,79,3,'','Apakah anda mengganti kerugian tersebut?','YToyOntpOjE7czoyOiJZYSI7aToyO3M6NToiVGlkYWsiO30=',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:27:42'),(83,2,79,4,'','Apakah armada anda hanya melayani pengiriman khusus ? Contoh : Ayam, Es, Barang pecah belah,\r\njika iya, apakah itu ?','',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:24:26');
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
INSERT INTO `survey_templates` VALUES (1,'Seller Survey',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:02:15'),(2,'Truck Vendor',NULL,'',NULL,NULL,'',NULL,'2018-06-19 15:22:09');
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

-- Dump completed on 2018-06-19 22:27:57
