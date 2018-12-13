<?php

namespace Admin\Model;

use Think\Model;

class SjObjectModel extends Model
{


    public $log;

    public function _initialize()
    {
        $this->log = D('Log');
    }

    /**
     * 添加审计对象
     * @return array
     */
    public function addSjObject()
    {

        $where['FRDWDM'] = I('post.frdwdm');

//        if (M('Sjobject')->where($where)->count() != 0) {
//            return array('status' => 0, 'info' => '法人单位代码重复，请重新填写');
//        }

        $SJOBJECT = M("Sjobject");
        $sj['did'] = session('my_info.department');
        $sj['aid'] = session('my_info.aid');
        $sj['modify_time'] = time();
        $sj['FRDWDM'] = I('post.frdwdm');
        $sj['name'] = I('post.name');
        $sj['FRDWQC'] = I('post.frdwqc');
        $sj['NSRBM'] = I('post.nsrbm');
        $sj['DWCLSJ'] = I('post.dwclsj');
        $sj['BSJDWFL'] = I('post.BSJDWFL');
        $sj['SJZQ'] = I('post.SJZQ');
        $sj['YSLB'] = I('post.YSLB');

        //录入时间
        //被审计单位分类
        //审计周期
        //审计情况(含历年)：
        //预算类别


//        $sj['DQFDDBR'] = I('post.fddbr');
        $sj['DWCLSJ'] = I('post.dwclsj');
        $sj['JJBZFS'] = I('post.jjbzfs');
        $sj['LY'] = I('post.ly');
        $sj['XZQH_XZ'] = I('post.xz');

        $sj['XZQH_JDBSC'] = I('post.jdbsc');

        $sj['XZQH_SDXM'] = I('post.sdxm');
        $sj['TXHM_DHHM'] = I('post.dhhm');
        $sj['TXHM_YZBM'] = I('post.yzbm');


        if ($id = $SJOBJECT->add($sj)) {
            $SJOBJECTDETAIL = M("Sjobjectdetail");
            $detail['pid'] = $id;
            $detail['modify_time'] = time();
            $detail['XZQH_JC'] = I('post.jc');
            $detail['XZQH_JC'] = I('post.jc');
            $detail['XZQH_JWH'] = I('post.jwh');
            $detail['XZQH_XCM'] = I('post.xcm');
            $detail['TXHM_DHFJH'] = I('post.dhfjh');
            $detail['DJQK_GSBM'] = I('post.gsbm');
            $detail['DJQK_GSDJZCH'] = I('post.gsdjzch');
            $detail['DJQK_BZBM'] = I('post.bzbm');
            $detail['DJQK_BWDJZCH'] = I('post.bwdjzch');
            $detail['DJQK_FQYDJZCH'] = I('post.fqydjzch');
            $detail['DJQK_QT'] = I('post.qt');
            $detail['DJQK_DJJG'] = I('post.djjg');
            $detail['DJQK_SFMBFQY'] = I('post.sfmbfqy');
            $detail['ZDLB_ZXKJZD'] = I('post.zxkjzd');
            $detail['ZDLB_DJZCLX'] = I('post.djzclx');
            $detail['ZDLB_KGQK'] = I('post.kgqk');
            $detail['ZDLB_LSGX'] = I('post.lsgz');
            $detail['XZSXJDW_SJDW'] = I('post.xzsjdw');
            $detail['XZSXJDW_XJDW'] = I('post.xzxjdw');
            $detail['CWSXJDW_SJDW'] = I('post.cwsjdw');
            $detail['CWSXJDW_CWXJDW'] = I('post.cwxjdw');
            $detail['QYZZDJ_JZYZZDJ'] = I('post.jzyzzdj');
            $detail['QYZZDJ_JZYZZDJ_OLD'] = I('post.jzyzzdjold');
            $detail['QYZZDJ_FCKFYZZDJ'] = I('post.fckfyzzdj');
            $detail['CYRYS_MEN'] = I('post.men');
            $detail['CYRYS_WOMEN'] = I('post.women');
            $detail['QYZCQK_QYSSZB'] = I('post.qysszb');
            $detail['QYZCQK_GJZB'] = I('post.gjzb');
            $detail['QYZCQK_JTZB'] = I('post.jtzb');
            $detail['QYZCQK_FRZB'] = I('post.frzb');
            $detail['QYZCQK_GRZB'] = I('post.grzb');
            $detail['QYZCQK_GATZB'] = I('post.gatzb');
            $detail['QYZCQK_WSZB'] = I('post.wszb');
            $detail['QYZCQK_GDZCYZ'] = I('post.gdzcyz');
            $detail['QYZCQK_GDZCJZ'] = I('post.gdzcjz');
            $detail['JJZB_YYSR'] = I('post.yysr');
            $detail['JJZB_ZYYWSR'] = I('post.zyywsr');
            $detail['JJZB_MC'] = I('post.cpmc');
            $detail['JJZB_JLDW'] = I('post.cpjldw');
            $detail['JJZB_SCNL'] = I('post.cpscnl');
            $detail['JJZB_MC2'] = I('post.cpmc2');
            $detail['JJZB_JLDW2'] = I('post.cpjldw2');
            $detail['JJZB_SCNL2'] = I('post.cpscnl2');
            $detail['JJZB_MC3'] = I('post.cpmc3');
            $detail['JJZB_JLDW3'] = I('post.cpjldw3');
            $detail['JJZB_SCNL3'] = I('post.cpscnl3');
            $detail['JJZB_GYQYGM'] = I('post.gyqygm');
            $detail['FJZB_FIRST'] = I('post.first');
            $detail['FJZB_SECOND'] = I('post.second');
            $detail['FJZB_THRID'] = I('post.thrid');
            $detail['FJZB_FOURTH'] = I('post.fourth');

            if ($SJOBJECTDETAIL->add($detail)) {
                $this->log->content = '添加审计对象';
                $this->log->addLog();
                return array('status' => 1, 'info' => '审计对象添加成功！', 'url' => u('SjObject/index'));
            } else {
                return array('status' => 0, 'info' => '审计对象添加失败，请重试！');
            }

        } else {
            return array('status' => 0, 'info' => '审计对象添加失败，请重试！');
        }

    }

