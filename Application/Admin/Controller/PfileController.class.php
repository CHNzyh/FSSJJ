<?php
namespace Admin\Controller;
use Think\Controller;

Class PfileController extends CommonController{
	//显示文件类型列表
	public function index(){

		$this->assign('list',D('Pfile')->searchPfile());
		$this->display();
	}
	//添加文件类型
	public function add(){
		if(IS_POST){
			$this->checkToken();
            header('Content-Type:application/json; charset=utf-8');

            echo json_encode(D("Pfile")->addPfile());			

		}else{
			$info = D('Pfile')->getPfilearray();
			$info['dsort'] = 0;
			$info['dstatus'] = 1;
			$this->assign('info',$info);
			$this->assign('title','添加文件类型');
			$this->display('edit');			
		}
	}
	//修改文件类型
	public function editPfile(){
 		if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Pfile")->editPfile());
        } else {
            $M = D("Pfile");
            $info = $M->where("id=" . (int) $_GET['id'])->find();
            if (empty($info['id'])) {
                $this->error("不存在该文件类型", U('Pfile/index'));
            }
			$this->assign('title','修改文件类型');
            $this->assign("info", D('Pfile')->getPfilearray($info));
            $this->display('edit');
        }
		
	}
	//快捷修改文件类型状态
	public function opPfileStatus(){
		header('Content-Type:application/json; charset=utf-8');
        echo json_encode(D("Pfile")->opStatus());		

	}
	//快捷修改排序
    public function opSort() {
        $M = M("Pfile");
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
	//删除文件类型
	public function delPfile(){


		$m = M('Pfile');
		$id = i('get.id');
		if($m->where(array('pid'=>$id))->select()){
			$this->error('删除失败，该文件类型存在子文件类型！');
		}else{
			if($m->where(array('id'=>$id))->delete()){
				$this->success('文件类型删除成功！');
			}else{
				$this->error('文件类型删除失败！');
			}
		}
        // if (M("News")->where("id=" . (int) $_GET['id'])->delete()) {
        //     $this->success("成功删除");

        // } else {
        //     $this->error("删除失败，可能是不存在该ID的记录");
        // }		

	}

    




}

?>