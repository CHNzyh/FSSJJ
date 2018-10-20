<?php
namespace Admin\Model;
use Think\Model;
use Org\Util\Category;
class PfileModel extends Model{


    public $log;
    public function _initialize() {

    	$this->log = D('Log');
	}
	public function searchPfile(){
		//$result = M('Pfile')->select();

		$cat = new Category("Pfile", array("id", "pid", "dname", "fullname"));
		$temp = $cat->getList('',0,'dsort');

		return $temp;


	}

	public function addPfile(){
		$datas['dname'] = I('post.dname');
		$datas['dename'] = I('post.dename');
		$datas['pid'] = I('post.pid');

		$M = M('Pfile');

		if(0<$M->where('(dname ="'.$datas['dname'].'" or dename ="'.$datas['dename'].'") and pid='.$datas['pid'])->count()){
			return array('status'=>0,'info'=>'已经存在相同的文件类型名称（目录）!');
		}
		$datas['purl'] = '';
		if($datas['pid']>0){
			$pf = $M->where('id='.$datas['pid'])->find();
			if($pf['dename']!=''){
				$datas['purl'] = $pf['dename'].'/';
			}
		}
		$datas['dstatus'] = I('post.dstatus');
		$datas['dcontent'] = I('post.dcontent');
		$datas['dsort'] = I('post.dsort');
		$datas['time'] = time();
		if($M->add($datas)){
			$this->log->content = '添加文件类型';
        	$this->log->addLog();
			return array('status'=>1,'info'=>'文件类型添加成功！','url'=>u('Pfile/index'));

		}else{
			return array('status'=>0,'info'=>'添加失败，请重试！');
		}
	}
	public function editPfile(){
		$M = M("Pfile");
		$_POST['utime'] = time();
		$_POST['purl'] = '';
		if($_POST['pid']>0){
			$pf = $M->where('id='.$_POST['pid'])->find();
			if($pf['dename']!=''){
				$_POST['purl'] = $pf['dename'].'/';
			}
		}
		if ($M->save($_POST)) {
			$this->log->content = '编辑文件类型';
        	$this->log->addLog();
			return array("status" => 1, "info" => "文件类型更新成功！", "url" => u("Pfile/index"));
		}
		else {			
			return array("status" => 0, "info" => "更新失败，请重试");
		}		
	}

	public function opStatus(){
		$M = M('Pfile');
		$datas["id"] = (int) $_GET["id"];
		$datas["dstatus"] = ($_GET["status"] == 1 ? 0 : 1);

		if ($M->save($datas)) {
			$this->log->content = '修改文件类型状态';
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

	public function getPfile(){
		$M = M('Pfile');
		$result = $M->where('id>0')->select();

		foreach($result as $k => $v){
			$dp[$v['id']]=$v;
		}

		unset($result);
		return $dp;
	}

	public function filearray()
	{
		$pf = M('Pfile');

		$list = $pf->where('dstatus=1')->order('id')->select();
		$result = array();
		foreach($list as $key=>$value){
			$result[$value['id']] = $value;
		}
		return $result;
	}
	public function getPfilearray($info = array(),$title='根节点') {
       
        $cat = new \Org\Util\Category('Pfile', array('id', 'pid', 'dname', 'fullname'));
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