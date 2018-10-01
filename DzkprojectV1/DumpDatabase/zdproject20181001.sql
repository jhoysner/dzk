-- MySQL dump 10.13  Distrib 5.7.23, for Linux (x86_64)
--
-- Host: 172.17.0.2    Database: dzkproject
-- ------------------------------------------------------
-- Server version	5.7.23-0ubuntu0.18.04.1-log

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
-- Table structure for table `branch`
--

DROP TABLE IF EXISTS `branch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `branch` (
  `idbranch` varchar(36) NOT NULL,
  `name` varchar(128) NOT NULL,
  `address` varchar(256) NOT NULL,
  `schedule` varchar(512) NOT NULL,
  `phone1` varchar(20) NOT NULL,
  `phone2` varchar(20) DEFAULT NULL,
  `image` varchar(512) DEFAULT NULL,
  `latitude` varchar(20) DEFAULT NULL,
  `longitude` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `commerce_idcommerce` varchar(36) NOT NULL,
  `country_idcountry` varchar(36) NOT NULL,
  `state_idstate` varchar(36) NOT NULL,
  `city_idcity` varchar(36) NOT NULL,
  PRIMARY KEY (`idbranch`),
  UNIQUE KEY `idbranch_UNIQUE` (`idbranch`),
  KEY `fk_branch_commerce1_idx` (`commerce_idcommerce`),
  KEY `fk_branch_country1_idx` (`country_idcountry`),
  KEY `fk_branch_state1_idx` (`state_idstate`),
  KEY `fk_branch_city1_idx` (`city_idcity`),
  CONSTRAINT `fk_branch_city1` FOREIGN KEY (`city_idcity`) REFERENCES `city` (`idcity`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_branch_commerce1` FOREIGN KEY (`commerce_idcommerce`) REFERENCES `commerce` (`idcommerce`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_branch_country1` FOREIGN KEY (`country_idcountry`) REFERENCES `country` (`idcountry`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_branch_state1` FOREIGN KEY (`state_idstate`) REFERENCES `state` (`idstate`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `branch`
--

LOCK TABLES `branch` WRITE;
/*!40000 ALTER TABLE `branch` DISABLE KEYS */;
/*!40000 ALTER TABLE `branch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `branch_has_discount`
--

DROP TABLE IF EXISTS `branch_has_discount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `branch_has_discount` (
  `idbranch_has_discount` varchar(36) NOT NULL,
  `discounthours` text,
  `amountapproved` int(11) DEFAULT NULL,
  `amountavailable` int(11) DEFAULT NULL,
  `amountredeemed` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `branch_idbranch` varchar(36) NOT NULL,
  `discount_iddiscount` varchar(36) NOT NULL,
  PRIMARY KEY (`idbranch_has_discount`,`branch_idbranch`,`discount_iddiscount`),
  UNIQUE KEY `idbranch_has_discount_UNIQUE` (`idbranch_has_discount`),
  KEY `fk_branch_has_discount_discount1_idx` (`discount_iddiscount`),
  KEY `fk_branch_has_discount_branch1_idx` (`branch_idbranch`),
  CONSTRAINT `fk_branch_has_discount_branch1` FOREIGN KEY (`branch_idbranch`) REFERENCES `branch` (`idbranch`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_branch_has_discount_discount1` FOREIGN KEY (`discount_iddiscount`) REFERENCES `discount` (`iddiscount`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `branch_has_discount`
--

LOCK TABLES `branch_has_discount` WRITE;
/*!40000 ALTER TABLE `branch_has_discount` DISABLE KEYS */;
/*!40000 ALTER TABLE `branch_has_discount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city` (
  `idcity` varchar(36) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `country_idcountry` varchar(36) NOT NULL,
  `state_idstate` varchar(36) NOT NULL,
  PRIMARY KEY (`idcity`),
  UNIQUE KEY `idcity_UNIQUE` (`idcity`),
  KEY `fk_city_country1_idx` (`country_idcountry`),
  KEY `fk_city_state1_idx` (`state_idstate`),
  CONSTRAINT `fk_city_country1` FOREIGN KEY (`country_idcountry`) REFERENCES `country` (`idcountry`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_city_state1` FOREIGN KEY (`state_idstate`) REFERENCES `state` (`idstate`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `city`
--

LOCK TABLES `city` WRITE;
/*!40000 ALTER TABLE `city` DISABLE KEYS */;
/*!40000 ALTER TABLE `city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commerce`
--

DROP TABLE IF EXISTS `commerce`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commerce` (
  `idcommerce` varchar(36) NOT NULL,
  `name` varchar(128) NOT NULL,
  `phone1` varchar(20) NOT NULL,
  `phone2` varchar(20) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `image` varchar(512) DEFAULT NULL,
  `web` varchar(128) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `country_idcountry` varchar(36) NOT NULL,
  `state_idstate` varchar(36) NOT NULL,
  `city_idcity` varchar(36) NOT NULL,
  `commercecategory_idcommercecategory` varchar(36) NOT NULL,
  PRIMARY KEY (`idcommerce`),
  UNIQUE KEY `idcommerce_UNIQUE` (`idcommerce`),
  KEY `fk_commerce_country1_idx` (`country_idcountry`),
  KEY `fk_commerce_state1_idx` (`state_idstate`),
  KEY `fk_commerce_city1_idx` (`city_idcity`),
  KEY `fk_commerce_commercecategory1_idx` (`commercecategory_idcommercecategory`),
  CONSTRAINT `fk_commerce_city1` FOREIGN KEY (`city_idcity`) REFERENCES `city` (`idcity`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_commerce_commercecategory1` FOREIGN KEY (`commercecategory_idcommercecategory`) REFERENCES `commercecategory` (`idcommercecategory`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_commerce_country1` FOREIGN KEY (`country_idcountry`) REFERENCES `country` (`idcountry`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_commerce_state1` FOREIGN KEY (`state_idstate`) REFERENCES `state` (`idstate`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commerce`
--

LOCK TABLES `commerce` WRITE;
/*!40000 ALTER TABLE `commerce` DISABLE KEYS */;
/*!40000 ALTER TABLE `commerce` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commerce_has_tags`
--

DROP TABLE IF EXISTS `commerce_has_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commerce_has_tags` (
  `commerce_idcommerce` varchar(36) NOT NULL,
  `tags_idtags` varchar(36) NOT NULL,
  PRIMARY KEY (`commerce_idcommerce`,`tags_idtags`),
  KEY `fk_commerce_has_tags_tags1_idx` (`tags_idtags`),
  KEY `fk_commerce_has_tags_commerce1_idx` (`commerce_idcommerce`),
  CONSTRAINT `fk_commerce_has_tags_commerce1` FOREIGN KEY (`commerce_idcommerce`) REFERENCES `commerce` (`idcommerce`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_commerce_has_tags_tags1` FOREIGN KEY (`tags_idtags`) REFERENCES `tags` (`idtags`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commerce_has_tags`
--

LOCK TABLES `commerce_has_tags` WRITE;
/*!40000 ALTER TABLE `commerce_has_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `commerce_has_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `idcountry` varchar(36) NOT NULL,
  `name` varchar(45) NOT NULL,
  `isocode` varchar(5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idcountry`),
  UNIQUE KEY `idcountry_UNIQUE` (`idcountry`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discount`
--

DROP TABLE IF EXISTS `discount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount` (
  `iddiscount` varchar(36) NOT NULL,
  `title` varchar(128) NOT NULL,
  `description` varchar(512) NOT NULL,
  `image` varchar(512) DEFAULT NULL,
  `startdate` timestamp NULL DEFAULT NULL,
  `enddate` timestamp NULL DEFAULT NULL,
  `outstanding` tinyint(1) NOT NULL DEFAULT '0',
  `conditions` text,
  `restrictions` text,
  `amountapproved` int(11) DEFAULT NULL,
  `amountavailable` int(11) DEFAULT NULL,
  `amountredeemed` int(11) NOT NULL DEFAULT '0',
  `normalprice` decimal(10,2) NOT NULL,
  `discountprice` decimal(10,2) NOT NULL,
  `discountpercentage` float NOT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `updated_at` varchar(45) DEFAULT NULL,
  `deleted_at` varchar(45) DEFAULT NULL,
  `discountcategory_iddiscountcategory` varchar(36) NOT NULL,
  PRIMARY KEY (`iddiscount`),
  UNIQUE KEY `iddiscount_UNIQUE` (`iddiscount`),
  KEY `fk_discount_discountcategory1_idx` (`discountcategory_iddiscountcategory`),
  CONSTRAINT `fk_discount_discountcategory1` FOREIGN KEY (`discountcategory_iddiscountcategory`) REFERENCES `discountcategory` (`iddiscountcategory`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discount`
--

LOCK TABLES `discount` WRITE;
/*!40000 ALTER TABLE `discount` DISABLE KEYS */;
/*!40000 ALTER TABLE `discount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discount_has_tags`
--

DROP TABLE IF EXISTS `discount_has_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount_has_tags` (
  `discount_iddiscount` varchar(36) NOT NULL,
  `tags_idtags` varchar(36) NOT NULL,
  PRIMARY KEY (`discount_iddiscount`,`tags_idtags`),
  KEY `fk_discount_has_tags_tags1_idx` (`tags_idtags`),
  KEY `fk_discount_has_tags_discount1_idx` (`discount_iddiscount`),
  CONSTRAINT `fk_discount_has_tags_discount1` FOREIGN KEY (`discount_iddiscount`) REFERENCES `discount` (`iddiscount`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_discount_has_tags_tags1` FOREIGN KEY (`tags_idtags`) REFERENCES `tags` (`idtags`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discount_has_tags`
--

LOCK TABLES `discount_has_tags` WRITE;
/*!40000 ALTER TABLE `discount_has_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `discount_has_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discountcategory`
--

DROP TABLE IF EXISTS `discountcategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discountcategory` (
  `iddiscountcategory` varchar(36) NOT NULL,
  `name` varchar(45) NOT NULL,
  `image` varchar(512) DEFAULT NULL,
  `icon` varchar(512) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`iddiscountcategory`),
  UNIQUE KEY `iddiscountcategory_UNIQUE` (`iddiscountcategory`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discountcategory`
--

LOCK TABLES `discountcategory` WRITE;
/*!40000 ALTER TABLE `discountcategory` DISABLE KEYS */;
/*!40000 ALTER TABLE `discountcategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2018_09_25_231613_create_permission_tables',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` varchar(36) NOT NULL,
  PRIMARY KEY (`permission_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_type`),
  KEY `fk_model_has_permissions_users1_idx` (`model_id`),
  CONSTRAINT `fk_model_has_permissions_users1` FOREIGN KEY (`model_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` varchar(36) NOT NULL,
  PRIMARY KEY (`role_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_type`),
  KEY `fk_model_has_roles_users1_idx` (`model_id`),
  CONSTRAINT `fk_model_has_roles_users1` FOREIGN KEY (`model_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `params`
--

DROP TABLE IF EXISTS `params`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `params` (
  `idparams` varchar(36) NOT NULL,
  `key` varchar(45) NOT NULL,
  `val` varchar(512) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idparams`),
  UNIQUE KEY `idparams_UNIQUE` (`idparams`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `params`
--

LOCK TABLES `params` WRITE;
/*!40000 ALTER TABLE `params` DISABLE KEYS */;
/*!40000 ALTER TABLE `params` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `state`
--

DROP TABLE IF EXISTS `state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `state` (
  `idstate` varchar(36) NOT NULL,
  `name` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `country_idcountry` varchar(36) NOT NULL,
  PRIMARY KEY (`idstate`),
  UNIQUE KEY `idstate_UNIQUE` (`idstate`),
  KEY `fk_state_country1_idx` (`country_idcountry`),
  CONSTRAINT `fk_state_country1` FOREIGN KEY (`country_idcountry`) REFERENCES `country` (`idcountry`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `state`
--

LOCK TABLES `state` WRITE;
/*!40000 ALTER TABLE `state` DISABLE KEYS */;
/*!40000 ALTER TABLE `state` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `idtags` varchar(36) NOT NULL,
  `name` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idtags`),
  UNIQUE KEY `idtags_UNIQUE` (`idtags`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` varchar(36) CHARACTER SET utf8 NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middlename` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `lastname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `birthday` date DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(512) CHARACTER SET utf8 DEFAULT NULL,
  `latitude` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `longitude` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `provider` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `provider_id` text CHARACTER SET utf8,
  `access_token` text CHARACTER SET utf8,
  `lastlogin` timestamp NULL DEFAULT NULL,
  `attempts` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `city_idcity` varchar(36) CHARACTER SET utf8 NOT NULL,
  `state_idstate` varchar(36) CHARACTER SET utf8 NOT NULL,
  `country_idcountry` varchar(36) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_users_city1_idx` (`city_idcity`),
  KEY `fk_users_state1_idx` (`state_idstate`),
  KEY `fk_users_country1_idx` (`country_idcountry`),
  CONSTRAINT `fk_users_city1` FOREIGN KEY (`city_idcity`) REFERENCES `city` (`idcity`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_country1` FOREIGN KEY (`country_idcountry`) REFERENCES `country` (`idcountry`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_state1` FOREIGN KEY (`state_idstate`) REFERENCES `state` (`idstate`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_has_commerce`
--

DROP TABLE IF EXISTS `users_has_commerce`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_has_commerce` (
  `idusers_has_commerce` varchar(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `users_id` varchar(36) NOT NULL,
  `commerce_idcommerce` varchar(36) NOT NULL,
  PRIMARY KEY (`idusers_has_commerce`),
  UNIQUE KEY `idusers_has_commerce_UNIQUE` (`idusers_has_commerce`),
  KEY `fk_users_has_commerce_commerce1_idx` (`commerce_idcommerce`),
  KEY `fk_users_has_commerce_users1_idx` (`users_id`),
  CONSTRAINT `fk_users_has_commerce_commerce1` FOREIGN KEY (`commerce_idcommerce`) REFERENCES `commerce` (`idcommerce`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_commerce_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_has_commerce`
--

LOCK TABLES `users_has_commerce` WRITE;
/*!40000 ALTER TABLE `users_has_commerce` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_has_commerce` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'dzkproject'
--

--
-- Dumping routines for database 'dzkproject'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-10-01  9:14:10
