/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : sj_1

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-12-02 20:48:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `on_task`
-- ----------------------------
DROP TABLE IF EXISTS `on_task`;
CREATE TABLE `on_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `t_name` varchar(255) DEFAULT NULL COMMENT '任务名称',
  `t_stime` int(11) DEFAULT NULL COMMENT '任务开始时间',
  `t_etime` int(11) DEFAULT NULL COMMENT '任务结束时间',
  `t_url` varchar(255) DEFAULT NULL COMMENT '任务上传文件目录',
  `t_content` text COMMENT '备注',
  `t_dname` text COMMENT '任务科室',
  `t_dename` text COMMENT '完成任务科室',
  `t_dsum` smallint(2) DEFAULT '0' COMMENT '任务科室总数',
  `t_desum` smallint(2) DEFAULT '0' COMMENT '完成任务科室总数',
  `t_time` int(11) DEFAULT NULL COMMENT '上传时间',
  `t_utime` int(11) DEFAULT NULL COMMENT '编辑时间',
  `t_uid` int(11) DEFAULT NULL COMMENT '任务发起人',
  `t_status` smallint(1) DEFAULT '0' COMMENT '任务状态：0为未完成1为已完成',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of on_task
-- ----------------------------
INSERT INTO `on_task` VALUES ('1', '111', '1543075200', '1545667200', '/Task/2018-11-25/', '222', '|4|,|6|,|5|', null, '3', '0', null, null, '10', '0');
INSERT INTO `on_task` VALUES ('2', 'abcd1', '1543680000', '1546358400', '/Task/2018-12-02/', '', '|4|,|6|,|1|,|5|,|7|', null, '5', '0', null, null, '10', '0');
