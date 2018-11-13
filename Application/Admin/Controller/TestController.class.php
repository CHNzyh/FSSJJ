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
            $info = $this->getSelectOption($info, 'sjzq', 'pid=4');
            $info = $this->getSelectOption($info, 'bsjdwfl', 'pid=5');
            $info = $this->getSelectOption($info, 'yslb', 'pid=6');
            $this->assign('info', $info);
            $this->assign('title', '添加审计对象');
            $this->display('addObject');
        }
    }

    /**
     * 生成审计计划列表
     */
    public function buildSJPlan(){
        $info['cstatus'] = 1;
        $info = D('Config')->getConfigA('pid = 5');
        $data = D('Test')->buildSJPlan($info);
        $this->assign('list', $data['list']);
        $this->assign('keys', $data['keys']);
        $this->assign('page', $data['page']);
        $this->display('sjPlan');
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
            $info = $this->getSelectOption($info, 'sjzq', 'pid=5');
            $info = $this->getSelectOption($info, 'bsjdwfl', 'pid=4');
            $info = $this->getSelectOption($info, 'yslb', 'pid=6');
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
        $FRlist = $M->where("sjid=" . (int)$_GET['id'])->select();

        foreach ($FRlist as $num => $v) {
            $v['startTime'] = date('Y/m/d', $v['startTime']);
            $v['endTime'] = date('Y/m/d', $v['endTime']);
            $FRlist[$num] = $v;
        }

        $this->assign('title', '编辑历任法人');
        $this->assign('FRlist', $FRlist);
        $this->assign('name', $_GET['name']);
        $this->assign('info', (int)$_GET['id']);


        $this->display('corporation');
    }

    /**
     * 编辑历年审计对象
     */
    public function editSituation()
    {
        //1.初始化法人表
        $M = M('Situation');
        $FRlist = $M->where("sjid=" . (int)$_GET['id'])->select();

        foreach ($FRlist as $num => $v) {
            $v['startTime'] = date('Y/m/d', $v['startTime']);
            $v['endTime'] = date('Y/m/d', $v['endTime']);
            $FRlist[$num] = $v;
        }

        $this->assign('title', '编辑历任法人');
        $this->assign('FRlist', $FRlist);
        $this->assign('name', $_GET['name']);
        $this->assign('info', (int)$_GET['id']);


        $this->display('situation');
    }

    /**
     * 从列表回来的历任法人主列表
     */
    public function editCorporationFromDetail($id)
    {
        //1.初始化法人表
        $M = M('Corporation');
        $info = $M->where("id=" . $id)->find();

        $FRlist = $M->where("sjid=" . $info['sjid'])->select();

        foreach ($FRlist as $num => $v) {
            $v['startTime'] = date('Y/m/d', $v['startTime']);
            $v['endTime'] = date('Y/m/d', $v['endTime']);
            $FRlist[$num] = $v;
        }

        $this->assign('title', '编辑历任法人');
        $this->assign('FRlist', $FRlist);
        $this->assign('name', $_GET['name']);
        $this->assign('info', $info['sjid']);


        $this->display('corporation');
    }

    /**
     * 从列表回来的历年审计情况主列表
     */
    public function editSituationFromDetail($id)
    {
        //1.初始化法人表
        $M = M('Situation');
        $info = $M->where("id=" . $id)->find();

        $FRlist = $M->where("sjid=" . $info['sjid'])->select();

        foreach ($FRlist as $num => $v) {
            $v['startTime'] = date('Y/m/d', $v['startTime']);
            $v['endTime'] = date('Y/m/d', $v['endTime']);
            $FRlist[$num] = $v;
        }

        $this->assign('title', '编辑审计情况');
        $this->assign('FRlist', $FRlist);
        $this->assign('name', $_GET['name']);
        $this->assign('info', $info['sjid']);


        $this->display('situation');
    }

    /**
     * 在历任法人上面点击编辑
     */
    public function editCorporationDetail()
    {

        if (IS_POST) {
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Test")->editCorporationDetail((int)$_GET['id']));
        } else {
            $M = M('Corporation');
            $detail = $M->where("id=" . (int)$_GET['id'])->find();
            $detail['startTime'] = date('Y/m/d', $detail['startTime']);
            $detail['endTime'] = date('Y/m/d', $detail['endTime']);
            $this->assign('info', $detail);
            $this->display('editCorporation');
        }
    }

    /**
     * 在历年审计情况上点击编辑审计情况
     */
    public function editSituationDetail()
    {
        if (IS_POST) {
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Test")->editSituationDetail((int)$_GET['id']));
        } else {
            $M = M('Situation');
            $detail = $M->where("id=" . (int)$_GET['id'])->find();
            $detail['startTime'] = date('Y/m/d', $detail['startTime']);
            $detail['endTime'] = date('Y/m/d', $detail['endTime']);
            $this->assign('info', $detail);
            $this->display('editSituation');
        }
    }

    /**
     * 删除法人代表
     */
    public function deleteCorporation()
    {
        $M = M('Corporation');
        $id = i('get.id');
        if ($M->where(array('id' => $id))->delete()) {
            $this->success('法人代表删除成功！');
        } else {
            $this->error('法人代表删除失败！');
        }
    }

    /**
     * 删除法人代表
     */
    public function deleteSituation()
    {
        $M = M('Situation');
        $id = i('get.id');
        if ($M->where(array('id' => $id))->delete()) {
            $this->success('审计情况删除成功！');
        } else {
            $this->error('审计情况删除失败！');
        }
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

    /**
     * 增加审计情况
     */
    public function addSituation()
    {
        if (IS_POST) {
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Test")->addSituation((int)$_GET['id']));
        } else {
            $this->assign('id', (int)$_GET['id']);
            $this->display('addSituation');
        }
    }


    private function getSelectOption($info, $fieldname, $condition)
    {
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