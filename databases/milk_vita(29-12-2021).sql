-- MySQL dump 10.13  Distrib 8.0.27, for macos11 (x86_64)
--
-- Host: 127.0.0.1    Database: milk_vita
-- ------------------------------------------------------
-- Server version	8.0.27

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
-- Table structure for table `action_menus`
--

DROP TABLE IF EXISTS `action_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `action_menus` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_id` int NOT NULL,
  `sub_menu_id` int NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inside',
  `icon` text COLLATE utf8mb4_unicode_ci,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `trash` tinyint NOT NULL DEFAULT '0',
  `position` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_menus`
--

LOCK TABLES `action_menus` WRITE;
/*!40000 ALTER TABLE `action_menus` DISABLE KEYS */;
INSERT INTO `action_menus` VALUES (1,'Edit','এডিট',7,0,'in_page','fa fa-pencil','/role/update',0,1,NULL,NULL),(2,'Edit','এডিট',8,0,'in_page','fa fa-pencil','/user/access/edit',0,3,NULL,NULL),(3,'Delete','ডিলিট',8,0,'in_page','fa fa-trash','/user/access/delete',0,4,NULL,NULL),(4,'Add New','নতুন যোগ করুন',8,0,'in_page','fa fa-plus','/user/access/add',0,2,NULL,NULL),(5,'Add New','নতুন যোগ করুন',7,0,'in_page','fa fa-plus','/role/add',0,1,NULL,NULL),(6,'Collect','সংগ্রহ',3,0,'in_page','fa fa-plus','/management/milk-collection/collect',0,1,NULL,NULL),(7,'List','তালিকা',3,0,'in_page','fa fa-list','/management/milk-collection/list',0,2,NULL,NULL);
/*!40000 ALTER TABLE `action_menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `association_members`
--

DROP TABLE IF EXISTS `association_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `association_members` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `regi_id` int NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `total_cattle` int NOT NULL DEFAULT '0',
  `total_gavi` int NOT NULL DEFAULT '0',
  `total_bokna` int NOT NULL DEFAULT '0',
  `total_shar` int NOT NULL DEFAULT '0',
  `total_mohish` int NOT NULL DEFAULT '0',
  `total_bolod` int NOT NULL DEFAULT '0',
  `total_bokna_bachor` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `association_members`
--

LOCK TABLES `association_members` WRITE;
/*!40000 ALTER TABLE `association_members` DISABLE KEYS */;
/*!40000 ALTER TABLE `association_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `associations`
--

DROP TABLE IF EXISTS `associations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `associations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `milk_area_division_id` int DEFAULT NULL,
  `milk_area_district_id` int DEFAULT NULL,
  `milk_area_thana_id` int DEFAULT NULL,
  `milk_area_village` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `association_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `association_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_of_dairy_area` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `working_area_of_association` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `association_division_id` int DEFAULT NULL,
  `association_district_id` int DEFAULT NULL,
  `association_thana_id` int DEFAULT NULL,
  `association_village` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_present_member` int DEFAULT NULL,
  `distance_of_working_area_to_adjoining_area` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `distance_of_factory_to_association_center` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` decimal(10,8) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `temparary_approved` tinyint NOT NULL DEFAULT '0',
  `permanent_approved` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `associations_user_id_foreign` (`user_id`),
  CONSTRAINT `associations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `associations`
--

