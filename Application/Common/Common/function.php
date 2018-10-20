<?php

function pre($content)
{
	echo "<pre>";
	print_r($content);
	echo "</pre>";
}

function checkKey()
{
	import("@.ORG.Xxtea");
	$base64_key = "jvf";
	$xxtea_key = "blon";
	$des_key = "hzj";
	$str = @file_get_contents(ROOT_PATH . "/Public/key.dat");
	$str = Xxtea::decrypt($str, $xxtea_key);
	pre($str);
	exit();
	$arr = explode(",", $str);
	$host = $_SERVER["HTTP_HOST"];

	if (in_array($host, $arr)) {
		return true;
	}

	show();
}

function show()
{
	@header("Content-Type: text/html; charset=utf-8");
	$str = "PGRpdiBpZD0iIiBjbGFzcz0iIj48c3BhbiBzdHlsZT0iY29sb3I6IHJlZDsiPuaCqOi/mOayoeacieiiq+aOiOadg++8geivt+iBlOezuzxhIGhyZWY9Imh0dHA6Ly93d3cuanZmbmV0LmNvbSI+5L2z5byX572R57uc5bel5L2c5a6kPC9hPuiBlOezu+eUteivne+8mjAzNzEtNTU2OTU5Njc7CVFROjE3MTQ1MDg4Njg8L3NwYW4+PC9kaXY+";
	$str = base64_decode($str);
	exit($str);
}

function page($count, $size)
{
	$page = new Think\Page($count, $size);
	$page->lastSuffix = false;
	$page->setConfig("prev", "上一页");
	$page->setConfig("next", "下一页");
	$page->setConfig("first", "首页");
	$page->setConfig("last", "尾页");
	$page->setConfig("theme", "%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <span>共%TOTAL_PAGE%页</span>");
	$pConf["show"] = $page->show();
	$pConf["first"] = $page->firstRow;
	$pConf["list"] = $page->listRows;
	return $pConf;
}

function check_verify($code, $id = "", $reset = true)
{
	$verify = new Think\Verify();
	$verify->reset = $reset;
	return $verify->check($code, $id, $reset);
}

function set_config($name, $value = "", $path = DATA_PATH)
{
	static $_cache = array();
	$filename = $path . $name . ".php";

	if ("" !== $value) {
		if (is_null($value)) {
			return false !== strpos($name, "*") ? array_map("unlink", glob($filename)) : unlink($filename);
		}
		else {
			$dir = dirname($filename);

			if (!is_dir($dir)) {
				mkdir($dir, 493, true);
			}

			$_cache[$name] = $value;
			return file_put_contents($filename, strip_whitespace("<?php\treturn " . var_export($value, true) . ";?>"));
		}
	}

	if (isset($_cache[$name])) {
		return $_cache[$name];
	}

	if (is_file($filename)) {
		$value = include ($filename);
		$_cache[$name] = $value;
	}
	else {
		$value = false;
	}

	return $value;
}

function encrypt($data)
{
	return md5(c("AUTH_CODE") . md5($data));
}

function strToArray($string)
{
	$strlen = mb_strlen($string);

	while ($strlen) {
		$array[] = mb_substr($string, 0, 1, "utf8");
		$string = mb_substr($string, 1, $strlen, "utf8");
		$strlen = mb_strlen($string);
	}

	return $array;
}

function randCode($length = 5, $type = 0)
{
	$arr = array(1 => "0123456789", 2 => "abcdefghijklmnopqrstuvwxyz", 3 => "ABCDEFGHIJKLMNOPQRSTUVWXYZ", 4 => "~@#$%^&*(){}[]|");

	if ($type == 0) {
		array_pop($arr);
		$string = implode("", $arr);
	}
	else if ($type == "-1") {
		$string = implode("", $arr);
	}
	else {
		$string = $arr[$type];
	}

	$count = strlen($string) - 1;

	for ($i = 0; $i < $length; $i++) {
		$str[$i] = $string[rand(0, $count)];
		$code .= $str[$i];
	}

	return $code;
}

