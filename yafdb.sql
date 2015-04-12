-- MySQL dump 10.13  Distrib 5.5.42, for Linux (i686)
--
-- Host: localhost    Database: yafdb
-- ------------------------------------------------------
-- Server version	5.5.42-cll-lve

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
-- Table structure for table `access`
--

DROP TABLE IF EXISTS `access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) NOT NULL,
  `module` varchar(50) DEFAULT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `access`
--

LOCK TABLES `access` WRITE;
/*!40000 ALTER TABLE `access` DISABLE KEYS */;
INSERT INTO `access` VALUES (2,23,0,NULL),(3,20,0,NULL),(3,19,0,NULL),(3,18,0,NULL),(3,16,0,NULL),(3,14,0,NULL),(3,13,0,NULL),(3,12,0,NULL),(3,9,0,NULL),(3,7,0,NULL),(3,6,0,NULL),(2,22,0,NULL),(2,21,0,NULL),(2,20,0,NULL),(2,19,0,NULL),(2,18,0,NULL),(2,17,0,NULL),(2,16,0,NULL),(2,15,0,NULL),(2,14,0,NULL),(2,13,0,NULL),(2,12,0,NULL),(2,9,0,NULL),(3,5,0,NULL),(3,4,0,NULL),(2,7,0,NULL),(2,6,0,NULL),(2,5,0,NULL),(2,4,0,NULL),(2,3,0,NULL),(2,2,0,NULL),(2,11,0,NULL),(2,10,0,NULL),(2,1,0,NULL),(3,3,0,NULL),(3,2,0,NULL),(3,11,0,NULL),(3,10,0,NULL),(3,1,0,NULL),(3,21,0,NULL),(3,22,0,NULL),(3,23,0,NULL);
/*!40000 ALTER TABLE `access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msg`
--

DROP TABLE IF EXISTS `msg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msg` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `msg_name` varchar(20) NOT NULL,
  `msg_content` text NOT NULL,
  `submit_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msg`
--

LOCK TABLES `msg` WRITE;
/*!40000 ALTER TABLE `msg` DISABLE KEYS */;
INSERT INTO `msg` VALUES (29,'汗','ok啦！！！',1427106949),(8,'我了歌曲','我来了，北京',1427037943),(4,'panda','^_^，哈哈哈，我知道你是',1427034735),(7,'青','师礼，我知道你是，哈哈',1427036730),(9,'哈哈','我又来了',1427069321),(10,'^_^','really?现在是见证奇迹的时候了',1427073464),(16,'哈喽','',1427223632),(12,'^_^','现在是见证奇迹的时候了',1427069480),(13,'^_^','no,yy',1427073446),(17,'345345','345345345345',1427110240),(18,'第三方 ','发打算速度个',1427110423),(19,'和','领导司法局塑料袋',1427110603),(20,'我了','挥洒符合考虑撒旦',1427110625),(31,'在','吗',1427218944),(22,'ok','yes，网购',1427112533),(30,'2342342','34234234',1427107544),(24,'happy','^_^啊哈哈',1427114648),(26,'helllo','&lt;script&gt;alert(\'hello\')&lt;/script&gt;',1427122936);
/*!40000 ALTER TABLE `msg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `node`
--

DROP TABLE IF EXISTS `node`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  `sort` smallint(6) unsigned DEFAULT NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `node`
--

LOCK TABLES `node` WRITE;
/*!40000 ALTER TABLE `node` DISABLE KEYS */;
INSERT INTO `node` VALUES (1,'Index','IndexModule',1,'Module',0,0,0),(2,'Admin','AdminModule',1,'Module',0,0,0),(3,'Index','Index',1,'Controller',0,2,0),(4,'index','index',1,'Action',0,3,0),(5,'Login','Login',1,'Controller',0,2,0),(6,'index','index',1,'Action',0,5,0),(7,'loginH','loginH',1,'Action',0,5,0),(9,'logout','logoutAction',1,'Action',0,5,0),(10,'Index','IndexController',1,'Controller',0,1,0),(11,'index','indexAction',1,'Action',0,10,0),(12,'Node','NodeController',1,'Controller',0,2,0),(13,'index','indexAction',1,'Action',0,12,0),(14,'add','addAction',1,'Action',0,12,0),(15,'addhandle','addhandleAction',1,'Action',0,12,0),(16,'edit','editAction',1,'Action',0,12,0),(17,'edithandle','edithandleAction',1,'Action',0,12,0),(18,'Role','RoleController',1,'Controller',0,2,0),(19,'index','indexAction',1,'Action',0,18,0),(20,'edit','editAction',1,'Action',0,18,0),(21,'User','UserController',1,'Controller',0,2,0),(22,'index','indexAction',1,'Action',0,21,0),(23,'add','addAction',1,'Action',0,21,0);
/*!40000 ALTER TABLE `node` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (2,'超级管理员',0,1,'超级管理员'),(3,'会员',0,1,'会员'),(4,'编辑',0,1,'编辑');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_user` (
  `role_id` mediumint(9) unsigned NOT NULL,
  `user_id` char(32) NOT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` VALUES (2,'11'),(3,'9');
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `password` char(32) NOT NULL,
  `register_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (10,'admin','21232f297a57a5a743894a0e4a801fc3',1427686595),(11,'panda','ce61649168c4550c2f7acab92354dc6e',1427686608),(9,'hunhun','d8a77dc7df2c6abfe1730e1fe0cfb315',1427713049);
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

-- Dump completed on 2015-04-12 13:32:18
