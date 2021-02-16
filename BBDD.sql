CREATE DATABASE  IF NOT EXISTS `sweethome` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `sweethome`;
-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: localhost    Database: sweethome
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.30-MariaDB

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
-- Table structure for table `attempts`
--

DROP TABLE IF EXISTS `attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(39) NOT NULL,
  `expirydate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attempts`
--

LOCK TABLES `attempts` WRITE;
/*!40000 ALTER TABLE `attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `casas`
--

DROP TABLE IF EXISTS `casas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `casas` (
  `casa_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `casa_name` varchar(150) DEFAULT NULL,
  `casa_img` varchar(200) DEFAULT NULL,
  `casa_desc` text,
  `casa_ubication` text,
  `casa_score` int(11) NOT NULL DEFAULT '0',
  `casa_owner` int(11) unsigned NOT NULL,
  `casa_active` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`casa_id`,`casa_owner`),
  KEY `ibfk1_idx` (`casa_owner`),
  CONSTRAINT `ibfk1` FOREIGN KEY (`casa_owner`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `casas`
--

LOCK TABLES `casas` WRITE;
/*!40000 ALTER TABLE `casas` DISABLE KEYS */;
INSERT INTO `casas` VALUES (4,'TITULO_PRUEBA2','img/4jC9L6sVz661t56F3a6T.jpg','DESCRIPCION_PRUEBA','http://google',4,3,1),(5,'Casa Cortes de Pino','img/4p4FeWDR2A42g28A3505.jpg','Casa rural de Palencia rodeada de pinos','https://goo.gl/maps/saddssadadsdasas',11,8,1);
/*!40000 ALTER TABLE `casas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preguntas`
--

DROP TABLE IF EXISTS `preguntas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preguntas` (
  `pregunta_id` int(11) NOT NULL AUTO_INCREMENT,
  `pregunta_uid` int(11) NOT NULL,
  `pregunta_casa` int(11) unsigned NOT NULL,
  `pregunta_texto` text NOT NULL,
  `pregunta_opcional_nombre` varchar(90) DEFAULT NULL,
  `pregunta_opcional_email` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`pregunta_id`),
  KEY `ibfk_casa_idx` (`pregunta_casa`),
  KEY `fk_casa_idx` (`pregunta_casa`),
  CONSTRAINT `fk_casa` FOREIGN KEY (`pregunta_casa`) REFERENCES `casas` (`casa_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preguntas`
--

LOCK TABLES `preguntas` WRITE;
/*!40000 ALTER TABLE `preguntas` DISABLE KEYS */;
INSERT INTO `preguntas` VALUES (14,3,5,'prueba3','prueba1','prueba2@test'),(15,3,5,'holaa','Usuario #3','admin2@yahoo.es');
/*!40000 ALTER TABLE `preguntas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requests` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL,
  `rkey` varchar(20) NOT NULL,
  `expire` datetime NOT NULL,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requests`
--

LOCK TABLES `requests` WRITE;
/*!40000 ALTER TABLE `requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL,
  `hash` varchar(40) NOT NULL,
  `expiredate` datetime NOT NULL,
  `ip` varchar(39) NOT NULL,
  `agent` varchar(200) NOT NULL,
  `cookie_crc` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES (1,1,'a903f65f4354ea46d5b0d86c7d81638e1759c52e','2019-05-08 11:31:34','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36','130bb6178fd18f45dbc6cf7ea335e145c41d7517'),(2,1,'ffdacff7bdb15862f63c4eca074f9289aaffed11','2019-05-08 11:35:19','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36','933451251cc1461ddbb05c6664439aa71810b821'),(3,1,'cedca7ff44b63f815bc9e1bda7b25f036869f3c5','2019-05-08 11:35:31','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36','218413963a4ad387f95c308abca93021e1950186'),(4,4,'9945cdde1d4f9908dff3e01553cc0fed07b6247b','2019-05-08 11:56:33','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36','2174e9e0cda6b52f275327110a9dc8f6cbb558b2'),(5,5,'55b95199763f0530d4274b1042722d069d8fc387','2019-05-08 12:20:13','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36','3326c8ec045d406e69707753f47418f3c1fa9ca6'),(6,6,'e4b718c359003cd8684435ca6a35c9e970f68688','2019-05-08 15:32:53','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36','52b8bbac593d045a81c00697fe6ff0c70a9bee12'),(7,3,'a3cb124328e90f8b453b0fbd3ad2edd3f3e11968','2019-05-08 15:38:53','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36','3bc0ceed697ac53fa2ac3d7f9a5424b061cf04f4'),(8,3,'f983f41d1c7e127659f1e34c20f4986d05131dcd','2019-05-08 15:41:01','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36','19fc2d718d39a3810bbbc3d1e4112128865e63f0'),(17,1,'0dee87b21dc2b0746ded07efca099f96dd45c7d6','2018-05-09 10:41:28','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36','fa0019cdd3b59f019e90578197cf13b13468d306'),(19,1,'da9546e1fafe534a1245ff65538967ebce938442','2018-05-09 12:03:20','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36','e68dd6dccdef12e315a326f371fb7a09c353bdd5');
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `isactive` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT NULL,
  `is_owner` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin@yahoo.es','$2y$11$9p5BgdM6hJZcc3t0kbNCHeUkeNVCKmtMwazsW1/WqMnv1pwyYkmf6',1,'2018-05-08 09:46:42','2018-05-09 11:33:20',0),(3,'admin2@yahoo.es','$2y$11$SBhYQNdvRXnVNLH5KKxb1uxBdnMVUqQhChe.7dKcFaCDPTMyKZnJa',1,'2018-05-08 10:51:29','2018-05-09 11:32:12',1),(4,'prueba_login@yahoo.es','$2y$11$BuSFqH1NLP/Yrq6PTNAlaOGCaVwtVo.Mgv8wvU/9wDwjYzL6TWfS6',1,'2018-05-08 10:56:33','2018-05-08 11:56:33',0),(5,'test44@yahoo.es','$2y$11$/.2MSpDulR9QbwYuc1r3jelmK7CNWPu/gKp0BiUjXk8mibz6M/zKO',1,'2018-05-08 11:20:13','2018-05-08 12:20:14',0),(6,'test@test.net','$2y$11$yKWbch1JG2Fq/hK/x8YsZO91fQ4ruxws2TpuNkOtaWTHZoSJBTYv2',1,'2018-05-08 14:32:53','2018-05-08 15:32:53',0),(7,'prueba3@yahoo.es','$2y$11$iHLIJ.p2QKfklIkJ817Pr.6cyCsacXXkj9I.W.YyuUgFB2gfcia1S',1,'2018-05-09 08:08:40','2018-05-09 09:09:01',0),(8,'prueba5@yahoo.es','$2y$11$r6Vb9WR0CKVbtQqKUfPdTu.RYz7/ICKmKDe9BOQNcywob6PdV5zfa',1,'2018-05-09 08:09:22','2018-05-09 09:09:22',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `votos`
--

DROP TABLE IF EXISTS `votos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `votos` (
  `user_id` int(11) unsigned NOT NULL,
  `casa_id` int(11) unsigned NOT NULL,
  `votos` int(1) NOT NULL,
  KEY `ibfk_casa_idx` (`casa_id`),
  KEY `ibfk_user_idx` (`user_id`),
  CONSTRAINT `ibfk_casa` FOREIGN KEY (`casa_id`) REFERENCES `casas` (`casa_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `ibfk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `votos`
--

LOCK TABLES `votos` WRITE;
/*!40000 ALTER TABLE `votos` DISABLE KEYS */;
INSERT INTO `votos` VALUES (1,5,5),(3,5,5);
/*!40000 ALTER TABLE `votos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'sweethome'
--

--
-- Dumping routines for database 'sweethome'
--
/*!50003 DROP PROCEDURE IF EXISTS `add_vote` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_vote`(insert_uid INT, insert_cid INT,insert_vote INT)
BEGIN
	DECLARE res INT;
    SELECT votos INTO res FROM votos WHERE `votos`.`user_id` = insert_uid AND `votos`.`casa_id` = insert_cid;
    IF res IS NULL THEN 
		INSERT INTO votos VALUES (insert_uid,insert_cid,insert_vote);
		UPDATE casas SET casa_score = casa_score+insert_vote WHERE casa_id = insert_cid;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `del_vote` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `del_vote`(delete_uid INT, delete_cid INT)
BEGIN
DECLARE res INT;
    SELECT votos INTO res FROM votos WHERE `votos`.`user_id` = delete_uid AND `votos`.`casa_id` = delete_cid;
    IF res IS NOT NULL THEN 
		DELETE FROM votos WHERE user_id = delete_uid AND casa_id = delete_cid;
		UPDATE casas SET casa_score = casa_score-res WHERE casa_id = delete_cid;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-09 13:15:37
