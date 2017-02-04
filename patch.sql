-- MySQL dump 10.13  Distrib 5.7.15, for FreeBSD11.0 (amd64)
--
-- Host: localhost    Database: miradio
-- ------------------------------------------------------
-- Server version	5.7.15-log

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
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--


--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(5) NOT NULL,
  `ru` varchar(50) DEFAULT NULL,
  `en` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` VALUES (2,0,'Другое','Other'),(3,1,'Азия','Asia'),(4,2,'Азербайджан','Azerbaijan'),(5,3,'Аргентина','Argentina'),(6,4,'Беларусь','Belarus'),(7,5,'Бейрут','Beirut'),(8,6,'Бразилия','Brazil'),(9,7,'Великобритания','United Kingdom'),(10,8,'Германия','Germany'),(11,9,'Греция','Greece'),(12,10,'Дания','Denmark'),(13,11,'Израиль','Israel'),(14,12,'Испания','Spain'),(15,13,'Италия','Italy'),(16,14,'Киргизия','Kyrgyzstan'),(17,15,'Казахстан','Kazakhstan'),(18,16,'Канада','Canada'),(19,17,'Литва','Lithuania'),(20,18,'Ливан','Lebanon'),(21,19,'Морокко','Morocco'),(22,20,'Нидерланды','Netherlands'),(23,11,'ОАЭ','UAE'),(24,22,'Польша','Poland'),(25,23,'Португалия','Portugal'),(26,24,'Россия','Russia'),(27,25,'Румыния','Romania'),(28,26,'Северная Корея','North Korea'),(29,27,'Турция','Turkey'),(30,28,'Украина','Ukraine'),(31,29,'Франция','France'),(32,30,'Хорватия','Croatia'),(33,31,'Эстония','Estonia'),(34,32,'США','USA'),(35,33,'International','International');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genre`
--

DROP TABLE IF EXISTS `genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `genre` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `gid` int(5) NOT NULL,
  `ru` varchar(50) NOT NULL,
  `en` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genre`
--

LOCK TABLES `genre` WRITE;
/*!40000 ALTER TABLE `genre` DISABLE KEYS */;
INSERT INTO `genre` VALUES (2,0,'Другое','Other'),(3,1,'Анекдоты','Jokes'),(4,1,'Аниме','Anime'),(5,2,'Аудиокниги','Audiobooks'),(6,3,'Дабстеп','Dubstep'),(7,4,'Джаз, Блюз','Jazz, Blues'),(8,5,'Детское','Child'),(9,6,'Игровое радио','Playing radio'),(10,7,'Йога, СПА, Медитация','Meditation'),(11,8,'Кантри','Country'),(12,9,'Классика','Classic'),(13,10,'Кавказ','Caucasus'),(14,11,'Металл','Metal'),(15,12,'Новости, разговорное','News, Talk'),(16,13,'Поп','POP'),(17,14,'Прошлых лет','Last years'),(18,15,'Рок','Rock'),(19,16,'Релакс','Relax'),(20,17,'РЭП, Хип-хоп','RAP,Hip-Hop'),(21,19,'Смешанный стиль','Mixed Style'),(22,20,'Ска, Рокстедди, Реггей','Ska, Reggae'),(23,22,'Спорт','Sport'),(24,23,'Танцевальная','Dance'),(25,24,'Шансон','Chanson'),(26,25,'Электронная','Electronic'),(27,26,'Этническая','Ethnic'),(28,27,'Юмор','Humor');
/*!40000 ALTER TABLE `genre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `radios`
--

/*!40101 SET character_set_client = @saved_cs_client */;
ALTER TABLE radios ADD `country` smallint(6) DEFAULT '0';
ALTER TABLE radios ADD `genre` smallint(6) DEFAULT '0';
ALTER TABLE radios ADD `header` varchar(600) DEFAULT '';
ALTER TABLE radios ADD `noencode` tinyint(4) DEFAULT '0';
ALTER TABLE radios ADD `requests` int(11) DEFAULT '0';


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-18 12:16:45
