<?php

namespace Admin;

class Model\AdvertisingModel extends Think\Model\ViewModel
{
	protected $viewFields = array(
		"Advertising"          => array(0 => "id", 1 => "name", 2 => "type", 3 => "status", 4 => "sort", "_type" => "LEFT"),
		"Advertising_position" => array("name" => "position", "id" => "pid", "_on" => "Advertising.pid = Advertising_position.id")
		);

	public function listAdvertising($firstRow = 0, $listRows = 20, $where = array())
	{
		$list = $this->order("`pid` DESC , `sort` DESC")->where($where)->limit("$firstRow , $listRows")->select();
		return $list;
	}

	public function listPosition($firstRow = 0, $listRows = 20)
	{
		$M = admin\model\m("Advertising_position");
		$field = array("id", "tagname", "name", "width", "height");
		$list = $M->field($field)->order("`id` DESC")->limit("$firstRow , $listRows")->select();
		return $list;
	}

	public function addAdvertising()
	{
		$M = admin\model\m("Advertising");
		$data = admin\model\i("post.info");
		$data["desc"] = admin\model\str_replace(array("\r\n", "\r", "\n"), "", $data["desc"]);
		$data["code"] = admin\model\str_replace(array("\r\n", "\r", "\n"), "", $data["code"]);
		$data["adv_start_time"] = admin\model\strtotime($data["adv_start_time"]);
		$data["adv_end_time"] = admin\model\strtotime($data["adv_end_time"]);

		if ($M->add($data)) {
			return array("status" => 1, "info" => "已经添加", "url" => admin\model\u("Advertising/index"));
		}
		else {
			return array("status" => 0, "info" => "发布失败，请刷新页面尝试操作");
		}
	}

	public function editAdvertising()
	{
		$M = admin\model\m("Advertising");
		$data = admin\model\i("post.info");
		$data["desc"] = admin\model\str_replace(array("\r\n", "\r", "\n"), "", $data["desc"]);
		$data["code"] = admin\model\str_replace(array("\r\n", "\r", "\n"), "", $data["code"]);
		$data["adv_start_time"] = admin\model\strtotime($data["adv_start_time"]);
		$data["adv_end_time"] = admin\model\strtotime($data["adv_end_time"]);

		if ($M->save($data)) {
			return array("status" => 1, "info" => "已经更新", "url" => admin\model\u("Advertising/index"));
		}
		else {
			return array("status" => 0, "info" => "更新失败，请刷新页面尝试操作");
		}
	}

	public function addPosition()
	{
		$M = admin\model\m("Advertising_position");
		$data = $_POST["info"];

		if ($M->add($data)) {
			return array("status" => 1, "info" => "已经添加", "url" => admin\model\u("Advertising/position"));
		}
		else {
			return array("status" => 0, "info" => "发布失败，请刷新页面尝试操作");
		}
	}

	public function editPosition()
	{
		$M = admin\model\m("Advertising_position");
		$data = $_POST["info"];

		if ($M->save($data)) {
			return array("status" => 1, "info" => "已经更新", "url" => admin\model\u("Advertising/position"));
		}
		else {
			return array("status" => 0, "info" => "更新失败，请刷新页面尝试操作");
		}
	}

	public function getPosName()
	{
		$M = admin\model\m("Advertising_position");
		$field = array("id", "name", "width", "height");
		return $M->field($field)->select();
	}
}


?>
