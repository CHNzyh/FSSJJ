<?php

namespace Admin\Controller;
use Think\Controller;
class OrderController extends CommonController {
    
    public function index() {
        $M = M("Goods_order");
        $auction = M("Auction");
        $member = M('Member');
        if(I('get.typ')==''){
            $where = array(
                'type'=>array('in','0,1'),
                'losetime'=>array('gt',time()),
            ); 
        }else{
            $where = array('type'=>'2'); 
        }
        $count = $M->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];
        $list = $M->where($where)->order('time desc')->select();
        foreach ($list as $lk => $lv) {
            $list[$lk]['pname']=$auction->where('pid='.$lv['gid'])->getField('pname');
            $list[$lk]['account']=$member->where('uid='.$lv['uid'])->getField('account');
        }
        $this->list = $list;
        $this->display(); 
    }
    
    public function lose() {
        $M = M("Goods_order");
        $auction = M("Auction");
        $member = M('Member');
        if(I('get.typ')==''){
            $where = array(
            'type'=>array('in',array('0','1')),
            'losetime'=>array('lt',time()),
            'status'=>array('in',array('0','4')),
            );
        }else{
            $where = array('type'=>'2'); 
        }
        $count = $M->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];
        $list = $M->where($where)->order('time desc')->select();
        foreach ($list as $lk => $lv) {
            $list[$lk]['pname']=$auction->where('pid='.$lv['gid'])->getField('pname');
            $list[$lk]['account']=$member->where('uid='.$lv['uid'])->getField('account');
        }

        $this->list = $list;
        $this->display(); 
    }
    
    public function deduct(){
        $m = M('member');
        $order = M('goods_order');
        $goods_user = M('Goods_user');
        $pOrder = I('post.order_no');
        $decsta=0;
        
        $oInfo = $order->where(array('order_no'=>$pOrder))->find();
        
        
        $guw = array('g-u'=>'p-u','uid'=>$oInfo['uid'],'gid'=>$oInfo['gid']);
        $gfeez = $goods_user->where($guw)->find();
        $pname =M('Auction')->where(array('pid'=>$gfeez['gid']))->getField('pname');
        
        if($gfeez['pledge']!=0){
            if($m->where(array('uid'=>$gfeez['uid']))->setDec('wallet_pledge_freeze',$gfeez['pledge'])){
                $matter=array(
                    'type'=>'deposit', 
                    'tid'=>0, 
                    'paytype' =>'扣除', 
                    'remark' => '未在订单有效期支付拍品【<a href="'.U('Home/Auction/details',array('pid'=>$gfeez['gid'])).'">'.$pname.'</a>】，扣除保证金'
                    );
                $data = array(
                    'order_no'=> createNo('AM'),
                    'uid'=> $gfeez['uid'],
                    'time'=> time(),
                    'matter' => serialize($matter),
                    'expend' => $gfeez['pledge']
                    );
                if(M('member_pledge_bill')->add($data)){
                    $goods_user->where($guw)->setField('pledge',0);
                    
                    sendSms($data['uid'],'系统发送','您好，后台管理员为您'.$matter['paytype'].'保证金'.$data['expend'].'元！<br/>备注：'.$matter['remark']);
                    $decsta+=1;
                }
            }
        }
        
        
        if($gfeez['limsum']!=0){
            if($m->where(array('uid'=>$info['uid']))->setDec('wallet_limsum_freeze',$gfeez['limsum'])){
                $matter=array(
                    'type'=>'deposit', 
                    'tid'=>0, 
                    'paytype' =>'扣除', 
                    'remark' => '未在订单有效期支付拍品【<a href="'.U('Home/Auction/details',array('pid'=>$gfeez['gid'])).'">'.$pname.'</a>】，扣除保证金'
                    );
                $data = array(
                    'order_no'=> createNo('AM'),
                    'uid'=> $gfeez['uid'],
                    'time'=> time(),
                    'matter' => serialize($matter),
                    'expend' => $gfeez['limsum']
                    );
                if(M('member_limsum_bill')->add($data)){
                    $goods_user->where($guw)->setField('limsum',0);
                    
                    sendSms($data['uid'],'系统发送','您好，后台管理员为您'.$matter['paytype'].'保证金'.$data['expend'].'元！<br/>备注：'.$matter['remark']);
                    $decsta+=2;
                } 
            }
        }
        $order->where(array('order_no'=>$pOrder))->setField('status',4);
        if($decsta!=0){
            echo json_encode(array('status' => 1, 'msg' => '已扣除保证金：'.$gfeez['pledge'].'  信用额度：'.$gfeez['limsum']));
        }else{
            echo json_encode(array('status' => 0, 'msg' => '扣除失败！请重试','url' => __SELF__));
        }
        
        
    }
    
    public function search(){
            $where = array(
                'losetime'=>array('gt',time()),
            ); 
            if(I('get.order_no')!=''){
                $where['order_no']=array('LIKE', '%' . I('get.order_no') . '%');
            }else{
                if(I('get.type')!=''){
                    $where['type']=I('get.type');
                }
                if(I('get.status')!=''){
                    $where['status']=I('get.status');
                }
            }
            $M = M("Goods_order");
            $auction = M("Auction");
            $member = M('Member');
            $count = $M->where($where)->count();
            $pConf = page($count,C('PAGE_SIZE'));
            $this->page = $pConf['show'];
            $list = $M->where($where)->select();
            foreach ($list as $lk => $lv) {
                $list[$lk]['pname']=$auction->where('pid='.$lv['gid'])->getField('pname');
                $list[$lk]['account']=$member->where('uid='.$lv['uid'])->getField('account');
            }
            $this->list=$list;
            $where['order_no']=I('get.order_no');
            $this->keys=$where;
            $this->page = $pConf['show'];
            C('TOKEN_ON',false);
            $this->display('index');
    }
    
    public function set_order(){
        if (IS_POST) {
            $this->checkToken();
            $data['Order'] = I('post.order');
            if (set_config("SetOrder", $data, APP_PATH . "Common/Conf/")) {
                delDirAndFile(WEB_CACHE_PATH . "Cache/Admin/");
                echo json_encode(array('status' => 1, 'info' => '设置成功'));
            } else {
                echo json_encode(array('status' => 0, 'info' => '设置失败，请检查'));
            }
        } else {
            $this->order=C('Order');
            $this->display();
        }
    }
    
    public function edit(){
        $M = M("Goods_order");
        if (IS_POST) {
            $pow =I('post.info');
            $where = array('order_no'=>I('get.order_no'));
            $order = $M->where($where)->find();
            if($pow['act']!=''){
                if($pow['act']=='add'){
                    $data['losetime'] = $order['losetime']+(60*60*24*$pow['day']);
                }
                if($pow['act']=='sub'){
                    $data['losetime'] = $order['losetime']-(60*60*24*$pow['day']);
                }
            }
            $data['status']=$pow['status'];
            $data['remark']=$pow['remark'];
            if($M->where($where)->save($data)){
                echo json_encode(array('status' => 1, 'info' => '编辑成功','url' => U('Order/index'))); 
            }else{
                echo json_encode(array('status' => 0, 'info' => '编辑失败，请检查'));
            }
        } else {
            $info = $M->where(array('order_no'=>I('get.order_no')))->find();
            $this->info=$info;
            $this->display();
        }
    }
    
    public function del() {
        if (M("News")->where("id=" . (int) $_GET['id'])->delete()) {
            $this->success("成功删除");

        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }

}?>
