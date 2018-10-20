<?php

namespace Admin\Controller;
use Think\Controller;
class AdvertisingController extends CommonController {

    
    public function index() {
        $Advertising = M('Advertising');
        $Position = M('Advertising_position');
        $field = array('id','name');
        $search = $Position->field($field)->select();

        $this->assign('search',$search);
        $count = $Advertising->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];
        $this->list = D('Advertising')->listAdvertising($pConf['first'],$pConf['list']);
        C('TOKEN_ON',false);
        $this->display('advertising');
    }
    
    public function add_advertising(){
        if (IS_POST) {
            $this->checkToken();
            echo json_encode(D("Advertising")->addAdvertising());
        } else {
            $this->posName = D("Advertising")->getPosName();
            $this->display();
        }
    }
    
    public function edit_advertising() {
        $M = M('Advertising');
        if (IS_POST) {
            $this->checkToken();
            echo json_encode(D("Advertising")->editAdvertising());
        } else {
             $info = $M->where("id=" . (int) $_GET['id'])->find();
            if ($info['id'] == '') {
                $this->error("不存在该记录");
            }
            $this->posName = D("Advertising")->getPosName();
            $this->assign("info", $info);
            $this->display('add_advertising');
        }
    }
    
    public function del_advertising() {
        if (M("Advertising")->where("id=" . (int) $_GET['id'])->delete()) {
            $this->success("成功删除");
            
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }
    
    public function order_advertising() {
        if (IS_POST) {
            $getInfo = I('post.');
            $M = M('Advertising');
            $where=array('id'=>$getInfo['odAid']);
            if($getInfo['odType'] == 'rising'){
                if($M->where($where)->setInc('sort')){
                    echo json_encode(array('status'=>'1','msg'=>'排序写入数据库成功'));
                }
            }elseif($getInfo['odType'] == 'drop'){
                if($M->where($where)->setDec('sort')){
                    echo json_encode(array('status'=>'1','msg'=>'排序写入数据库成功'));
                }
            }
        } else {
            echo json_encode(array('status'=>'0','msg'=>'什么情况'));
        }
    }
    
    public function search(){
            $keyW = I('get.');
            if($keyW['id'] != '') $where['pid'] = $keyW['id'];
            if($keyW['type'] != '') $where['type'] = $keyW['type'];
            
            $Position = M('Advertising_position');
            $field = array('id','name');
            $search = $Position->field($field)->select();
            $this->search = $search;
            
            $keyS = array('count' =>$count,'id'=>$keyW['id'],'type' => $keyW['type']);
            $this->keys = $keyS;

            
            $D = D("Advertising");
            $count = $D->where($where)->count();
            $pConf = page($count,C('PAGE_SIZE'));
            $this->list = $D->listAdvertising($pConf['first'],$pConf['list'],$where);
            $this->page = $pConf['show'];
            C('TOKEN_ON',false);
            $this->display('advertising');
    }
    
    public function forbid(){
        $getAjx = I('post.');
        $M = M('Advertising');
        $where = array('id' => $getAjx['forAid']);
        if($getAjx['forType']){
            if($M->where($where)->setField('status',0)){
                echo json_encode(array('status'=>'1','type'=>$getAjx['forType'],'msg'=>'禁用成功'));
            }
        }else{
            if($M->where($where)->setField('status',1)){
                echo json_encode(array('status'=>'1','type'=>$getAjx['forType'],'msg'=>'恢复成功'));
            }
        }
        

    }


    
    public function position() {
        $M = M('Advertising_position');
        $count = $M->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];
        $this->list = D('Advertising')->listPosition($pConf['first'], $pConf['list']);
        C('TOKEN_ON',false);
        $this->display();
    }
    
    
    public function add_position(){
        if (IS_POST) {
            $this->checkToken();
            echo json_encode(D("Advertising")->addPosition());
        } else {
            $this->display();
        }
    }
    
    public function edit_position() {
        $M = M('advertising_position');
        if (IS_POST) {
            $this->checkToken();
            echo json_encode(D("Advertising")->editPosition());
        } else {
             $info = $M->where("id=" . (int) $_GET['id'])->find();
            if ($info['id'] == '') {
                $this->error("不存在该记录");
            }
            $this->assign("info", $info);
            $this->display('add_position');
        }
    }
    
    public function del_position() {
        if (M("advertising_position")->where("id=" . (int) $_GET['id'])->delete()) {
            $this->success("成功删除");
            
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }
        
    public function del_pic() {
        $imgUrl = I('post.imgUrl');
        $imgDelUrl = C('UPLOADS_PICPATH').I('post.imgUrl'); 
        $advId = I('post.advId');
        $M = M('Advertising');
        $data = array(
            'id' => $advId,
            'code' =>''
        );
        if($advId){
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
}?>
