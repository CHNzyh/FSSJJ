# Host: localhost  (Version: 5.5.53)
# Date: 2018-12-02 22:10:19
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "on_sjinfo"
#

CREATE TABLE `on_sjinfo` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `sjid` int(11) NOT NULL DEFAULT '0' COMMENT '关联到审计对象的id',
  `time` int(11) DEFAULT NULL COMMENT '时间，以年度为单位',
  `info` varchar(255) DEFAULT NULL COMMENT '审计情况',
  `modify_time` varchar(255) DEFAULT NULL COMMENT '最近一次修改的时间',
  PRIMARY KEY (`id`),
  KEY `sjid` (`sjid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='审计对象表';

#
# Data for table "on_sjinfo"
#

INSERT INTO `on_sjinfo` VALUES (1,18,2017,'挺好',NULL),(2,18,2018,'一般',NULL),(3,18,2019,'不咋地',NULL);
