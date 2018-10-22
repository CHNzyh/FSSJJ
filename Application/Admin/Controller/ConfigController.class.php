<?php
namespace Admin\Controller;
use Think\Controller;
use Org\Util\Category;
/*
 *文件名称：数据字典管理
 *功能描述：添加、修改、删除数据字典内容
 */
Class ConfigController extends CommonController{
   //显示字典列表
	public function index(){

		$this->assign('list',D('Config')->searchConfig());
		$this->display();
	}
	//添加字典
	public function add(){
		if(IS_POST){
			$this->checkToken();
            header('Content-Type:application/json; charset=utf-8');

            echo json_encode(D("Config")->addConfig());			

		}else{
			//$info = $this->getConfig();
                        $info = D('Config')->getConfigarray($info);
			$info['dsort'] = 0;
			$info['dstatus'] = 1;
			$this->assign('info',$info);
			$this->assign('title','添加字典');
			$this->display('edit');			
		}
	}
	//修改字典
	public function editConfig(){
 		if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Config")->editConfig());
        } else {
            $M = D("Config");
            $info = $M->where("id=" . (int) $_GET['id'])->find();
            if (empty($info['id'])) {
                $this->error("不存在该字典", U('Config/index'));
            }
			$this->assign('title','修改字典');
            //$this->assign("info", $this->getConfig($info));
            $this->assign("info", D('Config')->getConfigarray($info));
            $this->display('edit');
        }
		
	}
	//快捷修改字典状态
	public function opConfigStatus(){
		header('Content-Type:application/json; charset=utf-8');
        echo json_encode(D("Config")->opStatus());		

	}
	//快捷修改排序
    public function opSort() {
        $M = M("Config");
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
	//删除字典
	public function delConfig(){

		$m = M('Config');
		$id = i('get.id');
		if($m->where(array('pid'=>$id))->select()){
			$this->error('删除失败，该字典存在子字典！');
		}else{
			if($m->where(array('id'=>$id))->delete()){
				$this->success('字典删除成功！');
			}else{
				$this->error('字典删除失败！');
			}
		}
        
	}







}
