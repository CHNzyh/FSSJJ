# Host: localhost  (Version: 5.5.53)
# Date: 2018-11-04 21:56:28
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "on_situation"
#

DROP TABLE IF EXISTS `on_situation`;
CREATE TABLE `on_situation` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `sjid` int(11) NOT NULL DEFAULT '0' COMMENT '关联到审计对象的id',
  `startTime` int(11) DEFAULT NULL COMMENT '时间，以年度为单位',
  `endTime` varchar(255) DEFAULT NULL,
  `situation` varchar(255) DEFAULT NULL COMMENT '审计情况文件  这里存url',
  `explain` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '审计情况名称',
  PRIMARY KEY (`id`),
  KEY `sjid` (`sjid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='审计对象表';

#
# Data for table "on_situation"
#

/*!40000 ALTER TABLE `on_situation` DISABLE KEYS */;
INSERT INTO `on_situation` VALUES (1,26,1541692800,'1542902400',NULL,'444','444'),(2,26,1541260800,'1542211200',NULL,'777','666');
/*!40000 ALTER TABLE `on_situation` ENABLE KEYS */;
