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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_menus`
--

LOCK TABLES `action_menus` WRITE;
/*!40000 ALTER TABLE `action_menus` DISABLE KEYS */;
INSERT INTO `action_menus` VALUES (1,'Edit','এডিট',7,0,'in_page','fa fa-pencil','/role/update',0,1,NULL,NULL),(2,'Edit','এডিট',8,0,'in_page','fa fa-pencil','/user/access/edit',0,3,NULL,NULL),(3,'Delete','ডিলিট',8,0,'in_page','fa fa-trash','/user/access/delete',0,4,NULL,NULL),(4,'Add New','নতুন যোগ করুন',8,0,'in_page','fa fa-plus','/user/access/add',0,2,NULL,NULL),(5,'Add New','নতুন যোগ করুন',7,0,'in_page','fa fa-plus','/role/add',0,1,NULL,NULL),(6,'Collect','সংগ্রহ',3,0,'in_page','fa fa-plus','/management/milk-collection/collect',0,1,NULL,NULL),(7,'List','তালিকা',3,0,'in_page','fa fa-list','/management/milk-collection/list',0,2,NULL,NULL),(8,'Add New','নতুন যোগ করুন',1,0,'in_page','fa fa-plus','/association/add',0,1,NULL,NULL),(9,'association-edit','association-edit',8,0,'in_page','fa fa-pencil','/association/edit',0,1,NULL,NULL),(10,'Member-Update','Member-Update',8,0,'in_page','fa fa-plus','/association/member',0,1,NULL,NULL),(11,'Add chilling Plant','Add chilling Plant',12,0,'in_page','fa fa-plus','/chilling-plant/add',0,1,NULL,NULL),(12,'Edit Chilling Plant','Edit Chilling Plant',12,0,'in_page','fa fa-plus','/chilling-plant/edit',0,1,NULL,NULL),(13,'Role Edit','রোল সম্পাদনা করুন',7,0,'in_page','fa fa-pencil','/role/edit',0,5,NULL,NULL),(14,'Association Edit','এসোসিয়েশন এডিট',1,0,'in_page','fa fa-pencil','/association/edit',0,5,NULL,NULL),(15,'Association Primary Data View','অ্যাসোসিয়েশন প্রাথমিক ডেটা ভিউ',1,0,'in_page','fa fa-eye','/association/primary-data-view',0,5,NULL,NULL),(16,'Add New Member','নতুন সদস্য তৈরি',1,0,'in_page','fa fa-plus','/association/add-member',0,5,NULL,NULL),(17,'Association Application Form','সমিতির আবেদনপত্র',4,0,'in_page','fa fa-file-o','/association/application/form',0,4,NULL,NULL),(18,'Application List','আবেদনকৃত সমিতির তালিকা',4,0,'in_page','fa fa-list','/association/application/list',0,6,NULL,NULL),(19,'Details','ডিটেলস',13,0,'in_page','fa fa-eye','/association/applied/details',0,0,NULL,NULL),(20,'Add','নতুন যোগ করুন',15,0,'in_page','fa fa-push','/designation/add',0,0,NULL,NULL),(30,'Add New','নতুন যোগ করুন',21,0,'in_page','fa fa-pencil','/milk-category/add',0,5,NULL,NULL),(31,'Delete','ডিলিট',21,0,'in_page','fa fa-trash','/milk-category/delete',0,5,NULL,NULL),(32,'Edit','এডিট',21,0,'in_page','fa fa-trash','/milk-category/edit',0,5,NULL,NULL),(33,'Add New','নতুন যোগ করুন',22,0,'in_page','fa fa-pencil','/processing-plant/add',0,5,NULL,NULL),(34,'Delete','ডিলিট',22,0,'in_page','fa fa-trash','/processing-plant/delete',0,5,NULL,NULL),(35,'Edit','এডিট',22,0,'in_page','fa fa-trash','/association/add-member',0,5,NULL,NULL),(36,'Add New','নতুন যোগ করুন',23,0,'in_page','fa fa-pencil','/vehicle/category/add',0,5,NULL,NULL),(37,'Delete','ডিলিট',23,0,'in_page','fa fa-trash','/vehicle/category/delete',0,5,NULL,NULL),(38,'Edit','এডিট',23,0,'in_page','fa fa-trash','/vehicle/category/edit',0,5,NULL,NULL),(39,'Add New','নতুন যোগ করুন',24,0,'in_page','fa fa-pencil','/vehicle/add',0,5,NULL,NULL),(40,'Delete','ডিলিট',24,0,'in_page','fa fa-trash','/vehicle/delete',0,5,NULL,NULL),(41,'Edit','এডিট',24,0,'in_page','fa fa-trash','/vehicle/edit',0,5,NULL,NULL),(42,'Add New','নতুন যোগ করুন',25,0,'in_page','fa fa-pencil','/association/milk-collection/add',0,5,NULL,NULL),(43,'Delete','ডিলিট',25,0,'in_page','fa fa-trash','/association/milk-collection/delete',0,5,NULL,NULL),(44,'Edit','এডিট',25,0,'in_page','fa fa-trash','/association/milk-collection/edit',0,5,NULL,NULL);
/*!40000 ALTER TABLE `action_menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `association_commitee_members`
--

DROP TABLE IF EXISTS `association_commitee_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `association_commitee_members` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `association_id` bigint unsigned DEFAULT NULL,
  `member_id` bigint unsigned DEFAULT NULL,
  `designation_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `association_commitee_members_association_id_foreign` (`association_id`),
  KEY `association_commitee_members_member_id_foreign` (`member_id`),
  KEY `association_commitee_members_designation_id_foreign` (`designation_id`),
  CONSTRAINT `association_commitee_members_association_id_foreign` FOREIGN KEY (`association_id`) REFERENCES `associations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `association_commitee_members_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `association_commitee_members_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `association_members` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `association_commitee_members`
--

LOCK TABLES `association_commitee_members` WRITE;
/*!40000 ALTER TABLE `association_commitee_members` DISABLE KEYS */;
INSERT INTO `association_commitee_members` VALUES (1,1,1,1,'2022-01-20 05:52:59','2022-01-20 05:52:59');
/*!40000 ALTER TABLE `association_commitee_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `association_control_flows`
--

