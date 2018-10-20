<?php
namespace Admin\Controller;
use Think\Controller;

class ProjectController extends CommonController{

	public function index()
	{	
		//$this->display('index/index');

		$this->search();


	}

	public function add()//增加审计第一步
	{

		$data = D('Company')->searchCompany(array('status'=>1));
		$this->assign('list',$data['list']);
		$this->assign('keys',$data['keys']);
		$this->assign('page',$data['page']);
		$this->display('company');
	}
	public function searchcompany()
	{
		$keys = i('post.');
		$where = array(
						'status'=>1,
						'cname'=>'like "%'.$keys['keyword'].'%"'
			);
		$data = D('Company')->searchCompany($where);
		$this->assign('list',$data['list']);
		$this->assign('keys',$data['keys']);
		$this->assign('page',$data['page']);
		$this->display('company');
	}

	public function editProject(){
		if(IS_POST){
			$this->checkToken();
            header('Content-Type:application/json; charset=utf-8');

            echo json_encode(D("Project")->edit());

		}else{

			$id = I('get.id');

			$info = M('Project')->where('id='.$id)->find();
			
			$info['pbtime'] = date('Y/m/d',$info['pbtime']);
			$info['petime'] = date('Y/m/d',$info['petime']);
		
			$sql = M('Department')->where('id='.$info['pdepaid'].' or pid='.$info['pdepaid'])->field('id')->select(false);
			$user = M('Admin')->where('department in('.$sql.')')->select();

			
			foreach($user as $value=>$key){
				$user[$value]['check']=(is_numeric(strpos($info['pcrew'],'||'.$key['aid'].'||')))?1:0;
				
			}
			
			$this->assign('dp',D('Department')->where('id='.$info['pdepaid'])->find());
			$this->assign('info',$info);
			$this->assign('user',$user);
			$this->display('edit');

		}
	}

	public function showtranslation($id){

        $M = M('Project');
 		$where = array('pcompany_id='.$id);
	 	if(session('my_info.aid')>10)
    		$where['pdepaid'] = session('my_info.department');

        $count = $M->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE')); 
        $list=$M->where($where)->order('id desc')->limit($pConf['first'], $pConf['list'])->select();
        
        $this->list=$list;

        $keys['count']=$count;
        $this->keys=$keys;
        $this->page = $pConf['show'];
        C('TOKEN_ON',false);

        $this->list=$list;
        $this->assign('keys',$keys);
		$this->display();


	}

	public function translation(){//增加审计第二步
		if(IS_POST){

			$this->checkToken();
            //header('Content-Type:application/json; charset=utf-8');

            echo json_encode(D("Project")->add());
           
		}else{

			$this->assign('dp',D('Department')->where('id='.$_SESSION['my_info']['department'])->find());
			$M = M();

			$user = $M->query('select * from __PREFIX__Admin where department in(select id from __PREFIX__Department where id='.$_SESSION['my_info']['department'].' or pid='.$_SESSION['my_info']['department'].')');

			$company = M('Company')->where('id='.i('get.id'))->find();
			$info['pcompany'] = $company['cname'];



			$info['pcompany_id'] = $company['id'];
			$info['pstatus'] = 1;
			$this->assign('info',$info);
			$this->assign('title','添加审计项目');
			$this->assign('user',$user);
			
			$this->display('edit');
		}
	}

	public function search(){//搜索项目

        $M = M('Project');
        $keys = I('get.');
        $where = array('id>0');
        
        if(!empty($keys)){	        

	        $where = ($keys['keyword']!='')?array_merge(array($keys[field]=>array('LIKE','%'.$keys['keyword'].'%')),$where):$where;
	        $where = ($keys['department']>0)?array_merge(array('pdepaid='.$keys['department']),$where):$where;
	        $where = ($keys['user']>0)?array_merge(array('_string'=>'pleader='.$keys['user'].' or pcrew like"%||'.$keys['user'].'||%"'),$where):$where;
	        $where = ($keys['pbtime']!='')?array_merge(array('pbtime>='.strtotime($keys['pbtime'])),$where):$where;
	        $where = ($keys['petime']!='')?array_merge(array('petime<='.strtotime($keys['petime'])),$where):$where;
    	}

    	if(session('my_info.aid')>10)
    		$where['pdepaid'] = session('my_info.department');


        $count = $M->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE')); 
        $list=$M->where($where)->order('id desc')->limit($pConf['first'], $pConf['list'])->select();
        $this->list=$list;

        $keys['count']=$count;
        $this->keys=$keys;
        $this->page = $pConf['show'];
        C('TOKEN_ON',false);

        if(session('my_info.aid')==10){//AID=10为超级管理员
        	if($keys['department']>0){
      			$user = $this->getAdmin(array('department='.$keys['department']));
      			$condition = array('pid'=>$keys['department']);
        	}
        	$dp = D('Department')->getDepartmentarray($condition,'全部部门');
        	
    	}else{
    		$dp = D('Department')->getDepartment();
      		$user = $this->getAdmin(array('department='.session('my_info.department')));
    	}

             
        $this->list=$list;
        $this->assign('did',session('my_info.department'));
        $this->assign('dp',$dp);
        $this->assign('user',$user);
        $this->assign('keys',$keys);
		$this->display('index');

	}

