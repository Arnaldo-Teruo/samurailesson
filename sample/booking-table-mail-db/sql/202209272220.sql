-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: booking-table
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `count` int(11) NOT NULL DEFAULT 1,
  `error` text NOT NULL,
  `memo` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'motoki.kyanpp','test1@change.meoo',9,'22','ppppppppppppppp\r\nokokokok','2022-09-24 01:53:05','2022-09-26 00:33:05'),(3,'佐藤たける','road.to.can@gmail.com',2,'456','aaaaaaaaaaaaaaaa\r\neeeeeeeeeeeeeee\r\nrrrrrrrrrrrrrrrrrrrrrrrrrrrrr','2022-09-24 01:54:10','2022-09-26 00:58:05'),(4,'山根たくや','yamane@mail.com',0,'lll','mlmlmalal','2022-09-25 21:18:10','2022-09-26 00:39:09'),(7,'ダート','dart@mail.com',1,'','jjjjjjjjjjjj','2022-09-25 23:42:45','2022-09-25 23:42:45'),(8,'スティーブ','stibu@mail.com',7,'111','qqq','2022-09-26 01:18:04','2022-09-26 01:32:59'),(9,'ナンシー','nancy@mail.com',1,'','lkjlkj','2022-09-26 01:24:35','2022-09-26 01:24:35'),(10,'斎藤和義','test1@change.me',1,'','321','2022-09-26 01:24:58','2022-09-26 01:24:58'),(11,'喜屋武元貴','test1@change.me',1,'','321','2022-09-26 01:26:02','2022-09-26 01:26:02'),(12,'ルーシー','curis@mail.com',1,'','lkjlkj','2022-09-26 01:28:23','2022-09-26 01:28:23'),(13,'マイク','mike@mail.com',1,'','','2022-09-26 01:30:12','2022-09-26 01:30:12'),(14,'シャーリー','syari@mail.com',1,'','','2022-09-26 01:31:51','2022-09-26 01:31:51');
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

-- Dump completed on 2022-09-27 22:18:13
