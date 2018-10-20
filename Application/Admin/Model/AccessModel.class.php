<?php
namespace Admin\Model;
use Think\Model;
use Org\Util\Category;
class AccessModel extends Model
{

	public $log;
    public function _initialize() {
    	$this->log = D('Log');
	}

	public function nodeList()
	{
		$cat = new Category("Node", array("id", "pid", "title", "fullname"));
		$temp = $cat->getList('',0,'sort');
		$level = array("1" => "项目（GROUP_NAME）", "2" => "模块(MODEL_NAME)", "3" => "操作（ACTION_NAME）");


		foreach ($temp as $k => $v ) {
			$temp[$k]["statusTxt"] = ($v["status"] == 1 ? "启用" : "禁用");
			$temp[$k]["chStatusTxt"] = ($v["status"] == 0 ? "启用" : "禁用");
			$temp[$k]["menuTxt"] = ($v["menu"] == 1 ? "显示" : "隐藏");
			$temp[$k]["chMenuTxt"] = ($v["menu"] == 0 ? "显示" : "隐藏");			
			$temp[$k]["level"] = $level[$v["level"]];
			$list[$v["id"]] = $temp[$k];
		}

		unset($temp);
		return $list;
	}

	public function roleList()
	{
		$M = m("Role");
		$list = $M->select();

		foreach ($list as $k => $v ) {
			$list[$k]["statusTxt"] = ($v["status"] == 1 ? "启用" : "禁用");
			$list[$k]["chStatusTxt"] = ($v["status"] == 0 ? "启用" : "禁用");
		}

		return $list;
	}

	public function opStatus($op = "Node")
	{
		$M = m("$op");
		if($op=='Admin'){
			$datas["aid"] = (int) $_GET["id"];
		}else{
			$datas["id"] = (int) $_GET["id"];	
		}
		
		$datas["status"] = ($_GET["status"] == 1 ? 0 : 1);

		if ($M->save($datas)) {
			return array(
			"status" => 1,
			"info"   => "处理成功",
			"data"   => array("status" => $datas["status"], "txt" => $datas["status"] == 1 ? "禁用" : "启动")
			);
			$this->log->content = '修改节点状态';
        	$this->log->addLog();
		}
		else {
			return array("status" => 0, "info" => "处理失败");
		}
	}

	public function opMenu()
	{
		$M = m('Node');
		$datas["id"] = (int) $_GET["id"];
		$datas["menu"] = ($_GET["menu"] == 1 ? 0 : 1);

		if ($M->save($datas)) {
			return array(
			"status" => 1,
			"info"   => "处理成功",
			"data"   => array("menu" => $datas["menu"], "txt" => $datas["menu"] == 1 ? "隐藏" : "显示")
			);
		}
		else {
			return array("status" => 0, "info" => "处理失败");
		}
	}	

	public function editNode()
	{
		$M = m("Node");
		return $M->save($_POST) ? array("status" => 1, info => "更新节点信息成功", "url" => u("Access/nodeList")) : array("status" => 0, info => "更新节点信息失败");
	}

	public function addNode()
	{
		$M = m("Node");
		return $M->add($_POST) ? array("status" => 1, info => "添加节点信息成功", "url" => u("Access/nodeList")) : array("status" => 0, info => "添加节点信息失败");
	}

	public function adminList()
	{
		$list = m("Admin")->select();

		foreach ($list as $k => $v ) {
			$list[$k]["statusTxt"] = ($v["status"] == 1 ? "启用" : "禁用");
		}

		return $list;
	}

