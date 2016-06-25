-- MySQL dump 10.10
--
-- Host: localhost    Database: planetarion
-- ------------------------------------------------------
-- Server version	5.0.24a-Debian_9ubuntu2.1-log

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
-- Table structure for table `alliance`
--

DROP TABLE IF EXISTS `alliance`;
CREATE TABLE `alliance` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tag` varchar(4) character set latin1 collate latin1_bin NOT NULL default '',
  `secret` varchar(8) character set latin1 collate latin1_bin NOT NULL default '',
  `hc` int(10) unsigned NOT NULL default '0',
  `offa` int(10) unsigned default '0',
  `offb` int(10) unsigned default '0',
  `offc` int(10) unsigned default '0',
  `members` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(120) character set latin1 collate latin1_bin NOT NULL default '',
  `hcname` varchar(25) character set latin1 collate latin1_bin NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `tag` (`tag`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alliance`
--


/*!40000 ALTER TABLE `alliance` DISABLE KEYS */;
LOCK TABLES `alliance` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `alliance` ENABLE KEYS */;

--
-- Table structure for table `fleet`
--

DROP TABLE IF EXISTS `fleet`;
CREATE TABLE `fleet` (
  `planet_id` int(10) unsigned NOT NULL default '0',
  `fleet_id` int(10) unsigned NOT NULL auto_increment,
  `num` tinyint(3) unsigned default '0',
  `ticks` tinyint(3) unsigned default '0',
  `target_id` int(10) unsigned default '0',
  `type` tinyint(3) unsigned default '0',
  `full_eta` tinyint(3) unsigned default '0',
  PRIMARY KEY  (`fleet_id`),
  UNIQUE KEY `planetid_num` (`planet_id`,`num`),
  KEY `target_id` (`target_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fleet`
--


/*!40000 ALTER TABLE `fleet` DISABLE KEYS */;
LOCK TABLES `fleet` WRITE;
INSERT INTO `fleet` VALUES (1,1,0,0,0,0,0),(1,2,1,0,0,0,0),(1,3,2,0,0,0,0),(1,4,3,0,0,0,0),(1,5,4,0,0,0,0),(2,6,0,0,0,0,0),(2,7,1,0,0,0,0),(2,8,2,0,0,0,0),(2,9,3,0,0,0,0),(2,10,4,0,0,0,0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `fleet` ENABLE KEYS */;

--
-- Table structure for table `galaxy`
--

DROP TABLE IF EXISTS `galaxy`;
CREATE TABLE `galaxy` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `x` smallint(5) unsigned NOT NULL default '0',
  `y` smallint(5) unsigned NOT NULL default '0',
  `name` varchar(120) default 'Far Far Away',
  `pic` varchar(255) default NULL,
  `gc` int(10) unsigned default '0',
  `mow` int(10) unsigned default '0',
  `moc` int(10) unsigned default '0',
  `mot` int(10) unsigned default '0',
  `text` text,
  `members` tinyint(3) unsigned default '0',
  `exile_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `exile_id` int(10) unsigned default '0',
  `metal` bigint(20) unsigned default '0',
  `crystal` bigint(20) unsigned default '0',
  `eonium` bigint(20) unsigned default '0',
  `donation_date` datetime default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `x_y` (`x`,`y`),
  KEY `exile_id` (`exile_id`)
) ENGINE=MyISAM AUTO_INCREMENT=106 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `galaxy`
--


/*!40000 ALTER TABLE `galaxy` DISABLE KEYS */;
LOCK TABLES `galaxy` WRITE;
INSERT INTO `galaxy` VALUES (1,1,1,'My Galaxy',NULL,0,0,0,0,NULL,2,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(2,1,2,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(3,1,3,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(4,1,4,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(5,1,5,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(6,1,6,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(7,1,7,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(8,2,1,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(9,2,2,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(10,2,3,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(11,2,4,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(12,2,5,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(13,2,6,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(14,2,7,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(15,3,1,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(16,3,2,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(17,3,3,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(18,3,4,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(19,3,5,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(20,3,6,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(21,3,7,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(22,4,1,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(23,4,2,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(24,4,3,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(25,4,4,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(26,4,5,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(27,4,6,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(28,4,7,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(29,5,1,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(30,5,2,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(31,5,3,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(32,5,4,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(33,5,5,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(34,5,6,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(35,5,7,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(36,6,1,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(37,6,2,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(38,6,3,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(39,6,4,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(40,6,5,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(41,6,6,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(42,6,7,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(43,7,1,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(44,7,2,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(45,7,3,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(46,7,4,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(47,7,5,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(48,7,6,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(49,7,7,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(50,8,1,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(51,8,2,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(52,8,3,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(53,8,4,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(54,8,5,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(55,8,6,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(56,8,7,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(57,9,1,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(58,9,2,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(59,9,3,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(60,9,4,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(61,9,5,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(62,9,6,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(63,9,7,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(64,10,1,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(65,10,2,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(66,10,3,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(67,10,4,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(68,10,5,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(69,10,6,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(70,10,7,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(71,11,1,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(72,11,2,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(73,11,3,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(74,11,4,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(75,11,5,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(76,11,6,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(77,11,7,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(78,12,1,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(79,12,2,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(80,12,3,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(81,12,4,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(82,12,5,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(83,12,6,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(84,12,7,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(85,13,1,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(86,13,2,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(87,13,3,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(88,13,4,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(89,13,5,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(90,13,6,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(91,13,7,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(92,14,1,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(93,14,2,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(94,14,3,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(95,14,4,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(96,14,5,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(97,14,6,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(98,14,7,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(99,15,1,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(100,15,2,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(101,15,3,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(102,15,4,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(103,15,5,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(104,15,6,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00'),(105,15,7,'Far Far Away',NULL,0,0,0,0,NULL,0,'0000-00-00 00:00:00',0,0,0,0,'0000-00-00 00:00:00');
UNLOCK TABLES;
/*!40000 ALTER TABLE `galaxy` ENABLE KEYS */;

--
-- Table structure for table `general`
--

DROP TABLE IF EXISTS `general`;
CREATE TABLE `general` (
  `tick` int(10) unsigned default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `general`
--


/*!40000 ALTER TABLE `general` DISABLE KEYS */;
LOCK TABLES `general` WRITE;
INSERT INTO `general` VALUES (0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `general` ENABLE KEYS */;

--
-- Table structure for table `highscore`
--

DROP TABLE IF EXISTS `highscore`;
CREATE TABLE `highscore` (
  `round` smallint(5) unsigned NOT NULL default '0',
  `coords` varchar(10) NOT NULL default '',
  `planetname` varchar(30) NOT NULL default '',
  `leader` varchar(30) NOT NULL default '',
  `score` bigint(20) unsigned default '0',
  `roids` int(10) unsigned default '0',
  `date` datetime default '0000-00-00 00:00:00',
  KEY `round` (`round`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `highscore`
--


/*!40000 ALTER TABLE `highscore` DISABLE KEYS */;
LOCK TABLES `highscore` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `highscore` ENABLE KEYS */;

--
-- Table structure for table `highscore_alliance`
--

DROP TABLE IF EXISTS `highscore_alliance`;
CREATE TABLE `highscore_alliance` (
  `round` smallint(5) unsigned NOT NULL default '0',
  `tag` varchar(4) NOT NULL default '',
  `name` varchar(128) NOT NULL default '',
  `hcname` varchar(25) NOT NULL default '',
  `members` tinyint(3) unsigned NOT NULL default '0',
  `score` bigint(20) unsigned default '0',
  `roids` int(10) unsigned default '0',
  `date` datetime default '0000-00-00 00:00:00',
  KEY `round` (`round`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `highscore_alliance`
--


/*!40000 ALTER TABLE `highscore_alliance` DISABLE KEYS */;
LOCK TABLES `highscore_alliance` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `highscore_alliance` ENABLE KEYS */;

--
-- Table structure for table `highscore_gal`
--

DROP TABLE IF EXISTS `highscore_gal`;
CREATE TABLE `highscore_gal` (
  `round` smallint(5) unsigned NOT NULL default '0',
  `coords` varchar(10) NOT NULL default '',
  `galname` varchar(200) default NULL,
  `score` bigint(20) unsigned default '0',
  `roids` int(10) unsigned default '0',
  `date` datetime default '0000-00-00 00:00:00',
  KEY `round` (`round`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `highscore_gal`
--


/*!40000 ALTER TABLE `highscore_gal` DISABLE KEYS */;
LOCK TABLES `highscore_gal` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `highscore_gal` ENABLE KEYS */;

--
-- Table structure for table `iptables`
--

DROP TABLE IF EXISTS `iptables`;
CREATE TABLE `iptables` (
  `ip` varchar(20) default '',
  `comment` varchar(255) default '',
  UNIQUE KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `iptables`
--


/*!40000 ALTER TABLE `iptables` DISABLE KEYS */;
LOCK TABLES `iptables` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `iptables` ENABLE KEYS */;

--
-- Table structure for table `journal`
--

DROP TABLE IF EXISTS `journal`;
CREATE TABLE `journal` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `planet_id` int(10) unsigned NOT NULL default '0',
  `target_id` int(10) unsigned NOT NULL default '0',
  `date` datetime default '0000-00-00 00:00:00',
  `tick` int(10) unsigned default '0',
  `hidden` tinyint(3) unsigned default '0',
  `type` tinyint(3) unsigned NOT NULL default '0',
  `data` blob,
  UNIQUE KEY `pt` (`planet_id`,`target_id`,`type`),
  KEY `id` (`id`),
  KEY `d` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `journal`
--


/*!40000 ALTER TABLE `journal` DISABLE KEYS */;
LOCK TABLES `journal` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `journal` ENABLE KEYS */;

--
-- Table structure for table `logging`
--

DROP TABLE IF EXISTS `logging`;
CREATE TABLE `logging` (
  `planet_id` int(10) unsigned NOT NULL default '0',
  `stamp` datetime default '0000-00-00 00:00:00',
  `type` tinyint(3) unsigned NOT NULL default '0',
  `class` tinyint(3) unsigned NOT NULL default '0',
  `data` varchar(255) default NULL,
  KEY `planet_id` (`planet_id`),
  KEY `stamp` (`stamp`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logging`
--


/*!40000 ALTER TABLE `logging` DISABLE KEYS */;
LOCK TABLES `logging` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `logging` ENABLE KEYS */;

--
-- Table structure for table `mail`
--

DROP TABLE IF EXISTS `mail`;
CREATE TABLE `mail` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `planet_id` int(10) unsigned NOT NULL default '0',
  `sender_id` int(10) unsigned NOT NULL default '0',
  `date` datetime default '0000-00-00 00:00:00',
  `ref` smallint(5) unsigned default '1',
  `subject` varchar(255) default '',
  `text` text,
  PRIMARY KEY  (`id`),
  KEY `planet_id` (`planet_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mail`
--


/*!40000 ALTER TABLE `mail` DISABLE KEYS */;
LOCK TABLES `mail` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `mail` ENABLE KEYS */;

--
-- Table structure for table `market`
--

DROP TABLE IF EXISTS `market`;
CREATE TABLE `market` (
  `unit_id` tinyint(3) unsigned NOT NULL default '0',
  `num` int(10) unsigned default '0',
  `type` tinyint(3) unsigned NOT NULL default '0',
  KEY `unit_id` (`unit_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `market`
--


/*!40000 ALTER TABLE `market` DISABLE KEYS */;
LOCK TABLES `market` WRITE;
INSERT INTO `market` VALUES (1,1004,1),(2,1012,1),(3,1000,1),(4,1000,1),(5,1000,1),(6,1000,1),(7,1000,1),(8,1000,1),(9,1000,1),(10,1000,1),(11,1000,1),(12,1000,1),(13,1000,1),(20,1000,2),(21,1000,2),(22,1000,2),(23,1000,2),(24,1000,2),(1,1000,3),(2,1000,3),(3,1000,3),(4,1000,3),(5,1000,3),(6,1000,3),(7,1000,3),(8,1000,3);
UNLOCK TABLES;
/*!40000 ALTER TABLE `market` ENABLE KEYS */;

--
-- Table structure for table `msg`
--

DROP TABLE IF EXISTS `msg`;
CREATE TABLE `msg` (
  `mail_id` int(10) unsigned NOT NULL default '0',
  `folder` tinyint(3) unsigned default '1',
  `planet_id` int(10) unsigned NOT NULL default '0',
  `old` tinyint(3) unsigned default '0',
  UNIQUE KEY `plnt_fldr_ml` (`planet_id`,`folder`,`mail_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `msg`
--


/*!40000 ALTER TABLE `msg` DISABLE KEYS */;
LOCK TABLES `msg` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `msg` ENABLE KEYS */;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `planet_id` int(10) unsigned NOT NULL default '0',
  `date` datetime default '0000-00-00 00:00:00',
  `tick` int(10) unsigned default '0',
  `type` tinyint(3) unsigned NOT NULL default '0',
  `hidden` tinyint(3) unsigned default '0',
  `text` blob,
  KEY `id` (`id`),
  KEY `planet_id` (`planet_id`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news`
--


/*!40000 ALTER TABLE `news` DISABLE KEYS */;
LOCK TABLES `news` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;

--
-- Table structure for table `pds`
--

DROP TABLE IF EXISTS `pds`;
CREATE TABLE `pds` (
  `planet_id` int(10) unsigned NOT NULL default '0',
  `pds_id` tinyint(3) unsigned NOT NULL default '0',
  `num` int(10) unsigned NOT NULL default '0',
  UNIQUE KEY `planet_pds` (`planet_id`,`pds_id`),
  KEY `pds_id` (`pds_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pds`
--


/*!40000 ALTER TABLE `pds` DISABLE KEYS */;
LOCK TABLES `pds` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `pds` ENABLE KEYS */;

--
-- Table structure for table `pds_build`
--

DROP TABLE IF EXISTS `pds_build`;
CREATE TABLE `pds_build` (
  `planet_id` int(10) unsigned NOT NULL default '0',
  `build_ticks` tinyint(3) unsigned default '0',
  `num` int(10) unsigned NOT NULL default '0',
  `pds_id` tinyint(3) unsigned default '0',
  KEY `planet_id` (`planet_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pds_build`
--


/*!40000 ALTER TABLE `pds_build` DISABLE KEYS */;
LOCK TABLES `pds_build` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `pds_build` ENABLE KEYS */;

--
-- Table structure for table `planet`
--

DROP TABLE IF EXISTS `planet`;
CREATE TABLE `planet` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `x` smallint(5) unsigned NOT NULL default '0',
  `y` smallint(5) unsigned NOT NULL default '0',
  `z` smallint(5) unsigned NOT NULL default '0',
  `planetname` varchar(30) NOT NULL default '',
  `leader` varchar(30) NOT NULL default '',
  `score` bigint(20) unsigned default '0',
  `metal` bigint(20) unsigned default '0',
  `crystal` bigint(20) unsigned default '0',
  `eonium` bigint(20) unsigned default '0',
  `constructions` tinyint(3) unsigned default '0',
  `research` tinyint(3) unsigned default '0',
  `metalroids` int(10) unsigned default '0',
  `crystalroids` int(10) unsigned default '0',
  `eoniumroids` int(10) unsigned default '0',
  `uniniroids` int(10) unsigned default '0',
  `has_news` tinyint(3) unsigned default '0',
  `has_mail` tinyint(3) unsigned default '0',
  `has_friendly` tinyint(3) unsigned default '0',
  `has_hostile` tinyint(3) unsigned default '0',
  `mode` tinyint(3) unsigned default '0',
  `planet_m` int(10) unsigned default '0',
  `planet_c` int(10) unsigned default '0',
  `planet_e` int(10) unsigned default '0',
  `speed_modifier` tinyint(3) unsigned default '0',
  `news_deleted` datetime default '0000-00-00 00:00:00',
  `vote` int(10) unsigned default '0',
  `gal_hostile` tinyint(3) unsigned default '0',
  `has_politics` tinyint(3) unsigned default '0',
  `roid_modifier` int(10) unsigned default '0',
  `exile_vote` int(10) unsigned default '0',
  `alliance_id` int(10) unsigned default '0',
  `status` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `x_y_z` (`x`,`y`,`z`),
  KEY `mode` (`mode`),
  KEY `alliance_id` (`alliance_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `planet`
--


/*!40000 ALTER TABLE `planet` DISABLE KEYS */;
LOCK TABLES `planet` WRITE;
INSERT INTO `planet` VALUES (1,1,1,1,'here','Admin',0,5000,5000,5000,0,0,0,0,0,3,0,0,0,0,242,250,250,250,0,'0000-00-00 00:00:00',0,0,0,0,0,0,0),(2,1,1,2,'the game','Moderator',0,5000,5000,5000,0,0,0,0,0,3,0,0,0,0,242,250,250,250,0,'0000-00-00 00:00:00',0,0,0,0,0,0,0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `planet` ENABLE KEYS */;

--
-- Table structure for table `politics`
--

DROP TABLE IF EXISTS `politics`;
CREATE TABLE `politics` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `planet_id` int(10) unsigned NOT NULL default '0',
  `gal_id` int(10) unsigned NOT NULL default '0',
  `date` datetime default NULL,
  `subject` varchar(255) NOT NULL default '',
  `creator` varchar(30) default '',
  `replies` smallint(5) unsigned default '0',
  PRIMARY KEY  (`id`),
  KEY `date` (`date`),
  KEY `gal_id` (`gal_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `politics`
--


/*!40000 ALTER TABLE `politics` DISABLE KEYS */;
LOCK TABLES `politics` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `politics` ENABLE KEYS */;

--
-- Table structure for table `poltext`
--

DROP TABLE IF EXISTS `poltext`;
CREATE TABLE `poltext` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `planet_id` int(10) unsigned NOT NULL default '0',
  `thread_id` int(10) unsigned NOT NULL default '0',
  `date` datetime default NULL,
  `text` text,
  PRIMARY KEY  (`id`),
  KEY `thread_id` (`thread_id`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `poltext`
--


/*!40000 ALTER TABLE `poltext` DISABLE KEYS */;
LOCK TABLES `poltext` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `poltext` ENABLE KEYS */;

--
-- Table structure for table `rc`
--

DROP TABLE IF EXISTS `rc`;
CREATE TABLE `rc` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `planet_id` int(10) unsigned NOT NULL default '0',
  `rc_id` tinyint(3) unsigned NOT NULL default '0',
  `status` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `planet_rc` (`planet_id`,`rc_id`),
  KEY `id_st` (`rc_id`,`status`)
) ENGINE=MyISAM AUTO_INCREMENT=159 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rc`
--


/*!40000 ALTER TABLE `rc` DISABLE KEYS */;
LOCK TABLES `rc` WRITE;
INSERT INTO `rc` VALUES (1,1,0,3),(2,1,2,0),(3,1,4,0),(4,1,6,0),(5,1,8,0),(6,1,10,0),(7,1,1,1),(8,1,3,0),(9,1,5,0),(10,1,7,0),(11,1,9,0),(12,1,11,0),(13,1,31,0),(14,1,33,0),(15,1,35,0),(16,1,37,0),(17,1,30,1),(18,1,32,0),(19,1,34,0),(20,1,36,0),(21,1,41,0),(22,1,43,0),(23,1,45,0),(24,1,47,0),(25,1,40,1),(26,1,42,0),(27,1,44,0),(28,1,46,0),(29,1,48,0),(30,1,60,1),(31,1,62,0),(32,1,64,0),(33,1,66,0),(34,1,68,0),(35,1,61,0),(36,1,63,0),(37,1,65,0),(38,1,67,0),(39,1,69,0),(40,1,71,0),(41,1,70,0),(42,1,100,1),(43,1,121,0),(44,1,123,0),(45,1,125,0),(46,1,127,0),(47,1,129,0),(48,1,131,0),(49,1,120,1),(50,1,122,0),(51,1,124,0),(52,1,126,0),(53,1,128,0),(54,1,130,0),(55,1,101,0),(56,1,103,0),(57,1,105,0),(58,1,107,0),(59,1,109,0),(60,1,102,0),(61,1,104,0),(62,1,106,0),(63,1,108,0),(64,1,110,0),(65,1,91,0),(66,1,13,0),(67,1,15,0),(68,1,17,0),(69,1,14,0),(70,1,16,0),(71,1,12,0),(72,1,18,0),(73,1,19,0),(74,1,20,0),(75,1,21,0),(76,1,49,0),(77,1,50,0),(78,1,51,0),(79,1,52,0),(80,2,0,3),(81,2,2,0),(82,2,4,0),(83,2,6,0),(84,2,8,0),(85,2,10,0),(86,2,1,1),(87,2,3,0),(88,2,5,0),(89,2,7,0),(90,2,9,0),(91,2,11,0),(92,2,31,0),(93,2,33,0),(94,2,35,0),(95,2,37,0),(96,2,30,1),(97,2,32,0),(98,2,34,0),(99,2,36,0),(100,2,41,0),(101,2,43,0),(102,2,45,0),(103,2,47,0),(104,2,40,1),(105,2,42,0),(106,2,44,0),(107,2,46,0),(108,2,48,0),(109,2,60,1),(110,2,62,0),(111,2,64,0),(112,2,66,0),(113,2,68,0),(114,2,61,0),(115,2,63,0),(116,2,65,0),(117,2,67,0),(118,2,69,0),(119,2,71,0),(120,2,70,0),(121,2,100,1),(122,2,121,0),(123,2,123,0),(124,2,125,0),(125,2,127,0),(126,2,129,0),(127,2,131,0),(128,2,120,1),(129,2,122,0),(130,2,124,0),(131,2,126,0),(132,2,128,0),(133,2,130,0),(134,2,101,0),(135,2,103,0),(136,2,105,0),(137,2,107,0),(138,2,109,0),(139,2,102,0),(140,2,104,0),(141,2,106,0),(142,2,108,0),(143,2,110,0),(144,2,91,0),(145,2,13,0),(146,2,15,0),(147,2,17,0),(148,2,14,0),(149,2,16,0),(150,2,12,0),(151,2,18,0),(152,2,19,0),(153,2,20,0),(154,2,21,0),(155,2,49,0),(156,2,50,0),(157,2,51,0),(158,2,52,0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `rc` ENABLE KEYS */;

--
-- Table structure for table `rc_build`
--

DROP TABLE IF EXISTS `rc_build`;
CREATE TABLE `rc_build` (
  `planet_id` int(10) unsigned NOT NULL default '0',
  `rc_id` tinyint(3) unsigned NOT NULL default '0',
  `build_ticks` tinyint(3) unsigned default NULL,
  KEY `planet_id` (`planet_id`),
  KEY `rc_id` (`rc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rc_build`
--


/*!40000 ALTER TABLE `rc_build` DISABLE KEYS */;
LOCK TABLES `rc_build` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `rc_build` ENABLE KEYS */;

--
-- Table structure for table `rc_class`
--

DROP TABLE IF EXISTS `rc_class`;
CREATE TABLE `rc_class` (
  `id` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(30) NOT NULL default '',
  `description` varchar(255) default '',
  `metal` mediumint(8) unsigned NOT NULL default '0',
  `crystal` mediumint(8) unsigned NOT NULL default '0',
  `eonium` mediumint(8) unsigned NOT NULL default '0',
  `build_ticks` tinyint(3) unsigned NOT NULL default '0',
  `rc_id` tinyint(3) unsigned NOT NULL default '0',
  `block_id` tinyint(3) unsigned default '0',
  `type` tinyint(4) default '0',
  PRIMARY KEY  (`id`),
  KEY `rc_id` (`rc_id`),
  KEY `block_id` (`block_id`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rc_class`
--


/*!40000 ALTER TABLE `rc_class` DISABLE KEYS */;
LOCK TABLES `rc_class` WRITE;
INSERT INTO `rc_class` VALUES (0,'University','Gives You the ability for further researches.',0,0,0,0,0,0,0),(2,'Crystal Extraction','Methods of refining crystal without loss of molecular integrity.',2400,2400,0,12,1,0,0),(4,'Eonium Fusion','The art of extracting the highly unstable element Eonium from its original source.',9600,9600,0,24,3,0,0),(6,'Core Resources','The development of deep core mining on a planets surface for untapped veins of resource.',38400,38400,0,48,5,0,0),(8,'Crystal Plasma','Development of extracting crystal plasma from a melted core source without contamination.',115200,115200,0,80,7,0,0),(10,'Advanced Composites','The research into purifying raw Eonium and increasing its power output from that of its original solid state.',230400,230400,0,120,9,0,0),(1,'Mining Center','Extracts 1500 units of metal per tick.',1200,1200,0,8,0,0,1),(3,'Crystal Refinery','Extracts 1500 units of crystal per tick.',4800,4800,0,16,2,0,1),(5,'Eonium Laboratory','Extracts 1500 units of eonium per tick.',19200,19200,0,32,4,0,1),(7,'Advanced Metal Mine','Extracts 3000 units of metal per tick.',57600,57600,0,64,6,0,1),(9,'Advanced Crystal Mine','Extracts 3000 units of crystal per tick.',153600,153600,0,96,8,0,1),(11,'Advanced Eonium Mine','Extracts 3000 units of eonium per tick.',307200,307200,0,120,10,0,1),(31,'Rift Generator','Vessel propulsion engines create a small subspace rift reducing traveltime by 1 tick.',2400,2400,0,16,30,0,1),(33,'Warpfield Regulator','Vessels have the ability to Warp Space/Time reducing traveltime by 1 additional tick.',9600,9600,0,32,32,0,1),(35,'Vortex Stabilizer','Vessels can substain Space/Time rifts for a longer period reducing traveltime by 1 additional tick.',38400,38400,0,64,34,0,1),(37,'Hypergate','Vessels have the ability to form a tear in the Space/Time continuum reducing traveltime by 1 additional tick.',115200,115200,0,96,36,0,1),(30,'Quantum Mechanics','The study of improved stellar travel.',1200,1200,0,8,0,0,0),(32,'Warp Technology','Research of nonlinear time travel theories and their application.',4800,4800,0,24,31,0,0),(34,'Wormholes','Research on the extension and stability of Space/Time rifts.',19200,19200,0,48,33,0,0),(36,'Hyperspace','Research on the ability to create a tear in Space/Time and allow passage of vessels without damaging the timelines',76800,76800,0,80,35,70,0),(41,'Neural Networks','Research on cluster targeting from a planetary based control drone.',3200,1600,0,12,40,0,0),(43,'Enhanced Targeting','Research on specialised targeting systems for integration into planetary based control drones.',12800,6400,0,24,42,0,0),(45,'Pulsating Photons','Research on energised fluxuating photons and their application into planetary defence networks.',51200,25600,0,48,44,0,0),(47,'Ionized Beams','The use of ionized light-beams as the ultimate planet side weapon.',172800,86400,0,80,46,0,0),(40,'PDS Control Center','Enables production of Meson cannons.',1600,800,0,8,0,0,1),(42,'Particle Accelerator','Enables production of Hyperon turrets.',6400,3200,0,16,41,0,1),(44,'Neutron Chamber','Enables factory production of Neutron emitters.',25600,12800,0,32,43,0,1),(46,'Photon Charger','Enables factory production of Photon cannons.',76800,38400,0,64,45,0,1),(48,'Ion Dispatcher','Enables factory production of Ion turrets.',204800,102400,0,96,47,0,1),(60,'Energy Patterns','Application of the theory regarding wave-amplification in a vacuum environment.',800,1600,0,8,0,0,0),(62,'Resource Signatures','Allows the locating and subsequent charting of orbital asteroids for retrieval and resource mining.',3200,6400,0,16,61,0,0),(64,'Unit Patterns','The application of determining specific ship vapor trail signatures.',12800,25600,0,32,63,0,0),(66,'Interference','Technology surrounding advanced wave interference and blockage\r\n.',38400,76000,0,64,65,0,0),(68,'Fleet Signatures','The field of advanced decryption algorithms.',76800,153000,0,96,67,0,0),(61,'Scope Amplifier','Enables Asteroid Location Technology',800,4000,0,12,60,0,1),(63,'Wave filter','Enables Unit Pattern Technology to assist in gaining covert information on enemy Fleets.',3200,16000,0,24,62,0,1),(65,'PDS Scanner','Enables PDS Scans that allow user to gain intelligence on enemy Planetary Defense.',12800,64000,0,48,64,0,1),(67,'Reflection Center','Enables Wave Reflectors that attempt to divert enemy scans on your Planet or Fleets.',28800,144000,0,80,66,0,1),(69,'Ion Field Receiver','Enables News Scans - these give valuable information regarding the Military situation of a Galaxy.',57600,288000,0,96,68,0,1),(71,'Decryption Center','Enables Military Scans that allow you to check if an enemys fleets are at home or out on a mission.',115200,576000,0,120,70,0,1),(70,'Cloaked Signatures','Research on cloaked vessels vapour trail signatures.',153600,307000,0,120,69,36,0),(100,'Light Factory','Enables production of Interceptors.',2000,400,0,8,0,0,1),(121,'Spider Factory','Produces Spiders',800,4000,0,16,120,0,1),(123,'Wraith Factory','Produces Wraiths.',3200,16000,0,32,122,0,1),(125,'Black Widow Facility','Produces Black Widows.',12800,56200,0,64,124,0,1),(127,'Ghost Factory','Produces Ghosts.',28800,115200,0,80,126,0,1),(129,'Tarantula Compound','Produces Tarantulas.',57600,232000,0,96,128,0,1),(131,'Spectre Factory','Produces Spectres.',115200,576000,0,120,130,0,1),(120,'Mounted EMP','Minimizing EMP emitters to allow usage with small ships.',2000,2000,0,8,0,0,0),(122,'Cloaking Device','Exploring anti radar detection systems for use with manned ships.',1600,8000,0,20,121,101,0),(124,'Black Widow Facility','The study of applying multiple frequency EMP technology to larger vessels.',6400,32000,0,48,123,0,0),(126,'Improved Cloaking','The study of applying stealth technology to larger warfaring vessels.',12800,76000,0,64,125,0,0),(128,'The Tarantula Project','Research on a more powerful EMP emitter for application on medium sized vessels',28800,144000,0,96,127,0,0),(130,'Cloaked Capital Hulls','The study of applying stealth or cloaking facilities for use with capital hulls.',76800,288000,0,120,129,0,0),(101,'Space Warfare','Weapon technology research regarding zero-gravity propulsion missiles.',4000,800,0,16,100,122,0),(103,'Plasma Weapons','Research on crystal based plasma weapon technology.',16000,3200,0,32,102,0,0),(105,'Ion Weapons','Research on hull integrity and increased strength of metal alloys for use in medium sized ship production',64000,12800,0,64,104,0,0),(107,'Capital Hulls','Research on hull integrity and increased strength of metal alloys for use in larger sized ship production.',192000,38400,0,80,106,0,0),(109,'Beam Weapons','The study of fast-tracking photon cannons.',384000,86400,0,120,108,0,0),(102,'War Academy','Enables production of Phoenixes.',8000,1600,0,24,101,0,1),(104,'War Factory','Enables production of Warfrigates.',32000,6400,0,48,103,0,1),(106,'Destroyer Factory','Enables production of Devastators.',96000,19800,0,64,105,0,1),(108,'Cruiser Factory','Enables production of Starcruisers.',216000,43200,0,96,107,0,1),(110,'Battleship Factory','Enables production of Dreadnaughts.',432000,115200,0,120,109,0,1),(91,'Trading Unit','Build a place for a UniTrade branch office.',12000,58000,32000,36,90,0,1),(13,'Metal Extractor','Extracts 6000 units of metal per tick from planet core.',432000,432000,307200,144,12,0,1),(15,'Crystal Extractor','Extracts 6000 units of crystal per tick from planet core.',432000,432000,1228000,168,14,0,1),(17,'Eonium Extractor','Extracts 6000 units of eonium per tick from planet core.',432000,432000,4912000,192,16,0,1),(14,'Crystal Magma','Separation process of crystal resources from planetary magma',432000,432000,614000,168,13,0,0),(16,'Eonium Magma','Separation process of diffusive eonium resources from fluid planetary magma.',432000,432000,2456000,192,15,18,0),(12,'Metal Magma','Process of reducing planetary magma to metal resource element.',384000,384000,153000,144,11,0,0),(18,'Space Mining','Recent discoveries allow research on automatization in Asteroid mining to possibly raise resource income.',432000,432000,2456000,192,15,16,0),(19,'Mining Factory','Using automatization Asteroid Mining can be increased by 25%.',432000,432000,4912000,192,18,0,1),(20,'Mining Economization','Business studies seems to show that further enhancement in Asteroid Mining may be realized.',432000,432000,7368000,216,19,0,0),(21,'Asteroid Economics','Optimizing the process of Asteroid Mining leads to some further increase in resource mining.',432000,432000,7368000,216,20,0,1),(49,'Missile Knowledge','Basic research on Planet-Planet Missiles',25600,51200,12600,48,44,0,0),(50,'Missile Battery','Production of Anti-PDS Missile technology',51200,86400,25200,64,49,0,1),(51,'Missile Tracking','Research on target tracking of incoming Missiles.',86400,115200,50400,80,50,0,0),(52,'Missile Deflection','Factory production of Anti-Missile Cannons.',115200,144000,86400,96,51,0,1);
UNLOCK TABLES;
/*!40000 ALTER TABLE `rc_class` ENABLE KEYS */;

--
-- Table structure for table `scan`
--

DROP TABLE IF EXISTS `scan`;
CREATE TABLE `scan` (
  `planet_id` int(10) unsigned NOT NULL default '0',
  `wave_id` tinyint(3) unsigned NOT NULL default '0',
  `num` int(10) unsigned default '0',
  UNIQUE KEY `planet_wave` (`planet_id`,`wave_id`),
  KEY `wave_id` (`wave_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scan`
--


/*!40000 ALTER TABLE `scan` DISABLE KEYS */;
LOCK TABLES `scan` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `scan` ENABLE KEYS */;

--
-- Table structure for table `scan_build`
--

DROP TABLE IF EXISTS `scan_build`;
CREATE TABLE `scan_build` (
  `planet_id` int(10) unsigned NOT NULL default '0',
  `scan_id` tinyint(3) unsigned NOT NULL default '0',
  `build_ticks` tinyint(3) unsigned default '0',
  `num` int(10) unsigned NOT NULL default '0',
  KEY `planet_id` (`planet_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scan_build`
--


/*!40000 ALTER TABLE `scan_build` DISABLE KEYS */;
LOCK TABLES `scan_build` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `scan_build` ENABLE KEYS */;

--
-- Table structure for table `scan_class`
--

DROP TABLE IF EXISTS `scan_class`;
CREATE TABLE `scan_class` (
  `id` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(30) NOT NULL default '',
  `description` varchar(255) default '',
  `metal` mediumint(8) unsigned NOT NULL default '0',
  `crystal` mediumint(8) unsigned NOT NULL default '0',
  `eonium` mediumint(8) unsigned NOT NULL default '0',
  `build_ticks` tinyint(3) unsigned NOT NULL default '0',
  `rc_id` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `rc_id` (`rc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scan_class`
--


/*!40000 ALTER TABLE `scan_class` DISABLE KEYS */;
LOCK TABLES `scan_class` WRITE;
INSERT INTO `scan_class` VALUES (1,'Wave Amplifier','Amplifies the power of all your waves, making them harder to deflect or scramble.',0,1000,1000,4,60),(2,'Sector Scan','Returns general information about target.',0,750,250,4,61),(3,'Asteroid Scan','Searches for nearby undiscovered asteroids.',0,1750,250,6,62),(4,'Unit Scan','Returns details of ship signatures in target sector.',0,2500,1000,8,63),(5,'PDS Scan','Returns details of PDS signatures in target sector.',0,2000,1500,8,65),(6,'Wave Reflector','Attempts to scramble and deflect incoming scans targeted at your planet.',0,2000,2000,10,67),(7,'News Scan','Returns the latest news-transmission from target sector.',0,3000,2000,12,69),(8,'Military Scan','Decrypts military communication to reveal cloaked ships and fleet-locations.',0,4000,3000,16,71);
UNLOCK TABLES;
/*!40000 ALTER TABLE `scan_class` ENABLE KEYS */;

--
-- Table structure for table `unit_build`
--

DROP TABLE IF EXISTS `unit_build`;
CREATE TABLE `unit_build` (
  `planet_id` int(10) unsigned NOT NULL default '0',
  `unit_id` tinyint(3) unsigned NOT NULL default '0',
  `build_ticks` tinyint(3) default '0',
  `num` int(10) unsigned NOT NULL default '0',
  KEY `planet_id` (`planet_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit_build`
--


/*!40000 ALTER TABLE `unit_build` DISABLE KEYS */;
LOCK TABLES `unit_build` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `unit_build` ENABLE KEYS */;

--
-- Table structure for table `unit_class`
--

DROP TABLE IF EXISTS `unit_class`;
CREATE TABLE `unit_class` (
  `id` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(30) NOT NULL default '',
  `description` varchar(255) default '',
  `type` tinyint(3) unsigned default '0',
  `class` tinyint(3) unsigned default '0',
  `speed` tinyint(3) unsigned default '0',
  `fuel` smallint(5) unsigned default '0',
  `init` tinyint(3) unsigned default '0',
  `agility` tinyint(3) unsigned NOT NULL default '0',
  `weapon_speed` tinyint(3) unsigned default '0',
  `guns` tinyint(3) unsigned default '1',
  `power` tinyint(3) unsigned default '2',
  `armor` smallint(5) unsigned default '0',
  `resistance` tinyint(3) unsigned NOT NULL default '0',
  `t1` tinyint(3) unsigned NOT NULL default '0',
  `t2` tinyint(3) unsigned default NULL,
  `t3` tinyint(3) unsigned default NULL,
  `metal` mediumint(8) unsigned default '0',
  `crystal` mediumint(8) unsigned default '0',
  `eonium` mediumint(8) unsigned default '0',
  `build_ticks` tinyint(3) unsigned NOT NULL default '0',
  `rc_id` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `rc_id` (`rc_id`),
  KEY `class` (`class`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit_class`
--


/*!40000 ALTER TABLE `unit_class` DISABLE KEYS */;
LOCK TABLES `unit_class` WRITE;
INSERT INTO `unit_class` VALUES (1,'Interceptor','Light and agile, 1 laser cannon, good against frigates and corvettes.',1,1,2,10,8,30,30,1,2,3,50,3,2,1,1250,0,0,4,100),(2,'Phoenix','Highly efficient against Cruisers, armed with 1 powerful cannon.',2,1,3,25,6,25,10,1,12,12,65,5,4,3,2000,500,0,8,102),(3,'War Frigate','Armed with 3 fast-tracking turrets, this ship was made for taking out Corvettes.',3,1,4,80,10,20,25,3,5,30,75,2,1,NULL,5500,1500,0,12,104),(4,'Devastor','Armed with 3 heavy plasma cannons, specialized for destroying Battleships and Cruisers.',4,1,4,175,7,15,5,3,25,70,80,6,5,4,12000,4000,0,16,106),(5,'Star Cruiser','With 8 powerful guns, this ship is an exellent Frigate-killer.',5,1,5,350,11,10,15,8,15,155,85,3,2,NULL,24000,6000,0,20,108),(6,'Dreadnaught','The Colossus of space combat, equipped with 100 guns, best used against smaller.',6,1,5,700,9,5,30,100,2,400,90,1,2,NULL,70000,16000,0,24,110),(7,'Spider','Fast, small and armed with a light EMP emitter, capable of holding ships like Corvettes and Frigates.',1,2,2,10,5,30,0,1,0,2,45,2,3,NULL,0,1250,0,4,121),(8,'Wraith','A cloaked and lethal corvette, very good against Cruisers and Destroyers.',2,3,3,30,12,25,15,1,12,12,65,5,4,3,2000,1000,0,8,123),(9,'Black Widow','A frigate-class ship, armed with no less than 5 EMP emitters tuned against corvettes and fighters.',3,2,4,80,4,20,0,5,0,30,70,2,1,NULL,2000,5000,0,12,125),(10,'Ghost','A cloaked Destroyer, specialized for taking out the biggest ships.',4,3,4,175,13,15,5,3,25,70,75,6,5,4,9000,7000,0,16,127),(11,'Tarantula','With 6 EMP emitters tuned for holding large ships, this ship will pacify cruisers and destroyers.',5,2,5,350,3,8,0,6,0,135,70,5,4,3,14000,12000,0,20,129),(12,'Spectre','Cloaked battleship with 100 guns against Fighter and Corvettes.',6,3,5,700,14,5,30,100,2,350,85,1,2,NULL,53000,33000,0,24,131),(13,'Astro Pod','A special ship made to steal asteroids during combat, and transport them back to the new owner.',3,4,4,125,15,18,0,0,0,12,65,0,NULL,NULL,1750,500,500,12,0),(20,'Meson Cannon','The smallest of the PDS units available, suited to target Corvettes and Fighters.',1,5,0,0,2,1,30,1,2,8,100,2,1,NULL,350,350,350,4,40),(21,'Hyperon Turret','This upgraded version of the Light Turret will attempt to target Frigates and Corvettes',1,5,0,0,2,1,25,1,10,16,100,3,2,NULL,1000,1000,1000,6,42),(22,'Neutron Emitter','A powerful defensive unit, suited against Destroyers and Frigates.',2,5,0,0,2,1,20,1,20,32,100,4,3,NULL,2000,2000,2000,10,44),(23,'Photon Cannon','Using energized Photons, this turret can penetrate even the hulls of Cruisers and Destroyers.',2,5,0,0,2,1,15,1,50,64,100,5,4,NULL,3500,3500,3500,12,46),(24,'ION Turret','Most powerfull PDS, target Battleships.',3,5,0,0,2,1,5,1,75,96,100,6,5,NULL,5000,5000,5000,16,48),(25,'Missile Launcher','Launches Missiles',4,5,0,0,2,1,0,0,0,48,100,0,NULL,NULL,1500,1500,5000,16,50),(26,'Planetary Missile','Anti PDS Missile',7,6,1,8,1,50,65,12,1,1,5,255,NULL,NULL,200,200,250,6,50),(27,'Missile Cannon','This is the Anti Missile PDS',2,5,0,0,0,1,30,10,1,8,100,7,NULL,NULL,750,750,750,24,52);
UNLOCK TABLES;
/*!40000 ALTER TABLE `unit_class` ENABLE KEYS */;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
CREATE TABLE `units` (
  `id` int(10) unsigned NOT NULL default '0',
  `unit_id` tinyint(3) unsigned NOT NULL default '0',
  `num` int(10) unsigned default '0',
  KEY `id` (`id`),
  KEY `unit_id` (`unit_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `units`
--


/*!40000 ALTER TABLE `units` DISABLE KEYS */;
LOCK TABLES `units` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `units` ENABLE KEYS */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `login` varchar(30) character set latin1 collate latin1_bin NOT NULL default '',
  `password` varchar(30) character set latin1 collate latin1_bin NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `planet_id` int(10) unsigned NOT NULL default '0',
  `last` datetime default NULL,
  `signup` datetime default '0000-00-00 00:00:00',
  `first_tick` int(10) unsigned default '0',
  `last_tick` int(10) unsigned default '0',
  `last_sleep` datetime default '0000-00-00 00:00:00',
  `login_date` datetime default NULL,
  `uptime` time default '00:00:00',
  `ip` varchar(20) default '',
  `imgpath` varchar(255) default 'http://khan.stoney.cinetic.de/img',
  `delete_date` datetime default '0000-00-00 00:00:00',
  `settings` int(10) unsigned default '0',
  `mysession` varchar(35) default NULL,
  `last_post` datetime NOT NULL default '0000-00-00 00:00:00',
  `error` int(10) unsigned NOT NULL default '0',
  UNIQUE KEY `login` (`login`),
  KEY `planet_id` (`planet_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--


/*!40000 ALTER TABLE `user` DISABLE KEYS */;
LOCK TABLES `user` WRITE;
INSERT INTO `user` VALUES ('admin','admin4','myphppa@web.de',1,NULL,'0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00',NULL,'00:00:00','','http://khan.stoney.cinetic.de/img','0000-00-00 00:00:00',0,NULL,'0000-00-00 00:00:00',0),('moderator','moderator4','myphppa@web.de',2,NULL,'0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00',NULL,'00:00:00','','http://khan.stoney.cinetic.de/img','0000-00-00 00:00:00',0,NULL,'0000-00-00 00:00:00',0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