    /**
     * 编辑审计对象
     * @return array
     */
    public function editSjObject()
    {
        $id = I('post.id');

        if (M('Sjobject')->where("FRDWDM = '" . I('post.frdwdm') . "' AND id!='" . $id . "'")->count() != 0) {
            return array('status' => 0, 'info' => '法人单位代码重复，请重新填写');
        }

        $SJOBJECT = M("Sjobject");
        $sj['did'] = session('my_info.department');
        $sj['aid'] = session('my_info.aid');

        $sj['id'] = $id;
        $sj['name'] = I('post.name');
        $sj['FRDWDM'] = I('post.frdwdm');
        $sj['FRDWQC'] = I('post.frdwqc');
        $sj['NSRBM'] = I('post.nsrbm');
        $sj['DWCLSJ'] = I('post.dwclsj');
        $sj['BSJDWFL'] = I('post.BSJDWFL');
        $sj['SJZQ'] = I('post.SJZQ');
        $sj['YSLB'] = I('post.YSLB');
        $sj['modify_time'] = time();
        //录入时间
        //被审计单位分类
        //审计周期
        //审计情况(含历年)：
        //预算类别


//        $sj['DQFDDBR'] = I('post.fddbr');

        $sj['DWCLSJ'] = I('post.dwclsj');
        $sj['JJBZFS'] = I('post.jjbzfs');
        $sj['LY'] = I('post.ly');
        $sj['XZQH_XZ'] = I('post.xz');

        $sj['XZQH_JDBSC'] = I('post.jdbsc');

        $sj['XZQH_SDXM'] = I('post.sdxm');
        $sj['TXHM_DHHM'] = I('post.dhhm');
        $sj['TXHM_YZBM'] = I('post.yzbm');

        if ($SJOBJECT->save($sj)) {
            $SJOBJECTDETAIL = M("Sjobjectdetail");
            $detail['pid'] = $id;
            $detail['modify_time'] = time();
//            $sj['SJXXQK'] = I('post.sjxxqk');
            $detail['XZQH_JC'] = I('post.jc');
            $detail['XZQH_JWH'] = I('post.jwh');
            $detail['XZQH_XCM'] = I('post.xcm');
            $detail['TXHM_DHFJH'] = I('post.dhfjh');
            $detail['DJQK_GSBM'] = I('post.gsbm');
            $detail['DJQK_GSDJZCH'] = I('post.gsdjzch');
            $detail['DJQK_BZBM'] = I('post.bzbm');
            $detail['DJQK_BWDJZCH'] = I('post.bwdjzch');
            $detail['DJQK_FQYDJZCH'] = I('post.fqydjzch');
            $detail['DJQK_QT'] = I('post.qt');
            $detail['DJQK_DJJG'] = I('post.djjg');
            $detail['DJQK_SFMBFQY'] = I('post.sfmbfqy');
            $detail['ZDLB_ZXKJZD'] = I('post.zxkjzd');
            $detail['ZDLB_DJZCLX'] = I('post.djzclx');
            $detail['ZDLB_KGQK'] = I('post.kgqk');
            $detail['ZDLB_LSGX'] = I('post.lsgz');
            $detail['XZSXJDW_SJDW'] = I('post.xzsjdw');
            $detail['XZSXJDW_XJDW'] = I('post.xzxjdw');
            $detail['CWSXJDW_SJDW'] = I('post.cwsjdw');
            $detail['CWSXJDW_CWXJDW'] = I('post.cwxjdw');
            $detail['QYZZDJ_JZYZZDJ'] = I('post.jzyzzdj');
            $detail['QYZZDJ_JZYZZDJ_OLD'] = I('post.jzyzzdjold');
            $detail['QYZZDJ_FCKFYZZDJ'] = I('post.fckfyzzdj');
            $detail['CYRYS_MEN'] = I('post.men');
            $detail['CYRYS_WOMEN'] = I('post.women');
            $detail['QYZCQK_QYSSZB'] = I('post.qysszb');
            $detail['QYZCQK_GJZB'] = I('post.gjzb');
            $detail['QYZCQK_JTZB'] = I('post.jtzb');
            $detail['QYZCQK_FRZB'] = I('post.frzb');
            $detail['QYZCQK_GRZB'] = I('post.grzb');
            $detail['QYZCQK_GATZB'] = I('post.gatzb');
            $detail['QYZCQK_WSZB'] = I('post.wszb');
            $detail['QYZCQK_GDZCYZ'] = I('post.gdzcyz');
            $detail['QYZCQK_GDZCJZ'] = I('post.gdzcjz');
            $detail['JJZB_YYSR'] = I('post.yysr');
            $detail['JJZB_ZYYWSR'] = I('post.zyywsr');
            $detail['JJZB_MC'] = I('post.cpmc');
            $detail['JJZB_JLDW'] = I('post.cpjldw');
            $detail['JJZB_SCNL'] = I('post.cpscnl');
            $detail['JJZB_MC2'] = I('post.cpmc2');
            $detail['JJZB_JLDW2'] = I('post.cpjldw2');
            $detail['JJZB_SCNL2'] = I('post.cpscnl2');
            $detail['JJZB_MC3'] = I('post.cpmc3');
            $detail['JJZB_JLDW3'] = I('post.cpjldw3');
            $detail['JJZB_SCNL3'] = I('post.cpscnl3');
            $detail['JJZB_GYQYGM'] = I('post.gyqygm');
            $detail['FJZB_FIRST'] = I('post.first');
            $detail['FJZB_SECOND'] = I('post.second');
            $detail['FJZB_THRID'] = I('post.thrid');
            $detail['FJZB_FOURTH'] = I('post.fourth');
            if ($SJOBJECTDETAIL->save($detail)) {
                $this->log->content = '编辑审计对象';
                $this->log->addLog();
                return array("status" => 1, "info" => "审计对象更新成功！", "url" => u("SjObject/index"));
            } else {
                printf("1");
                return array("status" => 0, "info" => "更新失败，请重试");
            }
        } else {
            printf("2");
            return array("status" => 0, "info" => "更新失败，请重试");
        }
    }

