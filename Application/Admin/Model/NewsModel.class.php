<?php

namespace Admin\Model;
use Think\Model;
use Org\Util\Category;
class NewsModel extends Model
{
	public function listNews($firstRow = 0, $listRows = 20, $where)
	{
		$M = m("News");
		$list = $M->field("`id`,`title`,`status`,`published`,`cid`,`aid`")->order("`published` DESC")->limit($firstRow, $listRows)->where($where)->select();
		$statusArr = array("审核状态", "已发布状态");
		$aidArr = m("Admin")->field("`aid`,`email`,`nickname`")->select();

		foreach ($aidArr as $k => $v ) {
			$aids[$v["aid"]] = $v;
		}

		unset($aidArr);
		$cidArr = m("Category")->field("`cid`,`name`")->select();

		foreach ($cidArr as $k => $v ) {
			$cids[$v["cid"]] = $v;
		}

		unset($cidArr);

		foreach ($list as $k => $v ) {
			$list[$k]["aidName"] = ($aids[$v["aid"]]["nickname"] == "" ? $aids[$v["aid"]]["email"] : $aids[$v["aid"]]["nickname"]);
			$list[$k]["status"] = $statusArr[$v["status"]];
			$list[$k]["cidName"] = $cids[$v["cid"]]["name"];
		}

		return $list;
	}

	public function category()
	{
		if (IS_POST) {
			$act = $_POST[act];
			$data = $_POST["data"];
			$data["name"] = addslashes($data["name"]);
			$M = m("Category");

			if ($act == "add") {
				unset($data[Model\cid]);

				if ($M->where($data)->count() == 0) {
					return $M->add($data) ? array("status" => 1, "info" => "分类 " . $data["name"] . " 已经成功添加到系统中", "url" => u("News/category", array("time" => time()))) : array("status" => 0, "info" => "分类 " . $data["name"] . " 添加失败");
				}
				else {
					return array("status" => 0, "info" => "系统中已经存在分类" . $data["name"]);
				}
			}
			else if ($act == "edit") {
				if (empty($data["name"])) {
					unset($data["name"]);
				}

				if ($data["pid"] == $data["cid"]) {
					unset($data["pid"]);
				}

				return $M->save($data) ? array("status" => 1, "info" => "分类 " . $data["name"] . " 已经成功更新", "url" => u("News/category", array("time" => time()))) : array("status" => 0, "info" => "分类 " . $data["name"] . " 更新失败");
			}
			else if ($act == "del") {
				unset($data["pid"]);
				unset($data["name"]);
				return $M->where($data)->delete() ? array("status" => 1, "info" => "分类 " . $data["name"] . " 已经成功删除", "url" => u("News/category", array("time" => time()))) : array("status" => 0, "info" => "分类 " . $data["name"] . " 删除失败");
			}
		}
		else {
			$cat = new Category("Category", array("cid", "pid", "name", "fullname"));
			return $cat->getList(NULL, 0, "sort desc");
		}
	}

	public function addNews()
	{
		$M = m("News");
		$data = $_POST["info"];
		$data["published"] = time();
		$data["aid"] = $_SESSION["my_info"]["aid"];

		if (empty($data["summary"])) {
			$data["summary"] = cutstr($data["content"], 200);
		}

		if ($M->add($data)) {
			return array("status" => 1, "info" => "已经发布", "url" => u("News/index"));
		}
		else {
			return array("status" => 0, "info" => "发布失败，请刷新页面尝试操作");
		}
	}

	public function edit()
	{
		$M = m("News");
		$data = $_POST["info"];
		$data["update_time"] = time();

		if ($M->save($data)) {
			return array("status" => 1, "info" => "已经更新", "url" => u("News/index"));
		}
		else {
			return array("status" => 0, "info" => "更新失败，请刷新页面尝试操作");
		}
	}
}


?>
