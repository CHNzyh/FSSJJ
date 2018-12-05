/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : sj_1

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-12-05 22:16:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `on_sharedatalog`
-- ----------------------------
DROP TABLE IF EXISTS `on_sharedatalog`;
CREATE TABLE `on_sharedatalog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `s_id` int(11) DEFAULT NULL COMMENT '下载文件ID',
  `s_did` int(11) DEFAULT '0' COMMENT '下载人所属部门',
  `s_uid` int(11) DEFAULT '0' COMMENT '下载人',
  `s_time` int(11) DEFAULT '0' COMMENT '下载时间',
  `s_ip` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
