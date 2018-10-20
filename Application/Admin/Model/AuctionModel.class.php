<?php
namespace Admin\Model;
use Think\Model\ViewModel;
use Org\Util\Category;
class AuctionModel extends ViewModel
{
	protected $viewFields = array(
		"Auction" => array(0 => "pid", 1 => "gid", 2 => "type", 3 => "pname", 4 => "starttime", 5 => "endtime", 6 => "uid", "_type" => "LEFT"),
		"Goods"   => array(0 => "cid", 1 => "aid", "_on" => "Auction.gid = Goods.id")
		);

	public function listAuction($firstRow = 0, $listRows = 20, $where, $od)
	{
		$list = $this->limit($firstRow . "," . $listRows)->order($od)->where($where)->select();
		$aidArr = m("Admin")->field("`aid`,`email`,`nickname`")->select();

		foreach ($aidArr as $k => $v ) {
			$aids[$v["aid"]] = $v;
		}

		unset($aidArr);
		$cidArr = m("Goods_category")->field("`cid`,`name`")->select();

		foreach ($cidArr as $k => $v ) {
			$cids[$v["cid"]] = $v;
		}

		unset($cidArr);
		$cat = new Category("Goods_category", array("cid", "pid", "name", "fullname"));

		foreach ($list as $k => $v ) {
			$list[$k]["aidName"] = ($aids[$v["aid"]]["nickname"] == "" ? $aids[$v["aid"]]["email"] : $aids[$v["aid"]]["nickname"]);
			$list[$k]["cidName"] = $cids[$v["cid"]]["name"];
			$uPath = $cat->getPath($v["cid"]);
			$list[$k]["pidName"] = $uPath[0]["name"];
		}

		return $list;
	}

	public function category()
	{
		if (IS_POST) {
			$act = $_POST[act];
			$data = $_POST["data"];
			$data["name"] = addslashes($data["name"]);
			$nameArr = explode(",", addslashes($data["name"]));
			$M = m("Goods_category");

			if ($act == "add") {
				foreach ($nameArr as $nk => $nv ) {
					if ($nv != "") {
						$newData = array("pid" => $data["pid"], "name" => $nv);

						if ($M->where($newData)->count() == 0) {
							$newData["ico"] = $data["ico"];
							$M->add($newData) ? $successName .= $nv . "," : $errorName .= $nv . ",";
						}
						else {
							$reName .= $nv . ",";
						}
					}
				}

				if ($successName != "") {
					$info = $successName . "已经成功添加到系统中<br/>";

					if ($errorName != "") {
						$info .= $errorName . "添加失败<br/>";
					}
					else if ($reName != "") {
						$info .= $reName . "已存在并跳过<br/>";
					}

					return array("status" => 1, "info" => $info, "url" => u("Goods/category", array("time" => time())));
				}
				else {
					if ($errorName != "") {
						$info .= $errorName . "添加失败<br/>";
					}
					else if ($reName != "") {
						$info .= $reName . "已存在并跳过<br/>";
					}

					return array("status" => 0, "info" => $info);
				}
			}
			else if ($act == "edit") {
				if (empty($data["name"])) {
					unset($data["name"]);
				}

				if ($data["pid"] == $data["cid"]) {
					unset($data["pid"]);
				}

				return $M->save($data) ? array("status" => 1, "info" => "分类 " . $data["name"] . " 已经成功更新", "url" => u("Goods/category", array("time" => time()))) : array("status" => 0, "info" => "分类 " . $data["name"] . " 更新失败");
			}
			else if ($act == "del") {
				unset($data["pid"]);
				unset($data["name"]);
				return $M->where($data)->delete() ? array("status" => 1, "info" => "分类 " . $data["name"] . " 已经成功删除", "url" => u("Goods/category", array("time" => time()))) : array("status" => 0, "info" => "分类 " . $data["name"] . " 删除失败");
			}
		}
		else {
			$cat = new Category("Goods_category", array("cid", "pid", "name", "fullname"));
			return $cat->getList();
		}
	}

