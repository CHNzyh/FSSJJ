<?php
/**
 +------------------------------------------------------------------------------
 * 文件名称： /core/AuthRemote.class.php
 +------------------------------------------------------------------------------
 * 文件描述： 远程认证库
 +------------------------------------------------------------------------------
 */
defined('WF_CORE_ROOT') or die( 'Access not allowed');

class WF_Auth
{
	// 验证是管理员
	static function isAdmin()
	{
		return 'admin' === wf_gpc('wf_uname', 's');
	}

	// 验证是否有权限
	static function isAllow()
	{
		$auth_arr = wf_gpc('wf_uauth', 'S');
		return (in_array('*', $auth_arr) || in_array(WF_ACTION_NAME, $auth_arr)) ? true : false;
	}

	// 验证是否登录
	static public function isLogin()
	{
		// 校验 tokey
		$tokey1 = self::getTokey();
		$tokey2 = wf_gpc('wf_tokey', 'S');

		return !empty($tokey2) && $tokey1 === $tokey2;
	}

	// 远程本地登陆认证
	static function loginCheck()
	{
		$uname  = wf_gpc('wf_uname', 'p', 'trim');
		$upawd  = wf_gpc('wf_upawd', 'p', 'trim');
		$uhash  = wf_gpc('wf_uhash', 'p', 'trim');

		if (empty($uhash) || $uhash != $_SESSION['wf_uhash']){
			$_SESSION = array();
			$_SESSION['wf_error'] = '校验码码非法，请刷新页面后重试';
			wf_redirect('login.php?act=in');
		}

		// 请求API接口
		$json_url = WF_API_URL .'?'. http_build_query(array(
		'key' 	   => WF_API_KEY,
		'hostid'   => WF_API_HOSTID,
		'username' => $uname,
		'password' => md5(WF_API_KEY . $upawd)
		));
		$user_info = file_get_contents($json_url);
		$user_info = json_decode($user_info);

		$_SESSION = array();
		if (1 === $user_info->code) {
			$_SESSION['wf_uauth'] = explode(',', $user_info->data->auth);
			$_SESSION['wf_uroot'] = $user_info->data->root;
			$_SESSION['wf_upath'] = $user_info->data->path;
			$_SESSION['wf_uhost'] = $user_info->data->host;

			$_SESSION['wf_tokey'] = self::getTokey();
			$_SESSION['wf_error'] = '';

			wf_redirect('./');
		} else {
			$_SESSION['wf_error'] = $user_info->message;
			wf_redirect('login.php?act=in');
		}
	}

	// 登出
	static public function loginOut()
	{
		$_SESSION = array();
		unset($_SESSION);
	}

	static public function getTokey()
	{
		return md5($_SERVER['HTTP_USER_AGENT'] . date('Y-m-d') . WF_API_KEY);
	}
}