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
        $this->sharelog = D('Sharedatalog');
    }
    public function addShare()
    {    
        $datas = I('post.');
        
        $datas['s_time'] = time();
        //$datas['s_url'] = I('post.pffname');       
        $datas['s_uid'] = session('my_info.aid');
        $datas['s_ip'] = get_client_ip();
        $datas['s_stime'] = strtotime($datas['s_stime']);
        $datas['s_etime'] = strtotime($datas['s_etime']);
        //unset($datas['pffname']);

        if ($this->share->add($datas)) {
            $this->log->content = '添加共享文件';
            $this->log->addLog();
            return array('status' => 1, 'info' => '共享文件添加成功！', 'url' => u('Sharedata/index'));
        } else {
            return array('status' => 0, 'info' => '添加失败，请重试！');
        }

    }

    public function editShare()
    {

        $datas = I('post.');
        $datas['s_time'] = time();
        //$datas['s_url'] = I('post.pffname');       
        $datas['s_uid'] = session('my_info.aid');
        $datas['s_ip'] = get_client_ip();
        $datas['s_stime'] = strtotime($datas['s_stime']);
        $datas['s_etime'] = strtotime($datas['s_etime']);


        if ($this->share->save($datas)) {
            $this->log->content = '修改共享文件';
            $this->log->addLog();
            return array('status' => 1, 'info' => '修改共享文件内容添加成功！', 'url' => u('Sharedata/index'));

        } else {
            return array('status' => 0, 'info' => '修改失败，请重试！');
        }
    }
    
    public function delShare($id){
        $result = $this->getShare($id);
       
       @unlink(C('UPLOAD_PATH').$result['s_url']);
        if ($this->share->where("id=" . (int) $_GET['id'])->delete()) {
            $this->log->content = '删除共享文件';
            $this->log->addLog();
            return true;
        } else {
            return false;
        }
    }
    
    public function getShare($id){
        $result = $this->share->where('id='.$id)->find();
        return $result;
    }
}
