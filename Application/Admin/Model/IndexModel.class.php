<?php

namespace Admin;

class Model\IndexModel extends Think\Model
{
	public function my_info($datas)
	{
		$M = admin\model\m("Admin");

		if (admin\model\md5(admin\model\c("AUTH_CODE") . admin\model\md5($datas["pwd0"])) != $_SESSION["my_info"]["pwd"]) {
			return array("status" => 0, "info" => "旧密码错误");
		}

		if (admin\model\trim($datas["pwd"]) == "") {
			return array("status" => 0, "info" => "密码不能为空");
		}

		if (admin\model\trim($datas["pwd"]) != admin\model\trim($datas["pwd1"])) {
			return array("status" => 0, "info" => "两次密码不一致");
		}

		$data["aid"] = $_SESSION["my_info"]["aid"];
		$data["pwd"] = admin\model\md5(admin\model\c("AUTH_CODE") . admin\model\md5($datas["pwd"]));

		if ($M->save($data)) {
			admin\model\setcookie("$this->loginMarked", Model\NULL, -3600, "/");
			unset($_SESSION["$this->loginMarked"]);
			unset($_COOKIE["$this->loginMarked"]);
			return array("status" => 1, "info" => "你的密码已经成功修改，请重新登录", "url" => admin\model\u("Access/index"));
		}
		else {
			return array("status" => 0, "info" => "密码修改失败");
		}
	}
}


?>
