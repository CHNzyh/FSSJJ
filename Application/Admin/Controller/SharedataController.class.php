<?php
/* 
 * 共享文件管理
 */

namespace Admin\Controller;
use Think\Controller;

class SharedataController extends CommonController{
    
    public function index(){
        $this->search();        
    }
    /*
     * 添加共享文件
     */
    public function add(){
        if(IS_POST){
            $this->checkToken();
             
            header('Content-Type:application/json; charset=utf-8');

            echo json_encode(D("Sharedata")->addShare());
        }else{
            
            $dp = D('Department')->getDepartmentname(session('my_info.department'));
            
            $info['url']='/'.C('SHARE_FILEPATH').'/'.$dp['dename'].'/'.date('Y-m-d',  time()).'/';
            $info['s_stime'] = time();
            $info['s_etime'] = time();
            $this->assign('info',$info);
            $this->assign('dp',$dp);
            $this->assign('title','添加共享文件');
            $this->display('edit');			
        }
    }
    /*
     * 编辑共享文件
     */
    public function editShare($id){
         if(IS_POST){
            $this->checkToken();
             
            header('Content-Type:application/json; charset=utf-8');

            echo json_encode(D("Sharedata")->editShare());
        }else{
            $info = D('Sharedata')->where('id='.$id)->find();
            $dp = D('Department')->getDepartmentname(session('my_info.department'));

           // $info['url']='/'.C('SHARE_FILEPATH').'/'.$dp['dename'].'/'.date('Y-m-d',  time()).'/';
            $this->assign('info',$info);
            $this->assign('dp',$dp);
            $this->assign('title','修改共享文件');
            $this->display('edit');
        }
    }
    public function delShare($id){
        $result = D('Sharedata')->delShare($id);
        
        if($result){
            $this->success("成功删除");
        }  else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }
    /*
     * 查找共享文件
     */
    public function search(){
        $M = M('Sharedata');
        $keys = I('get.');
        $where = array('a.id>0');

        if(!empty($keys)){	        

                $where = ($keys['keyword']!='')?array_merge(array($keys[field]=>array('LIKE','%'.$keys['keyword'].'%')),$where):$where;
                $where = ($keys['department']>0)?array_merge(array('pdepaid='.$keys['department']),$where):$where;
                $where = ($keys['user']>0)?array_merge(array('_string'=>'pleader='.$keys['user'].' or pcrew like"%||'.$keys['user'].'||%"'),$where):$where;
                $where = ($keys['pbtime']!='')?array_merge(array('pbtime>='.strtotime($keys['pbtime'])),$where):$where;
                $where = ($keys['petime']!='')?array_merge(array('petime<='.strtotime($keys['petime'])),$where):$where;
        }

        if(session('my_info.aid')>10)
                $where['s_did'] = session('my_info.department');


        $count = $M->alias('a')->join('__DEPARTMENT__ b ON a.s_did= b.id')->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE')); 
        $list=$M->alias('a')->join('__DEPARTMENT__ b ON a.s_did= b.id')->join('__ADMIN__ c ON a.s_uid= c.aid')->field('a.*,b.dname,c.nickname')->where($where)->order('a.id desc')->limit($pConf['first'], $pConf['list'])->select();
        $this->list=$list;

        
        $keys['count']=$count;
        $this->keys=$keys;
        $this->page = $pConf['show'];

        C('TOKEN_ON',false);

        if(session('my_info.aid')==10){//AID=10为超级管理员
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
     * 添加下载日志
     */
    public function addlog(){
        
    }
    /*
     * 显示下载日志
     */
    public function showlog(){
        
    }
    /*
     * 删除图片
     */
    public function del_pic() {
        $imgUrl = I('post.imgUrl');
        $imgDelUrl = C('UPLOAD_PATH').I('post.imgUrl'); 
        $id = I('post.id');
        
        $M = M('Sharedata');
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
    
}
