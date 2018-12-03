# Host: localhost  (Version: 5.5.53)
# Date: 2018-12-02 22:09:55
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "on_sjobject"
#

CREATE TABLE `on_sjobject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `did` varchar(255) DEFAULT NULL COMMENT '部门id',
  `modify_time` varchar(255) DEFAULT NULL COMMENT '最近一次修改的时间',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `department` int(11) DEFAULT NULL COMMENT '关联到所属部门',
  `cid` int(11) DEFAULT NULL COMMENT '子id  关联到detail表上',
  `FRDWDM` varchar(255) DEFAULT NULL COMMENT '法人单位代码',
  `FRDWQC` varchar(255) DEFAULT NULL COMMENT '法人单位全称',
  `NSRBM` varchar(255) DEFAULT NULL COMMENT '纳税人编码',
  `DWCLSJ` varchar(255) DEFAULT NULL COMMENT '单位成立时间',
  `DQFDDBR` varchar(255) DEFAULT NULL COMMENT '当前的法人',
  `BSJDWFL` varchar(255) DEFAULT NULL COMMENT '被审计单位分类（下拉菜单）',
  `SJZQ` varchar(255) DEFAULT NULL COMMENT '审计周期（下拉菜单）',
  `SJQK` text COMMENT '审计情况',
  `YSLB` varchar(255) DEFAULT NULL COMMENT '预算类别（下拉菜单）',
  `JJBZFS` varchar(255) DEFAULT NULL COMMENT '经济保障方式',
  `LY` varchar(255) DEFAULT NULL COMMENT '领域',
  `XZQH_XZ` varchar(255) DEFAULT NULL COMMENT '行政区划-乡镇',
  `XZQH_JDBSC` varchar(255) DEFAULT NULL COMMENT '行政区划-街道办事处',
  `XZQH_SDXM` varchar(255) DEFAULT NULL COMMENT '行政区划-省地县码（地域）',
  `TXHM_DHHM` int(11) DEFAULT NULL COMMENT '通信号码_电话号码',
  `TXHM_YZBM` int(11) DEFAULT NULL COMMENT '通信号码_邮政编码',
  PRIMARY KEY (`id`),
  KEY `DQFDDBR` (`DQFDDBR`) COMMENT '根据当前法定代表人排序',
  KEY `department` (`department`) COMMENT '根据关联的部门进行排序'
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='审计对象表';

#
# Data for table "on_sjobject"
#

INSERT INTO `on_sjobject` VALUES (23,'0',NULL,'呀呀呀',NULL,NULL,'11','','','','',NULL,'3',NULL,NULL,'','','','','',0,0),(24,'1',NULL,'88',NULL,NULL,'','','','','',NULL,'2',NULL,NULL,'','','','','',0,0),(25,'4',NULL,'777',NULL,NULL,'1','2','3','8','6',NULL,'4',NULL,NULL,'9','10','11','13','15',17,20),(26,'5',NULL,'123123123',NULL,NULL,'333','444','888','','',NULL,'1',NULL,NULL,'','','','','',0,0),(27,'6',NULL,'987444',NULL,NULL,'','','','',NULL,NULL,NULL,NULL,NULL,'','','','','',0,0),(28,'0','1543759693','444',NULL,NULL,'','','','',NULL,NULL,NULL,NULL,NULL,'','','','','',0,0);