	public function filtrate()
	{
		if (IS_POST) {
			$act = $_POST[act];
			$data = $_POST["data"];
			$data["name"] = addslashes($data["name"]);
			$nameArr = explode(",", addslashes($data["name"]));
			$M = m("Goods_filtrate");

			if ($act == "add") {
				foreach ($nameArr as $nk => $nv ) {
					if ($nv != "") {
						$newData = array("pid" => $data["pid"], "name" => $nv);

						if ($M->where($newData)->count() == 0) {
							$M->add($newData) ? $successName .= $nv . "," : $errorName .= $nv . ",";
						}
						else {
							$reName .= $nv . ",";
						}
					}
				}

				if ($successName != "") {
					$info = $successName . "已经成功添加到系统中<br/>";

					if ($errorName != "") {
						$info .= $errorName . "添加失败<br/>";
					}
					else if ($reName != "") {
						$info .= $reName . "已存在并跳过<br/>";
					}

					return array("status" => 1, "info" => $info, "url" => u("Goods/filtrate", array("time" => time())));
				}
				else {
					if ($errorName != "") {
						$info .= $errorName . "添加失败<br/>";
					}
					else if ($reName != "") {
						$info .= $reName . "已存在并跳过<br/>";
					}

					return array("status" => 0, "info" => $info);
				}
			}
			else if ($act == "edit") {
				if (empty($data["name"])) {
					unset($data["name"]);
				}

				if ($data["pid"] == $data["fid"]) {
					unset($data["pid"]);
				}

				return $M->save($data) ? array("status" => 1, "info" => "条件 " . $data["name"] . " 已经成功更新", "url" => u("Goods/filtrate", array("time" => time()))) : array("status" => 0, "info" => "条件 " . $data["name"] . " 更新失败");
			}
			else if ($act == "del") {
				unset($data["pid"]);
				unset($data["name"]);
				return $M->where($data)->delete() ? array("status" => 1, "info" => "条件 " . $data["name"] . " 已经成功删除", "url" => u("Goods/filtrate", array("time" => time()))) : array("status" => 0, "info" => "条件 " . $data["name"] . " 删除失败");
			}
		}
		else {
			$cat = new Category("Goods_filtrate", array("fid", "pid", "name", "fullname"));
			return $cat->getList(NULL, 0, "sort desc");
		}
	}

