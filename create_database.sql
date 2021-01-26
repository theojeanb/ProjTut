-- MariaDB dump 10.17  Distrib 10.4.14-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: projtut
-- ------------------------------------------------------
-- Server version	10.4.14-MariaDB

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
-- Table structure for table `arme`
--

DROP TABLE IF EXISTS `arme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `arme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `degats` int(11) NOT NULL,
  `rarete` int(11) NOT NULL,
  `sprite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prix` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `arme`
--

LOCK TABLES `arme` WRITE;
/*!40000 ALTER TABLE `arme` DISABLE KEYS */;
INSERT INTO `arme` VALUES (5,'Master Sword',300,4,'epee.png',999),(6,'Masamune',200,3,'',666),(7,'Buster Sword',200,3,'epeeEnchant.png',555),(8,'Monado',100,2,'',50);
/*!40000 ALTER TABLE `arme` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `armure`
--

DROP TABLE IF EXISTS `armure`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `armure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `defense` int(11) NOT NULL,
  `rarete` int(11) NOT NULL,
  `sprite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prix` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4ADFC535C54C8C93` (`type_id`),
  CONSTRAINT `FK_4ADFC535C54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `armure`
--

LOCK TABLES `armure` WRITE;
/*!40000 ALTER TABLE `armure` DISABLE KEYS */;
INSERT INTO `armure` VALUES (5,5,'Thunder Helmet',10,2,'casque.png',120),(6,6,'Magic Armor',500,4,'plastronR.png',90),(7,7,'SPEEEED',50,3,'jambières.png',95),(8,8,'Crocs',30,1,'botte.png',60);
/*!40000 ALTER TABLE `armure` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ennemi`
--

DROP TABLE IF EXISTS `ennemi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ennemi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `arme_id` int(11) DEFAULT NULL,
  `armure_id` int(11) DEFAULT NULL,
  `potion_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `degats` int(11) NOT NULL,
  `pv` int(11) NOT NULL,
  `sprite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BE21B38B21D9C0A` (`arme_id`),
  KEY `IDX_BE21B38BE4000E4F` (`armure_id`),
  KEY `IDX_BE21B38B7126B348` (`potion_id`),
  CONSTRAINT `FK_BE21B38B21D9C0A` FOREIGN KEY (`arme_id`) REFERENCES `arme` (`id`),
  CONSTRAINT `FK_BE21B38B7126B348` FOREIGN KEY (`potion_id`) REFERENCES `potion` (`id`),
  CONSTRAINT `FK_BE21B38BE4000E4F` FOREIGN KEY (`armure_id`) REFERENCES `armure` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ennemi`
--

LOCK TABLES `ennemi` WRITE;
/*!40000 ALTER TABLE `ennemi` DISABLE KEYS */;
INSERT INTO `ennemi` VALUES (5,NULL,NULL,NULL,'Gobelin',10,5,''),(6,NULL,NULL,NULL,'Koopa',20,10,''),(7,NULL,NULL,NULL,'Sephiroth',100,3000,''),(8,NULL,NULL,NULL,'NOAH',30000,99999,'noah.png');
/*!40000 ALTER TABLE `ennemi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventaire`
--

DROP TABLE IF EXISTS `inventaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `joueur_id` int(11) DEFAULT NULL,
  `arme_id` int(11) DEFAULT NULL,
  `armure_id` int(11) DEFAULT NULL,
  `potion_id` int(11) DEFAULT NULL,
  `est_equipe` tinyint(1) NOT NULL,
  `x` int(11) DEFAULT NULL,
  `y` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_338920E0A9E2D76C` (`joueur_id`),
  KEY `IDX_338920E021D9C0A` (`arme_id`),
  KEY `IDX_338920E0E4000E4F` (`armure_id`),
  KEY `IDX_338920E07126B348` (`potion_id`),
  CONSTRAINT `FK_338920E021D9C0A` FOREIGN KEY (`arme_id`) REFERENCES `arme` (`id`),
  CONSTRAINT `FK_338920E07126B348` FOREIGN KEY (`potion_id`) REFERENCES `potion` (`id`),
  CONSTRAINT `FK_338920E0A9E2D76C` FOREIGN KEY (`joueur_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_338920E0E4000E4F` FOREIGN KEY (`armure_id`) REFERENCES `armure` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventaire`
--

LOCK TABLES `inventaire` WRITE;
/*!40000 ALTER TABLE `inventaire` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `potion`
--

DROP TABLE IF EXISTS `potion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `potion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `effet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valeur` int(11) NOT NULL,
  `rarete` int(11) NOT NULL,
  `sprite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prix` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `potion`
--

LOCK TABLES `potion` WRITE;
/*!40000 ALTER TABLE `potion` DISABLE KEYS */;
INSERT INTO `potion` VALUES (5,'Potion de rapidité','SPEED',50,3,'potion.png',45),(6,'Potion de force','STRENGTH',50,3,'potion.png',85),(7,'Potion de régénération','HP',30,3,'potion.png',60),(8,'Potion de renforcement','HPMAX',5,3,'potionV.png',50);
/*!40000 ALTER TABLE `potion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type`
--

DROP TABLE IF EXISTS `type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type`
--

LOCK TABLES `type` WRITE;
/*!40000 ALTER TABLE `type` DISABLE KEYS */;
INSERT INTO `type` VALUES (5,'Casque'),(6,'Plastron'),(7,'Jambières'),(8,'Chaussures');
/*!40000 ALTER TABLE `type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attaque` int(11) NOT NULL,
  `defense` int(11) NOT NULL,
  `argent` int(11) NOT NULL,
  `pv_max` int(11) NOT NULL,
  `niveau` int(11) NOT NULL,
  `experience` int(11) NOT NULL,
  `pv` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (3,'admin','admin','[\"ROLE_ADMIN\"]','$argon2id$v=19$m=65536,t=4,p=1$MFNLT2VsLkdFLlVBWGdyWQ$gAGANllvjr48fIiylo8XNJA8fIvcNs48khcTTC5bY54',10,10,0,100,1,0,100),(4,'user','user','[\"ROLE_USER\"]','$argon2id$v=19$m=65536,t=4,p=1$VmMxQUFDVGtFVGRvMzU2aA$sCi/+xByJ1HFJQb4v37ENdASJix55LOoKULNjO4TTD4',10,10,0,100,1,0,100);
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

-- Dump completed on 2021-01-15 14:41:20
