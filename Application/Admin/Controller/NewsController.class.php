<?php

namespace Admin\Controller;
use Think\Controller;
class NewsController extends CommonController {
    
    public function index() {
        $M = M("News");
        $count = $M->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];

        $this->cate = D("News")->category();
        $this->list = D("News")->listNews($pConf['first'], $pConf['list']);
        C('TOKEN_ON',false);
        $this->display(); 
    }
    
    public function search(){
            $keyW = I('get.');
            if($keyW['cid'] != '') $where['cid'] = $keyW['cid'];
            if($keyW['keyword'] != '') $where['title'] = array('LIKE', '%' . $keyW['keyword'] . '%');
            $M = M("News");
            $count = $M->where($where)->count();
            $pConf = page($count,C('PAGE_SIZE'));

            if($keyW['cid'] != ''){
                $catname = M('Category')->where('cid='.$keyW['cid'])->getField('name');
            }else{
               $catname = '所有'; 
            }
            $keyS = array('count' =>$count,'keyword'=>$keyW['keyword'],'name' => $catname,'cid' => $keyW['cid']);
            $this->keys = $keyS;
            $this->page = $pConf['show'];
            $this->cate = D("News")->category();
            $this->list = D("News")->listNews($pConf['first'], $pConf['list'],$where);
            C('TOKEN_ON',false);
            $this->display('index');
    }
    
    public function category() {
        if (IS_POST) {
            echo json_encode(D("News")->category());
        } else {
            $this->assign("list", D("News")->category());
            $this->display();
        }
    }
    
    public function order_category() {
        if (IS_POST) {
            $getInfo = I('post.');

            $M = M('category');
            $where=array('cid'=>$getInfo['odAid']);
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
    
    public function add() {
        if (IS_POST) {
            $this->checkToken();
            echo json_encode(D("News")->addNews());
        } else {
            $this->assign("list", D("News")->category());
            $this->display();
        }
    }
    
    public function checkNewsTitle() {
        $M = M("News");
        $where = "title='" .I('get.title') . "'";
        if (!empty($_GET['id'])) {
            $where.=" And id !=" . (int) $_GET['id'];
        }
        if ($M->where($where)->count() > 0) {
            echo json_encode(array("status" => 0, "info" => "已经存在，请修改标题"));
        } else {
            echo json_encode(array("status" => 1, "info" => "可以使用"));
        }
    }
    
    public function edit() {
        $M = M("News");
        if (IS_POST) {
            $this->checkToken();
            echo json_encode(D("News")->edit());
        } else {
            $info = $M->where("id=" . (int) $_GET['id'])->find();
            if ($info['id'] == '') {
                $this->error("不存在该记录");
            }
            $info['content']=stripslashes($info['content']);
            $this->assign("info", $info);
            $this->assign("list", D("News")->category());
            $this->display("add");
        }
    }
    
    public function del() {
        if (M("News")->where("id=" . (int) $_GET['id'])->delete()) {
            $this->success("成功删除");

        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }
    
    public function del_pic() {
        $imgUrl = I('post.imgUrl');
        $imgDelUrl = C('UPLOADS_PICPATH').I('post.imgUrl'); 
        $newsId = I('post.newsId');
        $M = M('News');
        $data = array(
            'id' => $newsId,
            'picture' =>''
        );
        if($newsId){
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