	public function cate_filt()
	{
		$act = i("post.act");
		$data = i("post.data");
		$cate = m("Goods_category");
		$filt = m("Goods_filtrate");
		$cName = ($data["cid"] != 0 ? $cate->where("cid=" . $data["cid"])->getField("name") : "顶级分类");
		$fName = ($data["fid"] != 0 ? $filt->where("fid=" . $data["fid"])->getField("name") : "顶级条件");
		$M = m("Goods_category_filtrate");

		if ($act == "add") {
			if ($M->where($data)->count() == 0) {
				if (($data["cid"] == 0) || ($data["fid"] == 0)) {
					if (($data["cid"] == 0) & ($data["fid"] == 0)) {
						$cateMap = $cate->where("pid=0")->select();
						$filtMap = $filt->where("pid=0")->select();
						$repCount = 0;

						foreach ($cateMap as $ck => $cv ) {
							foreach ($filtMap as $fk => $fv ) {
								$autoData = array();
								$autoData = array("cid" => $cv["cid"], "fid" => $fv["fid"]);

								if ($M->where($autoData)->count() == 0) {
									$M->add($autoData);
								}
								else {
									$repCount += 1;
								}
							}

							if ($repCount != 0) {
								return array("status" => 1, "info" => "关联成功，" . $repCount . "个重复关联已跳过", "url" => u("Goods/cate_filt", array("time" => time())));
							}
						}
					}

					if (($data["cid"] != 0) & ($data["fid"] == 0)) {
						$filtMap = $filt->where("pid=0")->select();
						$repCount = 0;

						foreach ($filtMap as $fk => $fv ) {
							$autoData = array();
							$autoData = array("cid" => $data["cid"], "fid" => $fv["fid"]);

							if ($M->where($autoData)->count() == 0) {
								$M->add($autoData);
							}
							else {
								$repCount += 1;
							}
						}

						if ($repCount != 0) {
							return array("status" => 1, "info" => "关联成功，" . $repCount . "个重复关联已跳过", "url" => u("Goods/cate_filt", array("time" => time())));
						}
					}

					if (($data["cid"] == 0) & ($data["fid"] != 0)) {
						$cateMap = $cate->where("pid=0")->select();
						$repCount = 0;

						foreach ($cateMap as $ck => $cv ) {
							$autoData = array();
							$autoData = array("cid" => $cv["cid"], "fid" => $data["fid"]);

							if ($M->where($autoData)->count() == 0) {
								$M->add($autoData);
							}
							else {
								$repCount += 1;
							}
						}

						if ($repCount != 0) {
							return array("status" => 1, "info" => "关联成功，" . $repCount . "个重复关联已跳过", "url" => u("Goods/cate_filt", array("time" => time())));
						}
					}

					return array("status" => 1, "info" => $cName . "<---->" . $fName . "——关联成功", "url" => u("Goods/cate_filt", array("time" => time())));
				}

				return $M->add($data) ? array("status" => 1, "info" => $cName . "<---->" . $fName . "——关联成功", "url" => u("Goods/cate_filt", array("time" => time()))) : array("status" => 0, "info" => $cName . "<---->" . $fName . "——关联失败");
			}
			else {
				return array("status" => 0, "info" => $cName . "<---->" . $fName . "已关联，无需重复");
			}
		}
	}

	public function addGoods()
	{
		$M = m("Goods");
		$data = $_POST["info"];
		$region = i("post.region");

		if ($region["province"] != "") {
			$data = array_merge($data, $region);
		}

		$e_data = i("post.extend");
		$data["published"] = time();
		$data["pictures"] = implode("|", i("post.pic"));
		$data["aid"] = $_SESSION["my_info"]["aid"];

		if ($gid = $M->add($data)) {
			foreach ($e_data as $edk => $edv ) {
				m("Goods_fields")->data(array("gid" => $gid, "eid" => $edk, "default" => $edv))->add();
			}

			return array("status" => 1, "info" => "已经发布", "url" => u("Goods/index"));
		}
		else {
			return array("status" => 0, "info" => "发布失败，请刷新页面尝试操作");
		}
	}

	public function edit()
	{
		$M = m("Goods");
		$goods_fields = m("Goods_fields");
		$data = $_POST["info"];
		$region = i("post.region");

		if ($region["province"] != "") {
			$data = array_merge($data, $region);
		}

		$data["pictures"] = implode("|", i("post.pic"));
		$data["update_time"] = time();
		$e_data = i("post.extend");

		if ($M->save($data)) {
			foreach ($e_data as $edk => $edv ) {
				$goods_fields->where(array("gid" => $data["id"], "eid" => $edk))->setField("default", $edv);
			}

			return array("status" => 1, "info" => "已经更新", "url" => u("Goods/index"));
		}
		else {
			return array("status" => 0, "info" => "更新失败，请刷新页面尝试操作");
		}
	}

	public function fields_add()
	{
		$M = m("goods_extend");
		$info = i("post.info");

		if (empty($info["id"])) {
			unset($info["id"]);

			if ($M->add($info)) {
				return array("status" => 1, "info" => "添加成功", "url" => u("Goods/fields_list"));
			}
			else {
				return array("status" => 0, "info" => "添加失败，请刷新页面尝试操作");
			}
		}
		else if ($M->save($info)) {
			return array("status" => 1, "info" => "已经更新", "url" => u("Goods/fields_list"));
		}
		else {
			return array("status" => 0, "info" => "更新失败，请刷新页面尝试操作");
		}
	}

