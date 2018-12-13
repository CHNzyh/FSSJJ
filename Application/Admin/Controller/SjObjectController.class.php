<?php

namespace Admin\Controller;

use Org\Util\ArrayList;
use Think\Controller;

class SjObjectController extends CommonController
{

    public function index()
    {
        $data = D('SjObject')->searchSjobject();

//        $where = array('a.id>0');
        $keys = $data['keys'];
        if (session('my_info.position') == 3)
            $keys['user'] = session('my_info.aid');
//        if(!empty($keys)){
//            $where = ($keys['keyword']!='')?array_merge(array('a.'.$keys[field]=>array('LIKE','%'.$keys['keyword'].'%')),$where):$where;
//            $where = ($keys['department']>0)?array_merge(array('a.s_did='.$keys['department']),$where):$where;
//            $where = ($keys['user']>0)?array_merge(array('a.s_aid='.$keys['user']),$where):$where;
//            $where = ($keys['s_stime']!='')?array_merge(array('s_stime>='.strtotime($keys['s_stime'])),$where):$where;
//            $where = ($keys['s_etime']!='')?array_merge(array('s_etime<='.strtotime($keys['s_etime'])),$where):$where;
//        }

//        if(session('my_info.aid')>10 && session('my_info.position')>1)
//            $where['a.s_did'] = session('my_info.department');


        if (session('my_info.aid') == 10 || session('my_info.position') == 1) {//AID=10为超级管理员
            if ($keys['department'] > 0) {
                $user = $this->getAdminForSJObject(array('department=' . $keys['department']));
                $condition = array('pid' => $keys['department']);
            }

            $dp = D('Department')->getDepartmentarray($condition, '全部部门');

        } else {

            $dp = D('Department')->getDepartment();

            $user = $this->getAdminForSJObject(array('department=' . session('my_info.department')));
        }

        C('TOKEN_ON', false);
        $this->assign('did', session('my_info.department'));
        $this->assign('dp', $dp);
        $this->assign('user', $user);
        $this->assign('keys', $keys);
        $this->assign('list', $data['list']);
        $this->assign('page', $data['page']);

        $this->display('index');
    }

    public function search()
    {
        $this->index();
    }

    public function searchPastPlan()
    {

    }