    /**
     * 添加法人代表
     */
    public function addCorporation($id)
    {
        $corporation = M('Corporation');
        $data['sjid'] = $id;

        $data['startTime'] = strtotime(I('post.startTime'));
        $data['endTime'] = strtotime(I('post.endTime'));
        $data['corporation'] = I('post.corporation');
        $data['explain'] = I('post.explain');
        $data['modify_time'] = time();
        if ($corporation->add($data)) {
            $this->log->content = '添加法人';
            $this->log->addLog();
            return array('status' => 1, 'info' => '法人添加成功！', "url" => u("SjObject/editCorporation?id=$id"));
        } else {
            return array('status' => 0, 'info' => '法人添加失败，请重试！');
        }
    }

    /**
     * 添加审计情况
     */
    public function addSituation($id)
    {
        $corporation = M('Situation');
        $data['sjid'] = $id;
        $data['name'] = I('post.name');
        $data['startTime'] = strtotime(I('post.startTime'));
        $data['endTime'] = strtotime(I('post.endTime'));
        $data['explain'] = I('post.explain');
        $data['uploadUrl'] = I('post.uploadUrl');
        $data['modify_time'] = time();
        if ($corporation->add($data)) {
            $this->log->content = '添加审计情况';
            $this->log->addLog();
            return array('status' => 1, 'info' => '审计情况添加成功！', "url" => u("SjObject/editSituation?id=$id"));
        } else {
            return array('status' => 0, 'info' => '审计情况添加失败，请重试！');
        }
    }