function delDirAndFile($path, $delDir = false)
{
	$handle = opendir($path);

	if ($handle) {
		while (false !== $item = readdir($handle)) {
			if (($item != ".") && ($item != "..")) {
				is_dir("$path/$item") ? deldirandfile("$path/$item", $delDir) : unlink("$path/$item");
			}
		}

		closedir($handle);

		if ($delDir) {
			return rmdir($path);
		}
	}
	else if (file_exists($path)) {
		return unlink($path);
	}
	else {
		return false;
	}
}

function hideStr($string, $bengin = 0, $len = 4, $type = 0, $glue = "@")
{
	if (empty($string)) {
		return false;
	}

	$array = array();
	if (($type == 0) || ($type == 1) || ($type == 4)) {
		$strlen = $length = mb_strlen($string);

		while ($strlen) {
			$array[] = mb_substr($string, 0, 1, "utf8");
			$string = mb_substr($string, 1, $strlen, "utf8");
			$strlen = mb_strlen($string);
		}
	}

	switch ($type) {
	case 1:
		$array = array_reverse($array);

		for ($i = $bengin; $i < ($bengin + $len); $i++) {
			if (isset($array[$i])) {
				$array[$i] = "*";
			}
		}

		$string = implode("", array_reverse($array));
		break;

	case 2:
		$array = explode($glue, $string);
		$array[0] = hidestr($array[0], $bengin, $len, 1);
		$string = implode($glue, $array);
		break;

	case 3:
		$array = explode($glue, $string);
		$array[1] = hidestr($array[1], $bengin, $len, 0);
		$string = implode($glue, $array);
		break;

	case 4:
		$left = $bengin;
		$right = $len;
		$tem = array();

		for ($i = 0; $i < ($length - $right); $i++) {
			if (isset($array[$i])) {
				$tem[] = ($left <= $i ? "*" : $array[$i]);
			}
		}

		$array = array_chunk(array_reverse($array), $right);
		$array = array_reverse($array[0]);

		for ($i = 0; $i < $right; $i++) {
			$tem[] = $array[$i];
		}

		$string = implode("", $tem);
		break;

	default:
		for ($i = $bengin; $i < ($bengin + $len); $i++) {
			if (isset($array[$i])) {
				$array[$i] = "*";
			}
		}

		$string = implode("", $array);
		break;
	}

	return $string;
}

function cutStr($str, $len = 100, $start = 0, $suffix = 1)
{
	$str = strip_tags(trim(strip_tags($str)));
	$str = str_replace(array("\n", "\t"), "", $str);
	$strlen = mb_strlen($str);

	while ($strlen) {
		$array[] = mb_substr($str, 0, 1, "utf8");
		$str = mb_substr($str, 1, $strlen, "utf8");
		$strlen = mb_strlen($str);
	}

	$end = $len + $start;
	$str = "";

	for ($i = $start; $i < $end; $i++) {
		$str .= $array[$i];
	}

	return $len < count($array) ? ($suffix == 1 ? $str . "&hellip;" : $str) : $str;
}

function makeDir($path)
{
	return is_dir($path) || (makedir(dirname($path)) && @mkdir($path, 511));
}

function is_email($value)
{
	return preg_match("/^[0-9a-zA-Z]+(?:[\_\.\-][a-z0-9\-]+)*@[a-zA-Z0-9]+(?:[-.][a-zA-Z0-9]+)*\.[a-zA-Z]+$/i", $value);
}

