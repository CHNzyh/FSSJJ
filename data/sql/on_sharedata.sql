/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : sj_1

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-10-25 15:06:17
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `on_sharedata`
-- ----------------------------
DROP TABLE IF EXISTS `on_sharedata`;
CREATE TABLE `on_sharedata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(255) DEFAULT NULL COMMENT '共享文件名称',
  `s_company` varchar(255) DEFAULT NULL COMMENT '数据提供单位名称',
  `s_linkman` varchar(100) DEFAULT NULL COMMENT '数据提供人名称',
  `s_did` int(11) DEFAULT '0' COMMENT '所属部门',
  `s_uid` int(11) DEFAULT '0' COMMENT '上传人',
  `s_stime` int(11) DEFAULT NULL COMMENT '有效开始时间',
  `s_etime` int(11) DEFAULT NULL COMMENT '有效结束时间',
  `s_url` varchar(255) DEFAULT NULL COMMENT '文件路径',
  `s_content` text COMMENT '数据提供主要信息或要素',
  `s_content1` text COMMENT '备注',
  `s_time` int(11) DEFAULT NULL COMMENT '上传时间',
  `s_hit` int(11) DEFAULT '0' COMMENT '下载次数',
  `s_ip` varchar(16) DEFAULT NULL COMMENT '上传IP',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of on_sharedata
-- ----------------------------
INSERT INTO `on_sharedata` VALUES ('1', '111', null, null, '4', '11', null, null, '/sharedata/a1/20181021/360base.dll', '1212', null, '1540213419', '0', '127.0.0.1');
INSERT INTO `on_sharedata` VALUES ('2', '12121', null, null, '4', '11', null, null, '/sharedata/a1/20181021/config.php', '1212121212', null, '1540213648', '0', '127.0.0.1');
