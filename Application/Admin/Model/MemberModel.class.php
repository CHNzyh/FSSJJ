<?php

namespace Admin\Model;
use Think\Model;
class MemberModel extends Model
{
	public function addMember()
	{
		$m_member = m("Member");
		$data = i("post.info");
		$uid = i("post.uid");
		$sm["email"] = $data["email"];
		$sm["uid"] = array("neq", $uid);

		if ($data["email"] != "") {
			if ($m_member->where($sm)->count()) {
				return array("status" => 0, "info" => "邮箱地址已存在！");
				exit();
			}

			if (!is_email($data["email"])) {
				return array("status" => 0, "info" => "邮箱格式错误！");
				exit();
			}
		}

		if ($data["pwd"]) {
			if (strlen($data["pwd"]) < 6) {
				return array("status" => 0, "info" => "密码少于6位！");
				exit();
			}

			$data["pwd"] = encrypt($data["pwd"]);
		}
		else {
			unset($data["pwd"]);
		}

		if ($uid) {
			$map["uid"] = $uid;

			if ($m_member->where($map)->save($data)) {
				return array("status" => 1, "info" => "修改会员成功", "url" => u("Member/index"));
				exit();
			}
			else {
				return array("status" => 0, "info" => "修改会员失败");
				exit();
			}
		}
		else {
			if (empty($data["pwd"])) {
				return array("status" => 0, "info" => "请输入密码！");
				exit();
			}

			if ($m_member->add($data)) {
				return array("status" => 1, "info" => "添加会员成功", "url" => u("Member/index"));
				exit();
			}
			else {
				return array("status" => 0, "info" => "添加会员失败");
				exit();
			}
		}
	}

	public function addFeedback()
	{
		$data = i("post.data");
		$act = i("post.act");
		$M = m("feedback");

		if ($act == "add") {
			if ($M->where($data)->count() == 0) {
				return $M->add($data) ? array("status" => 1, "info" => "分类 " . $data["name"] . " 已经成功添加到系统中", "url" => u("Member/feedback", array("time" => time()))) : array("status" => 0, "info" => "推广类型 " . $data["name"] . " 添加失败");
			}
			else {
				return array("status" => 0, "info" => "系统中已经存在推广类型 " . $data["name"]);
			}
		}
		else if ($act == "edit") {
			return $M->save($data) ? array("status" => 1, "info" => "推广类型 " . $data["name"] . " 已经成功更新", "url" => u("Member/feedback", array("time" => time()))) : array("status" => 0, "info" => "推广类型 " . $data["name"] . " 更新失败");
		}
		else {
			unset($data["name"]);
			return $M->where($data)->delete() ? array("status" => 1, "info" => "推广类型 " . $data["name"] . " 已经成功删除", "url" => u("Member/feedback", array("time" => time()))) : array("status" => 0, "info" => "推广类型 " . $data["name"] . " 删除失败");
		}
	}

