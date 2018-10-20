<?php

namespace Admin\Controller;
use Think\Controller;
class LinkController extends CommonController {

    
    public function index() {
        if(I('get.ico')!=''){
            $where = array('rec'=>I('get.ico'));
        }
        $link = M('Link');
        $count = $link->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];
        $this->list = $link->order('sort desc')->where($where)->select();
        $this->ico=I('get.ico');
        $this->display();
    }
    
    public function add(){
        if (IS_POST) {
            $this->checkToken();
            $data = I('post.info');
            if(M('Link')->add($data)){
                echo json_encode(array('status' => 1, 'info' => '添加成功', 'url' => U('Link/index')));
            }else{
                echo json_encode(array('status' => 0, 'info' => '添加失败！请重试'));
            }
        } else {
            $this->display();
        }
    }
    
    public function edit() {
        $M = M('Link');
        if (IS_POST) {
            $this->checkToken();
            $data = I('post.info');
            if(M('Link')->save($data)){
                echo json_encode(array('status' => 1, 'info' => '已更新', 'url' => U('Link/index')));
            }else{
                echo json_encode(array('status' => 0, 'info' => '更新失败，请重试'));
            }
        } else {
            $info = $M->where("id=" . (int) $_GET['id'])->find();
            if ($info['id'] == '') {
                $this->error("不存在该记录");
            }
            $this->assign("info", $info);
            $this->display('add');
        }
    }
    
    public function del() {
        if (M("Link")->where("id=" . (int) $_GET['id'])->delete()) {
            $this->success("成功删除");
            
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }
    
    public function sort() {
        if (IS_POST) {
            $getInfo = I('post.');
            $M = M('Link');
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
    
    public function del_pic() {
        $imgUrl = I('post.imgUrl');
        $imgDelUrl = C('UPLOADS_PICPATH').I('post.imgUrl'); 
        $linkId = I('post.linkId');
        $M = M('Link');
        $data = array(
            'id' => $linkId,
            'ico' =>''
        );
        if($linkId){
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
