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
            $config = D('Config');

//            $areatype = array("市级对象", "县级对象", "县级对象");
//            $leval = array("A", "B", "C");
//            $cycle = array("1年", "2年", "3年", "4年", "5年");
//
//            $info = $this->getLevalTypeListOption($info);
//            $info = $this->getUnitListOption($info);
//            $areatype = $this->getAreaTypeListOption($areatype);
            $info = $this->getSelectOption($info, 'sjzq', 'pid=4');
            $info = $this->getSelectOption($info, 'bsjdwfl', 'pid=5');
            $info = $this->getSelectOption($info, 'yslb', 'pid=6');
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
            // $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Test")->editSjObject());
        } else {

            $sjobject = M("Sjobject");
            $sql = "select * from on_sjobject as SJ left join on_sjobjectdetail as DETAIL  ON DETAIL.pid=SJ.id  where SJ.id =" . (int)$_GET['id'];
            $sjobjectArray = $sjobject->query($sql);
            $info = $sjobjectArray[0];


            //$info = $this ->getCycleListOption($info,$config);
            $info = $this->getSelectOption($info, 'sjzq', 'pid=4');
            $info = $this->getSelectOption($info, 'bsjdwfl', 'pid=5');
            $info = $this->getSelectOption($info, 'yslb', 'pid=6');
            //$info = $this ->getLevalTypeListOption($info,$config);
            //$info = $this ->getUnitListOption($info,$config);
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
     * 编辑历任法人
     */
    public function editCorporation()
    {
        //1.初始化法人表
        $M = M('Corporation');
        $FRlist = $M->where("sjid=" . (int)$_GET['id'])->order('time desc')->select();

        $this->assign('title', '编辑历任法人');
        $this->assign('FRlist', $FRlist);
        $this->assign('name', $_GET['name']);
        $this->assign('info', (int)$_GET['id']);

        $this->display('corporation');
    }

    public function opCompanyStatus()
    {
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode(D("Test")->opStatus());
    }

    /**
     * 增加法人代表
     */
    public function addCorporation()
    {
        if (IS_POST) {
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Test")->addCorporation((int)$_GET['id']));
        } else {
            $this->assign('id', (int)$_GET['id']);
            $this->display('addCorporation');
        }
    }


    private function getSelectOption($info, $fieldname, $condition)
    {
        //$cycle = $config->where("pid = 5")->field("dname")->order('dsort')->select();
        $result = D('Config')->getConfigA($condition);
        $info[$fieldname] = "";
        foreach ($result as $v) {
            $selected = $v['dname'] == $info[$fieldname] ? ' selected="selected"' : "";
            $info[$fieldname] .= '<option value="' . $v['dname'] . '"' . $selected . '>' . $v['dname'] . '</option>';
        }
        return $info;
    }

}

?>