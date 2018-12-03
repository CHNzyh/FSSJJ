# Host: localhost  (Version: 5.5.53)
# Date: 2018-12-02 22:10:24
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "on_situation"
#

CREATE TABLE `on_situation` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `sjid` int(11) NOT NULL DEFAULT '0' COMMENT '关联到审计对象的id',
  `startTime` int(11) DEFAULT NULL COMMENT '时间，以年度为单位',
  `endTime` varchar(255) DEFAULT NULL,
  `situation` varchar(255) DEFAULT NULL COMMENT '审计情况文件  这里存url',
  `explain` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '审计情况名称',
  `uploadUrl` varchar(255) DEFAULT NULL,
  `modify_time` varchar(255) DEFAULT NULL COMMENT '最近一次修改的时间',
  PRIMARY KEY (`id`),
  KEY `sjid` (`sjid`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='审计对象表';

#
# Data for table "on_situation"
#

INSERT INTO `on_situation` VALUES (10,27,1541606400,'1542902400',NULL,'56856','123123','/Situation/2018-11-21/5bf56e09c7041.docx',NULL),(11,28,0,'0',NULL,'','123','','1543759759');
