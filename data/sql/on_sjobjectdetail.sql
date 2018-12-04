# Host: localhost  (Version: 5.5.53)
# Date: 2018-12-04 22:33:20
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "on_sjobjectdetail"
#

CREATE TABLE `on_sjobjectdetail` (
  `pid` int(6) NOT NULL DEFAULT '0',
  `SJXXQK` text COMMENT '审计详细情况',
  `XZQH_JC` varchar(255) DEFAULT NULL COMMENT '行政区划（街、村、门牌号）',
  `XZQH_JWH` varchar(255) DEFAULT NULL COMMENT '居委会或村委会',
  `XZQH_XCM` varchar(255) DEFAULT NULL COMMENT '乡村码',
  `TXHM_DHFJH` varchar(255) DEFAULT '0' COMMENT '电话分机号',
  `TXHM_DZYX` varchar(255) DEFAULT NULL COMMENT '电子邮箱',
  `DJQK_GSBM` varchar(255) DEFAULT NULL COMMENT '登记机关-工商行政管理部门',
  `DJQK_BZBM` varchar(255) DEFAULT NULL COMMENT '登记机关-编制部门',
  `DJQK_MZBM` varchar(255) DEFAULT NULL COMMENT '登记机关-民政部门',
  `DJQK_QT` varchar(255) DEFAULT NULL COMMENT '登记机关-其他',
  `DJQK_SFMBFQY` varchar(255) DEFAULT NULL COMMENT '登记情况-是否民办非企业',
  `DJQK_GSDJZCH` varchar(255) DEFAULT NULL COMMENT '登记情况-工商登记注册号',
  `DJQK_BWDJZCH` varchar(255) DEFAULT NULL COMMENT '登记情况-编委登记注册号（编办文件“三定方案”）',
  `DJQK_FQYDJZCH` varchar(255) DEFAULT NULL COMMENT '登记情况-社团、民办非企业登记注册号',
  `DJQK_DJJG` varchar(255) DEFAULT NULL COMMENT '登记情况-登记机关-其他（请注明）',
  `ZDLB_ZXKJZD` varchar(255) DEFAULT NULL COMMENT '执行会计制度类别-执行会计制度',
  `ZDLB_DJZCLX` varchar(255) DEFAULT NULL COMMENT '执行会计制度类别-登记注册类型',
  `ZDLB_KGQK` varchar(255) DEFAULT NULL COMMENT '执行会计制度类别-控股情况',
  `ZDLB_LSGX` varchar(255) DEFAULT NULL COMMENT '执行会计制度类别-隶属关系',
  `XZSXJDW_SJDW` varchar(255) DEFAULT NULL COMMENT '行政上下级单位-行政上级单位',
  `XZSXJDW_XJDW` varchar(255) DEFAULT NULL COMMENT '行政上下级单位-行政下级单位',
  `CWSXJDW_SJDW` varchar(255) DEFAULT NULL COMMENT '财务上下级单位-财务上级单位',
  `CWSXJDW_CWXJDW` varchar(255) DEFAULT NULL COMMENT '财务上下级单位-财务下级单位',
  `QYZZDJ_JZYZZDJ` varchar(255) DEFAULT NULL COMMENT '企业资质登记-建筑业资质等级（新标准）',
  `QYZZDJ_JZYZZDJ_OLD` varchar(255) DEFAULT NULL COMMENT '企业资质登记-建筑业资质等级（老标准）',
  `QYZZDJ_FCKFYZZDJ` varchar(255) DEFAULT NULL COMMENT '企业资质登记-房地产开发业资质等级',
  `CYRYS_MEN` varchar(255) DEFAULT NULL COMMENT '从业人员数（男）',
  `CYRYS_WOMEN` varchar(255) DEFAULT NULL COMMENT '从业人员数（女）',
  `QYZCQK_QYSSZB` varchar(255) DEFAULT NULL COMMENT '企业资产情况-企业实收资本',
  `QYZCQK_GJZB` varchar(255) DEFAULT NULL COMMENT '企业资产情况-国家资本',
  `QYZCQK_JTZB` varchar(255) DEFAULT NULL COMMENT '企业资产情况-集体资本',
  `QYZCQK_FRZB` varchar(255) DEFAULT NULL COMMENT '企业资产情况-法人资本',
  `QYZCQK_GRZB` varchar(255) DEFAULT NULL COMMENT '企业资产情况-个人资本',
  `QYZCQK_GATZB` varchar(255) DEFAULT NULL COMMENT '企业资产情况-港澳台资本',
  `QYZCQK_WSZB` varchar(255) DEFAULT NULL COMMENT '企业资产情况-外商资本（不包含港澳台资本）',
  `QYZCQK_GDZCYZ` varchar(255) DEFAULT NULL COMMENT '企业资产情况-固定资产原值',
  `QYZCQK_GDZCJZ` varchar(255) DEFAULT NULL COMMENT '企业资产情况-固定资产净值',
  `QYZCQK_DQMC` varchar(255) DEFAULT NULL COMMENT '企业资产情况-地区名称',
  `JJZB_YYSR` varchar(255) DEFAULT NULL COMMENT '企业主要经济指标-全年营业收入',
  `JJZB_ZYYWSR` varchar(255) DEFAULT NULL COMMENT '企业主要经济指标-主营营业收入',
  `JJZB_MC` varchar(255) DEFAULT NULL COMMENT '企业主要经济指标-产品或设备名称',
  `JJZB_JLDW` varchar(255) DEFAULT NULL COMMENT '企业主要经济指标-产品或设备计量单位',
  `JJZB_SCNL` varchar(255) DEFAULT NULL COMMENT '企业主要经济指标-产品或设备生产能力',
  `JJZB_GYQYGM` varchar(255) DEFAULT NULL COMMENT '企业主要经济指标-工业企业规模',
  `FJZB_FIRST` varchar(255) DEFAULT NULL COMMENT '第一附加指标',
  `FJZB_SECOND` varchar(255) DEFAULT NULL COMMENT '第二附加指标',
  `FJZB_THRID` varchar(255) DEFAULT NULL COMMENT '第三附加指标',
  `FJZB_FOURTH` varchar(255) DEFAULT NULL COMMENT '第四附加指标',
  `JJZB_MC2` varchar(255) DEFAULT NULL COMMENT '企业主要经济指标-产品或设备名称2',
  `JJZB_JLDW2` varchar(255) DEFAULT NULL COMMENT '企业主要经济指标-产品或设备计量单位2',
  `JJZB_SCNL2` varchar(255) DEFAULT NULL COMMENT '企业主要经济指标-产品或设备生产能力2',
  `JJZB_MC3` varchar(255) DEFAULT NULL COMMENT '企业主要经济指标-产品或设备名称3',
  `JJZB_JLDW3` varchar(255) DEFAULT NULL COMMENT '企业主要经济指标-产品或设备计量单位3',
  `JJZB_SCNL3` varchar(255) DEFAULT NULL COMMENT '企业主要经济指标-产品或设备生产能力3',
  `modify_time` varchar(255) DEFAULT NULL COMMENT '最近一次修改的时间',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='审计对象表';
