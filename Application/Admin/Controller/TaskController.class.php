<?php
/* 
 * 任务管理
 */

namespace Admin\Controller;
use Think\Controller;

class TaskController extends CommonController{
    
    public function index(){
        $this->search();
        
    }
    
    public function addTask(){
        if(IS_POST){
//            $this->checkToken();
//             
//            header('Content-Type:application/json; charset=utf-8');
//
//            echo json_encode(D("Task")->addTask());

            D("Task")->addTask();
            
            
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
//            $this->checkToken();
//             
//            header('Content-Type:application/json; charset=utf-8');
//
//            echo json_encode(D("Task")->editTask());
            D("Taskcontent")->editTaskcontent();
           
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
    public function search(){
       
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
        $where = array_merge(array('a.t_etime>='.time()),$where);
        if(session('my_info.aid')>10 && session('my_info.position')>1){
          $where = array_merge(array('a.t_dname like \'%|'.session('my_info.department').'|%\''),$where);
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
        $this->display('index');        
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
}