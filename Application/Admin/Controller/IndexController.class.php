<?php

namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {

    public function index() {
        
        $take = M('member_pledge_take');
        $this->takeAll = $take->count();
        $this->takeUn = $take->where('status=0')->count();
        
        $lbid = array(
            'type'=>array('in',array('0','1')),
            'losetime'=>array('lt',time()),
            'status'=>array('in',array('0','4')),
            );
        
        $losebidAll = M('goods_order')->where($lbid)->count();
        
        $$lbid['status']=0;
        $losebidUn = M('goods_order')->where($lbid)->count();
        $this->losebidAll=$losebidAll;
        $this->losebidUn=$losebidUn;

        
        if (function_exists('gd_info')) {
            $gd = gd_info();
            $gd = $gd['GD Version'];
        } else {
            $gd = "不支持";
        }
        $info = array(
            '操作系统' => PHP_OS,
            '主机名IP端口' => $_SERVER['SERVER_NAME'] . ' (' . $_SERVER['SERVER_ADDR'] . ':' . $_SERVER['SERVER_PORT'] . ')',
            '运行环境' => $_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式' => php_sapi_name(),
            '程序目录' => WEB_ROOT,
            'MYSQL版本' => function_exists("mysql_close") ? mysql_get_client_info() : '不支持',
            'GD库版本' => $gd,

            '上传附件限制' => ini_get('upload_max_filesize'),
            '执行时间限制' => ini_get('max_execution_time') . "秒",
            '剩余空间' => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
            '服务器时间' => date("Y年n月j日 H:i:s"),
            '北京时间' => gmdate("Y年n月j日 H:i:s", time() + 8 * 3600),
            '采集函数检测' => ini_get('allow_url_fopen') ? '支持' : '不支持',
            'register_globals' => get_cfg_var("register_globals") == "1" ? "ON" : "OFF",
            'magic_quotes_gpc' => (1 === get_magic_quotes_gpc()) ? 'YES' : 'NO',
            'magic_quotes_runtime' => (1 === get_magic_quotes_runtime()) ? 'YES' : 'NO',
        );
        $this->assign('server_info', $info);
        $this->display();
    }
    
    public function take(){
        $take = M('member_pledge_take');
        $member= M('member');
        if (IS_POST) {
            $this->checkToken();
            $post = I('post.');
            $sdata = array(
                'tid'=>$post['tid'],
                'status'=>$post['status'],
                'cause'=>$post['cause'],
                'dtime'=>time()
                );
            if($take->save($sdata)){
                
                $w = array('uid'=>$post['uid']);
                if($post['status']==1){
                    if($member->where($w)->setDec('wallet_pledge_freeze',$post['money'])&&$member->where($w)->setDec('wallet_pledge',$post['money'])){
                        $matter=array(
                            'type'=>'extract', 
                            'tid'=>3, 
                            'paytype' =>'扣除', 
                            'remark' => $post['cause']
                            );
                        $data = array(
                            'order_no'=> createNo('RTK'),
                            'uid'=> $post['uid'],
                            'time'=> time(),
                            'matter' => serialize($matter),
                            'expend' => $post['money']
                            );
                        if(M('member_limsum_bill')->add($data)){
                            
                            sendSms($data['uid'],'系统发送','您的'.$data['expend'].'元保证金已成功提现。系统已'.$matter['paytype'].'保证金'.$data['expend'].'元！备注：'.$matter['remark']);
                            echo json_encode(array('status' => 1, 'info' => '已处理申请为已提现','url'=>U('Index/take')));
                        } 
                    }
                }elseif ($post['status']==2) {
                    if($member->where($w)->setDec('wallet_pledge_freeze',$post['money'])){
                        $matter=array(
                            'type'=>'unfreeze', 
                            'tid'=>3, 
                            'paytype' =>'解冻', 
                            'remark' =>  $post['cause']
                            );
                        $data = array(
                            'order_no'=> createNo('RTKF'),
                            'uid'=> $post['uid'],
                            'time'=> time(),
                            'matter' => serialize($matter),
                            'income' => $post['money']
                            );
                        if(M('member_pledge_bill')->add($data)){
                            
                            sendSms($data['uid'],'系统发送','网站驳回了您'.$data['income'].'元提现申请！'.$matter['paytype'].'保证金'.$data['income'].'元！备注：'.$matter['remark']);
                            echo json_encode(array('status' => 1, 'info' => '已处理申请为驳回申请'.$data['money'],'url'=>U('Index/take')));
                        } 
                    }
                }
            }
        }else{
            if(I('get.tid')){
                $tinfo = $take->where('tid='.I('get.tid'))->find();
                $tinfo['uaccount'] = $member->where('uid='.I('get.tid'))->getField('account');
                $this->tinfo=$tinfo;
                $this->display('rtake');
            }else{
                if(I('get.sw')!=''){
                    $sw=array('status'=>I('get.sw'));
                }
                
                $count = $member->where($sw)->count();
                $pConf = page($count,20);
                $take_list = $take->where($sw)->limit($pConf['first'].','.$pConf['list'])->order('time desc')->select();
                foreach ($take_list as $tk => $tv) {
                    $take_list[$tk]['uaccount'] = $member->where('uid='.$tv['uid'])->getField('account');
                }
                
                $this->sw=I('get.sw');
                $this->page = $pConf['show']; 
                $this->take_list = $take_list;
                $this->display();
            }
        }
        

        
    }

    public function myInfo() {
        if (IS_POST) {
            $this->checkToken();
            echo json_encode(D("Index")->my_info($_POST));
        } else {
            $this->display();
        }
    }

    public function cache() {
        $caches = array(
            "HomeCache" => array("name" => "网站前台缓存文件", "path" => WEB_CACHE_PATH . "Cache/Home/"),
            "AdminCache" => array("name" => "网站后台缓存文件", "path" => WEB_CACHE_PATH . "Cache/Admin/"),
            "HomeData" => array("name" => "网站前台数据库字段缓存文件", "path" => WEB_CACHE_PATH . "Data/Home/"),
            "AdminData" => array("name" => "网站后台数据库字段缓存文件", "path" => WEB_CACHE_PATH . "Data/Admin/"),
            "HomeLog" => array("name" => "网站日志缓存文件", "path" => WEB_CACHE_PATH . "Logs/"),
            "HomeTemp" => array("name" => "网站临时缓存文件", "path" => WEB_CACHE_PATH . "Temp/"),
            "MinFiles" => array("name" => "JS\CSS压缩缓存文件", "path" => WEB_CACHE_PATH . "MinFiles/")
        );
        if (IS_POST) {
            foreach ($_POST['cache'] as $path) {
                if (isset($caches[$path]))
                    delDirAndFile($caches[$path]['path']);
            }
           $this->checkToken();
            echo json_encode(array("status"=>1,"info"=>"缓存文件已清除"));
        } else {
            $this->assign("caches", $caches);
            $this->display();
        }
    }

}?>