	public function recharge_pledge($info)
	{
		switch ($info["act"]) {
		case "add":
			if (m("member")->where(array("uid" => $info["uid"]))->setInc("wallet_pledge", $info["money"])) {
				$matter = array("type" => "deposit", "tid" => 0, "paytype" => "充值", "remark" => $info["remark"]);
				$data = array("order_no" => createno("AA"), "uid" => $info["uid"], "time" => time(), "matter" => serialize($matter), "income" => $info["money"]);

				if (m("member_pledge_bill")->add($data)) {
					sendsms($data["uid"], "系统发送", "您好，后台管理员为您" . $matter["paytype"] . "保证金" . $data["income"] . "元！备注：" . $matter["remark"]);
					return array("status" => 1, "info" => "已成功充值", "url" => Model\__SELF__);
				}
			}

			break;

		case "minus":
			$m = m("member");
			$pledge = $m->where(array("uid" => $info["uid"]))->field("wallet_pledge,wallet_pledge_freeze")->find();
			$available = $pledge["wallet_pledge"] - $pledge["wallet_pledge_freeze"];

			if ($info["money"] <= $available) {
				if ($m->where(array("uid" => $info["uid"]))->setDec("wallet_pledge", $info["money"])) {
					$matter = array("type" => "deposit", "tid" => 0, "paytype" => "扣除", "remark" => $info["remark"]);
					$data = array("order_no" => createno("AM"), "uid" => $info["uid"], "time" => time(), "matter" => serialize($matter), "expend" => $info["money"]);

					if (m("member_pledge_bill")->add($data)) {
						sendsms($data["uid"], "系统发送", "您好，后台管理员为您" . $matter["paytype"] . "保证金" . $data["expend"] . "元！备注：" . $matter["remark"]);
						return array("status" => 1, "info" => "已扣除成功", "url" => Model\__SELF__);
					}
				}
			}
			else {
				return array("status" => 0, "info" => "账户可扣除（可用资金）不足，扣除失败", "url" => Model\__SELF__);
			}

			break;

		case "freeze":
			$m = m("member");
			$wr = array("uid" => $info["uid"]);
			$pledge = $m->where($wr)->field("wallet_pledge,wallet_pledge_freeze")->find();
			$available = $pledge["wallet_pledge"] - $pledge["wallet_pledge_freeze"];

			if ($info["money"] <= $available) {
				if ($m->where($wr)->setInc("wallet_pledge_freeze", $info["money"])) {
					$matter = array("type" => "freeze", "tid" => 0, "paytype" => "冻结", "remark" => $info["remark"]);
					$data = array("order_no" => createno("AF"), "uid" => $info["uid"], "time" => time(), "matter" => serialize($matter), "expend" => $info["money"]);

					if (m("member_pledge_bill")->add($data)) {
						sendsms($data["uid"], "系统发送", "您好，后台管理员为您" . $matter["paytype"] . "保证金" . $data["expend"] . "元！备注：" . $matter["remark"]);
						return array("status" => 1, "info" => "已成功冻结" . $info["money"], "url" => Model\__SELF__);
					}
				}
			}
			else {
				return array("status" => 0, "info" => "账户可冻结（可用资金）不足，冻结失败", "url" => Model\__SELF__);
			}

			break;

		case "unfeeze":
			$m = m("member");
			$wr = array("uid" => $info["uid"]);
			$freeze = $m->where($wr)->getField("wallet_pledge_freeze");

			if ($info["money"] <= $freeze) {
				if ($m->where($wr)->setDec("wallet_pledge_freeze", $info["money"])) {
					$matter = array("type" => "unfreeze", "tid" => 0, "paytype" => "解冻", "remark" => $info["remark"]);
					$data = array("order_no" => createno("AUF"), "uid" => $info["uid"], "time" => time(), "matter" => serialize($matter), "income" => $info["money"]);

					if (m("member_pledge_bill")->add($data)) {
						sendsms($data["uid"], "系统发送", "您好，后台管理员为您" . $matter["paytype"] . "保证金" . $data["income"] . "元！备注：" . $matter["remark"]);
						return array("status" => 1, "info" => "已成功解冻" . $info["money"], "url" => Model\__SELF__);
					}
				}
			}
			else {
				return array("status" => 0, "info" => "账户可解冻资金不足，解冻失败", "url" => Model\__SELF__);
			}

			break;

		default:
			break;
		}
	}

