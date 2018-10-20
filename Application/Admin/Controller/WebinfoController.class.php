<?php

namespace Admin\Controller;
use Think\Controller;

class WebinfoController extends CommonController {
    
    public function index() {

        $this->display();
    }

    
    public function steWebConfig() {
        $this->checkSystemConfig('SITE_INFO');
    }
    
    public function setEmailConfig() {
        $this->checkSystemConfig("SYSTEM_EMAIL");
    }
    
    public function setNoteConfig() {

        $this->checkSystemConfig("SYSTEM_NOTE");
    }
    
    public function setSafeConfig() {
        $this->checkSystemConfig("TOKEN");
    }
    
    public function setUserAgreement() {
        if (IS_POST) {
            $this->checkToken();
            $config = APP_PATH . "Common/Conf/UserAgreement.php";
            $config = file_exists($config) ? include "$config" : array();
            $config = is_array($config) ? $config : array();
            if (set_config("UserAgreement", I('post.'), APP_PATH . "Common/Conf/")) {
                delDirAndFile(WEB_CACHE_PATH . "Cache/Admin/");
                echo json_encode(array('status' => 1, 'info' => '用户协议已更新'));
            } else {
                echo json_encode(array('status' => 0, 'info' => '用户协议失败，请检查', 'url' => __ACTION__));
            }
        } else {
            $this->UserAgreement = include APP_PATH . 'Common/Conf/UserAgreement.php';
            $this->display();
        }
    }
    
    public function navigation() {
        if (IS_POST) {
            echo json_encode(D("Webinfo")->navigation());
        } else {
            $this->assign("list", D("Webinfo")->navigation());
            $this->display();
        }
    }
    
    public function order_navigation() {
        if (IS_POST) {
            $getInfo = I('post.');
            $M = M('navigation');
            $where=array('lid'=>$getInfo['odAid']);
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
    
    private function checkSystemConfig($obj = "SITE_INFO") {
        if (IS_POST) {
            $this->checkToken();
            $config = APP_PATH . "Common/Conf/systemConfig.php";
            $config = file_exists($config) ? include "$config" : array();
            $config = is_array($config) ? $config : array();
            $config = array_merge($config, array("$obj" => $_POST));
            if($obj == "SITE_INFO"){
              $str = "网站配置信息";
            }elseif ($obj == "SYSTEM_EMAIL") {
              $str = "系统邮箱配置";
            }elseif($obj == 'TOKEN'){
              $str = "安全设置";
            }elseif($obj == 'SYSTEM_NOTE'){
              $str = "系统短信配置";
            }
            if (set_config("systemConfig", $config, APP_PATH . "Common/Conf/")) {
                delDirAndFile(WEB_CACHE_PATH . "Cache/Admin/");
                if ($obj == "TOKEN") {
                    unset($_SESSION, $_COOKIE);
                    echo json_encode(array('status' => 1, 'info' => $str . '已更新，你需要重新登录', 'url' => __APP__ . '?' . time()));
                } else {
                    echo json_encode(array('status' => 1, 'info' => $str . '已更新'));
                }
            } else {
                echo json_encode(array('status' => 0, 'info' => $str . '失败，请检查', 'url' => __ACTION__));
            }
        } else {
            $this->display();
        }
    }

    
    public function testEmailConfig() {
        C('TOKEN_ON', false);
        $return = send_mail($_POST['test_email'], "", "测试配置是否正确", "这是一封测试邮件，如果收到了说明配置没有问题", "", $_POST);
        if ($return == 1) {
            echo json_encode(array('status' => 1, 'info' => "测试邮件已经发往你的邮箱" . $_POST['test_email'] . "中，请注意查收"));
        } else {
            echo json_encode(array('status' => 0, 'info' => "$return"));
        }
    }
    
    public function testNoteConfig() {
        C('TOKEN_ON', false);
        echo json_encode(sendNote(C('SYSTEM_NOTE.test'),$content='如果收到了说明没有问题'));
    }

}

?>
