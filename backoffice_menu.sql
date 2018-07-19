-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.28-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for markopelago
CREATE DATABASE IF NOT EXISTS `markopelago` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `markopelago`;

-- Dumping structure for table markopelago.a_backoffice_menu
CREATE TABLE IF NOT EXISTS `a_backoffice_menu` (
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Dumping data for table markopelago.a_backoffice_menu: ~11 rows (approximately)
/*!40000 ALTER TABLE `a_backoffice_menu` DISABLE KEYS */;
INSERT INTO `a_backoffice_menu` (`id`, `seqno`, `parent_id`, `name`, `url`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `xtimestamp`) VALUES
	(1, 1, 0, 'Home', 'index.php', '2016-04-11 18:31:28', 'superuser@jalurkerja.com', '127.0.0.1', '2016-10-28 16:10:37', 'superuser', '127.0.0.1', '2016-10-28 09:10:37'),
	(2, 2, 0, 'Master Data', '#', '2016-04-11 18:31:28', 'superuser@jalurkerja.com', '127.0.0.1', '2016-04-11 18:31:28', 'superuser@jalurkerja.com', '127.0.0.1', '2016-04-11 11:31:28'),
	(3, 5, 0, 'General', '#', '2016-04-11 18:31:28', 'superuser@jalurkerja.com', '127.0.0.1', '2016-11-07 08:01:39', 'superuser', '127.0.0.1', '2018-07-01 03:33:18'),
	(4, 1, 8, 'Users', 'users_list.php', '2016-11-07 08:08:09', 'superuser', '127.0.0.1', '2016-11-07 08:08:09', 'superuser', '127.0.0.1', '2018-06-23 13:35:34'),
	(5, 1, 2, 'Groups', 'groups_list.php', '2017-03-27 09:59:48', 'superuser', '127.0.0.1', '2017-03-27 09:59:48', 'superuser', '127.0.0.1', '2018-06-23 13:35:35'),
	(6, 1, 3, 'Change Password', 'change_password.php', '2016-11-07 08:08:39', 'superuser', '127.0.0.1', '2016-11-07 08:08:39', 'superuser', '127.0.0.1', '2017-07-31 01:54:05'),
	(7, 2, 8, 'Goods', 'goods_list.php', NULL, '', NULL, NULL, '', NULL, '2018-07-01 03:35:24'),
	(8, 3, 0, 'Subject', '#', NULL, '', NULL, NULL, '', NULL, '2018-06-23 13:35:34'),
	(9, 3, 8, 'Surveys', 'surveys_list.php', NULL, '', NULL, NULL, '', NULL, '2018-07-01 03:35:46'),
	(10, 4, 0, 'Marketing', '#', '2016-04-11 18:31:28', 'superuser@jalurkerja.com', '127.0.0.1', '2016-11-07 08:01:39', 'superuser', '127.0.0.1', '2018-06-23 13:35:34'),
	(11, 1, 10, 'Promo', 'promo_list.php', NULL, '', NULL, NULL, '', NULL, '2018-06-23 13:35:35'),
	(12, 2, 2, 'Banks', 'banks_list.php', '2018-07-19 04:59:10', 'superuser', '127.0.0.1', '2018-07-19 04:59:21', 'superuser', '127.0.0.1', '2018-07-19 04:59:28'),
	(13, 4, 8, 'Categories', 'cat_list.php', NULL, '', NULL, NULL, '', NULL, '2018-07-01 03:35:24'),
	(14, 5, 8, 'Payments Type', 'paytype_list.php', '2018-07-20 03:18:22', 'superuser', '127.0.0..1', '2018-07-20 03:18:31', 'superuser', '127.0.0.1', '2018-07-20 03:18:59'),
	(15, 6, 8, 'Units ', 'units_list.php', '2018-07-20 03:18:22', 'superuser', '127.0.0..1', '2018-07-20 03:18:31', 'superuser', '127.0.0.1', '2018-07-20 03:19:06'),
	(16, 7, 8, 'Vehicle Brands', 'vehbrand_list.php', '2018-07-20 03:18:22', 'superuser', '127.0.0..1', '2018-07-20 03:18:31', 'superuser', '127.0.0.1', '2018-07-20 03:20:10'),
	(17, 8, 8, 'Vehicle Types', 'vehtype_list.php', '2018-07-20 03:18:22', 'superuser', '127.0.0..1', '2018-07-20 03:18:31', 'superuser', '127.0.0.1', '2018-07-20 03:20:07');
/*!40000 ALTER TABLE `a_backoffice_menu` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
