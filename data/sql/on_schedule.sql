/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : sj_1

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-11-13 22:13:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `on_schedule`
-- ----------------------------
DROP TABLE IF EXISTS `on_schedule`;
CREATE TABLE `on_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(255) DEFAULT NULL COMMENT '项目名称',
  `s_did` int(11) DEFAULT NULL COMMENT '部门ID',
  `s_aid` int(11) DEFAULT NULL COMMENT '主审',
  `s_catalog` varchar(255) DEFAULT NULL COMMENT '上传目录',
  `s_file_1_url` varchar(255) DEFAULT NULL,
  `s_file_1_time` int(11) DEFAULT NULL,
  `s_file_2_url` varchar(255) DEFAULT NULL,
  `s_file_2_time` int(11) DEFAULT NULL,
  `s_file_3_url` varchar(255) DEFAULT NULL,
  `s_file_3_time` int(11) DEFAULT NULL,
  `s_file_4_url` varchar(255) DEFAULT NULL,
  `s_file_4_time` int(11) DEFAULT NULL,
  `s_file_5_url` varchar(255) DEFAULT NULL,
  `s_file_5_time` int(11) DEFAULT NULL,
  `s_file_6_url` varchar(255) DEFAULT NULL,
  `s_file_6_time` int(11) DEFAULT NULL,
  `s_file_7_url` varchar(255) DEFAULT NULL,
  `s_file_7_time` int(11) DEFAULT NULL,
  `s_status` smallint(1) DEFAULT '0' COMMENT '项目状态：0为未完成1为完成',
  `s_content` text COMMENT '备注',
  `s_ip` char(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of on_schedule
-- ----------------------------
INSERT INTO `on_schedule` VALUES ('1', '111', '6', '11', '/Schedule/b/2018-11-04/', '/Schedule/b/2018-11-04/5bead0fcec16f.txt', '1542115585', '/Schedule/b/2018-11-04/5bdefe0e70d18.txt', '1541340688', '/Schedule/b/2018-11-04/5bead1ec09e1c.txt', '1542115825', null, null, null, null, null, null, null, null, '0', '121212', '127.0.0.1');
