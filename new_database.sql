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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `arme`
--

LOCK TABLES `arme` WRITE;
/*!40000 ALTER TABLE `arme` DISABLE KEYS */;
INSERT INTO `arme` VALUES (17,'Master Sword',300,4,'epee.png',999),(18,'Masamune',200,3,'masamune.png',666),(19,'Buster Sword',200,3,'epeeEnchant.png',555),(20,'Monado',100,2,'monado.png',50);
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `armure`
--

LOCK TABLES `armure` WRITE;
/*!40000 ALTER TABLE `armure` DISABLE KEYS */;
INSERT INTO `armure` VALUES (17,17,'Thunder Helmet',10,2,'casque.png',120),(18,18,'Magic Armor',500,4,'plastronR.png',90),(19,19,'SPEEEED',50,3,'jambières.png',95),(20,20,'Crocs',30,1,'botte.png',60);
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ennemi`
--

LOCK TABLES `ennemi` WRITE;
/*!40000 ALTER TABLE `ennemi` DISABLE KEYS */;
INSERT INTO `ennemi` VALUES (17,NULL,NULL,NULL,'Gobelin',10,5,''),(18,NULL,NULL,NULL,'Koopa',20,10,''),(19,NULL,NULL,NULL,'Sephiroth',100,3000,''),(20,NULL,NULL,NULL,'NOAH',30000,99999,'noah.png');
/*!40000 ALTER TABLE `ennemi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipement`
--

DROP TABLE IF EXISTS `equipement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `arme_id` int(11) DEFAULT NULL,
  `casque_id` int(11) DEFAULT NULL,
  `plastron_id` int(11) DEFAULT NULL,
  `jambieres_id` int(11) DEFAULT NULL,
  `bottes_id` int(11) DEFAULT NULL,
  `potion_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B8B4C6F321D9C0A` (`arme_id`),
  UNIQUE KEY `UNIQ_B8B4C6F326926994` (`casque_id`),
  UNIQUE KEY `UNIQ_B8B4C6F330EF2009` (`plastron_id`),
  UNIQUE KEY `UNIQ_B8B4C6F39FFEB269` (`jambieres_id`),
  UNIQUE KEY `UNIQ_B8B4C6F3A49B5F19` (`bottes_id`),
  UNIQUE KEY `UNIQ_B8B4C6F37126B348` (`potion_id`),
  UNIQUE KEY `UNIQ_B8B4C6F3A76ED395` (`user_id`),
  CONSTRAINT `FK_B8B4C6F321D9C0A` FOREIGN KEY (`arme_id`) REFERENCES `inventaire` (`id`),
  CONSTRAINT `FK_B8B4C6F326926994` FOREIGN KEY (`casque_id`) REFERENCES `inventaire` (`id`),
  CONSTRAINT `FK_B8B4C6F330EF2009` FOREIGN KEY (`plastron_id`) REFERENCES `inventaire` (`id`),
  CONSTRAINT `FK_B8B4C6F37126B348` FOREIGN KEY (`potion_id`) REFERENCES `inventaire` (`id`),
  CONSTRAINT `FK_B8B4C6F39FFEB269` FOREIGN KEY (`jambieres_id`) REFERENCES `inventaire` (`id`),
  CONSTRAINT `FK_B8B4C6F3A49B5F19` FOREIGN KEY (`bottes_id`) REFERENCES `inventaire` (`id`),
  CONSTRAINT `FK_B8B4C6F3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `inventaire` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipement`
--

LOCK TABLES `equipement` WRITE;
/*!40000 ALTER TABLE `equipement` DISABLE KEYS */;
/*!40000 ALTER TABLE `equipement` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventaire`
--

LOCK TABLES `inventaire` WRITE;
/*!40000 ALTER TABLE `inventaire` DISABLE KEYS */;
INSERT INTO `inventaire` VALUES (6,NULL,20,NULL,NULL,NULL,NULL),(7,10,NULL,NULL,17,NULL,NULL),(8,10,20,NULL,NULL,NULL,NULL);
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
  `x` int(11) DEFAULT NULL,
  `y` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `potion`
--

LOCK TABLES `potion` WRITE;
/*!40000 ALTER TABLE `potion` DISABLE KEYS */;
INSERT INTO `potion` VALUES (17,'Potion de rapidité','SPEED',50,3,'potionRapidite.png',45,NULL,NULL),(18,'Potion de force','STRENGTH',50,3,'potionForce.png',85,NULL,NULL),(19,'Potion de régénération','HP',30,3,'potion.png',60,NULL,NULL),(20,'Potion de renforcement','HPMAX',5,3,'potionV.png',50,NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type`
--

LOCK TABLES `type` WRITE;
/*!40000 ALTER TABLE `type` DISABLE KEYS */;
INSERT INTO `type` VALUES (17,'Casque'),(18,'Plastron'),(19,'Jambières'),(20,'Chaussures');
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (9,'admin','admin','[\"ROLE_ADMIN\"]','$argon2id$v=19$m=65536,t=4,p=1$dWhpNmZrbmMwNmJUOXV4Tw$IHrB/BJHJEvFgV0hUaDIbVVY+ATfWPexSDvx0x05yH8',10,10,1000,100,1,0,100),(10,'user','user','[\"ROLE_USER\"]','$argon2id$v=19$m=65536,t=4,p=1$bXNWRmVxSU45YXhCTjlTVw$rmLD2X134Hc6E82aP61y+wFAlpCdTbcCRPCuF7Q9Ois',10,10,955,100,1,0,100);
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

-- Dump completed on 2021-03-29 14:03:04
