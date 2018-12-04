<?php
/* 
 * 任务管理
 */

namespace Admin\Controller;
use Think\Controller;

class TaskController extends CommonController{
    
    /*
     * 进行中的任务列表
     */
    public function index(){
        $this->search();
        
    }
    /*
     * 已完成任务列表
     */
    public function complete(){
        $this->search('complete');
    }
    /*
     * 查看任务
     */
    
    public function viewTask($id) {
        $info = D('Task')->getTask($id);
        
        $where = array('a.t_id'=>$id);
         if(session('my_info.aid')>10 && session('my_info.position')>1){
          $where = array_merge(array('a.t_did ='.session('my_info.department')),$where);
        }
        $result = D('Taskcontent')->alias('a')->join('__DEPARTMENT__ b ON a.t_did= b.id')->join('__ADMIN__ c ON a.t_uid= c.aid')->field('a.*,b.dname,c.nickname')->where($where)->select();
        
        $this->assign('info',$info);
        $this->assign('result',$result);
        $this->display('view');
        
    }
    public function addTask(){
        if(IS_POST){
            $this->checkToken();             
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Task")->addTask());            
        }else{            
            //$dp = D('Department')->getDepartmentname(session('my_info.department'));
            $dp = D('Department')->where('dstatus=1')->field('id,dname,dename')->order('dsort desc')->select();
            
             foreach($dp as $v=>$k){
                $dp[$v][ck]=1;                               
            }
            
            $info['t_url']='/'.C('TASK_FILEPATH').'/'.date('Y-m-d',  time()).'/';
            $info['s_stime'] = time();
            $info['s_etime'] = strtotime("+1 month");
           
            $this->assign('info',$info);
            $this->assign('dp',$dp);
            $this->assign('title','添加综合任务');
            $this->display('edit');			
        }
    }
    
    
     /*
     * 编辑综合任务
     */
    public function editTask($id){
         if(IS_POST){
            $this->checkToken();
             
            header('Content-Type:application/json; charset=utf-8');

            echo json_encode(D("Task")->editTask());
            //D("Task")->editTask();
        }else{
            $info = D('Task')->where('id='.$id)->find();
            $dp = D('Department')->where('dstatus=1')->field('id,dname,dename')->order('dsort desc')->select();
            foreach($dp as $v=>$k){
                $dp[$v][ck]=0;
               if(strpos($info['t_dname'], '|'.$k['id'].'|')>-1){
                   $dp[$v][ck]=1;
               }                
            }
           
           // $info['url']='/'.C('SHARE_FILEPATH').'/'.$dp['dename'].'/'.date('Y-m-d',  time()).'/';
            $this->assign('info',$info);
            $this->assign('dp',$dp);
            $this->assign('title','修改综合任务');
            $this->display('edit');
        }
    }
    public function delTask($id){
       
        $result = D('Task')->delTask($id);
        
        
        if($result){
            $this->success("成功删除");
        }  else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }
    
    public function  uploadTask($id){
        if(IS_POST){
            $this->checkToken();             
            header('Content-Type:application/json; charset=utf-8');//
            echo json_encode(D("Taskcontent")->editTaskcontent());          
        }else{
            $info = D('Task')->where('id='.$id)->find();
            $taskinfo = D('Taskcontent')->gettaskcontent($id);
            $info['t_id']=$info['id'];
            $info['id']=($taskinfo)?$taskinfo['id']:0;
            $info['t_furl']=$taskinfo['t_furl'];
            $dp = D('Department')->getDepartmentname(session('my_info.department'));
            $this->assign('info',$info);
            $this->assign('dp',$dp);
            $this->assign('title','上传综合任务文件');
            $this->display('uploadTask');
        }
    }


