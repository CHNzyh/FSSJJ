/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : sj_1

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-10-22 15:10:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `on_saredatalog`
-- ----------------------------
DROP TABLE IF EXISTS `on_saredatalog`;
CREATE TABLE `on_saredatalog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `s_id` int(11) DEFAULT NULL COMMENT '下载文件ID',
  `s_did` int(11) DEFAULT '0' COMMENT '下载人所属部门',
  `s_uid` int(11) DEFAULT '0' COMMENT '下载人',
  `s_stime` int(11) DEFAULT '0' COMMENT '下载时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of on_saredatalog
-- ----------------------------
