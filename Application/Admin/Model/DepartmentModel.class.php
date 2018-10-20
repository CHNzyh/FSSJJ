<?php
namespace Admin\Model;
use Think\Model;
use Org\Util\Category;
class DepartmentModel extends Model{


    public $log;
    public function _initialize() {

    	$this->log = D('Log');
	}
	public function searchDepartment(){
		$result = M('Department')->select();

		$cat = new Category("Department", array("id", "pid", "dname", "fullname"));
		$temp = $cat->getList('',0,'dsort');
		return $temp;


	}

	public function addDepartment(){
		$datas['dname'] = I('post.dname');
		$datas['dename'] = I('post.dename');

		$M = M('Department');
		if(0<$M->where('dname ="'.$datas['dname'].'" or dename ="'.$datas['dename'].'"')->count()){
			return array('status'=>0,'info'=>'已经存在相同的部门名称（英文）!');
		}
		$datas['dstatus'] = I('post.dstatus');
		$datas['dcontent'] = I('post.dcontent');
		$datas['pid'] = I('post.pid');
		$datas['dsort'] = I('post.dsort');
		$datas['time'] = time();
		if($M->add($datas)){
			$this->log->content = '添加部门';
        	$this->log->addLog();
			return array('status'=>1,'info'=>'部门添加成功！','url'=>u('Department/index'));

		}else{
			return array('status'=>0,'info'=>'添加失败，请重试！');
		}
	}
	public function editDepartment(){
		$M = M("Department");
		$_POST['utime'] = time();
		if ($M->save($_POST)) {
			$this->log->content = '编辑部门';
        	$this->log->addLog();
			return array("status" => 1, "info" => "部门更新成功！", "url" => u("Department/index"));
		}
		else {			
			return array("status" => 0, "info" => "更新失败，请重试");
		}		
	}

	public function opStatus(){
		$M = M('Department');
		$datas["id"] = (int) $_GET["id"];
		$datas["dstatus"] = ($_GET["status"] == 1 ? 0 : 1);

		if ($M->save($datas)) {
			$this->log->content = '修改部门状态';
        	$this->log->addLog();
			return array(
						"status" => 1,
						"info"   => "处理成功",
						"data"   => array("status" => $datas["dstatus"], "txt" => $datas["dstatus"] == 1 ? "禁用" : "启动")
						);
		}
		else {
			return array("status" => 0, "info" => "处理失败");
		}		
	}

	public function getDepartment(){
		$M = M('Department');
		$result = $M->where('id>0')->select();

		foreach($result as $k => $v){
			$dp[$v['id']]=$v;
		}

		unset($result);
		return $dp;
	}

	
     public function getDepartmentarray($info = array(),$title='根节点') {
       
        $cat = new Category('Department', array('id', 'pid', 'dname', 'fullname'));
        $list = $cat->getList();
        $info['pidOption'] = '<option value="0">'.$title.'</option>';               
        foreach ($list as $k => $v) {
            $disabled = $v['id'] == $info['id'] ? ' disabled="disabled"' : "";
            $selected = $v['id'] == $info['pid'] ? ' selected="selected"' : "";
            $info['pidOption'].='<option value="' . $v['id'] . '"' . $selected . $disabled . '>' . $v['fullname'] . '</option>';
        }
        return $info;
     }	


}
?>