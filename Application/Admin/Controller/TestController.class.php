<?php

namespace Admin\Controller;

use Org\Util\ArrayList;
use Think\Controller;

class TestController extends CommonController
{

    public function index()
    {

        $data = D('Test')->searchSjobject();
        $this->assign('list', $data['list']);
        $this->assign('keys', $data['keys']);
        $this->assign('page', $data['page']);

        $this->display('index');
    }

    public function search()
    {
        $this->index();
    }

    /**
     * 添加审计对象
     */
    public function add()
    {
        if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');

            echo json_encode(D("Test")->addSjObject());

        } else {
            $info['cstatus'] = 1;
            $config = M('Config');
//            $areatype = array("市级对象", "县级对象", "县级对象");
//            $leval = array("A", "B", "C");
//            $cycle = array("1年", "2年", "3年", "4年", "5年");
//
//            $info = $this->getLevalTypeListOption($info);
//            $info = $this->getUnitListOption($info);
//            $areatype = $this->getAreaTypeListOption($areatype);
            $info = $this ->getCycleListOption($info,$config);
            $info = $this ->getLevalTypeListOption($info,$config);
            $info = $this ->getUnitListOption($info,$config);
            $this->assign('info', $info);
            $this->assign('title', '添加审计对象');
            $this->display('edit');
        }
    }

    /**
     * 编辑审计对象
     */
    public function editSjObject()
    {
        if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Test")->editSjObject());
        } else {

            $sjobject = M("Sjobject");
            $config = M('Config');

            $sql = "select * from on_sjobject as SJ left join on_sjobjectdetail as DETAIL  ON DETAIL.pid=SJ.id  where SJ.id =" . (int)$_GET['id'];
            $sjobjectArray = $sjobject->query($sql);
            $info = $sjobjectArray[0];

            $info = $this ->getCycleListOption($info,$config);
            $info = $this ->getLevalTypeListOption($info,$config);
            $info = $this ->getUnitListOption($info,$config);
//            $areatype = array("市级对象", "县级对象");
//            $leval = array("A", "B", "C");
//            $cycle = array("1年", "2年", "3年", "4年", "5年");
//            $info = $this->getLevalTypeListOption($info);
//            $info = $this->getUnitListOption($info);

//            $this->assign('areatype', $areatype);
//            $this->assign('leval', $leval);
//            $this->assign('cycle', $cycle);
            $this->assign('title', '添加审计对象');
            $this->assign("info", $info);

            $this->display('edit');
        }
    }

    /**
     * 管理审计情况
     */
    public function manageSjObject()
    {
        if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Test")->manageSjInfo());
        } else {
            //1.初始化法人表
            $M = M('Corporation');
            $FRlist = $M->where("sjid=" . (int)$_GET['id'])->order('time desc')->select();
            //2.初始化审计情况表
            $M = M('Sjinfo');
            $SJInfoList = $M->where("sjid=" . (int)$_GET['id'])->order('time desc')->select();

            $this->assign('title', '管理审计情况');
            $this->assign('FRlist', $FRlist);
            $this->assign('SJInfoList', $SJInfoList);
            $this->assign('name', $_GET['name']);

            $this->display('manage');
        }
    }

    public function opCompanyStatus()
    {
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode(D("Test")->opStatus());
    }

    private function getLevalTypeListOption($info,$config)
    {
        $cycle = $config->where("extent = 'leval_type'")->field("field_name")->select();
        $info['bsjdwfl'] = "";
        foreach ($cycle as $v) {
            $selected = $v['field_name'] == $info['bsjdwfl'] ? ' selected="selected"' : "";
            $info['bsjdwfl'] .= '<option value="' . $v['field_name'] . '"' . $selected . '>' . $v['field_name'] . '</option>';
        }
        return $info;
    }

    private function getUnitListOption($info,$config)
    {
        $cycle = $config->where("extent = 'unit'")->field("field_name")->select();
        $info['yslb'] = "";
        foreach ($cycle as $v) {
            $selected = $v['field_name'] == $info['yslb'] ? ' selected="selected"' : "";
            $info['yslb'] .= '<option value="' . $v['field_name'] . '"' . $selected . '>' . $v['field_name'] . '</option>';
        }
        return $info;
    }

    private function getCycleListOption($info,$config)
    {
        $cycle = $config->where("extent = 'cycle'")->field("field_name")->select();
        $info['sjzq'] = "";
        foreach ($cycle as $v) {
            $selected = $v['field_name'] == $info['sjzq'] ? ' selected="selected"' : "";
            $info['sjzq'] .= '<option value="' . $v['field_name'] . '"' . $selected . '>' . $v['field_name'] . '</option>';
        }
        return $info;
    }


//    private function getAreaTypeListOption($areatype)
//    {
//        $List = array("市级对象", "县级对象");
//        $info['areatype'] = $List;
//        return $info;
//    }
}

?>