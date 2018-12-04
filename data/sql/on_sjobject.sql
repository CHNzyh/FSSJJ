# Host: localhost  (Version: 5.5.53)
# Date: 2018-12-04 22:33:14
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
  `department` varchar(255) DEFAULT NULL COMMENT '关联到所属部门',
  `cid` varchar(255) DEFAULT NULL COMMENT '子id  关联到detail表上',
  `FRDWDM` varchar(255) DEFAULT NULL COMMENT '法人单位代码',
  `FRDWQC` varchar(255) DEFAULT NULL COMMENT '法人单位全称',
  `NSRBM` varchar(255) DEFAULT NULL COMMENT '纳税人编码',
  `DWCLSJ` varchar(255) DEFAULT NULL COMMENT '单位成立时间',
  `DQFDDBR` varchar(255) DEFAULT NULL COMMENT '当前的法人',
  `BSJDWFL` varchar(255) DEFAULT NULL COMMENT '被审计单位分类（下拉菜单）',
  `SJZQ` varchar(255) DEFAULT NULL COMMENT '审计周期（下拉菜单）',
  `SJQK` varchar(255) DEFAULT '' COMMENT '审计情况',
  `YSLB` varchar(255) DEFAULT NULL COMMENT '预算类别（下拉菜单）',
  `JJBZFS` varchar(255) DEFAULT NULL COMMENT '经济保障方式',
  `LY` varchar(255) DEFAULT NULL COMMENT '领域',
  `XZQH_XZ` varchar(255) DEFAULT NULL COMMENT '行政区划-乡镇',
  `XZQH_JDBSC` varchar(255) DEFAULT NULL COMMENT '行政区划-街道办事处',
  `XZQH_SDXM` varchar(255) DEFAULT NULL COMMENT '行政区划-省地县码（地域）',
  `TXHM_DHHM` varchar(255) DEFAULT NULL COMMENT '通信号码_电话号码',
  `TXHM_YZBM` varchar(255) DEFAULT NULL COMMENT '通信号码_邮政编码',
  PRIMARY KEY (`id`),
  KEY `DQFDDBR` (`DQFDDBR`) COMMENT '根据当前法定代表人排序',
  KEY `department` (`department`) COMMENT '根据关联的部门进行排序'
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='审计对象表';
