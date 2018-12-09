# Host: localhost  (Version: 5.5.53)
# Date: 2018-12-09 17:18:23
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "on_past_plan"
#

CREATE TABLE `on_past_plan` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `sj_year` varchar(255) DEFAULT NULL,
  `sj_id_bean` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "on_past_plan"
#

INSERT INTO `on_past_plan` VALUES (6,'2018','27,33,39,45,51,57,63,69,24,30,36,42,48,54,60,66,28,26,23,29,32,34,35,38,40,41,44,46,47,50,52,53,56,58,59,62,64,65,68,70,25,31,37,43,49,55,61,67,');
