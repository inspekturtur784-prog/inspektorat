-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: inspektorat_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `buletins`
--

DROP TABLE IF EXISTS `buletins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buletins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `intro` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `pdf_file` varchar(255) DEFAULT NULL,
  `image_position` varchar(255) NOT NULL DEFAULT 'center',
  `theme` varchar(255) NOT NULL DEFAULT 'navy',
  `read_minutes` int(10) unsigned NOT NULL DEFAULT 1,
  `tanggal` date DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `toc` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`toc`)),
  `art_kicker` varchar(255) DEFAULT NULL,
  `art_title` varchar(255) DEFAULT NULL,
  `art_p1` text DEFAULT NULL,
  `art_pull` text DEFAULT NULL,
  `art_p2` text DEFAULT NULL,
  `stats_title` varchar(255) DEFAULT NULL,
  `stats` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`stats`)),
  `stats_note` text DEFAULT NULL,
  `iv_title` varchar(255) DEFAULT NULL,
  `iv_q` text DEFAULT NULL,
  `iv_a` text DEFAULT NULL,
  `iv_who` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `published_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buletins`
--

LOCK TABLES `buletins` WRITE;
/*!40000 ALTER TABLE `buletins` DISABLE KEYS */;
INSERT INTO `buletins` VALUES (6,'rapat-evaluasi-Tskhe','RAPAT EVALUASI','EDISI 02 . INSPEKTORAT 9 OKTOBER 2025',NULL,'1789353554_RAPT3.jpg','1789353554_CONTOH-BULETIN.pdf','top','navy',1,NULL,NULL,'2026-09-13 19:39:14','2026-09-22 20:16:03',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL),(7,'rapat-sakip-jdxNV','RAPAT SAKIP','EDISI 04 . INSPEKTORAT 17 MEI 2024',NULL,'1789353604_INSPEKTORAT 2.jpeg','1789353604_03-pedoman-teknis-penilaian-mandiri-kapabilitas-apip.pdf','bottom','navy',1,NULL,NULL,'2026-09-13 19:40:04','2026-09-22 20:15:44',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL),(8,'hasil-cepat-dampak-hebat-ZHN6a','Hasil Cepat Dampak Hebat','EDISI 02 . INSPEKTORAT 14 agustus 2026',NULL,'1789442787_ke 1 buletin.png','1789442787_buletin-new-2.pdf','top','navy',1,NULL,NULL,'2026-09-14 20:26:27','2026-09-22 20:06:36',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL),(9,'coba-buletin-iW28I','COBA BULETIN','EDISI 01. INSPEKTORAT 2026',NULL,'1790576889_gambar awal.png','1790576889_PPT-Modul-6-Rekayasa-Proses-Final.pdf','center','navy',1,NULL,NULL,'2026-09-27 23:28:09','2026-09-27 23:28:09',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL),(10,'coba-inspektorat-buletin-FIGgn','COBA INSPEKTORAT BULETIN','EDISI 01 . INSPEKTORAT 2026',NULL,'1790577074_Screenshot 2026-09-28 132442.png','1790577074_BULETIN-PENGAWASAN-11092026-2-(2)_compressed.pdf','center','navy',1,NULL,NULL,'2026-09-27 23:31:14','2026-09-27 23:31:14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL);
/*!40000 ALTER TABLE `buletins` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-01 12:22:59
