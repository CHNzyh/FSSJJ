<?php

namespace Admin\Controller;
use Think\Controller;
class AccessController extends CommonController {
    
    public function index() {

        $M = M("Admin");
        $count = $M->count();
        $pConf = page($count,C('PAGE_SIZE')); 
        $list=$M->order('aid')->limit($pConf['first'], $pConf['list'])->select();
        $this->page = $pConf['show'];


        $dp = D('Department')->getDepartment();
        
        foreach ($list as $k => $v ) {
            $list[$k]["statusTxt"] = ($v["status"] == 1 ? "启用" : "禁用");
            $list[$k]["chStatusTxt"] = ($v["status"] == 0 ? "启用" : "禁用");
            $list[$k]['dname']=($dp[$v['department']]['dname']!=''?$dp[$v['department']]['dname']:'无');   
        }     

        $this->list=$list;
        C('TOKEN_ON',false);
        //$this->assign("list", D("Access")->adminList());
        $this->display();
    }

    public function nodeList() {
        $this->assign("list", D("Access")->nodeList());
        $this->display();
    }

    public function roleList() {
        $this->assign("list", D("Access")->roleList());
        $this->display();
    }

    public function addRole() {
        if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Access")->addRole());
        } else {
            //$this->assign("info", $this->getRole());
            $this->display("editRole");
        }
    }

    public function editRole() {
        if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Access")->editRole());
        } else {
            $M = M("Role");
            $info = $M->where("id=" . (int) $_GET['id'])->find();
            if (empty($info['id'])) {
                $this->error("不存在该角色", U('Access/roleList'));
            }
            $this->assign('info',$info);
            //$this->assign("info", $this->getRole($info));
            $this->display();
        }
    }

    public function opNodeStatus() {
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode(D("Access")->opStatus("Node"));
    }
    public function opNodeMenu() {
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode(D("Access")->opMenu("Node"));
    }    

    public function opRoleStatus() {
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode(D("Access")->opStatus("Role"));
    }

    public function opSort() {
        $M = M("Node");
        $datas['id'] = (int) I("post.id");
        $datas['sort'] = (int) I("post.sort");
        header('Content-Type:application/json; charset=utf-8');
        if ($M->save($datas)) {
            echo json_encode(array('status' => 1, 'info' => "处理成功"));
        } else {
            echo json_encode(array('status' => 0, 'info' => "处理失败"));
        }
    }

    public function editNode() {
        if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Access")->editNode());
        } else {
            $M = M("Node");
            $info = $M->where("id=" . (int) $_GET['id'])->find();
            if (empty($info['id'])) {
                $this->error("不存在该节点", U('Access/nodeList'));
            }
            $this->assign("info", $this->getPid($info));
            $this->display();
        }
    }

    public function addNode() {
        if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Access")->addNode());
        } else {
            $this->assign("info", $this->getPid(array('level' => 1)));
            $this->display("editNode");
        }
    }

    
    public function addAdmin() {
        if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Access")->addAdmin());
        } else {

            $info = $this->getRoleListOption(array('role_id' => 0));
            $info = $this->getDepartmentListOption($info);
			$info['status']=1;
            $this->assign("info",$info );
            $this->assign('title','添加用户');
            $this->display();
        }
    }

    public function changeRole() {
        header('Content-Type:application/json; charset=utf-8');
        if (IS_POST) {
            $this->checkToken();
            echo json_encode(D("Access")->changeRole());
        } else {
            $M = M("Node");
            $info = M("Role")->where("id=" . (int) $_GET['id'])->find();
            if (empty($info['id'])) {
                $this->error("不存在该用户组", U('Access/roleList'));
            }
            $access = M("Access")->field("CONCAT(`node_id`,':',`level`,':',`pid`) as val")->where("`role_id`=" . $info['id'])->select();
            $info['access'] = count($access) > 0 ? json_encode($access) : json_encode(array());
            $this->assign("info", $info);
            $datas = $M->where("level=1")->select();

            foreach ($datas as $k => $v) {
                $map['level'] = 2;
                $map['pid'] = $v['id'];
                $datas[$k]['data'] = $M->where($map)->order('sort')->select();
                foreach ($datas[$k]['data'] as $k1 => $v1) {
                    $map['level'] = 3;
                    $map['pid'] = $v1['id'];
                    $datas[$k]['data'][$k1]['data'] = $M->where($map)->order('sort')->select();
                }
            }
            $this->assign("nodeList", $datas);
            $this->display();
        }
    }

    
    public function editAdmin() {
        if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Access")->editAdmin());
        } else {
            $M = M("Admin");
            $aid = (int) $_GET['aid'];
            $pre = C("DB_PREFIX");
            $info = $M->where("`aid`=" . $aid)->join($pre . "role_user ON " . $pre . "admin.aid = " . $pre . "role_user.user_id")->find();
            if (empty($info['aid'])) {
                $this->error("不存在该管理员ID", U('Access/index'));
            }
            if ($info['email'] == C('ADMIN_AUTH_KEY')) {
                $this->error("超级管理员信息不允许操作", U("Access/index"));
                exit;
            }
            $info = $this->getRoleListOption($info);
            $info = $this->getDepartmentListOption($info);
            $this->assign("info",$info );            
            $this->assign('title','修改用户信息');

            $this->display("addAdmin");
        }
    }

    public function search(){
        $M = M('Admin');
        $keys = I('get.');

        if($keys['field']=='email'){
            $where = array(
                        $keys['field'] => array('LIKE','%'.$keys['keyword'].'%'),
                        'nickname' => array('LIKE','%'.$keys['keyword'].'%'),
                        '_logic' => 'or'
                );

        }else{    
            $where = array($keys[field]=>array('LIKE','%'.$keys['keyword'].'%'));
        }
        $count = $M->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE')); 
        $list=$M->where($where)->order('aid desc')->limit($pConf['first'], $pConf['list'])->select();
        $this->list=$list;


        $keys['count']=$count;
        $this->keys=$keys;
        $this->page = $pConf['show'];
        C('TOKEN_ON',false);


        $dp = D('Department')->getDepartment();
        
        foreach ($list as $k => $v ) {
            $list[$k]["statusTxt"] = ($v["status"] == 1 ? "启用" : "禁用");

            $list[$k]["chStatusTxt"] = ($v["status"] == 0 ? "启用" : "禁用");

            $list[$k]['dname']=($dp[$v['department']]['dname']!=''?$dp[$v['department']]['dname']:'无');   
        }     

        $this->list=$list;
        $this->display("index");
    }

    public function opAdminStatus() {
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode(D("Access")->opStatus("Admin"));
    }    

    private function getRole($info = array()) {
       
        $cat = new \Org\Util\Category('Role', array('id', 'pid', 'name', 'fullname'));
        $list = $cat->getList();               
        foreach ($list as $k => $v) {
            $disabled = $v['id'] == $info['id'] ? ' disabled="disabled"' : "";
            $selected = $v['id'] == $info['pid'] ? ' selected="selected"' : "";
            $info['pidOption'].='<option value="' . $v['id'] . '"' . $selected . $disabled . '>' . $v['fullname'] . '</option>';
        }
        return $info;
    }

    private function getRoleListOption($info = array()) {
       
        $cat = new \Org\Util\Category('Role', array('id', 'pid', 'name', 'fullname'));
        $list = $cat->getList();               
        $info['roleOption'] = "";
        foreach ($list as $v) {
            $disabled = $v['id'] == 1 ? ' disabled="disabled"' : "";
            $selected = $v['id'] == $info['role_id'] ? ' selected="selected"' : "";
            $info['roleOption'].='<option value="' . $v['id'] . '"' . $selected . $disabled . '>' . $v['fullname'] . '</option>';
        }
        return $info;
    }

    private function getPid($info) {
        $arr = array("请选择", "项目", "模块", "操作");
        for ($i = 1; $i < 4; $i++) {
            $selected = $info['level'] == $i ? " selected='selected'" : "";
            $info['levelOption'].='<option value="' . $i . '" ' . $selected . '>' . $arr[$i] . '</option>';
        }
        $level = $info['level'] - 1;
        import("Category");
        $cat = new \Org\Util\Category('Node', array('id', 'pid', 'title', 'fullname'));
        $list = $cat->getList();               
        $option = $level == 0 ? '<option value="0" level="-1">根节点</option>' : '<option value="0" disabled="disabled">根节点</option>';
        foreach ($list as $k => $v) {
            $disabled = $v['level'] == $level ? "" : ' disabled="disabled"';
            $selected = $v['id'] != $info['pid'] ? "" : ' selected="selected"';
            $option.='<option value="' . $v['id'] . '"' . $disabled . $selected . '  level="' . $v['level'] . '">' . $v['fullname'] . '</option>';
        }
        $info['pidOption'] = $option;
        return $info;
    }

    private function getDepartmentListOption($info = array()) {
       
        $cat = new \Org\Util\Category('Department', array('id', 'pid', 'dname', 'fullname'));
        $list = $cat->getList();               
        $info['DepartmentOption'] = "";
        foreach ($list as $v) {
            //$disabled = $v['id'] == 1 ? ' disabled="disabled"' : "";
            $selected = $v['id'] == $info['department'] ? ' selected="selected"' : "";
            $info['DepartmentOption'].='<option value="' . $v['id'] . '"' . $selected . $disabled . '>' . $v['fullname'] . '</option>';
        }
        return $info;
    }    

}?>
