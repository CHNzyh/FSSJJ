# Host: localhost  (Version: 5.5.53)
# Date: 2018-12-01 16:41:37
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "on_node"
#

CREATE TABLE `on_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `ctrlname` varchar(20) DEFAULT NULL COMMENT '操作类名称',
  `showname` varchar(20) DEFAULT NULL COMMENT '显示操作名称',
  `title` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  `sort` smallint(6) unsigned DEFAULT NULL COMMENT '排序',
  `pid` smallint(6) unsigned NOT NULL COMMENT '父ID',
  `level` tinyint(1) unsigned NOT NULL,
  `menu` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为菜单',
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=163 DEFAULT CHARSET=utf8 COMMENT='权限节点表';

#
# Data for table "on_node"
#

INSERT INTO `on_node` VALUES (1,'Admin','',NULL,'后台管理',1,'网站后台管理项目',1,0,1,1),(2,'Index','',NULL,'管理首页',1,'',1,1,2,1),(5,'index','',NULL,'默认页',1,'',5,2,3,1),(6,'myInfo','',NULL,'我的个人信息',1,'',6,2,3,1),(8,'index','',NULL,'用户列表',1,'',2,14,3,1),(9,'addAdmin','',NULL,'添加用户',1,'',1,14,3,1),(14,'Access','',NULL,'系统管理',1,'权限管理，为系统后台管理员设置不同的权限',8,1,2,1),(15,'nodeList','',NULL,'查看节点',1,'节点列表信息',6,14,3,1),(16,'roleList','',NULL,'角色列表查看',1,'角色列表查看',4,14,3,1),(17,'addRole','',NULL,'添加角色',1,'',3,14,3,1),(18,'editRole','',NULL,'编辑角色',1,'',0,14,3,0),(19,'opNodeStatus','',NULL,'便捷开启禁用节点',1,'',0,14,3,0),(20,'opRoleStatus','',NULL,'便捷开启禁用角色',1,'',0,14,3,0),(21,'editNode','',NULL,'编辑节点',1,'',0,14,3,0),(22,'addNode','',NULL,'添加节点',1,'',5,14,3,1),(24,'editAdmin','',NULL,'编辑管理员信息',1,'',0,14,3,0),(25,'changeRole','',NULL,'权限分配',1,'',0,14,3,0),(32,'SysData','',NULL,'数据库管理',1,'包含数据库备份、还原、打包等',9,1,2,1),(33,'index','',NULL,'查看数据库表结构信息',1,'',1,32,3,1),(34,'backup','',NULL,'备份数据库',1,'',0,32,3,0),(35,'restore','',NULL,'查看已备份SQL文件',1,'',0,32,3,1),(36,'restoreData','',NULL,'执行数据库还原操作',1,'',0,32,3,0),(37,'delSqlFiles','',NULL,'删除SQL文件',1,'',0,32,3,0),(38,'sendSql','',NULL,'邮件发送SQL文件',1,'',0,32,3,0),(39,'zipSql','',NULL,'打包SQL文件',1,'',0,32,3,0),(40,'zipList','',NULL,'查看已打包SQL文件',1,'',0,32,3,1),(41,'unzipSqlfile','',NULL,'解压缩ZIP文件',1,'',0,32,3,0),(42,'delZipFiles','',NULL,'删除zip压缩文件',1,'',0,32,3,0),(43,'downFile','',NULL,'下载备份的SQL,ZIP文件',1,'',0,32,3,0),(44,'repair','',NULL,'数据库优化修复',1,'',0,32,3,1),(104,'Department','',NULL,'部门管理',1,'',7,1,2,1),(105,'index','',NULL,'部门列表',1,'',0,104,3,1),(106,'add','',NULL,'添加部门',1,'',0,104,3,1),(107,'Log','',NULL,'日志管理',1,'',10,1,2,1),(108,'Company','',NULL,'审计企业',1,'',4,1,2,1),(109,'index','',NULL,'企业列表',1,'',0,108,3,1),(110,'add','',NULL,'添加审计企业',1,'',1,108,3,1),(111,'search','',NULL,'查询企业',1,'',2,108,3,0),(112,'edit','',NULL,'编辑审计企业',1,'',3,108,3,0),(113,'del','',NULL,'删除审计企业',1,'',4,108,3,0),(114,'editDepartment','',NULL,'编辑部门',1,'',0,104,3,0),(115,'opDepartmentStatus','',NULL,'快捷修改部门状态',1,'',0,104,3,0),(116,'opSort','',NULL,'修改部门排序',1,'',0,104,3,0),(117,'delDepartment','',NULL,'删除部门',1,'',0,104,3,0),(118,'Project','',NULL,'项目管理',1,'',3,1,2,0),(119,'index','',NULL,'项目列表',1,'',0,118,3,1),(120,'add','',NULL,'添加项目',1,'',1,118,3,1),(121,'translation','',NULL,'添加审计',1,'',0,118,3,0),(122,'editProject','',NULL,'编辑审计项目',1,'',3,118,3,0),(123,'opProjectStatus','',NULL,'修改项目状态',1,'',0,118,3,0),(124,'addFile','',NULL,'添加项目文件',1,'',0,118,3,0),(125,'fileList','',NULL,'显示文件列表',1,'',0,118,3,0),(126,'Pfile','',NULL,'文件类型管理',1,'',5,1,2,1),(127,'index','',NULL,'文件类型列表',1,'',0,126,3,1),(128,'add','',NULL,'添加文件类型',1,'',0,126,3,1),(129,'editPfile','',NULL,'编辑文件类型',1,'',0,126,3,0),(130,'opPfileStatus','',NULL,'快捷修改文件类型状态',1,'',0,126,3,0),(131,'opSort','',NULL,'修改文件类型排序',1,'',0,126,3,0),(132,'delPfile','',NULL,'删除文件类型',1,'',0,126,3,0),(133,'getUrl','',NULL,'获取文件类型地址',1,'',0,118,3,0),(134,'editProjectFile','',NULL,'修改项目文件',1,'',0,118,3,0),(135,'delProjectFile','',NULL,'删除项目文件',1,'',0,118,3,0),(136,'opProjectFileStatus','',NULL,'修改项目文件状态',1,'',0,118,3,0),(137,'index','',NULL,'日志列表',1,'',1,107,3,1),(140,'showtranslation','',NULL,'查看企业审计信息',1,'',0,118,3,0),(141,'SjObject','',NULL,'审计对象',1,'',13,1,2,1),(142,'index','',NULL,'审计对象',1,NULL,0,141,3,1),(143,'add','',NULL,'添加审计对象',1,NULL,1,141,3,1),(144,'index','Config',NULL,'数据字典管理',0,'',7,14,3,1),(145,'Sharedata',NULL,NULL,'共享文件管理',1,'',6,1,2,1),(146,'index',NULL,NULL,'共享文件列表',1,'',0,145,3,1),(147,'add',NULL,NULL,'添加共享文件',1,'',1,145,3,1),(148,'addlog',NULL,NULL,'添加共享文件下载日志',1,'',9,145,3,0),(149,'showlog',NULL,NULL,'查看下载日志',1,'',3,145,3,1),(150,'News',NULL,NULL,'新闻',1,'',0,1,2,1),(151,'add',NULL,NULL,'添加',1,'',0,150,3,1),(152,'delShare',NULL,NULL,'删除共享文件',1,'',4,145,3,0),(153,'editShare',NULL,NULL,'编辑共享文件',1,'',5,145,3,0),(154,'getfile',NULL,NULL,'下载共享文件',1,'',6,145,3,0),(155,'Schedule',NULL,NULL,'进度管理',1,'',2,1,2,1),(156,'index',NULL,NULL,'进度列表',1,'',0,155,3,1),(157,'addSchedule',NULL,NULL,'添加项目',1,'',1,155,3,1),(158,'editSchedule',NULL,NULL,'编辑项目',1,'',2,155,3,0),(159,'uploadfile',NULL,NULL,'添加项目节点文件',1,'',3,155,3,0),(160,'delSchedule',NULL,NULL,'删除项目',1,'',4,155,3,0),(161,'getfile',NULL,NULL,'下载项目节点文件',1,'',5,155,3,0),(162,'buildSjPlan',NULL,NULL,'生成审计计划列表',1,'',2,141,3,1);
