<?php

namespace Admin\Model;
use Think\Model;

class SharedatalogModel extends Model{
    protected $_auto = array(
		array('s_time','time',1,'function'),
		array('s_ip','get_client_ip',1,'function'),
	);
    public function addLog($id){
         //$datas['ip'] = get_client_ip();
        $datas['s_uid'] = session('my_info.aid');
        $datas['s_did'] = session('my_info.department');
        $datas['s_id'] = $id;
       

        C('TOKEN_ON',false);
        if($this->create($datas,1)){
                return $this->add();
        }else{
                echo $this->getError();
        }
		
	}
}

