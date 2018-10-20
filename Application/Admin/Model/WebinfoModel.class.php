<?php
namespace Admin\Model;
use Think\Model;
use Org\Util\Category;
class WebinfoModel extends Model
{
	public function set_site_info()
	{
	}

	public function navigation()
	{
		if (IS_POST) {
			$act = $_POST[act];
			$data = $_POST["data"];
			$data["name"] = addslashes($data["name"]);
			$M = M("Navigation");

			if ($act == "add") {
				unset($data[lid]);

				if ($M->where($data)->count() == 0) {
					return $M->add($data) ? array("status" => 1, "info" => "导航 " . $data["name"] . " 已经成功添加到系统中", "url" => u("Webinfo/navigation", array("time" => time()))) : array("status" => 0, "info" => "导航 " . $data["name"] . " 添加失败");
				}
				else {
					return array("status" => 0, "info" => "系统中已经存在导航" . $data["name"]);
				}
			}
			else if ($act == "edit") {
				if (empty($data["name"])) {
					unset($data["name"]);
				}

				if ($data["pid"] == $data["lid"]) {
					unset($data["pid"]);
				}

				return $M->save($data) ? array("status" => 1, "info" => "导航 " . $data["name"] . " 已经成功更新", "url" => u("Webinfo/navigation", array("time" => time()))) : array("status" => 0, "info" => "导航 " . $data["name"] . " 更新失败");
			}
			else if ($act == "del") {
				unset($data["pid"]);
				unset($data["name"]);
				return $M->where($data)->delete() ? array("status" => 1, "info" => "导航 " . $data["name"] . " 已经成功删除", "url" => u("Webinfo/navigation", array("time" => time()))) : array("status" => 0, "info" => "导航 " . $data["name"] . " 删除失败");
			}
		}
		else {
			$cat = new Category("Navigation", array("lid", "pid", "name", "fullname"));
			return $cat->getList(NULL, 0, "sort desc");
		}
	}
}


?>