function send_mail($to, $name, $subject = "", $body = "", $attachment = NULL, $config = "")
{
	$config = (is_array($config) ? $config : c("SYSTEM_EMAIL"));
	$mail = new Org\Util\PHPMailer\PHPMailer();
	$mail->CharSet = "UTF-8";
	$mail->IsSMTP();
	$mail->SMTPDebug = 0;
	$mail->SMTPAuth = true;

	if ($config["smtp_port"] == 465) {
		$mail->SMTPSecure = "ssl";
	}

	$mail->Host = $config["smtp_host"];
	$mail->Port = $config["smtp_port"];
	$mail->Username = $config["smtp_user"];
	$mail->Password = $config["smtp_pass"];
	$mail->SetFrom($config["from_email"], $config["from_name"]);
	$replyEmail = ($config["reply_email"] ? $config["reply_email"] : $config["reply_email"]);
	$replyName = ($config["reply_name"] ? $config["reply_name"] : $config["reply_name"]);
	$mail->AddReplyTo($replyEmail, $replyName);
	$mail->Subject = $subject;
	$mail->MsgHTML($body);
	$mail->AddAddress($to, $name);

	if (is_array($attachment)) {
		foreach ($attachment as $file ) {
			if (is_array($file)) {
				is_file($file["path"]) && $mail->AddAttachment($file["path"], $file["name"]);
			}
			else {
				is_file($file) && $mail->AddAttachment($file);
			}
		}
	}
	else {
		is_file($attachment) && $mail->AddAttachment($attachment);
	}

	return $mail->Send() ? true : $mail->ErrorInfo;
}

function remove_xss($val)
{
	$val = preg_replace("/([\\x00-\\x08,\\x0b-\\x0c,\\x0e-\\x19])/", "", $val);
	$search = "abcdefghijklmnopqrstuvwxyz";
	$search .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$search .= "1234567890!@#$%^&*()";
	$search .= "~`\";:?+/={}[]-_|'\\";

	for ($i = 0; $i < strlen($search); $i++) {
		$val = preg_replace("/(&#[xX]0{0,8}" . dechex(ord($search[$i])) . ";?)/i", $search[$i], $val);
		$val = preg_replace("/(&#0{0,8}" . ord($search[$i]) . ";?)/", $search[$i], $val);
	}

	$ra1 = array("javascript", "vbscript", "expression", "applet", "meta", "xml", "blink", "link", "style", "script", "embed", "object", "iframe", "frame", "frameset", "ilayer", "layer", "bgsound", "title", "base");
	$ra2 = array("onabort", "onactivate", "onafterprint", "onafterupdate", "onbeforeactivate", "onbeforecopy", "onbeforecut", "onbeforedeactivate", "onbeforeeditfocus", "onbeforepaste", "onbeforeprint", "onbeforeunload", "onbeforeupdate", "onblur", "onbounce", "oncellchange", "onchange", "onclick", "oncontextmenu", "oncontrolselect", "oncopy", "oncut", "ondataavailable", "ondatasetchanged", "ondatasetcomplete", "ondblclick", "ondeactivate", "ondrag", "ondragend", "ondragenter", "ondragleave", "ondragover", "ondragstart", "ondrop", "onerror", "onerrorupdate", "onfilterchange", "onfinish", "onfocus", "onfocusin", "onfocusout", "onhelp", "onkeydown", "onkeypress", "onkeyup", "onlayoutcomplete", "onload", "onlosecapture", "onmousedown", "onmouseenter", "onmouseleave", "onmousemove", "onmouseout", "onmouseover", "onmouseup", "onmousewheel", "onmove", "onmoveend", "onmovestart", "onpaste", "onpropertychange", "onreadystatechange", "onreset", "onresize", "onresizeend", "onresizestart", "onrowenter", "onrowexit", "onrowsdelete", "onrowsinserted", "onscroll", "onselect", "onselectionchange", "onselectstart", "onstart", "onstop", "onsubmit", "onunload");
	$ra = array_merge($ra1, $ra2);
	$found = true;

	while ($found == true) {
		$val_before = $val;

		for ($i = 0; $i < sizeof($ra); $i++) {
			$pattern = "/";

			for ($j = 0; $j < strlen($ra[$i]); $j++) {
				if (0 < $j) {
					$pattern .= "(";
					$pattern .= "(&#[xX]0{0,8}([9ab]);)";
					$pattern .= "|";
					$pattern .= "|(&#0{0,8}([9|10|13]);)";
					$pattern .= ")*";
				}

				$pattern .= $ra[$i][$j];
			}

			$pattern .= "/i";
			$replacement = substr($ra[$i], 0, 2) . "<x>" . substr($ra[$i], 2);
			$val = preg_replace($pattern, $replacement, $val);

			if ($val_before == $val) {
				$found = false;
			}
		}
	}

	return $val;
}

