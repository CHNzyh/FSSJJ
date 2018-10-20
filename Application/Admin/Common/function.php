<?php

function toDate($time, $format = "Y-m-d H:i:s")
{
	if (empty($time)) {
		return "";
	}

	$format = str_replace("#", ":", $format);
	return date($format, $time);
}

function toDateYmd($time, $format = "Y-m-d")
{
	if (empty($time)) {
		return "";
	}

	$format = str_replace("#", ":", $format);
	return date($format, $time);
}

function filtName($fid)
{
	return m("Goods_filtrate")->where("fid=" . $fid)->getField("name");
}

function cateName($cid)
{
	return m("Goods_category")->where("cid=" . $cid)->getField("name");
}

function getExtendsHtml($cid, $gid)
{
	$extend = m("Goods_extend");
	$cate = m("Goods_category");
	$cLinkE = m("goods_category_extend");
	$cate->where("cid=" . $cid)->getField("pid");
	$interimCid = $cid;
	$catPath = array($cid);

	do {
		$interimCid = $cate->where("cid=" . $interimCid)->getField("pid");

		if ($interimCid != 0) {
			$catPath[] = $interimCid;
		}
	} while ($interimCid != 0);

	$catPath = array_reverse($catPath);
	$eHtmlUl = "";
	$eHtmlDiv = "";
	$textarea = array();
	$goods_fields = m("goods_fields");
	$regWhere = array(
		array(
			"cid" => array("in", $catPath)
			),
		array("eid" => 0)
		);

	if ($cLinkE->where($regWhere)->count()) {
		$region = c("goods_region");
	}
	else {
		$region = "no";
	}

	foreach ($catPath as $lk => $lv ) {
		$eidArr = $cLinkE->where("cid=" . $lv)->getField("eid", true);
		$eMap = $extend->where(array(
	"eid"    => array("in", $eidArr),
	"status" => 1
	))->order("rank desc")->select();

		foreach ($eMap as $ek => $ev ) {
			$rd = "r" . rand();
			$textarea[] = $rd;
			$eHtmlUl .= "<li class=\"ext\" eid=\"" . $ev["eid"] . "\">" . $ev["name"] . "</li>";

			if ($gid) {
				$fieldVal = $goods_fields->where(array("eid" => $ev["eid"], "gid" => $gid))->getField("default");
			}
			else {
				$fieldVal = $ev["default"];
			}

			$eHtmlDiv .= "<div class=\"hide ext\" eid=\"" . $ev["eid"] . "\"><textarea id=\"" . $rd . "\" style=\"width: 88%; height:400px;\" name=\"extend[" . $ev["eid"] . "]\">" . stripslashes($fieldVal) . "</textarea></div>";
		}
	}

	return array("eUrlHtml" => $eHtmlUl, "eDivHtml" => $eHtmlDiv, "textarea" => $textarea, "region" => $region);
}

function bidType($typ)
{
	$nowTime = time();

	switch ($typ) {
	case "biding":
		$bidtype = array(
			"starttime" => array("elt", $nowTime),
			"endtime"   => array("egt", $nowTime)
			);
		$saytyp = array("ch" => "正在拍卖", "get" => "biding");
		break;

	case "bidend":
		$bidtype = array(
			"endtime" => array("lt", $nowTime)
			);
		$saytyp = array("ch" => "已结束拍卖", "get" => "bidend");
		break;

	case "future":
		$bidtype = array(
			"starttime" => array("gt", $nowTime)
			);
		$saytyp = array("ch" => "未开始拍卖", "get" => "future");
		break;
	}

	return array("bidType" => $bidtype, "saytyp" => $saytyp);
}

function getFiltrateHtml($cid, $filtStr)
{
	$filtrate = m("Goods_filtrate");
	$cate = m("Goods_category");
	$cLinkF = m("Goods_category_filtrate");
	$filtArr = explode("_", $filtStr);
	$cate->where("cid=" . $cid)->getField("pid");
	$interimCid = $cid;
	$catPath = array($cid);

	do {
		$interimCid = $cate->where("cid=" . $interimCid)->getField("pid");

		if ($interimCid != 0) {
			$catPath[] = $interimCid;
		}
	} while ($interimCid != 0);

	$catPath = array_reverse($catPath);

	foreach ($catPath as $lk => $lv ) {
		$fidArr = $cLinkF->where("cid=" . $lv)->getField("fid", true);
		$filtMap = $filtrate->where(array(
	"fid" => array("in", $fidArr)
	))->order("sort desc")->select();
		$filtBoxClass = ($lk == 0 ? "filtbox" : "filtbox child");

		if ($filtMap) {
			$filtHtml .= "<div class=\"" . $filtBoxClass . "\">";

			foreach ($filtMap as $fk => $fv ) {
				$filtHtml .= "<ul class=\"clearfix\">";
				$filtHtml .= "<li><span>" . $fv["name"] . ":</span></li>";
				$filtHtml .= "<li><a class=\"filtParent";
				if (empty($filtStr) || in_array($fv["fid"], $filtArr)) {
					$filtHtml .= " current";
				}

				$filtHtml .= "\" fid=\"" . $fv["fid"] . "\" href=\"javascript:void(0);\">不限</a></li>";
				$childMap = $filtrate->where("pid=" . $fv["fid"])->select();

				foreach ($childMap as $ck => $cv ) {
					$filtHtml .= "<li><a href=\"javascript:void(0);\" fid=\"" . $cv["fid"] . "\" class=\"filtParent";
					$display = "none";

					if (in_array($cv["fid"], $filtArr)) {
						$filtHtml .= " current";
						$display = "block";
					}

					$filtHtml .= "\">" . $cv["name"] . "</a></li>";
					$childLi .= getchildhtml($cv["fid"], $display, $filtArr);
				}

				$filtHtml .= "</ul>";
				$filtHtml .= $childLi;
				$childLi = "";
				$display = "none";
			}

			$filtHtml .= "</div>";
		}
	}

	return $filtHtml;
}

function countChild($fid)
{
	return m("Goods_filtrate")->where("pid=" . $fid)->count();
}

function getChildHtml($fid, $display, $filtArr)
{
	if (countchild($fid) != 0) {
		$childArr = m("Goods_filtrate")->where("pid=" . $fid)->order("sort desc")->select();
		$childStr = "<div class=\"filtLi\" style=\"display:" . $display . ";\" fid=\"" . $fid . "\">";
		$childStr .= "<ul class=\"clearfix filtChild\">";

		foreach ($childArr as $ck => $cv ) {
			$childStr .= "<li><a class=\"filtParent";
			$displaySun = "none";

			if (in_array($cv["fid"], $filtArr)) {
				$childStr .= " current";
				$displayCh = "block";
			}
			else {
				$displayCh = "none";
			}

			$childStr .= "\" fid=\"" . $cv["fid"] . "\" href=\"javascript:void(0);\">" . $cv["name"];

			if (countchild($cv["fid"]) != 0) {
				$childStr .= "(" . countchild($cv["fid"]) . ")";
			}

			$childStr .= "</a></li>";
			$childSun .= getchildhtml($cv["fid"], $displayCh, $filtArr);
		}

		$childStr .= "</ul>";
		$childStr .= $childSun;
		$childStr .= "</div>";
		return $childStr;
	}

	return NULL;
}


?>
