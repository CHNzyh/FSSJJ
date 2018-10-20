<?php
namespace Admin\Controller;
use Think\Controller;

class CompanyController extends CommonController{

	public function index(){

		$data = D('Company')->searchCompany();
		$this->assign('list',$data['list']);
		$this->assign('keys',$data['keys']);
		$this->assign('page',$data['page']);

		$this->display('index');
	}

	public function search(){
		$this->index();
	}
	public function add(){
		if(IS_POST){
			$this->checkToken();
            header('Content-Type:application/json; charset=utf-8');

            echo json_encode(D("Company")->addCompany());			

		}else{			
			$info['cstatus'] = 1;
			$this->assign('info',$info);
			$this->assign('title','添加审计企业');
			$this->display('edit');			
		}
	}
	public function editCompany(){
		if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Company")->editCompany());
        } else {
            $M = D("Company");
            $info = $M->where("id=" . (int) $_GET['id'])->find();

           
            if (empty($info['id'])) {
                $this->error("不存在该企业", U('Company/index'));
            }
            $this->assign("info", $info);
			$this->assign('title','修改审计企业');
            $this->display('edit');
        }
	}
	public function opCompanyStatus(){
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode(D("Company")->opStatus());			
	}
}
?>