    public function editCorporationDetail($id)
    {
        $corporation = M('Corporation');
        $data['id'] = $id;

        $data['startTime'] = strtotime(I('post.startTime'));
        $data['endTime'] = strtotime(I('post.endTime'));
        $data['corporation'] = I('post.corporation');
        $data['explain'] = I('post.explain');
        $data['modify_time'] = time();
        if ($corporation->save($data)) {
            $this->log->content = '编辑法人';
            $this->log->addLog();
            return array('status' => 1, 'info' => '法人编辑成功！', "url" => u("SjObject/editCorporationFromDetail?id=$id"));
        } else {
            return array('status' => 0, 'info' => '法人编辑失败，请重试！');
        }
    }

    public function editSituationDetail($id)
    {
        $corporation = M('Situation');
        $data['id'] = $id;
        $data['name'] = I('post.name');

        $data['startTime'] = strtotime(I('post.startTime'));
        $data['endTime'] = strtotime(I('post.endTime'));
        $data['explain'] = I('post.explain');
        $data['modify_time'] = time();
        if ($corporation->save($data)) {
            $this->log->content = '编辑审计情况';
            $this->log->addLog();
            return array('status' => 1, 'info' => '审计情况编辑成功！', "url" => u("SjObject/editSituationFromDetail?id=$id"));
        } else {
            return array('status' => 0, 'info' => '审计情况编辑失败，请重试！');
        }
    }


    /**
     * 管理审计情况
     */
    public function manageSjInfo()
    {
        return array("status" => 1, "info" => "提交功能暂未开发！", "url" => u("SjObject/index"));
    }