LOCK TABLES `associations` WRITE;
/*!40000 ALTER TABLE `associations` DISABLE KEYS */;
/*!40000 ALTER TABLE `associations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `districts`
--

DROP TABLE IF EXISTS `districts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `districts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `division_id` int NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `lon` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `trash` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `districts`
--

LOCK TABLES `districts` WRITE;
/*!40000 ALTER TABLE `districts` DISABLE KEYS */;
INSERT INTO `districts` VALUES (1,1,'Comilla','কুমিল্লা','23.4682747','91.1788135','www.comilla.gov.bd',0,NULL,NULL),(2,1,'Feni','ফেনী','23.023231','91.3840844','www.feni.gov.bd',0,NULL,NULL),(3,1,'Brahmanbaria','ব্রাহ্মণবাড়িয়া','23.9570904','91.1119286','www.brahmanbaria.gov.bd',0,NULL,NULL),(4,1,'Rangamati','রাঙ্গামাটি',NULL,NULL,'www.rangamati.gov.bd',0,NULL,NULL),(5,1,'Noakhali','নোয়াখালী','22.869563','91.099398','www.noakhali.gov.bd',0,NULL,NULL),(6,1,'Chandpur','চাঁদপুর','23.2332585','90.6712912','www.chandpur.gov.bd',0,NULL,NULL),(7,1,'Lakshmipur','লক্ষ্মীপুর','22.942477','90.841184','www.lakshmipur.gov.bd',0,NULL,NULL),(8,1,'Chattogram','চট্টগ্রাম','22.335109','91.834073','www.chittagong.gov.bd',0,NULL,NULL),(9,1,'Coxsbazar','কক্সবাজার',NULL,NULL,'www.coxsbazar.gov.bd',0,NULL,NULL),(10,1,'Khagrachhari','খাগড়াছড়ি','23.119285','91.984663','www.khagrachhari.gov.bd',0,NULL,NULL),(11,1,'Bandarban','বান্দরবান','22.1953275','92.2183773','www.bandarban.gov.bd',0,NULL,NULL),(12,2,'Sirajganj','সিরাজগঞ্জ','24.4533978','89.7006815','www.sirajganj.gov.bd',0,NULL,NULL),(13,2,'Pabna','পাবনা','23.998524','89.233645','www.pabna.gov.bd',0,NULL,NULL),(14,2,'Bogura','বগুড়া','24.8465228','89.377755','www.bogra.gov.bd',0,NULL,NULL),(15,2,'Rajshahi','রাজশাহী',NULL,NULL,'www.rajshahi.gov.bd',0,NULL,NULL),(16,2,'Natore','নাটোর','24.420556','89.000282','www.natore.gov.bd',0,NULL,NULL),(17,2,'Joypurhat','জয়পুরহাট',NULL,NULL,'www.joypurhat.gov.bd',0,NULL,NULL),(18,2,'Chapainawabganj','চাঁপাইনবাবগঞ্জ','24.5965034','88.2775122','www.chapainawabganj.gov.bd',0,NULL,NULL),(19,2,'Naogaon','নওগাঁ',NULL,NULL,'www.naogaon.gov.bd',0,NULL,NULL),(20,3,'Jashore','যশোর','23.16643','89.2081126','www.jessore.gov.bd',0,NULL,NULL),(21,3,'Satkhira','সাতক্ষীরা',NULL,NULL,'www.satkhira.gov.bd',0,NULL,NULL),(22,3,'Meherpur','মেহেরপুর','23.762213','88.631821','www.meherpur.gov.bd',0,NULL,NULL),(23,3,'Narail','নড়াইল','23.172534','89.512672','www.narail.gov.bd',0,NULL,NULL),(24,3,'Chuadanga','চুয়াডাঙ্গা','23.6401961','88.841841','www.chuadanga.gov.bd',0,NULL,NULL),(25,3,'Kushtia','কুষ্টিয়া','23.901258','89.120482','www.kushtia.gov.bd',0,NULL,NULL),(26,3,'Magura','মাগুরা','23.487337','89.419956','www.magura.gov.bd',0,NULL,NULL),(27,3,'Khulna','খুলনা','22.815774','89.568679','www.khulna.gov.bd',0,NULL,NULL),(28,3,'Bagerhat','বাগেরহাট','22.651568','89.785938','www.bagerhat.gov.bd',0,NULL,NULL),(29,3,'Jhenaidah','ঝিনাইদহ','23.5448176','89.1539213','www.jhenaidah.gov.bd',0,NULL,NULL),(30,4,'Jhalakathi','ঝালকাঠি',NULL,NULL,'www.jhalakathi.gov.bd',0,NULL,NULL),(31,4,'Patuakhali','পটুয়াখালী','22.3596316','90.3298712','www.patuakhali.gov.bd',0,NULL,NULL),(32,4,'Pirojpur','পিরোজপুর',NULL,NULL,'www.pirojpur.gov.bd',0,NULL,NULL),(33,4,'Barisal','বরিশাল',NULL,NULL,'www.barisal.gov.bd',0,NULL,NULL),(34,4,'Bhola','ভোলা','22.685923','90.648179','www.bhola.gov.bd',0,NULL,NULL),(35,4,'Barguna','বরগুনা',NULL,NULL,'www.barguna.gov.bd',0,NULL,NULL),(36,5,'Sylhet','সিলেট','24.8897956','91.8697894','www.sylhet.gov.bd',0,NULL,NULL),(37,5,'Moulvibazar','মৌলভীবাজার','24.482934','91.777417','www.moulvibazar.gov.bd',0,NULL,NULL),(38,5,'Habiganj','হবিগঞ্জ','24.374945','91.41553','www.habiganj.gov.bd',0,NULL,NULL),(39,5,'Sunamganj','সুনামগঞ্জ','25.0658042','91.3950115','www.sunamganj.gov.bd',0,NULL,NULL),(40,6,'Narsingdi','নরসিংদী','23.932233','90.71541','www.narsingdi.gov.bd',0,NULL,NULL),(41,6,'Gazipur','গাজীপুর','24.0022858','90.4264283','www.gazipur.gov.bd',0,NULL,NULL),(42,6,'Shariatpur','শরীয়তপুর',NULL,NULL,'www.shariatpur.gov.bd',0,NULL,NULL),(43,6,'Narayanganj','নারায়ণগঞ্জ','23.63366','90.496482','www.narayanganj.gov.bd',0,NULL,NULL),(44,6,'Tangail','টাঙ্গাইল',NULL,NULL,'www.tangail.gov.bd',0,NULL,NULL),(45,6,'Kishoreganj','কিশোরগঞ্জ','24.444937','90.776575','www.kishoreganj.gov.bd',0,NULL,NULL),(46,6,'Manikganj','মানিকগঞ্জ',NULL,NULL,'www.manikganj.gov.bd',0,NULL,NULL),(47,6,'Dhaka','ঢাকা','23.7115253','90.4111451','www.dhaka.gov.bd',0,NULL,NULL),(48,6,'Munshiganj','মুন্সিগঞ্জ',NULL,NULL,'www.munshiganj.gov.bd',0,NULL,NULL),(49,6,'Rajbari','রাজবাড়ী','23.7574305','89.6444665','www.rajbari.gov.bd',0,NULL,NULL),(50,6,'Madaripur','মাদারীপুর','23.164102','90.1896805','www.madaripur.gov.bd',0,NULL,NULL),(51,6,'Gopalganj','গোপালগঞ্জ','23.0050857','89.8266059','www.gopalganj.gov.bd',0,NULL,NULL),(52,6,'Faridpur','ফরিদপুর','23.6070822','89.8429406','www.faridpur.gov.bd',0,NULL,NULL),(53,7,'Panchagarh','পঞ্চগড়','26.3411','88.5541606','www.panchagarh.gov.bd',0,NULL,NULL),(54,7,'Dinajpur','দিনাজপুর','25.6217061','88.6354504','www.dinajpur.gov.bd',0,NULL,NULL),(55,7,'Lalmonirhat','লালমনিরহাট',NULL,NULL,'www.lalmonirhat.gov.bd',0,NULL,NULL),(56,7,'Nilphamari','নীলফামারী','25.931794','88.856006','www.nilphamari.gov.bd',0,NULL,NULL),(57,7,'Gaibandha','গাইবান্ধা','25.328751','89.528088','www.gaibandha.gov.bd',0,NULL,NULL),(58,7,'Thakurgaon','ঠাকুরগাঁও','26.0336945','88.4616834','www.thakurgaon.gov.bd',0,NULL,NULL),(59,7,'Rangpur','রংপুর','25.7558096','89.244462','www.rangpur.gov.bd',0,NULL,NULL),(60,7,'Kurigram','কুড়িগ্রাম','25.805445','89.636174','www.kurigram.gov.bd',0,NULL,NULL),(61,8,'Sherpur','শেরপুর','25.0204933','90.0152966','www.sherpur.gov.bd',0,NULL,NULL),(62,8,'Mymensingh','ময়মনসিংহ','24.7465670','90.4072093','www.mymensingh.gov.bd',0,NULL,NULL),(63,8,'Jamalpur','জামালপুর','24.937533','89.937775','www.jamalpur.gov.bd',0,NULL,NULL),(64,8,'Netrokona','নেত্রকোণা','24.870955','90.727887','www.netrokona.gov.bd',0,NULL,'2021-09-22 01:10:35');
/*!40000 ALTER TABLE `districts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `divisions`
--

DROP TABLE IF EXISTS `divisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `divisions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trash` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `divisions`
--

LOCK TABLES `divisions` WRITE;
/*!40000 ALTER TABLE `divisions` DISABLE KEYS */;
INSERT INTO `divisions` VALUES (1,'Chattagram','চট্টগ্রাম','www.chittagongdiv.gov.bd',0,NULL,'2021-09-14 16:42:50'),(2,'Rajshahi','রাজশাহী','www.rajshahidiv.gov.bd',0,NULL,NULL),(3,'Khulna','খুলনা','www.khulnadiv.gov.bd',0,NULL,NULL),(4,'Barisal','বরিশাল','www.barisaldiv.gov.bd',0,NULL,NULL),(5,'Sylhet','সিলেট','www.sylhetdiv.gov.bd',0,NULL,NULL),(6,'Dhaka','ঢাকা','www.dhakadiv.gov.bd',0,NULL,NULL),(7,'Rangpur','রংপুর','www.rangpurdiv.gov.bd',0,NULL,NULL),(8,'Mymensingh','ময়মনসিংহ','www.mymensinghdiv.gov.bd',0,NULL,'2021-09-22 01:10:51');
/*!40000 ALTER TABLE `divisions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entities`
--

DROP TABLE IF EXISTS `entities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `system_id` int NOT NULL DEFAULT '0',
  `parent_id` int NOT NULL DEFAULT '0',
  `entity_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entities`
--

LOCK TABLES `entities` WRITE;
/*!40000 ALTER TABLE `entities` DISABLE KEYS */;
INSERT INTO `entities` VALUES (1,1,0,'Chilling Plant','2021-12-27 00:02:05','2021-12-27 04:39:55'),(2,0,0,'Processing Plent','2021-12-27 01:08:53','2021-12-27 04:44:55'),(3,1,0,'Association','2021-12-27 02:12:14','2021-12-27 04:38:14'),(4,1,3,'Field Officer','2021-12-27 05:25:15','2021-12-27 05:25:15');
/*!40000 ALTER TABLE `entities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `informative_member_infos`
--

DROP TABLE IF EXISTS `informative_member_infos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `informative_member_infos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_of_cattle` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `informative_member_infos`
--

LOCK TABLES `informative_member_infos` WRITE;
/*!40000 ALTER TABLE `informative_member_infos` DISABLE KEYS */;
/*!40000 ALTER TABLE `informative_member_infos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `informative_road_types`
--

DROP TABLE IF EXISTS `informative_road_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `informative_road_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `road_type_id` int NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `form_id` int NOT NULL,
  `distance` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `informative_road_types`
--

LOCK TABLES `informative_road_types` WRITE;
/*!40000 ALTER TABLE `informative_road_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `informative_road_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci,
  `icon` text COLLATE utf8mb4_unicode_ci,
  `trash` tinyint NOT NULL DEFAULT '0',
  `position` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,'Association registration','সমিতি নিবন্ধন','/association/all','http://server.ecom.decode-lab.com/public/images/pencil.svg',0,8,NULL,NULL),(2,'Profile','প্রোফাইল','/admin/profile','http://server.ecom.decode-lab.com/public/images/Vector.svg',0,1,NULL,NULL),(3,'Milk collection management','দুগ্ধ সংগ্রহ ব্যবস্থাপনা ','/management/milk-collection','http://server.ecom.decode-lab.com/public/images/dudh.svg',1,7,NULL,NULL),(4,'Association Data','সমিতির তথ্য সংযুক্তি','/admin/association/data-add','http://server.ecom.decode-lab.com/public/images/pencil.svg',1,6,NULL,NULL),(5,'Survey report All','সমিতি জরিপ','/admin/survey-report/all','http://server.ecom.decode-lab.com/public/images/node.svg',1,7,NULL,NULL),(6,'System','সিস্টেম','/user/system','http://server.ecom.decode-lab.com/public/images/service.svg',0,2,NULL,NULL),(7,'User Role','ইউজার রোল','/user/role','http://server.ecom.decode-lab.com/public/images/user_role.svg',0,4,NULL,NULL),(8,'User','ইউজার','/user/access/all','http://server.ecom.decode-lab.com/public/images/sodossho.svg',0,5,NULL,NULL),(9,'Road Type','রাস্তার ধরন','/admin/road-type','http://server.ecom.decode-lab.com/public/images/road.svg',0,9,NULL,NULL),(10,'Permission','পারমিশন','/user/privilege','http://server.ecom.decode-lab.com/public/images/security.svg',0,5,NULL,NULL),(11,'Entity','এনটিটি','/user/entity','http://server.ecom.decode-lab.com/public/images/sodossho.svg',0,3,NULL,NULL);
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (36,'2014_10_12_100000_create_password_resets_table',1),(37,'2016_06_01_000001_create_oauth_auth_codes_table',1),(38,'2016_06_01_000002_create_oauth_access_tokens_table',1),(39,'2016_06_01_000003_create_oauth_refresh_tokens_table',1),(40,'2016_06_01_000004_create_oauth_clients_table',1),(41,'2016_06_01_000005_create_oauth_personal_access_clients_table',1),(42,'2019_08_19_000000_create_failed_jobs_table',1),(43,'2019_12_14_000001_create_personal_access_tokens_table',1),(46,'2021_11_22_070535_create_menus_table',1),(47,'2021_11_22_070558_create_sub_menus_table',1),(48,'2021_11_22_070609_create_action_menus_table',1),(50,'2021_12_01_103652_create_road_types_table',3),(51,'2021_12_02_053816_create_informative_member_infos_table',4),(52,'2021_12_02_053837_create_informative_road_types_table',4),(53,'2021_12_05_075818_create_survey_reports_table',5),(54,'2021_09_14_000444_create_districts_table',6),(55,'2021_09_14_005758_create_divisions_table',6),(56,'2021_09_14_195649_create_thanas_table',6),(58,'2021_12_13_062452_create_role_wise_menus_table',8),(60,'2021_12_19_083630_create_association_members_table',10),(65,'2021_12_26_101743_create_entities_table',14),(66,'2021_12_27_080715_create_systems_table',15),(67,'2021_11_22_065415_create_roles_table',16),(68,'2014_10_12_000000_create_users_table',17),(69,'2021_12_29_052535_create_associations_table',18);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `client_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
INSERT INTO `oauth_access_tokens` VALUES ('016f301d7990e50f5eda7ad2c5a708ed4821764e96524f918d7c167bac911b1b3426fcde806fc64f',1,1,'milk-vita','[]',0,'2021-11-23 04:49:17','2021-11-23 04:49:17','2022-11-23 10:49:17'),('019f06c8c8b6c8a421639fdf6b9fb409dd47c8455b419bbedede16f6a65b4594f53b573249f060c3',1,1,'milk-vita','[]',0,'2021-12-27 02:00:37','2021-12-27 02:00:37','2022-12-27 08:00:37'),('025c7869689180403458d3e6ef31406466e5a10fcf40476f6968a93d6841128bc6c371326f5a04af',1,1,'milk-vita','[]',1,'2021-12-07 04:33:20','2021-12-07 04:33:20','2022-12-07 10:33:20'),('02f5b680f3163963356a88182740c355691257ade5aa9d412905ac4465039f3a050a38c607556900',1,1,'milk-vita','[]',0,'2021-12-27 02:16:59','2021-12-27 02:16:59','2022-12-27 08:16:59'),('044d004fc917fc5431c4040a6d2fb54a030757674a9d5cd7678f17edf80132c8ebe49310e8780b90',1,1,'milk-vita','[]',1,'2021-11-23 05:35:30','2021-11-23 05:35:30','2022-11-23 11:35:30'),('0654ee37f080f2693342a1c976e4f71bce8913d8f762e9a68b669db9075368ef10ef66d5c33b6c5d',1,1,'milk-vita','[]',0,'2021-12-26 05:44:14','2021-12-26 05:44:14','2022-12-26 11:44:14'),('06e33c6f0c23c34cac6e13ca1bf04efd1a994d0358ccc39615d78e2b1e1769629ed708d1c764d370',1,1,'milk-vita','[]',0,'2021-12-14 23:35:13','2021-12-14 23:35:13','2022-12-15 05:35:13'),('07a1c20be51c32206568a9a4ca8d7cf17480ebbffb31b82f1421d82d7513de4cfb88e092ddabe450',1,1,'milk-vita','[]',1,'2021-12-07 04:45:39','2021-12-07 04:45:39','2022-12-07 10:45:39'),('07b1e5796ee68d4894d2a5b177bbd68f02a774cbe7ccb114f408e3e168e9b13539820758b1be574c',1,1,'milk-vita','[]',0,'2021-12-28 02:31:28','2021-12-28 02:31:28','2022-12-28 08:31:28'),('07d4440776d0a96351d71fab323f0cb3e3d630e82f4faec5608964a12caa4063bea02da0ddf796d5',1,1,'milk-vita','[]',0,'2021-12-13 08:50:01','2021-12-13 08:50:01','2022-12-13 14:50:01'),('07d481c3286e542181752561fc558129711e466795be6f89099e69913532d60696821ab18d00cfad',4,1,'milk-vita','[]',1,'2021-12-09 00:39:51','2021-12-09 00:39:51','2022-12-09 06:39:51'),('0915d5f55e584fb5da2f0c0fceac9591e2b6821d1fbb193167d8932bea90aafdb5d835d7cccbc608',1,1,'milk-vita','[]',0,'2021-12-19 01:31:48','2021-12-19 01:31:48','2022-12-19 07:31:48'),('0ba983d6dbe1da10b95d31901fee90b163d3af9e579b0c4ff432af8eca900645b4eb0b6eb1ffd290',1,1,'milk-vita','[]',1,'2021-11-23 05:43:23','2021-11-23 05:43:23','2022-11-23 11:43:23'),('0c5926a8c2ccdc400f837f9c4353e060a09722e68c2ed3496b87881a3a0468c18e16c72da9e1b305',1,1,'milk-vita','[]',0,'2021-12-26 00:49:29','2021-12-26 00:49:29','2022-12-26 06:49:29'),('0d621d96c7313c8f42957b99dc59845aef3f2544e5ff6b711dd6bd4c00ea3ab8cec37bbefe1075e1',1,1,'milk-vita','[]',0,'2021-12-26 05:32:19','2021-12-26 05:32:19','2022-12-26 11:32:19'),('0dc7a22fab9fefac0e5497efe44d0345a832b17524432eca7c18e4d9db14e2f64707d3d8d26d5095',1,1,'milk-vita','[]',0,'2021-12-26 05:45:34','2021-12-26 05:45:34','2022-12-26 11:45:34'),('0e14830fb2ab724a694e48821771c07e9610b784c9144c91c6adedaaaaf60fca793d6035e789d94d',1,1,'milk-vita','[]',0,'2021-12-26 23:01:31','2021-12-26 23:01:31','2022-12-27 05:01:31'),('0f2b4fd2d5efc4af91947db35e336003df2e1d10b363a5bc8a3ed880025ef20bb5d2b930cbdcec85',1,1,'milk-vita','[]',1,'2021-12-05 06:08:45','2021-12-05 06:08:45','2022-12-05 12:08:45'),('0fa78c4e043cead09ffe46e708510a655115a1af70a7329dc014f9ccc368ea02e427127c2d19c701',1,1,'milk-vita','[]',0,'2021-11-23 04:29:04','2021-11-23 04:29:04','2022-11-23 10:29:04'),('0ff09f52ec4e58660c420f432e0be50c7e40a4d1007eefc538fc4665a45d1a0f9ad8f7921ec48fc3',1,1,'milk-vita','[]',1,'2021-12-28 07:10:04','2021-12-28 07:10:04','2022-12-28 13:10:04'),('10e1a87319ff4164a86949cb781002e1a9784b69db7f701b9b896657b919d20b7773de73a14bd006',1,1,'milk-vita','[]',0,'2021-12-19 01:38:38','2021-12-19 01:38:38','2022-12-19 07:38:38'),('125c00810e11f6964071001817e798433c7a415da2868e0fe3f3f77a5d54875f0fb97b3bfc1b1769',1,1,'milk-vita','[]',1,'2021-12-05 22:19:53','2021-12-05 22:19:53','2022-12-06 04:19:53'),('132f66e0f0adbeb538e54da9df5c00204786faa903bd16c1ffc517dc7dae07ba28729499fa6aa0ae',1,1,'milk-vita','[]',1,'2021-11-24 00:09:30','2021-11-24 00:09:30','2022-11-24 06:09:30'),('132f91da2026d92b97f3f58121da4322fdaf832e38aa17fa5c0c6f0752711ebf0cf7d04b74da06a7',1,1,'milk-vita','[]',1,'2021-12-05 04:16:48','2021-12-05 04:16:48','2022-12-05 10:16:48'),('13a03e8c01ec9f761c2ab78f9a887a7d125443ee8acbbaacaae2400f7d8f49edaffac466d05a7c35',1,1,'milk-vita','[]',0,'2021-11-23 21:52:07','2021-11-23 21:52:07','2022-11-24 03:52:07'),('145eae7c15b5a88737fb8218001f084531d0648346be43148d121c39ad668a07f237a7a645aaffe8',1,1,'milk-vita','[]',0,'2021-12-19 01:30:41','2021-12-19 01:30:41','2022-12-19 07:30:41'),('156933d3296a16db51b21b2131aa74a8fae47d18d8f91de8c73758405090b1900ec61c8cb80613cb',1,1,'milk-vita','[]',1,'2021-12-14 05:16:06','2021-12-14 05:16:06','2022-12-14 11:16:06'),('17bdfdf3f625ea154852c6cd8901b3838d854c0c91fb6f8d6ff2a4b6f2525686f9d2d593b01a1f5a',5,1,'milk-vita','[]',0,'2021-12-06 01:29:27','2021-12-06 01:29:27','2022-12-06 07:29:27'),('183810398d98bbaac2ba342d139c1a00c1fb679d09d5f40bf3248cee45f8a31934453e49082a057e',1,1,'milk-vita','[]',1,'2021-11-23 05:28:22','2021-11-23 05:28:22','2022-11-23 11:28:22'),('1ab61a6926415fc4369bfdb732f22fedb99bea660afb368b1f9528a1dacf17b9b5ec64f91c2570c5',1,1,'milk-vita','[]',0,'2021-11-23 03:13:44','2021-11-23 03:13:44','2022-11-23 09:13:44'),('1ac77153654e7ccadb0126eee14e32babf7e4c5721dca27f6dccbdbcb44e77267d02a5d1d13daef4',1,1,'milk-vita','[]',1,'2021-11-24 00:26:13','2021-11-24 00:26:13','2022-11-24 06:26:13'),('1b0b5e8adb3beaa53631bbf84207320d34810b95dc3179ea26b4d55256e5268e435f3b9eb4c8853e',4,1,'milk-vita','[]',1,'2021-12-07 04:43:57','2021-12-07 04:43:57','2022-12-07 10:43:57'),('1b97b33fd1af6a85a158ace9ddb1c7692b7cd5e291c7f9f28425be98ba87f9c3e30bbec8b677de9e',1,1,'milk-vita','[]',1,'2021-11-25 05:16:48','2021-11-25 05:16:48','2022-11-25 11:16:48'),('1c9740ac34050ce89967e4491a0bbec670e55e13d77b51af836a182392a8c1c4fd6ec41ac5154a7f',1,1,'milk-vita','[]',1,'2021-12-02 02:45:16','2021-12-02 02:45:16','2022-12-02 08:45:16'),('1cad7f8378d488bfbd7362da65721fdc268969acd120a0cfef4a51d7fc8b7ac9eaceccb2ce29f024',1,1,'milk-vita','[]',0,'2021-12-05 00:25:39','2021-12-05 00:25:39','2022-12-05 06:25:39'),('1cb993800f1cc306f2ea0184eb5ad4cc4a99274a38df7862ee73d19e9a19e9168fb5845ad4b093fc',1,1,'milk-vita','[]',0,'2021-11-24 22:22:36','2021-11-24 22:22:36','2022-11-25 04:22:36'),('1e56cf731e0a2cae6398f064a0fdee2130aebb072c3d58ade05e3c843eb44e9205e4494ce62cc75f',1,1,'milk-vita','[]',1,'2021-11-30 01:29:56','2021-11-30 01:29:56','2022-11-30 07:29:56'),('1ea90fb3902024f1e20cae498d71f098df338a234682b30c293f84a66b23eb29687463dae064d588',1,1,'milk-vita','[]',1,'2021-12-07 04:13:31','2021-12-07 04:13:31','2022-12-07 10:13:31'),('1f97718157366c20385de1ecd2dfc0ae079967269cbb68fddb252f93004ab48167d521185aa8b55c',1,1,'milk-vita','[]',0,'2021-11-23 04:06:28','2021-11-23 04:06:28','2022-11-23 10:06:28'),('202deb7360df1515571585922bf8ac76c6b9ce651692cf9ffb1bce54b91ce04932a42071749fa6dc',1,1,'milk-vita','[]',0,'2021-12-02 05:02:07','2021-12-02 05:02:07','2022-12-02 11:02:07'),('22034b4d7d64ae02a6c57376e2ab1f7b5710044ed1f7b14e03828977d29f71db1b2eae6fddcf15e8',1,1,'milk-vita','[]',1,'2021-12-05 04:03:55','2021-12-05 04:03:55','2022-12-05 10:03:55'),('2213eeb5e1b3744b27031492e653e6756bebfb448308f20bf6787888b64cdd52a15c1943944ef0f3',1,1,'milk-vita','[]',0,'2021-12-27 04:49:48','2021-12-27 04:49:48','2022-12-27 10:49:48'),('22811151a9298a3d3b548eec81d04f434732d690fc42ca7d7cb57709c5b344fbdbb85eb944ea038e',1,1,'milk-vita','[]',1,'2021-11-30 02:08:00','2021-11-30 02:08:00','2022-11-30 08:08:00'),('23ac3e395771984e12c6365aed1ffa0e0c87c722e44e11236f9d5e10bf1ce1913b4c799d8d1ed1f1',2,1,'milk-vita','[]',1,'2021-12-05 04:06:10','2021-12-05 04:06:10','2022-12-05 10:06:10'),('23cbb3e1b3fbb3116b9cabfd905ae859a96ff62700704bd502ac0b31e00371a6def31d818ab43da9',1,1,'milk-vita','[]',0,'2021-12-26 02:47:43','2021-12-26 02:47:43','2022-12-26 08:47:43'),('25e43bfea43046da9d88380088f4c447d9ee0282c3a9855dfed403360f1ff8123681709aff91b315',1,1,'milk-vita','[]',0,'2021-12-13 06:01:03','2021-12-13 06:01:03','2022-12-13 12:01:03'),('27ddd536e2ae0ec9b1c84c827a88dd80ff12386744b46901b941ef3737ae28479939051244d41487',1,1,'milk-vita','[]',0,'2021-12-26 00:49:05','2021-12-26 00:49:05','2022-12-26 06:49:05'),('281073dbc1b2db9dfc1dcb9cee9637a02cca435944a32fc0bc9a91994cf64a06320c3722e0c5a760',1,1,'milk-vita','[]',1,'2021-11-24 00:06:47','2021-11-24 00:06:47','2022-11-24 06:06:47'),('283cedd3760784bf083a20154ee4e1e3085a69d33039edc35bae3a8bbf9125e1836c789cb58e7766',1,1,'milk-vita','[]',1,'2021-12-02 01:08:16','2021-12-02 01:08:16','2022-12-02 07:08:16'),('286d27fa1c98e38ccd1c9869a1aaa9648dcfc630db9b52fedec05d3ea6c1bb55a976d7ed8aa1ee3e',2,1,'milk-vita','[]',1,'2021-12-05 03:56:40','2021-12-05 03:56:40','2022-12-05 09:56:40'),('2a088915fb89a86bb6d75a534e498cf03b7b08aff03b918ec1d00562da566a343664093a2ccb261a',1,1,'milk-vita','[]',0,'2021-12-14 04:15:38','2021-12-14 04:15:38','2022-12-14 10:15:38'),('2a12013146e44a210839cfccff60d8d033f1ba18935129061d2cb7d649d14a02129f4e5bcd52cab4',1,1,'milk-vita','[]',0,'2021-11-23 22:29:45','2021-11-23 22:29:45','2022-11-24 04:29:45'),('2a9496d1685e441973e9ce6e7683c9d82faf99eefa35fda155f39b9c119ae0a8767c0c90ea67b194',1,1,'milk-vita','[]',1,'2021-11-24 03:05:10','2021-11-24 03:05:10','2022-11-24 09:05:10'),('2b00920640c99b35af8e1762b76a7848b6cb4bd05d72d6edc00d754f21da4e2fee6a7df001b35193',1,1,'milk-vita','[]',0,'2021-11-23 05:50:20','2021-11-23 05:50:20','2022-11-23 11:50:20'),('2c08c9ec8dafbbf218a91fbd81c85ba6d5b33955243b826a39fe53c45d2d54d57761a2eb4aba5b75',1,1,'milk-vita','[]',0,'2021-11-23 03:29:54','2021-11-23 03:29:54','2022-11-23 09:29:54'),('2c810331870f3bf1fc8bcb295639ee2905d3d1ca48c7b6d160cdd5e5448e9974a270b3d3f648681d',5,1,'milk-vita','[]',1,'2021-12-07 04:15:11','2021-12-07 04:15:11','2022-12-07 10:15:11'),('2d3f857923a72461cb135c73c21ba93209772c71c60c6b084d93655b2e5e37d0b53ab27fe6eeda36',1,1,'milk-vita','[]',0,'2021-11-23 12:26:42','2021-11-23 12:26:42','2022-11-23 18:26:42'),('2ea94e30da7250a3e477110133df29141256f28192dc76e40eeb9d1a6170b826ebc209bba6753dbc',1,1,'milk-vita','[]',0,'2021-11-30 02:25:26','2021-11-30 02:25:26','2022-11-30 08:25:26'),('2f1def05f064a6eb1db624dee2239762997953f34626de4e59c796013334dac9dada7d96ceb08c8f',1,1,'milk-vita','[]',0,'2021-11-23 22:24:05','2021-11-23 22:24:05','2022-11-24 04:24:05'),('2ffd44bad0c802c6adecd1c99299c31d530c9c75f305aecc40ada74282596474c4844886367efeb0',1,1,'milk-vita','[]',0,'2021-12-27 01:25:56','2021-12-27 01:25:56','2022-12-27 07:25:56'),('3055d5f0b98813f0b89f302329ac33fc3acfd6003d3e71239f3b302014df414971d98df8d1ef7228',1,1,'milk-vita','[]',0,'2021-12-26 23:24:38','2021-12-26 23:24:38','2022-12-27 05:24:38'),('30bb533b6e18fd3f47ba675a4f632378dc68092c570fe8f630000200cd00fb3a89dca8d7157983c3',1,1,'milk-vita','[]',0,'2021-12-09 03:10:51','2021-12-09 03:10:51','2022-12-09 09:10:51'),('30c8233f5403b8494e87ef6183e8552f59b7163afeeb2649e7aa7f0b7a2a64dd7c2ecac3713e07eb',1,1,'milk-vita','[]',0,'2021-11-23 04:25:26','2021-11-23 04:25:26','2022-11-23 10:25:26'),('30fe95ee63be6637afdb7220bf3eb3d457dbd685d60017c6e3ced9b4820a77b7d962d72937c58fa0',1,1,'milk-vita','[]',0,'2021-11-23 04:12:13','2021-11-23 04:12:13','2022-11-23 10:12:13'),('32e81dff4def4bcc901867271d7eb384d4f63ddfcb77e62a8f32b218896eec484c9206fab299c12c',1,1,'milk-vita','[]',0,'2021-12-28 07:08:08','2021-12-28 07:08:08','2022-12-28 13:08:08'),('33d97c3d5a8d97d6695c575497aa2ca08cff4ec144648edc767b4ca86748932e4cb9e5e2f7add4c6',1,1,'milk-vita','[]',0,'2021-12-26 02:45:21','2021-12-26 02:45:21','2022-12-26 08:45:21'),('341c115babb61eaebaa7ce34f06c560f8bc3022d31d4d27f66835bfe6cdcc29fbe7343510513be27',5,1,'milk-vita','[]',1,'2021-12-06 01:08:10','2021-12-06 01:08:10','2022-12-06 07:08:10'),('346e61e15cabf6206e7f6b8b73fc1989198b31c8127ae3309d0d60c86716f81af2a42fa3284c84e8',4,1,'milk-vita','[]',1,'2021-12-09 04:47:36','2021-12-09 04:47:36','2022-12-09 10:47:36'),('37261c22f54b9af1f434fc7d20d604564d8ce21413c2a73d1b36ebbfc7ddef933c6427ec0b1a9eaf',4,1,'milk-vita','[]',0,'2021-12-08 04:48:25','2021-12-08 04:48:25','2022-12-08 10:48:25'),('37923b0ac2c4e5a3045a6a74091a2a45ec5e4e59a15b5b43b4c1a0035c35be624f1eef5b0a5450ca',1,1,'milk-vita','[]',0,'2021-12-27 02:27:47','2021-12-27 02:27:47','2022-12-27 08:27:47'),('3799627a677d52776951abeff459174014a6899ddaac9fc55acfbf70e4453a9026de2d3e46fd9664',1,1,'milk-vita','[]',0,'2021-12-26 05:34:24','2021-12-26 05:34:24','2022-12-26 11:34:24'),('38515d102099d8f27eb7545145233f078a3f9f93400c51c780166e69d18b9ecce49ca53c698f2266',1,1,'milk-vita','[]',0,'2021-11-23 12:26:10','2021-11-23 12:26:10','2022-11-23 18:26:10'),('39220f5c3234c7932c0c1636f0012c392656cf048ee0fd7f9b30996e8c24cd033db403883cff45f2',1,1,'milk-vita','[]',1,'2021-11-24 03:01:56','2021-11-24 03:01:56','2022-11-24 09:01:56'),('3a01ba59b6026547d069b7874f1776a5491e8602a431d57a702d78f4965558fbf0933770d0a0c10a',1,1,'milk-vita','[]',0,'2021-11-23 04:11:19','2021-11-23 04:11:19','2022-11-23 10:11:19'),('3a49e6b2f46a8ca2be7299656615930a37019b3e9000c07a31f0487d6e08c1ce1edb8458d6b1620d',1,1,'milk-vita','[]',0,'2021-11-23 06:00:17','2021-11-23 06:00:17','2022-11-23 12:00:17'),('3e472ac449f48f8ae053b43d672f9acd690c33273347eb33f9ab4bad9c362f9c9a2d3b91bbdab865',4,1,'milk-vita','[]',0,'2021-12-09 00:37:52','2021-12-09 00:37:52','2022-12-09 06:37:52'),('403edbcb9e4d5c787b5430618eb0b60986cb024f6270ea30c2e52d9b5ba457df55356be813ab275d',1,1,'milk-vita','[]',0,'2021-11-23 04:07:54','2021-11-23 04:07:54','2022-11-23 10:07:54'),('405177b6e423228a5060b173b1485d5cb1100a11c9aff4d5aa21f8cc5d9715c33fd451030eb35085',1,1,'milk-vita','[]',1,'2021-12-06 00:47:43','2021-12-06 00:47:43','2022-12-06 06:47:43'),('41a42a9f643f5171ccc9c2b814fef841333b3f9d168863d0d0de84c3142f983c8ce77878d06065c4',1,1,'milk-vita','[]',0,'2021-11-23 21:52:14','2021-11-23 21:52:14','2022-11-24 03:52:14'),('41cd929470a1f417ee4f2cc047559fa8830b3642ba2f60621cca416c4c9e1631c4157d96af16602a',1,1,'milk-vita','[]',1,'2021-12-28 07:08:30','2021-12-28 07:08:30','2022-12-28 13:08:30'),('4237d1b16470f555b338bb17fca9bbf7f2eea9aff1163838af097ca94732e2ab881a8cd749b18a2d',1,1,'milk-vita','[]',0,'2021-12-02 03:02:51','2021-12-02 03:02:51','2022-12-02 09:02:51'),('423845ad030468694b625b2f8cbb8c9f6dac5ca8bc520f8e9db613827474b68caf7864d1f77c82cd',1,1,'milk-vita','[]',0,'2021-11-25 05:20:37','2021-11-25 05:20:37','2022-11-25 11:20:37'),('42518e1777a96ab569e5f0f60c03abdbb6a6d7016309db0ae5c868455fbb7322973d917ff3d1c88b',1,1,'milk-vita','[]',0,'2021-12-13 01:56:14','2021-12-13 01:56:14','2022-12-13 07:56:14'),('428d855f44205fa7a61fb9d8be4ec58dcc2a200ca260292b06f6f7c48d8faa05c4c4848581a96191',1,1,'milk-vita','[]',0,'2021-12-13 04:35:02','2021-12-13 04:35:02','2022-12-13 10:35:02'),('432f1e4c3fbeeacb65eac03015c66c30cbad5cb3bf856b0ca8ea1a41aee56d5bcfaf25c1a310975d',1,1,'milk-vita','[]',0,'2021-12-26 05:20:50','2021-12-26 05:20:50','2022-12-26 11:20:50'),('44d63224f60bf5312f01856187a74ea0a8f6e0f6da1a21519e89d41f31e014ec0f4d2f1f73d2a1de',1,1,'milk-vita','[]',0,'2021-12-28 07:13:03','2021-12-28 07:13:03','2022-12-28 13:13:03'),('45cfe644dbbe807f3e86ca60df798281abeccabe775d37776ff18f0bb85bbc9c40d282f785a5e4ef',2,1,'milk-vita','[]',0,'2021-12-05 04:20:09','2021-12-05 04:20:09','2022-12-05 10:20:09'),('463a069dc3821c60f346965fa8868812b9ec2c17a2d1183f6ca3fe32ebf380f549715da561ee9204',1,1,'milk-vita','[]',0,'2021-11-23 03:14:28','2021-11-23 03:14:28','2022-11-23 09:14:28'),('47dd894b93065efcaae8c9bd256cb139577751f28252fa1e901e6bd8f9588d031fbc0329215d3323',1,1,'milk-vita','[]',0,'2021-11-23 23:34:37','2021-11-23 23:34:37','2022-11-24 05:34:37'),('49e7c2f011c12a1f90cccedf47a3d62175f7c0061664fea620b1c3f4707876cd4855721a07eccd95',5,1,'milk-vita','[]',1,'2021-12-07 04:36:43','2021-12-07 04:36:43','2022-12-07 10:36:43'),('4a33d8773545716d136c2c6b5006ec7c0dc44e912c13762bccc3dd5b12ad3a2fc2069c8df9bd2d69',1,1,'milk-vita','[]',0,'2021-12-27 00:07:40','2021-12-27 00:07:40','2022-12-27 06:07:40'),('4a5d557c8b60cb167400ac514ff38ffcd05d120bb467c6282ed8201f494eb4606460095eb5c9f3f9',1,1,'milk-vita','[]',0,'2021-11-23 05:51:07','2021-11-23 05:51:07','2022-11-23 11:51:07'),('4a6dd5272c4c73441d09f52c1fd5e06e84abe9a06cf160b32a0a25f9a04ae6e7fc55ef46c547c4c3',1,1,'milk-vita','[]',1,'2021-12-07 04:42:07','2021-12-07 04:42:07','2022-12-07 10:42:07'),('4b0c03393b33f842f620856bd7c322c7ad68be002aa60dd54aeb55d80e2cbb3d553b47c52d1b8a9a',1,1,'milk-vita','[]',0,'2021-11-23 23:02:22','2021-11-23 23:02:22','2022-11-24 05:02:22'),('4dcb59d9da63b3354398d33d7529df39f9e81433dfb92202740a1966bded4ac1c257a10c31b54883',1,1,'milk-vita','[]',0,'2021-12-21 00:34:46','2021-12-21 00:34:46','2022-12-21 06:34:46'),('4e33c1f6826a86bf0688c939401d4601a8d64a00127c085694ca41466005e3ccb41ba6c5607c037b',1,1,'milk-vita','[]',0,'2021-11-23 22:29:32','2021-11-23 22:29:32','2022-11-24 04:29:32'),('4e937ccd7182ac81bc14c4ac8b89633f881117dad8c3a0e412978f7ebae7f92ff6d79104b8cf0b60',1,1,'milk-vita','[]',0,'2021-12-13 03:26:08','2021-12-13 03:26:08','2022-12-13 09:26:08'),('50e8d319c9a6e901af1516b3fe511bcb37d5cde26f4272258259865b22dc4f5150d0f05ea0c65933',1,1,'milk-vita','[]',0,'2021-12-27 02:16:03','2021-12-27 02:16:03','2022-12-27 08:16:03'),('51981ac0b8605553afbc8e5cf6119ff7b820aba7c364a8279e6cb780e0b56b8d4d6139d1dc16c79c',4,1,'milk-vita','[]',1,'2021-12-06 03:40:47','2021-12-06 03:40:47','2022-12-06 09:40:47'),('51f700107efaab025de636df9d96e212c4526ce193175dec7df1914dc541fe63aecdd86cad8d8545',1,1,'milk-vita','[]',0,'2021-11-23 04:03:55','2021-11-23 04:03:55','2022-11-23 10:03:55'),('522484c192d43042ad9654410795744d359b3fe71c10cf2749953c11077b4c0c00078d71ea7815b5',1,1,'milk-vita','[]',1,'2021-11-23 05:34:27','2021-11-23 05:34:27','2022-11-23 11:34:27'),('52b3f30fcbb0de78fcb170625f92b8a3e5e688b83a618a39c10fdfafdad182d0ced3211f82dc253f',1,1,'milk-vita','[]',0,'2021-12-28 04:40:46','2021-12-28 04:40:46','2022-12-28 10:40:46'),('52d314e00747e7e2dab42715b38d8af9c856a5fb57503717b163a202e550eaa74f56b1a9c0a2db40',3,1,'milk-vita','[]',1,'2021-12-21 00:59:54','2021-12-21 00:59:54','2022-12-21 06:59:54'),('5356f39af378b6d3642ae71dec21f7b502303d68786e5ad610d7871f276a1cbaef40b0b35546d225',1,1,'milk-vita','[]',1,'2021-12-05 02:37:09','2021-12-05 02:37:09','2022-12-05 08:37:09'),('538da90a86e54feae7503201d6d343eeb9ed8f83ed3509ff708c632f26a463aefda16a5dcdf51ed8',1,1,'milk-vita','[]',1,'2021-11-24 03:02:48','2021-11-24 03:02:48','2022-11-24 09:02:48'),('54045a9edbdb54fbc6caf0475c74d523613cbbefac32e693b67cef5b96098baeb46d3ba3544c9a95',1,1,'milk-vita','[]',1,'2021-11-30 00:41:09','2021-11-30 00:41:09','2022-11-30 06:41:09'),('54224133f1e9346679e10f54b1878d5566406040b70c4ab55b6432eaed87093e5ec2dd6fb50b4c17',1,1,'milk-vita','[]',0,'2021-12-27 04:49:10','2021-12-27 04:49:10','2022-12-27 10:49:10'),('5485df335fec291126481589572181736c0ffc362201e92754b13bf2c2cc7c0481270cc43972dec5',1,1,'milk-vita','[]',0,'2021-11-22 01:29:35','2021-11-22 01:29:35','2022-11-22 07:29:35'),('55aefbbeeeef629a913940d752803a9a01bc2a5c49c0f5da63742eb3e429b924192864e4572c70ff',1,1,'milk-vita','[]',0,'2021-12-12 22:48:40','2021-12-12 22:48:40','2022-12-13 04:48:40'),('5651bcdc6ea710fc63a9defd9dfde61274d8a974fdfcff51a593f03674273bf8ea871cf627952e7d',1,1,'milk-vita','[]',0,'2021-11-24 22:22:39','2021-11-24 22:22:39','2022-11-25 04:22:39'),('570688a4911a45fcceeeb4df25834edc9dfaa36236251ab846ec83e9e2fa8f54d14b2ed399c78250',2,1,'milk-vita','[]',1,'2021-12-05 05:44:22','2021-12-05 05:44:22','2022-12-05 11:44:22'),('586455ea12a313f53ac5a6bf019121241996873c853bcbf1d00f3d9f178338e05bd9627d62431727',1,1,'milk-vita','[]',1,'2021-11-30 02:11:51','2021-11-30 02:11:51','2022-11-30 08:11:51'),('59ccaa07e06f78a73815756ab146d2325980d5dcb9d35e8506b182fa94eeac6050d2fcd202561015',1,1,'milk-vita','[]',0,'2021-12-09 01:55:43','2021-12-09 01:55:43','2022-12-09 07:55:43'),('5b6c46a5b43416f6f9a030042045123b86b63b60cca55791af2601b231dead24b9c9e755b05377d7',1,1,'milk-vita','[]',0,'2021-11-23 05:50:45','2021-11-23 05:50:45','2022-11-23 11:50:45'),('5c37d31f046af5a0dd8e4c990cee8e9c60262e0af95e9afefffda6bf9334db73d980b142d231e2ac',1,1,'milk-vita','[]',1,'2021-11-25 05:15:32','2021-11-25 05:15:32','2022-11-25 11:15:32'),('5cb80f492157530c967453aead930999ad68d94e0a04ab79da10d89b3d9b15bcd47120d0c1c4ed26',1,1,'milk-vita','[]',0,'2021-11-23 05:52:26','2021-11-23 05:52:26','2022-11-23 11:52:26'),('5ed6b0fdc28bbb928eb9ad18f82cd35ca907c0ad6c827ee345d68b5d31a13e8fec2afa4a9f7b60a3',5,1,'milk-vita','[]',1,'2021-12-06 01:31:15','2021-12-06 01:31:15','2022-12-06 07:31:15'),('5ee9b1ff64c75de1b8f8c922fb3f838d0d54e5b55c0ed81c9ced603173535d7da468b6561cef40a2',1,1,'milk-vita','[]',0,'2021-12-27 03:49:23','2021-12-27 03:49:23','2022-12-27 09:49:23'),('5f6da428ceb0bf572432bb2982482397ebac6dfb48cf6661eae578253bfa9e31d39edd311f3c8fad',1,1,'milk-vita','[]',0,'2021-12-27 00:07:27','2021-12-27 00:07:27','2022-12-27 06:07:27'),('602c59191fda9857463bdf534a1a93b847782758a1a3d0d986dffd5e2184abfc3183c9c6a217275c',1,1,'milk-vita','[]',0,'2021-12-07 22:07:41','2021-12-07 22:07:41','2022-12-08 04:07:41'),('61cfd4cb6778e25b1ee3949e26b4301540bcaf7d46d978418d9724cf0f6faedb85bd71606ce88a8b',1,1,'milk-vita','[]',0,'2021-12-27 03:51:02','2021-12-27 03:51:02','2022-12-27 09:51:02'),('61f45b4ae5a04700a6af0b3b8d20d99d338a785dd01198c907106247eb5b73b85c41a41660f46ad4',1,1,'milk-vita','[]',0,'2021-12-13 06:00:43','2021-12-13 06:00:43','2022-12-13 12:00:43'),('624f90b9c175851f0776d3b7b91dcf00993709ddc9e23daed6711f7edac0bd78e88fb5ffc1444382',1,1,'milk-vita','[]',0,'2021-12-13 01:59:49','2021-12-13 01:59:49','2022-12-13 07:59:49'),('6380024b0d34c7b73ff0c7b297775acf3e9fa144fcfc0d891679bbb3c3d56e4a237e50da5ee0753a',2,1,'milk-vita','[]',1,'2021-12-06 00:55:51','2021-12-06 00:55:51','2022-12-06 06:55:51'),('63d9a1277bf7974dc514b07dd55dcc5655c483bb64868a5e7437a50c24f5d3a8764607bfbd768bc9',4,1,'milk-vita','[]',1,'2021-12-07 04:14:17','2021-12-07 04:14:17','2022-12-07 10:14:17'),('63fc80d7eea255a1aefe83a214f7f627992ebfcc5bdc44ba67c581f028a78752b81cb8db317a1ab3',1,1,'milk-vita','[]',0,'2021-12-05 00:25:41','2021-12-05 00:25:41','2022-12-05 06:25:41'),('643eda6438ad8245342399e26b7354213185e0bd6806c64fb9888f96a464df14a5dcf4b5c285ea69',1,1,'milk-vita','[]',0,'2021-12-02 05:03:59','2021-12-02 05:03:59','2022-12-02 11:03:59'),('644975fa0908f56562e7ebc8403eab3b8000bd4b7a2e1ec0516d35b5087cb09f3a2f7756155b2ba6',1,1,'milk-vita','[]',0,'2021-12-21 01:55:47','2021-12-21 01:55:47','2022-12-21 07:55:47'),('644be81216e11f9af5598b9863b6a5d9ff523d1de4161bf6d58134d428594fbc06f13154a036f211',1,1,'milk-vita','[]',1,'2021-11-24 03:00:03','2021-11-24 03:00:03','2022-11-24 09:00:03'),('65033393189e0ec2ba3b127552050a952ed03bcd21f53c34d5f4d0e7bc1a5bbaf7ba7cc90e504070',4,1,'milk-vita','[]',1,'2021-12-09 22:47:43','2021-12-09 22:47:43','2022-12-10 04:47:43'),('657602d23a6c75306e5065e3b14d5ad3254e1244bc353b8b13be960c26dfda5558169134be44ef33',1,1,'milk-vita','[]',1,'2021-11-23 04:28:26','2021-11-23 04:28:26','2022-11-23 10:28:26'),('65cc5ec422e9ef32552a058c82959b41f38513c4808b77d98d4eec3da85fd3d017043bf912fca305',4,1,'milk-vita','[]',0,'2021-12-08 03:43:17','2021-12-08 03:43:17','2022-12-08 09:43:17'),('65ee39b677d88698a2cf3616b3f487f1f89f84e872f248f10da6e1891dad0dfca1037bb1e3a88cd7',1,1,'milk-vita','[]',0,'2021-12-27 02:28:23','2021-12-27 02:28:23','2022-12-27 08:28:23'),('6668eddb5056d09fb6caac54a8034546777baa756b2ab4c4b70b403bbbc94513ecb31a143293d7fb',1,1,'milk-vita','[]',0,'2021-12-13 04:33:47','2021-12-13 04:33:47','2022-12-13 10:33:47'),('669c32d83e4c383bcaf5f794750fbc65383eab02ac062fb566539d284e388267e4bd06994da81665',1,1,'milk-vita','[]',0,'2021-11-24 22:16:14','2021-11-24 22:16:14','2022-11-25 04:16:14'),('6726867e9b23a427c9cdf8fc4d7243692ed2d66db79deca9a3065b223aa5c8d3a22639283f6ed4ad',1,1,'milk-vita','[]',1,'2021-11-30 02:10:39','2021-11-30 02:10:39','2022-11-30 08:10:39'),('67e755dde4b835ce5b1f02942ec12fa3cc67098167fb2285400618f9ce94c48ac3238e8d20bbcb4f',1,1,'milk-vita','[]',0,'2021-11-23 05:49:57','2021-11-23 05:49:57','2022-11-23 11:49:57'),('68e511136ca649857891c34766cb9bfc9819b61ebeff6ac183a003f0eb66026f66418899cc8bad37',1,1,'milk-vita','[]',0,'2021-12-13 01:56:33','2021-12-13 01:56:33','2022-12-13 07:56:33'),('6943d19658879fdadee5e9c40e799135870959f8b88e982e28ab0d174fb837b037aa22fee87051c2',1,1,'milk-vita','[]',0,'2021-11-23 04:02:37','2021-11-23 04:02:37','2022-11-23 10:02:37'),('69931033b21f5954e92d24e73e3b7f79cc61ec705cc0dd9489bf599f13bdd6acb187f92e1879a637',1,1,'milk-vita','[]',0,'2021-11-23 04:08:06','2021-11-23 04:08:06','2022-11-23 10:08:06'),('69afa4c368d4b9494a20a95108d77fb5fce19a30dc3d7daf0d598991a526156fb816e99ec109e863',1,1,'milk-vita','[]',0,'2021-12-13 23:51:57','2021-12-13 23:51:57','2022-12-14 05:51:57'),('6a0babadf4262830dfbc720160b77df88ff96c59d14d706152c56be096199e65647d6b934dd1364f',1,1,'milk-vita','[]',1,'2021-12-21 01:01:33','2021-12-21 01:01:33','2022-12-21 07:01:33'),('6a283f35c6eb49082b1cf2863d9b182e37fafb847e2d9ebe5d4c05975dd79bde7e500684b4813be7',1,1,'milk-vita','[]',0,'2021-12-26 05:20:44','2021-12-26 05:20:44','2022-12-26 11:20:44'),('6a67836b2fdb58d492dc920e662aec90e5b56f4c7ec9da6fdb84fb077bf9d4be4a8f8e147f289cd1',1,1,'milk-vita','[]',1,'2021-11-30 00:47:13','2021-11-30 00:47:13','2022-11-30 06:47:13'),('6a952193aab405ffc173ce930679f6e9ae896b4058649d224f6171dc5ce0165090eb7333666ab508',1,1,'milk-vita','[]',0,'2021-12-27 00:07:12','2021-12-27 00:07:12','2022-12-27 06:07:12'),('6c8a4233401cc0524b373f4e2cc366045affa73d39b21f7be811f119ed5e240cfae1063c6d87c6d5',1,1,'milk-vita','[]',0,'2021-12-07 22:07:39','2021-12-07 22:07:39','2022-12-08 04:07:39'),('6e241ec57c0cfdf243e650bdf2bb200cc65e026aeb2c0e808c95cbc9f107e49192b9d4cae604f2b2',1,1,'milk-vita','[]',0,'2021-11-24 00:04:41','2021-11-24 00:04:41','2022-11-24 06:04:41'),('6f69056b01643ec31f7ee284c2e8bededb0012e2c25737befb920892b56a8e4d2f67d87ed3f88fce',1,1,'milk-vita','[]',1,'2021-12-08 04:48:06','2021-12-08 04:48:06','2022-12-08 10:48:06'),('721e5b2ba413fcd5e3da86d6e93d6070306a50b1d4e9cac8af6ce06369ff291e9333e3404d48dcd9',1,1,'milk-vita','[]',0,'2021-12-27 02:00:53','2021-12-27 02:00:53','2022-12-27 08:00:53'),('738f0870b4557dd5e8133d52028d69184bdf8a60e3295e84f36538147264ed8f462e0f1056aa1532',1,1,'milk-vita','[]',0,'2021-12-05 21:55:09','2021-12-05 21:55:09','2022-12-06 03:55:09'),('7442b799caf64cee5494cdccbc324c655235c3552ba38a60184ecb43451b4b80bed9be9b21e1f9cd',1,1,'milk-vita','[]',1,'2021-11-24 03:03:23','2021-11-24 03:03:23','2022-11-24 09:03:23'),('747b2fb8c5c6bb7c4bd0f84f14e72cb5a3bf20983cfc4a252081a76cb7a5c742f88cb61618253668',2,1,'milk-vita','[]',0,'2021-12-05 05:42:57','2021-12-05 05:42:57','2022-12-05 11:42:57'),('75261dbed8dca759fdd7dfde7475d3374b4f3db17b21efb06b275cea8e8a2525a760fb283a5c1298',1,1,'milk-vita','[]',0,'2021-12-13 06:00:28','2021-12-13 06:00:28','2022-12-13 12:00:28'),('75693ca203f51311909827420cf211d5329ad837b77ffa95fd1291b499bf4a6f61b37545027b05ec',1,1,'milk-vita','[]',0,'2021-12-13 03:25:33','2021-12-13 03:25:33','2022-12-13 09:25:33'),('766b0f1cc979af4847e3e5581a5d1f996589d4c25eae76400893ccf598a8a2032419afebd0014069',1,1,'milk-vita','[]',0,'2021-12-27 01:25:23','2021-12-27 01:25:23','2022-12-27 07:25:23'),('76ce1608bfda39df943664ee873f2b13f97dc0a5c8ed3d8fb08ef261cdc3ba880e35b8f6f090aeae',1,1,'milk-vita','[]',0,'2021-11-23 12:28:06','2021-11-23 12:28:06','2022-11-23 18:28:06'),('7717204b475049248c003d53032e8ac558d9f052ff0311adc93f435a0953a09e0767ff6ae90b9f96',1,1,'milk-vita','[]',0,'2021-12-27 00:01:53','2021-12-27 00:01:53','2022-12-27 06:01:53'),('7731515f080231c84ab0a89edfe4f6f4e8ce11894f8612f3f0e70094a989e3dc33f311f53a39a947',1,1,'milk-vita','[]',0,'2021-11-23 04:14:26','2021-11-23 04:14:26','2022-11-23 10:14:26'),('77891dd6dd06ae0d40d6f68aeec37a11861ef3f2b7727cc99205925411aa92152be01e88442ab04a',1,1,'milk-vita','[]',0,'2021-12-28 06:10:18','2021-12-28 06:10:18','2022-12-28 12:10:18'),('790499f90840e8b870c169e3ed9cc4946134bd3b3a96f0eae2d73fb655cbc667f1dfecb750aaa2bc',1,1,'milk-vita','[]',0,'2021-12-13 03:39:04','2021-12-13 03:39:04','2022-12-13 09:39:04'),('794b6c0e69f166a127506f1cc485549074d4a61c490bc783399cb9a843f504fdb312397b16a6276e',1,1,'milk-vita','[]',0,'2021-12-19 03:40:50','2021-12-19 03:40:50','2022-12-19 09:40:50'),('7a672f6dd2acf60e4cf67d9cf6d03fbaae172a069d281333d1576ed39f5321a58f33fc96ab2c9eab',1,1,'milk-vita','[]',0,'2021-11-24 00:25:48','2021-11-24 00:25:48','2022-11-24 06:25:48'),('7ae0b9c6c04b40bd158eda616a4cbfb46a49f1806ec420f3e00900510a4709d03b490715d84844c8',1,1,'milk-vita','[]',0,'2021-11-23 23:34:31','2021-11-23 23:34:31','2022-11-24 05:34:31'),('7c078d73fd2e0f4bf7500c0b7af8088c221f037a226440b9e73f526041cfeaa10358569a9a1a3e93',1,1,'milk-vita','[]',0,'2021-12-28 06:11:36','2021-12-28 06:11:36','2022-12-28 12:11:36'),('7cafd6efe5a942414b8e72a217b95283ba129be8e6af3f24d3ad18223513c428828c7f7f5bade485',2,1,'milk-vita','[]',1,'2021-12-05 00:35:03','2021-12-05 00:35:03','2022-12-05 06:35:03'),('7d8af066eb70d6f9690a031180d1c62402dffa85e36e757096bf370602c4c97b13c9e7c0519bf2ae',1,1,'milk-vita','[]',1,'2021-11-25 04:52:03','2021-11-25 04:52:03','2022-11-25 10:52:03'),('7efbd97be4962c728e05d3837bfcd86081c681abc8f9d70de0613fe113c634a9d0812a3244f08a9e',1,1,'milk-vita','[]',0,'2021-12-06 01:33:08','2021-12-06 01:33:08','2022-12-06 07:33:08'),('81a1e1774ffaf556fb36503e48205cf2c8aef6a1b6fa53eb2ee9798cfe3fa9cafd3462c9c1151b28',1,1,'milk-vita','[]',1,'2021-12-07 22:08:20','2021-12-07 22:08:20','2022-12-08 04:08:20'),('81cf665e36c5e97309bf09d413fbf2287c931ece6022b727ded4bbebf18d29c16c6fa2e716b76bb8',1,1,'milk-vita','[]',0,'2021-12-02 05:04:56','2021-12-02 05:04:56','2022-12-02 11:04:56'),('82889e24b9e17d2242c84e996b02ab5727a659b2a04e4e5d148fcbeef6f91039f23ce70c644fe39f',1,1,'milk-vita','[]',1,'2021-12-06 01:12:52','2021-12-06 01:12:52','2022-12-06 07:12:52'),('82fed7dfc530a13414c649042ae6cf5239ac9b62b50fc0f3b42e3400c519fda97adb667fc8d96a75',1,1,'milk-vita','[]',1,'2021-12-05 00:32:07','2021-12-05 00:32:07','2022-12-05 06:32:07'),('834074b0d2c5361688a2ac386b3a614cdaaf0eadeadb244084be72ef5f7402da8054d3975c3baace',1,1,'milk-vita','[]',0,'2021-11-23 04:00:48','2021-11-23 04:00:48','2022-11-23 10:00:48'),('844565f4cbd964acb30f37dbee3af2444430e8ffbc0c857d5ab50c3c90866164ff58af4ca629872a',1,1,'milk-vita','[]',0,'2021-12-09 02:48:18','2021-12-09 02:48:18','2022-12-09 08:48:18'),('84faf60d1e53d6cc0b96c1baae9cb4de794cbb78c0b3736ac3461272cfe83f7327bd12ba6daad9f7',1,1,'milk-vita','[]',1,'2021-11-25 05:18:15','2021-11-25 05:18:15','2022-11-25 11:18:15'),('85457ac71813300cbe6e2c19b58446b01a06a6e59f189f9a25bf941a230de2a77fdb59608e5faeda',1,1,'milk-vita','[]',0,'2021-12-28 23:23:53','2021-12-28 23:23:53','2022-12-29 05:23:53'),('858f3640885f1e88d8193960edc223059c2fe9e00516a4ec1e16a0eca73dff74cf9c836b2a26ab95',1,1,'milk-vita','[]',0,'2021-12-28 23:22:22','2021-12-28 23:22:22','2022-12-29 05:22:22'),('8695eb72fdad30faa7101999f99b96d81afcba59b51c875d67cd71d7531ea24ba7811d08241507e4',1,1,'milk-vita','[]',1,'2021-11-23 04:29:35','2021-11-23 04:29:35','2022-11-23 10:29:35'),('89587d699ee029fde813e75b19313a9c1bcc3b32e40f182aeec6176c78e71ba42c01572627968cb4',1,1,'milk-vita','[]',0,'2021-12-26 02:49:37','2021-12-26 02:49:37','2022-12-26 08:49:37'),('895b1ce05f08278213fec94f474207bcc3feeb8d551fbd70bffc997427765dae0b2c3af6d25dc195',1,1,'milk-vita','[]',0,'2021-11-23 04:01:27','2021-11-23 04:01:27','2022-11-23 10:01:27'),('8abaf8b16a5a02e7bc8f8127725fb007566e2e6e3f429ba36b6af2a70b9ecd3fe3dacdb1319d1a3b',1,1,'milk-vita','[]',1,'2021-11-24 03:01:48','2021-11-24 03:01:48','2022-11-24 09:01:48'),('8ae50ce08ef4dbdc758afad44430dc6a4bf1f7ec4612895206525afbd45204d27acc3342cedc5d94',1,1,'milk-vita','[]',0,'2021-12-28 03:13:47','2021-12-28 03:13:47','2022-12-28 09:13:47'),('8b974287565d08dfc1138244ffd8430717b30949b6b59f7d556895a38d0eb47526076c00b06b0465',4,1,'milk-vita','[]',0,'2021-12-08 03:46:14','2021-12-08 03:46:14','2022-12-08 09:46:14'),('8cda098a2c186fa410aa3d01a80847ea8c40ad200281eb57792603607e5bbbae5f5542add25e7901',2,1,'milk-vita','[]',1,'2021-12-05 06:09:09','2021-12-05 06:09:09','2022-12-05 12:09:09'),('8d56070b299a42263b124fc026921585c689b4638f405eba9266d68c48ca4d1b8645345416d0c090',1,1,'milk-vita','[]',0,'2021-11-23 04:05:27','2021-11-23 04:05:27','2022-11-23 10:05:27'),('8f32422a1b2de381a07b7ddb3074f3c134fc0816fb0096f874ab6e5fa4fb128ba190f0597c19878e',1,1,'milk-vita','[]',0,'2021-11-24 00:05:53','2021-11-24 00:05:53','2022-11-24 06:05:53'),('901014ac65a72405f073271768a021814e9a60008cc2163f0db12ff30a25f8e79385617d50bd0508',1,1,'milk-vita','[]',0,'2021-12-09 01:55:08','2021-12-09 01:55:08','2022-12-09 07:55:08'),('904d9d4b373604c52a444e679dd65d9b559c1181e118b5c82419aa88e8c5285bb27e9c71e01b410b',1,1,'milk-vita','[]',1,'2021-12-05 02:42:53','2021-12-05 02:42:53','2022-12-05 08:42:53'),('90899274eaff31144f934228bb169e63581e565ecc13c693c540b346563581b06312e9c7d48656b2',2,1,'milk-vita','[]',0,'2021-12-05 02:43:49','2021-12-05 02:43:49','2022-12-05 08:43:49'),('90b1a8514a1b7ca4db01aba87e8d72a34f6fe3a6bb3475176186d70272dd0c55e12058d423217579',1,1,'milk-vita','[]',1,'2021-11-29 23:49:41','2021-11-29 23:49:41','2022-11-30 05:49:41'),('912bda07af4dbdacd6d031d953b495bd1db0ea60762da1c3470e4cff7917eba3bffa873688e8341d',1,1,'milk-vita','[]',0,'2021-11-23 04:09:17','2021-11-23 04:09:17','2022-11-23 10:09:17'),('9161cbdfdbed3c12b76927476141a725837fc79d37929081b2bc1840a8c4134a2c8e8177bb667f85',1,1,'milk-vita','[]',0,'2021-11-23 21:48:52','2021-11-23 21:48:52','2022-11-24 03:48:52'),('92334f54788b76f34dccd6e41780470e15867697ee3cf59d096622ff5b041033652dfc525b1f8e6b',1,1,'milk-vita','[]',0,'2021-11-23 23:27:41','2021-11-23 23:27:41','2022-11-24 05:27:41'),('940c30bccd437171130cf7a782e2a494dff270927b366c0d5e003833d3918c5da296d51af7e26e66',2,1,'milk-vita','[]',1,'2021-12-28 07:09:55','2021-12-28 07:09:55','2022-12-28 13:09:55'),('94c02a62377abb8826b8f81252b48cb500878d35f621d998c63fcedc7007fc524e70fee2c00532a1',1,1,'milk-vita','[]',1,'2021-11-24 00:11:27','2021-11-24 00:11:27','2022-11-24 06:11:27'),('94d433bebeeb4b21d5b903804a177117874450938ef66e8ac332724dfea64b93a7a374aaacf3c82b',4,1,'milk-vita','[]',0,'2021-12-08 12:29:21','2021-12-08 12:29:21','2022-12-08 18:29:21'),('950d1249e28288120956601fd02cab2016ef25bc49c747e8a1ab6a1d4d35add69ee04fb3c178b0ca',1,1,'milk-vita','[]',0,'2021-12-26 23:45:32','2021-12-26 23:45:32','2022-12-27 05:45:32'),('961a4950c5dfad115aa0b74dc92f3b923dbdf6fdacd253aae35a682327196e3180533946b6fbfff5',1,1,'milk-vita','[]',1,'2021-11-23 05:34:32','2021-11-23 05:34:32','2022-11-23 11:34:32'),('9659c3d47d8b903356a8a11c205feb0846cde2ec18f2d4fc1dfde575675961c5d97f6695cb26f2b3',1,1,'milk-vita','[]',0,'2021-11-24 00:03:46','2021-11-24 00:03:46','2022-11-24 06:03:46'),('96ad353bf2b6687901d82b8738351d4af268be61e21ddecda277bd10129b650a7133e0cd5780585d',4,1,'milk-vita','[]',1,'2021-12-07 04:38:35','2021-12-07 04:38:35','2022-12-07 10:38:35'),('97e979b514a3072696431dc9f8f74e794c4e08815040ce1488ed138867e8d5638b24926542a13a53',1,1,'milk-vita','[]',1,'2021-12-09 22:47:34','2021-12-09 22:47:34','2022-12-10 04:47:34'),('995a63428cd0756445638c541c9878a88ae48cb8dac95d80809b2bfadc04cf4b10f06da48e702781',1,1,'milk-vita','[]',0,'2021-11-23 23:24:42','2021-11-23 23:24:42','2022-11-24 05:24:42'),('9999f4d62e94c8c3890d2de56085a793574e153c667009dc2b9a4d2145688f4a5f4483f874a7b4e5',1,1,'milk-vita','[]',1,'2021-12-02 05:04:25','2021-12-02 05:04:25','2022-12-02 11:04:25'),('99ef38357bfe671e81fc334775ae70ebd9c9f71c0bfbcede92156483983c2eb6f4822cbfbf8709f7',1,1,'milk-vita','[]',0,'2021-12-13 01:58:35','2021-12-13 01:58:35','2022-12-13 07:58:35'),('9af9de22181aec51576b43cf690de9ecb9634a19ef5d02ce5172ef5b68750984a473b3efa439d6e4',1,1,'milk-vita','[]',0,'2021-11-23 04:02:53','2021-11-23 04:02:53','2022-11-23 10:02:53'),('9b7701db9c26c09b2fc132509e03058324feaf3987767d42b66a8f62190d703a041b3d69e296abb2',1,1,'milk-vita','[]',0,'2021-11-23 04:08:01','2021-11-23 04:08:01','2022-11-23 10:08:01'),('9d337c9c1e15cf5a2437257536a0b0ae58ce7f97307bab4f03d97fb6901894f5ec26404e72e24d37',1,1,'milk-vita','[]',0,'2021-12-27 03:49:45','2021-12-27 03:49:45','2022-12-27 09:49:45'),('9df4df67431c1c2f1d21e6c442067057fbcb4d632340a79227d6b5f18b992be7b213357c7206f0cc',2,1,'milk-vita','[]',0,'2021-12-05 00:43:25','2021-12-05 00:43:25','2022-12-05 06:43:25'),('9e220ebe42c07189e228ccf00fee5620f6b3110750a2bc3480f949ed7f8726b549bd46b97841ea77',1,1,'milk-vita','[]',0,'2021-11-23 04:29:50','2021-11-23 04:29:50','2022-11-23 10:29:50'),('9f37706247200c1983cdcf7b796f0737e6ad1704dfa277f55ac73b22a79b9072bf02a8d75ec39241',1,1,'milk-vita','[]',1,'2021-11-30 00:44:01','2021-11-30 00:44:01','2022-11-30 06:44:01'),('a096a7e6ffc2334e279177ef49347c39e341f148d24e20be477e344f83ddd4ff96f684cf8c8a7b0b',1,1,'milk-vita','[]',0,'2021-12-28 07:14:04','2021-12-28 07:14:04','2022-12-28 13:14:04'),('a0d4d5cbd3edfadb06c460501539d00268c3fde41e8f7d4e1204c963624bcba89c818d0ba11fa863',1,1,'milk-vita','[]',0,'2021-11-24 22:24:38','2021-11-24 22:24:38','2022-11-25 04:24:38'),('a15c0902a93541d21541a20bc45f2877a7c8d0f72a25b168d830f21b91bed0933c03c1812fd00ee3',4,1,'milk-vita','[]',0,'2021-12-07 21:59:22','2021-12-07 21:59:22','2022-12-08 03:59:22'),('a288176557446fe4923236560864434733c2e0fd56ac1b85d96374d007ea21db4a18ff6ee3d8dc19',1,1,'milk-vita','[]',0,'2021-12-19 03:47:02','2021-12-19 03:47:02','2022-12-19 09:47:02'),('a28828d49844a466364ad1bd301f4b4a491bbb6bf52cd8b44e03d62fdf941d5b74afb0c1134dda3b',1,1,'milk-vita','[]',0,'2021-12-09 02:43:37','2021-12-09 02:43:37','2022-12-09 08:43:37'),('a2b61843e3b96685da5e3bc6a127fc70910dbf0692a365cc6a6521bbe214314b880abc7b86b1dd08',1,1,'milk-vita','[]',1,'2021-11-24 03:03:17','2021-11-24 03:03:17','2022-11-24 09:03:17'),('a3d430c115f21414879fbc2a56c612c71602f25401177cb101d69aee702cff842f9620d66534b16f',1,1,'milk-vita','[]',1,'2021-11-24 03:01:14','2021-11-24 03:01:14','2022-11-24 09:01:14'),('a4803ea6d8cff609c84c29428312d58bf37b67246cdc38525f96e796fa5e2ecd57d0b8442b936668',1,1,'milk-vita','[]',0,'2021-12-28 07:13:39','2021-12-28 07:13:39','2022-12-28 13:13:39'),('a7a994d5d51caeaad6a3b6bfd6eedb779b8477f2f687ba1a65c4e4cad4a2d01cc8b0429c3b131f32',1,1,'milk-vita','[]',1,'2021-11-30 00:44:21','2021-11-30 00:44:21','2022-11-30 06:44:21'),('a7aa5fbf4869205894081a0bc1c2d1d8272fc875e12055cbc2ef333bc6b7c8ba94312aa180051a5a',1,1,'milk-vita','[]',0,'2021-12-05 00:26:37','2021-12-05 00:26:37','2022-12-05 06:26:37'),('a8599122e26b76131b6442aa09e4642e2d541996ccd675b60240a40f2f9df5efcaf7516115b55236',5,1,'milk-vita','[]',1,'2021-12-08 23:43:54','2021-12-08 23:43:54','2022-12-09 05:43:54'),('a86b1260763e3a9427bf3528fb47e9be628ffd9e94e8c7732ebd10927690f373b532d73304c815e1',1,1,'milk-vita','[]',1,'2021-12-07 21:59:07','2021-12-07 21:59:07','2022-12-08 03:59:07'),('a930ea9930aaafebf4a708d69611d726be827a6f3dd2ad2a29196cce6d9504f17d25e2408c30ac61',4,1,'milk-vita','[]',1,'2021-12-08 03:47:23','2021-12-08 03:47:23','2022-12-08 09:47:23'),('a98512e012121ca16ae0591a9b88e20af200d4fd24b0211670cd907503c106a98519cfebc76d9fea',1,1,'milk-vita','[]',0,'2021-11-23 05:51:03','2021-11-23 05:51:03','2022-11-23 11:51:03'),('a98ac2bd8d90e1955aa06da589ec05077cefeeddf15d9ec692c1325300b3847f06e7c9ec04f5fb6d',1,1,'milk-vita','[]',1,'2021-11-23 23:35:01','2021-11-23 23:35:01','2022-11-24 05:35:01'),('a99eef22ebfc6a728199541564ec738362d71538cb0efc850120b13f2dbef297ef63b859dd494b8d',1,1,'milk-vita','[]',0,'2021-12-28 02:30:54','2021-12-28 02:30:54','2022-12-28 08:30:54'),('aa4515e186a0c3a4dd25d32941ea1a0fac46f6b5d9837c5d126de32e01ea6ec10223e71cb7a6a089',1,1,'milk-vita','[]',0,'2021-11-23 03:14:34','2021-11-23 03:14:34','2022-11-23 09:14:34'),('aaed0a90a9cf480512348e39e6506ad00fc70f7cb068bf52359162c3d2ecdc8cc0152c6682699fe8',1,1,'milk-vita','[]',1,'2021-11-25 05:15:25','2021-11-25 05:15:25','2022-11-25 11:15:25'),('aafcf8cb4f4b13d6b4a4b37b5b80ad05832d487b708c118f6fc02f4f9ec22ea86d1001ddddc88ba3',1,1,'milk-vita','[]',0,'2021-11-23 04:49:08','2021-11-23 04:49:08','2022-11-23 10:49:08'),('ad2069000a45c21399ce13525b3703fdad3f32882f495f598317fae7c3461ffa5d2ac119a03572d1',1,1,'milk-vita','[]',0,'2021-12-27 04:49:37','2021-12-27 04:49:37','2022-12-27 10:49:37'),('ad5e09a2502314ca2ba95c16c0fa40e2fcbfd5ad1eaaf005c142473b7de10cf0b5739d6e85f58549',1,1,'milk-vita','[]',0,'2021-11-23 23:53:28','2021-11-23 23:53:28','2022-11-24 05:53:28'),('add52f256e5d518f18742c76ad78239542357ae2a6a8ad73e2419447fd71d8bb932aa8da5dec1f57',1,1,'milk-vita','[]',1,'2021-11-23 05:52:47','2021-11-23 05:52:47','2022-11-23 11:52:47'),('ae01ec8cda4909569f128039c6596f5eda5daa8db25701de6bbbc67468f27e05132a33b24ef957ad',2,1,'milk-vita','[]',1,'2021-12-05 04:03:14','2021-12-05 04:03:14','2022-12-05 10:03:14'),('ae807cdbb4dcd83d1e65d8ce5bcb1cd5f17a268e43ee018b3668f84d2a1d5628534fbd9345c75a64',5,1,'milk-vita','[]',0,'2021-12-06 01:18:38','2021-12-06 01:18:38','2022-12-06 07:18:38'),('aeb12eb368531c2edf9b8840d657fb9de60cca913ebcc7a97cdb95b67ecd1bf78e02a377e389c7a7',1,1,'milk-vita','[]',0,'2021-12-19 01:32:45','2021-12-19 01:32:45','2022-12-19 07:32:45'),('affa87b9e42ae07bbb8b73eea99ed2b21d48afe9e4f41509754b72432e9df24b1df5b0ffff2bc8a7',1,1,'milk-vita','[]',0,'2021-12-26 02:48:37','2021-12-26 02:48:37','2022-12-26 08:48:37'),('b0434aeee985ae407c2de56d5b0a59e8f9c476f028368dece7ba88d5b938cf69c48a77e83ccfcabb',1,1,'milk-vita','[]',0,'2021-12-07 22:07:37','2021-12-07 22:07:37','2022-12-08 04:07:37'),('b0a81533e17842157485987e38f3d035f87e5471103a5047f7680421dcfac24a30d2b14bdeccdc36',1,1,'milk-vita','[]',0,'2021-11-23 04:28:19','2021-11-23 04:28:19','2022-11-23 10:28:19'),('b0c1ac16ed5133025d433d13cb81586efa9d386780dab95521f7f13e7ee4404b28e92a5819c647fa',1,1,'milk-vita','[]',1,'2021-11-23 04:28:19','2021-11-23 04:28:19','2022-11-23 10:28:19'),('b2a2d2f605c3fda122120ff13acc76415f942080495ce03a9c64d487434729e966dfb6e041478182',1,1,'milk-vita','[]',0,'2021-12-26 22:59:36','2021-12-26 22:59:36','2022-12-27 04:59:36'),('b33623dd2cb24ec42e3f081e87cac38adc97cf29ec69583c7060653b6496f0842cfdb3d30c41c0ec',1,1,'milk-vita','[]',0,'2021-12-28 02:43:40','2021-12-28 02:43:40','2022-12-28 08:43:40'),('b4a06fd4b3849914f5a387635acd9b5a9fffec31651c07171e7449815ac59af3d8dd1e0baaa8c606',1,1,'milk-vita','[]',1,'2021-12-05 04:03:02','2021-12-05 04:03:02','2022-12-05 10:03:02'),('b659daa1afe477addf923625167e6c8eac6b905e9102b2b9d9e59be1afdfe0875e602c45022988ae',3,1,'milk-vita','[]',1,'2021-12-06 00:50:59','2021-12-06 00:50:59','2022-12-06 06:50:59'),('b6a7b17d7980c05c9cf35c6dc1e145aaddd8c686627b01855d1e9f903fde951ccf9ca5e9dcd08d52',1,1,'milk-vita','[]',0,'2021-12-07 22:07:47','2021-12-07 22:07:47','2022-12-08 04:07:47'),('b6aaf259336c9a8e76c2fdf6d7543ac12b75f310f87edf30ec3371fb2acf05ce8de2f5df4db60557',1,1,'milk-vita','[]',0,'2021-12-19 01:29:47','2021-12-19 01:29:47','2022-12-19 07:29:47'),('b6e4d6fcdb5d636022e23946f2161e23e440f2fbccadab56d11adfd26512ffe5374dd90daf08f929',1,1,'milk-vita','[]',0,'2021-11-24 00:03:06','2021-11-24 00:03:06','2022-11-24 06:03:06'),('b74e85c89e9f43e5809e42a3c2fd9ec4327d7d2b84a3edbef6c1641139b6d85d4aaceb201dba17c6',1,1,'milk-vita','[]',0,'2021-12-19 03:53:43','2021-12-19 03:53:43','2022-12-19 09:53:43'),('b855fc60393df98290cb1679d49e8372c7b8290e269aafff18507c5651a84d418ce15a425f812956',1,1,'milk-vita','[]',0,'2021-11-23 12:24:32','2021-11-23 12:24:32','2022-11-23 18:24:32'),('b9274d20ef6759570891e7abb90eb299512942ba7dd7e70dc89e9a73d894d1e45ea725a091a72cb8',1,1,'milk-vita','[]',1,'2021-11-30 00:42:05','2021-11-30 00:42:05','2022-11-30 06:42:05'),('bb94841f48216da74b24bf847efcd383cbfbee84d47e56e7bb93b3e68893d018df95a0983bc385d7',6,1,'milk-vita','[]',1,'2021-12-14 23:37:30','2021-12-14 23:37:30','2022-12-15 05:37:30'),('bd4a7106f92f5023e40f54935b02ddcdf3ef592bbe79e250ff33069ef800fc523ff1725d36dbf799',1,1,'milk-vita','[]',0,'2021-11-23 23:04:02','2021-11-23 23:04:02','2022-11-24 05:04:02'),('be1679ac540b4785ba57ec24472e1303622c25875bde21e02a59edc000f00f0681043857903a5fcb',1,1,'milk-vita','[]',0,'2021-12-05 21:55:06','2021-12-05 21:55:06','2022-12-06 03:55:06'),('bf0a0310c5ceb9fd9f4fa78f57ed7f83a0af47a060d302590d81117f26fb32a4a90fbd770d7a268b',1,1,'milk-vita','[]',1,'2021-11-24 05:54:24','2021-11-24 05:54:24','2022-11-24 11:54:24'),('bf912110311bef54c9a0620db928efba90d1621b4d8d8b6c7fd0bd8be97c20f8f1d9b8a5290e063e',1,1,'milk-vita','[]',1,'2021-12-09 11:21:54','2021-12-09 11:21:54','2022-12-09 17:21:54'),('c08eaec1579e25c6d36f286f626be497f1221a2a176a1f013a74fad242d237abe4054e4cc1c30087',1,1,'milk-vita','[]',0,'2021-11-24 00:06:18','2021-11-24 00:06:18','2022-11-24 06:06:18'),('c0969cd606d5a59ffb88c10f59c562fff3bb5c140f00548d7ff68a584ab60dd4f05ff3888a7e4adb',4,1,'milk-vita','[]',1,'2021-12-06 01:04:56','2021-12-06 01:04:56','2022-12-06 07:04:56'),('c0b0986a04dd344dadaf18c4274977f729cf2b262bfc49f48f078a528aef6db822d52957954623e1',1,1,'milk-vita','[]',0,'2021-11-23 04:29:04','2021-11-23 04:29:04','2022-11-23 10:29:04'),('c0c94b570721ffcbc42da34a630e3b99003f2d01578ef176a63405397518dc063919fb8f986a4f3b',1,1,'milk-vita','[]',0,'2021-12-28 06:11:06','2021-12-28 06:11:06','2022-12-28 12:11:06'),('c1b8345a8a46680ee383c13dd454caa08c0bf5a1ca70838a9ad1fb9688532ea95d6d3f7ad48d6089',1,1,'milk-vita','[]',1,'2021-12-02 02:46:55','2021-12-02 02:46:55','2022-12-02 08:46:55'),('c54a3d6ca33f1b804255e1881b22eb79f61b7e5218deb32dc05dbe97575ff5ceed3676340a49db76',1,1,'milk-vita','[]',0,'2021-11-23 05:50:23','2021-11-23 05:50:23','2022-11-23 11:50:23'),('c5bbabd2df474e3f01ed46c37b438c4cb737c695697b01977e5c1b1fb6e3cfe9bd8f73506f084437',1,1,'milk-vita','[]',0,'2021-12-09 01:41:07','2021-12-09 01:41:07','2022-12-09 07:41:07'),('c5fa2ef13e28b04a2da760468352e8876c4bc27462c90bcc2a15a507af749854fba872aaa5716d3c',1,1,'milk-vita','[]',0,'2021-11-23 12:26:39','2021-11-23 12:26:39','2022-11-23 18:26:39'),('c6b130ca4221bd8f65f2d9ca8ae4ff755e389b36b8a16f6ee4a2133ea41136ada966ff7329c045fd',1,1,'milk-vita','[]',0,'2021-11-23 04:09:01','2021-11-23 04:09:01','2022-11-23 10:09:01'),('c7b75ddb1c4eabeb25e4ddac688405d9bebcd19f3eed048af87239d917145633d30179d275088a15',1,1,'milk-vita','[]',0,'2021-12-05 00:25:52','2021-12-05 00:25:52','2022-12-05 06:25:52'),('c835d5d3f5e749ad07d1b6290caf956cffda5e2c1ecaacb8d9e8fca1b89aa2c400f69d3ba629f354',1,1,'milk-vita','[]',0,'2021-12-05 22:17:37','2021-12-05 22:17:37','2022-12-06 04:17:37'),('c868e7b0bfc96cb17047dbd58885486b14aaae16cb44a921443fbb70c291ee12a624706eda4e6492',1,1,'milk-vita','[]',0,'2021-12-14 04:38:01','2021-12-14 04:38:01','2022-12-14 10:38:01'),('c89fefc6ff18a89a323a1c11de7e1de30238bc6e657b38a2c74421687dc1886015008598656f8fb8',1,1,'milk-vita','[]',0,'2021-12-27 02:16:43','2021-12-27 02:16:43','2022-12-27 08:16:43'),('c90691abb3220402c2efd75fe28f19a84698583cd6c24a9f355ce1f5cc8aba8d5553076fb63ee486',1,1,'milk-vita','[]',0,'2021-12-26 02:48:12','2021-12-26 02:48:12','2022-12-26 08:48:12'),('c9d91690ce2d4aed22a72db3e1f1f74b1e02a335e146d6f0f3cfec47721c2442f5350d906f3c52c3',1,1,'milk-vita','[]',0,'2021-12-28 02:42:48','2021-12-28 02:42:48','2022-12-28 08:42:48'),('cb21f370e3ffcc3a7c1ef1e19a99ac82d5f2ce930dd9a39d637f5241d43d74b577220d0e6c96ae6f',1,1,'milk-vita','[]',0,'2021-11-23 04:28:40','2021-11-23 04:28:40','2022-11-23 10:28:40'),('cc4b95b73c843eaa9e14750aaee9f0a8dc5b076ca585162400b00e8dd8f1b4d9abf193a78f13bef7',1,1,'milk-vita','[]',0,'2021-12-09 01:41:45','2021-12-09 01:41:45','2022-12-09 07:41:45'),('cd0d99790c4e592de0a478738e4d96439b1b78fd76c4de97a4eeff630cb33c580b5f6cf3445491cb',4,1,'milk-vita','[]',1,'2021-12-07 04:36:21','2021-12-07 04:36:21','2022-12-07 10:36:21'),('ce6116fa4d7202d691bba22561a983a74b05584214f15ba2de423c06d344600bbcf3c249a8718345',1,1,'milk-vita','[]',0,'2021-12-07 22:07:38','2021-12-07 22:07:38','2022-12-08 04:07:38'),('ce83d260b8819c0fe44b6e8f6ac104737a1c5814d4ca9563b6420baedd729cf67c28cca8ab075ecc',1,1,'milk-vita','[]',0,'2021-12-09 01:20:41','2021-12-09 01:20:41','2022-12-09 07:20:41'),('cf1e2c87dc1dfa0b08603eb100626c75b9555a82b29e5aaec7fe97312cc8b9b4eeb34beffb798a74',1,1,'milk-vita','[]',1,'2021-12-23 05:01:11','2021-12-23 05:01:11','2022-12-23 11:01:11'),('cff80f312a92b638d0a9a3b5a275a1c65ee50329f160d28cfb5427047187eac20c34d86929869aa9',1,1,'milk-vita','[]',0,'2021-11-23 12:26:35','2021-11-23 12:26:35','2022-11-23 18:26:35'),('d1dbb98f2b9e8fac58e1861e2c098bf5370b0abe0f86f44cbe1f9cee8fb7526d87f82fdfa9a59887',1,1,'milk-vita','[]',0,'2021-12-26 05:42:32','2021-12-26 05:42:32','2022-12-26 11:42:32'),('d1ff5d82b120cd3313c8d082129c67673581dc66e561eb68cf32098ad37d07e3e7486a4497dc5af8',1,1,'milk-vita','[]',0,'2021-12-19 04:15:01','2021-12-19 04:15:01','2022-12-19 10:15:01'),('d2208f13e32b7b1e5fbd19b5a072cbd18d1c63d6e77d926cad3f3819ea2c2c6519df227902267ea7',2,1,'milk-vita','[]',1,'2021-12-21 00:56:40','2021-12-21 00:56:40','2022-12-21 06:56:40'),('d5d9d4774811a075d8b7a8db3e61a7e1305d6f30cc2495eea539b446a757118108bb785a333758c6',1,1,'milk-vita','[]',0,'2021-11-23 12:28:12','2021-11-23 12:28:12','2022-11-23 18:28:12'),('d68561ee175530f1a831b2b53505396088642aa7f6a4a28b8ae85b401efa5a8f319ac6866dd9db47',1,1,'milk-vita','[]',1,'2021-12-09 04:33:57','2021-12-09 04:33:57','2022-12-09 10:33:57'),('d759a54f3d8f8b5b5bf07c29e252d70a94559ec7c22bdbd61e62688d91684c72339a73d78c5f2b84',1,1,'milk-vita','[]',0,'2021-11-23 04:44:20','2021-11-23 04:44:20','2022-11-23 10:44:20'),('d92fefcd37a5d61c1cc0c5eaaedb652faadf95af5023d96fa76e5006626a3d68b048b891450c2a40',1,1,'milk-vita','[]',1,'2021-12-13 05:10:47','2021-12-13 05:10:47','2022-12-13 11:10:47'),('d9a7066a018ac0f33a9b21e7de189130da1c781c22ce346662c8316d62ca79247aae8e0d9527a7d7',4,1,'milk-vita','[]',0,'2021-12-08 23:56:07','2021-12-08 23:56:07','2022-12-09 05:56:07'),('dba80c73a9447596f949fafb58196d1cb24bc0cd0045471d37f068442c57d8a983aef48558bfaafa',4,1,'milk-vita','[]',1,'2021-12-09 04:33:27','2021-12-09 04:33:27','2022-12-09 10:33:27'),('dcd577c37c583e4fcbd79dcf15b67d81a14ebf29839c9b4eb343c613c310313f4ade10f49d9f46aa',1,1,'milk-vita','[]',1,'2021-12-05 00:35:53','2021-12-05 00:35:53','2022-12-05 06:35:53'),('dce43a6fa7ab2038b0dc724c19784c5f4dae0fc5a803b064aeb9d763c67f421e9bfe66e5540931ee',1,1,'milk-vita','[]',1,'2021-12-06 00:55:31','2021-12-06 00:55:31','2022-12-06 06:55:31'),('dea0b9ae0e37ad8c911cdd2e4a4caa6273e48a3239fb7e0920a28c52575302599fa9c3086bc1dc97',1,1,'milk-vita','[]',0,'2021-11-23 04:28:26','2021-11-23 04:28:26','2022-11-23 10:28:26'),('df6476203d50870eac7775e3fd8f1721cce2f14c5f952dfc273941f44f3aea6943267cffe620234b',4,1,'milk-vita','[]',0,'2021-12-07 22:08:57','2021-12-07 22:08:57','2022-12-08 04:08:57'),('dfc55b2866aebbff328ca8d9925d790297c65b0bbfff82c0aa33535b69f808cde1cf45b754c75303',1,1,'milk-vita','[]',1,'2021-12-21 00:38:16','2021-12-21 00:38:16','2022-12-21 06:38:16'),('dfdc59ca7214f430b8c33e0480594822ae64a1826e6a341e4ea183199a65b7238b66bee327cf64c3',1,1,'milk-vita','[]',1,'2021-11-24 03:02:34','2021-11-24 03:02:34','2022-11-24 09:02:34'),('e00124adfaacaf478624383d2674a1e0abf6f15a90a018528629822c618baa63f7fd66843b1c920a',1,1,'milk-vita','[]',1,'2021-11-23 05:54:01','2021-11-23 05:54:01','2022-11-23 11:54:01'),('e0827eca26ce01b3056484123ea41c238044c3fe20b205e9c7384eb6cfd5ffe53dee5b7f722790b8',1,1,'milk-vita','[]',0,'2021-11-23 04:00:29','2021-11-23 04:00:29','2022-11-23 10:00:29'),('e26a0a123a1e183660e1aa1d4343ce234d3d68f182cc91bfb2dd34fed376910511641acb1c934472',1,1,'milk-vita','[]',0,'2021-12-26 23:56:23','2021-12-26 23:56:23','2022-12-27 05:56:23'),('e2832b35e65b71fd068e2841bdefcdbaa6b6eabf9acf3d529d3ca19747e529c51e098a58fa89fcca',1,1,'milk-vita','[]',0,'2021-11-23 03:58:14','2021-11-23 03:58:14','2022-11-23 09:58:14'),('e28ee326d4702b3510ee480ec030493fc88ecc4212190e7c79525671f3d81788c6e2b314cd6acfdf',5,1,'milk-vita','[]',0,'2021-12-08 23:42:54','2021-12-08 23:42:54','2022-12-09 05:42:54'),('e2b0dbb9f64f668d97366b63e33ad8e335116274be33184e118863a22f367e20b6aefc89a42cd325',1,1,'milk-vita','[]',0,'2021-11-23 04:29:28','2021-11-23 04:29:28','2022-11-23 10:29:28'),('e39c20ee096acb2a1f4fc2ba4b7afe5d5af92012fa945c97725dc7025e09bc03662897caece94e4c',1,1,'milk-vita','[]',0,'2021-12-27 04:48:59','2021-12-27 04:48:59','2022-12-27 10:48:59'),('e7625f7685c4718df0ba5f5f6ce16adefa5d06c4b97aaabeae9c4dd87b839fce5cd517acf142bd91',1,1,'milk-vita','[]',0,'2021-11-23 04:46:17','2021-11-23 04:46:17','2022-11-23 10:46:17'),('e7b7167d0c66dba021e07200225f4616ee2fc1f2a74c69e1ecf0d300c11bbfc874b854706b847ea8',1,1,'milk-vita','[]',0,'2021-11-23 12:24:52','2021-11-23 12:24:52','2022-11-23 18:24:52'),('e7bc6e9af2053967a6ec5c5722e752bd1eeb8135ec64ab5fea7bc995b5ce2f1d007db32174d361de',1,1,'milk-vita','[]',0,'2021-12-13 05:59:33','2021-12-13 05:59:33','2022-12-13 11:59:33'),('e82aa34201c20d78881b5f853307f267d183d01110a20bcd991f86aa903391e8b3a3e155f6bb4d3e',1,1,'milk-vita','[]',0,'2021-11-24 22:22:28','2021-11-24 22:22:28','2022-11-25 04:22:28'),('e873465f16e1276284042dda6ed7871bf6abfe72d2b1a2ee5420492714b59d1a6d5f9bd17c1d448c',1,1,'milk-vita','[]',0,'2021-11-24 00:05:34','2021-11-24 00:05:34','2022-11-24 06:05:34'),('e8cebe6706cecb737543026d879899ec6c3eebc20138c7166191f618d7b41ac03c6a396fa61b8aa3',2,1,'milk-vita','[]',1,'2021-12-28 07:10:37','2021-12-28 07:10:37','2022-12-28 13:10:37'),('e9819d5900aa8f5095cd3e38491d4763c7773a4b0e7a89b63cbe6f117bd32da447a8ed18c52608c0',1,1,'milk-vita','[]',0,'2021-12-19 01:38:13','2021-12-19 01:38:13','2022-12-19 07:38:13'),('ea6bdbe0ef735ac64c008685c1924afada015413334f0f4d235d7fb292057de27dd0de8f41e4d5c7',1,1,'milk-vita','[]',0,'2021-11-23 22:16:00','2021-11-23 22:16:00','2022-11-24 04:16:00'),('ead22b2acaeeb40eb8cede956b1c62629c13aa30b787a9ac6a89a4cead46adf81decac8425e226af',1,1,'milk-vita','[]',0,'2021-12-14 05:16:42','2021-12-14 05:16:42','2022-12-14 11:16:42'),('ec161ce7927f5ac9c95907b849b49300c308420e4c5da5bd2d4a25f4e1abc6c984a4d28b16926ffa',1,1,'milk-vita','[]',0,'2021-12-26 23:25:01','2021-12-26 23:25:01','2022-12-27 05:25:01'),('ec4d4bf5d4abc9d43298eee354bca6be9ebd1b8e2021cbd8699e1090495a0c09dab3619ccc4e29e3',1,1,'milk-vita','[]',0,'2021-12-13 06:00:30','2021-12-13 06:00:30','2022-12-13 12:00:30'),('ed4b0fbf0ea911c6044091f829130eeeb3c0327d46471115a9434e4229b843bfe03c9c7da344ae3c',1,1,'milk-vita','[]',0,'2021-11-23 03:57:31','2021-11-23 03:57:31','2022-11-23 09:57:31'),('edcde6f54a5c8293a9301b4d0935aaca076a50a04dede8e1cd52a12f1d8542dd0cc100dd6d291de4',1,1,'milk-vita','[]',1,'2021-11-23 05:52:39','2021-11-23 05:52:39','2022-11-23 11:52:39'),('edcfe7049cce88137ac53a66f016d26256a85c182e29131364af7944ccc1092437ac26b9f2daf0ca',4,1,'milk-vita','[]',1,'2021-12-08 04:36:38','2021-12-08 04:36:38','2022-12-08 10:36:38'),('ee3ac53fee90b58b102be865538047efa031777fa801953f9e3ed9ee3de675298fd6035e32a5f650',1,1,'milk-vita','[]',1,'2021-12-01 23:21:25','2021-12-01 23:21:25','2022-12-02 05:21:25'),('ee4001a83f8cc9a774a6f9734ddf1289aed4189c0dedb7dddcaa2e078cc9919ab40a409a6ac5dbfe',1,1,'milk-vita','[]',0,'2021-11-23 23:29:34','2021-11-23 23:29:34','2022-11-24 05:29:34'),('ee889fcbe5d45a26695a9cf2de6ac9933f7dac4034fd636a5a7ec4755d8ff14c6338983c0abe65ae',1,1,'milk-vita','[]',0,'2021-12-28 03:10:05','2021-12-28 03:10:05','2022-12-28 09:10:05'),('eebbf28d8a204a206c36e6590a6bfcc6e7a82285a6b2af8781abee812aacaa34edd412c439cd6c62',1,1,'milk-vita','[]',0,'2021-11-23 22:41:32','2021-11-23 22:41:32','2022-11-24 04:41:32'),('f0a2dfbc150c10ea3be5ba0ad9e6f7d2a5f2e977fe789f91830c6d9836f0dbc0438c4c03177a935e',1,1,'milk-vita','[]',1,'2021-12-14 04:20:50','2021-12-14 04:20:50','2022-12-14 10:20:50'),('f149a9471da39f376df08b35e6ee825f0ee72607bf479ca1656642e2069514ba2c7f79433399e588',1,1,'milk-vita','[]',1,'2021-12-06 01:01:29','2021-12-06 01:01:29','2022-12-06 07:01:29'),('f16d5401e3ab59013647d4da62c48eb5462b18435216e613755bf82748e4753f5902fd61738d2954',1,1,'milk-vita','[]',1,'2021-11-30 00:42:16','2021-11-30 00:42:16','2022-11-30 06:42:16'),('f25e6a5ebfd8783b66570dca639470025e706c74d722e8d4f65fa20fad7c1a47635de848e9521265',1,1,'milk-vita','[]',1,'2021-11-29 23:48:57','2021-11-29 23:48:57','2022-11-30 05:48:57'),('f273656f520892d682f56034483f5591defc2051dfbf6ff693d8976a37567f5eb9340977d3b0533d',1,1,'milk-vita','[]',0,'2021-11-23 05:49:35','2021-11-23 05:49:35','2022-11-23 11:49:35'),('f2e8f38607e74380232636e16da7b2ecd257a23aadcb1faea42ed325e88ca650c7a036fd781ea9ed',1,1,'milk-vita','[]',0,'2021-12-05 00:31:39','2021-12-05 00:31:39','2022-12-05 06:31:39'),('f315df42cb6c569f3d46b727e94365d86828be43ba677f4030bb2a64f8eff5a2c9c0e3d36ef7cdfe',1,1,'milk-vita','[]',0,'2021-12-26 22:59:04','2021-12-26 22:59:04','2022-12-27 04:59:04'),('f37e95ab661e8338fd52947499416e76e00db8c9cab35c0bfcecc24b98eb80012041c7d2412bc7ab',1,1,'milk-vita','[]',0,'2021-12-05 21:56:08','2021-12-05 21:56:08','2022-12-06 03:56:08'),('f447a72464243e25f0b77821b97e9b0abd1106f7dd435974f276a12ca9e713988cc26bdf707410b0',1,1,'milk-vita','[]',0,'2021-12-07 22:07:40','2021-12-07 22:07:40','2022-12-08 04:07:40'),('f4cdb8166686260a78e5452fae81f3b6caf45cea187d260c46f96a891a8dc51c2fd44d87967416a8',1,1,'milk-vita','[]',0,'2021-12-09 01:45:56','2021-12-09 01:45:56','2022-12-09 07:45:56'),('f4fbf319a398f106056bf2e54c6f1d82b0f303ddfe133f8d9e6800bfacfaf9e7b9299da33e868777',1,1,'milk-vita','[]',1,'2021-12-09 03:41:38','2021-12-09 03:41:38','2022-12-09 09:41:38'),('f58781c5f21d28f8369a228a31fecdeed293c95adda487c6e03ef2c20d3c5f3bdbe2882a7a93e8cb',2,1,'milk-vita','[]',1,'2021-12-21 01:55:36','2021-12-21 01:55:36','2022-12-21 07:55:36'),('f5b7017414cfe6d4441ce30ecc43ecab17414d0673941e95e6d861de733d5ff9395ad9b84180b6c3',1,1,'milk-vita','[]',0,'2021-11-23 03:58:33','2021-11-23 03:58:33','2022-11-23 09:58:33'),('f6871eb42d2c9577f15cb1df1f837437bc7dd7e3988a6227d5175da1f21c0cfb445c4ad40567bf12',3,1,'milk-vita','[]',0,'2021-12-06 00:24:59','2021-12-06 00:24:59','2022-12-06 06:24:59'),('f6e37dc0b76d316220cfb16f36c5e193914c1c204d79d7c19bc2911ad960c4cc70b296f9290cf991',10,1,'milk-vita','[]',0,'2021-12-14 23:40:15','2021-12-14 23:40:15','2022-12-15 05:40:15'),('f75544d4865857948bb836dc091fe2b36cd140b047a84f23c57372276d413358750d4bc5a68964ac',1,1,'milk-vita','[]',0,'2021-11-23 05:50:09','2021-11-23 05:50:09','2022-11-23 11:50:09'),('fa07ce8dba87f2e6fd7656e1daa6ad7583bffe1998401ff6432993362fa5be9fdb7a20d09fa0c5f9',1,1,'milk-vita','[]',1,'2021-11-23 05:43:59','2021-11-23 05:43:59','2022-11-23 11:43:59'),('fa26613d01d4dc2309a4a537bb655280b340e5af4347d27cb57107c690f28714200e5b2809e35271',1,1,'milk-vita','[]',0,'2021-11-23 23:34:25','2021-11-23 23:34:25','2022-11-24 05:34:25'),('fa4edb635a9847cdf89da65b23d737f18b7a7b9baa32b624762ff91bb519419d06858708107b805e',2,1,'milk-vita','[]',0,'2021-12-05 02:37:27','2021-12-05 02:37:27','2022-12-05 08:37:27'),('fa7df782ed220ad0f68a52f9779982c9e5fe4c8826d806d5290f179c732c2d2365aca30d9cf237e9',1,1,'milk-vita','[]',0,'2021-12-09 03:41:12','2021-12-09 03:41:12','2022-12-09 09:41:12'),('fc041e2f4596eb44a560835cb65c3376dc081f2698dd3ce8240552e0bfbfe7fdc630a0b6656091b1',1,1,'milk-vita','[]',1,'2021-11-23 04:28:40','2021-11-23 04:28:40','2022-11-23 10:28:40'),('fc29fd6548b63178e2b9b61abf9e859366062d6ffc6d2eff1fdd90f534161e4a40835ba9139ec5f1',1,1,'milk-vita','[]',1,'2021-11-24 03:04:53','2021-11-24 03:04:53','2022-11-24 09:04:53'),('fc2d2089fa5e80aaa3baa2f8df0b69d8d6dd6a3cd589fdc12222127ddbb9ced045671ebe7bf96663',1,1,'milk-vita','[]',0,'2021-11-24 00:26:06','2021-11-24 00:26:06','2022-11-24 06:26:06'),('fc3a4fc7fd572a06acbe7545620eafc435dc6c66ccd86b37f03c07dcc97bee7096f09ca9003e5e48',1,1,'milk-vita','[]',0,'2021-12-28 04:43:29','2021-12-28 04:43:29','2022-12-28 10:43:29'),('fcd0fefc3de33db409edabdc8d9b2021f4a080d8937ca002c2b33972e72e74c88dd6600f89a6b77c',4,1,'milk-vita','[]',0,'2021-12-08 23:45:19','2021-12-08 23:45:19','2022-12-09 05:45:19'),('fcede42879778b2971fd5a36cf7f3eb0e6fd45eceb64707b3f3b2135edd85d2d18b7da37a289c0ef',1,1,'milk-vita','[]',0,'2021-11-23 04:28:07','2021-11-23 04:28:07','2022-11-23 10:28:07'),('fd3fcf2a81f427966f2d60c71a713502a9ee7bed2e2b3f27aae191a973d23ee6e5954228a9043702',1,1,'milk-vita','[]',0,'2021-12-09 03:11:23','2021-12-09 03:11:23','2022-12-09 09:11:23'),('fe91be1f269e6d088f5b8117cea812b9ecbea1590002bfd2e6b7910954c0ed67fcf69cc6472b3ef7',1,1,'milk-vita','[]',1,'2021-11-23 05:34:42','2021-11-23 05:34:42','2022-11-23 11:34:42');
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `client_id` bigint unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` VALUES (1,NULL,'milk-vita','raNOqjNsGdtbOaihoINM42Ax4dU5YpfymFD2yaBf',NULL,'http://localhost',1,0,0,'2021-11-22 01:28:52','2021-11-22 01:28:52');
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_personal_access_clients`
--

LOCK TABLES `oauth_personal_access_clients` WRITE;
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
INSERT INTO `oauth_personal_access_clients` VALUES (1,1,'2021-11-22 01:28:52','2021-11-22 01:28:52');
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `road_types`
--

DROP TABLE IF EXISTS `road_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `road_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `road_type_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `road_types`
--

LOCK TABLES `road_types` WRITE;
/*!40000 ALTER TABLE `road_types` DISABLE KEYS */;
INSERT INTO `road_types` VALUES (1,'কাঁচা','2021-12-02 00:38:39','2021-12-02 01:26:22'),(2,'পাঁকা','2021-12-02 00:38:58','2021-12-02 00:38:58'),(3,'dfdf','2021-12-08 04:48:16','2021-12-08 04:48:16');
/*!40000 ALTER TABLE `road_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_wise_menus`
--

DROP TABLE IF EXISTS `role_wise_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_wise_menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int NOT NULL,
  `menus` longtext COLLATE utf8mb4_unicode_ci,
  `sub_menus` longtext COLLATE utf8mb4_unicode_ci,
  `action_menus` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_wise_menus`
--

LOCK TABLES `role_wise_menus` WRITE;
/*!40000 ALTER TABLE `role_wise_menus` DISABLE KEYS */;
INSERT INTO `role_wise_menus` VALUES (1,8,'[3]',NULL,'[6]','2021-12-20 23:08:22','2021-12-20 23:08:22'),(2,7,'[18,3]',NULL,'[4,2,3,6,7]','2021-12-20 23:09:02','2021-12-20 23:09:02'),(3,9,'[2,13,15,20,1,18,8,3,9,19]',NULL,'[1,5,4,2,3,6,7]','2021-12-21 00:20:59','2021-12-21 00:20:59'),(4,5,'[2,1]',NULL,'[]','2021-12-28 04:13:33','2021-12-28 04:13:33'),(5,2,'[2,9]',NULL,'[]','2021-12-28 07:10:29','2021-12-28 07:10:29');
/*!40000 ALTER TABLE `role_wise_menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `system_id` int NOT NULL DEFAULT '0',
  `entity_id` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'SuperAdmin',0,0,NULL,'2021-12-27 22:28:15'),(2,'Superadmin',1,0,'2021-12-27 04:30:41','2021-12-27 04:30:41'),(3,'Admin',1,0,'2021-12-27 04:32:59','2021-12-27 04:32:59'),(4,'Superadmin',0,2,'2021-12-27 21:57:17','2021-12-27 21:57:17'),(5,'Manager',1,4,'2021-12-27 23:16:34','2021-12-28 04:28:53');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_menus`
--

DROP TABLE IF EXISTS `sub_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sub_menus` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_id` int NOT NULL,
  `icon` text COLLATE utf8mb4_unicode_ci,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `trash` tinyint NOT NULL DEFAULT '0',
  `position` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_menus`
--

LOCK TABLES `sub_menus` WRITE;
/*!40000 ALTER TABLE `sub_menus` DISABLE KEYS */;
/*!40000 ALTER TABLE `sub_menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `survey_reports`
--

DROP TABLE IF EXISTS `survey_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `survey_reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `informative_form_id` int NOT NULL,
  `member` text COLLATE utf8mb4_unicode_ci,
  `total_member_of_family` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_number_of_dairy_cow` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_number_of_dry_cow` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_of_calves` text COLLATE utf8mb4_unicode_ci,
  `total_number_of_bull` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_number_of_animals` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `daily_average_milk_production` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zila_id` int DEFAULT NULL,
  `upazila_id` int DEFAULT NULL,
  `postoffice_id` int DEFAULT NULL,
  `village` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `distance` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `communication` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nearest_association_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `distance_from_nearest_association` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_reports`
--

LOCK TABLES `survey_reports` WRITE;
/*!40000 ALTER TABLE `survey_reports` DISABLE KEYS */;
INSERT INTO `survey_reports` VALUES (1,4,1,'null','sdfsdf','sdf','sdfsfd','null','sdfdsf','dfsdf','dfsdf',NULL,NULL,NULL,NULL,'fdfsdf','sdf','dsfs','dfsdf','2021-12-08','2021-12-08 04:46:30','2021-12-08 04:46:30'),(3,1,2,'null','223re','sdfsdf','sdfsdf','null','sdfsdf','sdfsdfsdf','sdfsdfsdf',NULL,NULL,NULL,NULL,'sdfsdf','sdfsdf','fsdfsdf','sdfsdfs','2021-12-19','2021-12-19 01:44:06','2021-12-19 01:44:06');
/*!40000 ALTER TABLE `survey_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `systems`
--

DROP TABLE IF EXISTS `systems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `systems` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `system_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `system_code` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `systems`
--

LOCK TABLES `systems` WRITE;
/*!40000 ALTER TABLE `systems` DISABLE KEYS */;
INSERT INTO `systems` VALUES (1,'MyGov',1,'2021-12-27 02:09:26','2021-12-27 02:09:34');
/*!40000 ALTER TABLE `systems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `thanas`
--

DROP TABLE IF EXISTS `thanas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `thanas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `district_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `trash` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=493 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thanas`
--

LOCK TABLES `thanas` WRITE;
/*!40000 ALTER TABLE `thanas` DISABLE KEYS */;
INSERT INTO `thanas` VALUES (1,1,'Debidwar','দেবিদ্বার','debidwar.comilla.gov.bd',0,NULL,NULL),(2,1,'Barura','বরুড়া','barura.comilla.gov.bd',0,NULL,NULL),(3,1,'Brahmanpara','ব্রাহ্মণপাড়া','brahmanpara.comilla.gov.bd',0,NULL,NULL),(4,1,'Chandina','চান্দিনা','chandina.comilla.gov.bd',0,NULL,NULL),(5,1,'Chauddagram','চৌদ্দগ্রাম','chauddagram.comilla.gov.bd',0,NULL,NULL),(6,1,'Daudkandi','দাউদকান্দি','daudkandi.comilla.gov.bd',0,NULL,NULL),(7,1,'Homna','হোমনা','homna.comilla.gov.bd',0,NULL,NULL),(8,1,'Laksam','লাকসাম','laksam.comilla.gov.bd',0,NULL,NULL),(9,1,'Muradnagar','মুরাদনগর','muradnagar.comilla.gov.bd',0,NULL,NULL),(10,1,'Nangalkot','নাঙ্গলকোট','nangalkot.comilla.gov.bd',0,NULL,NULL),(11,1,'Comilla Sadar','কুমিল্লা সদর','comillasadar.comilla.gov.bd',0,NULL,NULL),(12,1,'Meghna','মেঘনা','meghna.comilla.gov.bd',0,NULL,NULL),(13,1,'Monohargonj','মনোহরগঞ্জ','monohargonj.comilla.gov.bd',0,NULL,NULL),(14,1,'Sadarsouth','সদর দক্ষিণ','sadarsouth.comilla.gov.bd',0,NULL,NULL),(15,1,'Titas','তিতাস','titas.comilla.gov.bd',0,NULL,NULL),(16,1,'Burichang','বুড়িচং','burichang.comilla.gov.bd',0,NULL,NULL),(17,1,'Lalmai','লালমাই','lalmai.comilla.gov.bd',0,NULL,NULL),(18,2,'Chhagalnaiya','ছাগলনাইয়া','chhagalnaiya.feni.gov.bd',0,NULL,NULL),(19,2,'Feni Sadar','ফেনী সদর','sadar.feni.gov.bd',0,NULL,NULL),(20,2,'Sonagazi','সোনাগাজী','sonagazi.feni.gov.bd',0,NULL,NULL),(21,2,'Fulgazi','ফুলগাজী','fulgazi.feni.gov.bd',0,NULL,NULL),(22,2,'Parshuram','পরশুরাম','parshuram.feni.gov.bd',0,NULL,NULL),(23,2,'Daganbhuiyan','দাগনভূঞা','daganbhuiyan.feni.gov.bd',0,NULL,NULL),(24,3,'Brahmanbaria Sadar','ব্রাহ্মণবাড়িয়া সদর','sadar.brahmanbaria.gov.bd',0,NULL,NULL),(25,3,'Kasba','কসবা','kasba.brahmanbaria.gov.bd',0,NULL,NULL),(26,3,'Nasirnagar','নাসিরনগর','nasirnagar.brahmanbaria.gov.bd',0,NULL,NULL),(27,3,'Sarail','সরাইল','sarail.brahmanbaria.gov.bd',0,NULL,NULL),(28,3,'Ashuganj','আশুগঞ্জ','ashuganj.brahmanbaria.gov.bd',0,NULL,NULL),(29,3,'Akhaura','আখাউড়া','akhaura.brahmanbaria.gov.bd',0,NULL,NULL),(30,3,'Nabinagar','নবীনগর','nabinagar.brahmanbaria.gov.bd',0,NULL,NULL),(31,3,'Bancharampur','বাঞ্ছারামপুর','bancharampur.brahmanbaria.gov.bd',0,NULL,NULL),(32,3,'Bijoynagar','বিজয়নগর','bijoynagar.brahmanbaria.gov.bd    ',0,NULL,NULL),(33,4,'Rangamati Sadar','রাঙ্গামাটি সদর','sadar.rangamati.gov.bd',0,NULL,NULL),(34,4,'Kaptai','কাপ্তাই','kaptai.rangamati.gov.bd',0,NULL,NULL),(35,4,'Kawkhali','কাউখালী','kawkhali.rangamati.gov.bd',0,NULL,NULL),(36,4,'Baghaichari','বাঘাইছড়ি','baghaichari.rangamati.gov.bd',0,NULL,NULL),(37,4,'Barkal','বরকল','barkal.rangamati.gov.bd',0,NULL,NULL),(38,4,'Langadu','লংগদু','langadu.rangamati.gov.bd',0,NULL,NULL),(39,4,'Rajasthali','রাজস্থলী','rajasthali.rangamati.gov.bd',0,NULL,NULL),(40,4,'Belaichari','বিলাইছড়ি','belaichari.rangamati.gov.bd',0,NULL,NULL),(41,4,'Juraichari','জুরাছড়ি','juraichari.rangamati.gov.bd',0,NULL,NULL),(42,4,'Naniarchar','নানিয়ারচর','naniarchar.rangamati.gov.bd',0,NULL,NULL),(43,5,'Noakhali Sadar','নোয়াখালী সদর','sadar.noakhali.gov.bd',0,NULL,NULL),(44,5,'Companiganj','কোম্পানীগঞ্জ','companiganj.noakhali.gov.bd',0,NULL,NULL),(45,5,'Begumganj','বেগমগঞ্জ','begumganj.noakhali.gov.bd',0,NULL,NULL),(46,5,'Hatia','হাতিয়া','hatia.noakhali.gov.bd',0,NULL,NULL),(47,5,'Subarnachar','সুবর্ণচর','subarnachar.noakhali.gov.bd',0,NULL,NULL),(48,5,'Kabirhat','কবিরহাট','kabirhat.noakhali.gov.bd',0,NULL,NULL),(49,5,'Senbug','সেনবাগ','senbug.noakhali.gov.bd',0,NULL,NULL),(50,5,'Chatkhil','চাটখিল','chatkhil.noakhali.gov.bd',0,NULL,NULL),(51,5,'Sonaimori','সোনাইমুড়ী','sonaimori.noakhali.gov.bd',0,NULL,NULL),(52,6,'Haimchar','হাইমচর','haimchar.chandpur.gov.bd',0,NULL,NULL),(53,6,'Kachua','কচুয়া','kachua.chandpur.gov.bd',0,NULL,NULL),(54,6,'Shahrasti','শাহরাস্তি	','shahrasti.chandpur.gov.bd',0,NULL,NULL),(55,6,'Chandpur Sadar','চাঁদপুর সদর','sadar.chandpur.gov.bd',0,NULL,NULL),(56,6,'Matlab South','মতলব দক্ষিণ','matlabsouth.chandpur.gov.bd',0,NULL,NULL),(57,6,'Hajiganj','হাজীগঞ্জ','hajiganj.chandpur.gov.bd',0,NULL,NULL),(58,6,'Matlab North','মতলব উত্তর','matlabnorth.chandpur.gov.bd',0,NULL,NULL),(59,6,'Faridgonj','ফরিদগঞ্জ','faridgonj.chandpur.gov.bd',0,NULL,NULL),(60,7,'Lakshmipur Sadar','লক্ষ্মীপুর সদর','sadar.lakshmipur.gov.bd',0,NULL,NULL),(61,7,'Kamalnagar','কমলনগর','kamalnagar.lakshmipur.gov.bd',0,NULL,NULL),(62,7,'Raipur','রায়পুর','raipur.lakshmipur.gov.bd',0,NULL,NULL),(63,7,'Ramgati','রামগতি','ramgati.lakshmipur.gov.bd',0,NULL,NULL),(64,7,'Ramganj','রামগঞ্জ','ramganj.lakshmipur.gov.bd',0,NULL,NULL),(65,8,'Rangunia','রাঙ্গুনিয়া','rangunia.chittagong.gov.bd',0,NULL,NULL),(66,8,'Sitakunda','সীতাকুন্ড','sitakunda.chittagong.gov.bd',0,NULL,NULL),(67,8,'Mirsharai','মীরসরাই','mirsharai.chittagong.gov.bd',0,NULL,NULL),(68,8,'Patiya','পটিয়া','patiya.chittagong.gov.bd',0,NULL,NULL),(69,8,'Sandwip','সন্দ্বীপ','sandwip.chittagong.gov.bd',0,NULL,NULL),(70,8,'Banshkhali','বাঁশখালী','banshkhali.chittagong.gov.bd',0,NULL,NULL),(71,8,'Boalkhali','বোয়ালখালী','boalkhali.chittagong.gov.bd',0,NULL,NULL),(72,8,'Anwara','আনোয়ারা','anwara.chittagong.gov.bd',0,NULL,NULL),(73,8,'Chandanaish','চন্দনাইশ','chandanaish.chittagong.gov.bd',0,NULL,NULL),(74,8,'Satkania','সাতকানিয়া','satkania.chittagong.gov.bd',0,NULL,NULL),(75,8,'Lohagara','লোহাগাড়া','lohagara.chittagong.gov.bd',0,NULL,NULL),(76,8,'Hathazari','হাটহাজারী','hathazari.chittagong.gov.bd',0,NULL,NULL),(77,8,'Fatikchhari','ফটিকছড়ি','fatikchhari.chittagong.gov.bd',0,NULL,NULL),(78,8,'Raozan','রাউজান','raozan.chittagong.gov.bd',0,NULL,NULL),(79,8,'Karnafuli','কর্ণফুলী','karnafuli.chittagong.gov.bd',0,NULL,NULL),(80,9,'Coxsbazar Sadar','কক্সবাজার সদর','sadar.coxsbazar.gov.bd',0,NULL,NULL),(81,9,'Chakaria','চকরিয়া','chakaria.coxsbazar.gov.bd',0,NULL,NULL),(82,9,'Kutubdia','কুতুবদিয়া','kutubdia.coxsbazar.gov.bd',0,NULL,NULL),(83,9,'Ukhiya','উখিয়া','ukhiya.coxsbazar.gov.bd',0,NULL,NULL),(84,9,'Moheshkhali','মহেশখালী','moheshkhali.coxsbazar.gov.bd',0,NULL,NULL),(85,9,'Pekua','পেকুয়া','pekua.coxsbazar.gov.bd',0,NULL,NULL),(86,9,'Ramu','রামু','ramu.coxsbazar.gov.bd',0,NULL,NULL),(87,9,'Teknaf','টেকনাফ','teknaf.coxsbazar.gov.bd',0,NULL,NULL),(88,10,'Khagrachhari Sadar','খাগড়াছড়ি সদর','sadar.khagrachhari.gov.bd',0,NULL,NULL),(89,10,'Dighinala','দিঘীনালা','dighinala.khagrachhari.gov.bd',0,NULL,NULL),(90,10,'Panchari','পানছড়ি','panchari.khagrachhari.gov.bd',0,NULL,NULL),(91,10,'Laxmichhari','লক্ষীছড়ি','laxmichhari.khagrachhari.gov.bd',0,NULL,NULL),(92,10,'Mohalchari','মহালছড়ি','mohalchari.khagrachhari.gov.bd',0,NULL,NULL),(93,10,'Manikchari','মানিকছড়ি','manikchari.khagrachhari.gov.bd',0,NULL,NULL),(94,10,'Ramgarh','রামগড়','ramgarh.khagrachhari.gov.bd',0,NULL,NULL),(95,10,'Matiranga','মাটিরাঙ্গা','matiranga.khagrachhari.gov.bd',0,NULL,NULL),(96,10,'Guimara','গুইমারা','guimara.khagrachhari.gov.bd',0,NULL,NULL),(97,11,'Bandarban Sadar','বান্দরবান সদর','sadar.bandarban.gov.bd',0,NULL,NULL),(98,11,'Alikadam','আলীকদম','alikadam.bandarban.gov.bd',0,NULL,NULL),(99,11,'Naikhongchhari','নাইক্ষ্যংছড়ি','naikhongchhari.bandarban.gov.bd',0,NULL,NULL),(100,11,'Rowangchhari','রোয়াংছড়ি','rowangchhari.bandarban.gov.bd',0,NULL,NULL),(101,11,'Lama','লামা','lama.bandarban.gov.bd',0,NULL,NULL),(102,11,'Ruma','রুমা','ruma.bandarban.gov.bd',0,NULL,NULL),(103,11,'Thanchi','থানচি','thanchi.bandarban.gov.bd',0,NULL,NULL),(104,12,'Belkuchi','বেলকুচি','belkuchi.sirajganj.gov.bd',0,NULL,NULL),(105,12,'Chauhali','চৌহালি','chauhali.sirajganj.gov.bd',0,NULL,NULL),(106,12,'Kamarkhand','কামারখন্দ','kamarkhand.sirajganj.gov.bd',0,NULL,NULL),(107,12,'Kazipur','কাজীপুর','kazipur.sirajganj.gov.bd',0,NULL,NULL),(108,12,'Raigonj','রায়গঞ্জ','raigonj.sirajganj.gov.bd',0,NULL,NULL),(109,12,'Shahjadpur','শাহজাদপুর','shahjadpur.sirajganj.gov.bd',0,NULL,NULL),(110,12,'Sirajganj Sadar','সিরাজগঞ্জ সদর','sirajganjsadar.sirajganj.gov.bd',0,NULL,NULL),(111,12,'Tarash','তাড়াশ','tarash.sirajganj.gov.bd',0,NULL,NULL),(112,12,'Ullapara','উল্লাপাড়া','ullapara.sirajganj.gov.bd',0,NULL,NULL),(113,13,'Sujanagar','সুজানগর','sujanagar.pabna.gov.bd',0,NULL,NULL),(114,13,'Ishurdi','ঈশ্বরদী','ishurdi.pabna.gov.bd',0,NULL,NULL),(115,13,'Bhangura','ভাঙ্গুড়া','bhangura.pabna.gov.bd',0,NULL,NULL),(116,13,'Pabna Sadar','পাবনা সদর','pabnasadar.pabna.gov.bd',0,NULL,NULL),(117,13,'Bera','বেড়া','bera.pabna.gov.bd',0,NULL,NULL),(118,13,'Atghoria','আটঘরিয়া','atghoria.pabna.gov.bd',0,NULL,NULL),(119,13,'Chatmohar','চাটমোহর','chatmohar.pabna.gov.bd',0,NULL,NULL),(120,13,'Santhia','সাঁথিয়া','santhia.pabna.gov.bd',0,NULL,NULL),(121,13,'Faridpur','ফরিদপুর','faridpur.pabna.gov.bd',0,NULL,NULL),(122,14,'Kahaloo','কাহালু','kahaloo.bogra.gov.bd',0,NULL,NULL),(123,14,'Bogra Sadar','বগুড়া সদর','sadar.bogra.gov.bd',0,NULL,NULL),(124,14,'Shariakandi','সারিয়াকান্দি','shariakandi.bogra.gov.bd',0,NULL,NULL),(125,14,'Shajahanpur','শাজাহানপুর','shajahanpur.bogra.gov.bd',0,NULL,NULL),(126,14,'Dupchanchia','দুপচাচিঁয়া','dupchanchia.bogra.gov.bd',0,NULL,NULL),(127,14,'Adamdighi','আদমদিঘি','adamdighi.bogra.gov.bd',0,NULL,NULL),(128,14,'Nondigram','নন্দিগ্রাম','nondigram.bogra.gov.bd',0,NULL,NULL),(129,14,'Sonatala','সোনাতলা','sonatala.bogra.gov.bd',0,NULL,NULL),(130,14,'Dhunot','ধুনট','dhunot.bogra.gov.bd',0,NULL,NULL),(131,14,'Gabtali','গাবতলী','gabtali.bogra.gov.bd',0,NULL,NULL),(132,14,'Sherpur','শেরপুর','sherpur.bogra.gov.bd',0,NULL,NULL),(133,14,'Shibganj','শিবগঞ্জ','shibganj.bogra.gov.bd',0,NULL,NULL),(134,15,'Paba','পবা','paba.rajshahi.gov.bd',0,NULL,NULL),(135,15,'Durgapur','দুর্গাপুর','durgapur.rajshahi.gov.bd',0,NULL,NULL),(136,15,'Mohonpur','মোহনপুর','mohonpur.rajshahi.gov.bd',0,NULL,NULL),(137,15,'Charghat','চারঘাট','charghat.rajshahi.gov.bd',0,NULL,NULL),(138,15,'Puthia','পুঠিয়া','puthia.rajshahi.gov.bd',0,NULL,NULL),(139,15,'Bagha','বাঘা','bagha.rajshahi.gov.bd',0,NULL,NULL),(140,15,'Godagari','গোদাগাড়ী','godagari.rajshahi.gov.bd',0,NULL,NULL),(141,15,'Tanore','তানোর','tanore.rajshahi.gov.bd',0,NULL,NULL),(142,15,'Bagmara','বাগমারা','bagmara.rajshahi.gov.bd',0,NULL,NULL),(143,16,'Natore Sadar','নাটোর সদর','natoresadar.natore.gov.bd',0,NULL,NULL),(144,16,'Singra','সিংড়া','singra.natore.gov.bd',0,NULL,NULL),(145,16,'Baraigram','বড়াইগ্রাম','baraigram.natore.gov.bd',0,NULL,NULL),(146,16,'Bagatipara','বাগাতিপাড়া','bagatipara.natore.gov.bd',0,NULL,NULL),(147,16,'Lalpur','লালপুর','lalpur.natore.gov.bd',0,NULL,NULL),(148,16,'Gurudaspur','গুরুদাসপুর','gurudaspur.natore.gov.bd',0,NULL,NULL),(149,16,'Naldanga','নলডাঙ্গা','naldanga.natore.gov.bd',0,NULL,NULL),(150,17,'Akkelpur','আক্কেলপুর','akkelpur.joypurhat.gov.bd',0,NULL,NULL),(151,17,'Kalai','কালাই','kalai.joypurhat.gov.bd',0,NULL,NULL),(152,17,'Khetlal','ক্ষেতলাল','khetlal.joypurhat.gov.bd',0,NULL,NULL),(153,17,'Panchbibi','পাঁচবিবি','panchbibi.joypurhat.gov.bd',0,NULL,NULL),(154,17,'Joypurhat Sadar','জয়পুরহাট সদর','joypurhatsadar.joypurhat.gov.bd',0,NULL,NULL),(155,18,'Chapainawabganj Sadar','চাঁপাইনবাবগঞ্জ সদর','chapainawabganjsadar.chapainawabganj.gov.bd',0,NULL,NULL),(156,18,'Gomostapur','গোমস্তাপুর','gomostapur.chapainawabganj.gov.bd',0,NULL,NULL),(157,18,'Nachol','নাচোল','nachol.chapainawabganj.gov.bd',0,NULL,NULL),(158,18,'Bholahat','ভোলাহাট','bholahat.chapainawabganj.gov.bd',0,NULL,NULL),(159,18,'Shibganj','শিবগঞ্জ','shibganj.chapainawabganj.gov.bd',0,NULL,NULL),(160,19,'Mohadevpur','মহাদেবপুর','mohadevpur.naogaon.gov.bd',0,NULL,NULL),(161,19,'Badalgachi','বদলগাছী','badalgachi.naogaon.gov.bd',0,NULL,NULL),(162,19,'Patnitala','পত্নিতলা','patnitala.naogaon.gov.bd',0,NULL,NULL),(163,19,'Dhamoirhat','ধামইরহাট','dhamoirhat.naogaon.gov.bd',0,NULL,NULL),(164,19,'Niamatpur','নিয়ামতপুর','niamatpur.naogaon.gov.bd',0,NULL,NULL),(165,19,'Manda','মান্দা','manda.naogaon.gov.bd',0,NULL,NULL),(166,19,'Atrai','আত্রাই','atrai.naogaon.gov.bd',0,NULL,NULL),(167,19,'Raninagar','রাণীনগর','raninagar.naogaon.gov.bd',0,NULL,NULL),(168,19,'Naogaon Sadar','নওগাঁ সদর','naogaonsadar.naogaon.gov.bd',0,NULL,NULL),(169,19,'Porsha','পোরশা','porsha.naogaon.gov.bd',0,NULL,NULL),(170,19,'Sapahar','সাপাহার','sapahar.naogaon.gov.bd',0,NULL,NULL),(171,20,'Manirampur','মণিরামপুর','manirampur.jessore.gov.bd',0,NULL,NULL),(172,20,'Abhaynagar','অভয়নগর','abhaynagar.jessore.gov.bd',0,NULL,NULL),(173,20,'Bagherpara','বাঘারপাড়া','bagherpara.jessore.gov.bd',0,NULL,NULL),(174,20,'Chougachha','চৌগাছা','chougachha.jessore.gov.bd',0,NULL,NULL),(175,20,'Jhikargacha','ঝিকরগাছা','jhikargacha.jessore.gov.bd',0,NULL,NULL),(176,20,'Keshabpur','কেশবপুর','keshabpur.jessore.gov.bd',0,NULL,NULL),(177,20,'Jessore Sadar','যশোর সদর','sadar.jessore.gov.bd',0,NULL,NULL),(178,20,'Sharsha','শার্শা','sharsha.jessore.gov.bd',0,NULL,NULL),(179,21,'Assasuni','আশাশুনি','assasuni.satkhira.gov.bd',0,NULL,NULL),(180,21,'Debhata','দেবহাটা','debhata.satkhira.gov.bd',0,NULL,NULL),(181,21,'Kalaroa','কলারোয়া','kalaroa.satkhira.gov.bd',0,NULL,NULL),(182,21,'Satkhira Sadar','সাতক্ষীরা সদর','satkhirasadar.satkhira.gov.bd',0,NULL,NULL),(183,21,'Shyamnagar','শ্যামনগর','shyamnagar.satkhira.gov.bd',0,NULL,NULL),(184,21,'Tala','তালা','tala.satkhira.gov.bd',0,NULL,NULL),(185,21,'Kaliganj','কালিগঞ্জ','kaliganj.satkhira.gov.bd',0,NULL,NULL),(186,22,'Mujibnagar','মুজিবনগর','mujibnagar.meherpur.gov.bd',0,NULL,NULL),(187,22,'Meherpur Sadar','মেহেরপুর সদর','meherpursadar.meherpur.gov.bd',0,NULL,NULL),(188,22,'Gangni','গাংনী','gangni.meherpur.gov.bd',0,NULL,NULL),(189,23,'Narail Sadar','নড়াইল সদর','narailsadar.narail.gov.bd',0,NULL,NULL),(190,23,'Lohagara','লোহাগড়া','lohagara.narail.gov.bd',0,NULL,NULL),(191,23,'Kalia','কালিয়া','kalia.narail.gov.bd',0,NULL,NULL),(192,24,'Chuadanga Sadar','চুয়াডাঙ্গা সদর','chuadangasadar.chuadanga.gov.bd',0,NULL,NULL),(193,24,'Alamdanga','আলমডাঙ্গা','alamdanga.chuadanga.gov.bd',0,NULL,NULL),(194,24,'Damurhuda','দামুড়হুদা','damurhuda.chuadanga.gov.bd',0,NULL,NULL),(195,24,'Jibannagar','জীবননগর','jibannagar.chuadanga.gov.bd',0,NULL,NULL),(196,25,'Kushtia Sadar','কুষ্টিয়া সদর','kushtiasadar.kushtia.gov.bd',0,NULL,NULL),(197,25,'Kumarkhali','কুমারখালী','kumarkhali.kushtia.gov.bd',0,NULL,NULL),(198,25,'Khoksa','খোকসা','khoksa.kushtia.gov.bd',0,NULL,NULL),(199,25,'Mirpur','মিরপুর','mirpurkushtia.kushtia.gov.bd',0,NULL,NULL),(200,25,'Daulatpur','দৌলতপুর','daulatpur.kushtia.gov.bd',0,NULL,NULL),(201,25,'Bheramara','ভেড়ামারা','bheramara.kushtia.gov.bd',0,NULL,NULL),(202,26,'Shalikha','শালিখা','shalikha.magura.gov.bd',0,NULL,NULL),(203,26,'Sreepur','শ্রীপুর','sreepur.magura.gov.bd',0,NULL,NULL),(204,26,'Magura Sadar','মাগুরা সদর','magurasadar.magura.gov.bd',0,NULL,NULL),(205,26,'Mohammadpur','মহম্মদপুর','mohammadpur.magura.gov.bd',0,NULL,NULL),(206,27,'Paikgasa','পাইকগাছা','paikgasa.khulna.gov.bd',0,NULL,NULL),(207,27,'Fultola','ফুলতলা','fultola.khulna.gov.bd',0,NULL,NULL),(208,27,'Digholia','দিঘলিয়া','digholia.khulna.gov.bd',0,NULL,NULL),(209,27,'Rupsha','রূপসা','rupsha.khulna.gov.bd',0,NULL,NULL),(210,27,'Terokhada','তেরখাদা','terokhada.khulna.gov.bd',0,NULL,NULL),(211,27,'Dumuria','ডুমুরিয়া','dumuria.khulna.gov.bd',0,NULL,NULL),(212,27,'Botiaghata','বটিয়াঘাটা','botiaghata.khulna.gov.bd',0,NULL,NULL),(213,27,'Dakop','দাকোপ','dakop.khulna.gov.bd',0,NULL,NULL),(214,27,'Koyra','কয়রা','koyra.khulna.gov.bd',0,NULL,NULL),(215,28,'Fakirhat','ফকিরহাট','fakirhat.bagerhat.gov.bd',0,NULL,NULL),(216,28,'Bagerhat Sadar','বাগেরহাট সদর','sadar.bagerhat.gov.bd',0,NULL,NULL),(217,28,'Mollahat','মোল্লাহাট','mollahat.bagerhat.gov.bd',0,NULL,NULL),(218,28,'Sarankhola','শরণখোলা','sarankhola.bagerhat.gov.bd',0,NULL,NULL),(219,28,'Rampal','রামপাল','rampal.bagerhat.gov.bd',0,NULL,NULL),(220,28,'Morrelganj','মোড়েলগঞ্জ','morrelganj.bagerhat.gov.bd',0,NULL,NULL),(221,28,'Kachua','কচুয়া','kachua.bagerhat.gov.bd',0,NULL,NULL),(222,28,'Mongla','মোংলা','mongla.bagerhat.gov.bd',0,NULL,NULL),(223,28,'Chitalmari','চিতলমারী','chitalmari.bagerhat.gov.bd',0,NULL,NULL),(224,29,'Jhenaidah Sadar','ঝিনাইদহ সদর','sadar.jhenaidah.gov.bd',0,NULL,NULL),(225,29,'Shailkupa','শৈলকুপা','shailkupa.jhenaidah.gov.bd',0,NULL,NULL),(226,29,'Harinakundu','হরিণাকুন্ডু','harinakundu.jhenaidah.gov.bd',0,NULL,NULL),(227,29,'Kaliganj','কালীগঞ্জ','kaliganj.jhenaidah.gov.bd',0,NULL,NULL),(228,29,'Kotchandpur','কোটচাঁদপুর','kotchandpur.jhenaidah.gov.bd',0,NULL,NULL),(229,29,'Moheshpur','মহেশপুর','moheshpur.jhenaidah.gov.bd',0,NULL,NULL),(230,30,'Jhalakathi Sadar','ঝালকাঠি সদর','sadar.jhalakathi.gov.bd',0,NULL,NULL),(231,30,'Kathalia','কাঠালিয়া','kathalia.jhalakathi.gov.bd',0,NULL,NULL),(232,30,'Nalchity','নলছিটি','nalchity.jhalakathi.gov.bd',0,NULL,NULL),(233,30,'Rajapur','রাজাপুর','rajapur.jhalakathi.gov.bd',0,NULL,NULL),(234,31,'Bauphal','বাউফল','bauphal.patuakhali.gov.bd',0,NULL,NULL),(235,31,'Patuakhali Sadar','পটুয়াখালী সদর','sadar.patuakhali.gov.bd',0,NULL,NULL),(236,31,'Dumki','দুমকি','dumki.patuakhali.gov.bd',0,NULL,NULL),(237,31,'Dashmina','দশমিনা','dashmina.patuakhali.gov.bd',0,NULL,NULL),(238,31,'Kalapara','কলাপাড়া','kalapara.patuakhali.gov.bd',0,NULL,NULL),(239,31,'Mirzaganj','মির্জাগঞ্জ','mirzaganj.patuakhali.gov.bd',0,NULL,NULL),(240,31,'Galachipa','গলাচিপা','galachipa.patuakhali.gov.bd',0,NULL,NULL),(241,31,'Rangabali','রাঙ্গাবালী','rangabali.patuakhali.gov.bd',0,NULL,NULL),(242,32,'Pirojpur Sadar','পিরোজপুর সদর','sadar.pirojpur.gov.bd',0,NULL,NULL),(243,32,'Nazirpur','নাজিরপুর','nazirpur.pirojpur.gov.bd',0,NULL,NULL),(244,32,'Kawkhali','কাউখালী','kawkhali.pirojpur.gov.bd',0,NULL,NULL),(245,32,'Zianagar','জিয়ানগর','zianagar.pirojpur.gov.bd',0,NULL,NULL),(246,32,'Bhandaria','ভান্ডারিয়া','bhandaria.pirojpur.gov.bd',0,NULL,NULL),(247,32,'Mathbaria','মঠবাড়ীয়া','mathbaria.pirojpur.gov.bd',0,NULL,NULL),(248,32,'Nesarabad','নেছারাবাদ','nesarabad.pirojpur.gov.bd',0,NULL,NULL),(249,33,'Barisal Sadar','বরিশাল সদর','barisalsadar.barisal.gov.bd',0,NULL,NULL),(250,33,'Bakerganj','বাকেরগঞ্জ','bakerganj.barisal.gov.bd',0,NULL,NULL),(251,33,'Babuganj','বাবুগঞ্জ','babuganj.barisal.gov.bd',0,NULL,NULL),(252,33,'Wazirpur','উজিরপুর','wazirpur.barisal.gov.bd',0,NULL,NULL),(253,33,'Banaripara','বানারীপাড়া','banaripara.barisal.gov.bd',0,NULL,NULL),(254,33,'Gournadi','গৌরনদী','gournadi.barisal.gov.bd',0,NULL,NULL),(255,33,'Agailjhara','আগৈলঝাড়া','agailjhara.barisal.gov.bd',0,NULL,NULL),(256,33,'Mehendiganj','মেহেন্দিগঞ্জ','mehendiganj.barisal.gov.bd',0,NULL,NULL),(257,33,'Muladi','মুলাদী','muladi.barisal.gov.bd',0,NULL,NULL),(258,33,'Hizla','হিজলা','hizla.barisal.gov.bd',0,NULL,NULL),(259,34,'Bhola Sadar','ভোলা সদর','sadar.bhola.gov.bd',0,NULL,NULL),(260,34,'Borhan Sddin','বোরহান উদ্দিন','borhanuddin.bhola.gov.bd',0,NULL,NULL),(261,34,'Charfesson','চরফ্যাশন','charfesson.bhola.gov.bd',0,NULL,NULL),(262,34,'Doulatkhan','দৌলতখান','doulatkhan.bhola.gov.bd',0,NULL,NULL),(263,34,'Monpura','মনপুরা','monpura.bhola.gov.bd',0,NULL,NULL),(264,34,'Tazumuddin','তজুমদ্দিন','tazumuddin.bhola.gov.bd',0,NULL,NULL),(265,34,'Lalmohan','লালমোহন','lalmohan.bhola.gov.bd',0,NULL,NULL),(266,35,'Amtali','আমতলী','amtali.barguna.gov.bd',0,NULL,NULL),(267,35,'Barguna Sadar','বরগুনা সদর','sadar.barguna.gov.bd',0,NULL,NULL),(268,35,'Betagi','বেতাগী','betagi.barguna.gov.bd',0,NULL,NULL),(269,35,'Bamna','বামনা','bamna.barguna.gov.bd',0,NULL,NULL),(270,35,'Pathorghata','পাথরঘাটা','pathorghata.barguna.gov.bd',0,NULL,NULL),(271,35,'Taltali','তালতলি','taltali.barguna.gov.bd',0,NULL,NULL),(272,36,'Balaganj','বালাগঞ্জ','balaganj.sylhet.gov.bd',0,NULL,NULL),(273,36,'Beanibazar','বিয়ানীবাজার','beanibazar.sylhet.gov.bd',0,NULL,NULL),(274,36,'Bishwanath','বিশ্বনাথ','bishwanath.sylhet.gov.bd',0,NULL,NULL),(275,36,'Companiganj','কোম্পানীগঞ্জ','companiganj.sylhet.gov.bd',0,NULL,NULL),(276,36,'Fenchuganj','ফেঞ্চুগঞ্জ','fenchuganj.sylhet.gov.bd',0,NULL,NULL),(277,36,'Golapganj','গোলাপগঞ্জ','golapganj.sylhet.gov.bd',0,NULL,NULL),(278,36,'Gowainghat','গোয়াইনঘাট','gowainghat.sylhet.gov.bd',0,NULL,NULL),(279,36,'Jaintiapur','জৈন্তাপুর','jaintiapur.sylhet.gov.bd',0,NULL,NULL),(280,36,'Kanaighat','কানাইঘাট','kanaighat.sylhet.gov.bd',0,NULL,NULL),(281,36,'Sylhet Sadar','সিলেট সদর','sylhetsadar.sylhet.gov.bd',0,NULL,NULL),(282,36,'Zakiganj','জকিগঞ্জ','zakiganj.sylhet.gov.bd',0,NULL,NULL),(283,36,'Dakshinsurma','দক্ষিণ সুরমা','dakshinsurma.sylhet.gov.bd',0,NULL,NULL),(284,36,'Osmaninagar','ওসমানী নগর','osmaninagar.sylhet.gov.bd',0,NULL,NULL),(285,37,'Barlekha','বড়লেখা','barlekha.moulvibazar.gov.bd',0,NULL,NULL),(286,37,'Kamolganj','কমলগঞ্জ','kamolganj.moulvibazar.gov.bd',0,NULL,NULL),(287,37,'Kulaura','কুলাউড়া','kulaura.moulvibazar.gov.bd',0,NULL,NULL),(288,37,'Moulvibazar Sadar','মৌলভীবাজার সদর','moulvibazarsadar.moulvibazar.gov.bd',0,NULL,NULL),(289,37,'Rajnagar','রাজনগর','rajnagar.moulvibazar.gov.bd',0,NULL,NULL),(290,37,'Sreemangal','শ্রীমঙ্গল','sreemangal.moulvibazar.gov.bd',0,NULL,NULL),(291,37,'Juri','জুড়ী','juri.moulvibazar.gov.bd',0,NULL,NULL),(292,38,'Nabiganj','নবীগঞ্জ','nabiganj.habiganj.gov.bd',0,NULL,NULL),(293,38,'Bahubal','বাহুবল','bahubal.habiganj.gov.bd',0,NULL,NULL),(294,38,'Ajmiriganj','আজমিরীগঞ্জ','ajmiriganj.habiganj.gov.bd',0,NULL,NULL),(295,38,'Baniachong','বানিয়াচং','baniachong.habiganj.gov.bd',0,NULL,NULL),(296,38,'Lakhai','লাখাই','lakhai.habiganj.gov.bd',0,NULL,NULL),(297,38,'Chunarughat','চুনারুঘাট','chunarughat.habiganj.gov.bd',0,NULL,NULL),(298,38,'Habiganj Sadar','হবিগঞ্জ সদর','habiganjsadar.habiganj.gov.bd',0,NULL,NULL),(299,38,'Madhabpur','মাধবপুর','madhabpur.habiganj.gov.bd',0,NULL,NULL),(300,39,'Sunamganj Sadar','সুনামগঞ্জ সদর','sadar.sunamganj.gov.bd',0,NULL,NULL),(301,39,'South Sunamganj','দক্ষিণ সুনামগঞ্জ','southsunamganj.sunamganj.gov.bd',0,NULL,NULL),(302,39,'Bishwambarpur','বিশ্বম্ভরপুর','bishwambarpur.sunamganj.gov.bd',0,NULL,NULL),(303,39,'Chhatak','ছাতক','chhatak.sunamganj.gov.bd',0,NULL,NULL),(304,39,'Jagannathpur','জগন্নাথপুর','jagannathpur.sunamganj.gov.bd',0,NULL,NULL),(305,39,'Dowarabazar','দোয়ারাবাজার','dowarabazar.sunamganj.gov.bd',0,NULL,NULL),(306,39,'Tahirpur','তাহিরপুর','tahirpur.sunamganj.gov.bd',0,NULL,NULL),(307,39,'Dharmapasha','ধর্মপাশা','dharmapasha.sunamganj.gov.bd',0,NULL,NULL),(308,39,'Jamalganj','জামালগঞ্জ','jamalganj.sunamganj.gov.bd',0,NULL,NULL),(309,39,'Shalla','শাল্লা','shalla.sunamganj.gov.bd',0,NULL,NULL),(310,39,'Derai','দিরাই','derai.sunamganj.gov.bd',0,NULL,NULL),(311,40,'Belabo','বেলাবো','belabo.narsingdi.gov.bd',0,NULL,NULL),(312,40,'Monohardi','মনোহরদী','monohardi.narsingdi.gov.bd',0,NULL,NULL),(313,40,'Narsingdi Sadar','নরসিংদী সদর','narsingdisadar.narsingdi.gov.bd',0,NULL,NULL),(314,40,'Palash','পলাশ','palash.narsingdi.gov.bd',0,NULL,NULL),(315,40,'Raipura','রায়পুরা','raipura.narsingdi.gov.bd',0,NULL,NULL),(316,40,'Shibpur','শিবপুর','shibpur.narsingdi.gov.bd',0,NULL,NULL),(317,41,'Kaliganj','কালীগঞ্জ','kaliganj.gazipur.gov.bd',0,NULL,NULL),(318,41,'Kaliakair','কালিয়াকৈর','kaliakair.gazipur.gov.bd',0,NULL,NULL),(319,41,'Kapasia','কাপাসিয়া','kapasia.gazipur.gov.bd',0,NULL,NULL),(320,41,'Gazipur Sadar','গাজীপুর সদর','sadar.gazipur.gov.bd',0,NULL,NULL),(321,41,'Sreepur','শ্রীপুর','sreepur.gazipur.gov.bd',0,NULL,NULL),(322,42,'Shariatpur Sadar','শরিয়তপুর সদর','sadar.shariatpur.gov.bd',0,NULL,NULL),(323,42,'Naria','নড়িয়া','naria.shariatpur.gov.bd',0,NULL,NULL),(324,42,'Zajira','জাজিরা','zajira.shariatpur.gov.bd',0,NULL,NULL),(325,42,'Gosairhat','গোসাইরহাট','gosairhat.shariatpur.gov.bd',0,NULL,NULL),(326,42,'Bhedarganj','ভেদরগঞ্জ','bhedarganj.shariatpur.gov.bd',0,NULL,NULL),(327,42,'Damudya','ডামুড্যা','damudya.shariatpur.gov.bd',0,NULL,NULL),(328,43,'Araihazar','আড়াইহাজার','araihazar.narayanganj.gov.bd',0,NULL,NULL),(329,43,'Bandar','বন্দর','bandar.narayanganj.gov.bd',0,NULL,NULL),(330,43,'Narayanganj Sadar','নারায়নগঞ্জ সদর','narayanganjsadar.narayanganj.gov.bd',0,NULL,NULL),(331,43,'Rupganj','রূপগঞ্জ','rupganj.narayanganj.gov.bd',0,NULL,NULL),(332,43,'Sonargaon','সোনারগাঁ','sonargaon.narayanganj.gov.bd',0,NULL,NULL),(333,44,'Basail','বাসাইল','basail.tangail.gov.bd',0,NULL,NULL),(334,44,'Bhuapur','ভুয়াপুর','bhuapur.tangail.gov.bd',0,NULL,NULL),(335,44,'Delduar','দেলদুয়ার','delduar.tangail.gov.bd',0,NULL,NULL),(336,44,'Ghatail','ঘাটাইল','ghatail.tangail.gov.bd',0,NULL,NULL),(337,44,'Gopalpur','গোপালপুর','gopalpur.tangail.gov.bd',0,NULL,NULL),(338,44,'Madhupur','মধুপুর','madhupur.tangail.gov.bd',0,NULL,NULL),(339,44,'Mirzapur','মির্জাপুর','mirzapur.tangail.gov.bd',0,NULL,NULL),(340,44,'Nagarpur','নাগরপুর','nagarpur.tangail.gov.bd',0,NULL,NULL),(341,44,'Sakhipur','সখিপুর','sakhipur.tangail.gov.bd',0,NULL,NULL),(342,44,'Tangail Sadar','টাঙ্গাইল সদর','tangailsadar.tangail.gov.bd',0,NULL,NULL),(343,44,'Kalihati','কালিহাতী','kalihati.tangail.gov.bd',0,NULL,NULL),(344,44,'Dhanbari','ধনবাড়ী','dhanbari.tangail.gov.bd',0,NULL,NULL),(345,45,'Itna','ইটনা','itna.kishoreganj.gov.bd',0,NULL,NULL),(346,45,'Katiadi','কটিয়াদী','katiadi.kishoreganj.gov.bd',0,NULL,NULL),(347,45,'Bhairab','ভৈরব','bhairab.kishoreganj.gov.bd',0,NULL,NULL),(348,45,'Tarail','তাড়াইল','tarail.kishoreganj.gov.bd',0,NULL,NULL),(349,45,'Hossainpur','হোসেনপুর','hossainpur.kishoreganj.gov.bd',0,NULL,NULL),(350,45,'Pakundia','পাকুন্দিয়া','pakundia.kishoreganj.gov.bd',0,NULL,NULL),(351,45,'Kuliarchar','কুলিয়ারচর','kuliarchar.kishoreganj.gov.bd',0,NULL,NULL),(352,45,'Kishoreganj Sadar','কিশোরগঞ্জ সদর','kishoreganjsadar.kishoreganj.gov.bd',0,NULL,NULL),(353,45,'Karimgonj','করিমগঞ্জ','karimgonj.kishoreganj.gov.bd',0,NULL,NULL),(354,45,'Bajitpur','বাজিতপুর','bajitpur.kishoreganj.gov.bd',0,NULL,NULL),(355,45,'Austagram','অষ্টগ্রাম','austagram.kishoreganj.gov.bd',0,NULL,NULL),(356,45,'Mithamoin','মিঠামইন','mithamoin.kishoreganj.gov.bd',0,NULL,NULL),(357,45,'Nikli','নিকলী','nikli.kishoreganj.gov.bd',0,NULL,NULL),(358,46,'Harirampur','হরিরামপুর','harirampur.manikganj.gov.bd',0,NULL,NULL),(359,46,'Saturia','সাটুরিয়া','saturia.manikganj.gov.bd',0,NULL,NULL),(360,46,'Manikganj Sadar','মানিকগঞ্জ সদর','sadar.manikganj.gov.bd',0,NULL,NULL),(361,46,'Gior','ঘিওর','gior.manikganj.gov.bd',0,NULL,NULL),(362,46,'Shibaloy','শিবালয়','shibaloy.manikganj.gov.bd',0,NULL,NULL),(363,46,'Doulatpur','দৌলতপুর','doulatpur.manikganj.gov.bd',0,NULL,NULL),(364,46,'Singiar','সিংগাইর','singiar.manikganj.gov.bd',0,NULL,NULL),(365,47,'Savar','সাভার','savar.dhaka.gov.bd',0,NULL,NULL),(366,47,'Dhamrai','ধামরাই','dhamrai.dhaka.gov.bd',0,NULL,NULL),(367,47,'Keraniganj','কেরাণীগঞ্জ','keraniganj.dhaka.gov.bd',0,NULL,NULL),(368,47,'Nawabganj','নবাবগঞ্জ','nawabganj.dhaka.gov.bd',0,NULL,NULL),(369,47,'Dohar','দোহার','dohar.dhaka.gov.bd',0,NULL,NULL),(370,48,'Munshiganj Sadar','মুন্সিগঞ্জ সদর','sadar.munshiganj.gov.bd',0,NULL,NULL),(371,48,'Sreenagar','শ্রীনগর','sreenagar.munshiganj.gov.bd',0,NULL,NULL),(372,48,'Sirajdikhan','সিরাজদিখান','sirajdikhan.munshiganj.gov.bd',0,NULL,NULL),(373,48,'Louhajanj','লৌহজং','louhajanj.munshiganj.gov.bd',0,NULL,NULL),(374,48,'Gajaria','গজারিয়া','gajaria.munshiganj.gov.bd',0,NULL,NULL),(375,48,'Tongibari','টংগীবাড়ি','tongibari.munshiganj.gov.bd',0,NULL,NULL),(376,49,'Rajbari Sadar','রাজবাড়ী সদর','sadar.rajbari.gov.bd',0,NULL,NULL),(377,49,'Goalanda','গোয়ালন্দ','goalanda.rajbari.gov.bd',0,NULL,NULL),(378,49,'Pangsa','পাংশা','pangsa.rajbari.gov.bd',0,NULL,NULL),(379,49,'Baliakandi','বালিয়াকান্দি','baliakandi.rajbari.gov.bd',0,NULL,NULL),(380,49,'Kalukhali','কালুখালী','kalukhali.rajbari.gov.bd',0,NULL,NULL),(381,50,'Madaripur Sadar','মাদারীপুর সদর','sadar.madaripur.gov.bd',0,NULL,NULL),(382,50,'Shibchar','শিবচর','shibchar.madaripur.gov.bd',0,NULL,NULL),(383,50,'Kalkini','কালকিনি','kalkini.madaripur.gov.bd',0,NULL,NULL),(384,50,'Rajoir','রাজৈর','rajoir.madaripur.gov.bd',0,NULL,NULL),(385,51,'Gopalganj Sadar','গোপালগঞ্জ সদর','sadar.gopalganj.gov.bd',0,NULL,NULL),(386,51,'Kashiani','কাশিয়ানী','kashiani.gopalganj.gov.bd',0,NULL,NULL),(387,51,'Tungipara','টুংগীপাড়া','tungipara.gopalganj.gov.bd',0,NULL,NULL),(388,51,'Kotalipara','কোটালীপাড়া','kotalipara.gopalganj.gov.bd',0,NULL,NULL),(389,51,'Muksudpur','মুকসুদপুর','muksudpur.gopalganj.gov.bd',0,NULL,NULL),(390,52,'Faridpur Sadar','ফরিদপুর সদর','sadar.faridpur.gov.bd',0,NULL,NULL),(391,52,'Alfadanga','আলফাডাঙ্গা','alfadanga.faridpur.gov.bd',0,NULL,NULL),(392,52,'Boalmari','বোয়ালমারী','boalmari.faridpur.gov.bd',0,NULL,NULL),(393,52,'Sadarpur','সদরপুর','sadarpur.faridpur.gov.bd',0,NULL,NULL),(394,52,'Nagarkanda','নগরকান্দা','nagarkanda.faridpur.gov.bd',0,NULL,NULL),(395,52,'Bhanga','ভাঙ্গা','bhanga.faridpur.gov.bd',0,NULL,NULL),(396,52,'Charbhadrasan','চরভদ্রাসন','charbhadrasan.faridpur.gov.bd',0,NULL,NULL),(397,52,'Madhukhali','মধুখালী','madhukhali.faridpur.gov.bd',0,NULL,NULL),(398,52,'Saltha','সালথা','saltha.faridpur.gov.bd',0,NULL,NULL),(399,53,'Panchagarh Sadar','পঞ্চগড় সদর','panchagarhsadar.panchagarh.gov.bd',0,NULL,NULL),(400,53,'Debiganj','দেবীগঞ্জ','debiganj.panchagarh.gov.bd',0,NULL,NULL),(401,53,'Boda','বোদা','boda.panchagarh.gov.bd',0,NULL,NULL),(402,53,'Atwari','আটোয়ারী','atwari.panchagarh.gov.bd',0,NULL,NULL),(403,53,'Tetulia','তেতুলিয়া','tetulia.panchagarh.gov.bd',0,NULL,NULL),(404,54,'Nawabganj','নবাবগঞ্জ','nawabganj.dinajpur.gov.bd',0,NULL,NULL),(405,54,'Birganj','বীরগঞ্জ','birganj.dinajpur.gov.bd',0,NULL,NULL),(406,54,'Ghoraghat','ঘোড়াঘাট','ghoraghat.dinajpur.gov.bd',0,NULL,NULL),(407,54,'Birampur','বিরামপুর','birampur.dinajpur.gov.bd',0,NULL,NULL),(408,54,'Parbatipur','পার্বতীপুর','parbatipur.dinajpur.gov.bd',0,NULL,NULL),(409,54,'Bochaganj','বোচাগঞ্জ','bochaganj.dinajpur.gov.bd',0,NULL,NULL),(410,54,'Kaharol','কাহারোল','kaharol.dinajpur.gov.bd',0,NULL,NULL),(411,54,'Fulbari','ফুলবাড়ী','fulbari.dinajpur.gov.bd',0,NULL,NULL),(412,54,'Dinajpur Sadar','দিনাজপুর সদর','dinajpursadar.dinajpur.gov.bd',0,NULL,NULL),(413,54,'Hakimpur','হাকিমপুর','hakimpur.dinajpur.gov.bd',0,NULL,NULL),(414,54,'Khansama','খানসামা','khansama.dinajpur.gov.bd',0,NULL,NULL),(415,54,'Birol','বিরল','birol.dinajpur.gov.bd',0,NULL,NULL),(416,54,'Chirirbandar','চিরিরবন্দর','chirirbandar.dinajpur.gov.bd',0,NULL,NULL),(417,55,'Lalmonirhat Sadar','লালমনিরহাট সদর','sadar.lalmonirhat.gov.bd',0,NULL,NULL),(418,55,'Kaliganj','কালীগঞ্জ','kaliganj.lalmonirhat.gov.bd',0,NULL,NULL),(419,55,'Hatibandha','হাতীবান্ধা','hatibandha.lalmonirhat.gov.bd',0,NULL,NULL),(420,55,'Patgram','পাটগ্রাম','patgram.lalmonirhat.gov.bd',0,NULL,NULL),(421,55,'Aditmari','আদিতমারী','aditmari.lalmonirhat.gov.bd',0,NULL,NULL),(422,56,'Syedpur','সৈয়দপুর','syedpur.nilphamari.gov.bd',0,NULL,NULL),(423,56,'Domar','ডোমার','domar.nilphamari.gov.bd',0,NULL,NULL),(424,56,'Dimla','ডিমলা','dimla.nilphamari.gov.bd',0,NULL,NULL),(425,56,'Jaldhaka','জলঢাকা','jaldhaka.nilphamari.gov.bd',0,NULL,NULL),(426,56,'Kishorganj','কিশোরগঞ্জ','kishorganj.nilphamari.gov.bd',0,NULL,NULL),(427,56,'Nilphamari Sadar','নীলফামারী সদর','nilphamarisadar.nilphamari.gov.bd',0,NULL,NULL),(428,57,'Sadullapur','সাদুল্লাপুর','sadullapur.gaibandha.gov.bd',0,NULL,NULL),(429,57,'Gaibandha Sadar','গাইবান্ধা সদর','gaibandhasadar.gaibandha.gov.bd',0,NULL,NULL),(430,57,'Palashbari','পলাশবাড়ী','palashbari.gaibandha.gov.bd',0,NULL,NULL),(431,57,'Saghata','সাঘাটা','saghata.gaibandha.gov.bd',0,NULL,NULL),(432,57,'Gobindaganj','গোবিন্দগঞ্জ','gobindaganj.gaibandha.gov.bd',0,NULL,NULL),(433,57,'Sundarganj','সুন্দরগঞ্জ','sundarganj.gaibandha.gov.bd',0,NULL,NULL),(434,57,'Phulchari','ফুলছড়ি','phulchari.gaibandha.gov.bd',0,NULL,NULL),(435,58,'Thakurgaon Sadar','ঠাকুরগাঁও সদর','thakurgaonsadar.thakurgaon.gov.bd',0,NULL,NULL),(436,58,'Pirganj','পীরগঞ্জ','pirganj.thakurgaon.gov.bd',0,NULL,NULL),(437,58,'Ranisankail','রাণীশংকৈল','ranisankail.thakurgaon.gov.bd',0,NULL,NULL),(438,58,'Haripur','হরিপুর','haripur.thakurgaon.gov.bd',0,NULL,NULL),(439,58,'Baliadangi','বালিয়াডাঙ্গী','baliadangi.thakurgaon.gov.bd',0,NULL,NULL),(440,59,'Rangpur Sadar','রংপুর সদর','rangpursadar.rangpur.gov.bd',0,NULL,NULL),(441,59,'Gangachara','গংগাচড়া','gangachara.rangpur.gov.bd',0,NULL,NULL),(442,59,'Taragonj','তারাগঞ্জ','taragonj.rangpur.gov.bd',0,NULL,NULL),(443,59,'Badargonj','বদরগঞ্জ','badargonj.rangpur.gov.bd',0,NULL,NULL),(444,59,'Mithapukur','মিঠাপুকুর','mithapukur.rangpur.gov.bd',0,NULL,NULL),(445,59,'Pirgonj','পীরগঞ্জ','pirgonj.rangpur.gov.bd',0,NULL,NULL),(446,59,'Kaunia','কাউনিয়া','kaunia.rangpur.gov.bd',0,NULL,NULL),(447,59,'Pirgacha','পীরগাছা','pirgacha.rangpur.gov.bd',0,NULL,NULL),(448,60,'Kurigram Sadar','কুড়িগ্রাম সদর','kurigramsadar.kurigram.gov.bd',0,NULL,NULL),(449,60,'Nageshwari','নাগেশ্বরী','nageshwari.kurigram.gov.bd',0,NULL,NULL),(450,60,'Bhurungamari','ভুরুঙ্গামারী','bhurungamari.kurigram.gov.bd',0,NULL,NULL),(451,60,'Phulbari','ফুলবাড়ী','phulbari.kurigram.gov.bd',0,NULL,NULL),(452,60,'Rajarhat','রাজারহাট','rajarhat.kurigram.gov.bd',0,NULL,NULL),(453,60,'Ulipur','উলিপুর','ulipur.kurigram.gov.bd',0,NULL,NULL),(454,60,'Chilmari','চিলমারী','chilmari.kurigram.gov.bd',0,NULL,NULL),(455,60,'Rowmari','রৌমারী','rowmari.kurigram.gov.bd',0,NULL,NULL),(456,60,'Charrajibpur','চর রাজিবপুর','charrajibpur.kurigram.gov.bd',0,NULL,NULL),(457,61,'Sherpur Sadar','শেরপুর সদর','sherpursadar.sherpur.gov.bd',0,NULL,NULL),(458,61,'Nalitabari','নালিতাবাড়ী','nalitabari.sherpur.gov.bd',0,NULL,NULL),(459,61,'Sreebordi','শ্রীবরদী','sreebordi.sherpur.gov.bd',0,NULL,NULL),(460,61,'Nokla','নকলা','nokla.sherpur.gov.bd',0,NULL,NULL),(461,61,'Jhenaigati','ঝিনাইগাতী','jhenaigati.sherpur.gov.bd',0,NULL,NULL),(462,62,'Fulbaria','ফুলবাড়ীয়া','fulbaria.mymensingh.gov.bd',0,NULL,NULL),(463,62,'Trishal','ত্রিশাল','trishal.mymensingh.gov.bd',0,NULL,NULL),(464,62,'Bhaluka','ভালুকা','bhaluka.mymensingh.gov.bd',0,NULL,NULL),(465,62,'Muktagacha','মুক্তাগাছা','muktagacha.mymensingh.gov.bd',0,NULL,NULL),(466,62,'Mymensingh Sadar','ময়মনসিংহ সদর','mymensinghsadar.mymensingh.gov.bd',0,NULL,NULL),(467,62,'Dhobaura','ধোবাউড়া','dhobaura.mymensingh.gov.bd',0,NULL,NULL),(468,62,'Phulpur','ফুলপুর','phulpur.mymensingh.gov.bd',0,NULL,NULL),(469,62,'Haluaghat','হালুয়াঘাট','haluaghat.mymensingh.gov.bd',0,NULL,NULL),(470,62,'Gouripur','গৌরীপুর','gouripur.mymensingh.gov.bd',0,NULL,NULL),(471,62,'Gafargaon','গফরগাঁও','gafargaon.mymensingh.gov.bd',0,NULL,NULL),(472,62,'Iswarganj','ঈশ্বরগঞ্জ','iswarganj.mymensingh.gov.bd',0,NULL,NULL),(473,62,'Nandail','নান্দাইল','nandail.mymensingh.gov.bd',0,NULL,NULL),(474,62,'Tarakanda','তারাকান্দা','tarakanda.mymensingh.gov.bd',0,NULL,NULL),(475,63,'Jamalpur Sadar','জামালপুর সদর','jamalpursadar.jamalpur.gov.bd',0,NULL,NULL),(476,63,'Melandah','মেলান্দহ','melandah.jamalpur.gov.bd',0,NULL,NULL),(477,63,'Islampur','ইসলামপুর','islampur.jamalpur.gov.bd',0,NULL,NULL),(478,63,'Dewangonj','দেওয়ানগঞ্জ','dewangonj.jamalpur.gov.bd',0,NULL,NULL),(479,63,'Sarishabari','সরিষাবাড়ী','sarishabari.jamalpur.gov.bd',0,NULL,NULL),(480,63,'Madarganj','মাদারগঞ্জ','madarganj.jamalpur.gov.bd',0,NULL,NULL),(481,63,'Bokshiganj','বকশীগঞ্জ','bokshiganj.jamalpur.gov.bd',0,NULL,NULL),(482,64,'Barhatta','বারহাট্টা','barhatta.netrokona.gov.bd',0,NULL,NULL),(483,64,'Durgapur','দুর্গাপুর','durgapur.netrokona.gov.bd',0,NULL,NULL),(484,64,'Kendua','কেন্দুয়া','kendua.netrokona.gov.bd',0,NULL,NULL),(485,64,'Atpara','আটপাড়া','atpara.netrokona.gov.bd',0,NULL,NULL),(486,64,'Madan','মদন','madan.netrokona.gov.bd',0,NULL,NULL),(487,64,'Khaliajuri','খালিয়াজুরী','khaliajuri.netrokona.gov.bd',0,NULL,NULL),(488,64,'Kalmakanda','কলমাকান্দা','kalmakanda.netrokona.gov.bd',0,NULL,NULL),(489,64,'Mohongonj','মোহনগঞ্জ','mohongonj.netrokona.gov.bd',0,NULL,NULL),(490,64,'Purbadhala','পূর্বধলা','purbadhala.netrokona.gov.bd',0,NULL,'2021-09-22 01:10:15'),(491,64,'Netrokona Sadar','নেত্রকোণা সদর','netrokonasadar.netrokona.gov.bd',1,NULL,'2021-09-15 02:05:04');
/*!40000 ALTER TABLE `thanas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci,
  `system_id` int NOT NULL DEFAULT '0',
  `entity_id` int NOT NULL DEFAULT '0',
  `role_id` bigint unsigned DEFAULT NULL,
  `designation_id` int DEFAULT NULL,
  `division_id` int NOT NULL DEFAULT '0',
  `district_id` int NOT NULL DEFAULT '0',
  `thana_id` int NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_mobile_unique` (`mobile`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Sokina','01983667657','01983667657','shamim@gail.com',NULL,0,0,1,0,0,0,0,NULL,'$2y$10$B84QQxerSXh.kxtPw3sWoOntfFs6d7P5ddbDEXQhFBJm4IjmFVYYO',NULL,NULL,NULL),(2,'Md.Shamim Haque','01942077206','01942077206','sdd@gmail.com',NULL,1,0,2,NULL,1,1,1,NULL,'$2y$10$ad1r4YUWTlt1xol2tPriAeL0IEf6M.cmWVyfceXFBNASEKS840Bwa',NULL,'2021-12-28 07:09:25','2021-12-28 07:09:25');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-12-29 11:53:27
