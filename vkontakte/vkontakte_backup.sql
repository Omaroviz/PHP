-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: vkontakte
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
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(5000) DEFAULT NULL,
  `text` text DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `author_id` int(11) DEFAULT NULL,
  `post_from` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (21,'Привет','ВКонтакте Druza на PHP работает!','admin','2026-06-24 15:34:12',NULL,NULL),(26,'','TWlrdSBIYXRzdW5l? ','admin','2026-06-24 16:18:32',NULL,NULL),(27,'','dw','admin','2026-06-24 16:26:36',NULL,NULL),(28,'ВКонтакте 2007','Привет','omaroviz','2026-06-25 04:16:15',NULL,NULL),(29,'SELECT * FROM users','SELECT * FROM users','admin','2026-06-25 05:28:34',NULL,NULL),(30,'длвущшатдатштдлвыфашуоаш','вовшвцйощшауаоашцйош','omaroviz','2026-06-25 10:29:09',NULL,NULL),(34,'тест','test','admin','2026-06-25 10:55:30',NULL,NULL),(35,'xsas','xss','kolbasenko','2026-06-25 13:22:23',7,NULL),(36,'Новая запись','ВКотакте\r\n','puzalat','2026-06-25 15:36:37',2,NULL),(37,'Заголовок','Что у вас нового?','puzalat','2026-06-25 16:29:56',2,NULL),(38,'','?','puzalat','2026-06-25 16:31:12',2,NULL),(39,'Base','KRLWY4TEKNBESWKYKJ5GIVZVNQ7Q====','puzalat','2026-06-25 17:04:26',2,NULL),(43,'','<button>Text</button>','<button>userame</button>','2026-06-27 08:55:48',8,NULL),(44,'привет','всем','durov','2026-06-27 10:31:02',9,NULL),(45,'Это тест','base64','durov','2026-06-27 11:35:56',9,'general');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin','$2y$10$ZRBuRh0uPGLgDdSFdGCBMeQEIXcJbsGP2LvdsBiTbmtwvcb75sQqC'),(2,'Puzalat','puzalat','$2y$10$vSd.WMzc382jbZaDTKGooeZviXRys8.NQ0yT8pAMa2X.hydDoh4.a'),(3,'name','username','$2y$10$7yiQExzsbB3Q31Rzzjmicuuk9oGNApV7oaMg0GZRGyGBuX40EcOk6'),(4,'','','$2y$10$LhXNwwkjNrurCZBcNT3CSepDjq0JKuvMe//opQ4VN8zXY.qpYYqjW'),(5,'Omaroviz','omaroviz','$2y$10$rl4Do.GlFFx8untLtIkeK.4g0czrZ7OnSPSAkBgZbvy6LX1dmA45W'),(6,'Test','test','$2y$10$CPw0EdDnAK3lHdy3tDGIBuDMAknXLTmxXI24dYbk6P4FCPLYoW8/y'),(7,'Kolbasenko','kolbasenko','$2y$10$rmhxfEhozb7OlmKMXM7g3OrtL6Wv3u.NQ3lU5cQupB41OKhL91hjG'),(8,'<button>Name</button>','<button>userame</button>','$2y$10$4qcDacDf2SbiYcjom0ujteILm8Oq5weks9VqYRJaESbVkuEoi8aHu'),(9,'Павел Дуров','durov','$2y$10$7i8CbAW.nnExPSub5p9pzeHF0r/ljX47n0t5RR4H5OU/Nw2L6tnDO');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_info`
--

DROP TABLE IF EXISTS `users_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_info` (
  `id` int(11) unsigned NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `age` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_info`
--

LOCK TABLES `users_info` WRITE;
/*!40000 ALTER TABLE `users_info` DISABLE KEYS */;
INSERT INTO `users_info` VALUES (1,'Москва','Админ сайта',20),(2,'Minsk',NULL,NULL),(3,NULL,NULL,NULL),(5,'Москва','Тест',NULL),(7,'Волгоград',NULL,NULL),(8,'Уфа','<button>About</button>',NULL),(9,NULL,'(не)Официальный аккаунт Павла Вальерьвича Дурова',NULL);
/*!40000 ALTER TABLE `users_info` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-27 14:44:58
