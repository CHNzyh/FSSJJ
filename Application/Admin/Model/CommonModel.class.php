<?php
namespace Admin\Model;
use Think\Model;
class CommonModel extends Model{
	public $log;
	public $project;
    public function _initialize() {
    	//$this->log = A('Log');
    	//$this->project = M('Project');
	}
}
?>