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
  `kasusnohp` varchar(13) DEFAULT NULL,
  `kasusdesaid` int DEFAULT NULL,
  PRIMARY KEY (`kasusid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kasus`
--

LOCK TABLES `kasus` WRITE;
/*!40000 ALTER TABLE `kasus` DISABLE KEYS */;
INSERT INTO `kasus` VALUES (2,'afsdf','2023-08-06 00:00:00','asfasfafa assf afs',1,1,6,'2023-08-06','tsfasd','1691302490_fc44b268761276cb0bfc.jpg',-7.17101,112.628,'2023-08-06 04:20:30','1',2,NULL,NULL,NULL,NULL),(3,'afsdf','2023-08-06 00:00:00','asfasfafa assf afs',1,1,6,'2023-08-06','tsfasd','1691302517_1a013bf58b53abba42bf.jpg',-7.15914,112.637,'2023-08-06 04:20:06','1',2,NULL,NULL,NULL,NULL),(4,'testing edit luuur','2023-08-06 00:00:00','asfa fs sdfsdf',1,1,4,'2023-08-07','','1691302625_6998eb9188bbbac87ce3.jpg',-7.165,112.646,'2023-08-06 03:04:22','1',3,NULL,'selesai di verifikasi',NULL,NULL),(5,'asfasfasf','2023-08-18 00:00:00','asdasds',1,1,6,'0000-00-00','',NULL,-7.14616,112.635,'2023-08-11 00:48:43','1',1,'masyarakat',NULL,NULL,NULL),(6,'asfasfasda','2023-08-23 00:00:00','sdasdad',1,1,8,'2023-08-23','',NULL,-7.15533,112.639,'2023-09-20 03:50:33','1',2,'masyarakat','sedang kami tindak lanjutin','081574242578',2),(7,'asdasda','2023-09-20 00:00:00','sdasdasd',1,1,8,'2023-09-20','',NULL,-7.14478,112.635,'2023-09-20 03:46:16','081574242578',1,'masyarakat',NULL,'081574242578',5);
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
INSERT INTO `kategori` VALUES (1,'TIBUM TRAMAS'),(2,'PENEGAKAN PERDA'),(3,'LINMAS');
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
-- Table structure for table `master_desa`
--

DROP TABLE IF EXISTS `master_desa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `master_desa` (
  `idmaster_desa` int NOT NULL AUTO_INCREMENT,
  `nama_kec` varchar(45) DEFAULT NULL,
  `nama_desa` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idmaster_desa`)
) ENGINE=InnoDB AUTO_INCREMENT=273 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_desa`
--

LOCK TABLES `master_desa` WRITE;
/*!40000 ALTER TABLE `master_desa` DISABLE KEYS */;
INSERT INTO `master_desa` VALUES (2,'Tulungagung','Bago'),(3,'Tulungagung','Botoran'),(4,'Tulungagung','Jepun'),(5,'Tulungagung','Kampungdalem'),(6,'Tulungagung','Karangwaru'),(7,'Tulungagung','Kauman'),(8,'Tulungagung','Kedungsoko'),(9,'Tulungagung','Kenayan'),(10,'Tulungagung','Kepatihan'),(11,'Tulungagung','Kutoanyar'),(12,'Tulungagung','Panggungrejo'),(13,'Tulungagung','Sembung'),(14,'Tulungagung','Tamanan'),(15,'Tulungagung','Tertek'),(16,'Tanggung Gunung','Jenglungharjo'),(17,'Tanggung Gunung','Kresikan'),(18,'Tanggung Gunung','Ngepoh'),(19,'Tanggung Gunung','Ngrejo'),(20,'Tanggung Gunung','Pakisrejo'),(21,'Tanggung Gunung','Tanggung Gunung'),(22,'Tanggung Gunung','Tenggarejo'),(23,'Sumbergempol','Bendiljati Kulon'),(24,'Sumbergempol','Bendiljati Wetan'),(25,'Sumbergempol','Bendilwungu'),(26,'Sumbergempol','Bukur'),(27,'Sumbergempol','Doroampel'),(28,'Sumbergempol','Jabalsari'),(29,'Sumbergempol','Junjung'),(30,'Sumbergempol','Mirigambar'),(31,'Sumbergempol','Podorejo'),(32,'Sumbergempol','Sambidoplang'),(33,'Sumbergempol','Sambijajar'),(34,'Sumbergempol','Sambirobyong'),(35,'Sumbergempol','Sumberdadi'),(36,'Sumbergempol','Tambakrejo'),(37,'Sumbergempol','Trenceng'),(38,'Sumbergempol','Wates'),(39,'Sumbergempol','Wonorejo'),(40,'Sendang','Dono'),(41,'Sendang','Geger'),(42,'Sendang','Kedoyo'),(43,'Sendang','Krosok'),(44,'Sendang','Nglurup'),(45,'Sendang','Nglutung'),(46,'Sendang','Nyawangan'),(47,'Sendang','Picisan'),(48,'Sendang','Sendang'),(49,'Sendang','Talang'),(50,'Sendang','Tugu'),(51,'Rejotangan','Ariyojeding'),(52,'Rejotangan','Banjarejo'),(53,'Rejotangan','Blimbing'),(54,'Rejotangan','Buntaran'),(55,'Rejotangan','Jatidowo'),(56,'Rejotangan','Karangsari'),(57,'Rejotangan','Pakisrejo'),(58,'Rejotangan','Panjerejo'),(59,'Rejotangan','Rejotangan'),(60,'Rejotangan','Sukorejo Wetan'),(61,'Rejotangan','Sumberagung'),(62,'Rejotangan','Tanen'),(63,'Rejotangan','Tegalrejo'),(64,'Rejotangan','Tenggong'),(65,'Rejotangan','Tenggur'),(66,'Rejotangan','Tugu'),(67,'Pucanglaban','Demuk'),(68,'Pucanglaban','Kalidawe'),(69,'Pucanglaban','Kaligentong'),(70,'Pucanglaban','Manding'),(71,'Pucanglaban','Panggungkalak'),(72,'Pucanglaban','Panggunguni'),(73,'Pucanglaban','Pucanglaban'),(74,'Pucanglaban','Sumberbendo'),(75,'Pucanglaban','Sumberdadap'),(76,'Pakel','Bangunjaya'),(77,'Pakel','Bangunmulyo'),(78,'Pakel','Bono'),(79,'Pakel','Duwet'),(80,'Pakel','Gebang'),(81,'Pakel','Gempolan'),(82,'Pakel','Gesikan'),(83,'Pakel','Gombang'),(84,'Pakel','Kesreman'),(85,'Pakel','Ngebong'),(86,'Pakel','Ngrance'),(87,'Pakel','Pakel'),(88,'Pakel','Pecuk'),(89,'Pakel','Sambitan'),(90,'Pakel','Sanan'),(91,'Pakel','Sodo'),(92,'Pakel','Sukoanyar'),(93,'Pakel','Suwaluh'),(94,'Pakel','Tamban'),(95,'Pagerwojo','Gambiran'),(96,'Pagerwojo','Gondanggunung'),(97,'Pagerwojo','Kedungcangkring'),(98,'Pagerwojo','Kradinan'),(99,'Pagerwojo','Mulyosari'),(100,'Pagerwojo','Pagerwojo'),(101,'Pagerwojo','Penjore'),(102,'Pagerwojo','Samar'),(103,'Pagerwojo','Segawe'),(104,'Pagerwojo','Sidomulyo'),(105,'Pagerwojo','Wonorejo'),(106,'Ngunut','Balesono'),(107,'Ngunut','Gilang'),(108,'Ngunut','Kacangan'),(109,'Ngunut','Kalangan'),(110,'Ngunut','Kaliwungu'),(111,'Ngunut','Karangsono'),(112,'Ngunut','Kromasan'),(113,'Ngunut','Ngunut'),(114,'Ngunut','Pandansari'),(115,'Ngunut','Pulosari'),(116,'Ngunut','Pulotondo'),(117,'Ngunut','Purworejo'),(118,'Ngunut','Samir'),(119,'Ngunut','Selorejo'),(120,'Ngunut','Sumberejo Kulon'),(121,'Ngunut','Sumberejo Wetan'),(122,'Ngunut','Sumberingin Kidul'),(123,'Ngunut','Sumberingin Kulon'),(124,'Ngantru','Banjarsari'),(125,'Ngantru','Batokan'),(126,'Ngantru','Bendosari'),(127,'Ngantru','Kepuhrejo'),(128,'Ngantru','Mojoagung'),(129,'Ngantru','Ngantru'),(130,'Ngantru','Padangan'),(131,'Ngantru','Pakel'),(132,'Ngantru','Pinggirsari'),(133,'Ngantru','Pojok'),(134,'Ngantru','Pucunglor'),(135,'Ngantru','Pulerejo'),(136,'Ngantru','Srikaton'),(137,'Kedungwaru','Bangoan'),(138,'Kedungwaru','Boro'),(139,'Kedungwaru','Bulusari'),(140,'Kedungwaru','Gendingan'),(141,'Kedungwaru','Kedungwaru'),(142,'Kedungwaru','Ketanon'),(143,'Kedungwaru','Loderesan'),(144,'Kedungwaru','Majan'),(145,'Kedungwaru','Mangunsari'),(146,'Kedungwaru','Ngujang'),(147,'Kedungwaru','Plandaan'),(148,'Kedungwaru','Plosokandang'),(149,'Kedungwaru','Rejoagung'),(150,'Kedungwaru','Ringinpitu'),(151,'Kedungwaru','Simo'),(152,'Kedungwaru','Tapan'),(153,'Kedungwaru','Tawangsari'),(154,'Kedungwaru','Tunggulsari'),(155,'Kedungwaru','Winong'),(156,'Kauman','Balerejo'),(157,'Kauman','Banaran'),(158,'Kauman','Batangsaren'),(159,'Kauman','Bolorejo'),(160,'Kauman','Jatimulyo'),(161,'Kauman','Kalangbret'),(162,'Kauman','Karanganom'),(163,'Kauman','Kates'),(164,'Kauman','Kauman'),(165,'Kauman','Mojosari'),(166,'Kauman','Panggungrejo'),(167,'Kauman','Pucangan'),(168,'Kauman','Sidorejo'),(169,'Karangrejo','Babadan'),(170,'Karangrejo','Bungur'),(171,'Karangrejo','Gedangan'),(172,'Karangrejo','Jeli'),(173,'Karangrejo','Karangrejo'),(174,'Karangrejo','Punjul'),(175,'Karangrejo','Sembon'),(176,'Karangrejo','Sukodono'),(177,'Karangrejo','Sukorejo'),(178,'Karangrejo','Sukowidodo'),(179,'Karangrejo','Sukowiyono'),(180,'Karangrejo','Tanjungsari'),(181,'Karangrejo','Tulungrejo'),(182,'Kalidawir','Banyu Urip'),(183,'Kalidawir','Betak'),(184,'Kalidawir','Domasan'),(185,'Kalidawir','Jabon'),(186,'Kalidawir','Joho'),(187,'Kalidawir','Kalibatur'),(188,'Kalidawir','Kalidawir'),(189,'Kalidawir','Karangtalun'),(190,'Kalidawir','Ngubalan'),(191,'Kalidawir','Pagersari'),(192,'Kalidawir','Pakisaji'),(193,'Kalidawir','Rejosari'),(194,'Kalidawir','Salakkembang'),(195,'Kalidawir','Sukorejo Kulon'),(196,'Kalidawir','Tanjung'),(197,'Kalidawir','Tunggangri'),(198,'Kalidawir','Winong'),(199,'Gondang','Bendo'),(200,'Gondang','Bendungan'),(201,'Gondang','Blendis'),(202,'Gondang','Dukuh'),(203,'Gondang','Gondang'),(204,'Gondang','Gondosuli'),(205,'Gondang','Jarakan'),(206,'Gondang','Kendal'),(207,'Gondang','Kiping'),(208,'Gondang','Macanbang'),(209,'Gondang','Mojoarum'),(210,'Gondang','Ngrendeng'),(211,'Gondang','Notorejo'),(212,'Gondang','Rejosari'),(213,'Gondang','Sepatan'),(214,'Gondang','Sidem'),(215,'Gondang','Sidomulyo'),(216,'Gondang','Tawing'),(217,'Gondang','Tiudan'),(218,'Gondang','Wonokromo'),(219,'Campurdarat','Campurdarat'),(220,'Campurdarat','Gamping'),(221,'Campurdarat','Gedangan'),(222,'Campurdarat','Ngentrong'),(223,'Campurdarat','Pelem'),(224,'Campurdarat','Pojok'),(225,'Campurdarat','Sawo'),(226,'Campurdarat','Tanggung'),(227,'Campurdarat','Wates'),(228,'Boyolangu','Beji'),(229,'Boyolangu','Bono'),(230,'Boyolangu','Boyolangu'),(231,'Boyolangu','Gedangsewu'),(232,'Boyolangu','Karangrejo'),(233,'Boyolangu','Kendalbulur'),(234,'Boyolangu','Kepuh'),(235,'Boyolangu','Moyoketen'),(236,'Boyolangu','Ngranti'),(237,'Boyolangu','Pucungkidul'),(238,'Boyolangu','Sanggrahan'),(239,'Boyolangu','Serut'),(240,'Boyolangu','Sobontoro'),(241,'Boyolangu','Tanjungsari'),(242,'Boyolangu','Wajak Kidul'),(243,'Boyolangu','Wajak Lor'),(244,'Boyolangu','Waung'),(245,'Besuki','Besole'),(246,'Besuki','Besuki'),(247,'Besuki','Keboireng'),(248,'Besuki','Sedayugunung'),(249,'Besuki','Siyotobagus'),(250,'Besuki','Tanggulkundung'),(251,'Besuki','Tanggulturus'),(252,'Besuki','Tanggulwelahan'),(253,'Besuki','Tulungrejo'),(254,'Besuki','Wates Kroyo'),(255,'Bandung','Bandung'),(256,'Bandung','Bantengan'),(257,'Bandung','Bulus'),(258,'Bandung','Gandong'),(259,'Bandung','Kedungwilut'),(260,'Bandung','Kesambi'),(261,'Bandung','Mergayu'),(262,'Bandung','Ngepeh'),(263,'Bandung','Nglampir'),(264,'Bandung','Ngunggahan'),(265,'Bandung','Sebalor'),(266,'Bandung','Singgit'),(267,'Bandung','Soko'),(268,'Bandung','Sukoharjo'),(269,'Bandung','Suruhan Kidul'),(270,'Bandung','Suruhan Lor'),(271,'Bandung','Suwaru'),(272,'Bandung','Talun Kulon');
/*!40000 ALTER TABLE `master_desa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pegawai`
--

DROP TABLE IF EXISTS `pegawai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pegawai` (
  `pegawaiid` int NOT NULL AUTO_INCREMENT,
  `pegawainamalengkap` varchar(255) DEFAULT NULL,
  `pegawainip` varchar(30) DEFAULT NULL,
  `pegawaigolongan` varchar(10) DEFAULT NULL,
  `pegawaitmtgol` date DEFAULT NULL,
  `pegawainamajabatan` varchar(150) DEFAULT NULL,
  `pegawaiselon` varchar(15) DEFAULT NULL,
  `pegawaitmteselon` date DEFAULT NULL,
  `pegawaitanggalmasuk` date DEFAULT NULL,
  `pegawailatihan` varchar(200) DEFAULT NULL,
  `pegawailatihantahun` int DEFAULT NULL,
  `pegawaipendidikan` varchar(150) DEFAULT NULL,
  `pegawaipendidikantahun` int DEFAULT NULL,
  `pegawaijk` varchar(10) DEFAULT NULL,
  `pegawaipangkattahun` varchar(45) DEFAULT NULL,
  `pegawaiberkltahun` date DEFAULT NULL,
  PRIMARY KEY (`pegawaiid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pegawai`
--

LOCK TABLES `pegawai` WRITE;
/*!40000 ALTER TABLE `pegawai` DISABLE KEYS */;
INSERT INTO `pegawai` VALUES (2,'SONY WELLY ACHMADI, S,STP. MM','197707211997111001','IV/b','2021-10-01','KEPALA SATUAN POLISI PAMONG PRAJA','II.b','2023-03-21','2003-08-06','BIMTEK APARATUR SATPOL PP (2014)  , KOMPETENSI PEMERINTAHAN (2017),  BIMTEK REVOLUSI MENTAL (2018)',0,' S.STP., M.M',2011,'L','01/10/2023','2025-10-01');
/*!40000 ALTER TABLE `pegawai` ENABLE KEYS */;
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
INSERT INTO `sub_kategori` VALUES (1,1,'PATROLI'),(2,1,'DETEKSI DINI'),(3,1,'PAM VIP'),(4,1,'UNJUK RASA'),(5,1,'PPKS'),(6,1,'PK-5 '),(7,1,'DESTINASI WISATA'),(8,1,'KEGIATAN TAMBAHAN'),(9,2,'OPERASI'),(10,2,'PENERTIBAN'),(11,2,'SOSIALISASI'),(12,3,'OPTIMALISASI'),(13,3,'PEMBERDAYAAN'),(14,3,'PEMBINAAN');
/*!40000 ALTER TABLE `sub_kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surat_tugas`
--

DROP TABLE IF EXISTS `surat_tugas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `surat_tugas` (
  `surat_tugas_id` int NOT NULL AUTO_INCREMENT,
  `surat_tugas_nomor` varchar(45) DEFAULT NULL,
  `surat_tugas_untuk` text,
  `surat_tugas_lampiran` text,
  `surat_tugas_created_at` datetime DEFAULT NULL,
  `surat_tugas_created_by` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`surat_tugas_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surat_tugas`
--

LOCK TABLES `surat_tugas` WRITE;
/*!40000 ALTER TABLE `surat_tugas` DISABLE KEYS */;
INSERT INTO `surat_tugas` VALUES (1,'2361924','<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:100%;\"><tbody><tr><td style=\"width:15%;\"><img alt=\"\" src=\"https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/Lambang-tulungagung.png/511px-Lambang-tulungagung.png\" width=\"70\" height=\"90\" /></td><td style=\"width:85%;\"><p style=\"text-align:center;\"><span style=\"font-size:14px;\">PEMERINTAH KABUPATEN TULUNGAGUNG</span><br/><span style=\"font-size:14px;\"><strong>SATUAN POLISI PAMONG PRAJA</strong></span><br/><span style=\"font-size:14px;\">Jl. R.A. Kartini No. 7, Tlp/Fax (0355) 323655</span><br/><span style=\"font-size:14px;\">TULUNGAGUNG Kode Pos 66212</span></p></td></tr></tbody></table><strong>==========================================================================</strong><p style=\"text-align:center;\"><strong>SURAT PERINTAH TUGAS</strong><br/>Nomor : 300.1 / / 42.03 / 2023</p><p>Dasar :</p><ul><li style=\"text-align:justify;\">Peraturan Pemerintah Nomor 18 tahun 2018 tentang Satuan Polisi Pamong Praja.</li><li style=\"text-align:justify;\">Peraturan Menteri Dalam Negeri Nomor 54 Tahun 2011 tentang Standar Operasional Prosedur Satuan Polisi Pamong Praja.</li><li style=\"text-align:justify;\">Peraturan Menteri Dalam Negeri Nomor 26 Tahun 2020 tentang Penyelenggaraan Ketertiban Umum dan Ketentraman Masyarakat Serta Perlindungan Masyarakat.</li><li style=\"text-align:justify;\">Peraturan Bupati Tulungagung Nomor 74 Tahun 2019 tentang Kedudukan, Susunan Organisasi, Tupoksi dan Tata Kerja Satuan Polisi Pamong Praja.</li><li style=\"text-align:justify;\">Surat Keputusan Kepala Satuan Polisi Pamong Praja Nomor 800/005/SK.KEP/42.03/2023, tanggal 02 Januari 2023 tentang Penerimaan Belanja Jasa Tenaga Ketentraman, Ketertiban Umum, dan Perlindungan Masyarakat TNI/CPM/Polri/Linmas/ Satpol PP/Dishub pada Satuan Polisi Pamong Praja Kabupaten Tulungagung dalam Rangka Kegiatan Penindakan atas Gangguan Ketentraman dan Ketertiban Umum berdasarkan Perda dan Perkada Melalui Penertiban dan Penanganan Unjuk Rasa dan kerusuhan massa Tahun Anggaran 202</li></ul><p style=\"text-align:center;\"><strong>MEMERINTAHKAN</strong></p><p><strong>Kepada :</strong></p><ol><li>Pejabat Struktural di Lingkup Satuan Polisi Pamong Praja Tulungagung</li><li>Nama &ndash; nama sebagaimana terlampir</li></ol><p><strong>Untuk :</strong></p><ul><li>Melaksanakan Pengamanan Pagelaran Wayang Kulit tahun 2023</li><li>&nbsp;</li></ul>','<p style=\"text-align:center;\"><span style=\"font-size:16px;\"><strong>Daftar Anggota Satuan Polisi Pamong Praja Kabupaten Tulungagung Pengamanan Pagelaran Wayang Kulit tahun 2023</strong></span></p><table border=\"1\" style=\"border-collapse: collapse; width: 100%;\"><tbody><tr><td style=\"width:50px;\">Titik PAM</td><td style=\"width:291px;\">Nama Anggota</td><td>TUGAS</td></tr><tr><td style=\"width:50px;\">1</td><td style=\"width:291px;\">TEJO SULISTYANTO, EDY PURNOMO</td><td>PENGAMANAN</td></tr><tr><td style=\"width:50px;\">2</td><td style=\"width:291px;\">&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>&nbsp;</p>','2023-09-22 03:04:16','1'),(2,'4tertewtrew','<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:100%;\"><tbody><tr><td style=\"width:15%;\"><img alt=\"\" src=\"https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/Lambang-tulungagung.png/511px-Lambang-tulungagung.png\" width=\"70\" height=\"90\" /></td><td style=\"width:85%;\"><p style=\"text-align:center;\"><span style=\"font-size:14px;\">PEMERINTAH KABUPATEN TULUNGAGUNG</span><br /><span style=\"font-size:14px;\"><strong>SATUAN POLISI PAMONG PRAJA</strong></span><br /><span style=\"font-size:14px;\">Jl. R.A. Kartini No. 7, Tlp/Fax (0355) 323655</span><br /><span style=\"font-size:14px;\">TULUNGAGUNG Kode Pos 66212</span></p></td></tr></tbody></table><p><strong>==========================================================================</strong></p><p style=\"text-align:center;\"><strong>SURAT PERINTAH TUGAS</strong><br />Nomor : 300.1 / / 42.03 / 2023</p><p>Dasar :</p><ul><li style=\"text-align:justify;\">Peraturan Pemerintah Nomor 18 tahun 2018 tentang Satuan Polisi Pamong Praja.</li><li style=\"text-align:justify;\">Peraturan Menteri Dalam Negeri Nomor 54 Tahun 2011 tentang Standar Operasional Prosedur Satuan Polisi Pamong Praja.</li><li style=\"text-align:justify;\">Peraturan Menteri Dalam Negeri Nomor 26 Tahun 2020 tentang Penyelenggaraan Ketertiban Umum dan Ketentraman Masyarakat Serta Perlindungan Masyarakat.</li><li style=\"text-align:justify;\">Peraturan Bupati Tulungagung Nomor 74 Tahun 2019 tentang Kedudukan, Susunan Organisasi, Tupoksi dan Tata Kerja Satuan Polisi Pamong Praja.</li><li style=\"text-align:justify;\">Surat Keputusan Kepala Satuan Polisi Pamong Praja Nomor 800/005/SK.KEP/42.03/2023, tanggal 02 Januari 2023 tentang Penerimaan Belanja Jasa Tenaga Ketentraman, Ketertiban Umum, dan Perlindungan Masyarakat TNI/CPM/Polri/Linmas/ Satpol PP/Dishub pada Satuan Polisi Pamong Praja Kabupaten Tulungagung dalam Rangka Kegiatan Penindakan atas Gangguan Ketentraman dan Ketertiban Umum berdasarkan Perda dan Perkada Melalui Penertiban dan Penanganan Unjuk Rasa dan kerusuhan massa Tahun Anggaran 202</li></ul><p style=\"text-align:center;\"><strong>MEMERINTAHKAN</strong></p><p><strong>Kepada :</strong></p><ol><li>Pejabat Struktural di Lingkup Satuan Polisi Pamong Praja Tulungagung</li><li>Nama &ndash; nama sebagaimana terlampir</li></ol><p><strong>Untuk :</strong></p><ul><li>Melaksanakan Pengamanan Pagelaran Wayang Kulit tahun 2023</li><li>&nbsp;</li></ul>','<p style=\"text-align:center;\"><span style=\"font-size:16px;\"><strong>Daftar Anggota Satuan Polisi Pamong Praja Kabupaten Tulungagung Pengamanan Pagelaran Wayang Kulit tahun 2023</strong></span></p><table border=\"1\" cellspacing=\"0\" style=\"border-collapse:collapse;width:100%;\"><tbody><tr><td style=\"width:50px;\">Titik PAM</td><td style=\"width:291px;\">Nama Anggota</td><td>TUGAS</td></tr><tr><td style=\"width:50px;\">1</td><td style=\"width:291px;\">TEJO SULISTYANTO, EDY PURNOMO</td><td>PENGAMANAN</td></tr><tr><td style=\"width:50px;\">2</td><td style=\"width:291px;\">&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>&nbsp;</p>','2023-09-22 04:02:08','1');
/*!40000 ALTER TABLE `surat_tugas` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','d033e22ae348aeb5660fc2140aec35850c4da997',2,1,'Admina'),(2,'kasir','d033e22ae348aeb5660fc2140aec35850c4da997',-1,2,'Kasiro'),(3,'sony','ac5f84077ce93b6b0ffa1afff56b9d9a31355071',3,2,'SONY WELLY ACHMADI, S,STP. MM');
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

-- Dump completed on 2023-09-28 10:44:09