    /** 初始化审计对象主列表
     * @param array $data
     * @return array
     */
    public function searchSjobject($data = array())
    {

        $M = M('Sjobject');
        if (IS_POST) {
            $keys = I('post.');

            $where = array($keys[field] => array('LIKE', '%' . $keys['keyword'] . '%'));

            $did = $keys['department'];

            if (!empty($did)) {
                $where = array_merge(array('did='."'" . $keys['department']."'"), $where);
            }

            $aid = $keys['user'];
            if (!empty($aid)) {
                $where = array_merge(array('aid='."'" . $keys['user']."'"), $where);
            }

            if(!empty($keys['BSJDWFL'])){
                $where = array_merge(array('BSJDWFL='."'" . $keys['BSJDWFL']."'"), $where);
            }
            if(!empty($keys['YSLB'])){
                $where = array_merge(array('YSLB='."'" . $keys['YSLB']."'"), $where);
            }
            if(!empty($keys['SJZQ'])){
                $where = array_merge(array('SJZQ='."'" . $keys['SJZQ']."'"), $where);
            }
        } else {
            /**
             * 如果不是超级管理员  那么进入时要筛选权限内的信息出来
             */
            if (session('my_info.aid') != 10 && session('my_info.department') > 0) {
                $where = array('did=' . session('my_info.department'));
                $where = array_merge(array('aid=' . session('my_info.aid')), $where);
            }
        }

        $count = $M->where($where)->count();
        $pConf = page($count, 10);

        $list = $M->where($where)->order('id desc')->limit($pConf['first'], $pConf['list'])->select();

        $keys['count'] = $count;
        $data['keys'] = $keys;
        $data['page'] = $pConf['show'];
        $data['list'] = $list;
        C('TOKEN_ON', false);
        return $data;
    }

    /**
     * 生成过往年份的审计计划报表
     * @param $info
     */
    public function buildSJPlanByCondition($info, $data = array())
    {
        if (IS_POST) {
            $keys = I('post.');
            //如果是年份的话  那么就去读取历年表
            if ($keys['field'] == "year") {
                $M = M("past_plan");
                $valus = $keys['keyword'];
                $plan = $M->query("select * from on_past_plan where sj_year = '" . $valus . "'");
                $str = $plan[0]['sj_id_bean'];
                $idList = split(",", $str);
                $sql = "select * from on_sjobject where id in (";
                foreach ($idList as $v) {
                    if (!empty($v)) {
                        $sql .= $v . ",";
                    }
                }
                $sql = substr($sql, 0, strlen($sql) - 1);
                $sql .= ")";
                $list = $M->query($sql);
            } else {
                //如果是其他字段搜索  就需要复合查询
                $M = M("past_plan");
                $valus = $keys['keyword'];
                $plan = $M->query("select * from on_past_plan where sj_year = '" . date("Y") . "'");
                $str = $plan[0]['sj_id_bean'];
                $idList = split(",", $str);
                $sql = "select * from on_sjobject where id in (";
                foreach ($idList as $v) {
                    if (!empty($v)) {
                        $sql .= $v . ",";
                    }
                }
                $sql = substr($sql, 0, strlen($sql) - 1);
                $sql .= ")";
                $sql .= " AND " . $keys['field'] . " like '%" . $valus . "%' ";

                if(!empty($keys['BSJDWFL'])){
                    $sql.=" AND BSJDWFL = '".$keys['BSJDWFL']."'";
                }
                if(!empty($keys['YSLB'])){
                    $sql.=" AND YSLB = '".$keys['YSLB']."'";
                }
                if(!empty($keys['SJZQ'])){
                    $sql.=" AND SJZQ = '".$keys['SJZQ']."'";
                }
                $list = $M->query($sql);
            }

            C('TOKEN_ON', false);
            //4.这里把审计计划列表按照周期分组并拼成html
            //4.这里把审计计划列表按照周期分组并拼成html
            foreach ($list as $v => $k) {
                $data[$k['SJZQ']][] = $k;
            }
            foreach ($info as $j => $z) {
                $i = 0;
                $pgg .= '<tr><td colspan="6">' . $z['dname'] . '年一审</td></tr>';
                $pgs = '';
//            $pastBean .= "%" . $z['dname'] . "%,";
                foreach ($data[$z['dname']] as $v => $k) {
                    if ($hasCreated == false) {
                        $id = $k['id'];
                    } else {
                        $id = $k['sj_id'];
                    }


                    if (($i / 6) == intval($i / 6)) {
                        if ($i >= 6) {
                            $i = 0;
                            $pgs .= '</tr>';
                        }
                        $pgs .= '<tr><td><a href="' . U('watchSjObject', array('id' => $id)) . '">' . $k['name'] . '</a></td>';
                    } else {
                        $pgs .= '<td><a href="' . U('watchSjObject', array('id' => $id)) . '">' . $k['name'] . '</a></td>';
                    }
                    $pastBean .= "" . $k['id'] . ",";
                    $i++;
                }
                for ($k = 1; $k <= 6 - $i; $k++) {
                    $pgs .= '<td>&nbsp;</td>';
                }
                $pgg .= $pgs . '</tr>';
            }
            $data['keys'] = $keys;
            $data['list'] = $list;
            $data['pg'] = $pgg;
            return $data;
        }
    }