	public function checkcode()//验证项目编号
	{
		$where['pcode'] = I('post.pcode');
		if(I('post.id')>0)
			$where['id'] = I('post.id');

		if(M('project')->where($where)->count()!=0){
			if(I('post.id')){
				echo 'true';
			}else{
    			echo 'false';
    		}
		} else {
			echo 'true';
		}
	}
	
	public function opProjectStatus(){//修改项目状态
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode(D("Project")->opStatus());	
        exit;	
	}
	public function fileList($id)
	{
        $M = M('Projectfile');
        $keys = I('get.');
        $where = array('id>0 and pid='.$id);
        //print_r($keys);
        //die();
        if(!empty($keys)){

        	if($keys['pftype']>0){
        		$sql = M('Pfile')->where('pid='.$keys['pftype'])->field('id')->select(false);
        		
        		;
		        $where = array_merge(array('(pftype='.$keys['pftype'].' or pftype in('.$sql.'))'),$where);
        		//$sql = "select id from __PREFIX__pfile where pid=".$keys['pftype'];
        	}

	        $where = ($keys['keyword']!='')?array_merge(array('pfname'=>array('LIKE','%'.$keys['keyword'].'%')),$where):$where;
    	}

    	if(session('my_info.aid')>10)
    		$where['pdepaid'] = session('my_info.department');


        $count = $M->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE')); 
        $list=$M->where($where)->order('id desc')->limit($pConf['first'], $pConf['list'])->select();
        $this->list=$list;
        $keys['count']=$count;
        $this->keys=$keys;
        $this->page = $pConf['show'];
        C('TOKEN_ON',false);

		$p = D('Project');
		$this->assign('project',$p->getProject('id='.$id,true));		

        
		$pfile = D('Pfile')->getPfilearray(array('pid'=>$keys['pftype']),'请选择');

        $this->list=$list;
        $this->assign('pfile',$pfile);
        $this->assign('did',session('my_info.department'));
        $this->assign('pf',D('Pfile')->filearray());
        $this->assign('dp',$dp);
        $this->assign('user',$user);
        $this->assign('keys',$keys);
		$this->display('pfilelist');

	}
	public function addFile($id)
	{
		
		if(IS_POST){
			$this->checkToken();
            header('Content-Type:application/json; charset=utf-8');

            echo json_encode(D("Project")->addFile());


		}else{
			$p = D('Project');
			$project = $p->getProject('id='.$id,true);
			$pfile = D('Pfile')->getPfilearray(array(),'请选择');
			$info['pid']=$id;
			$info['pfstatus'] = 1;
			$info['cid'] = $project['pcompany_id'];
			$this->assign('filepath',date('YmdHis',time()));
			$this->assign('info',$info);
			$this->assign('pfile',$pfile);
			$this->assign('project',$project);				
			$this->title='添加项目文件';
			$this->display('pfileedit');
		}
	}
	public function editProjectFile($id='')
	{
		if(IS_POST){
			$this->checkToken();

            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Project")->editFile());

		}else{

			$id = I('get.id');

			$info = M('Projectfile')->where('id='.$id)->find();
			$info['pfbtime'] = ($info['pfbtime']>0)?date('Y/m/d',$info['pfbtime']):'';
			$info['pfetime'] = ($info['pfetime']>0)?date('Y/m/d',$info['pfetime']):'';
		
			$p = D('Project');
			$project = $p->getProject('id='.$info['pid'],true);
			$pfile = D('Pfile')->getPfilearray(array('pid'=>$info['pftype']),'请选择');
			
			$this->assign('filepath',$info['projectpath'].'/'.$info['pfpath']);
			$this->assign('info',$info);
			$this->assign('pfile',$pfile);
			$this->assign('project',$project);				
			$this->title='修改项目文件';
			$this->display('pfileedit');

		}
	}
	public function delProjectFile($id='')
	{
		echo $id;
		# code...
	}
	public function getUrl($id)
	{
        header('Content-Type:application/json; charset=utf-8');
        
        $result = M('Pfile')->where('id='.$id)->find();
        if($result['id']>0){
	        echo json_encode(array("status" => 1, "info" => $result['purl'].$result['dename']));

        }else{
	        echo json_encode(array("status" => 0, "info" => '请求的文件类型不存在！'));

        }
		
	}
	public function opProjectFileStatus(){//修改项目文件状态
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode(D("Project")->opProjectFileStatus());			
	}

}

?>