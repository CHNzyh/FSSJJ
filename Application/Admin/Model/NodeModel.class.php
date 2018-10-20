<?php
namespace Admin\Model;
use Think\Model\RelationModel;
class NodeModel extends RelationModel{
	 protected $_link = array(
			'Node' => array(
			    'mapping_type'  => self::HAS_MANY,	    
			    'parent_key'   => 'pid',
			    'mapping_name'  => 'node',
			    'mapping_order' => 'sort',
			    'condition' => 'menu=1',
			    ),	 	
	 	);
}
?>