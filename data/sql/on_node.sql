/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : sj_1

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-11-13 22:14:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `on_node`
-- ----------------------------
DROP TABLE IF EXISTS `on_node`;
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
) ENGINE=MyISAM AUTO_INCREMENT=162 DEFAULT CHARSET=utf8 COMMENT='权限节点表';

-- ----------------------------
-- Records of on_node
-- ----------------------------
INSERT INTO `on_node` VALUES ('1', 'Admin', '', null, '后台管理', '1', '网站后台管理项目', '1', '0', '1', '1');
INSERT INTO `on_node` VALUES ('2', 'Index', '', null, '管理首页', '1', '', '1', '1', '2', '1');
INSERT INTO `on_node` VALUES ('5', 'index', '', null, '默认页', '1', '', '5', '2', '3', '1');
INSERT INTO `on_node` VALUES ('6', 'myInfo', '', null, '我的个人信息', '1', '', '6', '2', '3', '1');
INSERT INTO `on_node` VALUES ('8', 'index', '', null, '用户列表', '1', '', '2', '14', '3', '1');
INSERT INTO `on_node` VALUES ('9', 'addAdmin', '', null, '添加用户', '1', '', '1', '14', '3', '1');
INSERT INTO `on_node` VALUES ('14', 'Access', '', null, '系统管理', '1', '权限管理，为系统后台管理员设置不同的权限', '8', '1', '2', '1');
INSERT INTO `on_node` VALUES ('15', 'nodeList', '', null, '查看节点', '1', '节点列表信息', '6', '14', '3', '1');
INSERT INTO `on_node` VALUES ('16', 'roleList', '', null, '角色列表查看', '1', '角色列表查看', '4', '14', '3', '1');
INSERT INTO `on_node` VALUES ('17', 'addRole', '', null, '添加角色', '1', '', '3', '14', '3', '1');
INSERT INTO `on_node` VALUES ('18', 'editRole', '', null, '编辑角色', '1', '', '0', '14', '3', '0');
INSERT INTO `on_node` VALUES ('19', 'opNodeStatus', '', null, '便捷开启禁用节点', '1', '', '0', '14', '3', '0');
INSERT INTO `on_node` VALUES ('20', 'opRoleStatus', '', null, '便捷开启禁用角色', '1', '', '0', '14', '3', '0');
INSERT INTO `on_node` VALUES ('21', 'editNode', '', null, '编辑节点', '1', '', '0', '14', '3', '0');
INSERT INTO `on_node` VALUES ('22', 'addNode', '', null, '添加节点', '1', '', '5', '14', '3', '1');
INSERT INTO `on_node` VALUES ('24', 'editAdmin', '', null, '编辑管理员信息', '1', '', '0', '14', '3', '0');
INSERT INTO `on_node` VALUES ('25', 'changeRole', '', null, '权限分配', '1', '', '0', '14', '3', '0');
INSERT INTO `on_node` VALUES ('32', 'SysData', '', null, '数据库管理', '1', '包含数据库备份、还原、打包等', '9', '1', '2', '1');
INSERT INTO `on_node` VALUES ('33', 'index', '', null, '查看数据库表结构信息', '1', '', '1', '32', '3', '1');
INSERT INTO `on_node` VALUES ('34', 'backup', '', null, '备份数据库', '1', '', '0', '32', '3', '0');
INSERT INTO `on_node` VALUES ('35', 'restore', '', null, '查看已备份SQL文件', '1', '', '0', '32', '3', '1');
INSERT INTO `on_node` VALUES ('36', 'restoreData', '', null, '执行数据库还原操作', '1', '', '0', '32', '3', '0');
INSERT INTO `on_node` VALUES ('37', 'delSqlFiles', '', null, '删除SQL文件', '1', '', '0', '32', '3', '0');
INSERT INTO `on_node` VALUES ('38', 'sendSql', '', null, '邮件发送SQL文件', '1', '', '0', '32', '3', '0');
INSERT INTO `on_node` VALUES ('39', 'zipSql', '', null, '打包SQL文件', '1', '', '0', '32', '3', '0');
INSERT INTO `on_node` VALUES ('40', 'zipList', '', null, '查看已打包SQL文件', '1', '', '0', '32', '3', '1');
INSERT INTO `on_node` VALUES ('41', 'unzipSqlfile', '', null, '解压缩ZIP文件', '1', '', '0', '32', '3', '0');
INSERT INTO `on_node` VALUES ('42', 'delZipFiles', '', null, '删除zip压缩文件', '1', '', '0', '32', '3', '0');
INSERT INTO `on_node` VALUES ('43', 'downFile', '', null, '下载备份的SQL,ZIP文件', '1', '', '0', '32', '3', '0');
INSERT INTO `on_node` VALUES ('44', 'repair', '', null, '数据库优化修复', '1', '', '0', '32', '3', '1');
INSERT INTO `on_node` VALUES ('137', 'index', '', null, '日志列表', '1', '', '1', '107', '3', '1');
INSERT INTO `on_node` VALUES ('130', 'opPfileStatus', '', null, '快捷修改文件类型状态', '1', '', '0', '126', '3', '0');
INSERT INTO `on_node` VALUES ('104', 'Department', '', null, '部门管理', '1', '', '7', '1', '2', '1');
INSERT INTO `on_node` VALUES ('105', 'index', '', null, '部门列表', '1', '', '0', '104', '3', '1');
INSERT INTO `on_node` VALUES ('106', 'add', '', null, '添加部门', '1', '', '0', '104', '3', '1');
INSERT INTO `on_node` VALUES ('107', 'Log', '', null, '日志管理', '1', '', '10', '1', '2', '1');
INSERT INTO `on_node` VALUES ('108', 'Company', '', null, '审计企业', '1', '', '4', '1', '2', '1');
INSERT INTO `on_node` VALUES ('109', 'index', '', null, '企业列表', '1', '', '0', '108', '3', '1');
INSERT INTO `on_node` VALUES ('110', 'add', '', null, '添加审计企业', '1', '', '1', '108', '3', '1');
INSERT INTO `on_node` VALUES ('111', 'search', '', null, '查询企业', '1', '', '2', '108', '3', '0');
INSERT INTO `on_node` VALUES ('112', 'edit', '', null, '编辑审计企业', '1', '', '3', '108', '3', '0');
INSERT INTO `on_node` VALUES ('113', 'del', '', null, '删除审计企业', '1', '', '4', '108', '3', '0');
INSERT INTO `on_node` VALUES ('114', 'editDepartment', '', null, '编辑部门', '1', '', '0', '104', '3', '0');
INSERT INTO `on_node` VALUES ('115', 'opDepartmentStatus', '', null, '快捷修改部门状态', '1', '', '0', '104', '3', '0');
INSERT INTO `on_node` VALUES ('116', 'opSort', '', null, '修改部门排序', '1', '', '0', '104', '3', '0');
INSERT INTO `on_node` VALUES ('117', 'delDepartment', '', null, '删除部门', '1', '', '0', '104', '3', '0');
INSERT INTO `on_node` VALUES ('118', 'Project', '', null, '项目管理', '1', '', '3', '1', '2', '0');
INSERT INTO `on_node` VALUES ('119', 'index', '', null, '项目列表', '1', '', '0', '118', '3', '1');
INSERT INTO `on_node` VALUES ('120', 'add', '', null, '添加项目', '1', '', '1', '118', '3', '1');
INSERT INTO `on_node` VALUES ('121', 'translation', '', null, '添加审计', '1', '', '0', '118', '3', '0');
INSERT INTO `on_node` VALUES ('122', 'editProject', '', null, '编辑审计项目', '1', '', '3', '118', '3', '0');
INSERT INTO `on_node` VALUES ('123', 'opProjectStatus', '', null, '修改项目状态', '1', '', '0', '118', '3', '0');
INSERT INTO `on_node` VALUES ('124', 'addFile', '', null, '添加项目文件', '1', '', '0', '118', '3', '0');
INSERT INTO `on_node` VALUES ('125', 'fileList', '', null, '显示文件列表', '1', '', '0', '118', '3', '0');
INSERT INTO `on_node` VALUES ('126', 'Pfile', '', null, '文件类型管理', '1', '', '5', '1', '2', '1');
INSERT INTO `on_node` VALUES ('127', 'index', '', null, '文件类型列表', '1', '', '0', '126', '3', '1');
INSERT INTO `on_node` VALUES ('128', 'add', '', null, '添加文件类型', '1', '', '0', '126', '3', '1');
INSERT INTO `on_node` VALUES ('129', 'editPfile', '', null, '编辑文件类型', '1', '', '0', '126', '3', '0');
INSERT INTO `on_node` VALUES ('144', 'index', 'Config', null, '数据字典管理', '0', '', '7', '14', '3', '1');
INSERT INTO `on_node` VALUES ('143', 'add', '', null, '添加审计对象', '1', null, '1', '141', '3', '1');
INSERT INTO `on_node` VALUES ('142', 'index', '', null, '审计对象', '1', null, '0', '141', '3', '1');
INSERT INTO `on_node` VALUES ('141', 'Test', '', null, '审计对象', '1', '', '13', '1', '2', '1');
INSERT INTO `on_node` VALUES ('140', 'showtranslation', '', null, '查看企业审计信息', '1', '', '0', '118', '3', '0');
INSERT INTO `on_node` VALUES ('131', 'opSort', '', null, '修改文件类型排序', '1', '', '0', '126', '3', '0');
INSERT INTO `on_node` VALUES ('132', 'delPfile', '', null, '删除文件类型', '1', '', '0', '126', '3', '0');
INSERT INTO `on_node` VALUES ('133', 'getUrl', '', null, '获取文件类型地址', '1', '', '0', '118', '3', '0');
INSERT INTO `on_node` VALUES ('134', 'editProjectFile', '', null, '修改项目文件', '1', '', '0', '118', '3', '0');
INSERT INTO `on_node` VALUES ('135', 'delProjectFile', '', null, '删除项目文件', '1', '', '0', '118', '3', '0');
INSERT INTO `on_node` VALUES ('136', 'opProjectFileStatus', '', null, '修改项目文件状态', '1', '', '0', '118', '3', '0');
INSERT INTO `on_node` VALUES ('145', 'Sharedata', null, null, '共享文件管理', '1', '', '6', '1', '2', '1');
INSERT INTO `on_node` VALUES ('146', 'index', null, null, '共享文件列表', '1', '', '0', '145', '3', '1');
INSERT INTO `on_node` VALUES ('147', 'add', null, null, '添加共享文件', '1', '', '1', '145', '3', '1');
INSERT INTO `on_node` VALUES ('148', 'addlog', null, null, '添加共享文件下载日志', '1', '', '9', '145', '3', '0');
INSERT INTO `on_node` VALUES ('149', 'showlog', null, null, '查看下载日志', '1', '', '3', '145', '3', '1');
INSERT INTO `on_node` VALUES ('150', 'News', null, null, '新闻', '1', '', '0', '1', '2', '1');
INSERT INTO `on_node` VALUES ('151', 'add', null, null, '添加', '1', '', '0', '150', '3', '1');
INSERT INTO `on_node` VALUES ('152', 'delShare', null, null, '删除共享文件', '1', '', '4', '145', '3', '0');
INSERT INTO `on_node` VALUES ('153', 'editShare', null, null, '编辑共享文件', '1', '', '5', '145', '3', '0');
INSERT INTO `on_node` VALUES ('154', 'getfile', null, null, '下载共享文件', '1', '', '6', '145', '3', '0');
INSERT INTO `on_node` VALUES ('155', 'Schedule', null, null, '进度管理', '1', '', '2', '1', '2', '1');
INSERT INTO `on_node` VALUES ('156', 'index', null, null, '进度列表', '1', '', '0', '155', '3', '1');
INSERT INTO `on_node` VALUES ('157', 'addSchedule', null, null, '添加项目', '1', '', '1', '155', '3', '1');
INSERT INTO `on_node` VALUES ('158', 'editSchedule', null, null, '编辑项目', '1', '', '2', '155', '3', '0');
INSERT INTO `on_node` VALUES ('159', 'uploadfile', null, null, '添加项目节点文件', '1', '', '3', '155', '3', '0');
INSERT INTO `on_node` VALUES ('160', 'delSchedule', null, null, '删除项目', '1', '', '4', '155', '3', '0');
INSERT INTO `on_node` VALUES ('161', 'getfile', null, null, '下载项目节点文件', '1', '', '5', '155', '3', '0');