    /**
     * 创建往年审计计划表
     * @param $info
     * @param $currentYear
     * @param array $data
     * @return array
     */
    public function buildPastSJPlan($info, $currentYear, $data = array())
    {
        if (IS_POST) {
            $keys = I('post.');
            //如果是其他字段搜索  就需要复合查询
            $M = M("past_plan");
            $valus = $keys['keyword'];
            $plan = $M->query("select * from on_past_plan where sj_year = '" . $keys['year'] . "'");
            $str = $plan[0]['sj_id_bean'];
            $idList = split(",", $str);
            $sql = "select * from on_sjobject where id in (";
            foreach ($idList as $v) {
                if (!empty($v)) {
                    $sql .= $v . ",";
                }
            }
            $sql = substr($sql, 0, strlen($sql) - 1);
            $sql .= ")";
            $sql .= " AND " . $keys['field'] . " like '%" . $valus . "%' ";
            if(!empty($keys['BSJDWFL'])){
                $sql.=" AND BSJDWFL = '".$keys['BSJDWFL']."'";
            }
            if(!empty($keys['YSLB'])){
                $sql.=" AND YSLB = '".$keys['YSLB']."'";
            }
            if(!empty($keys['SJZQ'])){
                $sql.=" AND SJZQ = '".$keys['SJZQ']."'";
            }
            $list = $M->query($sql);
        } else {
            $keys = I('post.');
            $M = M("past_plan");
            $plan = $M->query("select * from on_past_plan where sj_year = '" . $currentYear . "'");
            $str = $plan[0]['sj_id_bean'];
            $idList = split(",", $str);
            $sql = "select * from on_sjobject where id in (";
            foreach ($idList as $v) {
                if (!empty($v)) {
                    $sql .= $v . ",";
                }
            }
            $sql = substr($sql, 0, strlen($sql) - 1);
            $sql .= ")";
            $list = $M->query($sql);
        }
        C('TOKEN_ON', false);
        //4.这里把审计计划列表按照周期分组并拼成html
        //4.这里把审计计划列表按照周期分组并拼成html
        foreach ($list as $v => $k) {
            $data[$k['SJZQ']][] = $k;
        }
        foreach ($info as $j => $z) {
            $i = 0;
            $pgg .= '<tr><td colspan="6">' . $z['dname'] . '年一审</td></tr>';
            $pgs = '';
//            $pastBean .= "%" . $z['dname'] . "%,";
            foreach ($data[$z['dname']] as $v => $k) {
                if ($hasCreated == false) {
                    $id = $k['id'];
                } else {
                    $id = $k['sj_id'];
                }


                if (($i / 6) == intval($i / 6)) {
                    if ($i >= 6) {
                        $i = 0;
                        $pgs .= '</tr>';
                    }
                    $pgs .= '<tr><td><a href="' . U('watchSjObject', array('id' => $id)) . '">' . $k['name'] . '</a></td>';
                } else {
                    $pgs .= '<td><a href="' . U('watchSjObject', array('id' => $id)) . '">' . $k['name'] . '</a></td>';
                }
                $pastBean .= "" . $k['id'] . ",";
                $i++;
            }
            for ($k = 1; $k <= 6 - $i; $k++) {
                $pgs .= '<td>&nbsp;</td>';
            }
            $pgg .= $pgs . '</tr>';
        }
        $data['keys'] = $keys;
        $data['list'] = $list;
        $data['pg'] = $pgg;
        return $data;
    }

