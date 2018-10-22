/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : sj_1

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-10-22 15:12:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `on_config`
-- ----------------------------
DROP TABLE IF EXISTS `on_config`;
CREATE TABLE `on_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dname` varchar(100) NOT NULL COMMENT '部门名称',
  `dename` varchar(100) NOT NULL COMMENT '英文缩写',
  `pid` int(11) DEFAULT '0',
  `dstatus` tinyint(1) DEFAULT '1' COMMENT '状态',
  `dsort` smallint(6) DEFAULT '0' COMMENT '排序',
  `dcontent` text COMMENT '备注',
  `time` int(11) DEFAULT '0',
  `utime` int(11) DEFAULT '0' COMMENT '最后更新时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='部门表';

-- ----------------------------
-- Records of on_config
-- ----------------------------
INSERT INTO `on_config` VALUES ('1', '审计对象', 'sjdx', '0', '1', '1', '审计对象', '1455774424', '1540124298');
INSERT INTO `on_config` VALUES ('4', '审计对象分类', 'sjdx_fl', '1', '1', '0', '', '1455854755', '1540124337');
INSERT INTO `on_config` VALUES ('5', '审计对象周期', 'sjdx_zq', '1', '1', '1', '', '1455855690', '1540124361');
INSERT INTO `on_config` VALUES ('6', '预算类别', 'sjdx_yslb', '1', '1', '2', '', '1455855702', '1540124819');
INSERT INTO `on_config` VALUES ('7', '预算类', 'sjdx_yslb_ysl', '6', '1', '0', '', '1455855740', '1540124875');
INSERT INTO `on_config` VALUES ('9', '政府', 'sjdx_fl_zf', '4', '1', '1', '', '1540124404', '0');
INSERT INTO `on_config` VALUES ('10', '市委', 'sjdx_fl_sw', '4', '1', '0', '', '1540124435', '0');
INSERT INTO `on_config` VALUES ('11', '市人大', 'sjdx_fl_srd', '4', '1', '2', '', '1540124462', '0');
INSERT INTO `on_config` VALUES ('12', '市政协', 'sjdx_fl_szx', '4', '1', '3', '', '1540124487', '0');
INSERT INTO `on_config` VALUES ('13', '市属国有企业', 'sjdx_fl_gyqy', '4', '1', '5', '', '1540124514', '0');
INSERT INTO `on_config` VALUES ('14', '市直属事业单位', 'sjdx_fl_sydw', '4', '1', '4', '', '1540124540', '0');
INSERT INTO `on_config` VALUES ('15', '社会团体', 'sjdx_fl_shtt', '4', '1', '6', '', '1540124559', '0');
INSERT INTO `on_config` VALUES ('16', '其他(含检法)', 'sjdx_fl_qt', '4', '1', '7', '', '1540124593', '0');
INSERT INTO `on_config` VALUES ('17', '1', 'sjdx_zq_1', '5', '1', '0', '', '1540124704', '0');
INSERT INTO `on_config` VALUES ('18', '2', 'sjdx_zq_2', '5', '1', '0', '', '1540124721', '0');
INSERT INTO `on_config` VALUES ('19', '3', 'sjdx_zq_3', '5', '1', '2', '', '1540124744', '0');
INSERT INTO `on_config` VALUES ('20', '4', 'sjdx_zq_4', '5', '1', '3', '', '1540124766', '0');
INSERT INTO `on_config` VALUES ('21', '5', 'sjdx_zq_5', '5', '1', '4', '', '1540124782', '0');
INSERT INTO `on_config` VALUES ('22', '非预算类(企业、经营性事业单位)', 'sjdx_yslb_fysl', '6', '1', '1', '', '1540124902', '0');