    /*
     * 查找综合任务
     */
    public function search($active='index'){
       
        $M = M('Task');
        $keys = I('get.');
        $where = array('a.id>0');
        if(session('my_info.position')==3)
            $keys['user'] = session('my_info.aid');
        if(!empty($keys)){	        

                $where = ($keys['keyword']!='')?array_merge(array('a.'.$keys[field]=>array('LIKE','%'.$keys['keyword'].'%')),$where):$where;
                $where = ($keys['department']>0)?array_merge(array('a.t_dname like \'%|'.$keys['department'].'|%\''),$where):$where;       
//                $where = ($keys['t_stime']!='')?array_merge(array('a.t_stime>='.strtotime($keys['t_stime'])),$where):$where;
//                $where = ($keys['t_etime']!='')?array_merge(array('a.t_etime<='.strtotime($keys['t_etime'])),$where):$where;
        }
       
        if(session('my_info.aid')>10 && session('my_info.position')>1){
          $where = array_merge(array('a.t_dname like \'%|'.session('my_info.department').'|%\''),$where);
        }
        
        if($active=='index'){
            $where = array_merge(array('a.t_etime>='.time()),$where);
            $where = array_merge(array('a.t_dename not like \'%|'.session('my_info.department').'|%\''),$where);
            $where = array_merge(array('a.t_status=0'),$where);
            $tpl='index';
        }  elseif ($active=='complete') {
            //$where = array_merge(array('a.t_etime<'.time()),$where);
            $tpl='complete';
            $where['_string'] = '(a.t_dename like \'%|'.session('my_info.department').'|%\') or (a.t_status=1)  OR ( a.t_etime<'.time().') ';
            //$where = array_merge(array('a.t_dename like \'%|'.session('my_info.department').'|%\''),$where);
            //$where = array_merge(array('a.t_status=1'),$where);
            
        }

        
        $count = $M->alias('a')->where($where)->count();
        
        $pConf = page($count,C('PAGE_SIZE')); 
        $list=$M->alias('a')->where($where)->order('a.id desc')->limit($pConf['first'], $pConf['list'])->select();
        $this->list=$list;
                
        $keys['count']=$count;
        $this->keys=$keys;
        $this->page = $pConf['show'];

        C('TOKEN_ON',false);

        if(session('my_info.aid')==10||session('my_info.position')==1){//AID=10为超级管理员
                if($keys['department']>0){
                        $user = $this->getAdmin(array('department='.$keys['department']));
                        $condition = array('pid'=>$keys['department']);
                }
                
                $dp = D('Department')->getDepartmentarray($condition,'全部部门');
                
        }else{
            
                $dp = D('Department')->getDepartment();

                $user = $this->getAdmin(array('department='.session('my_info.department')));
        }


        $this->list=$list;
        $this->assign('did',session('my_info.department'));
        $this->assign('dp',$dp);
        $this->assign('user',$user);
        $this->assign('keys',$keys);
        $this->display($tpl);        
    }
     /*
     * 删除文件
     */
    public function del_file() {
        $imgUrl = I('post.imgUrl');
        $imgDelUrl = C('UPLOAD_PATH').I('post.imgUrl'); 
        $id = I('post.id');
        
       
        if($id){
            if(D('Taskcontent')->delTaskcontent($id)){
                if(@unlink($imgDelUrl)){
                    echo json_encode(array(
                    'status' => 1,
                    'msg' => '已从数据库删除成功!'
                    ));
                }else{
                    echo json_encode(array(
                    'status' => 0,
                    'msg' => '删除失败，刷新页面重试!'
                    ));
                }
            }
        }else{
            if(@unlink($imgDelUrl)){
                echo json_encode(array(
                'status' => 1,
                'msg' => '已从磁盘删除成功!'
                ));
            }else{
                echo json_encode(array(
                'status' => 0,
                'msg' => '磁盘文件删除失败，请检查文件是否存在或磁盘权限!'
                ));
            }
            
        }
    }
    
     /*
    加密获取下载文件
    */
    public function getfile($id,$url)
    {		

            if($url==md5(session('my_info.aid').date("Y-m-d",time()).$id)){
                $result = D('Taskcontent')->alias('a')->join('__DEPARTMENT__ b ON a.t_did= b.id')->where('a.id='.$id)->field('a.t_furl,a.t_id,b.dname')->find();
                $info = D('Task')->getTask($result['t_id']);
                $FileAddress='upload'.$result['t_furl'];

                //$DownloadName=str_replace('/','',strrchr($FileAddress,'/'));
                $DownloadName=$info['t_name'].'-'.$result['dname'].'-'.strrchr($FileAddress,'.');
                
                if(file_exists($FileAddress) && $file=fopen($FileAddress,"r")) //首先要判断文件是否存在，如果文件跟本不存在的话，后边的代码也是白费。
                {                    
                    Header("content-type:application/octet-stream"); //声明文件类型，这里是为了让客户端下载它，而不是打开它，所以声明为未知二进制文件。否则客户端会根据其文件类型在线打开它。
                    Header("content-Length:".filesize($FileAddress)); //声明文件的大小，告诉客户端这个文件的大小，否则客户端下载的时候看不到进度。
                    Header("content-disposition:attachment;filename=".$DownloadName); //声明文件名，这里就是告诉客户端它要下载的文件的名字，否则名字就会是你php文件的名字。
                    echo fread($file,filesize($FileAddress)); //这里就是将加载的文件echo出来，因此这个php文件不能出现其他任何的文字，就是说这里若是出现了任何其他的输出的话都会输出到客户端下载的文件里。
                    fclose($file); //最后关闭句柄。
                    $log = D('log');
                    $log->content='下载综合任务文件：'.$info['t_name'].'-'.$result['dname'].'文件';
                    $log->addLog();
                }else{
                    echo '<script language="javascript">alert("无法下载");window.opener=null;window.close();</script>';
                }                
            }else{
                    echo '<script language="javascript">alert("无法下载");window.opener=null;window.close();</script>';
            }
    }
}