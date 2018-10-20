# -----------------------------------------------------------
# PHP-Amateur database backup files
# Blog: http://blog.51edm.org
# Type: 系统自动备份
# Description:当前SQL文件包含了表：on_access、on_admin、on_company、on_department、on_log、on_node、on_pfile、on_project、on_projectfile、on_role、on_role_user的结构信息，表：on_access、on_admin、on_company、on_department、on_log、on_node、on_pfile、on_project、on_projectfile、on_role、on_role_user的数据
# Time: 2018-07-28 14:46:12
# -----------------------------------------------------------
# 当前SQL卷标：#1
# -----------------------------------------------------------


# 数据库表：on_access 结构信息
DROP TABLE IF EXISTS `on_access`;
CREATE TABLE `on_access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) NOT NULL,
  `pid` smallint(6) DEFAULT NULL,
  `module` varchar(50) DEFAULT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限分配表' ;

# 数据库表：on_admin 结构信息
DROP TABLE IF EXISTS `on_admin`;
CREATE TABLE `on_admin` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(20) DEFAULT NULL,
  `realname` varchar(100) DEFAULT NULL COMMENT '真实姓名',
  `email` varchar(50) DEFAULT NULL COMMENT '登录账号',
  `pwd` char(32) DEFAULT NULL COMMENT '登录密码',
  `status` int(11) DEFAULT '1' COMMENT '账号状态',
  `remark` varchar(255) DEFAULT '' COMMENT '备注信息',
  `find_code` char(5) DEFAULT NULL COMMENT '找回账号验证码',
  `phone` varchar(20) DEFAULT NULL COMMENT '电话',
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机',
  `department` int(11) DEFAULT '0' COMMENT '所属部门',
  `time` int(10) DEFAULT NULL COMMENT '开通时间',
  `utime` int(11) DEFAULT '0',
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='网站后台管理员表' ;

# 数据库表：on_company 结构信息
DROP TABLE IF EXISTS `on_company`;
CREATE TABLE `on_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cname` varchar(255) DEFAULT '' COMMENT '企业名称',
  `cename` varchar(255) DEFAULT '' COMMENT '英文名称',
  `cphone` varchar(50) DEFAULT '' COMMENT '联系电话',
  `ccontact` varchar(100) DEFAULT '' COMMENT '联系人',
  `caddress` varchar(255) DEFAULT '' COMMENT '地址',
  `cemail` varchar(100) DEFAULT '' COMMENT '邮箱',
  `cstatus` tinyint(1) DEFAULT '1' COMMENT '状态',
  `ccontent` text COMMENT '备注',
  `ctime` int(11) DEFAULT NULL COMMENT '添加时间',
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cname` (`cname`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='企业表' ;

# 数据库表：on_department 结构信息
DROP TABLE IF EXISTS `on_department`;
CREATE TABLE `on_department` (
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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='部门表' ;

# 数据库表：on_log 结构信息
DROP TABLE IF EXISTS `on_log`;
CREATE TABLE `on_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modname` varchar(50) NOT NULL COMMENT '模块名称',
  `actname` varchar(50) NOT NULL COMMENT '操作名称',
  `lcontent` text COMMENT '内容',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '所属用户',
  `ip` varchar(50) NOT NULL COMMENT 'IP',
  `ltime` int(11) DEFAULT '0' COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=210 DEFAULT CHARSET=utf8 COMMENT='日志表' ;

# 数据库表：on_node 结构信息
DROP TABLE IF EXISTS `on_node`;
CREATE TABLE `on_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  `sort` smallint(6) unsigned DEFAULT NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  `menu` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为菜单',
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=141 DEFAULT CHARSET=utf8 COMMENT='权限节点表' ;

# 数据库表：on_pfile 结构信息
DROP TABLE IF EXISTS `on_pfile`;
CREATE TABLE `on_pfile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dname` varchar(100) NOT NULL COMMENT '名称',
  `dename` varchar(255) NOT NULL COMMENT '目录地址',
  `purl` varchar(255) DEFAULT NULL,
  `pid` int(11) DEFAULT '0',
  `dstatus` tinyint(1) DEFAULT '1' COMMENT '状态',
  `dsort` smallint(6) DEFAULT '0' COMMENT '排序',
  `dcontent` text COMMENT '备注',
  `time` int(11) DEFAULT '0',
  `utime` int(11) DEFAULT '0' COMMENT '最后更新时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='部门表' ;

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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='项目文件表' ;

# 数据库表：on_role 结构信息
DROP TABLE IF EXISTS `on_role`;
CREATE TABLE `on_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `sort` int(11) DEFAULT '0',
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='权限角色表' ;

# 数据库表：on_role_user 结构信息
DROP TABLE IF EXISTS `on_role_user`;
CREATE TABLE `on_role_user` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户角色表' ;



# 数据库表：on_access 数据信息
INSERT INTO `on_access` VALUES ('2','94','3','90','');
INSERT INTO `on_access` VALUES ('2','93','3','90','');
INSERT INTO `on_access` VALUES ('2','92','3','90','');
INSERT INTO `on_access` VALUES ('2','91','3','90','');
INSERT INTO `on_access` VALUES ('2','90','2','1','');
INSERT INTO `on_access` VALUES ('2','89','3','81','');
INSERT INTO `on_access` VALUES ('2','88','3','81','');
INSERT INTO `on_access` VALUES ('2','87','3','81','');
INSERT INTO `on_access` VALUES ('2','86','3','81','');
INSERT INTO `on_access` VALUES ('2','85','3','81','');
INSERT INTO `on_access` VALUES ('3','105','3','104','');
INSERT INTO `on_access` VALUES ('3','104','2','1','');
INSERT INTO `on_access` VALUES ('3','102','3','50','');
INSERT INTO `on_access` VALUES ('3','62','3','50','');
INSERT INTO `on_access` VALUES ('3','61','3','50','');
INSERT INTO `on_access` VALUES ('3','60','3','50','');
INSERT INTO `on_access` VALUES ('3','59','3','50','');
INSERT INTO `on_access` VALUES ('3','58','3','50','');
INSERT INTO `on_access` VALUES ('3','57','3','50','');
INSERT INTO `on_access` VALUES ('3','56','3','50','');
INSERT INTO `on_access` VALUES ('3','55','3','50','');
INSERT INTO `on_access` VALUES ('3','54','3','50','');
INSERT INTO `on_access` VALUES ('3','53','3','50','');
INSERT INTO `on_access` VALUES ('3','52','3','50','');
INSERT INTO `on_access` VALUES ('4','120','3','118','');
INSERT INTO `on_access` VALUES ('4','136','3','118','');
INSERT INTO `on_access` VALUES ('4','121','3','118','');
INSERT INTO `on_access` VALUES ('4','123','3','118','');
INSERT INTO `on_access` VALUES ('4','124','3','118','');
INSERT INTO `on_access` VALUES ('4','125','3','118','');
INSERT INTO `on_access` VALUES ('2','84','3','81','');
INSERT INTO `on_access` VALUES ('2','83','3','81','');
INSERT INTO `on_access` VALUES ('2','82','3','81','');
INSERT INTO `on_access` VALUES ('2','81','2','1','');
INSERT INTO `on_access` VALUES ('2','80','3','76','');
INSERT INTO `on_access` VALUES ('2','79','3','76','');
INSERT INTO `on_access` VALUES ('2','78','3','76','');
INSERT INTO `on_access` VALUES ('2','77','3','76','');
INSERT INTO `on_access` VALUES ('2','76','2','1','');
INSERT INTO `on_access` VALUES ('2','75','3','69','');
INSERT INTO `on_access` VALUES ('2','74','3','69','');
INSERT INTO `on_access` VALUES ('2','73','3','69','');
INSERT INTO `on_access` VALUES ('2','72','3','69','');
INSERT INTO `on_access` VALUES ('2','71','3','69','');
INSERT INTO `on_access` VALUES ('2','70','3','69','');
INSERT INTO `on_access` VALUES ('2','69','2','1','');
INSERT INTO `on_access` VALUES ('2','68','3','63','');
INSERT INTO `on_access` VALUES ('2','67','3','63','');
INSERT INTO `on_access` VALUES ('3','51','3','50','');
INSERT INTO `on_access` VALUES ('3','50','2','1','');
INSERT INTO `on_access` VALUES ('3','8','3','14','');
INSERT INTO `on_access` VALUES ('3','14','2','1','');
INSERT INTO `on_access` VALUES ('3','13','3','4','');
INSERT INTO `on_access` VALUES ('3','12','3','4','');
INSERT INTO `on_access` VALUES ('3','11','3','4','');
INSERT INTO `on_access` VALUES ('3','10','3','4','');
INSERT INTO `on_access` VALUES ('3','4','2','1','');
INSERT INTO `on_access` VALUES ('3','7','3','3','');
INSERT INTO `on_access` VALUES ('3','3','2','1','');
INSERT INTO `on_access` VALUES ('2','66','3','63','');
INSERT INTO `on_access` VALUES ('2','65','3','63','');
INSERT INTO `on_access` VALUES ('2','64','3','63','');
INSERT INTO `on_access` VALUES ('2','63','2','1','');
INSERT INTO `on_access` VALUES ('2','62','3','50','');
INSERT INTO `on_access` VALUES ('2','61','3','50','');
INSERT INTO `on_access` VALUES ('2','60','3','50','');
INSERT INTO `on_access` VALUES ('2','59','3','50','');
INSERT INTO `on_access` VALUES ('2','58','3','50','');
INSERT INTO `on_access` VALUES ('2','57','3','50','');
INSERT INTO `on_access` VALUES ('2','56','3','50','');
INSERT INTO `on_access` VALUES ('2','55','3','50','');
INSERT INTO `on_access` VALUES ('2','54','3','50','');
INSERT INTO `on_access` VALUES ('2','53','3','50','');
INSERT INTO `on_access` VALUES ('2','52','3','50','');
INSERT INTO `on_access` VALUES ('2','51','3','50','');
INSERT INTO `on_access` VALUES ('2','50','2','1','');
INSERT INTO `on_access` VALUES ('2','44','3','32','');
INSERT INTO `on_access` VALUES ('2','43','3','32','');
INSERT INTO `on_access` VALUES ('2','42','3','32','');
INSERT INTO `on_access` VALUES ('2','41','3','32','');
INSERT INTO `on_access` VALUES ('2','40','3','32','');
INSERT INTO `on_access` VALUES ('2','39','3','32','');
INSERT INTO `on_access` VALUES ('2','38','3','32','');
INSERT INTO `on_access` VALUES ('2','37','3','32','');
INSERT INTO `on_access` VALUES ('2','36','3','32','');
INSERT INTO `on_access` VALUES ('2','35','3','32','');
INSERT INTO `on_access` VALUES ('2','34','3','32','');
INSERT INTO `on_access` VALUES ('2','33','3','32','');
INSERT INTO `on_access` VALUES ('2','32','2','1','');
INSERT INTO `on_access` VALUES ('2','31','3','26','');
INSERT INTO `on_access` VALUES ('2','30','3','26','');
INSERT INTO `on_access` VALUES ('2','29','3','26','');
INSERT INTO `on_access` VALUES ('2','28','3','26','');
INSERT INTO `on_access` VALUES ('2','27','3','26','');
INSERT INTO `on_access` VALUES ('2','26','2','1','');
INSERT INTO `on_access` VALUES ('2','25','3','14','');
INSERT INTO `on_access` VALUES ('2','24','3','14','');
INSERT INTO `on_access` VALUES ('2','23','3','14','');
INSERT INTO `on_access` VALUES ('2','22','3','14','');
INSERT INTO `on_access` VALUES ('2','21','3','14','');
INSERT INTO `on_access` VALUES ('2','20','3','14','');
INSERT INTO `on_access` VALUES ('2','19','3','14','');
INSERT INTO `on_access` VALUES ('2','18','3','14','');
INSERT INTO `on_access` VALUES ('2','17','3','14','');
INSERT INTO `on_access` VALUES ('2','16','3','14','');
INSERT INTO `on_access` VALUES ('2','15','3','14','');
INSERT INTO `on_access` VALUES ('2','9','3','14','');
INSERT INTO `on_access` VALUES ('2','8','3','14','');
INSERT INTO `on_access` VALUES ('2','14','2','1','');
INSERT INTO `on_access` VALUES ('2','100','3','4','');
INSERT INTO `on_access` VALUES ('2','96','3','4','');
INSERT INTO `on_access` VALUES ('2','95','3','4','');
INSERT INTO `on_access` VALUES ('2','10','3','4','');
INSERT INTO `on_access` VALUES ('2','4','2','1','');
INSERT INTO `on_access` VALUES ('2','101','3','3','');
INSERT INTO `on_access` VALUES ('2','49','3','3','');
INSERT INTO `on_access` VALUES ('2','48','3','3','');
INSERT INTO `on_access` VALUES ('2','47','3','3','');
INSERT INTO `on_access` VALUES ('2','46','3','3','');
INSERT INTO `on_access` VALUES ('2','45','3','3','');
INSERT INTO `on_access` VALUES ('2','7','3','3','');
INSERT INTO `on_access` VALUES ('2','3','2','1','');
INSERT INTO `on_access` VALUES ('2','6','3','2','');
INSERT INTO `on_access` VALUES ('2','5','3','2','');
INSERT INTO `on_access` VALUES ('2','2','2','1','');
INSERT INTO `on_access` VALUES ('2','1','1','0','');
INSERT INTO `on_access` VALUES ('3','6','3','2','');
INSERT INTO `on_access` VALUES ('3','5','3','2','');
INSERT INTO `on_access` VALUES ('3','2','2','1','');
INSERT INTO `on_access` VALUES ('3','1','1','0','');
INSERT INTO `on_access` VALUES ('4','140','3','118','');
INSERT INTO `on_access` VALUES ('4','133','3','118','');
INSERT INTO `on_access` VALUES ('4','134','3','118','');
INSERT INTO `on_access` VALUES ('3','108','2','1','');
INSERT INTO `on_access` VALUES ('3','109','3','108','');
INSERT INTO `on_access` VALUES ('3','118','2','1','');
INSERT INTO `on_access` VALUES ('3','119','3','118','');
INSERT INTO `on_access` VALUES ('3','120','3','118','');
INSERT INTO `on_access` VALUES ('4','135','3','118','');
INSERT INTO `on_access` VALUES ('4','119','3','118','');
INSERT INTO `on_access` VALUES ('4','118','2','1','');
INSERT INTO `on_access` VALUES ('4','6','3','2','');
INSERT INTO `on_access` VALUES ('4','5','3','2','');
INSERT INTO `on_access` VALUES ('4','2','2','1','');
INSERT INTO `on_access` VALUES ('4','1','1','0','');
INSERT INTO `on_access` VALUES ('4','122','3','118','');


# 数据库表：on_admin 数据信息
INSERT INTO `on_admin` VALUES ('10','admin','','admin@admin.com','1fdc80e84ed19bc053f0ddfc81915dd9','1','','','','','0','','0');
INSERT INTO `on_admin` VALUES ('11','a11','a1','a1@admin.com','dfa2e40bd61a0d05e9e033c06aad24ec','1','','','123','123','4','1455498137','1459323217');
INSERT INTO `on_admin` VALUES ('12','a2','a2','a2@admin.com','dfa2e40bd61a0d05e9e033c06aad24ec','1','','','','','4','1461053166','1466748933');
INSERT INTO `on_admin` VALUES ('13','a3','a3','a3@admin.com','dfa2e40bd61a0d05e9e033c06aad24ec','1','','','','','4','1461053211','1461053616');
INSERT INTO `on_admin` VALUES ('14','a4','a4','a4@admin.com','dfa2e40bd61a0d05e9e033c06aad24ec','1','','','','','1','1461053395','0');


# 数据库表：on_company 数据信息
INSERT INTO `on_company` VALUES ('1','A企业','A','13800000000','','抚顺市','aaa@abc.com','0','aaaaaa','1460689234','');
INSERT INTO `on_company` VALUES ('2','C企业','123123','13800000000','工','ABC','ABC2222@AB.com','1','abcabc','1460697259','1460702170');


# 数据库表：on_department 数据信息
INSERT INTO `on_department` VALUES ('1','aa','aa','0','1','1','123','1455774424','1463128422');
INSERT INTO `on_department` VALUES ('4','审计第一部门','a1','1','1','2','1111','1455854755','1461052987');
INSERT INTO `on_department` VALUES ('5','审计第二部门','a2','1','1','0','','1455855690','1461052999');
INSERT INTO `on_department` VALUES ('6','b','b','0','1','2','','1455855702','0');
INSERT INTO `on_department` VALUES ('7','b1','b1','6','1','0','','1455855740','0');


# 数据库表：on_log 数据信息
INSERT INTO `on_log` VALUES ('13','Access','index','显示管理员列表','10','127.0.0.1','1459324862');
INSERT INTO `on_log` VALUES ('14','Access','index','显示管理员列表','10','127.0.0.1','1459817630');
INSERT INTO `on_log` VALUES ('15','Access','index','显示管理员列表','10','127.0.0.1','1459821193');
INSERT INTO `on_log` VALUES ('16','Access','index','显示管理员列表','10','127.0.0.1','1459821630');
INSERT INTO `on_log` VALUES ('17','Access','index','显示管理员列表','10','127.0.0.1','1459821760');
INSERT INTO `on_log` VALUES ('18','Access','index','显示管理员列表','11','127.0.0.1','1459821859');
INSERT INTO `on_log` VALUES ('19','Access','index','显示管理员列表','11','127.0.0.1','1459821863');
INSERT INTO `on_log` VALUES ('20','Access','index','显示管理员列表','10','127.0.0.1','1460091301');
INSERT INTO `on_log` VALUES ('21','Access','index','显示管理员列表','10','127.0.0.1','1460689761');
INSERT INTO `on_log` VALUES ('22','Department','opDepartmentStatus','修改部门状态','10','127.0.0.1','1460690323');
INSERT INTO `on_log` VALUES ('23','Department','opDepartmentStatus','修改部门状态','10','127.0.0.1','1460690326');
INSERT INTO `on_log` VALUES ('24','Access','index','显示管理员列表','10','127.0.0.1','1460697071');
INSERT INTO `on_log` VALUES ('25','Access','index','显示管理员列表','10','127.0.0.1','1460697082');
INSERT INTO `on_log` VALUES ('26','Company','add','添加审计企业','10','127.0.0.1','1460697259');
INSERT INTO `on_log` VALUES ('27','Company','opCompanyStatus','修改企业状态','10','127.0.0.1','1460700049');
INSERT INTO `on_log` VALUES ('28','Company','opCompanyStatus','修改企业状态','10','127.0.0.1','1460700051');
INSERT INTO `on_log` VALUES ('29','Company','editCompany','编辑企业','10','127.0.0.1','1460702107');
INSERT INTO `on_log` VALUES ('30','Company','editCompany','编辑企业','10','127.0.0.1','1460702116');
INSERT INTO `on_log` VALUES ('31','Company','editCompany','编辑企业','10','127.0.0.1','1460702165');
INSERT INTO `on_log` VALUES ('32','Company','editCompany','编辑企业','10','127.0.0.1','1460702170');
INSERT INTO `on_log` VALUES ('33','Company','opCompanyStatus','修改企业状态','10','127.0.0.1','1461035404');
INSERT INTO `on_log` VALUES ('34','Department','editDepartment','编辑部门','10','127.0.0.1','1461052987');
INSERT INTO `on_log` VALUES ('35','Department','editDepartment','编辑部门','10','127.0.0.1','1461052999');
INSERT INTO `on_log` VALUES ('36','Project','translation','添加审计项目','12','127.0.0.1','1461141568');
INSERT INTO `on_log` VALUES ('37','Project','translation','添加审计项目','12','127.0.0.1','1461141722');
INSERT INTO `on_log` VALUES ('38','Project','translation','添加审计项目','12','127.0.0.1','1461141749');
INSERT INTO `on_log` VALUES ('39','Project','translation','添加审计项目','12','127.0.0.1','1461829997');
INSERT INTO `on_log` VALUES ('40','Project','translation','添加审计项目','12','127.0.0.1','1461830145');
INSERT INTO `on_log` VALUES ('41','Project','translation','添加审计项目','12','127.0.0.1','1461830815');
INSERT INTO `on_log` VALUES ('42','Project','translation','添加审计项目','12','127.0.0.1','1461830894');
INSERT INTO `on_log` VALUES ('43','Project','translation','添加审计项目','12','127.0.0.1','1461830966');
INSERT INTO `on_log` VALUES ('44','Project','translation','添加审计项目','12','127.0.0.1','1461902727');
INSERT INTO `on_log` VALUES ('45','Project','translation','添加审计项目','12','127.0.0.1','1461904076');
INSERT INTO `on_log` VALUES ('46','Project','opProjectStatus','修改项目状态','12','127.0.0.1','1462340673');
INSERT INTO `on_log` VALUES ('47','Project','opProjectStatus','修改项目状态','12','127.0.0.1','1462340675');
INSERT INTO `on_log` VALUES ('48','Project','opProjectStatus','修改项目状态','12','127.0.0.1','1462340677');
INSERT INTO `on_log` VALUES ('49','Project','opProjectStatus','修改项目状态','12','127.0.0.1','1462340682');
INSERT INTO `on_log` VALUES ('50','Project','opProjectStatus','修改项目状态','12','127.0.0.1','1462340684');
INSERT INTO `on_log` VALUES ('51','Project','opProjectStatus','修改项目状态','12','127.0.0.1','1462340686');
INSERT INTO `on_log` VALUES ('52','Project','opProjectStatus','修改项目状态','12','127.0.0.1','1462340693');
INSERT INTO `on_log` VALUES ('53','Project','opProjectStatus','修改项目状态','12','127.0.0.1','1462340695');
INSERT INTO `on_log` VALUES ('54','Project','opProjectStatus','修改项目状态','12','127.0.0.1','1462340867');
INSERT INTO `on_log` VALUES ('55','Project','opProjectStatus','修改项目状态','12','127.0.0.1','1462340870');
INSERT INTO `on_log` VALUES ('56','Project','editProject','修改审计项目','12','127.0.0.1','1462847974');
INSERT INTO `on_log` VALUES ('57','Project','editProject','修改审计项目','12','127.0.0.1','1462847981');
INSERT INTO `on_log` VALUES ('58','Project','editProject','修改审计项目','10','127.0.0.1','1462848007');
INSERT INTO `on_log` VALUES ('59','Project','editProject','修改审计项目','10','127.0.0.1','1462848032');
INSERT INTO `on_log` VALUES ('60','Pfile','opPfileStatus','修改部门状态','10','127.0.0.1','1463041123');
INSERT INTO `on_log` VALUES ('61','Pfile','opPfileStatus','修改部门状态','10','127.0.0.1','1463041129');
INSERT INTO `on_log` VALUES ('62','Pfile','editPfile','编辑部门','10','127.0.0.1','1463041156');
INSERT INTO `on_log` VALUES ('63','Pfile','editPfile','编辑文件类型','10','127.0.0.1','1463041199');
INSERT INTO `on_log` VALUES ('64','Pfile','editPfile','编辑文件类型','10','127.0.0.1','1463041417');
INSERT INTO `on_log` VALUES ('65','Pfile','add','添加文件类型','10','127.0.0.1','1463041432');
INSERT INTO `on_log` VALUES ('66','Pfile','add','添加文件类型','10','127.0.0.1','1463041448');
INSERT INTO `on_log` VALUES ('67','Pfile','editPfile','编辑文件类型','10','127.0.0.1','1463041463');
INSERT INTO `on_log` VALUES ('68','Pfile','add','添加文件类型','10','127.0.0.1','1463041503');
INSERT INTO `on_log` VALUES ('69','Pfile','add','添加文件类型','10','127.0.0.1','1463041520');
INSERT INTO `on_log` VALUES ('70','Pfile','add','添加文件类型','10','127.0.0.1','1463041582');
INSERT INTO `on_log` VALUES ('71','Pfile','editPfile','编辑文件类型','10','127.0.0.1','1463041597');
INSERT INTO `on_log` VALUES ('72','Pfile','editPfile','编辑文件类型','10','127.0.0.1','1463041614');
INSERT INTO `on_log` VALUES ('73','Pfile','add','添加文件类型','10','127.0.0.1','1463120199');
INSERT INTO `on_log` VALUES ('74','Pfile','add','添加文件类型','10','127.0.0.1','1463121004');
INSERT INTO `on_log` VALUES ('75','Pfile','add','添加文件类型','10','127.0.0.1','1463121018');
INSERT INTO `on_log` VALUES ('76','Pfile','add','添加文件类型','10','127.0.0.1','1463121038');
INSERT INTO `on_log` VALUES ('77','Pfile','editPfile','编辑文件类型','10','127.0.0.1','1463121049');
INSERT INTO `on_log` VALUES ('78','Pfile','editPfile','编辑文件类型','10','127.0.0.1','1463121056');
INSERT INTO `on_log` VALUES ('79','Pfile','editPfile','编辑文件类型','10','127.0.0.1','1463121067');
INSERT INTO `on_log` VALUES ('80','Pfile','editPfile','编辑文件类型','10','127.0.0.1','1463121112');
INSERT INTO `on_log` VALUES ('81','Department','editDepartment','编辑部门','10','127.0.0.1','1463128422');
INSERT INTO `on_log` VALUES ('82','Project','addFile','添加审计项目文件内容','12','127.0.0.1','1464068456');
INSERT INTO `on_log` VALUES ('83','Project','addFile','添加审计项目文件内容','12','127.0.0.1','1464068593');
INSERT INTO `on_log` VALUES ('84','Project','opProjectStatus','修改项目状态','12','127.0.0.1','1464068698');
INSERT INTO `on_log` VALUES ('85','Project','opProjectStatus','修改项目状态','12','127.0.0.1','1464068702');
INSERT INTO `on_log` VALUES ('86','Project','editProject','修改审计项目','12','127.0.0.1','1464068711');
INSERT INTO `on_log` VALUES ('87','Project','addFile','添加审计项目文件内容','12','127.0.0.1','1464068718');
INSERT INTO `on_log` VALUES ('88','Project','addFile','添加审计项目文件内容','12','127.0.0.1','1464068918');
INSERT INTO `on_log` VALUES ('89','Project','addFile','添加审计项目文件内容','12','127.0.0.1','1464068956');
INSERT INTO `on_log` VALUES ('90','Project','addFile','添加审计项目文件内容','12','127.0.0.1','1464069173');
INSERT INTO `on_log` VALUES ('91','Project','addFile','添加审计项目文件内容','12','127.0.0.1','1464069192');
INSERT INTO `on_log` VALUES ('92','Project','addFile','添加审计项目文件内容','12','127.0.0.1','1464069685');
INSERT INTO `on_log` VALUES ('93','Project','addFile','添加审计项目文件内容','12','127.0.0.1','1464073581');
INSERT INTO `on_log` VALUES ('94','Project','editProjectFile','修改审计项目文件内容','12','127.0.0.1','1464140242');
INSERT INTO `on_log` VALUES ('95','Project','editProjectFile','修改审计项目文件内容','12','127.0.0.1','1464140396');
INSERT INTO `on_log` VALUES ('96','Project','editProjectFile','修改审计项目文件内容','12','127.0.0.1','1464140447');
INSERT INTO `on_log` VALUES ('97','Project','editProjectFile','修改审计项目文件内容','12','127.0.0.1','1464140455');
INSERT INTO `on_log` VALUES ('98','Project','opProjectFileStatus','修改项目文件状态','12','127.0.0.1','1464141198');
INSERT INTO `on_log` VALUES ('99','Project','opProjectFileStatus','修改项目文件状态','12','127.0.0.1','1464141204');
INSERT INTO `on_log` VALUES ('100','Project','opProjectStatus','修改项目状态','12','127.0.0.1','1464141233');
INSERT INTO `on_log` VALUES ('101','Project','addFile','添加审计项目文件内容','12','127.0.0.1','1464932728');
INSERT INTO `on_log` VALUES ('102','Project','editProjectFile','修改审计项目文件内容','12','127.0.0.1','1465802539');
INSERT INTO `on_log` VALUES ('103','Project','addFile','添加审计项目文件内容','12','127.0.0.1','1465802595');
INSERT INTO `on_log` VALUES ('104','Project','opProjectFileStatus','修改项目文件状态','12','127.0.0.1','1465802638');
INSERT INTO `on_log` VALUES ('105','Project','opProjectFileStatus','修改项目文件状态','12','127.0.0.1','1465802640');
INSERT INTO `on_log` VALUES ('106','Public','index','用户登陆','12','127.0.0.1','1465972988');
INSERT INTO `on_log` VALUES ('107','Public','index','用户登陆','12','127.0.0.1','1465972995');
INSERT INTO `on_log` VALUES ('108','Public','index','用户登陆','12','127.0.0.1','1465973076');
INSERT INTO `on_log` VALUES ('109','Public','index','用户登陆','12','127.0.0.1','1465973093');
INSERT INTO `on_log` VALUES ('110','Public','index','用户登陆','12','127.0.0.1','1465973173');
INSERT INTO `on_log` VALUES ('111','Public','loginOut','用户登出','12','127.0.0.1','1465973210');
INSERT INTO `on_log` VALUES ('112','Public','index','用户登陆','12','127.0.0.1','1465973224');
INSERT INTO `on_log` VALUES ('113','Public','loginOut','用户登出','10','127.0.0.1','1465974018');
INSERT INTO `on_log` VALUES ('114','Public','loginOut','用户登出','12','127.0.0.1','1465974037');
INSERT INTO `on_log` VALUES ('115','Public','loginOut','用户登出','12','127.0.0.1','1465974067');
INSERT INTO `on_log` VALUES ('116','Public','loginOut','用户登出','12','127.0.0.1','1465974138');
INSERT INTO `on_log` VALUES ('117','Public','index','用户登陆','12','127.0.0.1','1465974196');
INSERT INTO `on_log` VALUES ('118','Public','index','用户登陆','10','127.0.0.1','1465974206');
INSERT INTO `on_log` VALUES ('119','Public','loginOut','用户登出','10','127.0.0.1','1465974447');
INSERT INTO `on_log` VALUES ('120','Public','index','用户登陆','10','127.0.0.1','1465974455');
INSERT INTO `on_log` VALUES ('121','Public','loginOut','用户登出','10','127.0.0.1','1465974469');
INSERT INTO `on_log` VALUES ('122','Public','index','用户登陆','10','127.0.0.1','1465974476');
INSERT INTO `on_log` VALUES ('123','Public','loginOut','用户登出','10','127.0.0.1','1465974832');
INSERT INTO `on_log` VALUES ('124','Public','index','用户登陆','10','127.0.0.1','1465974841');
INSERT INTO `on_log` VALUES ('125','Public','loginOut','用户登出','10','127.0.0.1','1465974847');
INSERT INTO `on_log` VALUES ('126','Public','index','用户登陆','10','127.0.0.1','1465974859');
INSERT INTO `on_log` VALUES ('127','Public','loginOut','用户登出','10','127.0.0.1','1465974864');
INSERT INTO `on_log` VALUES ('128','Public','loginOut','用户登出','12','127.0.0.1','1465974868');
INSERT INTO `on_log` VALUES ('129','Public','index','用户登陆','10','127.0.0.1','1465974906');
INSERT INTO `on_log` VALUES ('130','Public','loginOut','用户登出','10','127.0.0.1','1465974913');
INSERT INTO `on_log` VALUES ('131','Public','index','用户登陆','12','127.0.0.1','1465974921');
INSERT INTO `on_log` VALUES ('132','Public','loginOut','用户登出','12','127.0.0.1','1465974928');
INSERT INTO `on_log` VALUES ('133','Public','index','用户登陆','10','127.0.0.1','1465974934');
INSERT INTO `on_log` VALUES ('134','Public','loginOut','用户登出','10','127.0.0.1','1465974971');
INSERT INTO `on_log` VALUES ('135','Public','index','用户登陆','10','127.0.0.1','1465974978');
INSERT INTO `on_log` VALUES ('136','Public','index','用户登陆','10','127.0.0.1','1465975068');
INSERT INTO `on_log` VALUES ('137','Public','loginOut','用户登出','10','127.0.0.1','1465975073');
INSERT INTO `on_log` VALUES ('138','Public','index','用户登陆','10','127.0.0.1','1465975081');
INSERT INTO `on_log` VALUES ('139','Public','loginOut','用户登出','10','127.0.0.1','1465975088');
INSERT INTO `on_log` VALUES ('140','Public','loginOut','用户登出','12','127.0.0.1','1465975099');
INSERT INTO `on_log` VALUES ('141','Public','index','用户登陆','10','127.0.0.1','1465975195');
INSERT INTO `on_log` VALUES ('142','Public','loginOut','用户登出','10','127.0.0.1','1465975200');
INSERT INTO `on_log` VALUES ('143','Public','index','用户登陆','10','127.0.0.1','1465975203');
INSERT INTO `on_log` VALUES ('144','Public','loginOut','用户登出','10','127.0.0.1','1465975209');
INSERT INTO `on_log` VALUES ('145','Public','index','用户登陆','12','127.0.0.1','1465975212');
INSERT INTO `on_log` VALUES ('146','Public','loginOut','用户登出','12','127.0.0.1','1465975219');
INSERT INTO `on_log` VALUES ('147','Public','loginOut','用户登出','10','127.0.0.1','1465975265');
INSERT INTO `on_log` VALUES ('148','Public','index','用户登陆','10','127.0.0.1','1465975272');
INSERT INTO `on_log` VALUES ('149','Public','loginOut','用户登出','10','127.0.0.1','1465975369');
INSERT INTO `on_log` VALUES ('150','Public','loginOut','用户登出','10','127.0.0.1','1465975409');
INSERT INTO `on_log` VALUES ('151','Public','index','用户登陆','10','127.0.0.1','1465975422');
INSERT INTO `on_log` VALUES ('152','Public','loginOut','用户登出','10','127.0.0.1','1465975428');
INSERT INTO `on_log` VALUES ('153','Public','loginOut','用户登出','10','127.0.0.1','1465975527');
INSERT INTO `on_log` VALUES ('154','Public','loginOut','用户登出','10','127.0.0.1','1465975561');
INSERT INTO `on_log` VALUES ('155','Public','loginOut','用户登出','10','127.0.0.1','1465975723');
INSERT INTO `on_log` VALUES ('156','Public','index','用户登陆','10','127.0.0.1','1465975727');
INSERT INTO `on_log` VALUES ('157','Public','loginOut','用户登出','10','127.0.0.1','1465975732');
INSERT INTO `on_log` VALUES ('158','Public','index','用户登陆','12','127.0.0.1','1465975735');
INSERT INTO `on_log` VALUES ('159','Public','loginOut','用户登出','12','127.0.0.1','1465975740');
INSERT INTO `on_log` VALUES ('160','Public','index','用户登陆','10','127.0.0.1','1465975755');
INSERT INTO `on_log` VALUES ('161','Public','loginOut','用户登出','10','127.0.0.1','1465975759');
INSERT INTO `on_log` VALUES ('162','Public','index','用户登陆','12','127.0.0.1','1465975767');
INSERT INTO `on_log` VALUES ('163','Public','index','用户登陆','10','127.0.0.1','1465975773');
INSERT INTO `on_log` VALUES ('164','Public','index','用户登陆','10','127.0.0.1','1466038340');
INSERT INTO `on_log` VALUES ('165','Public','index','用户登陆','10','127.0.0.1','1466484600');
INSERT INTO `on_log` VALUES ('166','Public','index','用户登陆','12','127.0.0.1','1466486797');
INSERT INTO `on_log` VALUES ('167','Project','opProjectStatus','修改项目状态','12','127.0.0.1','1466489186');
INSERT INTO `on_log` VALUES ('168','Project','opProjectStatus','修改项目状态','12','127.0.0.1','1466489202');
INSERT INTO `on_log` VALUES ('169','Project','opProjectStatus','修改项目状态','12','127.0.0.1','1466489205');
INSERT INTO `on_log` VALUES ('170','Project','opProjectStatus','修改项目状态','12','127.0.0.1','1466489207');
INSERT INTO `on_log` VALUES ('171','Public','index','用户登陆','10','127.0.0.1','1466557278');
INSERT INTO `on_log` VALUES ('172','Public','loginOut','用户登出','10','127.0.0.1','1466562510');
INSERT INTO `on_log` VALUES ('173','Public','index','用户登陆','10','127.0.0.1','1466562554');
INSERT INTO `on_log` VALUES ('174','Public','index','用户登陆','10','127.0.0.1','1466644268');
INSERT INTO `on_log` VALUES ('175','Public','loginOut','用户登出','10','127.0.0.1','1466644489');
INSERT INTO `on_log` VALUES ('176','Public','index','用户登陆','10','127.0.0.1','1466644497');
INSERT INTO `on_log` VALUES ('177','Public','loginOut','用户登出','10','127.0.0.1','1466648851');
INSERT INTO `on_log` VALUES ('178','Public','index','用户登陆','10','127.0.0.1','1466648855');
INSERT INTO `on_log` VALUES ('179','Public','loginOut','用户登出','10','127.0.0.1','1466648866');
INSERT INTO `on_log` VALUES ('180','Public','index','用户登陆','10','127.0.0.1','1466648870');
INSERT INTO `on_log` VALUES ('181','Public','index','用户登陆','12','127.0.0.1','1466650462');
INSERT INTO `on_log` VALUES ('182','Project','opProjectStatus','修改项目状态','12','127.0.0.1','1466663196');
INSERT INTO `on_log` VALUES ('183','Project','opProjectStatus','修改项目状态','12','127.0.0.1','1466663242');
INSERT INTO `on_log` VALUES ('184','Project','addFile','添加审计项目文件内容','12','127.0.0.1','1466667547');
INSERT INTO `on_log` VALUES ('185','Department','opDepartmentStatus','修改部门状态','10','127.0.0.1','1466670803');
INSERT INTO `on_log` VALUES ('186','Department','opDepartmentStatus','修改部门状态','10','127.0.0.1','1466670815');
INSERT INTO `on_log` VALUES ('187','Public','index','用户登陆','10','127.0.0.1','1466732689');
INSERT INTO `on_log` VALUES ('188','Public','index','用户登陆','12','127.0.0.1','1466733176');
INSERT INTO `on_log` VALUES ('189','Public','loginOut','用户登出','12','127.0.0.1','1466746149');
INSERT INTO `on_log` VALUES ('190','Public','index','用户登陆','12','127.0.0.1','1466746165');
INSERT INTO `on_log` VALUES ('191','Public','loginOut','用户登出','12','127.0.0.1','1466747712');
INSERT INTO `on_log` VALUES ('192','Public','index','用户登陆','12','127.0.0.1','1466747714');
INSERT INTO `on_log` VALUES ('193','Public','index','用户登陆','12','127.0.0.1','1466747728');
INSERT INTO `on_log` VALUES ('194','Access','editAdmin','修改用户信息','10','127.0.0.1','1466748933');
INSERT INTO `on_log` VALUES ('195','Public','loginOut','用户登出','12','127.0.0.1','1466749375');
INSERT INTO `on_log` VALUES ('196','Public','index','用户登陆','12','127.0.0.1','1466749377');
INSERT INTO `on_log` VALUES ('197','Public','loginOut','用户登出','10','127.0.0.1','1466749394');
INSERT INTO `on_log` VALUES ('198','Public','index','用户登陆','10','127.0.0.1','1466749397');
INSERT INTO `on_log` VALUES ('199','Public','index','用户登陆','12','127.0.0.1','1466749412');
INSERT INTO `on_log` VALUES ('200','Public','index','用户登陆','12','127.0.0.1','1466749420');
INSERT INTO `on_log` VALUES ('201','Access','changeRole','设置角色权限','10','127.0.0.1','1466757130');
INSERT INTO `on_log` VALUES ('202','Public','loginOut','用户登出','12','127.0.0.1','1466757135');
INSERT INTO `on_log` VALUES ('203','Public','index','用户登陆','12','127.0.0.1','1466757137');
INSERT INTO `on_log` VALUES ('204','Public','index','用户登陆','10','127.0.0.1','1467001645');
INSERT INTO `on_log` VALUES ('205','Public','index','用户登陆','12','127.0.0.1','1467001683');
INSERT INTO `on_log` VALUES ('206','Public','index','用户登陆','12','127.0.0.1','1467001781');
INSERT INTO `on_log` VALUES ('207','Project','opProjectStatus','修改项目状态','12','127.0.0.1','1467001840');
INSERT INTO `on_log` VALUES ('208','Project','opProjectStatus','修改项目状态','12','127.0.0.1','1467001849');
INSERT INTO `on_log` VALUES ('209','Public','index','','10','127.0.0.1','1532760369');


# 数据库表：on_node 数据信息
INSERT INTO `on_node` VALUES ('1','Admin','后台管理','1','网站后台管理项目','1','0','1','1');
INSERT INTO `on_node` VALUES ('2','Index','管理首页','1','','1','1','2','1');
INSERT INTO `on_node` VALUES ('5','index','默认页','1','','5','2','3','1');
INSERT INTO `on_node` VALUES ('6','myInfo','我的个人信息','1','','6','2','3','1');
INSERT INTO `on_node` VALUES ('8','index','用户列表','1','','2','14','3','1');
INSERT INTO `on_node` VALUES ('9','addAdmin','添加用户','1','','1','14','3','1');
INSERT INTO `on_node` VALUES ('14','Access','权限管理','1','权限管理，为系统后台管理员设置不同的权限','6','1','2','1');
INSERT INTO `on_node` VALUES ('15','nodeList','查看节点','1','节点列表信息','6','14','3','1');
INSERT INTO `on_node` VALUES ('16','roleList','角色列表查看','1','角色列表查看','4','14','3','1');
INSERT INTO `on_node` VALUES ('17','addRole','添加角色','1','','3','14','3','1');
INSERT INTO `on_node` VALUES ('18','editRole','编辑角色','1','','0','14','3','0');
INSERT INTO `on_node` VALUES ('19','opNodeStatus','便捷开启禁用节点','1','','0','14','3','0');
INSERT INTO `on_node` VALUES ('20','opRoleStatus','便捷开启禁用角色','1','','0','14','3','0');
INSERT INTO `on_node` VALUES ('21','editNode','编辑节点','1','','0','14','3','0');
INSERT INTO `on_node` VALUES ('22','addNode','添加节点','1','','5','14','3','1');
INSERT INTO `on_node` VALUES ('24','editAdmin','编辑管理员信息','1','','0','14','3','0');
INSERT INTO `on_node` VALUES ('25','changeRole','权限分配','1','','0','14','3','0');
INSERT INTO `on_node` VALUES ('32','SysData','数据库管理','1','包含数据库备份、还原、打包等','7','1','2','1');
INSERT INTO `on_node` VALUES ('33','index','查看数据库表结构信息','1','','1','32','3','1');
INSERT INTO `on_node` VALUES ('34','backup','备份数据库','1','','0','32','3','0');
INSERT INTO `on_node` VALUES ('35','restore','查看已备份SQL文件','1','','0','32','3','1');
INSERT INTO `on_node` VALUES ('36','restoreData','执行数据库还原操作','1','','0','32','3','0');
INSERT INTO `on_node` VALUES ('37','delSqlFiles','删除SQL文件','1','','0','32','3','0');
INSERT INTO `on_node` VALUES ('38','sendSql','邮件发送SQL文件','1','','0','32','3','0');
INSERT INTO `on_node` VALUES ('39','zipSql','打包SQL文件','1','','0','32','3','0');
INSERT INTO `on_node` VALUES ('40','zipList','查看已打包SQL文件','1','','0','32','3','1');
INSERT INTO `on_node` VALUES ('41','unzipSqlfile','解压缩ZIP文件','1','','0','32','3','0');
INSERT INTO `on_node` VALUES ('42','delZipFiles','删除zip压缩文件','1','','0','32','3','0');
INSERT INTO `on_node` VALUES ('43','downFile','下载备份的SQL,ZIP文件','1','','0','32','3','0');
INSERT INTO `on_node` VALUES ('44','repair','数据库优化修复','1','','0','32','3','1');
INSERT INTO `on_node` VALUES ('137','index','日志列表','1','','1','107','3','1');
INSERT INTO `on_node` VALUES ('130','opPfileStatus','快捷修改文件类型状态','1','','0','126','3','0');
INSERT INTO `on_node` VALUES ('104','Department','部门管理','1','','5','1','2','1');
INSERT INTO `on_node` VALUES ('105','index','部门列表','1','','0','104','3','1');
INSERT INTO `on_node` VALUES ('106','add','添加部门','1','','0','104','3','1');
INSERT INTO `on_node` VALUES ('107','Log','日志管理','1','','8','1','2','1');
INSERT INTO `on_node` VALUES ('108','Company','审计企业','1','','4','1','2','1');
INSERT INTO `on_node` VALUES ('109','index','企业列表','1','','0','108','3','1');
INSERT INTO `on_node` VALUES ('110','add','添加审计企业','1','','1','108','3','1');
INSERT INTO `on_node` VALUES ('111','search','查询企业','1','','2','108','3','0');
INSERT INTO `on_node` VALUES ('112','edit','编辑审计企业','1','','3','108','3','0');
INSERT INTO `on_node` VALUES ('113','del','删除审计企业','1','','4','108','3','0');
INSERT INTO `on_node` VALUES ('114','editDepartment','编辑部门','1','','0','104','3','0');
INSERT INTO `on_node` VALUES ('115','opDepartmentStatus','快捷修改部门状态','1','','0','104','3','0');
INSERT INTO `on_node` VALUES ('116','opSort','修改部门排序','1','','0','104','3','0');
INSERT INTO `on_node` VALUES ('117','delDepartment','删除部门','1','','0','104','3','0');
INSERT INTO `on_node` VALUES ('118','Project','项目管理','1','','2','1','2','1');
INSERT INTO `on_node` VALUES ('119','index','项目列表','1','','0','118','3','1');
INSERT INTO `on_node` VALUES ('120','add','添加项目','1','','1','118','3','1');
INSERT INTO `on_node` VALUES ('121','translation','添加审计','1','','0','118','3','0');
INSERT INTO `on_node` VALUES ('122','editProject','编辑审计项目','1','','3','118','3','0');
INSERT INTO `on_node` VALUES ('123','opProjectStatus','修改项目状态','1','','0','118','3','0');
INSERT INTO `on_node` VALUES ('124','addFile','添加项目文件','1','','0','118','3','0');
INSERT INTO `on_node` VALUES ('125','fileList','显示文件列表','1','','0','118','3','0');
INSERT INTO `on_node` VALUES ('126','Pfile','文件类型管理','1','','5','1','2','1');
INSERT INTO `on_node` VALUES ('127','index','文件类型列表','1','','0','126','3','1');
INSERT INTO `on_node` VALUES ('128','add','添加文件类型','1','','0','126','3','1');
INSERT INTO `on_node` VALUES ('129','editPfile','编辑文件类型','1','','0','126','3','0');
INSERT INTO `on_node` VALUES ('140','showtranslation','查看企业审计信息','1','','0','118','3','0');
INSERT INTO `on_node` VALUES ('131','opSort','修改文件类型排序','1','','0','126','3','0');
INSERT INTO `on_node` VALUES ('132','delPfile','删除文件类型','1','','0','126','3','0');
INSERT INTO `on_node` VALUES ('133','getUrl','获取文件类型地址','1','','0','118','3','0');
INSERT INTO `on_node` VALUES ('134','editProjectFile','修改项目文件','1','','0','118','3','0');
INSERT INTO `on_node` VALUES ('135','delProjectFile','删除项目文件','1','','0','118','3','0');
INSERT INTO `on_node` VALUES ('136','opProjectFileStatus','修改项目文件状态','1','','0','118','3','0');


# 数据库表：on_pfile 数据信息
INSERT INTO `on_pfile` VALUES ('1','财务目录','Finance','','0','1','1','','1455774424','1463121056');
INSERT INTO `on_pfile` VALUES ('4','AO数据包文件','AOData','Finance/','1','1','2','','1455854755','1463121049');
INSERT INTO `on_pfile` VALUES ('5','AO采集转换说明文件','AOExplain','Finance/','1','1','1','','1455855690','1463121112');
INSERT INTO `on_pfile` VALUES ('6','业务目录','Business','','0','1','2','','1455855702','1463041597');
INSERT INTO `on_pfile` VALUES ('7','数据分析文件','DataAnalysis','Business/','6','1','2','','1455855740','1463041614');
INSERT INTO `on_pfile` VALUES ('9','数据分析文件','DataAnalysis','Finance/','1','1','3','','1463041432','0');
INSERT INTO `on_pfile` VALUES ('10','数据字典文件','DataDictionary','Finance/','1','1','4','','1463041448','0');
INSERT INTO `on_pfile` VALUES ('11','原始采集数据文件','OldData','Finance/','1','1','5','','1463041503','0');
INSERT INTO `on_pfile` VALUES ('12','原始采集说明文件','OldDataExplain','Finance/','1','1','6','','1463041520','0');
INSERT INTO `on_pfile` VALUES ('13','其它文件','Other','Finance/','1','1','7','','1463041582','0');
INSERT INTO `on_pfile` VALUES ('14','数据字典文件','DataDictionary','Business/','6','1','1','','1463120199','0');
INSERT INTO `on_pfile` VALUES ('15','原始采集数据文件','OldData','Business/','6','1','3','','1463121004','0');
INSERT INTO `on_pfile` VALUES ('16','原始采集说明文件','OldDataExplain','Business/','6','1','4','','1463121018','0');
INSERT INTO `on_pfile` VALUES ('17','其它文件','Other','Business/','6','1','5','','1463121038','0');


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
INSERT INTO `on_projectfile` VALUES ('12','123','7','2','4','a1/20160811','Finance','a1/20160811/Finance/20160623153834/activeds.tlb','1','','','0','0','1466667547','0','','1','12','127.0.0.1');


# 数据库表：on_role 数据信息
INSERT INTO `on_role` VALUES ('1','超级管理员','0','1','系统内置超级管理员组，不受权限分配账号限制','0','');
INSERT INTO `on_role` VALUES ('2','管理员','1','1','拥有系统仅此于超级管理员的权限','0','');
INSERT INTO `on_role` VALUES ('3','领导','1','1','拥有所有操作的读权限，无增加、删除、修改的权限','0','');
INSERT INTO `on_role` VALUES ('4','组员','1','1','测试','0','1466748640');


# 数据库表：on_role_user 数据信息
INSERT INTO `on_role_user` VALUES ('3','11');
INSERT INTO `on_role_user` VALUES ('4','12');
INSERT INTO `on_role_user` VALUES ('3','13');
INSERT INTO `on_role_user` VALUES ('3','14');