function byteFormat($bytes)
{
	$sizetext = array(" B", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
	return round($bytes / pow(1024, $i = floor(log($bytes, 1024))), 2) . $sizetext[$i];
}

function checkCharset($string, $charset = "UTF-8")
{
	if ($string == "") {
		return NULL;
	}

	$check = preg_match("%^(?:\r\n                                [\\x09\\x0A\\x0D\\x20-\\x7E] # ASCII\r\n                                | [\\xC2-\\xDF][\\x80-\\xBF] # non-overlong 2-byte\r\n                                | \\xE0[\\xA0-\\xBF][\\x80-\\xBF] # excluding overlongs\r\n                                | [\\xE1-\\xEC\\xEE\\xEF][\\x80-\\xBF]{2} # straight 3-byte\r\n                                | \\xED[\\x80-\\x9F][\\x80-\\xBF] # excluding surrogates\r\n                                | \\xF0[\\x90-\\xBF][\\x80-\\xBF]{2} # planes 1-3\r\n                                | [\\xF1-\\xF3][\\x80-\\xBF]{3} # planes 4-15\r\n                                | \\xF4[\\x80-\\x8F][\\x80-\\xBF]{2} # plane 16\r\n                                )*$%xs", $string);
	return $charset == "UTF-8" ? ($check == 1 ? $string : iconv("gb2312", "utf-8", $string)) : ($check == 0 ? $string : iconv("utf-8", "gb2312", $string));
}

function showAdvPosition($tagname, $htag = "", $is_flash = true)
{
	if (!$tagname) {
		return "";
	}

	$advertising_position = m("Advertising_position");
	$advertising = m("Advertising");
	$adv_postmap["tagname"] = array("eq", $tagname);
	$ap = $advertising_position->where($adv_postmap)->find();
	$now = time();
	$advmap["status"] = array("eq", 1);
	$advmap["pid"] = array("eq", $ap["id"]);
	$advmap["_string"] = "((adv_start_time <='" . $now . "' and adv_end_time >='" . $now . "') or (adv_start_time =0 and adv_end_time = 0 ) or (adv_start_time <='" . $now . "' and adv_end_time = 0 ) or (adv_start_time =0 and adv_end_time >='" . $now . "' ))";
	$adv_list = $advertising->where($advmap)->order("sort desc,id asc")->select();

	foreach ($adv_list as $key => $adv ) {
		$adv_list[$key]["html"] = getadvhtml($adv, $ap);
	}

	$ap["adv_list"] = $adv_list;
	if ($is_flash && ($ap["is_flash"] == 1) && !empty($ap["flash_style"])) {
		$adv_path = __ROOT__ . "/Public/Advertising/" . $ap["flash_style"] . ".swf";
		$adv_pics = "";
		$adv_texts = "";
		$adv_links = "";

		foreach ($ap["adv_list"] as $adv ) {
			if (empty($adv_pics)) {
				$jg = "";
			}
			else {
				$jg = "|";
			}

			$adv_pics .= $jg . c("UPLOADS_PICPATH") . $adv["code"];
			$adv_texts .= $jg . $adv["desc"];
			$adv_links .= $jg . $adv["url"];
		}

		unset($ap["adv_list"]);
		$parseStr = $ap["style"];
		$parseStr = str_replace("[adv_position.width]", $ap["width"], $parseStr);
		$parseStr = str_replace("[adv_position.height]", $ap["height"], $parseStr);
		$parseStr = str_replace("[adv_path]", $adv_path, $parseStr);
		$parseStr = str_replace("[adv_pics]", $adv_pics, $parseStr);
		$parseStr = str_replace("[adv_links]", $adv_links, $parseStr);
		$parseStr = str_replace("[adv_texts]", $adv_texts, $parseStr);

		if ($htag) {
			$parseStr = "<" . $htag . ">" . $parseStr . "</" . $htag . ">";
		}
	}
	else {
		$ap_adv_list = $ap["adv_list"];
		$parseStr = "";

		if ($ap_adv_list) {
			if ($htag) {
				foreach ($ap_adv_list as $value ) {
					$parseStr .= "<" . $htag . ">" . $value["html"] . "</" . $htag . ">";
				}
			}
			else {
				$parseStr .= "<ul>";

				foreach ($ap_adv_list as $value ) {
					$parseStr .= "<li>" . $value["html"] . "</li>";
				}

				$parseStr .= "</ul>";
			}
		}
	}

	return $parseStr;
}

function getAdvHTML($adv, $ap)
{
	if ($ap["width"] == 0) {
		$ap["width"] = "";
	}
	else {
		$ap["width"] = " width='" . $ap["width"] . "'";
	}

	if ($ap["height"] == 0) {
		$ap["height"] = "";
	}
	else {
		$ap["height"] = " height='" . $ap["height"] . "'";
	}

	switch ($adv["type"]) {
	case "1":
		if ($adv["url"] == "") {
			$adv_str = "<img src='" . c("UPLOADS_PICPATH") . $adv["code"] . "'" . $ap["width"] . $ap["height"] . "/>";
		}
		else if (intval($adv["is_vote"]) == 1) {
			$adv_str = "<a href='" . c("UPLOADS_PICPATH") . $adv["url"] . "' target='_blank' title='" . $adv["desc"] . "'><img src='" . c("UPLOADS_PICPATH") . $adv["code"] . "'" . $ap["width"] . $ap["height"] . "/></a>";
		}
		else {
			$adv_str = "<a href='" . $adv["url"] . "' target='_blank' title='" . $adv["desc"] . "'><img src='" . c("UPLOADS_PICPATH") . $adv["code"] . "'" . $ap["width"] . $ap["height"] . "/></a>";
		}

		break;

	case "2":
		$adv_str = "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0'" . $ap["width"] . $ap["height"] . "><param name='movie' value='" . c("UPLOADS_PICPATH") . $adv["code"] . "' /><param name='quality' value='high' /><param name='menu' value='false' /><embed src='" . c("UPLOADS_PICPATH") . $adv["code"] . "' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash'" . $ap["width"] . $ap["height"] . "></embed></object>";
		break;

	case "3":
		$adv_str = htmlspecialchars_decode($adv["code"]);
		break;
	}

	return $adv_str;
}

function getAdvtype($type)
{
	switch ($type) {
	case 2:
		$showText = "Flash广告";
		break;

	case 3:
		$showText = "自定义代码广告";
		break;

	case 1:
	default:
		$showText = "图片广告";
	}

	return $showText;
}

function picSize($wk, $wh, $how = "goods")
{
	if ($how == "goods") {
		$picFix = explode(",", c("GOODS_PIC_PREFIX"));
		$picWidth = explode(",", c("GOODS_PIC_WIDTH"));
		$picHeight = explode(",", c("GOODS_PIC_HEIGHT"));
	}
	else if ($how == "user") {
		$picFix = explode(",", c("USER_PIC_PREFIX"));
		$picWidth = explode(",", c("USER_PIC_WIDTH"));
		$picHeight = explode(",", c("USER_PIC_HEIGHT"));
	}

	$picSize = array();
	$sK = 0;

	foreach ($picFix as $fK => $fV ) {
		$picSize[$sK] = array("width" => $picWidth[$fK], "height" => $picHeight[$fK]);
		$sK += 1;
	}

	if ($wk < 4) {
		return $picSize[$wk][$wh];
	}

	return $picSize;
}

function picRep($str, $fix, $how = "goods")
{
	if ($how == "goods") {
		$picFix = explode(",", c("GOODS_PIC_PREFIX"));
		$preg = "/" . c("GOODS_PICPATH") . "\/\d+?\//is";
	}
	else if ($how == "user") {
		$picFix = explode(",", c("USER_PIC_PREFIX"));
		$preg = "/" . c("USER_PICPATH") . "\//is";
	}

	preg_match($preg, $str, $gdPicPath);
	$picFixPath = preg_replace($preg, $gdPicPath[0] . $picFix[$fix], $str);
	return $picFixPath;
}

function getPicUrl($picStr, $fix, $key)
{
	if ($picStr) {
		$picArr = explode("|", $picStr);
	}

	return picrep($picArr[$key], $fix);
}

function getUse($use)
{
	switch ($use) {
	case "pledge":
		return "保证金充值";
	case "auction":
		return "拍品支付";
	}
}

function getPayname($paytype)
{
	switch ($paytype) {
	case "alipay":
		return "支付宝";
	case "tenpay":
		return "财付通";
	case "palpay":
		return "贝宝支付";
	case "yeepay":
		return "易宝支付";
	case "kuaiqian":
		return "快钱支付";
	case "unionpay":
		return "银联在线";
	}
}

function getTopField($cid, $type = "str")
{
	$filtrate = m("Goods_filtrate");
	$cate = m("Goods_category");
	$cLinkF = m("Goods_category_filtrate");
	$interimCid = $cid;
	$catPath = array($cid);
	$zoarium = array();

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
	))->order("sort desc")->getField("fid", true);

		if ($filtMap) {
			$zoarium = array_merge($zoarium, $filtMap);
		}
	}

	if ($type == "str") {
		return implode("_", $zoarium);
	}
	else if ($type == "arr") {
		return $zoarium;
	}
}

