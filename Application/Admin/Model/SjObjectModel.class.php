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
        $SJOBJECT = M("Sjobject");
        $sj['FRDWDM'] = I('post.frdwdm');
        $sj['name'] = I('post.name');
        $sj['FRDWQC'] = I('post.frdwqc');
        $sj['NSRBM'] = I('post.nsrbm');
        $sj['DWCLSJ'] = I('post.dwclsj');

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


        $datas['time'] = time();
        if ($id = $SJOBJECT->add($sj)) {
            $SJOBJECTDETAIL = M("Sjobjectdetail");
            $detail['pid'] = $id;
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
        $SJOBJECT = M("Sjobject");
        $id = I('post.id');
        $sj['id'] = $id;
        $sj['name'] = I('post.name');
        $sj['FRDWDM'] = I('post.frdwdm');
        $sj['FRDWQC'] = I('post.frdwqc');
        $sj['NSRBM'] = I('post.nsrbm');
        $sj['DWCLSJ'] = I('post.dwclsj');

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
        if ($corporation->add($data)) {
            $this->log->content = '添加法人';
            $this->log->addLog();
            return array('status' => 1, 'info' => '法人添加成功！');
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
        if ($corporation->add($data)) {
            $this->log->content = '添加审计情况';
            $this->log->addLog();
            return array('status' => 1, 'info' => '审计情况添加成功！');
        } else {
            return array('status' => 0, 'info' => '审计情况添加失败，请重试！');
        }
    }

    public function editCorporationDetail($id){
        $corporation = M('Corporation');
        $data['id'] = $id;

        $data['startTime'] = strtotime(I('post.startTime'));
        $data['endTime'] = strtotime(I('post.endTime'));
        $data['corporation'] = I('post.corporation');
        $data['explain'] = I('post.explain');
        if ($corporation->save($data)) {
            $this->log->content = '编辑法人';
            $this->log->addLog();
            return array('status' => 1, 'info' => '法人编辑成功！',"url" => u("SjObject/editCorporationFromDetail?id=$id"));
        } else {
            return array('status' => 0, 'info' => '法人编辑失败，请重试！');
        }
    }

    public function editSituationDetail($id){
        $corporation = M('Situation');
        $data['id'] = $id;
        $data['name'] =I('post.name');

        $data['startTime'] = strtotime(I('post.startTime'));
        $data['endTime'] = strtotime(I('post.endTime'));
        $data['explain'] = I('post.explain');
        if ($corporation->save($data)) {
            $this->log->content = '编辑审计情况';
            $this->log->addLog();
            return array('status' => 1, 'info' => '审计情况编辑成功！',"url" => u("SjObject/editSituationFromDetail?id=$id"));
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
     * 生成审计计划报表
     * $info 包含周期的数组（1,2,3,4,5）
     */
    public function buildSJPlan($info,$data = array()){
        //当前年度
        $currentTime = date("Y");
        $M = M('Sjobject');
        $sql = "SELECT DISTINCT * FROM on_sjobject DX WHERE ((".$currentTime."-2013+1)%DX.SJZQ=0) ";
        for($i = 0;$i<count($info);$i++){
            $sql .= " UNION ";
            $sql .=" select * from on_sjobject DX where ((".$currentTime."-2013+1)%DX.SJZQ =".$i.") ";
            for ($j=1; $j<=(int)$info[$i]["dname"]; $j++) {
                $sql.=" AND (select startTime from on_situation where FROM_UNIXTIME(startTime,'%Y') = ("
                    .$currentTime."-".$j.") limit 1) is NULL ";
            }
        }
        $list = $M->query($sql);
        C('TOKEN_ON', false);
        $data['list'] = $list;

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