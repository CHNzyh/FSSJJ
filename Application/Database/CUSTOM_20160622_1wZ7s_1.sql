# -----------------------------------------------------------
# PHP-Amateur database backup files
# Blog: http://blog.51edm.org
# Type: 管理员后台手动备份
# Description:当前SQL文件包含了表：on_project、on_projectfile的结构信息，表：on_project、on_projectfile的数据
# Time: 2016-06-22 10:52:44
# -----------------------------------------------------------
# 当前SQL卷标：#1
# -----------------------------------------------------------


# 数据库表：on_project 结构信息
DROP TABLE IF EXISTS `on_project`;
CREATE TABLE `on_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pname` varchar(255) DEFAULT NULL COMMENT '项目名称',
  `pcode` varchar(255) DEFAULT NULL COMMENT '项目代码',
  `pcompany` varchar(255) DEFAULT NULL COMMENT '审计单位',
  `pcompany_id` int(11) DEFAULT NULL COMMENT '审计单位ID',
  `pdepaid` int(11) DEFAULT '0' COMMENT '所属部门ID',
  `pleader` varchar(255) DEFAULT NULL COMMENT '组长',
  `pcrew` varchar(255) DEFAULT NULL COMMENT '组员',
  `pbtime` int(11) DEFAULT NULL COMMENT '开始时间',
  `petime` int(11) DEFAULT NULL COMMENT '结束时间',
  `ptime` int(11) DEFAULT NULL COMMENT '项目添加时间',
  `pstatus` smallint(6) DEFAULT '1' COMMENT '状态',
  `pcontent` text COMMENT '备注',
  `pupdate_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `po_user` int(11) DEFAULT NULL COMMENT '添加人员',
  `pip` varchar(100) DEFAULT NULL COMMENT '添加IP',
  `ppath` varchar(255) DEFAULT NULL COMMENT '上传路径',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='项目表' ;

# 数据库表：on_projectfile 结构信息
DROP TABLE IF EXISTS `on_projectfile`;
CREATE TABLE `on_projectfile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pfname` varchar(255) DEFAULT NULL COMMENT '文件名称',
  `pid` int(11) DEFAULT '0' COMMENT '所属项目',
  `cid` int(11) DEFAULT '0' COMMENT '审计企业ID',
  `pdepaid` int(11) DEFAULT '0' COMMENT '所属部门',
  `projectpath` varchar(255) DEFAULT NULL COMMENT '项目目录',
  `pfpath` varchar(255) DEFAULT NULL COMMENT '文件地址',
  `pffname` varchar(255) DEFAULT NULL COMMENT '文件名称',
  `pftype` int(11) DEFAULT NULL,
  `pftype_1` varchar(255) DEFAULT NULL COMMENT '文件类型',
  `pftype_2` varchar(255) DEFAULT NULL COMMENT '文件类型',
  `pfbtime` int(11) DEFAULT '0' COMMENT '开始时间',
  `pfetime` int(11) DEFAULT '0' COMMENT '结束 时间',
  `pftime` int(11) DEFAULT '0' COMMENT '添加时间',
  `pfupdatetime` int(11) DEFAULT '0' COMMENT '修改时间',
  `pfcontent` text COMMENT '备注',
  `pfstatus` smallint(11) DEFAULT '1' COMMENT '状态',
  `pf_user` int(11) DEFAULT '0' COMMENT '操作人员',
  `pf_ip` varchar(100) DEFAULT NULL COMMENT '最后操作IP',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='项目文件表' ;



# 数据库表：on_project 数据信息
INSERT INTO `on_project` VALUES ('1','a1','123','C企业','2','4','12','||12||,||13||','1459440000','1460736000','','1','','1461829997','12','127.0.0.1','a1/123');
INSERT INTO `on_project` VALUES ('2','a1','1234','C企业','2','4','11','||12||,||13||','1459440000','1459526400','','1','','1461830145','12','127.0.0.1','a1/1234');
INSERT INTO `on_project` VALUES ('3','a1','12345','C企业','2','4','11','||12||,||13||','1459440000','1460044800','','1','','1461830815','12','127.0.0.1','a1/12345');
INSERT INTO `on_project` VALUES ('4','a1','辽第1号','C企业','2','4','11','||12||,||13||','1459267200','1460044800','','1','','1461830894','12','127.0.0.1','a1/辽第1号');
INSERT INTO `on_project` VALUES ('5','a1','抚顺财政','C企业','2','4','11','||12||,||13||','1459699200','1462291200','','1','','1461830966','12','127.0.0.1','a1/抚顺财政');
INSERT INTO `on_project` VALUES ('6','11','222','C企业','2','4','13','||12||,||11||','1459180800','1459353600','','1','','1461902727','12','127.0.0.1','a1/222');
INSERT INTO `on_project` VALUES ('7','普通审计项目2','20160811','C企业','2','4','12','||11||,||13||','1459094400','1461340800','','1','123','1464068711','12','127.0.0.1','a1/20160811');


# 数据库表：on_projectfile 数据信息
INSERT INTO `on_projectfile` VALUES ('8','asdfasdf','7','2','4','a1/20160811','Finance/AOExplain','','5','','','0','0','1464069685','0','','1','12','127.0.0.1');
INSERT INTO `on_projectfile` VALUES ('9','a123b1','7','2','4','a1/20160811','Finance','','1','','','1462032000','1464278400','1464073581','1464140455','abc123','1','12','127.0.0.1');
INSERT INTO `on_projectfile` VALUES ('10','aaaaaaaa','7','2','4','a1/20160811','Finance/DataDictionary','a1/20160811/Finance/DataDictionary/20160603133630/page_000001.jpg','10','','','1464537600','1465488000','1464932728','1465802539','123','1','12','127.0.0.1');
INSERT INTO `on_projectfile` VALUES ('11','aaaddff','7','2','4','a1/20160811','Finance/DataDictionary','a1/20160811/Finance/DataDictionary/20160613152242/page_000008.jpg','10','','','1466524800','1467216000','1465802595','0','123','1','12','127.0.0.1');