    /**
     * 生成审计计划报表
     * $info 包含周期的数组（1,2,3,4,5）
     */
    public function buildSJPlan($info, $data = array())
    {
        $current = M('current_plan');
        $past = M('past_plan');
        $hasCreated = false;
        //1.先从当前审计计划表里面找   如果有直接读表
        $count = $current->count();
        if ($count != 0) {
            $hasCreated = true;
            $list = $current->query("select * from on_current_plan");
        } else {
            //2.如果没有  则生成一个审计计划
            //当前年度
            $currentTime = date("Y");
            $M = M('Sjobject');
            $sql = "SELECT DISTINCT * FROM on_sjobject DX WHERE ((" . $currentTime . "-2013+1)%DX.SJZQ=0)  ";
            for ($i = 0; $i < count($info); $i++) {
                $sql .= " UNION ";
                $sql .= " select * from on_sjobject DX where ((" . $currentTime . "-2013+1)%DX.SJZQ =" . $i . ") ";
                for ($j = 1; $j <= (int)$info[$i]["dname"]; $j++) {
                    $sql .= " AND (select startTime from on_situation where FROM_UNIXTIME(startTime,'%Y') = ("
                        . $currentTime . "-" . $j . ") limit 1) is NULL ";
                }
            }
            $list = $M->query($sql);
            $plan = array();
            $planCount = 0;
            //3.生成完成后  把新生成的插入到当前审计计划表里面
            foreach ($list as $v => $k) {
                $bean['sj_id'] = $k['id'];
                $bean['name'] = $k['name'];
                $bean['SJZQ'] = $k['SJZQ'];
                $bean['sj_year'] = date('Y');
                $plan[$planCount] = $bean;
                $planCount++;
            }
            $current->addAll($plan);
        }


        C('TOKEN_ON', false);
        $pastBean = "";
        //4.这里把审计计划列表按照周期分组并拼成html
        foreach ($list as $v => $k) {
            $data[$k['SJZQ']][] = $k;
        }
        foreach ($info as $j => $z) {
            $i = 0;
            $pgg .= '<tr><td colspan="6">' . $z['dname'] . '年一审</td></tr>';
            $pgs = '';
//            $pastBean .= "%" . $z['dname'] . "%,";
            foreach ($data[$z['dname']] as $v => $k) {
                if ($hasCreated == false) {
                    $id = $k['id'];
                } else {
                    $id = $k['sj_id'];
                }


                if (($i / 6) == intval($i / 6)) {
                    if ($i >= 6) {
                        $i = 0;
                        $pgs .= '</tr>';
                    }
                    $pgs .= '<tr><td><a href="' . U('watchSjObject', array('id' => $id)) . '">' . $k['name'] . '</a></td>';
                } else {
                    $pgs .= '<td><a href="' . U('watchSjObject', array('id' => $id)) . '">' . $k['name'] . '</a></td>';
                }
                $pastBean .= "" . $k['id'] . ",";
                $i++;
            }
            for ($k = 1; $k <= 6 - $i; $k++) {
                $pgs .= '<td>&nbsp;</td>';
            }
            $pgg .= $pgs . '</tr>';
        }
        //5.如果没有生成过审计计划   这里还要插入历年审计计划表里面
        if ($hasCreated == false) {
            $pastPlan['sj_year'] = date('Y');
            $pastPlan['sj_id_bean'] = $pastBean;
            $past->where("sj_year = '" . date('Y') . "'")->delete();
            $past->add($pastPlan);
        }
        $data['list'] = $list;
        $data['pg'] = $pgg;
        return $data;

    }

    public function opStatus()
    {

        $M = M('Sjobject');
        $datas["id"] = (int)$_GET["id"];
        $datas["cstatus"] = ($_GET["status"] == 1 ? 0 : 1);

        if ($M->save($datas)) {
            $this->log->content = '修改企业状态';
            $this->log->addLog();
            return array(
                "status" => 1,
                "info" => "处理成功",
                "data" => array("status" => $datas["cstatus"], "txt" => $datas["cstatus"] == 1 ? "禁用" : "启动")
            );
        } else {
            return array("status" => 0, "info" => "处理失败");
        }


    }
}

?>
