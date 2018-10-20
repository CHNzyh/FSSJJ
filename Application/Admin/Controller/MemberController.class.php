<?php

namespace Admin\Controller;
use Think\Controller;
class MemberController extends CommonController {

    public function index() {
        $M = M("Member");
        $count = $M->count();
        $pConf = page($count,C('PAGE_SIZE')); 
        $list=$M->order('uid desc')->limit($pConf['first'], $pConf['list'])->select();
        $this->page = $pConf['show'];
        $this->list=$list;
        $this->display();
    }
    public function search(){
        $M = M("Member");
        $keys = I('get.');
        $where = array($keys[field]=>array('LIKE','%'.$keys['keyword'].'%'));
        $count = $M->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE')); 
        $list=$M->where($where)->order('uid desc')->limit($pConf['first'], $pConf['list'])->select();
        $this->list=$list;
        $keys['count']=$count;
        $this->keys=$keys;
        $this->page = $pConf['show'];
        C('TOKEN_ON',false);
        $this->display('index');
    }
    
    public function add(){
        if(IS_POST){
            echo json_encode(D('Member')->addMember());
        }else{
            $this->display();
        }
    }
    
    public function wallet(){
        if(IS_POST){
            $info = I('post.info');
            if($info['item'] == 'pledge'){
                echo json_encode(D('Member')->recharge_pledge($info));
            }elseif ($info['item'] == 'limsum') {
                echo json_encode(D('Member')->recharge_limsum($info));
            }else{
                return '不存在的充值项';
            }
            
            
        }else{
            $uid=I('get.uid');
            $m_member=M('Member');
            $map['uid']=$uid;
            $info=$m_member->where($map)->find();
            
            $available = $info['wallet_pledge'] - $info['wallet_pledge_freeze'];
            $info['available'] = $available>=0 ? $available : 0;
            
            $available_limsum = $info['wallet_limsum'] - $info['wallet_limsum_freeze'];
            $info['available_limsum'] = $available_limsum>=0 ? $available_limsum : 0;
            $this->info = $info;
            $this->display();
        }
    }
    
    public function feedback(){
        if(IS_POST){
            echo json_encode(D('Member')->addFeedback());
        }else{
            $M = M('feedback');
            $this->list = $M->order('count desc')->select();

            $this->display();
        }
    }
    
    public function set_member() {
        if (IS_POST) {
            
            $this->checkToken();
            $config = APP_PATH . "Common/Conf/SetMember.php";
            $config = file_exists($config) ? include "$config" : array();
            $config = is_array($config) ? $config : array();
            $data['Member'] = I('post.');
            if (set_config("SetMember", $data, APP_PATH . "Common/Conf/")) {
                delDirAndFile(WEB_CACHE_PATH . "Cache/Admin/");
                echo json_encode(array('status' => 1, 'info' => '设置成功','url'=>__ACTION__));
            } else {
                echo json_encode(array('status' => 0, 'info' => '设置失败，请检查'));
            }
        } else {
            $this->mbcof=C('Member');

            $this->display(); 
        }
    }
    
    public function edit(){
        if(IS_POST){
            echo json_encode(D('Member')->addMember());
        }else{
            $uid=I('get.uid');
            $m_member=M('Member');
            $map['uid']=$uid;
            $info=$m_member->where($map)->find();
            $this->info = $info;
            $this->display('add');
        }
    }
    
    public function del(){
        $uid=I('get.uid');
        if(!$uid){return false;}
        $m_member=M('Member');
        $map['uid']=$uid;
        if($m_member->where($map)->delete()){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }


}?>
