# Host: localhost  (Version: 5.5.53)
# Date: 2018-12-02 22:09:44
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "on_corporation"
#

CREATE TABLE `on_corporation` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `sjid` int(11) NOT NULL DEFAULT '0' COMMENT '关联到审计对象的id',
  `startTime` int(11) DEFAULT NULL COMMENT '时间，以年度为单位',
  `endTime` varchar(255) DEFAULT NULL,
  `corporation` varchar(255) DEFAULT NULL COMMENT '法人代表',
  `explain` varchar(255) DEFAULT NULL,
  `modify_time` varchar(255) DEFAULT NULL COMMENT '最近一次修改的时间',
  PRIMARY KEY (`id`),
  KEY `sjid` (`sjid`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='审计对象表';

#
# Data for table "on_corporation"
#

INSERT INTO `on_corporation` VALUES (19,26,1538323200,'1538668800','111','111',NULL),(21,26,1538582400,'1540915200','333','333',NULL),(22,26,1538582400,'1539878400','789','457',NULL),(23,27,1541433600,'1541692800','6661','777',NULL);