DROP TABLE IF EXISTS `association_control_flows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `association_control_flows` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `association_id` bigint unsigned NOT NULL,
  `chilling_plant_id` bigint unsigned DEFAULT NULL,
  `field_officer_id` bigint unsigned DEFAULT NULL,
  `chilling_plant_manager_id` tinyint NOT NULL DEFAULT '0',
  `milkvita_officer_id` tinyint NOT NULL DEFAULT '0',
  `upazila_cooperative_officer_id` tinyint NOT NULL DEFAULT '0',
  `is_milkvita_officer` tinyint NOT NULL DEFAULT '0',
  `is_approved_milkvita_officer` tinyint NOT NULL DEFAULT '0',
  `is_reject_milkvita_officer` tinyint NOT NULL DEFAULT '0',
  `is_upazila_cooperative_officer` tinyint NOT NULL DEFAULT '0',
  `is_approved_cooperative_officer` tinyint NOT NULL DEFAULT '0',
  `is_reject_cooperative_officer` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `association_control_flows_association_id_unique` (`association_id`),
  KEY `association_control_flows_field_officer_id_foreign` (`field_officer_id`),
  CONSTRAINT `association_control_flows_association_id_foreign` FOREIGN KEY (`association_id`) REFERENCES `associations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `association_control_flows_field_officer_id_foreign` FOREIGN KEY (`field_officer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `association_control_flows`
--

LOCK TABLES `association_control_flows` WRITE;
/*!40000 ALTER TABLE `association_control_flows` DISABLE KEYS */;
INSERT INTO `association_control_flows` VALUES (1,1,1,5,3,4,0,1,1,0,0,0,0,'2022-01-20 05:52:59','2022-01-20 05:53:51');
/*!40000 ALTER TABLE `association_control_flows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `association_histories`
--

DROP TABLE IF EXISTS `association_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `association_histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `association_id` bigint unsigned DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `association_histories_user_id_foreign` (`user_id`),
  KEY `association_histories_association_id_foreign` (`association_id`),
  CONSTRAINT `association_histories_association_id_foreign` FOREIGN KEY (`association_id`) REFERENCES `associations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `association_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `association_histories`
--

LOCK TABLES `association_histories` WRITE;
/*!40000 ALTER TABLE `association_histories` DISABLE KEYS */;
INSERT INTO `association_histories` VALUES (1,'New Association',5,1,NULL,'2022-01-20','2022-01-20 05:45:37','2022-01-20 05:45:37'),(2,'Has been applied',5,1,'The field officer applied to the chilling plant officer','2022-01-20','2022-01-20 05:52:59','2022-01-20 05:52:59'),(3,'Sent to Plant Officer',3,1,'The plant manager sent the application to the plant officer','2022-01-20','2022-01-20 05:53:23','2022-01-20 05:53:23'),(4,'Approved by plant officer',4,1,'','2022-01-20','2022-01-20 05:53:51','2022-01-20 05:53:51');
/*!40000 ALTER TABLE `association_histories` ENABLE KEYS */;
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
  `association_id` bigint unsigned DEFAULT NULL,
  `member_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int NOT NULL,
  `member_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fathers_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `village` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount_of_milk_produced` int NOT NULL DEFAULT '0',
  `where_sales_are` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_gavi` int NOT NULL DEFAULT '0',
  `total_bokna` int NOT NULL DEFAULT '0',
  `total_bokon_bachor` int NOT NULL DEFAULT '0',
  `total_are_bachor` int NOT NULL DEFAULT '0',
  `total_shar` int NOT NULL DEFAULT '0',
  `total_bolod` int NOT NULL DEFAULT '0',
  `total_mohish` int NOT NULL DEFAULT '0',
  `remark` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `association_members_association_id_foreign` (`association_id`),
  CONSTRAINT `association_members_association_id_foreign` FOREIGN KEY (`association_id`) REFERENCES `associations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `association_members`
--

LOCK TABLES `association_members` WRITE;
/*!40000 ALTER TABLE `association_members` DISABLE KEYS */;
INSERT INTO `association_members` VALUES (1,5,1,'Member One',20,NULL,NULL,'sdkf',50,NULL,3,0,0,0,0,0,0,NULL,'2022-01-20 05:46:12','2022-01-20 05:46:12');
/*!40000 ALTER TABLE `association_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `association_road_types`
--

DROP TABLE IF EXISTS `association_road_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `association_road_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `association_id` bigint unsigned DEFAULT NULL,
  `road_type_id` bigint unsigned DEFAULT NULL,
  `distance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'কিঃ মিঃ',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `association_road_types_association_id_foreign` (`association_id`),
  KEY `association_road_types_road_type_id_foreign` (`road_type_id`),
  CONSTRAINT `association_road_types_association_id_foreign` FOREIGN KEY (`association_id`) REFERENCES `associations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `association_road_types_road_type_id_foreign` FOREIGN KEY (`road_type_id`) REFERENCES `road_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `association_road_types`
--

LOCK TABLES `association_road_types` WRITE;
/*!40000 ALTER TABLE `association_road_types` DISABLE KEYS */;
INSERT INTO `association_road_types` VALUES (1,1,1,2.00,'কিঃ মিঃ','2022-01-20 05:52:59','2022-01-20 05:52:59'),(2,1,2,18.00,'কিঃ মিঃ','2022-01-20 05:52:59','2022-01-20 05:52:59');
/*!40000 ALTER TABLE `association_road_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `associations`
--

DROP TABLE IF EXISTS `associations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `associations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
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
  CONSTRAINT `associations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `associations`
--

LOCK TABLES `associations` WRITE;
/*!40000 ALTER TABLE `associations` DISABLE KEYS */;
INSERT INTO `associations` VALUES (1,5,1,1,1,'sdfsdf','Somity One','2355','Mirpur','Mirpur',1,1,2,'sfsdf',20,'20','20',90.41478560,23.81519950,0,0,'2022-01-20 05:45:37','2022-01-20 05:52:59');
/*!40000 ALTER TABLE `associations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chilling_plants`
--

DROP TABLE IF EXISTS `chilling_plants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chilling_plants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `chilling_plant_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `system_id` bigint unsigned NOT NULL DEFAULT '0',
  `entity_id` bigint unsigned DEFAULT NULL,
  `division_id` bigint unsigned DEFAULT NULL,
  `district_id` bigint unsigned DEFAULT NULL,
  `thana_id` bigint unsigned DEFAULT NULL,
  `longitude` int DEFAULT NULL,
  `latitude` int DEFAULT NULL,
  `full_address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chilling_plants_division_id_foreign` (`division_id`),
  KEY `chilling_plants_district_id_foreign` (`district_id`),
  KEY `chilling_plants_thana_id_foreign` (`thana_id`),
  KEY `chilling_plants_entity_id_foreign` (`entity_id`),
  CONSTRAINT `chilling_plants_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chilling_plants_division_id_foreign` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chilling_plants_entity_id_foreign` FOREIGN KEY (`entity_id`) REFERENCES `entities` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chilling_plants_thana_id_foreign` FOREIGN KEY (`thana_id`) REFERENCES `thanas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chilling_plants`
--

LOCK TABLES `chilling_plants` WRITE;
/*!40000 ALTER TABLE `chilling_plants` DISABLE KEYS */;
INSERT INTO `chilling_plants` VALUES (1,'Chilling Plant One',0,2,1,1,1,NULL,NULL,'DDD','2022-01-20 05:33:36','2022-01-20 05:33:36');
/*!40000 ALTER TABLE `chilling_plants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designations`
--

DROP TABLE IF EXISTS `designations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `designations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `designation_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_id` bigint unsigned DEFAULT NULL,
  `entity_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `designations_entity_id_foreign` (`entity_id`),
  CONSTRAINT `designations_entity_id_foreign` FOREIGN KEY (`entity_id`) REFERENCES `entities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designations`
--

LOCK TABLES `designations` WRITE;
/*!40000 ALTER TABLE `designations` DISABLE KEYS */;
INSERT INTO `designations` VALUES (1,'চেয়ারম্যান',0,3,'2022-01-20 05:52:06','2022-01-20 05:52:06');
/*!40000 ALTER TABLE `designations` ENABLE KEYS */;
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
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` text COLLATE utf8mb4_unicode_ci,
  `lon` text COLLATE utf8mb4_unicode_ci,
  `url` text COLLATE utf8mb4_unicode_ci,
  `trash` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `districts`
--

LOCK TABLES `districts` WRITE;
/*!40000 ALTER TABLE `districts` DISABLE KEYS */;
INSERT INTO `districts` VALUES (1,1,'Comilla','কুমিল্লা','23.4682747','91.1788135','www.comilla.gov.bd',0,NULL,NULL),(2,1,'Feni','ফেনী','23.023231','91.3840844','www.feni.gov.bd',0,NULL,NULL),(3,1,'Brahmanbaria','ব্রাহ্মণবাড়িয়া','23.9570904','91.1119286','www.brahmanbaria.gov.bd',0,NULL,NULL),(4,1,'Rangamati','রাঙ্গামাটি',NULL,NULL,'www.rangamati.gov.bd',0,NULL,NULL),(5,1,'Noakhali','নোয়াখালী','22.869563','91.099398','www.noakhali.gov.bd',0,NULL,NULL),(6,1,'Chandpur','চাঁদপুর','23.2332585','90.6712912','www.chandpur.gov.bd',0,NULL,NULL),(7,1,'Lakshmipur','লক্ষ্মীপুর','22.942477','90.841184','www.lakshmipur.gov.bd',0,NULL,NULL),(8,1,'Chattogram','চট্টগ্রাম','22.335109','91.834073','www.chittagong.gov.bd',0,NULL,NULL),(9,1,'Coxsbazar','কক্সবাজার',NULL,NULL,'www.coxsbazar.gov.bd',0,NULL,NULL),(10,1,'Khagrachhari','খাগড়াছড়ি','23.119285','91.984663','www.khagrachhari.gov.bd',0,NULL,NULL),(11,1,'Bandarban','বান্দরবান','22.1953275','92.2183773','www.bandarban.gov.bd',0,NULL,NULL),(12,2,'Sirajganj','সিরাজগঞ্জ','24.4533978','89.7006815','www.sirajganj.gov.bd',0,NULL,NULL),(13,2,'Pabna','পাবনা','23.998524','89.233645','www.pabna.gov.bd',0,NULL,NULL),(14,2,'Bogura','বগুড়া','24.8465228','89.377755','www.bogra.gov.bd',0,NULL,NULL),(15,2,'Rajshahi','রাজশাহী',NULL,NULL,'www.rajshahi.gov.bd',0,NULL,NULL),(16,2,'Natore','নাটোর','24.420556','89.000282','www.natore.gov.bd',0,NULL,NULL),(17,2,'Joypurhat','জয়পুরহাট',NULL,NULL,'www.joypurhat.gov.bd',0,NULL,NULL),(18,2,'Chapainawabganj','চাঁপাইনবাবগঞ্জ','24.5965034','88.2775122','www.chapainawabganj.gov.bd',0,NULL,NULL),(19,2,'Naogaon','নওগাঁ',NULL,NULL,'www.naogaon.gov.bd',0,NULL,NULL),(20,3,'Jashore','যশোর','23.16643','89.2081126','www.jessore.gov.bd',0,NULL,NULL),(21,3,'Satkhira','সাতক্ষীরা',NULL,NULL,'www.satkhira.gov.bd',0,NULL,NULL),(22,3,'Meherpur','মেহেরপুর','23.762213','88.631821','www.meherpur.gov.bd',0,NULL,NULL),(23,3,'Narail','নড়াইল','23.172534','89.512672','www.narail.gov.bd',0,NULL,NULL),(24,3,'Chuadanga','চুয়াডাঙ্গা','23.6401961','88.841841','www.chuadanga.gov.bd',0,NULL,NULL),(25,3,'Kushtia','কুষ্টিয়া','23.901258','89.120482','www.kushtia.gov.bd',0,NULL,NULL),(26,3,'Magura','মাগুরা','23.487337','89.419956','www.magura.gov.bd',0,NULL,NULL),(27,3,'Khulna','খুলনা','22.815774','89.568679','www.khulna.gov.bd',0,NULL,NULL),(28,3,'Bagerhat','বাগেরহাট','22.651568','89.785938','www.bagerhat.gov.bd',0,NULL,NULL),(29,3,'Jhenaidah','ঝিনাইদহ','23.5448176','89.1539213','www.jhenaidah.gov.bd',0,NULL,NULL),(30,4,'Jhalakathi','ঝালকাঠি',NULL,NULL,'www.jhalakathi.gov.bd',0,NULL,NULL),(31,4,'Patuakhali','পটুয়াখালী','22.3596316','90.3298712','www.patuakhali.gov.bd',0,NULL,NULL),(32,4,'Pirojpur','পিরোজপুর',NULL,NULL,'www.pirojpur.gov.bd',0,NULL,NULL),(33,4,'Barisal','বরিশাল',NULL,NULL,'www.barisal.gov.bd',0,NULL,NULL),(34,4,'Bhola','ভোলা','22.685923','90.648179','www.bhola.gov.bd',0,NULL,NULL),(35,4,'Barguna','বরগুনা',NULL,NULL,'www.barguna.gov.bd',0,NULL,NULL),(36,5,'Sylhet','সিলেট','24.8897956','91.8697894','www.sylhet.gov.bd',0,NULL,NULL),(37,5,'Moulvibazar','মৌলভীবাজার','24.482934','91.777417','www.moulvibazar.gov.bd',0,NULL,NULL),(38,5,'Habiganj','হবিগঞ্জ','24.374945','91.41553','www.habiganj.gov.bd',0,NULL,NULL),(39,5,'Sunamganj','সুনামগঞ্জ','25.0658042','91.3950115','www.sunamganj.gov.bd',0,NULL,NULL),(40,6,'Narsingdi','নরসিংদী','23.932233','90.71541','www.narsingdi.gov.bd',0,NULL,NULL),(41,6,'Gazipur','গাজীপুর','24.0022858','90.4264283','www.gazipur.gov.bd',0,NULL,NULL),(42,6,'Shariatpur','শরীয়তপুর',NULL,NULL,'www.shariatpur.gov.bd',0,NULL,NULL),(43,6,'Narayanganj','নারায়ণগঞ্জ','23.63366','90.496482','www.narayanganj.gov.bd',0,NULL,NULL),(44,6,'Tangail','টাঙ্গাইল',NULL,NULL,'www.tangail.gov.bd',0,NULL,NULL),(45,6,'Kishoreganj','কিশোরগঞ্জ','24.444937','90.776575','www.kishoreganj.gov.bd',0,NULL,NULL),(46,6,'Manikganj','মানিকগঞ্জ',NULL,NULL,'www.manikganj.gov.bd',0,NULL,NULL),(47,6,'Dhaka','ঢাকা','23.7115253','90.4111451','www.dhaka.gov.bd',0,NULL,NULL),(48,6,'Munshiganj','মুন্সিগঞ্জ',NULL,NULL,'www.munshiganj.gov.bd',0,NULL,NULL),(49,6,'Rajbari','রাজবাড়ী','23.7574305','89.6444665','www.rajbari.gov.bd',0,NULL,NULL),(50,6,'Madaripur','মাদারীপুর','23.164102','90.1896805','www.madaripur.gov.bd',0,NULL,NULL),(51,6,'Gopalganj','গোপালগঞ্জ','23.0050857','89.8266059','www.gopalganj.gov.bd',0,NULL,NULL),(52,6,'Faridpur','ফরিদপুর','23.6070822','89.8429406','www.faridpur.gov.bd',0,NULL,NULL),(53,7,'Panchagarh','পঞ্চগড়','26.3411','88.5541606','www.panchagarh.gov.bd',0,NULL,NULL),(54,7,'Dinajpur','দিনাজপুর','25.6217061','88.6354504','www.dinajpur.gov.bd',0,NULL,NULL),(55,7,'Lalmonirhat','লালমনিরহাট',NULL,NULL,'www.lalmonirhat.gov.bd',0,NULL,NULL),(56,7,'Nilphamari','নীলফামারী','25.931794','88.856006','www.nilphamari.gov.bd',0,NULL,NULL),(57,7,'Gaibandha','গাইবান্ধা','25.328751','89.528088','www.gaibandha.gov.bd',0,NULL,NULL),(58,7,'Thakurgaon','ঠাকুরগাঁও','26.0336945','88.4616834','www.thakurgaon.gov.bd',0,NULL,NULL),(59,7,'Rangpur','রংপুর','25.7558096','89.244462','www.rangpur.gov.bd',0,NULL,NULL),(60,7,'Kurigram','কুড়িগ্রাম','25.805445','89.636174','www.kurigram.gov.bd',0,NULL,NULL),(61,8,'Sherpur','শেরপুর','25.0204933','90.0152966','www.sherpur.gov.bd',0,NULL,NULL),(62,8,'Mymensingh','ময়মনসিংহ','24.7465670','90.4072093','www.mymensingh.gov.bd',0,NULL,NULL),(63,8,'Jamalpur','জামালপুর','24.937533','89.937775','www.jamalpur.gov.bd',0,NULL,NULL),(64,8,'Netrokona','নেত্রকোণা','24.870955','90.727887','www.netrokona.gov.bd',0,NULL,'2021-09-21 19:10:35');
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
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trash` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `divisions`
--

LOCK TABLES `divisions` WRITE;
/*!40000 ALTER TABLE `divisions` DISABLE KEYS */;
INSERT INTO `divisions` VALUES (1,'Chattagram','চট্টগ্রাম','www.chittagongdiv.gov.bd',0,NULL,'2021-09-14 10:42:50'),(2,'Rajshahi','রাজশাহী','www.rajshahidiv.gov.bd',0,NULL,NULL),(3,'Khulna','খুলনা','www.khulnadiv.gov.bd',0,NULL,NULL),(4,'Barisal','বরিশাল','www.barisaldiv.gov.bd',0,NULL,NULL),(5,'Sylhet','সিলেট','www.sylhetdiv.gov.bd',0,NULL,NULL),(6,'Dhaka','ঢাকা','www.dhakadiv.gov.bd',0,NULL,NULL),(7,'Rangpur','রংপুর','www.rangpurdiv.gov.bd',0,NULL,NULL),(8,'Mymensingh','ময়মনসিংহ','www.mymensinghdiv.gov.bd',0,NULL,'2021-09-21 19:10:51');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entities`
--

LOCK TABLES `entities` WRITE;
/*!40000 ALTER TABLE `entities` DISABLE KEYS */;
INSERT INTO `entities` VALUES (1,0,0,'Processing Plant','2022-01-20 05:27:37','2022-01-20 05:27:58'),(2,0,0,'Chilling Plant','2022-01-20 05:27:37','2022-01-20 05:27:37'),(3,0,2,'Association','2022-01-20 05:28:36','2022-01-20 05:28:36');
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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,'Association primary survey','সমিতি প্রাথমিক জরিপ','/association/all','http://server.ecom.decode-lab.com/public/images/pencil.svg',0,8,NULL,NULL),(2,'Profile','প্রোফাইল','/admin/profile','http://server.ecom.decode-lab.com/public/images/Vector.svg',0,1,NULL,NULL),(3,'Milk collection management','দুগ্ধ সংগ্রহ ব্যবস্থাপনা ','/management/milk-collection','http://server.ecom.decode-lab.com/public/images/dudh.svg',1,7,NULL,NULL),(4,'Association registration','সমিতির নিবন্ধন','/association/application/index','http://server.ecom.decode-lab.com/public/images/pencil.svg',0,9,NULL,NULL),(6,'System','সিস্টেম','/user/system','http://server.ecom.decode-lab.com/public/images/service.svg',0,2,NULL,NULL),(7,'User Role','ইউজার রোল','/role/all','http://server.ecom.decode-lab.com/public/images/user_role.svg',0,4,NULL,NULL),(8,'User','ইউজার','/user/access/all','http://server.ecom.decode-lab.com/public/images/sodossho.svg',0,5,NULL,NULL),(9,'Road Type','রাস্তার ধরন','/road-type','http://server.ecom.decode-lab.com/public/images/road.svg',0,9,NULL,NULL),(10,'Permission','পারমিশন','/user/privilege','http://server.ecom.decode-lab.com/public/images/security.svg',0,5,NULL,NULL),(11,'Entity','এনটিটি','/user/entity','http://server.ecom.decode-lab.com/public/images/sodossho.svg',0,3,NULL,NULL),(12,'Chilling Plant','চিলিং প্ল্যান্ট','/chilling-plant/all','http://server.ecom.decode-lab.com/public/images/sodossho.svg',0,2,NULL,NULL),(13,'Applied Association List','আবেদনকৃত সমিতির তালিকা','/association/applied/all','http://server.ecom.decode-lab.com/public/images/pencil.svg',0,5,NULL,NULL),(14,'Forwarded Application','ফরওয়ার্ড করা আবেদনসমূহ','/association/plant-application/list','http://server.ecom.decode-lab.com/public/images/sodossho.svg',0,5,NULL,NULL),(15,'Designation','উপাধি','/designation/list','http://server.ecom.decode-lab.com/public/images/sodossho.svg',0,0,NULL,NULL),(21,'Milk Category','মিল্ক ক্যাটাগরি','/milk-category/all','http://server.ecom.decode-lab.com/public/images/sodossho.svg',0,21,NULL,NULL),(22,'Processing Plant','প্রসেসিং প্লান্ট','/processing-plant/all','http://server.ecom.decode-lab.com/public/images/sodossho.svg',0,21,NULL,NULL),(23,'Vehicle Category','যানবাহনের ধরণ','/vehicle/category','http://server.ecom.decode-lab.com/public/images/sodossho.svg',0,23,NULL,NULL),(24,'Vehicle','যানবাহন','/vehicle/all','http://server.ecom.decode-lab.com/public/images/sodossho.svg',0,24,NULL,NULL),(25,'Milk Collection in Association','সমিতির দুধ সংগ্রহ','/association/milk-collection/all','http://server.ecom.decode-lab.com/public/images/sodossho.svg',0,25,NULL,NULL);
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
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (110,'2014_10_12_100000_create_password_resets_table',1),(111,'2016_06_01_000001_create_oauth_auth_codes_table',1),(112,'2016_06_01_000002_create_oauth_access_tokens_table',1),(113,'2016_06_01_000003_create_oauth_refresh_tokens_table',1),(114,'2016_06_01_000004_create_oauth_clients_table',1),(115,'2016_06_01_000005_create_oauth_personal_access_clients_table',1),(116,'2019_08_19_000000_create_failed_jobs_table',1),(117,'2019_12_14_000001_create_personal_access_tokens_table',1),(118,'2021_09_14_000444_create_districts_table',1),(119,'2021_09_14_005758_create_divisions_table',1),(120,'2021_09_14_195649_create_thanas_table',1),(121,'2021_11_22_065415_create_roles_table',1),(122,'2021_11_22_065416_create_users_table',1),(123,'2021_11_22_070535_create_menus_table',1),(124,'2021_11_22_070558_create_sub_menus_table',1),(125,'2021_11_22_070609_create_action_menus_table',1),(126,'2021_12_01_103652_create_road_types_table',1),(127,'2021_12_05_075818_create_survey_reports_table',1),(128,'2021_12_13_062452_create_role_wise_menus_table',1),(129,'2021_12_26_101743_create_entities_table',1),(130,'2021_12_27_080715_create_systems_table',1),(131,'2021_12_29_052535_create_associations_table',1),(132,'2021_12_29_052537_create_association_members_table',1),(133,'2022_01_03_095304_create_milk_categories_table',1),(134,'2022_01_05_070722_create_processing_plants_table',1),(135,'2022_01_05_113657_create_chilling_plants_table',1),(136,'2022_01_11_045718_create_vehicle_categories_table',1),(137,'2022_01_11_045942_create_vehicles_table',1),(138,'2022_01_12_095552_create_association_road_types_table',1),(139,'2022_01_12_102332_create_association_control_flows_table',1),(140,'2022_01_16_093455_create_milk_collection_in_associations_table',1),(141,'2022_01_18_082315_create_association_histories_table',1),(142,'2022_01_19_045801_create_designations_table',1),(143,'2022_01_19_081842_create_association_commitee_members_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `milk_categories`
--

DROP TABLE IF EXISTS `milk_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `milk_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `milk_category_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `milk_categories_milk_category_name_unique` (`milk_category_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `milk_categories`
--

LOCK TABLES `milk_categories` WRITE;
/*!40000 ALTER TABLE `milk_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `milk_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `milk_collection_in_associations`
--

DROP TABLE IF EXISTS `milk_collection_in_associations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `milk_collection_in_associations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `association_id` bigint unsigned NOT NULL,
  `member_id` bigint unsigned NOT NULL,
  `amount_of_milk` decimal(10,2) NOT NULL,
  `temperature` tinyint NOT NULL,
  `lactometer_readings` tinyint NOT NULL,
  `noni` decimal(10,1) NOT NULL,
  `snf` decimal(10,1) NOT NULL,
  `full_can` int NOT NULL DEFAULT '0',
  `half_can` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `milk_collection_in_associations_association_id_foreign` (`association_id`),
  KEY `milk_collection_in_associations_member_id_foreign` (`member_id`),
  CONSTRAINT `milk_collection_in_associations_association_id_foreign` FOREIGN KEY (`association_id`) REFERENCES `associations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `milk_collection_in_associations_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `association_members` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `milk_collection_in_associations`
--

LOCK TABLES `milk_collection_in_associations` WRITE;
/*!40000 ALTER TABLE `milk_collection_in_associations` DISABLE KEYS */;
/*!40000 ALTER TABLE `milk_collection_in_associations` ENABLE KEYS */;
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
INSERT INTO `oauth_access_tokens` VALUES ('0008c6ee6e03ef8a8c670f668f960ee6817aa8af3a4ee1338170adb7cb30bd94561540795e2ce0eb',2,1,'milk-vita','[]',0,'2022-01-20 04:07:07','2022-01-20 04:07:07','2023-01-20 10:07:07'),('0d5538dfe2fa379101e7f862566644c027145f9a577fdc75246912fa3e147c35a6e5037b47214098',5,1,'milk-vita','[]',1,'2022-01-20 05:52:18','2022-01-20 05:52:18','2023-01-20 11:52:18'),('0d8552f243530c2d1f2d7ae73404a97959dc3b7cc7be08b0ca43a6e5e914dcd013bcb614e04233b2',2,1,'milk-vita','[]',1,'2022-01-20 04:34:53','2022-01-20 04:34:53','2023-01-20 10:34:53'),('0f5ffd0d22e80f691a20e75df87d7220dbb4b962611e4b6685f7fa4210047c5b1612f9e1542d537d',2,1,'milk-vita','[]',1,'2022-01-20 05:47:45','2022-01-20 05:47:45','2023-01-20 11:47:45'),('16f5f774d1377d5807f54a8253d610cb00f74b46a1061b26f5f32e249fce0de2d0c133cb0dcf3b26',2,1,'milk-vita','[]',0,'2022-01-20 03:09:00','2022-01-20 03:09:00','2023-01-20 09:09:00'),('234adca09694c6b13fc735759c868da57f604f987b20fbe74f42be923ad37be9a2caaac3c197cf6a',2,1,'milk-vita','[]',0,'2022-01-20 03:53:44','2022-01-20 03:53:44','2023-01-20 09:53:44'),('2973371598073881a954d2ad76ad79fb809d053d0bc2944b1eb94796dc2b5b4ebcdf1f5a6d2ad070',2,1,'milk-vita','[]',0,'2022-01-20 03:52:48','2022-01-20 03:52:48','2023-01-20 09:52:48'),('47b24ffeff006e0e71f38d318e2c26392a25e1664136c74391df35e03807b7a0836d7ea11a515916',3,1,'milk-vita','[]',1,'2022-01-20 05:53:18','2022-01-20 05:53:18','2023-01-20 11:53:18'),('50d1f46221b53618bffa73288f7209fec9168f51cf2ccfdf81ac65b1350e6f94c900e965f80af381',5,1,'milk-vita','[]',1,'2022-01-20 05:41:05','2022-01-20 05:41:05','2023-01-20 11:41:05'),('58f51870e1ede140bde9306553ab042e6e6d0a740f4f75c051dac9326001fb7c8aa42932c4697dd7',2,1,'milk-vita','[]',1,'2022-01-20 04:27:02','2022-01-20 04:27:02','2023-01-20 10:27:02'),('941066046b4f06e674598b4b08c8d25ba65a8b976ff16cf0f8235e84675a27d51a6b465599e5d2a5',2,1,'milk-vita','[]',1,'2022-01-20 04:09:04','2022-01-20 04:09:04','2023-01-20 10:09:04'),('953f71aaf2436d7a44e5c23dbe9530511dbdea7957002ef1fb94a29e5ff3d418f3ac8b8072c9ae46',4,1,'milk-vita','[]',0,'2022-01-20 05:53:43','2022-01-20 05:53:43','2023-01-20 11:53:43'),('9966178c6c212fd1fb4b092e4a4d2708275a079a0955daae8baec5214e38a011684b078651c47e85',2,1,'milk-vita','[]',0,'2022-01-20 04:03:57','2022-01-20 04:03:57','2023-01-20 10:03:57'),('99f84d033d4adcd466316b3178af14a82ea94d703e30931e0d4f8a351650d1387ac29133e5109784',2,1,'milk-vita','[]',0,'2022-01-20 04:07:54','2022-01-20 04:07:54','2023-01-20 10:07:54'),('a10cbdb279970ad729dfa305d4a41dcde558e1ae5f1a55c11440a528c2889e326472516b9166b04e',2,1,'milk-vita','[]',0,'2022-01-20 03:55:19','2022-01-20 03:55:19','2023-01-20 09:55:19'),('a361d58a675b709f0e989ef4e06707169e377c4c7191038709c56f464b8c1a3a49d22b0350a9e369',2,1,'milk-vita','[]',1,'2022-01-20 04:08:44','2022-01-20 04:08:44','2023-01-20 10:08:44'),('c70052444005470495e1bfb4d45045cdea2618699910ab7d88a1da88d4b6fe2350212cd08747aaaf',2,1,'milk-vita','[]',1,'2022-01-20 04:08:17','2022-01-20 04:08:17','2023-01-20 10:08:17'),('e88e644c936c4a93ef5bf59c4ceabb917e8b5f43dc185cf3ec53b766a87fbe8929e84b2e3f19c0a0',2,1,'milk-vita','[]',1,'2022-01-20 04:33:01','2022-01-20 04:33:01','2023-01-20 10:33:01'),('e8b1d8eca276a4c8685a545c3c07d37901e751ab574a78805e75a8a930899543d32e4787872af2c6',2,1,'milk-vita','[]',0,'2022-01-20 03:53:34','2022-01-20 03:53:34','2023-01-20 09:53:34'),('eed79d10a01f31246e4df8e852d6148fcaadf6b7b5a4d594b9e06a53d0f3e558525450455e7f66a9',2,1,'milk-vita','[]',0,'2022-01-20 03:54:27','2022-01-20 03:54:27','2023-01-20 09:54:27'),('f1ca9dd08cb684ab85c3c0db1fc362099bc0d762d9e9d2f4f891d54abfccc60ccb44242067a78267',2,1,'milk-vita','[]',1,'2022-01-20 04:15:40','2022-01-20 04:15:40','2023-01-20 10:15:40'),('f7e4afb9551c6113f9e2b0fef9059f76f8cb00e30268315485a3c8c4ab16a806d8456096f89f8d89',2,1,'milk-vita','[]',1,'2022-01-20 04:09:32','2022-01-20 04:09:32','2023-01-20 10:09:32');
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
INSERT INTO `oauth_clients` VALUES (1,NULL,'milk-vita','KpJVmj5cC9klRin1B7zMFINO4q3HGo8rI2j97tb0',NULL,'http://localhost',1,0,0,'2022-01-20 03:08:53','2022-01-20 03:08:53');
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
INSERT INTO `oauth_personal_access_clients` VALUES (1,1,'2022-01-20 03:08:53','2022-01-20 03:08:53');
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
-- Table structure for table `processing_plants`
--

DROP TABLE IF EXISTS `processing_plants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `processing_plants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `processing_plant_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_id` bigint unsigned NOT NULL DEFAULT '0',
  `entity_id` bigint unsigned NOT NULL DEFAULT '0',
  `division_id` bigint unsigned NOT NULL DEFAULT '0',
  `district_id` bigint unsigned NOT NULL DEFAULT '0',
  `thana_id` bigint unsigned NOT NULL DEFAULT '0',
  `longitude` double(10,8) DEFAULT NULL,
  `latitude` double(10,8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `processing_plants_entity_id_foreign` (`entity_id`),
  KEY `processing_plants_division_id_foreign` (`division_id`),
  KEY `processing_plants_district_id_foreign` (`district_id`),
  KEY `processing_plants_thana_id_foreign` (`thana_id`),
  CONSTRAINT `processing_plants_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `processing_plants_division_id_foreign` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `processing_plants_entity_id_foreign` FOREIGN KEY (`entity_id`) REFERENCES `entities` (`id`) ON DELETE CASCADE,
  CONSTRAINT `processing_plants_thana_id_foreign` FOREIGN KEY (`thana_id`) REFERENCES `thanas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `processing_plants`
--

LOCK TABLES `processing_plants` WRITE;
/*!40000 ALTER TABLE `processing_plants` DISABLE KEYS */;
/*!40000 ALTER TABLE `processing_plants` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `road_types`
--

LOCK TABLES `road_types` WRITE;
/*!40000 ALTER TABLE `road_types` DISABLE KEYS */;
INSERT INTO `road_types` VALUES (1,'কাঁচা','2022-01-20 05:25:05','2022-01-20 05:25:05'),(2,'পাকা','2022-01-20 05:26:25','2022-01-20 05:26:25');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_wise_menus`
--

LOCK TABLES `role_wise_menus` WRITE;
/*!40000 ALTER TABLE `role_wise_menus` DISABLE KEYS */;
INSERT INTO `role_wise_menus` VALUES (1,4,'[2,1,4]',NULL,'[8,14,15,16,17,18]','2022-01-20 05:35:50','2022-01-20 05:35:50'),(2,3,'[14,2]',NULL,'[]','2022-01-20 05:36:02','2022-01-20 05:36:02'),(3,2,'[2,13]',NULL,'[19]','2022-01-20 05:36:11','2022-01-20 05:36:11');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Superadmin',0,0,NULL,NULL),(2,'Plant Manager',0,2,'2022-01-20 05:34:38','2022-01-20 05:34:38'),(3,'Chairman',0,2,'2022-01-20 05:35:07','2022-01-20 05:35:07'),(4,'Field Officer',0,2,'2022-01-20 05:35:17','2022-01-20 05:35:17');
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
  `user_id` int NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_reports`
--

LOCK TABLES `survey_reports` WRITE;
/*!40000 ALTER TABLE `survey_reports` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `systems`
--

LOCK TABLES `systems` WRITE;
/*!40000 ALTER TABLE `systems` DISABLE KEYS */;
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
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci,
  `trash` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=492 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thanas`
--

LOCK TABLES `thanas` WRITE;
/*!40000 ALTER TABLE `thanas` DISABLE KEYS */;
INSERT INTO `thanas` VALUES (1,1,'Debidwar','দেবিদ্বার','debidwar.comilla.gov.bd',0,NULL,NULL),(2,1,'Barura','বরুড়া','barura.comilla.gov.bd',0,NULL,NULL),(3,1,'Brahmanpara','ব্রাহ্মণপাড়া','brahmanpara.comilla.gov.bd',0,NULL,NULL),(4,1,'Chandina','চান্দিনা','chandina.comilla.gov.bd',0,NULL,NULL),(5,1,'Chauddagram','চৌদ্দগ্রাম','chauddagram.comilla.gov.bd',0,NULL,NULL),(6,1,'Daudkandi','দাউদকান্দি','daudkandi.comilla.gov.bd',0,NULL,NULL),(7,1,'Homna','হোমনা','homna.comilla.gov.bd',0,NULL,NULL),(8,1,'Laksam','লাকসাম','laksam.comilla.gov.bd',0,NULL,NULL),(9,1,'Muradnagar','মুরাদনগর','muradnagar.comilla.gov.bd',0,NULL,NULL),(10,1,'Nangalkot','নাঙ্গলকোট','nangalkot.comilla.gov.bd',0,NULL,NULL),(11,1,'Comilla Sadar','কুমিল্লা সদর','comillasadar.comilla.gov.bd',0,NULL,NULL),(12,1,'Meghna','মেঘনা','meghna.comilla.gov.bd',0,NULL,NULL),(13,1,'Monohargonj','মনোহরগঞ্জ','monohargonj.comilla.gov.bd',0,NULL,NULL),(14,1,'Sadarsouth','সদর দক্ষিণ','sadarsouth.comilla.gov.bd',0,NULL,NULL),(15,1,'Titas','তিতাস','titas.comilla.gov.bd',0,NULL,NULL),(16,1,'Burichang','বুড়িচং','burichang.comilla.gov.bd',0,NULL,NULL),(17,1,'Lalmai','লালমাই','lalmai.comilla.gov.bd',0,NULL,NULL),(18,2,'Chhagalnaiya','ছাগলনাইয়া','chhagalnaiya.feni.gov.bd',0,NULL,NULL),(19,2,'Feni Sadar','ফেনী সদর','sadar.feni.gov.bd',0,NULL,NULL),(20,2,'Sonagazi','সোনাগাজী','sonagazi.feni.gov.bd',0,NULL,NULL),(21,2,'Fulgazi','ফুলগাজী','fulgazi.feni.gov.bd',0,NULL,NULL),(22,2,'Parshuram','পরশুরাম','parshuram.feni.gov.bd',0,NULL,NULL),(23,2,'Daganbhuiyan','দাগনভূঞা','daganbhuiyan.feni.gov.bd',0,NULL,NULL),(24,3,'Brahmanbaria Sadar','ব্রাহ্মণবাড়িয়া সদর','sadar.brahmanbaria.gov.bd',0,NULL,NULL),(25,3,'Kasba','কসবা','kasba.brahmanbaria.gov.bd',0,NULL,NULL),(26,3,'Nasirnagar','নাসিরনগর','nasirnagar.brahmanbaria.gov.bd',0,NULL,NULL),(27,3,'Sarail','সরাইল','sarail.brahmanbaria.gov.bd',0,NULL,NULL),(28,3,'Ashuganj','আশুগঞ্জ','ashuganj.brahmanbaria.gov.bd',0,NULL,NULL),(29,3,'Akhaura','আখাউড়া','akhaura.brahmanbaria.gov.bd',0,NULL,NULL),(30,3,'Nabinagar','নবীনগর','nabinagar.brahmanbaria.gov.bd',0,NULL,NULL),(31,3,'Bancharampur','বাঞ্ছারামপুর','bancharampur.brahmanbaria.gov.bd',0,NULL,NULL),(32,3,'Bijoynagar','বিজয়নগর','bijoynagar.brahmanbaria.gov.bd    ',0,NULL,NULL),(33,4,'Rangamati Sadar','রাঙ্গামাটি সদর','sadar.rangamati.gov.bd',0,NULL,NULL),(34,4,'Kaptai','কাপ্তাই','kaptai.rangamati.gov.bd',0,NULL,NULL),(35,4,'Kawkhali','কাউখালী','kawkhali.rangamati.gov.bd',0,NULL,NULL),(36,4,'Baghaichari','বাঘাইছড়ি','baghaichari.rangamati.gov.bd',0,NULL,NULL),(37,4,'Barkal','বরকল','barkal.rangamati.gov.bd',0,NULL,NULL),(38,4,'Langadu','লংগদু','langadu.rangamati.gov.bd',0,NULL,NULL),(39,4,'Rajasthali','রাজস্থলী','rajasthali.rangamati.gov.bd',0,NULL,NULL),(40,4,'Belaichari','বিলাইছড়ি','belaichari.rangamati.gov.bd',0,NULL,NULL),(41,4,'Juraichari','জুরাছড়ি','juraichari.rangamati.gov.bd',0,NULL,NULL),(42,4,'Naniarchar','নানিয়ারচর','naniarchar.rangamati.gov.bd',0,NULL,NULL),(43,5,'Noakhali Sadar','নোয়াখালী সদর','sadar.noakhali.gov.bd',0,NULL,NULL),(44,5,'Companiganj','কোম্পানীগঞ্জ','companiganj.noakhali.gov.bd',0,NULL,NULL),(45,5,'Begumganj','বেগমগঞ্জ','begumganj.noakhali.gov.bd',0,NULL,NULL),(46,5,'Hatia','হাতিয়া','hatia.noakhali.gov.bd',0,NULL,NULL),(47,5,'Subarnachar','সুবর্ণচর','subarnachar.noakhali.gov.bd',0,NULL,NULL),(48,5,'Kabirhat','কবিরহাট','kabirhat.noakhali.gov.bd',0,NULL,NULL),(49,5,'Senbug','সেনবাগ','senbug.noakhali.gov.bd',0,NULL,NULL),(50,5,'Chatkhil','চাটখিল','chatkhil.noakhali.gov.bd',0,NULL,NULL),(51,5,'Sonaimori','সোনাইমুড়ী','sonaimori.noakhali.gov.bd',0,NULL,NULL),(52,6,'Haimchar','হাইমচর','haimchar.chandpur.gov.bd',0,NULL,NULL),(53,6,'Kachua','কচুয়া','kachua.chandpur.gov.bd',0,NULL,NULL),(54,6,'Shahrasti','শাহরাস্তি	','shahrasti.chandpur.gov.bd',0,NULL,NULL),(55,6,'Chandpur Sadar','চাঁদপুর সদর','sadar.chandpur.gov.bd',0,NULL,NULL),(56,6,'Matlab South','মতলব দক্ষিণ','matlabsouth.chandpur.gov.bd',0,NULL,NULL),(57,6,'Hajiganj','হাজীগঞ্জ','hajiganj.chandpur.gov.bd',0,NULL,NULL),(58,6,'Matlab North','মতলব উত্তর','matlabnorth.chandpur.gov.bd',0,NULL,NULL),(59,6,'Faridgonj','ফরিদগঞ্জ','faridgonj.chandpur.gov.bd',0,NULL,NULL),(60,7,'Lakshmipur Sadar','লক্ষ্মীপুর সদর','sadar.lakshmipur.gov.bd',0,NULL,NULL),(61,7,'Kamalnagar','কমলনগর','kamalnagar.lakshmipur.gov.bd',0,NULL,NULL),(62,7,'Raipur','রায়পুর','raipur.lakshmipur.gov.bd',0,NULL,NULL),(63,7,'Ramgati','রামগতি','ramgati.lakshmipur.gov.bd',0,NULL,NULL),(64,7,'Ramganj','রামগঞ্জ','ramganj.lakshmipur.gov.bd',0,NULL,NULL),(65,8,'Rangunia','রাঙ্গুনিয়া','rangunia.chittagong.gov.bd',0,NULL,NULL),(66,8,'Sitakunda','সীতাকুন্ড','sitakunda.chittagong.gov.bd',0,NULL,NULL),(67,8,'Mirsharai','মীরসরাই','mirsharai.chittagong.gov.bd',0,NULL,NULL),(68,8,'Patiya','পটিয়া','patiya.chittagong.gov.bd',0,NULL,NULL),(69,8,'Sandwip','সন্দ্বীপ','sandwip.chittagong.gov.bd',0,NULL,NULL),(70,8,'Banshkhali','বাঁশখালী','banshkhali.chittagong.gov.bd',0,NULL,NULL),(71,8,'Boalkhali','বোয়ালখালী','boalkhali.chittagong.gov.bd',0,NULL,NULL),(72,8,'Anwara','আনোয়ারা','anwara.chittagong.gov.bd',0,NULL,NULL),(73,8,'Chandanaish','চন্দনাইশ','chandanaish.chittagong.gov.bd',0,NULL,NULL),(74,8,'Satkania','সাতকানিয়া','satkania.chittagong.gov.bd',0,NULL,NULL),(75,8,'Lohagara','লোহাগাড়া','lohagara.chittagong.gov.bd',0,NULL,NULL),(76,8,'Hathazari','হাটহাজারী','hathazari.chittagong.gov.bd',0,NULL,NULL),(77,8,'Fatikchhari','ফটিকছড়ি','fatikchhari.chittagong.gov.bd',0,NULL,NULL),(78,8,'Raozan','রাউজান','raozan.chittagong.gov.bd',0,NULL,NULL),(79,8,'Karnafuli','কর্ণফুলী','karnafuli.chittagong.gov.bd',0,NULL,NULL),(80,9,'Coxsbazar Sadar','কক্সবাজার সদর','sadar.coxsbazar.gov.bd',0,NULL,NULL),(81,9,'Chakaria','চকরিয়া','chakaria.coxsbazar.gov.bd',0,NULL,NULL),(82,9,'Kutubdia','কুতুবদিয়া','kutubdia.coxsbazar.gov.bd',0,NULL,NULL),(83,9,'Ukhiya','উখিয়া','ukhiya.coxsbazar.gov.bd',0,NULL,NULL),(84,9,'Moheshkhali','মহেশখালী','moheshkhali.coxsbazar.gov.bd',0,NULL,NULL),(85,9,'Pekua','পেকুয়া','pekua.coxsbazar.gov.bd',0,NULL,NULL),(86,9,'Ramu','রামু','ramu.coxsbazar.gov.bd',0,NULL,NULL),(87,9,'Teknaf','টেকনাফ','teknaf.coxsbazar.gov.bd',0,NULL,NULL),(88,10,'Khagrachhari Sadar','খাগড়াছড়ি সদর','sadar.khagrachhari.gov.bd',0,NULL,NULL),(89,10,'Dighinala','দিঘীনালা','dighinala.khagrachhari.gov.bd',0,NULL,NULL),(90,10,'Panchari','পানছড়ি','panchari.khagrachhari.gov.bd',0,NULL,NULL),(91,10,'Laxmichhari','লক্ষীছড়ি','laxmichhari.khagrachhari.gov.bd',0,NULL,NULL),(92,10,'Mohalchari','মহালছড়ি','mohalchari.khagrachhari.gov.bd',0,NULL,NULL),(93,10,'Manikchari','মানিকছড়ি','manikchari.khagrachhari.gov.bd',0,NULL,NULL),(94,10,'Ramgarh','রামগড়','ramgarh.khagrachhari.gov.bd',0,NULL,NULL),(95,10,'Matiranga','মাটিরাঙ্গা','matiranga.khagrachhari.gov.bd',0,NULL,NULL),(96,10,'Guimara','গুইমারা','guimara.khagrachhari.gov.bd',0,NULL,NULL),(97,11,'Bandarban Sadar','বান্দরবান সদর','sadar.bandarban.gov.bd',0,NULL,NULL),(98,11,'Alikadam','আলীকদম','alikadam.bandarban.gov.bd',0,NULL,NULL),(99,11,'Naikhongchhari','নাইক্ষ্যংছড়ি','naikhongchhari.bandarban.gov.bd',0,NULL,NULL),(100,11,'Rowangchhari','রোয়াংছড়ি','rowangchhari.bandarban.gov.bd',0,NULL,NULL),(101,11,'Lama','লামা','lama.bandarban.gov.bd',0,NULL,NULL),(102,11,'Ruma','রুমা','ruma.bandarban.gov.bd',0,NULL,NULL),(103,11,'Thanchi','থানচি','thanchi.bandarban.gov.bd',0,NULL,NULL),(104,12,'Belkuchi','বেলকুচি','belkuchi.sirajganj.gov.bd',0,NULL,NULL),(105,12,'Chauhali','চৌহালি','chauhali.sirajganj.gov.bd',0,NULL,NULL),(106,12,'Kamarkhand','কামারখন্দ','kamarkhand.sirajganj.gov.bd',0,NULL,NULL),(107,12,'Kazipur','কাজীপুর','kazipur.sirajganj.gov.bd',0,NULL,NULL),(108,12,'Raigonj','রায়গঞ্জ','raigonj.sirajganj.gov.bd',0,NULL,NULL),(109,12,'Shahjadpur','শাহজাদপুর','shahjadpur.sirajganj.gov.bd',0,NULL,NULL),(110,12,'Sirajganj Sadar','সিরাজগঞ্জ সদর','sirajganjsadar.sirajganj.gov.bd',0,NULL,NULL),(111,12,'Tarash','তাড়াশ','tarash.sirajganj.gov.bd',0,NULL,NULL),(112,12,'Ullapara','উল্লাপাড়া','ullapara.sirajganj.gov.bd',0,NULL,NULL),(113,13,'Sujanagar','সুজানগর','sujanagar.pabna.gov.bd',0,NULL,NULL),(114,13,'Ishurdi','ঈশ্বরদী','ishurdi.pabna.gov.bd',0,NULL,NULL),(115,13,'Bhangura','ভাঙ্গুড়া','bhangura.pabna.gov.bd',0,NULL,NULL),(116,13,'Pabna Sadar','পাবনা সদর','pabnasadar.pabna.gov.bd',0,NULL,NULL),(117,13,'Bera','বেড়া','bera.pabna.gov.bd',0,NULL,NULL),(118,13,'Atghoria','আটঘরিয়া','atghoria.pabna.gov.bd',0,NULL,NULL),(119,13,'Chatmohar','চাটমোহর','chatmohar.pabna.gov.bd',0,NULL,NULL),(120,13,'Santhia','সাঁথিয়া','santhia.pabna.gov.bd',0,NULL,NULL),(121,13,'Faridpur','ফরিদপুর','faridpur.pabna.gov.bd',0,NULL,NULL),(122,14,'Kahaloo','কাহালু','kahaloo.bogra.gov.bd',0,NULL,NULL),(123,14,'Bogra Sadar','বগুড়া সদর','sadar.bogra.gov.bd',0,NULL,NULL),(124,14,'Shariakandi','সারিয়াকান্দি','shariakandi.bogra.gov.bd',0,NULL,NULL),(125,14,'Shajahanpur','শাজাহানপুর','shajahanpur.bogra.gov.bd',0,NULL,NULL),(126,14,'Dupchanchia','দুপচাচিঁয়া','dupchanchia.bogra.gov.bd',0,NULL,NULL),(127,14,'Adamdighi','আদমদিঘি','adamdighi.bogra.gov.bd',0,NULL,NULL),(128,14,'Nondigram','নন্দিগ্রাম','nondigram.bogra.gov.bd',0,NULL,NULL),(129,14,'Sonatala','সোনাতলা','sonatala.bogra.gov.bd',0,NULL,NULL),(130,14,'Dhunot','ধুনট','dhunot.bogra.gov.bd',0,NULL,NULL),(131,14,'Gabtali','গাবতলী','gabtali.bogra.gov.bd',0,NULL,NULL),(132,14,'Sherpur','শেরপুর','sherpur.bogra.gov.bd',0,NULL,NULL),(133,14,'Shibganj','শিবগঞ্জ','shibganj.bogra.gov.bd',0,NULL,NULL),(134,15,'Paba','পবা','paba.rajshahi.gov.bd',0,NULL,NULL),(135,15,'Durgapur','দুর্গাপুর','durgapur.rajshahi.gov.bd',0,NULL,NULL),(136,15,'Mohonpur','মোহনপুর','mohonpur.rajshahi.gov.bd',0,NULL,NULL),(137,15,'Charghat','চারঘাট','charghat.rajshahi.gov.bd',0,NULL,NULL),(138,15,'Puthia','পুঠিয়া','puthia.rajshahi.gov.bd',0,NULL,NULL),(139,15,'Bagha','বাঘা','bagha.rajshahi.gov.bd',0,NULL,NULL),(140,15,'Godagari','গোদাগাড়ী','godagari.rajshahi.gov.bd',0,NULL,NULL),(141,15,'Tanore','তানোর','tanore.rajshahi.gov.bd',0,NULL,NULL),(142,15,'Bagmara','বাগমারা','bagmara.rajshahi.gov.bd',0,NULL,NULL),(143,16,'Natore Sadar','নাটোর সদর','natoresadar.natore.gov.bd',0,NULL,NULL),(144,16,'Singra','সিংড়া','singra.natore.gov.bd',0,NULL,NULL),(145,16,'Baraigram','বড়াইগ্রাম','baraigram.natore.gov.bd',0,NULL,NULL),(146,16,'Bagatipara','বাগাতিপাড়া','bagatipara.natore.gov.bd',0,NULL,NULL),(147,16,'Lalpur','লালপুর','lalpur.natore.gov.bd',0,NULL,NULL),(148,16,'Gurudaspur','গুরুদাসপুর','gurudaspur.natore.gov.bd',0,NULL,NULL),(149,16,'Naldanga','নলডাঙ্গা','naldanga.natore.gov.bd',0,NULL,NULL),(150,17,'Akkelpur','আক্কেলপুর','akkelpur.joypurhat.gov.bd',0,NULL,NULL),(151,17,'Kalai','কালাই','kalai.joypurhat.gov.bd',0,NULL,NULL),(152,17,'Khetlal','ক্ষেতলাল','khetlal.joypurhat.gov.bd',0,NULL,NULL),(153,17,'Panchbibi','পাঁচবিবি','panchbibi.joypurhat.gov.bd',0,NULL,NULL),(154,17,'Joypurhat Sadar','জয়পুরহাট সদর','joypurhatsadar.joypurhat.gov.bd',0,NULL,NULL),(155,18,'Chapainawabganj Sadar','চাঁপাইনবাবগঞ্জ সদর','chapainawabganjsadar.chapainawabganj.gov.bd',0,NULL,NULL),(156,18,'Gomostapur','গোমস্তাপুর','gomostapur.chapainawabganj.gov.bd',0,NULL,NULL),(157,18,'Nachol','নাচোল','nachol.chapainawabganj.gov.bd',0,NULL,NULL),(158,18,'Bholahat','ভোলাহাট','bholahat.chapainawabganj.gov.bd',0,NULL,NULL),(159,18,'Shibganj','শিবগঞ্জ','shibganj.chapainawabganj.gov.bd',0,NULL,NULL),(160,19,'Mohadevpur','মহাদেবপুর','mohadevpur.naogaon.gov.bd',0,NULL,NULL),(161,19,'Badalgachi','বদলগাছী','badalgachi.naogaon.gov.bd',0,NULL,NULL),(162,19,'Patnitala','পত্নিতলা','patnitala.naogaon.gov.bd',0,NULL,NULL),(163,19,'Dhamoirhat','ধামইরহাট','dhamoirhat.naogaon.gov.bd',0,NULL,NULL),(164,19,'Niamatpur','নিয়ামতপুর','niamatpur.naogaon.gov.bd',0,NULL,NULL),(165,19,'Manda','মান্দা','manda.naogaon.gov.bd',0,NULL,NULL),(166,19,'Atrai','আত্রাই','atrai.naogaon.gov.bd',0,NULL,NULL),(167,19,'Raninagar','রাণীনগর','raninagar.naogaon.gov.bd',0,NULL,NULL),(168,19,'Naogaon Sadar','নওগাঁ সদর','naogaonsadar.naogaon.gov.bd',0,NULL,NULL),(169,19,'Porsha','পোরশা','porsha.naogaon.gov.bd',0,NULL,NULL),(170,19,'Sapahar','সাপাহার','sapahar.naogaon.gov.bd',0,NULL,NULL),(171,20,'Manirampur','মণিরামপুর','manirampur.jessore.gov.bd',0,NULL,NULL),(172,20,'Abhaynagar','অভয়নগর','abhaynagar.jessore.gov.bd',0,NULL,NULL),(173,20,'Bagherpara','বাঘারপাড়া','bagherpara.jessore.gov.bd',0,NULL,NULL),(174,20,'Chougachha','চৌগাছা','chougachha.jessore.gov.bd',0,NULL,NULL),(175,20,'Jhikargacha','ঝিকরগাছা','jhikargacha.jessore.gov.bd',0,NULL,NULL),(176,20,'Keshabpur','কেশবপুর','keshabpur.jessore.gov.bd',0,NULL,NULL),(177,20,'Jessore Sadar','যশোর সদর','sadar.jessore.gov.bd',0,NULL,NULL),(178,20,'Sharsha','শার্শা','sharsha.jessore.gov.bd',0,NULL,NULL),(179,21,'Assasuni','আশাশুনি','assasuni.satkhira.gov.bd',0,NULL,NULL),(180,21,'Debhata','দেবহাটা','debhata.satkhira.gov.bd',0,NULL,NULL),(181,21,'Kalaroa','কলারোয়া','kalaroa.satkhira.gov.bd',0,NULL,NULL),(182,21,'Satkhira Sadar','সাতক্ষীরা সদর','satkhirasadar.satkhira.gov.bd',0,NULL,NULL),(183,21,'Shyamnagar','শ্যামনগর','shyamnagar.satkhira.gov.bd',0,NULL,NULL),(184,21,'Tala','তালা','tala.satkhira.gov.bd',0,NULL,NULL),(185,21,'Kaliganj','কালিগঞ্জ','kaliganj.satkhira.gov.bd',0,NULL,NULL),(186,22,'Mujibnagar','মুজিবনগর','mujibnagar.meherpur.gov.bd',0,NULL,NULL),(187,22,'Meherpur Sadar','মেহেরপুর সদর','meherpursadar.meherpur.gov.bd',0,NULL,NULL),(188,22,'Gangni','গাংনী','gangni.meherpur.gov.bd',0,NULL,NULL),(189,23,'Narail Sadar','নড়াইল সদর','narailsadar.narail.gov.bd',0,NULL,NULL),(190,23,'Lohagara','লোহাগড়া','lohagara.narail.gov.bd',0,NULL,NULL),(191,23,'Kalia','কালিয়া','kalia.narail.gov.bd',0,NULL,NULL),(192,24,'Chuadanga Sadar','চুয়াডাঙ্গা সদর','chuadangasadar.chuadanga.gov.bd',0,NULL,NULL),(193,24,'Alamdanga','আলমডাঙ্গা','alamdanga.chuadanga.gov.bd',0,NULL,NULL),(194,24,'Damurhuda','দামুড়হুদা','damurhuda.chuadanga.gov.bd',0,NULL,NULL),(195,24,'Jibannagar','জীবননগর','jibannagar.chuadanga.gov.bd',0,NULL,NULL),(196,25,'Kushtia Sadar','কুষ্টিয়া সদর','kushtiasadar.kushtia.gov.bd',0,NULL,NULL),(197,25,'Kumarkhali','কুমারখালী','kumarkhali.kushtia.gov.bd',0,NULL,NULL),(198,25,'Khoksa','খোকসা','khoksa.kushtia.gov.bd',0,NULL,NULL),(199,25,'Mirpur','মিরপুর','mirpurkushtia.kushtia.gov.bd',0,NULL,NULL),(200,25,'Daulatpur','দৌলতপুর','daulatpur.kushtia.gov.bd',0,NULL,NULL),(201,25,'Bheramara','ভেড়ামারা','bheramara.kushtia.gov.bd',0,NULL,NULL),(202,26,'Shalikha','শালিখা','shalikha.magura.gov.bd',0,NULL,NULL),(203,26,'Sreepur','শ্রীপুর','sreepur.magura.gov.bd',0,NULL,NULL),(204,26,'Magura Sadar','মাগুরা সদর','magurasadar.magura.gov.bd',0,NULL,NULL),(205,26,'Mohammadpur','মহম্মদপুর','mohammadpur.magura.gov.bd',0,NULL,NULL),(206,27,'Paikgasa','পাইকগাছা','paikgasa.khulna.gov.bd',0,NULL,NULL),(207,27,'Fultola','ফুলতলা','fultola.khulna.gov.bd',0,NULL,NULL),(208,27,'Digholia','দিঘলিয়া','digholia.khulna.gov.bd',0,NULL,NULL),(209,27,'Rupsha','রূপসা','rupsha.khulna.gov.bd',0,NULL,NULL),(210,27,'Terokhada','তেরখাদা','terokhada.khulna.gov.bd',0,NULL,NULL),(211,27,'Dumuria','ডুমুরিয়া','dumuria.khulna.gov.bd',0,NULL,NULL),(212,27,'Botiaghata','বটিয়াঘাটা','botiaghata.khulna.gov.bd',0,NULL,NULL),(213,27,'Dakop','দাকোপ','dakop.khulna.gov.bd',0,NULL,NULL),(214,27,'Koyra','কয়রা','koyra.khulna.gov.bd',0,NULL,NULL),(215,28,'Fakirhat','ফকিরহাট','fakirhat.bagerhat.gov.bd',0,NULL,NULL),(216,28,'Bagerhat Sadar','বাগেরহাট সদর','sadar.bagerhat.gov.bd',0,NULL,NULL),(217,28,'Mollahat','মোল্লাহাট','mollahat.bagerhat.gov.bd',0,NULL,NULL),(218,28,'Sarankhola','শরণখোলা','sarankhola.bagerhat.gov.bd',0,NULL,NULL),(219,28,'Rampal','রামপাল','rampal.bagerhat.gov.bd',0,NULL,NULL),(220,28,'Morrelganj','মোড়েলগঞ্জ','morrelganj.bagerhat.gov.bd',0,NULL,NULL),(221,28,'Kachua','কচুয়া','kachua.bagerhat.gov.bd',0,NULL,NULL),(222,28,'Mongla','মোংলা','mongla.bagerhat.gov.bd',0,NULL,NULL),(223,28,'Chitalmari','চিতলমারী','chitalmari.bagerhat.gov.bd',0,NULL,NULL),(224,29,'Jhenaidah Sadar','ঝিনাইদহ সদর','sadar.jhenaidah.gov.bd',0,NULL,NULL),(225,29,'Shailkupa','শৈলকুপা','shailkupa.jhenaidah.gov.bd',0,NULL,NULL),(226,29,'Harinakundu','হরিণাকুন্ডু','harinakundu.jhenaidah.gov.bd',0,NULL,NULL),(227,29,'Kaliganj','কালীগঞ্জ','kaliganj.jhenaidah.gov.bd',0,NULL,NULL),(228,29,'Kotchandpur','কোটচাঁদপুর','kotchandpur.jhenaidah.gov.bd',0,NULL,NULL),(229,29,'Moheshpur','মহেশপুর','moheshpur.jhenaidah.gov.bd',0,NULL,NULL),(230,30,'Jhalakathi Sadar','ঝালকাঠি সদর','sadar.jhalakathi.gov.bd',0,NULL,NULL),(231,30,'Kathalia','কাঠালিয়া','kathalia.jhalakathi.gov.bd',0,NULL,NULL),(232,30,'Nalchity','নলছিটি','nalchity.jhalakathi.gov.bd',0,NULL,NULL),(233,30,'Rajapur','রাজাপুর','rajapur.jhalakathi.gov.bd',0,NULL,NULL),(234,31,'Bauphal','বাউফল','bauphal.patuakhali.gov.bd',0,NULL,NULL),(235,31,'Patuakhali Sadar','পটুয়াখালী সদর','sadar.patuakhali.gov.bd',0,NULL,NULL),(236,31,'Dumki','দুমকি','dumki.patuakhali.gov.bd',0,NULL,NULL),(237,31,'Dashmina','দশমিনা','dashmina.patuakhali.gov.bd',0,NULL,NULL),(238,31,'Kalapara','কলাপাড়া','kalapara.patuakhali.gov.bd',0,NULL,NULL),(239,31,'Mirzaganj','মির্জাগঞ্জ','mirzaganj.patuakhali.gov.bd',0,NULL,NULL),(240,31,'Galachipa','গলাচিপা','galachipa.patuakhali.gov.bd',0,NULL,NULL),(241,31,'Rangabali','রাঙ্গাবালী','rangabali.patuakhali.gov.bd',0,NULL,NULL),(242,32,'Pirojpur Sadar','পিরোজপুর সদর','sadar.pirojpur.gov.bd',0,NULL,NULL),(243,32,'Nazirpur','নাজিরপুর','nazirpur.pirojpur.gov.bd',0,NULL,NULL),(244,32,'Kawkhali','কাউখালী','kawkhali.pirojpur.gov.bd',0,NULL,NULL),(245,32,'Zianagar','জিয়ানগর','zianagar.pirojpur.gov.bd',0,NULL,NULL),(246,32,'Bhandaria','ভান্ডারিয়া','bhandaria.pirojpur.gov.bd',0,NULL,NULL),(247,32,'Mathbaria','মঠবাড়ীয়া','mathbaria.pirojpur.gov.bd',0,NULL,NULL),(248,32,'Nesarabad','নেছারাবাদ','nesarabad.pirojpur.gov.bd',0,NULL,NULL),(249,33,'Barisal Sadar','বরিশাল সদর','barisalsadar.barisal.gov.bd',0,NULL,NULL),(250,33,'Bakerganj','বাকেরগঞ্জ','bakerganj.barisal.gov.bd',0,NULL,NULL),(251,33,'Babuganj','বাবুগঞ্জ','babuganj.barisal.gov.bd',0,NULL,NULL),(252,33,'Wazirpur','উজিরপুর','wazirpur.barisal.gov.bd',0,NULL,NULL),(253,33,'Banaripara','বানারীপাড়া','banaripara.barisal.gov.bd',0,NULL,NULL),(254,33,'Gournadi','গৌরনদী','gournadi.barisal.gov.bd',0,NULL,NULL),(255,33,'Agailjhara','আগৈলঝাড়া','agailjhara.barisal.gov.bd',0,NULL,NULL),(256,33,'Mehendiganj','মেহেন্দিগঞ্জ','mehendiganj.barisal.gov.bd',0,NULL,NULL),(257,33,'Muladi','মুলাদী','muladi.barisal.gov.bd',0,NULL,NULL),(258,33,'Hizla','হিজলা','hizla.barisal.gov.bd',0,NULL,NULL),(259,34,'Bhola Sadar','ভোলা সদর','sadar.bhola.gov.bd',0,NULL,NULL),(260,34,'Borhan Sddin','বোরহান উদ্দিন','borhanuddin.bhola.gov.bd',0,NULL,NULL),(261,34,'Charfesson','চরফ্যাশন','charfesson.bhola.gov.bd',0,NULL,NULL),(262,34,'Doulatkhan','দৌলতখান','doulatkhan.bhola.gov.bd',0,NULL,NULL),(263,34,'Monpura','মনপুরা','monpura.bhola.gov.bd',0,NULL,NULL),(264,34,'Tazumuddin','তজুমদ্দিন','tazumuddin.bhola.gov.bd',0,NULL,NULL),(265,34,'Lalmohan','লালমোহন','lalmohan.bhola.gov.bd',0,NULL,NULL),(266,35,'Amtali','আমতলী','amtali.barguna.gov.bd',0,NULL,NULL),(267,35,'Barguna Sadar','বরগুনা সদর','sadar.barguna.gov.bd',0,NULL,NULL),(268,35,'Betagi','বেতাগী','betagi.barguna.gov.bd',0,NULL,NULL),(269,35,'Bamna','বামনা','bamna.barguna.gov.bd',0,NULL,NULL),(270,35,'Pathorghata','পাথরঘাটা','pathorghata.barguna.gov.bd',0,NULL,NULL),(271,35,'Taltali','তালতলি','taltali.barguna.gov.bd',0,NULL,NULL),(272,36,'Balaganj','বালাগঞ্জ','balaganj.sylhet.gov.bd',0,NULL,NULL),(273,36,'Beanibazar','বিয়ানীবাজার','beanibazar.sylhet.gov.bd',0,NULL,NULL),(274,36,'Bishwanath','বিশ্বনাথ','bishwanath.sylhet.gov.bd',0,NULL,NULL),(275,36,'Companiganj','কোম্পানীগঞ্জ','companiganj.sylhet.gov.bd',0,NULL,NULL),(276,36,'Fenchuganj','ফেঞ্চুগঞ্জ','fenchuganj.sylhet.gov.bd',0,NULL,NULL),(277,36,'Golapganj','গোলাপগঞ্জ','golapganj.sylhet.gov.bd',0,NULL,NULL),(278,36,'Gowainghat','গোয়াইনঘাট','gowainghat.sylhet.gov.bd',0,NULL,NULL),(279,36,'Jaintiapur','জৈন্তাপুর','jaintiapur.sylhet.gov.bd',0,NULL,NULL),(280,36,'Kanaighat','কানাইঘাট','kanaighat.sylhet.gov.bd',0,NULL,NULL),(281,36,'Sylhet Sadar','সিলেট সদর','sylhetsadar.sylhet.gov.bd',0,NULL,NULL),(282,36,'Zakiganj','জকিগঞ্জ','zakiganj.sylhet.gov.bd',0,NULL,NULL),(283,36,'Dakshinsurma','দক্ষিণ সুরমা','dakshinsurma.sylhet.gov.bd',0,NULL,NULL),(284,36,'Osmaninagar','ওসমানী নগর','osmaninagar.sylhet.gov.bd',0,NULL,NULL),(285,37,'Barlekha','বড়লেখা','barlekha.moulvibazar.gov.bd',0,NULL,NULL),(286,37,'Kamolganj','কমলগঞ্জ','kamolganj.moulvibazar.gov.bd',0,NULL,NULL),(287,37,'Kulaura','কুলাউড়া','kulaura.moulvibazar.gov.bd',0,NULL,NULL),(288,37,'Moulvibazar Sadar','মৌলভীবাজার সদর','moulvibazarsadar.moulvibazar.gov.bd',0,NULL,NULL),(289,37,'Rajnagar','রাজনগর','rajnagar.moulvibazar.gov.bd',0,NULL,NULL),(290,37,'Sreemangal','শ্রীমঙ্গল','sreemangal.moulvibazar.gov.bd',0,NULL,NULL),(291,37,'Juri','জুড়ী','juri.moulvibazar.gov.bd',0,NULL,NULL),(292,38,'Nabiganj','নবীগঞ্জ','nabiganj.habiganj.gov.bd',0,NULL,NULL),(293,38,'Bahubal','বাহুবল','bahubal.habiganj.gov.bd',0,NULL,NULL),(294,38,'Ajmiriganj','আজমিরীগঞ্জ','ajmiriganj.habiganj.gov.bd',0,NULL,NULL),(295,38,'Baniachong','বানিয়াচং','baniachong.habiganj.gov.bd',0,NULL,NULL),(296,38,'Lakhai','লাখাই','lakhai.habiganj.gov.bd',0,NULL,NULL),(297,38,'Chunarughat','চুনারুঘাট','chunarughat.habiganj.gov.bd',0,NULL,NULL),(298,38,'Habiganj Sadar','হবিগঞ্জ সদর','habiganjsadar.habiganj.gov.bd',0,NULL,NULL),(299,38,'Madhabpur','মাধবপুর','madhabpur.habiganj.gov.bd',0,NULL,NULL),(300,39,'Sunamganj Sadar','সুনামগঞ্জ সদর','sadar.sunamganj.gov.bd',0,NULL,NULL),(301,39,'South Sunamganj','দক্ষিণ সুনামগঞ্জ','southsunamganj.sunamganj.gov.bd',0,NULL,NULL),(302,39,'Bishwambarpur','বিশ্বম্ভরপুর','bishwambarpur.sunamganj.gov.bd',0,NULL,NULL),(303,39,'Chhatak','ছাতক','chhatak.sunamganj.gov.bd',0,NULL,NULL),(304,39,'Jagannathpur','জগন্নাথপুর','jagannathpur.sunamganj.gov.bd',0,NULL,NULL),(305,39,'Dowarabazar','দোয়ারাবাজার','dowarabazar.sunamganj.gov.bd',0,NULL,NULL),(306,39,'Tahirpur','তাহিরপুর','tahirpur.sunamganj.gov.bd',0,NULL,NULL),(307,39,'Dharmapasha','ধর্মপাশা','dharmapasha.sunamganj.gov.bd',0,NULL,NULL),(308,39,'Jamalganj','জামালগঞ্জ','jamalganj.sunamganj.gov.bd',0,NULL,NULL),(309,39,'Shalla','শাল্লা','shalla.sunamganj.gov.bd',0,NULL,NULL),(310,39,'Derai','দিরাই','derai.sunamganj.gov.bd',0,NULL,NULL),(311,40,'Belabo','বেলাবো','belabo.narsingdi.gov.bd',0,NULL,NULL),(312,40,'Monohardi','মনোহরদী','monohardi.narsingdi.gov.bd',0,NULL,NULL),(313,40,'Narsingdi Sadar','নরসিংদী সদর','narsingdisadar.narsingdi.gov.bd',0,NULL,NULL),(314,40,'Palash','পলাশ','palash.narsingdi.gov.bd',0,NULL,NULL),(315,40,'Raipura','রায়পুরা','raipura.narsingdi.gov.bd',0,NULL,NULL),(316,40,'Shibpur','শিবপুর','shibpur.narsingdi.gov.bd',0,NULL,NULL),(317,41,'Kaliganj','কালীগঞ্জ','kaliganj.gazipur.gov.bd',0,NULL,NULL),(318,41,'Kaliakair','কালিয়াকৈর','kaliakair.gazipur.gov.bd',0,NULL,NULL),(319,41,'Kapasia','কাপাসিয়া','kapasia.gazipur.gov.bd',0,NULL,NULL),(320,41,'Gazipur Sadar','গাজীপুর সদর','sadar.gazipur.gov.bd',0,NULL,NULL),(321,41,'Sreepur','শ্রীপুর','sreepur.gazipur.gov.bd',0,NULL,NULL),(322,42,'Shariatpur Sadar','শরিয়তপুর সদর','sadar.shariatpur.gov.bd',0,NULL,NULL),(323,42,'Naria','নড়িয়া','naria.shariatpur.gov.bd',0,NULL,NULL),(324,42,'Zajira','জাজিরা','zajira.shariatpur.gov.bd',0,NULL,NULL),(325,42,'Gosairhat','গোসাইরহাট','gosairhat.shariatpur.gov.bd',0,NULL,NULL),(326,42,'Bhedarganj','ভেদরগঞ্জ','bhedarganj.shariatpur.gov.bd',0,NULL,NULL),(327,42,'Damudya','ডামুড্যা','damudya.shariatpur.gov.bd',0,NULL,NULL),(328,43,'Araihazar','আড়াইহাজার','araihazar.narayanganj.gov.bd',0,NULL,NULL),(329,43,'Bandar','বন্দর','bandar.narayanganj.gov.bd',0,NULL,NULL),(330,43,'Narayanganj Sadar','নারায়নগঞ্জ সদর','narayanganjsadar.narayanganj.gov.bd',0,NULL,NULL),(331,43,'Rupganj','রূপগঞ্জ','rupganj.narayanganj.gov.bd',0,NULL,NULL),(332,43,'Sonargaon','সোনারগাঁ','sonargaon.narayanganj.gov.bd',0,NULL,NULL),(333,44,'Basail','বাসাইল','basail.tangail.gov.bd',0,NULL,NULL),(334,44,'Bhuapur','ভুয়াপুর','bhuapur.tangail.gov.bd',0,NULL,NULL),(335,44,'Delduar','দেলদুয়ার','delduar.tangail.gov.bd',0,NULL,NULL),(336,44,'Ghatail','ঘাটাইল','ghatail.tangail.gov.bd',0,NULL,NULL),(337,44,'Gopalpur','গোপালপুর','gopalpur.tangail.gov.bd',0,NULL,NULL),(338,44,'Madhupur','মধুপুর','madhupur.tangail.gov.bd',0,NULL,NULL),(339,44,'Mirzapur','মির্জাপুর','mirzapur.tangail.gov.bd',0,NULL,NULL),(340,44,'Nagarpur','নাগরপুর','nagarpur.tangail.gov.bd',0,NULL,NULL),(341,44,'Sakhipur','সখিপুর','sakhipur.tangail.gov.bd',0,NULL,NULL),(342,44,'Tangail Sadar','টাঙ্গাইল সদর','tangailsadar.tangail.gov.bd',0,NULL,NULL),(343,44,'Kalihati','কালিহাতী','kalihati.tangail.gov.bd',0,NULL,NULL),(344,44,'Dhanbari','ধনবাড়ী','dhanbari.tangail.gov.bd',0,NULL,NULL),(345,45,'Itna','ইটনা','itna.kishoreganj.gov.bd',0,NULL,NULL),(346,45,'Katiadi','কটিয়াদী','katiadi.kishoreganj.gov.bd',0,NULL,NULL),(347,45,'Bhairab','ভৈরব','bhairab.kishoreganj.gov.bd',0,NULL,NULL),(348,45,'Tarail','তাড়াইল','tarail.kishoreganj.gov.bd',0,NULL,NULL),(349,45,'Hossainpur','হোসেনপুর','hossainpur.kishoreganj.gov.bd',0,NULL,NULL),(350,45,'Pakundia','পাকুন্দিয়া','pakundia.kishoreganj.gov.bd',0,NULL,NULL),(351,45,'Kuliarchar','কুলিয়ারচর','kuliarchar.kishoreganj.gov.bd',0,NULL,NULL),(352,45,'Kishoreganj Sadar','কিশোরগঞ্জ সদর','kishoreganjsadar.kishoreganj.gov.bd',0,NULL,NULL),(353,45,'Karimgonj','করিমগঞ্জ','karimgonj.kishoreganj.gov.bd',0,NULL,NULL),(354,45,'Bajitpur','বাজিতপুর','bajitpur.kishoreganj.gov.bd',0,NULL,NULL),(355,45,'Austagram','অষ্টগ্রাম','austagram.kishoreganj.gov.bd',0,NULL,NULL),(356,45,'Mithamoin','মিঠামইন','mithamoin.kishoreganj.gov.bd',0,NULL,NULL),(357,45,'Nikli','নিকলী','nikli.kishoreganj.gov.bd',0,NULL,NULL),(358,46,'Harirampur','হরিরামপুর','harirampur.manikganj.gov.bd',0,NULL,NULL),(359,46,'Saturia','সাটুরিয়া','saturia.manikganj.gov.bd',0,NULL,NULL),(360,46,'Manikganj Sadar','মানিকগঞ্জ সদর','sadar.manikganj.gov.bd',0,NULL,NULL),(361,46,'Gior','ঘিওর','gior.manikganj.gov.bd',0,NULL,NULL),(362,46,'Shibaloy','শিবালয়','shibaloy.manikganj.gov.bd',0,NULL,NULL),(363,46,'Doulatpur','দৌলতপুর','doulatpur.manikganj.gov.bd',0,NULL,NULL),(364,46,'Singiar','সিংগাইর','singiar.manikganj.gov.bd',0,NULL,NULL),(365,47,'Savar','সাভার','savar.dhaka.gov.bd',0,NULL,NULL),(366,47,'Dhamrai','ধামরাই','dhamrai.dhaka.gov.bd',0,NULL,NULL),(367,47,'Keraniganj','কেরাণীগঞ্জ','keraniganj.dhaka.gov.bd',0,NULL,NULL),(368,47,'Nawabganj','নবাবগঞ্জ','nawabganj.dhaka.gov.bd',0,NULL,NULL),(369,47,'Dohar','দোহার','dohar.dhaka.gov.bd',0,NULL,NULL),(370,48,'Munshiganj Sadar','মুন্সিগঞ্জ সদর','sadar.munshiganj.gov.bd',0,NULL,NULL),(371,48,'Sreenagar','শ্রীনগর','sreenagar.munshiganj.gov.bd',0,NULL,NULL),(372,48,'Sirajdikhan','সিরাজদিখান','sirajdikhan.munshiganj.gov.bd',0,NULL,NULL),(373,48,'Louhajanj','লৌহজং','louhajanj.munshiganj.gov.bd',0,NULL,NULL),(374,48,'Gajaria','গজারিয়া','gajaria.munshiganj.gov.bd',0,NULL,NULL),(375,48,'Tongibari','টংগীবাড়ি','tongibari.munshiganj.gov.bd',0,NULL,NULL),(376,49,'Rajbari Sadar','রাজবাড়ী সদর','sadar.rajbari.gov.bd',0,NULL,NULL),(377,49,'Goalanda','গোয়ালন্দ','goalanda.rajbari.gov.bd',0,NULL,NULL),(378,49,'Pangsa','পাংশা','pangsa.rajbari.gov.bd',0,NULL,NULL),(379,49,'Baliakandi','বালিয়াকান্দি','baliakandi.rajbari.gov.bd',0,NULL,NULL),(380,49,'Kalukhali','কালুখালী','kalukhali.rajbari.gov.bd',0,NULL,NULL),(381,50,'Madaripur Sadar','মাদারীপুর সদর','sadar.madaripur.gov.bd',0,NULL,NULL),(382,50,'Shibchar','শিবচর','shibchar.madaripur.gov.bd',0,NULL,NULL),(383,50,'Kalkini','কালকিনি','kalkini.madaripur.gov.bd',0,NULL,NULL),(384,50,'Rajoir','রাজৈর','rajoir.madaripur.gov.bd',0,NULL,NULL),(385,51,'Gopalganj Sadar','গোপালগঞ্জ সদর','sadar.gopalganj.gov.bd',0,NULL,NULL),(386,51,'Kashiani','কাশিয়ানী','kashiani.gopalganj.gov.bd',0,NULL,NULL),(387,51,'Tungipara','টুংগীপাড়া','tungipara.gopalganj.gov.bd',0,NULL,NULL),(388,51,'Kotalipara','কোটালীপাড়া','kotalipara.gopalganj.gov.bd',0,NULL,NULL),(389,51,'Muksudpur','মুকসুদপুর','muksudpur.gopalganj.gov.bd',0,NULL,NULL),(390,52,'Faridpur Sadar','ফরিদপুর সদর','sadar.faridpur.gov.bd',0,NULL,NULL),(391,52,'Alfadanga','আলফাডাঙ্গা','alfadanga.faridpur.gov.bd',0,NULL,NULL),(392,52,'Boalmari','বোয়ালমারী','boalmari.faridpur.gov.bd',0,NULL,NULL),(393,52,'Sadarpur','সদরপুর','sadarpur.faridpur.gov.bd',0,NULL,NULL),(394,52,'Nagarkanda','নগরকান্দা','nagarkanda.faridpur.gov.bd',0,NULL,NULL),(395,52,'Bhanga','ভাঙ্গা','bhanga.faridpur.gov.bd',0,NULL,NULL),(396,52,'Charbhadrasan','চরভদ্রাসন','charbhadrasan.faridpur.gov.bd',0,NULL,NULL),(397,52,'Madhukhali','মধুখালী','madhukhali.faridpur.gov.bd',0,NULL,NULL),(398,52,'Saltha','সালথা','saltha.faridpur.gov.bd',0,NULL,NULL),(399,53,'Panchagarh Sadar','পঞ্চগড় সদর','panchagarhsadar.panchagarh.gov.bd',0,NULL,NULL),(400,53,'Debiganj','দেবীগঞ্জ','debiganj.panchagarh.gov.bd',0,NULL,NULL),(401,53,'Boda','বোদা','boda.panchagarh.gov.bd',0,NULL,NULL),(402,53,'Atwari','আটোয়ারী','atwari.panchagarh.gov.bd',0,NULL,NULL),(403,53,'Tetulia','তেতুলিয়া','tetulia.panchagarh.gov.bd',0,NULL,NULL),(404,54,'Nawabganj','নবাবগঞ্জ','nawabganj.dinajpur.gov.bd',0,NULL,NULL),(405,54,'Birganj','বীরগঞ্জ','birganj.dinajpur.gov.bd',0,NULL,NULL),(406,54,'Ghoraghat','ঘোড়াঘাট','ghoraghat.dinajpur.gov.bd',0,NULL,NULL),(407,54,'Birampur','বিরামপুর','birampur.dinajpur.gov.bd',0,NULL,NULL),(408,54,'Parbatipur','পার্বতীপুর','parbatipur.dinajpur.gov.bd',0,NULL,NULL),(409,54,'Bochaganj','বোচাগঞ্জ','bochaganj.dinajpur.gov.bd',0,NULL,NULL),(410,54,'Kaharol','কাহারোল','kaharol.dinajpur.gov.bd',0,NULL,NULL),(411,54,'Fulbari','ফুলবাড়ী','fulbari.dinajpur.gov.bd',0,NULL,NULL),(412,54,'Dinajpur Sadar','দিনাজপুর সদর','dinajpursadar.dinajpur.gov.bd',0,NULL,NULL),(413,54,'Hakimpur','হাকিমপুর','hakimpur.dinajpur.gov.bd',0,NULL,NULL),(414,54,'Khansama','খানসামা','khansama.dinajpur.gov.bd',0,NULL,NULL),(415,54,'Birol','বিরল','birol.dinajpur.gov.bd',0,NULL,NULL),(416,54,'Chirirbandar','চিরিরবন্দর','chirirbandar.dinajpur.gov.bd',0,NULL,NULL),(417,55,'Lalmonirhat Sadar','লালমনিরহাট সদর','sadar.lalmonirhat.gov.bd',0,NULL,NULL),(418,55,'Kaliganj','কালীগঞ্জ','kaliganj.lalmonirhat.gov.bd',0,NULL,NULL),(419,55,'Hatibandha','হাতীবান্ধা','hatibandha.lalmonirhat.gov.bd',0,NULL,NULL),(420,55,'Patgram','পাটগ্রাম','patgram.lalmonirhat.gov.bd',0,NULL,NULL),(421,55,'Aditmari','আদিতমারী','aditmari.lalmonirhat.gov.bd',0,NULL,NULL),(422,56,'Syedpur','সৈয়দপুর','syedpur.nilphamari.gov.bd',0,NULL,NULL),(423,56,'Domar','ডোমার','domar.nilphamari.gov.bd',0,NULL,NULL),(424,56,'Dimla','ডিমলা','dimla.nilphamari.gov.bd',0,NULL,NULL),(425,56,'Jaldhaka','জলঢাকা','jaldhaka.nilphamari.gov.bd',0,NULL,NULL),(426,56,'Kishorganj','কিশোরগঞ্জ','kishorganj.nilphamari.gov.bd',0,NULL,NULL),(427,56,'Nilphamari Sadar','নীলফামারী সদর','nilphamarisadar.nilphamari.gov.bd',0,NULL,NULL),(428,57,'Sadullapur','সাদুল্লাপুর','sadullapur.gaibandha.gov.bd',0,NULL,NULL),(429,57,'Gaibandha Sadar','গাইবান্ধা সদর','gaibandhasadar.gaibandha.gov.bd',0,NULL,NULL),(430,57,'Palashbari','পলাশবাড়ী','palashbari.gaibandha.gov.bd',0,NULL,NULL),(431,57,'Saghata','সাঘাটা','saghata.gaibandha.gov.bd',0,NULL,NULL),(432,57,'Gobindaganj','গোবিন্দগঞ্জ','gobindaganj.gaibandha.gov.bd',0,NULL,NULL),(433,57,'Sundarganj','সুন্দরগঞ্জ','sundarganj.gaibandha.gov.bd',0,NULL,NULL),(434,57,'Phulchari','ফুলছড়ি','phulchari.gaibandha.gov.bd',0,NULL,NULL),(435,58,'Thakurgaon Sadar','ঠাকুরগাঁও সদর','thakurgaonsadar.thakurgaon.gov.bd',0,NULL,NULL),(436,58,'Pirganj','পীরগঞ্জ','pirganj.thakurgaon.gov.bd',0,NULL,NULL),(437,58,'Ranisankail','রাণীশংকৈল','ranisankail.thakurgaon.gov.bd',0,NULL,NULL),(438,58,'Haripur','হরিপুর','haripur.thakurgaon.gov.bd',0,NULL,NULL),(439,58,'Baliadangi','বালিয়াডাঙ্গী','baliadangi.thakurgaon.gov.bd',0,NULL,NULL),(440,59,'Rangpur Sadar','রংপুর সদর','rangpursadar.rangpur.gov.bd',0,NULL,NULL),(441,59,'Gangachara','গংগাচড়া','gangachara.rangpur.gov.bd',0,NULL,NULL),(442,59,'Taragonj','তারাগঞ্জ','taragonj.rangpur.gov.bd',0,NULL,NULL),(443,59,'Badargonj','বদরগঞ্জ','badargonj.rangpur.gov.bd',0,NULL,NULL),(444,59,'Mithapukur','মিঠাপুকুর','mithapukur.rangpur.gov.bd',0,NULL,NULL),(445,59,'Pirgonj','পীরগঞ্জ','pirgonj.rangpur.gov.bd',0,NULL,NULL),(446,59,'Kaunia','কাউনিয়া','kaunia.rangpur.gov.bd',0,NULL,NULL),(447,59,'Pirgacha','পীরগাছা','pirgacha.rangpur.gov.bd',0,NULL,NULL),(448,60,'Kurigram Sadar','কুড়িগ্রাম সদর','kurigramsadar.kurigram.gov.bd',0,NULL,NULL),(449,60,'Nageshwari','নাগেশ্বরী','nageshwari.kurigram.gov.bd',0,NULL,NULL),(450,60,'Bhurungamari','ভুরুঙ্গামারী','bhurungamari.kurigram.gov.bd',0,NULL,NULL),(451,60,'Phulbari','ফুলবাড়ী','phulbari.kurigram.gov.bd',0,NULL,NULL),(452,60,'Rajarhat','রাজারহাট','rajarhat.kurigram.gov.bd',0,NULL,NULL),(453,60,'Ulipur','উলিপুর','ulipur.kurigram.gov.bd',0,NULL,NULL),(454,60,'Chilmari','চিলমারী','chilmari.kurigram.gov.bd',0,NULL,NULL),(455,60,'Rowmari','রৌমারী','rowmari.kurigram.gov.bd',0,NULL,NULL),(456,60,'Charrajibpur','চর রাজিবপুর','charrajibpur.kurigram.gov.bd',0,NULL,NULL),(457,61,'Sherpur Sadar','শেরপুর সদর','sherpursadar.sherpur.gov.bd',0,NULL,NULL),(458,61,'Nalitabari','নালিতাবাড়ী','nalitabari.sherpur.gov.bd',0,NULL,NULL),(459,61,'Sreebordi','শ্রীবরদী','sreebordi.sherpur.gov.bd',0,NULL,NULL),(460,61,'Nokla','নকলা','nokla.sherpur.gov.bd',0,NULL,NULL),(461,61,'Jhenaigati','ঝিনাইগাতী','jhenaigati.sherpur.gov.bd',0,NULL,NULL),(462,62,'Fulbaria','ফুলবাড়ীয়া','fulbaria.mymensingh.gov.bd',0,NULL,NULL),(463,62,'Trishal','ত্রিশাল','trishal.mymensingh.gov.bd',0,NULL,NULL),(464,62,'Bhaluka','ভালুকা','bhaluka.mymensingh.gov.bd',0,NULL,NULL),(465,62,'Muktagacha','মুক্তাগাছা','muktagacha.mymensingh.gov.bd',0,NULL,NULL),(466,62,'Mymensingh Sadar','ময়মনসিংহ সদর','mymensinghsadar.mymensingh.gov.bd',0,NULL,NULL),(467,62,'Dhobaura','ধোবাউড়া','dhobaura.mymensingh.gov.bd',0,NULL,NULL),(468,62,'Phulpur','ফুলপুর','phulpur.mymensingh.gov.bd',0,NULL,NULL),(469,62,'Haluaghat','হালুয়াঘাট','haluaghat.mymensingh.gov.bd',0,NULL,NULL),(470,62,'Gouripur','গৌরীপুর','gouripur.mymensingh.gov.bd',0,NULL,NULL),(471,62,'Gafargaon','গফরগাঁও','gafargaon.mymensingh.gov.bd',0,NULL,NULL),(472,62,'Iswarganj','ঈশ্বরগঞ্জ','iswarganj.mymensingh.gov.bd',0,NULL,NULL),(473,62,'Nandail','নান্দাইল','nandail.mymensingh.gov.bd',0,NULL,NULL),(474,62,'Tarakanda','তারাকান্দা','tarakanda.mymensingh.gov.bd',0,NULL,NULL),(475,63,'Jamalpur Sadar','জামালপুর সদর','jamalpursadar.jamalpur.gov.bd',0,NULL,NULL),(476,63,'Melandah','মেলান্দহ','melandah.jamalpur.gov.bd',0,NULL,NULL),(477,63,'Islampur','ইসলামপুর','islampur.jamalpur.gov.bd',0,NULL,NULL),(478,63,'Dewangonj','দেওয়ানগঞ্জ','dewangonj.jamalpur.gov.bd',0,NULL,NULL),(479,63,'Sarishabari','সরিষাবাড়ী','sarishabari.jamalpur.gov.bd',0,NULL,NULL),(480,63,'Madarganj','মাদারগঞ্জ','madarganj.jamalpur.gov.bd',0,NULL,NULL),(481,63,'Bokshiganj','বকশীগঞ্জ','bokshiganj.jamalpur.gov.bd',0,NULL,NULL),(482,64,'Barhatta','বারহাট্টা','barhatta.netrokona.gov.bd',0,NULL,NULL),(483,64,'Durgapur','দুর্গাপুর','durgapur.netrokona.gov.bd',0,NULL,NULL),(484,64,'Kendua','কেন্দুয়া','kendua.netrokona.gov.bd',0,NULL,NULL),(485,64,'Atpara','আটপাড়া','atpara.netrokona.gov.bd',0,NULL,NULL),(486,64,'Madan','মদন','madan.netrokona.gov.bd',0,NULL,NULL),(487,64,'Khaliajuri','খালিয়াজুরী','khaliajuri.netrokona.gov.bd',0,NULL,NULL),(488,64,'Kalmakanda','কলমাকান্দা','kalmakanda.netrokona.gov.bd',0,NULL,NULL),(489,64,'Mohongonj','মোহনগঞ্জ','mohongonj.netrokona.gov.bd',0,NULL,NULL),(490,64,'Purbadhala','পূর্বধলা','purbadhala.netrokona.gov.bd',0,NULL,'2021-09-21 19:10:15'),(491,64,'Netrokona Sadar','নেত্রকোণা সদর','netrokonasadar.netrokona.gov.bd',1,NULL,'2021-09-14 20:05:04');
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
  `name_bn` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fathers_name_bn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fathers_name_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mothers_name_bn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mothers_name_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `husband_or_wife_name_bn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `husband_or_wife_name_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `religion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sex` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nid_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_id` bigint unsigned NOT NULL DEFAULT '0',
  `entity_id` bigint unsigned NOT NULL DEFAULT '0',
  `chilling_plant_id` bigint unsigned NOT NULL DEFAULT '0',
  `association_id` bigint unsigned NOT NULL DEFAULT '0',
  `proccessing_plant_id` bigint unsigned NOT NULL DEFAULT '0',
  `role_id` bigint unsigned DEFAULT NULL,
  `designation_id` bigint unsigned DEFAULT '0',
  `division_id` bigint unsigned NOT NULL DEFAULT '0',
  `district_id` bigint unsigned NOT NULL DEFAULT '0',
  `thana_id` bigint unsigned NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_path` text COLLATE utf8mb4_unicode_ci,
  `signature_path` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_mobile_unique` (`mobile`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'Sokina','সকিনা','01983667657','01983667657','shamim@gail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,0,0,1,0,0,0,0,NULL,'$2y$10$B84QQxerSXh.kxtPw3sWoOntfFs6d7P5ddbDEXQhFBJm4IjmFVYYO',NULL,NULL,NULL,NULL,'2022-01-20 05:08:55'),(3,'Manager',NULL,'plantmanager','01942077206','manager@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,2,1,0,0,2,0,1,1,1,NULL,'$2y$10$Os6LeSKY4YschmVMKkWKJ.V/1yeGdr3X4i0IGVuWIsfFdI5LC2Gp6',NULL,NULL,NULL,'2022-01-20 05:37:52','2022-01-20 05:39:23'),(4,'Chairman',NULL,'plantchairman','01986775654','chairman@mail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,2,1,0,0,3,0,1,1,1,NULL,'$2y$10$ATvuu8CMMhUBgnlP36KEqeMY69zMqLXvBs5ZotvF2YNj8esrkbPU.',NULL,NULL,NULL,'2022-01-20 05:39:08','2022-01-20 05:39:08'),(5,'Field Officer',NULL,'fieldofficer','01787667657','officer@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,2,1,0,0,4,0,1,1,1,NULL,'$2y$10$1bl1v0yr5Dbvgi1S9zdokOvDiCjJlZQCf368BiYZAYmR2.sI5XqWG',NULL,NULL,NULL,'2022-01-20 05:40:42','2022-01-20 05:40:42');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle_categories`
--

DROP TABLE IF EXISTS `vehicle_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vehicle_category_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vehicle_categories_vehicle_category_name_unique` (`vehicle_category_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_categories`
--

LOCK TABLES `vehicle_categories` WRITE;
/*!40000 ALTER TABLE `vehicle_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `vehicle_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `model_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vat_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `system_id` bigint unsigned NOT NULL DEFAULT '0',
  `vehicle_category_id` bigint unsigned NOT NULL DEFAULT '0',
  `processing_plant_id` bigint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicles_vehicle_category_id_foreign` (`vehicle_category_id`),
  KEY `vehicles_processing_plant_id_foreign` (`processing_plant_id`),
  CONSTRAINT `vehicles_processing_plant_id_foreign` FOREIGN KEY (`processing_plant_id`) REFERENCES `processing_plants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `vehicles_vehicle_category_id_foreign` FOREIGN KEY (`vehicle_category_id`) REFERENCES `vehicle_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicles`
--

LOCK TABLES `vehicles` WRITE;
/*!40000 ALTER TABLE `vehicles` DISABLE KEYS */;
/*!40000 ALTER TABLE `vehicles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-20 17:55:38
