<?php
namespace Admin\Controller;
use Think\Controller;
use Org\Util\Category;
Class DepartmentController extends CommonController{
	//显示部门列表
	public function index(){

		$this->assign('list',D('Department')->searchDepartment());
		$this->display();
	}
	//添加部门
	public function add(){
		if(IS_POST){
			$this->checkToken();
            header('Content-Type:application/json; charset=utf-8');

            echo json_encode(D("Department")->addDepartment());			

		}else{
			$info = $this->getDepartment();
			$info['dsort'] = 0;
			$info['dstatus'] = 1;
			$this->assign('info',$info);
			$this->assign('title','添加部门');
			$this->display('edit');			
		}
	}
	//修改部门
	public function editDepartment(){
 		if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Department")->editDepartment());
        } else {
            $M = D("Department");
            $info = $M->where("id=" . (int) $_GET['id'])->find();
            if (empty($info['id'])) {
                $this->error("不存在该部门", U('Department/index'));
            }
			$this->assign('title','修改部门');
            $this->assign("info", $this->getDepartment($info));
            $this->display('edit');
        }
		
	}
	//快捷修改部门状态
	public function opDepartmentStatus(){
		header('Content-Type:application/json; charset=utf-8');
        echo json_encode(D("Department")->opStatus());		

	}
	//快捷修改排序
    public function opSort() {
        $M = M("Department");
        $datas['id'] = (int) I("post.id");
        $datas['dsort'] = (int) I("post.sort");
        header('Content-Type:application/json; charset=utf-8');
        if ($M->save($datas)) {
            echo json_encode(array('status' => 1, 'info' => "处理成功"));
        } else {
            echo json_encode(array('status' => 0, 'info' => "处理失败"));
        }
    }

	//
	//删除部门
	public function delDepartment(){

		$m = M('Department');
		$id = i('get.id');
		if($m->where(array('pid'=>$id))->select()){
			$this->error('删除失败，该部门存在子部门！');
		}else{
			if($m->where(array('id'=>$id))->delete()){
				$this->success('部门删除成功！');
			}else{
				$this->error('部门删除失败！');
			}
		}
        if (M("News")->where("id=" . (int) $_GET['id'])->delete()) {
            $this->success("成功删除");

        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }		

	}







}

?>