	public function recharge_limsum($info)
	{
		switch ($info["act"]) {
		case "add":
			if (m("member")->where(array("uid" => $info["uid"]))->setInc("wallet_limsum", $info["money"])) {
				$matter = array("type" => "deposit", "tid" => 0, "paytype" => "充值", "remark" => $info["remark"]);
				$data = array("order_no" => createno("ALA"), "uid" => $info["uid"], "time" => time(), "matter" => serialize($matter), "income" => $info["money"]);

				if (m("member_limsum_bill")->add($data)) {
					sendsms($data["uid"], "系统发送", "您好，后台管理员为您" . $matter["paytype"] . "信用额度" . $data["income"] . "元！备注：" . $matter["remark"]);
					return array("status" => 1, "info" => "已成功充值", "url" => Model\__SELF__);
				}
			}

			break;

		case "minus":
			$m = m("member");
			$pledge = $m->where(array("uid" => $info["uid"]))->field("wallet_limsum,wallet_limsum_freeze")->find();
			$available = $pledge["wallet_limsum"] - $pledge["wallet_limsum_freeze"];

			if ($info["money"] <= $available) {
				if ($m->where(array("uid" => $info["uid"]))->setDec("wallet_limsum", $info["money"])) {
					$matter = array("type" => "deposit", "tid" => 0, "paytype" => "扣除", "remark" => $info["remark"]);
					$data = array("order_no" => createno("ALM"), "uid" => $info["uid"], "time" => time(), "matter" => serialize($matter), "expend" => $info["money"]);

					if (m("member_limsum_bill")->add($data)) {
						sendsms($data["uid"], "系统发送", "您好，后台管理员为您" . $matter["paytype"] . "信用额度" . $data["expend"] . "元！备注：" . $matter["remark"]);
						return array("status" => 1, "info" => "已扣除成功", "url" => Model\__SELF__);
					}
				}
			}
			else {
				return array("status" => 0, "info" => "账户可扣除（可用资金）不足，扣除失败", "url" => Model\__SELF__);
			}

			break;

		case "freeze":
			$m = m("member");
			$wr = array("uid" => $info["uid"]);
			$pledge = $m->where($wr)->field("wallet_limsum,wallet_limsum_freeze")->find();
			$available = $pledge["wallet_limsum"] - $pledge["wallet_limsum_freeze"];

			if ($info["money"] <= $available) {
				if ($m->where($wr)->setInc("wallet_limsum_freeze", $info["money"])) {
					$matter = array("type" => "freeze", "tid" => 0, "paytype" => "冻结", "remark" => $info["remark"]);
					$data = array("order_no" => createno("ALF"), "uid" => $info["uid"], "time" => time(), "matter" => serialize($matter), "expend" => $info["money"]);

					if (m("member_limsum_bill")->add($data)) {
						sendsms($data["uid"], "系统发送", "您好，后台管理员为您" . $matter["paytype"] . "信用额度" . $data["expend"] . "元！备注：" . $matter["remark"]);
						return array("status" => 1, "info" => "已成功冻结" . $info["money"], "url" => Model\__SELF__);
					}
				}
			}
			else {
				return array("status" => 0, "info" => "账户可冻结（可用资金）不足，冻结失败", "url" => Model\__SELF__);
			}

			break;

		case "unfeeze":
			$m = m("member");
			$wr = array("uid" => $info["uid"]);
			$freeze = $m->where($wr)->getField("wallet_limsum_freeze");

			if ($info["money"] <= $freeze) {
				if ($m->where($wr)->setDec("wallet_limsum_freeze", $info["money"])) {
					$matter = array("type" => "unfreeze", "tid" => 0, "paytype" => "解冻", "remark" => $info["remark"]);
					$data = array("order_no" => createno("ALUF"), "uid" => $info["uid"], "time" => time(), "matter" => serialize($matter), "income" => $info["money"]);

					if (m("member_limsum_bill")->add($data)) {
						sendsms($data["uid"], "系统发送", "您好，后台管理员为您" . $matter["paytype"] . "信用额度" . $data["income"] . "元！备注：" . $matter["remark"]);
						return array("status" => 1, "info" => "已成功解冻" . $info["money"], "url" => Model\__SELF__);
					}
				}
			}
			else {
				return array("status" => 0, "info" => "账户可解冻资金不足，解冻失败", "url" => Model\__SELF__);
			}

			break;

		default:
			break;
		}
	}
}


?>
