<?php

namespace Admin\Controller;
use Think\Controller;
use Org\Util\Rbac;
class CommonController extends Controller {

    public $loginMarked;


    public function _initialize() {
        // header("Content-Type:text/html; charset=utf-8");
        // header('Content-Type:application/json; charset=utf-8');
        $systemConfig = include APP_PATH . 'Common/Conf/systemConfig.php';
        if (empty($systemConfig['TOKEN']['admin_marked'])) {
            $systemConfig['TOKEN']['admin_marked'] = "admin.rzinfo.net.cn";
            $systemConfig['TOKEN']['admin_timeout'] = 3600;
            $systemConfig['TOKEN']['member_marked'] = "home.rzinfo.net.cn";
            $systemConfig['TOKEN']['member_timeout'] = 3600;
            set_config("systemConfig", $systemConfig, APP_PATH . "Common/Conf/");
            if (is_dir(WEB_ROOT . "install/")) {
                
            }
        }
        $this->lock_id = C('LOCK_ID'); 
        $this->loginMarked = md5($systemConfig['TOKEN']['admin_marked']);
        $this->checkLogin();
        
        if (C('USER_AUTH_ON') && !in_array(CONTROLLER_NAME, explode(',', C('NOT_AUTH_MODULE')))) {
           
            if (!RBAC::AccessDecision()) {
                
                if (!$_SESSION [C('USER_AUTH_KEY')]) {
                    
                    redirect(C('USER_AUTH_GATEWAY'));

                }
                
                if (C('RBAC_ERROR_PAGE')) {
                    
                    redirect(C('RBAC_ERROR_PAGE'));
                } else {
                    if (C('GUEST_AUTH_ON')) {
                        $this->assign('jumpUrl', C('USER_AUTH_GATEWAY'));
                    }
                    

                    $this->error(L('_VALID_ACCESS_'));
                }
            }
        }
        $menu =  $this->show_menu();


        $this->upWholeUrl = __ROOT__.trim(C('UPLOADS_PICPATH'),'.');
        $this->assign("menu",$menu['menu']);
        //$this->assign("sub_menu", $this->show_sub_menu());
        $this->assign("sub_menu", $menu['sub_menu']);
        $this->assign("my_info", $_SESSION['my_info']);
        $this->assign("site", $systemConfig);
        //echo CONTROLLER_NAME;
        //echo ACTION_NAME;

    }

    protected function getQRCode($url = NULL) {
        if (IS_POST) {
            $this->assign("QRcodeUrl", "");
        } else {

            $url = empty($url) ? C('WEB_ROOT') . U(CONTROLLER_NAME . '/' . ACTION_NAME) : $url;
            
        }
    }

    public function checkLogin() {
        if (isset($_COOKIE[$this->loginMarked])) {
            $cookie = explode("_", $_COOKIE[$this->loginMarked]);
            $timeout = C("TOKEN");
            if (time() > (end($cookie) + $timeout['admin_timeout'])) {
                setcookie("$this->loginMarked", NULL, -3600, "/");
                unset($_SESSION[$this->loginMarked], $_COOKIE[$this->loginMarked]);
                $this->error("登录超时，请重新登录", U("Public/index"));
            } else {
                if ($cookie[0] == $_SESSION[$this->loginMarked]) {
                    setcookie("$this->loginMarked", $cookie[0] . "_" . time(), 0, "/");
                } else {
                    setcookie("$this->loginMarked", NULL, -3600, "/");
                    unset($_SESSION[$this->loginMarked], $_COOKIE[$this->loginMarked]);
                    $this->error("帐号异常，请重新登录", U("Public/index"));
                }
            }
        } else {
             //echo $this->loginMarked;
             //print_r($_COOKIE);
            //$this->redirect("Public/index");
            $this->error("登录超时，请重新登录", U("Public/index"));
        }
        return TRUE;
    }

    
    protected function checkToken() {
        if (IS_POST) {
            if (!M("Admin")->autoCheckToken($_POST)) {
                die(json_encode(array('status' => 0, 'info' => '重复提交数据')));
            }
            unset($_POST[C("TOKEN_NAME")]);
        }
    }

    
    private function show_menu() {
        $node = D('Node')->where('level=2 and menu=1')->order('sort,id')->relation(true)->select();

        $module = '';
        $node_id = '';
        $accessList = $_SESSION['_ACCESS_LIST'];

       
        foreach($accessList as $key => $value){
            foreach ($value as $key1 => $value1) {
                $module .= ','.$key1;
                foreach ($value1 as $key2 => $value2) {
                    $node_id .= ','.$value2;
                }
            }
            
        }
        
        foreach ($node as $key => $value) {
            
            if(!in_array(strtoupper($value['name']),explode(',',$module)) && $_SESSION['authId']!=10){

                unset($node[$key]);               
            }else{
                foreach ($value['node'] as $key1 => $value1) {
                    if(!in_array(strtoupper($value1['id']),explode(',',$node_id)) && $_SESSION['authId']!=10){

                    unset($node[$key]['node'][$key1]);               
                    }
                }
            }
        }



        //print_r($node);
        
        //$cache = C('admin_big_menu');
        $cache = $node;
        $count = count($cache);
        


        $i = 1;
        $menu = "";


        foreach ($cache as $key => $value) {
            if ($i == 1) {

                $css = ($value['name'] == CONTROLLER_NAME) ? "fisrt_current" : "fisrt";
                $menu.='<li class="' . $css . '"><span><a href="' . U($value['name'] . '/index') . '">' . $value['title'] . '</a></span></li>';
            } else if ($i == $count) {
                $css = $value['name'] == CONTROLLER_NAME ? "end_current" : "end";
                $menu.='<li class="' . $css . '"><span><a href="' . U($value['name'] . '/index') . '">' . $value['title'] . '</a></span></li>';
            } else {
                $css = $value['name'] == CONTROLLER_NAME ? "current" : "";
                $menu.='<li class="' . $css . '"><span><a href="' . U($value['name'] . '/index') . '">' . $value['title'] . '</a></span></li>';
            }
            if($value['name'] == CONTROLLER_NAME){
                
                foreach ($value['node'] as $key1 => $value1) {
                    $sub_menu[] = array('url'=>U(CONTROLLER_NAME.'/'.$value1['name']),'title'=>$value1['title']);
                }

            }
            $i++;
        }
       
        $result = array('menu'=>$menu,'sub_menu'=>$sub_menu);
        return $result;
    }

    
    private function show_sub_menu() {
        $big = CONTROLLER_NAME == "Index" ? "Common" : CONTROLLER_NAME;
        $cache = C('admin_sub_menu');

        $sub_menu = array();
        if ($cache[$big]) {
            $cache = $cache[$big];
            foreach ($cache as $url => $title) {
                $url = $big == "Common" ? $url : "$big/$url";
                $sub_menu[] = array('url' => U("$url"), 'title' => $title);
            }
            //print_r($sub_menu);
            return $sub_menu;
        } else {
            return $sub_menu[] = array('url' => '#', 'title' => "该菜单组不存在");
        }
    }

    public function getAdmin($condition=array())
    {
        $condition = array_merge(array('aid>10'),$condition);
        if(I('post.did')>0)
            $condition = array_merge(array('department='.I('post.did'),'status=1'),$condition);
        $result = D('Admin')->getAdmin($condition);
        
        if(IS_POST){            
           header('Content-Type:application/json; charset=utf-8');
            echo json_encode($result);
        }else{
            return $result;
        }
    }

}?>
