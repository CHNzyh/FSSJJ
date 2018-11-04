/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : sj_1

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-11-04 19:36:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `on_upfile`
-- ----------------------------
DROP TABLE IF EXISTS `on_upfile`;
CREATE TABLE `on_upfile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `u_name` varchar(255) DEFAULT NULL COMMENT '上传文件名称',
  `u_did` int(11) DEFAULT NULL COMMENT '上传科室',
  `u_aid` int(11) DEFAULT NULL COMMENT '上传人员',
  `u_url` varchar(255) DEFAULT NULL COMMENT '上传目录',
  `u_file` varchar(255) DEFAULT NULL COMMENT '文件路径',
  `u_type` smallint(2) DEFAULT NULL COMMENT '上传文档类型',
  `u_tim` int(11) DEFAULT NULL COMMENT '上传时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of on_upfile
-- ----------------------------