	public function addAdmin()
	{
		if (!is_email($_POST["email"])) {
			return array("status" => 0, "info" => "邮件地址错误");
		}

		$datas = array();
		$M = m("Admin");
		$datas["email"] = trim($_POST["email"]);

		if (0 < $M->where("`email`='" . $datas["email"] . "'")->count()) {
			return array("status" => 0, "info" => "已经存在该账号");
		}

		$datas["pwd"] = encrypt(trim($_POST["pwd"]));
		$datas["time"] = time();
		$datas["remark"] = i("post.remark");
		$datas["nickname"] = i("post.nickname");
		$datas['department'] = i('post.department');

		if ($M->add($datas)) {
			m("RoleUser")->add(array("user_id" => $M->getLastInsID(), "role_id" => (int) $_POST["role_id"]));

			if (c("SYSTEM_EMAIL")) {
				$body = "你的账号已开通，登录地址：" . c("WEB_ROOT") . u("Public/index") . "<br/>登录账号是：" . $datas["email"] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;登录密码是：" . $_POST["pwd"];
				$info = (send_mail($datas["email"], "", "开通账号", $body) ? "添加新账号成功并已发送账号开通通知邮件" : "添加新账号成功但发送账号开通通知邮件失败");
			}
			else {
				$info = "账号已开通，请通知相关人员";
			}
			$this->log->content = '添加用户';
        	$this->log->addLog();

			return array("status" => 1, "info" => $info, "url" => u("Access/index"));
		}
		else {
			return array("status" => 0, "info" => "添加新账号失败，请重试");
		}
	}

	public function editAdmin()
	{
		$M = M("Admin");

		if (!empty($_POST["pwd"])) {
			$_POST["pwd"] = encrypt(trim($_POST["pwd"]));
		}
		else {
			unset($_POST["pwd"]);
		}

		$user_id = (int) $_POST["aid"];
		$role_id = (int) $_POST["role_id"];
		$roleStatus = M("RoleUser")->where("`user_id`=$user_id")->save(array("role_id" => $role_id));
		unset($_POST["role_id"]);
		$_POST['utime'] = time();
		if ($M->save($_POST)) {
			$this->log->content = '修改用户信息';
        	$this->log->addLog();
			return $roleStatus == TRUE ? array("status" => 1, "info" => "成功更新", "url" => u("Access/index")) : array("status" => 1, "info" => "用户信息已更新，用户所属组未更改", "url" => u("Access/index"));
		}
		else {
			return $roleStatus == TRUE ? array("status" => 1, "info" => "用户信息未更新，用户所属组已更新", "url" => u("Access/index")) : array("status" => 0, "info" => "更新失败，请重试");
		}
	}

	public function editRole()
	{
		$M = m("Role");
		$_POST['utime']=time();
		if ($M->save($_POST)) {
			$this->log->content = '编辑角色信息';
        	$this->log->addLog();
			return array("status" => 1, "info" => "成功更新", "url" => u("Access/roleList"));
		}
		else {			
			return array("status" => 0, "info" => "更新失败，请重试");
		}
	}

	public function addRole()
	{
		$M = m("Role");

		if ($M->add($_POST)) {
			$this->log->content = '添加角色信息';
        	$this->log->addLog();
			return array("status" => 1, "info" => "成功添加", "url" => u("Access/roleList"));
		}
		else {
			return array("status" => 0, "info" => "添加失败，请重试");
		}
	}

	public function changeRole()
	{
		$M = m("Access");
		$role_id = (int) $_POST["id"];
		$M->where("role_id=" . $role_id)->delete();
		$data = $_POST["data"];

		if (count($data) == 0) {
			return array("status" => 1, "info" => "清除所有权限成功", "url" => u("Access/roleList"));
		}

		$datas = array();

		foreach ($data as $k => $v ) {
			$tem = explode(":", $v);
			$datas[$k]["role_id"] = $role_id;
			$datas[$k]["node_id"] = $tem[0];
			$datas[$k]["level"] = $tem[1];
			$datas[$k]["pid"] = $tem[2];
		}

		if ($M->addAll($datas)) {
			$this->log->content = '设置角色权限';
        	$this->log->addLog();
			return array("status" => 1, "info" => "设置成功", "url" => u("Access/roleList"));
		}
		else {
			return array("status" => 0, "info" => "设置失败，请重试");
		}
	}
}


?>
