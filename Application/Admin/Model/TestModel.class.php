<?php

namespace Admin\Model;

use Think\Model;

class TestModel extends Model
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
//        $datas['name'] = I('post.cname');
//        if (0 < $M->where('name ="' . $datas['name'] . '"')->count()) {
//            return array('status' => 0, 'info' => '已经存在相同的审计对象名称!');
//        }
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


        $sj['DQFDDBR'] = I('post.fddbr');
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
                return array('status' => 1, 'info' => '审计对象添加成功！', 'url' => u('Test/index'));
//            return array('status' => 1, 'info' => $datas['name'], 'url' => u('Test/index'));
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


        $sj['DQFDDBR'] = I('post.fddbr');

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
                return array("status" => 1, "info" => "审计对象更新成功！", "url" => u("Test/index"));
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
     * 管理审计情况
     */
    public function manageSjInfo()
    {
        return array("status" => 1, "info" => "提交功能暂未开发！", "url" => u("Test/index"));
    }

    public function searchSjobject($data = array())
    {

        $M = M('Sjobject');
        if (IS_POST) {
            $keys = I('post.');

            $where = array($keys[field] => array('LIKE', '%' . $keys['keyword'] . '%'));
        }
//    if($data['status']==1) $where['cstatus'] =1;//不显示禁用企业

        $count = $M->where($where)->count();
        $pConf = page($count, C('PAGE_SIZE'));

        $list = $M->where($where)->order('id desc')->limit($pConf['first'], $pConf['list'])->select();

        $keys['count'] = $count;
        $data['keys'] = $keys;
        $data['page'] = $pConf['show'];
        $data['list'] = $list;
        C('TOKEN_ON', false);

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