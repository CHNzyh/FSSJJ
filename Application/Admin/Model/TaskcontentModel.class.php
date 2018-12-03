<?php
namespace Admin\Model;
use Think\Model;
/*
 * 综合任务文件管理
 */
class TaskcontentModel extends Model{
    public $log;
    public $share;
    public $sharelog;

    public function _initialize()
    {
        $this->log = D('Log');
        $this->taskcontent = M('Taskcontent');
        $this->task = D('Task');
    }
    /*
     * 获取综合任务内容
     */
    public function gettaskcontent($id){
        return $this->taskcontent->where(array('t_id'=>$id,'t_did'=>session('my_info.department')))->find();        
    }
    /*
     * 添加综合任务文件
     */
    public function editTaskcontent()
    {    
        $datas = I('post.'); 
        
        $datas['t_furl'] = I('post.t_furl');       
        $datas['t_uid'] = session('my_info.aid');       
        $datas['t_did'] = session('my_info.department');        
        $datas['t_time']=time();

        unset($datas['__jvfnet__']);
       

        if($datas['id']==0){
            if ($this->taskcontent->add($datas)) {
                $this->task->modifyTask($datas['t_id'],'increase');//修改综合任务完成情况
                $this->log->content = '添加综合任务上传文件';
                $this->log->addLog();
                $this->task->modifyTask($datas['t_id'],'increase');//修改综合任务完成情况
                return array('status' => 1, 'info' => '添加综合任务上传文件成功！', 'url' => u('Task/index'));
            } else {
                return array('status' => 0, 'info' => '添加失败，请重试！');
            }
        }  else {
            if ($this->taskcontent->save($datas)) {
                 $this->log->content = '修改综合任务上传文件';
                 $this->log->addLog();
                 return array('status' => 1, 'info' => '修改综合任务上传文件成功！', 'url' => u('Task/index'));
             } else {
                 return array('status' => 0, 'info' => '修改失败，请重试！');
             }    
        }
    }
    /*
     * 删除综合任务文件同时删除数据记录
     */
    public function delTaskcontent($id) {
        if($this->taskcontent->where("id=" . $id)->delete()){
            $this->log->content = '删除综合任务上传文件';
            $this->log->addLog();
            return true;
        }
        return false;
    }
    
    public function delFile($id){        
         $data = array(
            'id' => $id,
            't_furl' =>''
         );
         return $this->taskcontent->save($data);        
    }
}
?>