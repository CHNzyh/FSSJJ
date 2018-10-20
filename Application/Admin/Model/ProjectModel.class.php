<?php

namespace Admin\Model;

use Think\Model;

class ProjectModel extends Model
{

    public $log;
    public $project;

    public function _initialize()
    {
        $this->log = D('Log');
        $this->project = M('Project');
    }


    public function add()
    {
        $datas['pname'] = I('post.pname');

        $datas['pcode'] = I('post.pcode');
        $datas['pbtime'] = strtotime(I('post.pbtime'));
        $datas['petime'] = strtotime(I('post.petime'));
        $datas['pleader'] = I('post.pleader');
        foreach (I('post.pcrew') as $value => $key) {
            $datas['pcrew'] .= '||' . $key . '||,';
        }
        $datas['pcrew'] = substr($datas['pcrew'], 0, -1);
        $datas['pcompany'] = I('post.pcompany');
        $datas['pcompany_id'] = I('post.pcompany_id');
        $datas['pcontent'] = I('post.pcontent');
        $datas['pstatus'] = I('post.pstatus');
        $datas['pdepaid'] = I('post.pdepaid');
        if (0 < $this->project->where('pcode ="' . $datas['pcode'] . '"')->count()) {
            return array('status' => 0, 'info' => '已经存在相同的审计项目!');
        }
        $datas['ppath'] = I('post.dename') . '/' . $datas['pcode'];

        $path = C('UPLOAD_PATH') . '/' . $datas['ppath'];
        mkdir(iconv("UTF-8", "GBK", $path), 0777, true);
        $datas['ptime'] = time();
        $datas['po_user'] = $_SESSION['my_info']['aid'];
        $datas['pip'] = get_client_ip();
        if ($this->project->add($datas)) {
            $this->log->content = '添加审计项目';
            $this->log->addLog();
            return array('status' => 1, 'info' => '审计项目添加成功！', 'url' => u('Project/index'));

        } else {
            return array('status' => 0, 'info' => '添加失败，请重试！');
        }
    }

    public function edit()
    {

        $datas['pname'] = I('post.pname');

        $datas['pcode'] = I('post.pcode');
        $datas['pbtime'] = strtotime(I('post.pbtime'));
        $datas['petime'] = strtotime(I('post.petime'));
        $datas['pleader'] = I('post.pleader');
        foreach (I('post.pcrew') as $value => $key) {
            $datas['pcrew'] .= '||' . $key . '||,';
        }
        $datas['pcrew'] = substr($datas['pcrew'], 0, -1);
        $datas['pcompany'] = I('post.pcompany');
        $datas['pcompany_id'] = I('post.pcompany_id');
        $datas['pcontent'] = I('post.pcontent');
        $datas['pstatus'] = I('post.pstatus');
        $datas['pdepaid'] = I('post.pdepaid');
        $datas['id'] = I('post.id');
        if (0 < $this->project->where('pcode ="' . $datas['pcode'] . '" and id<>' . $datas['id'])->count()) {
            return array('status' => 0, 'info' => '已经存在相同的审计项目!');
        }
        $datas['ppath'] = I('post.dename') . '/' . $datas['pcode'];

        $path = C('UPLOAD_PATH') . '/' . $datas['ppath'];
        if (!is_dir($path))
            mkdir(iconv("UTF-8", "GBK", $path), 0777, true);
        $datas['pupdate_time'] = time();
        $datas['po_user'] = $_SESSION['my_info']['aid'];
        $datas['pip'] = get_client_ip();
        if ($this->project->save($datas)) {
            $this->log->content = '修改审计项目';
            $this->log->addLog();
            return array('status' => 1, 'info' => '审计项目修改成功！', 'url' => u('Project/index'));

        } else {
            return array('status' => 0, 'info' => '修改失败，请重试！');
        }


    }

    public function opStatus()
    {

        $M = M('Project');
        $datas["id"] = (int)$_GET["id"];
        //$datas["id"] = 1;
        $datas["pstatus"] = ($_GET["status"] == 1 ? 0 : 1);
        $datas['pupdate_time'] = time();

        if ($M->save($datas)) {
            $this->log->content = '修改项目状态';
            $this->log->addLog();
            return array(
                "status" => 1,
                "info" => "处理成功",
                "data" => array("status" => $datas["pstatus"], "txt" => $datas["pstatus"] == 1 ? "禁用" : "启动")
            );
        } else {

            return array("status" => 0, "info" => "处理失败");
        }
    }

    public function getProject($condition, $only = false)
    {
        if ($only) {
            $result = M('Project')->where($condition)->find();
        } else {
            $result = M('Project')->where($condition)->select();
        }

        return $result;
    }

    public function addFile()
    {
        $datas = I('post.');
        $datas['pftime'] = time();
        $datas['pfbtime'] = strtotime(I('post.pfbtime'));
        $datas['pfetime'] = strtotime(I('post.pfetime'));
        $datas['pf_user'] = $_SESSION['my_info']['aid'];
        $datas['pf_ip'] = get_client_ip();
        unset($datas['filepath']);

        if (M('projectfile')->add($datas)) {
            $this->log->content = '添加审计项目文件内容';
            $this->log->addLog();
            return array('status' => 1, 'info' => '审计项目文件内容添加成功！', 'url' => u('Project/fileList?id=' . $datas['pid']));

        } else {
            return array('status' => 0, 'info' => '添加失败，请重试！');
        }

    }

    public function editFile()
    {

        $datas = I('post.');
        $datas['pfbtime'] = strtotime(I('post.pfbtime'));
        $datas['pfetime'] = strtotime(I('post.pfetime'));
        $datas['pfupdatetime'] = time();
        $datas['pf_user'] = $_SESSION['my_info']['aid'];
        $datas['pf_ip'] = get_client_ip();
        unset($datas['filepath']);


        if (M('projectfile')->save($datas)) {
            $this->log->content = '修改审计项目文件内容';
            $this->log->addLog();
            return array('status' => 1, 'info' => '修改项目文件内容添加成功！', 'url' => u('Project/fileList?id=' . $datas['pid']));

        } else {
            return array('status' => 0, 'info' => '修改失败，请重试！');
        }

    }

    public function opProjectFileStatus()
    {

        $M = M('Projectfile');
        $datas["id"] = (int)$_GET["id"];
        $datas["pfstatus"] = ($_GET["status"] == 1 ? 0 : 1);

        if ($M->save($datas)) {
            $this->log->content = '修改项目文件状态';
            $this->log->addLog();
            return array(
                "status" => 1,
                "info" => "处理成功",
                "data" => array("status" => $datas["pstatus"], "txt" => $datas["pstatus"] == 1 ? "禁用" : "启动")
            );
        } else {
            return array("status" => 0, "info" => "处理失败");
        }
    }
}

?>