<?php



$config1 = array(
    
    'DB_TYPE' => 'mysql', 
    'SHOW_PAGE_TRACE' => true,
    'TOKEN_ON' => true, 
    'TOKEN_NAME' => '__jvfnet__', 
    'TOKEN_TYPE' => 'md5', 
    'TOKEN_RESET' => FALSE, 
    
    'AUTHOR_INFO' => array(
        'author' => 'rzinfo.net.cn',
        'author_email' => '373786626@qq.com',
    ),

    'DEFAULT_C_LAYER'       =>  'Controller', 
    'MODULE_ALLOW_LIST'     =>  array('Home','Admin'), 
    'DEFAULT_MODULE'        =>  'Admin', 
    //'MODULE_DENY_LIST'   => array('Common'),
    'TAGLIB_BUILD_IN' =>'Cx,Cuit', 
    'URL_ROUTER_ON'   => true,
    'URL_MODEL'=> '1', 
    'UPLOADS_PICPATH'=>'./Uploads/',
    
    'VAR_SESSION_ID' =>  'session_id', 
    
    'GOODS_PICPATH'=>'Goods',
    
    
    'GOODS_PIC_PREFIX' =>'pre_,max_,mid_,mini_',
    'GOODS_PIC_WIDTH' =>'750,520,259,96',
    'GOODS_PIC_HEIGHT' =>'562,390,194,72',

    
    'USER_PICPATH'=>'User',
    'USER_PIC_PREFIX' =>'max_,mid_,mini_',
    'USER_PIC_WIDTH' =>'215,100,50',
    'USER_PIC_HEIGHT' =>'215,100,50',
    
);
$config2 = APP_PATH . "Common/Conf/systemConfig.php";
$config2 = file_exists($config2) ? include "$config2" : array();

$payment = APP_PATH . "Common/Conf/payment.php";
$payment = file_exists($payment) ? include "$payment" : array();

$setExtend = APP_PATH . "Common/Conf/setExtend.php";
$setExtend = file_exists($setExtend) ? include "$setExtend" : array();

$SetAuction = APP_PATH . "Common/Conf/SetAuction.php";
$SetAuction = file_exists($SetAuction) ? include "$SetAuction" : array();

$SetOrder = APP_PATH . "Common/Conf/SetOrder.php";
$SetOrder = file_exists($SetOrder) ? include "$SetOrder" : array();

$SetMember = APP_PATH . "Common/Conf/SetMember.php";
$SetMember = file_exists($SetMember) ? include "$SetMember" : array();

return array_merge($config1, $config2, $payment,$setExtend,$SetAuction,$SetOrder,$SetMember);
?>