function sendSms($uid, $type, $content)
{
	$smsData = array("uid" => $uid, "type" => $type, "content" => $content, "time" => time());
	m("mysms")->add($smsData);
}

function createNo($rmk)
{
	return $rmk . strtoupper(dechex(date("m"))) . date("d") . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf("d", rand(0, 99));
}

function sendNote($mobile = "", $content = "")
{
	$ntc = c("SYSTEM_NOTE");

	if (empty($ntc)) {
		return array("status" => 0, "info" => "未配置短信接口，无法发送短信");
		break;
	}
	else if ($mobile == "") {
		return array("status" => 0, "info" => "手机号未填写");
        break;
	}
	else if ($content == "") {
		return array("status" => 0, "info" => "内容不能为空");
        break;
	}

	if (PATH_SEPARATOR == ":") {
		$url = $ntc["url"] . $ntc["uid"]["field"] . "=%s&" . $ntc["pwd"]["field"] . "=%s&" . $ntc["mob"]["field"] . "=%s&" . $ntc["con"]["field"] . "=%s";
		$uid = urlencode($ntc["uid"]["value"]);
		$pwd = urlencode($ntc["pwd"]["value"]);
		$mob = urlencode($mobile);
		$content = iconv("UTF-8", "GB2312", $content);
		$rurl = sprintf($url, $uid, $pwd, $mob, $content);
		($ch = curl_init()) || exit(curl_error());
		curl_setopt($ch, CURLOPT_URL, $rurl);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$result = curl_exec($ch);
		$status = explode("/", $result);
		curl_close($ch);
	}
	else if (strtoupper(substr(PHP_OS, 0, 3)) === "WIN") {
		$content = iconv("UTF-8", "GB2312//IGNORE", $content);
		$sendurl = $ntc["url"];
		$sdata = $ntc["uid"]["field"] . "=" . $ntc["uid"]["value"] . "&" . $ntc["pwd"]["field"] . "=" . $ntc["pwd"]["value"] . "&" . $ntc["mob"]["field"] . "=" . $mobile . "&" . $ntc["con"]["field"] . "=" . $content;
		$status = explode("/", file_get_contents($sendurl . $sdata));
	}

	if ($status[0] == $ntc["status"]) {
		return array("status" => 1, "info" => "发送成功");
	}
	else {
		return array("status" => 0, "info" => "发送失败:错误代码   " . $status[0]);
	}
}


?>
