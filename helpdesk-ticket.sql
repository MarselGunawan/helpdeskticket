-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for helpdesk_ticket
CREATE DATABASE IF NOT EXISTS `helpdesk_ticket` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `helpdesk_ticket`;

-- Dumping structure for table helpdesk_ticket.tickets
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `category` enum('Hardware','Software','Network','Others') NOT NULL,
  `description` text NOT NULL,
  `status` enum('Open','In Progress','Closed') NOT NULL DEFAULT 'Open',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table helpdesk_ticket.tickets: ~0 rows (approximately)
INSERT INTO `tickets` (`id`, `subject`, `category`, `description`, `status`, `created_at`) VALUES
	(1, 'Laptop tidak bisa menyala', 'Hardware', 'Laptop karyawan tidak dapat menyala ketika tombol power ditekan.', 'Open', '2026-09-03 08:11:27'),
	(2, 'Install Microsoft Office', 'Software', 'Mohon dilakukan instalasi Microsoft Office pada komputer karyawan.', 'In Progress', '2026-09-03 08:11:27'),
	(3, 'Internet kantor tidak terhubung', 'Network', 'Koneksi internet pada komputer bagian finance tidak dapat digunakan.', 'Closed', '2026-09-03 08:11:27'),
	(5, 'test', 'Others', 'test', 'In Progress', '2026-09-03 08:16:59');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
