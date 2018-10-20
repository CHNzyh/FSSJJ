<?php
namespace Admin\Controller;
use Think\Controller;
class KsController extends Controller{

	 public function _initialize() {
        //header("Content-Type:text/html; charset=utf-8");
        //header('Content-Type:application/json; charset=utf-8');
        // $systemConfig = include APP_PATH . 'Common/Conf/systemConfig.php';

        // $this->assign("site", $systemConfig);


    }

	public function a($condition=array()){
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

	public function index(){
		$this->display();
	}

}

?>