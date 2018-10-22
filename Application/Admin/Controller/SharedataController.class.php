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
            echo json_encode(D("Sharedata")->add());
        }else{
            $dp = D('Department')->where('id='.session('my_info.department'))->find();
            $info['filepath']='/sharedata/'.$dp['dename'];
            $this->assign('info',$info);
            $this->assign('dp',$dp);
            $this->assign('title','添加共享文件');
            $this->display('edit');			
        }
    }
    /*
     * 编辑共享文件
     */
    public function edit($id){
        
    }
    /*
     * 查找共享文件
     */
    public function search(){
        $M = M('Sharedata');
        $keys = I('get.');
        $where = array('id>0');

        if(!empty($keys)){	        

                $where = ($keys['keyword']!='')?array_merge(array($keys[field]=>array('LIKE','%'.$keys['keyword'].'%')),$where):$where;
                $where = ($keys['department']>0)?array_merge(array('pdepaid='.$keys['department']),$where):$where;
                $where = ($keys['user']>0)?array_merge(array('_string'=>'pleader='.$keys['user'].' or pcrew like"%||'.$keys['user'].'||%"'),$where):$where;
                $where = ($keys['pbtime']!='')?array_merge(array('pbtime>='.strtotime($keys['pbtime'])),$where):$where;
                $where = ($keys['petime']!='')?array_merge(array('petime<='.strtotime($keys['petime'])),$where):$where;
        }

        if(session('my_info.aid')>10)
                $where['s_did'] = session('my_info.department');


        $count = $M->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE')); 
        $list=$M->where($where)->order('id desc')->limit($pConf['first'], $pConf['list'])->select();
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
    
}
