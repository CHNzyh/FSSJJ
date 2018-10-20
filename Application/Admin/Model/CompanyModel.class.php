<?php
namespace Admin\Model;
use Think\Model;

class CompanyModel extends Model{



    public $log;
    public function _initialize() {

    	$this->log = D('Log');
	}
	public function addCompany(){
		$datas['cname'] = I('post.cname');
		$datas['cename'] = I('post.cename');

		$M = M('Company');
		if(0<$M->where('cname ="'.$datas['cname'].'" or cename ="'.$datas['cename'].'"')->count()){
			return array('status'=>0,'info'=>'已经存在相同的企业名称（英文）!');
		}
		$datas['cstatus'] = I('post.cstatus');
		$datas['ccontent'] = I('post.ccontent');
		$datas['cphone'] = I('post.cphone');
		$datas['ccontact'] = I('post.ccontact');
		$datas['caddress'] = I('post.caddress');
		$datas['cemail'] = I('post.cemail');
		$datas['ctime'] = time();
		if($M->add($datas)){
			$this->log->content = '添加审计企业';
        	$this->log->addLog();
			return array('status'=>1,'info'=>'企业添加成功！','url'=>u('Company/index'));

		}else{
			return array('status'=>0,'info'=>'添加失败，请重试！');
		}		

	}

	public function editCompany(){
		$M = M("Company");
		$_POST['utime'] = time();
		if ($M->save($_POST)) {
			$this->log->content = '编辑企业';
        	$this->log->addLog();
			return array("status" => 1, "info" => "企业更新成功！", "url" => u("Company/index"));
		}
		else {			
			return array("status" => 0, "info" => "更新失败，请重试");
		}		
	
	}

	public function searchCompany($data=array()){

        $M = M('Company');
        if(IS_POST){
        	$keys = I('post.');

        	$where = array($keys[field]=>array('LIKE','%'.$keys['keyword'].'%'));
    	}
        if($data['status']==1) $where['cstatus'] =1;//不显示禁用企业

        $count = $M->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE')); 

        $list=$M->where($where)->order('id desc')->limit($pConf['first'], $pConf['list'])->select();
       
        $keys['count']=$count;
        $data['keys']=$keys;
        $data['page'] = $pConf['show'];
        $data['list'] = $list;
        C('TOKEN_ON',false);

        return $data;
	}

	public function opStatus(){

		$M = M('Company');
		$datas["id"] = (int) $_GET["id"];
		$datas["cstatus"] = ($_GET["status"] == 1 ? 0 : 1);

		if ($M->save($datas)) {
			$this->log->content = '修改企业状态';
        	$this->log->addLog();
			return array(
						"status" => 1,
						"info"   => "处理成功",
						"data"   => array("status" => $datas["cstatus"], "txt" => $datas["cstatus"] == 1 ? "禁用" : "启动")
						);
		}
		else {
			return array("status" => 0, "info" => "处理失败");
		}		


	}
}
?>