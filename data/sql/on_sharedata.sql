/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : sj_1

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-10-22 15:10:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `on_sharedata`
-- ----------------------------
DROP TABLE IF EXISTS `on_sharedata`;
CREATE TABLE `on_sharedata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(255) DEFAULT NULL COMMENT '共享文件名称',
  `s_did` int(11) DEFAULT '0' COMMENT '所属部门',
  `s_uid` int(11) DEFAULT '0' COMMENT '上传人',
  `s_url` varchar(255) DEFAULT NULL COMMENT '文件路径',
  `s_time` int(11) DEFAULT NULL COMMENT '上传时间',
  `s_hit` int(11) DEFAULT '0' COMMENT '下载次数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of on_sharedata
-- ----------------------------
