<?php
namespace Admin\Controller;
use Think\Controller;
Class LogController extends Controller{
	// 显示日志




 public function _initialize() {
        header("Content-Type:text/html; charset=utf-8");
        header('Content-Type:application/json; charset=utf-8');
        $systemConfig = include APP_PATH . 'Common/Conf/systemConfig.php';
       
        $this->lock_id = C('LOCK_ID'); 
        $this->loginMarked = md5($systemConfig['TOKEN']['admin_marked']);
       
        
       
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

	public $content;
	public function index(){

		$this->search();

	}

	public function search()
	{
            $log = M('Log');


            $keys = I('get.');
            $where = array('a.id>0');

            if(!empty($keys)){	   
                $where = ($keys['department']>0)?array_merge(array('a.did='.$keys['department']),$where):$where;
                $where = ($keys['user']>0)?array_merge(array('a.userid='.$keys['user']),$where):$where;
                $where = ($keys['pbtime']!='')?array_merge(array('a.ltime>='.strtotime($keys['pbtime'])),$where):$where;
                $where = ($keys['petime']!='')?array_merge(array('a.ltime<='.strtotime($keys['petime'])),$where):$where;
            }
		

            $count = $log->alias('a')->join('__DEPARTMENT__ b ON a.did= b.id')->join('__ADMIN__ c ON a.userid= c.aid')->where($where)->order('ltime desc')->count();
            $pConf = page($count,C('PAGE_SIZE')); 

            $list = $log->alias('a')->join('__DEPARTMENT__ b ON a.did= b.id')->join('__ADMIN__ c ON a.userid= c.aid')->where($where)->limit($pConf['first'], $pConf['list'])->order('ltime desc')->select();

            $this->list=$list;



            $keys['count']=$count;
            $this->keys=$keys;
            $this->page = $pConf['show'];
            C('TOKEN_ON',false);

            if($keys['department']>0){
                    $user = $this->getAdmin(array('department='.$keys['department']));
                    $condition = array('pid'=>$keys['department']);
            }
            $dp = D('Department')->getDepartmentarray($condition,'全部部门');


            $this->assign('dp',$dp);
            $this->assign('user',$user);

            $this->assign('keys',$keys);
           
            $this->display('index');
	}

	//增加日志 
	public function addLog(){
		D('Log')->addLog($this->content);
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
	
}
?>