	public function cate_extend()
	{
		$act = i("post.act");
		$data = i("post.data");
		$cate = m("Goods_category");
		$extend = m("Goods_extend");
		$cName = ($data["cid"] != 0 ? $cate->where("cid=" . $data["cid"])->getField("name") : "频道");

		if ($data["eid"] != "") {
			if ($data["eid"] != 0) {
				$eName = $extend->where("eid=" . $data["eid"])->getField("name");
			}
			else {
				$eName = "地区";
			}
		}
		else {
			$eName = "所有字段";
		}

		$M = m("Goods_category_extend");

		if ($act == "add") {
			if ($M->where($data)->count() == 0) {
				if (($data["cid"] == 0) || ($data["eid"] == "")) {
					if (($data["cid"] == 0) & ($data["eid"] == "")) {
						$cateMap = $cate->where("pid=0")->select();
						$extendMap = $extend->select();
						$repCount = 0;

						foreach ($cateMap as $ck => $cv ) {
							foreach ($extendMap as $fk => $fv ) {
								$autoData = array();
								$autoData = array("cid" => $cv["cid"], "eid" => $fv["eid"]);

								if ($M->where($autoData)->count() == 0) {
									$M->add($autoData);
								}
								else {
									$repCount += 1;
								}
							}

							$region = array("cid" => $cv["cid"], "eid" => 0);

							if ($M->where($region)->count() == 0) {
								$M->add($region);
							}
							else {
								$repCount += 1;
							}

							if ($repCount != 0) {
								return array("status" => 1, "info" => "关联成功，" . $repCount . "个重复关联已跳过", "url" => u("Goods/cate_extend", array("time" => time())));
							}
						}
					}

					if (($data["cid"] != 0) & ($data["eid"] == "")) {
						$extendMap = $extend->where("pid=0")->select();
						$repCount = 0;

						foreach ($filtMap as $fk => $fv ) {
							$autoData = array();
							$autoData = array("cid" => $data["cid"], "eid" => $fv["eid"]);

							if ($M->where($autoData)->count() == 0) {
								$M->add($autoData);
							}
							else {
								$repCount += 1;
							}
						}

						$region = array("cid" => $data["cid"], "eid" => 0);

						if ($M->where($region)->count() == 0) {
							$M->add($region);
						}
						else {
							$repCount += 1;
						}

						if ($repCount != 0) {
							return array("status" => 1, "info" => "关联成功，" . $repCount . "个重复关联已跳过", "url" => u("Goods/cate_extend", array("time" => time())));
						}
					}

					if (($data["cid"] == 0) & ($data["eid"] != "")) {
						$cateMap = $cate->where("pid=0")->select();
						$repCount = 0;

						foreach ($cateMap as $ck => $cv ) {
							$autoData = array();
							$autoData = array("cid" => $cv["cid"], "eid" => $data["eid"]);

							if ($M->where($autoData)->count() == 0) {
								$M->add($autoData);
							}
							else {
								$repCount += 1;
							}
						}

						if ($repCount != 0) {
							return array("status" => 1, "info" => "关联成功，" . $repCount . "个重复关联已跳过", "url" => u("Goods/cate_extend", array("time" => time())));
						}
					}

					return array("status" => 1, "info" => $cName . "<---->" . $eName . "——关联成功", "url" => u("Goods/cate_extend", array("time" => time())));
				}

				return $M->add($data) ? array("status" => 1, "info" => $cName . "<---->" . $eName . "——关联成功", "url" => u("Goods/cate_extend", array("time" => time()))) : array("status" => 0, "info" => $cName . "<---->" . $eName . "——关联失败");
			}
			else {
				return array("status" => 0, "info" => $cName . "<---->" . $eName . "已关联，无需重复");
			}
		}
	}
}


?>
