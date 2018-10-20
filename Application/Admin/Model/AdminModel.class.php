<?
namespace Admin\Model;
use Think\Model;

class AdminModel extends Model{
	
	public function getAdmin($condition=array())
	{

		$user = M('Admin');
		$where = array('aid>0');
		if(!empty($condition))
			$where = array_merge($condition,$where);
		if(IS_POST){
			if(I('post.did')>0){
				//$where = array_merge(array('department='.I('post.did')),$where);
			}
		}
		$resutl =  $user->where($where)->select();

		return $resutl;
	}

}
?>