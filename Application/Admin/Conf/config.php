<?php


$DB_PREFIX = C('DB_PREFIX');
return array(
        
    'UPLOAD_PATH' =>file_get_contents('http://127.0.0.1:8080/upload/1.php'),
    'SHAREDATA_URL' =>file_get_contents('http://127.0.0.1:8080/upload/1.php').'\sharedata',
    'PAGE_SIZE' =>20,
    'DEFAULT_FILTER' => 'strip_tags,trim',
    
    'ADV_PICPATH'=>'Advertising',
    'ADV_MAX_WIDTH'=>'1400',
    'ADV_MAX_HEIGHT'=>'700',
    
    'ARTICLE_PICPATH'=>'Article',
    'ART_MAX_WIDTH'=>'1000',
    
    'CATE_PICPATH'=>'Category',
    'CATE_ICO_WIDTH'=>'50',
    'CATE_ICO_HEIGHT'=>'50',

    
    'LINK_PICPATH'=>'Link',
    'LINK_ICO_WIDTH'=>'128',
    'LINK_ICO_HEIGHT'=>'48',

    
    'NEWS_PICPATH'=>'News',
    'NEWS_ICO_WIDTH'=>'180',
    'NEWS_ICO_HEIGHT'=>'100',
    
    'TASK_FILEPATH'=> 'Task', //综合任务目录
    'SHARE_FILEPATH'=>'Sharedata',//共享文件目录
    'SCHEDULE_FILEPATH'=>'Schedule',//项目进度上传文件目录
    'SCHEDULE_FILENAME'=>array(
        'file_1' => '文件一',
        'file_2' => '文件二',
        'file_3' => '文件三',
        'file_4' => '文件四',
        'file_5' => '文件五',
        'file_6' => '文件六',
        'file_7' => '文件七'     
    ),
    
    'USER_AUTH_ON' => true,
    'USER_AUTH_TYPE' => 1, 
    'USER_AUTH_KEY' => 'authId', 

    'USER_AUTH_MODEL' => 'Admin', 
    'AUTH_PWD_ENCODER' => 'md5', 
    'USER_AUTH_GATEWAY' => '/admin/Public/index', 
    'NOT_AUTH_MODULE' => 'Public,Upload,Log', 
    'REQUIRE_AUTH_MODULE' => '', 
    'NOT_AUTH_ACTION' => 'search,getcate,getFilt,getExtends,checkNewsTitle,goodPicOrder,del_pic,cutview,cutoper,delIco,order_filtrate,getChild,order_fields,onOff_fields,region_fields,region,sort,order_advertising,forbid,order_navigation,checkcode,addLog', 
    'REQUIRE_AUTH_ACTION' => '', 
    'GUEST_AUTH_ON' => false, 
    'GUEST_AUTH_ID' => 0, 
    'RBAC_ROLE_TABLE' => $DB_PREFIX . 'role',
    'RBAC_USER_TABLE' => $DB_PREFIX . 'role_user',
    'RBAC_ACCESS_TABLE' => $DB_PREFIX . 'access',
    'RBAC_NODE_TABLE' => $DB_PREFIX . 'node',

    'LOCK_ID'=>array(
        'link'=>'1,2,3',
        'article'=>'1,2,3',
        'goods'=>'1,2,3',
        'art_sun'=>'1,2'
        ),
    
    'sqlFileSize' => 5242880, 
        
        
    'PositionArray' => array(1=>'局长',2=>'科长',3=>'科员'),
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public',
        '__IMG__'    => __ROOT__ . '/Public/Admin/Img',
        '__CSS__'    => __ROOT__ . '/Public/Admin/Css',
        '__JS__'     => __ROOT__ . '/Public/Admin/Js',
        '--PUBLIC--'=>__ROOT__ . '/Public'
    ),
);


?>
