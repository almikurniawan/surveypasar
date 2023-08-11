CREATE DATABASE  IF NOT EXISTS `aduan` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `aduan`;
-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: aduan
-- ------------------------------------------------------
-- Server version	8.0.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `kasus`
--

DROP TABLE IF EXISTS `kasus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kasus` (
  `kasusid` int NOT NULL AUTO_INCREMENT,
  `kasusjudul` text,
  `kasustanggal` datetime DEFAULT NULL,
  `kasusdeskripsi` text,
  `kasusurusan` int DEFAULT NULL,
  `kasuskategori` int DEFAULT NULL,
  `kasussubkategori` int DEFAULT NULL,
  `kasustanggalinformasi` date DEFAULT NULL,
  `kasusnomorsurat` varchar(255) DEFAULT NULL,
  `kasusfile` varchar(255) DEFAULT NULL,
  `kasuslatitude` float DEFAULT NULL,
  `kasuslongitude` float DEFAULT NULL,
  `kasuscreatedat` datetime DEFAULT NULL,
  `kasuscreatedby` varchar(45) DEFAULT NULL,
  `kasusstatus` int DEFAULT NULL,
  `kasussumber` varchar(45) DEFAULT NULL,
  `kasuscatatanpetugas` text,
  PRIMARY KEY (`kasusid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kasus`
--

LOCK TABLES `kasus` WRITE;
/*!40000 ALTER TABLE `kasus` DISABLE KEYS */;
INSERT INTO `kasus` VALUES (2,'afsdf','2023-08-06 00:00:00','asfasfafa assf afs',1,1,6,'2023-08-06','tsfasd','1691302490_fc44b268761276cb0bfc.jpg',-7.17101,112.628,'2023-08-06 04:20:30','1',2,NULL,NULL),(3,'afsdf','2023-08-06 00:00:00','asfasfafa assf afs',1,1,6,'2023-08-06','tsfasd','1691302517_1a013bf58b53abba42bf.jpg',-7.15914,112.637,'2023-08-06 04:20:06','1',2,NULL,NULL),(4,'testing edit luuur','2023-08-06 00:00:00','asfa fs sdfsdf',1,1,4,'2023-08-07','','1691302625_6998eb9188bbbac87ce3.jpg',-7.165,112.646,'2023-08-06 03:04:22','1',3,NULL,'selesai di verifikasi'),(5,'asfasfasf','2023-08-18 00:00:00','asdasds',1,1,6,'0000-00-00','',NULL,-7.14616,112.635,'2023-08-11 00:48:43','1',1,'masyarakat',NULL);
/*!40000 ALTER TABLE `kasus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kategori` (
  `idkategori` int NOT NULL AUTO_INCREMENT,
  `kategorinama` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idkategori`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES (1,'TIBUM TRAMAS'),(2,'PENEGAKAN PERDA'),(3,'LINMAS'),(4,'DAMKAR');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kegiatan`
--

DROP TABLE IF EXISTS `kegiatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kegiatan` (
  `idkegiatan` int NOT NULL AUTO_INCREMENT,
  `kegiatanjudul` varchar(255) DEFAULT NULL,
  `kegiatantanggal` datetime NOT NULL,
  `kegiatanjumlahpersonil` int DEFAULT NULL,
  `kegiatanketerangan` varchar(45) DEFAULT NULL,
  `kegiatanijin` varchar(45) DEFAULT NULL,
  `kegiatansakit` varchar(45) DEFAULT NULL,
  `kegiatantanpaketerangan` varchar(45) DEFAULT NULL,
  `kegiatankategori` int NOT NULL,
  `kegiatansubkategori` int DEFAULT NULL,
  `kegiatancreatedat` datetime DEFAULT NULL,
  `kegiatancreatedby` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idkegiatan`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kegiatan`
--

LOCK TABLES `kegiatan` WRITE;
/*!40000 ALTER TABLE `kegiatan` DISABLE KEYS */;
INSERT INTO `kegiatan` VALUES (1,'kegiatan patroli','2023-08-11 01:30:00',10,'-','-','-','-',1,6,'2023-08-04 23:55:14','1'),(2,'kegiatan patroli','2023-08-11 01:30:00',10,'-','-','-','-',1,6,'2023-08-04 23:55:27','1'),(3,'asdasdasd','2023-08-16 00:00:00',10,'-','-','-','-',1,8,'2023-08-04 23:59:08','1'),(4,'wesrgj ','2023-08-18 00:00:00',10,'-','-','-','-',1,5,'2023-08-05 00:02:19','1'),(5,'testing edit','2023-08-05 01:00:00',9,'-','-','-','-',1,8,'2023-08-05 00:03:09','1');
/*!40000 ALTER TABLE `kegiatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `status` (
  `statusid` int NOT NULL AUTO_INCREMENT,
  `statusname` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`statusid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (1,'Menunggu Review'),(2,'Sedang Ditindak Lanjuti'),(3,'Selesai'),(4,'Kasus Tidak Valid');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_kategori`
--

DROP TABLE IF EXISTS `sub_kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sub_kategori` (
  `idsub_kategori` int NOT NULL AUTO_INCREMENT,
  `sub_kategori_idkategori` int NOT NULL,
  `sub_kategorinama` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idsub_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_kategori`
--

LOCK TABLES `sub_kategori` WRITE;
/*!40000 ALTER TABLE `sub_kategori` DISABLE KEYS */;
INSERT INTO `sub_kategori` VALUES (1,1,'PATROLI'),(2,1,'DETEKSI DINI'),(3,1,'PAM VIP'),(4,1,'UNJUK RASA'),(5,1,'PPKS'),(6,1,'PK-5 '),(7,1,'DESTINASI WISATA'),(8,1,'KEGIATAN TAMBAHAN'),(9,2,'OPERASI'),(10,2,'PENERTIBAN'),(11,2,'SOSIALISASI'),(12,3,'OPTIMALISASI'),(13,3,'PEMBERDAYAAN'),(14,3,'PEMBINAAN'),(15,4,'PROTEKSI'),(16,4,'PENANGANAN'),(17,4,'INVESTIGASI'),(18,4,'EVAKUASI');
/*!40000 ALTER TABLE `sub_kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `urusan`
--

DROP TABLE IF EXISTS `urusan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `urusan` (
  `urusanid` int NOT NULL AUTO_INCREMENT,
  `urusannama` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`urusanid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `urusan`
--

LOCK TABLES `urusan` WRITE;
/*!40000 ALTER TABLE `urusan` DISABLE KEYS */;
INSERT INTO `urusan` VALUES (1,'Pribadi'),(2,'Kelompok');
/*!40000 ALTER TABLE `urusan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `user_password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `user_kar_id` int DEFAULT NULL,
  `user_type` int DEFAULT NULL,
  `user_nama_lengkap` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','d033e22ae348aeb5660fc2140aec35850c4da997',1,1,'Admina'),(2,'kasir','d033e22ae348aeb5660fc2140aec35850c4da997',2,2,'Kasiro');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-08-11 13:53:12
