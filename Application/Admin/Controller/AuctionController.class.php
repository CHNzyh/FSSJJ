<?php

namespace Admin\Controller;
use Think\Controller;
class AuctionController extends CommonController {
    
    public function index() {
        $channel = M('goods_category')->where('pid=0')->select(); 
        $this->channel=$channel; 
        $ws = I('get.typ')?bidType(I('get.typ')):bidType('biding');
        $od = 'pid desc';
        $M = M("Auction");
        $count = $M->where($ws['bidType'])->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];
        $this->list = D("Auction")->listAuction($pConf['first'], $pConf['list'],$ws['bidType'],$od);
        $this->saytyp=$ws['saytyp'];
        $this->display(); 
    }
    
    public function search(){
        $ws = bidType(I('get.typ'));
        $keyW = I('get.');
        $cate=M('Goods_category');
        if($keyW['type']!=''){
            $where['type'] = $keyW['type'];
            $tname = $keyW['type']==0 ?'竞拍模式':'竞价模式';
        }else{
            $tname = '所有模式';
        }
        if($keyW['pid']!=''){
            $chname=  $cate->where('cid='.$keyW['pid'])->getField('name');
            if($keyW['cid']==''){
                $cat = new \Org\Util\Category('Goods_category', array('cid', 'pid', 'name', 'fullname'));
                $catecid = $cat->getList(NULL, $keyW['pid'],NULL);
                foreach ($catecid as $cik => $civ) {
                    $keyW['cid'][$cik]=$civ['cid'];
                }
                array_push($keyW['cid'], $keyW['pid']); 
                $where['cid'] = array('in',$keyW['cid']);
                $catname = '所有'; 
            }else{
                $chname = '所有';
                if($keyW['cid']!=''){
                    $where['cid'] = $keyW['cid'];
                    $catname = $cate->where('cid='.$keyW['cid'])->getField('name');
                }else{
                    $catname = '所有'; 
                }
            }
        }else{
            $cat = new \Org\Util\Category('Goods_category', array('cid', 'pid', 'name', 'fullname'));
            $catecid = $cat->getList(NULL, 0,NULL);
            foreach ($catecid as $cik => $civ) {
                $keyW['cid'][$cik]=$civ['cid'];
            }
            $where['cid'] = array('in',$keyW['cid']);
            $chname = '所有';
            $catname = '所有'; 
        }
        $where = array_merge($where,$ws['bidType']);
        if($keyW['cid'] != '') $where['cid'] = array('in',$keyW['cid']);
        if($keyW['keyword'] != '') $where['pname'] = array('LIKE', '%' . $keyW['keyword'] . '%');
        $D = D("Auction");
        $count = $D->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE'));

        $channel = $cate->where('pid=0')->select(); 
        $this->channel=$channel; 
        
        
        $keyS = array('count' =>$count,'keyword'=>$keyW['keyword'],'type'=>$keyW['type'],'tname'=>$tname,'chname' => $chname,'catname' => $catname,'pid'=>$keyW['pid']);
        $this->keys = $keyS;
        $this->page = $pConf['show']; 
        $this->list= D("Auction")->listAuction($pConf['first'], $pConf['list'],$where);
        $this->saytyp=$ws['saytyp']; 
        C('TOKEN_ON',false);
        $this->display('index');
    }
    
    public function add() {
        if (IS_POST) {
            $info = I('post.info');
            $info['starttime']=strtotime($info['starttime']);
            $info['endtime']=strtotime($info['endtime']);
            $info['nowprice']=$info['onset'];
            
            if($info['endtime']>time()){
                if($info['pledge_type'] == 0){
                    $info['pledge'] = $info['ratio_b'].'/'.$info['ratio_g'];
                    unset($info['ratio_b']);
                    unset($info['ratio_g']);
                }elseif ($info['pledge_type'] == 1) {
                    $info['pledge'] = $info['fixation'];
                    unset($info['fixation']);
                }
                
                if($info['starttime']<=time()){
                    $typ='biding';
                }else{
                    $typ='future';
                }
                if($pid = M('Auction')->add($info)){
                    M('Auction')->where('pid ='.$pid)->save(array('bidnb'=>'B'.$pid.'-'.time()));
                    echo json_encode(array('status' => 1, 'info' => '已添加成功','url'=>U('Auction/index',array('typ'=>$typ))));
                }else{
                    echo json_encode(array('status' => 0, 'info' => '添加失败，请重试','url'=>__SELF__));
                }
            }else{
                echo json_encode(array('status' => 0, 'info' => '拍品结束时间小于当前时间，请检查','url'=>__SELF__));
            }
        }else{
            $goods= M('Goods');
            $info['gid'] = I('get.gid');
            $gdata=$goods->where('id ='.$info['gid'])->field('title,price')->find();
            if($gdata){
                $bidcof=C('Auction');
                $info['pname'] = $gdata['title'];
                $info['onset'] = $gdata['price'];
                $info['price'] = $gdata['price'];
                $info = array_merge($info,$bidcof);
                $this->info=$info;
                $this->display();
            }else{
                $this->error('商品不存在！');
            }
        }
        
    }
    
    public function edit() {
        if (IS_POST) {
            $info = I('post.info');
            $info['starttime']=strtotime($info['starttime']);
            $info['endtime']=strtotime($info['endtime']);
            $info['nowprice']=$info['onset'];
            if($info['pledge_type'] == 0){
                $info['pledge'] = $info['ratio_b'].'/'.$info['ratio_g'];
                unset($info['ratio_b']);
                unset($info['ratio_g']);
            }elseif ($info['pledge_type'] == 1) {
                $info['pledge'] = $info['fixation'];
                unset($info['fixation']);
            }
            if(M('Auction')->save($info)){
                echo json_encode(array('status' => 1, 'info' => '修改成功','url'=>U('Auction/index')));
            }else{
                echo json_encode(array('status' => 0, 'info' => '修改失败，请重试','url'=>__SELF__));
            }
        }else{
            $info = M('Auction')->where(array('pid'=>I('get.pid')))->find();
            $bidcof=C('Auction');
            if($info['pledge_type'] == 0){
                $pledge = explode('/', $info['pledge']);
                $info['ratio_b'] = $pledge[0];
                $info['ratio_g'] = $pledge[1];
                
                $info['fixation'] = $bidcof['fixation'];
            }elseif ($info['pledge_type'] == 1) {
                $info['fixation'] = $info['pledge'];
                
                $info['ratio_b'] = $bidcof['ratio_b'];
                $info['ratio_g'] = $bidcof['ratio_g'];

            }
            unset($info['pledge']);
            $this->info=$info;
            $this->display('add'); 
        }
        
    }
    
    public function set_auction() {
        if (IS_POST) {
            $this->checkToken();
            $config = APP_PATH . "Common/Conf/SetAuction.php";
            $config = file_exists($config) ? include "$config" : array();
            $config = is_array($config) ? $config : array();
            $data['Auction'] = I('post.Auction');
            if (set_config("SetAuction", $data, APP_PATH . "Common/Conf/")) {
                delDirAndFile(WEB_CACHE_PATH . "Cache/Admin/");
                echo json_encode(array('status' => 1, 'info' => '设置成功'));
            } else {
                echo json_encode(array('status' => 0, 'info' => '设置失败，请检查'));
            }
        } else {
            $this->bidcof=C('Auction');
            $this->display(); 
        }
    }
    public function del(){
        if (M("Auction")->where("pid=" . (int) $_GET['pid'])->delete()) {
            $this->success("成功删除");
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }
}?>