    /**
     * 添加审计对象
     */
    public function add()
    {
        if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');

            echo json_encode(D("SjObject")->addSjObject());

        } else {
            $info['cstatus'] = 1;
            $info = $this->getSelectOption($info, 'SJZQ', 'pid=5');
            $info = $this->getSelectOption($info, 'BSJDWFL', 'pid=4');
            $info = $this->getSelectOption($info, 'YSLB', 'pid=6');
            $this->assign('info', $info);
            $this->assign('title', '添加审计对象');
            $this->display('addObject');
        }
    }

    /**
     * 验证法人代码是否重复
     */
    public function checkcode()//验证项目编号
    {
        $where['FRDWDM'] = I('post.pcode');
        if (M('Sjobject')->where($where)->count() != 0) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    /**
     * 重置审计计划
     * 实现原理为删除审计计划表和历年审计计划表中当年的部分
     * 然后重新走生成流程
     */
    public function resetPlan()
    {
        $current = M('current_plan');
        $past = M('past_plan');

        $current->where("id like '%%'")->delete();
        $past->where("sj_year = " . date("Y"))->delete();

        $this->buildSJPlan();
    }


    /**
     * 生成审计计划列表
     */
    public function buildSJPlan()
    {
        $info['cstatus'] = 1;
        $info = D('Config')->getConfigA('pid = 5');
        $data = D('SjObject')->buildSJPlan($info);

        $this->assign('list', $data['list']);
        $this->assign('pg', $data['pg']);
        $this->assign('keys', $data['keys']);
        $this->assign('page', $data['page']);
        $this->display('sjPlan');
    }

    /**
     * 生成审计计划列表
     */
    public function buildSJPlanByCondition()
    {
        $info['cstatus'] = 1;
        $info = D('Config')->getConfigA('pid = 5');
        $data = D('SjObject')->buildSJPlanByCondition($info);

        $this->assign('list', $data['list']);
        $this->assign('pg', $data['pg']);
        $this->assign('keys', $data['keys']);
        $this->assign('page', $data['page']);
        $this->display('sjPlan');
    }

    public function pastPlan(){
        $year =  M('past_plan')->query("select sj_year from on_past_plan group by sj_year");
        $i = 0;
        foreach ($year[0] as $v) {
            if($i==0){
                $currentYear = $v;
                $year['year'] .= '<option value="' . $v . '"' . "select" . '>' . $v . '</option>';
            }else{
                $year['year'] .= '<option value="' . $v . '"'  . '>' . $v . '</option>';
            }

            $i++;
        }
        $info['cstatus'] = 1;
        $info = D('Config')->getConfigA('pid = 5');
        $data = D('SjObject')->buildPastSJPlan($info,$currentYear);
        $this->assign('year',$year);
        $this->assign('list', $data['list']);
        $this->assign('pg', $data['pg']);
        $this->assign('keys', $data['keys']);
        $this->assign('page', $data['page']);
        $this->display('PastSjPlan');
    }


    /**
     * 查看审计对象   适用于在审计计划界面跳转过来的
     */
    public function watchSjObject()
    {
        if (IS_POST) {
            // $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("SjObject")->editSjObject());
        } else {
            $sjobject = M("Sjobject");
            $sql = "select * from on_sjobject as SJ left join on_sjobjectdetail as DETAIL  ON DETAIL.pid=SJ.id  where SJ.id =" . (int)$_GET['id'];
            $sjobjectArray = $sjobject->query($sql);
            $info = $sjobjectArray[0];
            $info = $this->getSelectOption($info, 'SJZQ', 'pid=5');
            $info = $this->getSelectOption($info, 'BSJDWFL', 'pid=4');
            $info = $this->getSelectOption($info, 'YSLB', 'pid=6');
            $this->assign('title', '添加审计对象');
            $this->assign("info", $info);

            $this->display('editForPlan');
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
            echo json_encode(D("SjObject")->editSjObject());
        } else {
            $sjobject = M("Sjobject");
            $sql = "select * from on_sjobject as SJ left join on_sjobjectdetail as DETAIL  ON DETAIL.pid=SJ.id  where SJ.id =" . (int)$_GET['id'];
            $sjobjectArray = $sjobject->query($sql);
            $info = $sjobjectArray[0];
            $info = $this->getSelectOption($info, 'SJZQ', 'pid=5');
            $info = $this->getSelectOption($info, 'BSJDWFL', 'pid=4');
            $info = $this->getSelectOption($info, 'YSLB', 'pid=6');
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
        if (IS_POST) {
            $keys = I('post.');

            $where = array($keys[field] => array('LIKE', '%' . $keys['keyword'] . '%'));

            $startTime = $keys['startTime'];
            $endTime = $keys['endTime'];
//            if (!empty($startTime)&&empty($endTime)) {
//                $where= array_merge(array('startTime' => array('EGT', '%' .strtotime($startTime). '%')),$where);
////                $where['startTime'] = '>=' . strtotime($startTime);
//            }else if(!empty($endTime)&&empty($startTime)){
//                $where= array_merge(array('endTime' => array('ELT', '%' .strtotime($endTime). '%')),$where);
//            }else{
//                $where= array_merge(array('endTime' => array('ELT', '%' .strtotime($endTime). '%')),$where);
//            }

            if (!empty($startTime)) {
                $where = array_merge(array('startTime' => array('LIKE', '%' . strtotime($startTime) . '%')), $where);
            }
            if (!empty($endTime)) {
                $where = array_merge(array('endTime' => array('LIKE', '%' . strtotime($endTime) . '%')), $where);
            }
        }
        $where['sjid'] = (int)$_GET['id'];
        $FRlist = $M->where($where)->select();
        foreach ($FRlist as $num => $v) {
            $v['startTime'] = date('Y/m/d', $v['startTime']);
            $v['endTime'] = date('Y/m/d', $v['endTime']);
            $FRlist[$num] = $v;
        }

        $this->assign('title', '编辑历任法人');
        $this->assign('FRlist', $FRlist);
        $this->assign('keys', $keys);
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
            echo json_encode(D("SjObject")->editCorporationDetail((int)$_GET['id']));
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
            echo json_encode(D("SjObject")->editSituationDetail((int)$_GET['id']));
        } else {
            $M = M('Situation');
            $detail = $M->where("id=" . (int)$_GET['id'])->find();
            $detail['startTime'] = date('Y/m/d', $detail['startTime']);
            $detail['endTime'] = date('Y/m/d', $detail['endTime']);
            $detail['url'] = '/' . C('SITUATION_FILEPATH') . '/' . date('Y-m-d', time()) . '/';
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
        $result = $M->where(array('id' => $id))->select();
        $file = trim($result['uploadUrl']);
        if ($file != '') {
            $url = C('UPLOAD_PATH') . $file;
            if (file_exists($url))
                @unlink($url);
        }


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
            echo json_encode(D("SjObject")->addCorporation((int)$_GET['id']));
        } else {
            $detail['startTime'] = date('Y/m/d');
            $detail['endTime'] = date('Y/m/d',strtotime('+1month'));
            $this->assign('info', $detail);
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
            echo json_encode(D("SjObject")->addSituation((int)$_GET['id']));
        } else {
            $info['startTime'] = date('Y/m/d');
            $info['endTime'] = date('Y/m/d',strtotime('+1month'));
            $this->assign('id', (int)$_GET['id']);
            $info['url'] = '/' . C('SITUATION_FILEPATH') . '/' . date('Y-m-d', time()) . '/';
            $this->assign('info', $info);
            $this->display('addSituation');
        }
    }


    private function getSelectOption($info, $fieldname, $condition)
    {
        $result = D('Config')->getConfigA($condition);
        $ori = $info[$fieldname];
        foreach ($result as $v) {
            $selected = $v['dname'] == $ori ? ' selected="selected"' : "";
            $info[$fieldname] .= '<option value="' . $v['dname'] . '"' . $selected . '>' . $v['dname'] . '</option>';
        }
        return $info;
    }

    /*
   加密获取下载文件
   */
    public function getfile($id, $url)
    {
        $result = D('Situation')->where('id=' . $id)->field('uploadUrl')->find();
        $FileAddress = 'upload' . $result['uploadUrl'];
        $DownloadName = str_replace('/', '', strrchr($FileAddress, '/'));
        if (file_exists($FileAddress) && $file = fopen($FileAddress, "r")) //首先要判断文件是否存在，如果文件跟本不存在的话，后边的代码也是白费。
        {
            Header("content-type:application/octet-stream"); //声明文件类型，这里是为了让客户端下载它，而不是打开它，所以声明为未知二进制文件。否则客户端会根据其文件类型在线打开它。
            Header("content-Length:" . filesize($FileAddress)); //声明文件的大小，告诉客户端这个文件的大小，否则客户端下载的时候看不到进度。
            Header("content-disposition:attachment;filename=" . $DownloadName); //声明文件名，这里就是告诉客户端它要下载的文件的名字，否则名字就会是你php文件的名字。
            echo fread($file, filesize($FileAddress)); //这里就是将加载的文件echo出来，因此这个php文件不能出现其他任何的文字，就是说这里若是出现了任何其他的输出的话都会输出到客户端下载的文件里。
            fclose($file); //最后关闭句柄。
        } else {
            echo '<script language="javascript">alert("无法下载");window.opener=null;window.close();</script>';
        }
    }

    public function getSsarchKV()
    {
    }

}

?>