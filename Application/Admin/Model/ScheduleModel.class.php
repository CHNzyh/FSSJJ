<?php

/* 
 * 审计项目进度
 */
namespace Admin\Model;
use Think\Model;
class ScheduleModel extends Model{
    
    public $log;
    public $schedule;

    public function _initialize()
    {
        $this->log = D('Log');
        $this->schedule = M('Schedule');
    }
    public function addSchedule()
    {    
        $datas = I('post.');
   
        $datas['s_aid'] = session('my_info.aid');
        $datas['s_ip'] = get_client_ip();
        //unset($datas['pffname']);
        $datas['s_file_'.$datas['filenum'].'_url'] = $datas['s_url'];
        $datas['s_file_'.$datas['filenum'].'_time'] = time();
        unset($datas['filenum']);
        unset($datas['s_url']);

        if ($this->schedule->add($datas)) {
            $this->log->content = '添加审计项目';
            $this->log->addLog();
            return array('status' => 1, 'info' => '审计项目添加成功！', 'url' => u('Schedule/index'));
        } else {
            return array('status' => 0, 'info' => '添加失败，请重试！');
        }
    }

    public function editSchedule($ctl='edit')
    {
        $datas = I('post.');        
        $datas['s_file_'.$datas['filenum'].'_url'] = $datas['s_url'];
        $datas['s_file_'.$datas['filenum'].'_time'] = time();
        unset($datas['filenum']);
        unset($datas['s_url']); 
        if ($this->schedule->save($datas)) {
            switch ($ctl){
                case 'edit':
                    $logcontent = '修改审计项目';
                    break;
                case 'uploadfile':
                    $logcontent = '审计项目上传'.C('SCHEDULE_FILENAME')['file_'.I('get.filenum')];
                    break;
            }
            $this->log->content = '';
            $this->log->addLog();
            return array('status' => 1, 'info' => $logcontent.'内容成功！', 'url' => u('Schedule/index'));

        } else {
            return array('status' => 0, 'info' => '修改失败，请重试！');
        }
    }
    
    public function delSchedule($id){
        $result = $this->getSchedule($id);
       
       for($i=1;$i<7;$i++){
            $file = trim($result['s_file_'.$i.'_url']);
            if($file!=''){
                $url = C('UPLOAD_PATH').$file; 
                if(file_exists($url))
                    @unlink($url);                
            }
        }
        if ($this->schedule->where("id=" . (int) $_GET['id'])->delete()) {
            $this->log->content = '删除审计项目';
            $this->log->addLog();
            return true;
        } else {
            return false;
        }
    }
    
    public function getSchedule($id){
        $result = $this->schedule->where('id='.$id)->find();
        return $result;
    }
}
