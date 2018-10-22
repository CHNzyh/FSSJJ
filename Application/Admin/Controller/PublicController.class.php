<?php
namespace Admin\Controller;
use Think\Controller;
use Org\Util\Rbac;
class PublicController extends Controller {

    public $loginMarked;

    
    public function _initialize() {
         header("Content-Type:text/html; charset=utf-8");
         header('Content-Type:application/json; charset=utf-8');
    //     $loginMarked = C("TOKEN");
    //     $this->loginMarked = md5($loginMarked['admin_marked']);
    }

    
    private function checkToken() {
        if (!M("Admin")->autoCheckToken($_POST)) {
            die(json_encode(array('status' => 0, 'info' => '令牌验证失败')));
        }
        unset($_POST[C("TOKEN_NAME")]);
    }

    public function index() {
        if (IS_POST) {
          
            $returnLoginInfo = D("Public")->auth();
            
            if ($returnLoginInfo['status'] == 1) {
                $map = array();
                
                //$map['email'] = I('post.email');
                $map['email'] = $returnLoginInfo['email'];
                $authInfo = Rbac::authenticate($map);
                $_SESSION[C('USER_AUTH_KEY')] = $authInfo['aid'];
                $_SESSION['email'] = $authInfo['email'];
                if ($authInfo['email'] == C('ADMIN_AUTH_KEY')) {
                    $_SESSION[C('ADMIN_AUTH_KEY')] = true;
                }
                RBAC::saveAccessList();
                $log = D('log');

                $log->addLog('用户登陆');
            }
          
        

            echo json_encode($returnLoginInfo);
        } else {

            if (isset($_COOKIE[$this->loginMarked])) {
                $this->redirect("Index/index");
            }
            $this->display("Common:login");
        }
    }

    public function verify_code(){
        $Verify = new \Think\Verify();
        $Verify->fontSize = 17;
        $Verify->length   = 4;
        $Verify->codeSet = '0123456789';
        $Verify->entry();
    }
    public function loginOut() {
        $log = D('log');
        $log->content='用户登出';
        $log->addLog();        setcookie("$this->loginMarked", NULL, -3600, "/");
        unset($_SESSION["$this->loginMarked"], $_COOKIE["$this->loginMarked"]);
        
        if (isset($_SESSION[C('USER_AUTH_KEY')])) {
            unset($_SESSION[C('USER_AUTH_KEY')]);
            unset($_SESSION);
            session_destroy();

        }


        $this->redirect("Public/index");
    }

    public function findPwd() {
        $M = M("Admin");
        if (IS_POST) {
            $this->checkToken();
            echo json_encode(D("Public")->findPwd());
        } else {
            setcookie("$this->loginMarked", NULL, -3600, "/");
            unset($_SESSION["$this->loginMarked"], $_COOKIE["$this->loginMarked"]);
            $cookie =I('get.code');
            $shell = substr($cookie, -32);
            $aid = (int) str_replace($shell, '', $cookie);
            $info = $M->where("`aid`='$aid'")->find();
            if ($info['status'] == 0) {
                $this->error("你的账号被禁用，有疑问联系管理员吧", __APP__);
            }
            if (md5($info['find_code']) == $shell) {
                $this->assign("info", $info);
                $_SESSION['aid'] = $aid;
                $systemConfig = include APP_PATH . 'Common/Conf/systemConfig.php';
                $this->assign("site", $systemConfig);
                $this->display("Common:findPwd");
            } else {
                $this->error("验证地址不存在或已失效", __APP__);
            }
        }
    }

}?>
