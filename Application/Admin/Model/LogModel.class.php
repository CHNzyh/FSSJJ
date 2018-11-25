<?php

namespace Admin\Model;
use Think\Model;

class LogModel extends Model{

	public $content;
	protected $_auto = array(
		array('ltime','time',1,'function'),
		array('ip','get_client_ip',1,'function'),
	);

	public function addLog(){
		$datas['modname'] = CONTROLLER_NAME;
		$datas['actname'] = ACTION_NAME;
		//$datas['ip'] = get_client_ip();
		$datas['userid'] = session('my_info.aid');
                $datas['did'] = session('my_info.department');
		$datas['lcontent'] = $this->content;
		//$datas['ltime'] = time();

		C('TOKEN_ON',false);
		if($this->create($datas,1)){
			return $this->add();
		}else{
			echo $this->getError();
		}
		
	}


}
?>