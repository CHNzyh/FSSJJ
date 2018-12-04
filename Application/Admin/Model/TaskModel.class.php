<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Model;
use Think\Model;
class TaskModel extends Model{
    
    public $log;
    public $task;   

    public function _initialize()
    {
        $this->log = D('Log');
        $this->task = M('Task');
        
    }
    public function addTask()
    {    
        $datas = I('post.');       
        //$datas['t_url'] = I('post.pffname');       
        $datas['t_uid'] = session('my_info.aid');       
        $datas['t_stime'] = strtotime($datas['t_stime']);
        $datas['t_etime'] = strtotime($datas['t_etime']);
        //unset($datas['pffname']);
        $d='';
        $i=1;
        foreach($datas['t_dname'] as $key=>$value){
            $d=$d.'|'.$value.'|,';
            $i++;
        }
        $d = substr($d,0,strlen($d)-1);
        $datas['t_dname']=$d;
        $datas['t_dsum']=$i;
        $datas['t_time']=time();
        $datas['t_dename']= '';
        if ($this->task->add($datas)) {
            $this->log->content = '添加综合任务';
            $this->log->addLog();
            return array('status' => 1, 'info' => '综合任务添加成功！', 'url' => u('Task/index'));
        } else {
            return array('status' => 0, 'info' => '添加失败，请重试！');
        }
    }
    
     public function editTask()
    {
        
         $datas = I('post.');
         $info = D('Task')->where('id='.$datas['id'])->find();
         

         $datas['t_stime'] = strtotime($datas['t_stime']);
         $datas['t_etime'] = strtotime($datas['t_etime']);

         $d='';
         $i=0;
         foreach($datas['t_dname'] as $key=>$value){
             $d=$d.'|'.$value.'|,';
             $i++;
         }
         $d = substr($d,0,strlen($d)-1);
         $datas['t_dname']=$d;
        
         /*
          * 判断部门是否有更改
          * 如果有部门减少，则删除减少部门上传的文件。
          */
         if($info['t_dname']!=$datas['t_dname']){
             //$noid='';
             
             foreach (explode(',',$info['t_dname']) as $v=>$k){                 
                //$noid.=(strpos($datas['t_dname'],$k)>-1)?'':str_replace('|','',$k).',';                  
                 if(strpos($datas['t_dname'],$k)>-1){                     
                 }else{
                     $info['t_dename']=  str_replace($k, '', $info['t_dename']);
                     $this->delTaskContent($datas['id'],str_replace('|','',$k));
                 }
             }
             $datas['t_dename']=$info['t_dename'];
         }
         //$noid = substr($noid,0,strlen($noid)-1);
        

         $datas['t_dsum']=$i;
         $datas['t_utime']=time();

         //unset($datas['__jvfnet__']);
         if ($this->task->save($datas)) {
             $this->log->content = '修改综合任务';
             $this->log->addLog();
             return array('status' => 1, 'info' => '修改综合任务内容成功！', 'url' => u('Task/index'));
         } else {
             return array('status' => 0, 'info' => '修改失败，请重试！');
         }         
    }
    
    public function delTask($id) {
        $info = $this->getTask($id);
        if($info){
            $result = D('Taskcontent')->where(array('t_id'=>$id))->select();
            foreach ($result as $v=>$k){
                @unlink(C('UPLOAD_PATH').$k['t_furl']);
            }
            D('Taskcontent')->where(array('t_id'=>$id))->delete();
            $this->task->where(array('id'=>$id))->delete();
            $this->log->content = '删除综合任务部门文件。';
            $this->log->addLog();
            return true;
        }else{
            return false;
        }
        
    }
    
    public function delTaskContent($id,$did){        
       $result = $this->getTaskContent($id,$did);
       $this->modifyTask($id, 'reduce',$did);//减少任务表中的部门和状态
       @unlink(C('UPLOAD_PATH').$result['t_furl']);
        if (D('Taskcontent')->where(array('t_id'=>$id,'t_did'=>$did))->delete()) {            
            $this->log->content = '删除综合任务部门文件。';
            $this->log->addLog();
            return true;
        } else {
            return false;
        }
    }
    
    public function getTaskContent($id,$did){
        $result = D('Taskcontent')->where(array('t_id'=>$id,'t_did'=>$did))->find();
        return $result;
    }
    /*
     * 获取综合任务内容
     */
    public function getTask($id){
        return $this->task->where(array('id'=>$id))->find();        
    }
    /*
     * 修改综合任务完成状态
     */
    public function modifyTask($id,$active,$did){
        if($active=='increase'){//增加完成部门
            $info = $this->getTask($id);
            if(strpos($info['t_dename'],'|'.$did.'|')!==FALSE){
                
            }else{
                $info['t_dename'].='|'.$did.'|,';
                $info['t_dename'] = substr($info['t_dename'],0,strlen($info['t_dename'])-1);
                $info['t_desum']++;
                $info['t_status']=($info['t_dsum']==$info['t_desum'])?1:0;
                $this->task->save($info);
            }
        }  else {//减少完成部门
            $info = $this->getTask($id);
            
            if(strpos($info['t_dename'],'|'.$did.'|')!==FALSE){
                $info['t_dename']= str_replace('|'.$did.'|,','',$info['t_dename']);                
                $info['t_desum']--;
                $info['t_desum'] = ($info['t_desum']<0)?0:$info['t_desum'];
                $info['t_status']=0;
                $this->task->save($info);
            }
        }
    }
}