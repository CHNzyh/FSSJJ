<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Model;
use Think\Model;
class SharedataModel extends Model{
    
    public $log;
    public $share;
    public $sharelog;

    public function _initialize()
    {
        $this->log = D('Log');
        $this->share = M('Sharedata');
        $this->sharelog = D('Sharedata');
    }
    public function add()
    {
    
        $datas = I('post.');
        $datas['s_time'] = time();
        $datas['s_url'] = I('post.pffname');       
        $datas['s_uid'] = session('my_info.aid');
        $datas['s_ip'] = get_client_ip();
        unset($datas['pffname']);

        if ($this->share->add($datas)) {
            $this->log->content = '添加共享文件';
            $this->log->addLog();
            return array('status' => 1, 'info' => '共享文件添加成功！', 'url' => u('Sharedata/index'));
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
}
