<?php

/* 
 *进度管理 
 * 
 */

namespace Admin\Controller;
use Think\Controller;

class ScheduleController extends CommonController{

    /*
     * 显示进度列表
     */
    public function index(){
        
        $this->search();
        
    }
    
    /*
     * 添加进度
     */
    public function addSchedule(){
        if(IS_POST){
            $this->checkToken();             
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Schedule")->addSchedule());
        }else{            
            $dp = D('Department')->getDepartmentname(session('my_info.department'));            
            $info['s_catalog']='/'.C('SCHEDULE_FILEPATH').'/'.$dp['dename'].'/'.date('Y-m-d',  time()).'/';
            $info['filenum']=1;
            $this->assign('info',$info);
            $this->assign('dp',$dp);
            $this->assign('title','添加审计项目');
            $this->display('edit');			
        }
    }
    /*
     * 修改进度
     */
    public function editSchedule($id){
        if(IS_POST){
            $this->checkToken();
             
            header('Content-Type:application/json; charset=utf-8');

            echo json_encode(D("Schedule")->editShare());
        }else{
            $info = D('Schedule')->where('id='.$id)->find();
            $dp = D('Department')->getDepartmentname(session('my_info.department'));
            
           // $info['url']='/'.C('SHARE_FILEPATH').'/'.$dp['dename'].'/'.date('Y-m-d',  time()).'/';
            $this->assign('info',$info);
            $this->assign('dp',$dp);
            $this->assign('title','编辑审计项目');
            $this->display('edit');
        }
    }
    
    /*
     * 节点文件上传
     */
    public function uploadfile($id,$filenum){
        if(IS_POST){
            $this->checkToken();
             
            header('Content-Type:application/json; charset=utf-8');

            echo json_encode(D("Schedule")->editSchedule('uploadfile'));
           
        }else{
            $info = D('Schedule')->where('id='.$id)->find();
            $dp = D('Department')->getDepartmentname(session('my_info.department'));
            $info['filenumname']=(C('SCHEDULE_FILENAME')['file_'.I('get.filenum')]);
            $info['filenum'] = I('get.filenum');
           // $info['url']='/'.C('SHARE_FILEPATH').'/'.$dp['dename'].'/'.date('Y-m-d',  time()).'/';
            $this->assign('info',$info);
            $this->assign('dp',$dp);
            $this->assign('title','编辑审计项目');
            $this->display();
        }
        
    }
    /*
     * 搜索
     */
    
    public function search(){
        
        
        $M = M('Schedule');
        $keys = I('get.');
        $where = array('a.id>0');
        if(session('my_info.position')==3)
            $keys['user'] = session('my_info.aid');
        if(!empty($keys)){
                $where = ($keys['keyword']!='')?array_merge(array('a.'.$keys[field]=>array('LIKE','%'.$keys['keyword'].'%')),$where):$where;
                $where = ($keys['department']>0)?array_merge(array('a.s_did='.$keys['department']),$where):$where;
                $where = ($keys['user']>0)?array_merge(array('a.s_aid='.$keys['user']),$where):$where;
                $where = ($keys['s_stime']!='')?array_merge(array('s_stime>='.strtotime($keys['s_stime'])),$where):$where;
                $where = ($keys['s_etime']!='')?array_merge(array('s_etime<='.strtotime($keys['s_etime'])),$where):$where;
        }

        if(session('my_info.aid')>10 && session('my_info.position')>1)
          $where['a.s_did'] = session('my_info.department');
        
            
        $count = $M->alias('a')->join('__DEPARTMENT__ b ON a.s_did= b.id')->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE')); 
        $list=$M->alias('a')->join('__DEPARTMENT__ b ON a.s_did= b.id')->join('__ADMIN__ c ON a.s_aid= c.aid')->field('a.*,b.dname,c.nickname')->where($where)->order('a.id desc')->limit($pConf['first'], $pConf['list'])->select();
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
     * 删除图片
     */
    public function del_pic() {
        $imgUrl = I('post.imgUrl');
        $imgDelUrl = C('UPLOAD_PATH').I('post.imgUrl'); 
        $id = I('post.id');
        
        $M = M('Schedule');
        $data = array(
            'id' => $id,
            's_url' =>''
        );
        if($id){
            if($M->save($data)){
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
     *  删除审计项目
     */
    public function delSchedule($id){
         $result = D('')->delSchedule($id);
        
        if($result){
            $this->success("成功删除");
        }  else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }       
    }


    /*
    加密获取下载文件
    */
     public function getfile($id,$filenum,$url)
    {		

        if($url==md5(session('my_info.aid').date("Y-m-d",time()).$id.$filenum)){
            $result = D('Schedule')->where('id='.$id)->field('s_file_'.$filenum.'_url,s_name')->find();                
            $FileAddress='upload'.$result['s_file_'.$filenum.'_url'];

            $DownloadName=str_replace('/','',strrchr($FileAddress,'/'));               
            if(file_exists($FileAddress) && $file=fopen($FileAddress,"r")) //首先要判断文件是否存在，如果文件跟本不存在的话，后边的代码也是白费。
            {
                Header("content-type:application/octet-stream"); //声明文件类型，这里是为了让客户端下载它，而不是打开它，所以声明为未知二进制文件。否则客户端会根据其文件类型在线打开它。
                Header("content-Length:".filesize($FileAddress)); //声明文件的大小，告诉客户端这个文件的大小，否则客户端下载的时候看不到进度。
                Header("content-disposition:attachment;filename=".$DownloadName); //声明文件名，这里就是告诉客户端它要下载的文件的名字，否则名字就会是你php文件的名字。
                echo fread($file,filesize($FileAddress)); //这里就是将加载的文件echo出来，因此这个php文件不能出现其他任何的文字，就是说这里若是出现了任何其他的输出的话都会输出到客户端下载的文件里。
                fclose($file); //最后关闭句柄。
                $log = D('log');
                $log->content='下载共享文件：'.$result['s_name'];
                $log->addLog();
            }else{
                echo '<script language="javascript">alert("无法下载");window.opener=null;window.close();</script>';
            }                
        }else{
                echo '<script language="javascript">alert("无法下载");window.opener=null;window.close();</script>';
        }
    }
}