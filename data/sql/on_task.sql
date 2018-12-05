/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : sj_1

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-12-05 22:16:33
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
  `t_class` varchar(100) DEFAULT '' COMMENT '任务类型',
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
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
