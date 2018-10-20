<?php

namespace Admin\Controller;
use Think\Controller;
class GoodsController extends CommonController {
    
    public function index() {
        $channel = M('goods_category')->where('pid=0')->select(); 
        $this->channel=$channel; 
        $M = M("Goods");
        $count = $M->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];
        $this->list = D("Goods")->listGoods($pConf['first'], $pConf['list']);
        $this->display();
    }
    
    public function getcate(){
        $pid=I('post.pid');
        $cateHtml='';
        if($pid!=''){
            $cat = new \Org\Util\Category('Goods_category', array('cid', 'pid', 'name', 'fullname'));
            $cate=$cat->getList(NULL, $pid,NULL);
            $cateHtml='<span id="cid_select">->&nbsp;&nbsp;<select name="cid"><option value="">所有分类</option>';
            foreach ($cate as $ck => $cv) {
                $cateHtml.='<option value="'.$cv['cid'].'">'.$cv['fullname'].'</option>';
            }
            $cateHtml.='</select></span>';
        }
        echo json_encode(array("status" => 1, "htm" => $cateHtml));
    }
    
    public function search(){
            $keyW = I('get.');
            $cate=M('Goods_category');
            if($keyW['pid']!=''){
                $chname=  $cate->where('cid='.$keyW['pid'])->getField('name');
                if($keyW['cid']==''){
                    $cat = new \Org\Util\Category('Goods_category', array('cid', 'pid', 'name', 'fullname'));
                    $catecid = $cat->getList(NULL, $keyW['pid'],NULL);
                    foreach ($catecid as $cik => $civ) {
                        $keyW['cid'][$cik]=$civ['cid'];
                    }
                    array_push($keyW['cid'], $keyW['pid']); 
                    $where['cid'] = array('in',$keyW['cid']);
                    $catname = '所有'; 
                }else{
                    $chname = '所有';
                    if($keyW['cid']!=''){
                        $where['cid'] = $keyW['cid'];
                        $catname = $cate->where('cid='.$keyW['cid'])->getField('name');
                    }else{
                        $catname = '所有'; 
                    }
                }
            }else{
                $cat = new \Org\Util\Category('Goods_category', array('cid', 'pid', 'name', 'fullname'));
                $catecid = $cat->getList(NULL, 0,NULL);
                foreach ($catecid as $cik => $civ) {
                    $keyW['cid'][$cik]=$civ['cid'];
                }
                $where['cid'] = array('in',$keyW['cid']);
                $chname = '所有';
                $catname = '所有'; 
            }

            if($keyW['cid'] != '') $where['cid'] = array('in',$keyW['cid']);
            if($keyW['keyword'] != '') $where['title'] = array('LIKE', '%' . $keyW['keyword'] . '%');
            $M = M("Goods");
            $count = $M->where($where)->count();
            $pConf = page($count,C('PAGE_SIZE'));
            
            $channel = $cate->where('pid=0')->select(); 
            $keyS = array('count' =>$count,'keyword'=>$keyW['keyword'],'chname' => $chname,'catname' => $catname,'pid'=>$keyW['pid']);
            $this->keys = $keyS;
            $this->page = $pConf['show'];
            
            $this->channel=$channel; 
            $this->list = D("Goods")->listGoods($pConf['first'], $pConf['list'],$where);
            C('TOKEN_ON',false);
            $this->display('index');
    }
    
    public function add() {
        if (IS_POST) {
            $this->checkToken();
            echo json_encode(D("Goods")->addGoods());
        } else {
            $this->info=array('layer'=>C('goods_region')); 
            $this->assign("list", D("Goods")->category());
            $this->display();
        }

    }
    
    public function getFilt(){

        echo json_encode(array("status" => 1, "html" => getFiltrateHtml(I('post.cid'),I('post.filtStr'))));
    }
    
    public function getExtends(){
        $rtdata=getExtendsHtml(I('post.cid'),I('post.gid'));
        echo json_encode(array("status" => 1, "ulhtml" => $rtdata['eUrlHtml'],"divhtml" => $rtdata['eDivHtml'],'textarr'=>$rtdata['textarea'],'region'=>$rtdata['region']));
    }
    
    public function checkNewsTitle() {
        $M = M("Goods");
        $where = "title='" .I('get.title') . "'";
        if (!empty($_GET['id'])) {
            $where.=" And id !=" . (int) $_GET['id'];
        }
        if ($M->where($where)->count() > 0) {
            echo json_encode(array("status" => 0, "info" => "已经存在，请修改标题"));
        } else {
            echo json_encode(array("status" => 1, "info" => "可以使用"));
        }
    }
    
    public function edit() {
        $M = M("Goods");
        if (IS_POST) {
            $this->checkToken();
            echo json_encode(D("Goods")->edit());
        } else {
            $info = $M->where("id=" . (int) $_GET['id'])->find();
            if ($info['id'] == '') {
                $this->error("不存在该记录");
            }
            if ($info['pictures']) {
                $info['pictures'] = explode('|', $info['pictures']);
            }
            $info['content']=stripslashes($info['content']);
            $info['layer']=C('goods_region'); 
            $this->assign("info", $info);
            $this->assign("list", D("Goods")->category());
            $this->display("add");
        }
    }
    
    public function goodPicOrder(){
        C('TOKEN_ON',false);
        if (IS_POST) {
            $data = array(
                'id' => I('post.goodsId'),
                'pictures' => I('post.imgArr')
                );
            if(M('Goods')->save($data)){
                echo json_encode(array('status' => 1, 'msg' => "排序成功，已保存到数据库"));
            }else{
                echo json_encode(array('status' => 0, 'msg' => "排序失败，请刷新页面尝试操作"));
            }
        }
    }
    
    public function del_goods() {
        if (M("Goods")->where("id=" . (int) $_GET['id'])->delete()) {
            $this->success("成功删除");

        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }
    
    public function del_pic() {
        $imgUrl = I('post.imgUrl');
        $imgDelUrl = C('UPLOADS_PICPATH').I('post.imgUrl'); 
        $goodsId = I('post.goodsId'); 
        if($goodsId){
            $goods = M('Goods');
            $gd_pic = $goods->where(array('id'=>$goodsId))->find();
            
            $newPic = str_replace('||','|',trim(str_replace($imgUrl, '', $gd_pic['pictures']),'|'));
            $data = array(
                'id' => I('post.goodsId'),
                'pictures' => $newPic
                );

            if($goods->save($data)){
                $ecJson = array(
                    'status' => 1,
                    'msg' => '删除成功!'
                    );
                @unlink($imgDelUrl);
                
                $picFix = explode(',',C('GOODS_PIC_PREFIX'));
                foreach ($picFix as $pfK => $pfV) {
                    @unlink(picRep($imgUrl,$pfK));
                }
                
                echo json_encode($ecJson);
            }else{
                $ecJson = array(
                    'status' => 0,
                    'msg' => '删除失败，刷新页面重试!'
                    );
                echo json_encode($ecJson);
            }
        }else{
            if(@unlink($imgDelUrl)){
                echo json_encode(array(
                'status' => 1,
                'msg' => '已从服务器删除成功!'
                ));
            }else{
                echo json_encode(array(
                'status' => 0,
                'msg' => '删除失败，请检查文件权限!'
                ));
            }
            
        }
    }
    
    public function cutview() {
        $this->display();
    }
    public function cutoper(){
        $cutsize = explode('|',I('post.cutSize'));
        $cutImgP = I('post.cutImgP');
        $upFixPath = C('UPLOADS_PICPATH');
        $parImgUrl = $upFixPath.picRep($cutImgP,0);
        $maxImgUrl = $upFixPath.picRep($cutImgP,1);

        $imCut = new \Think\Image(); 
        $imCut->open($parImgUrl);
        $cStutas = $imCut->crop($cutsize[2],$cutsize[3],$cutsize[0], $cutsize[1])->save($maxImgUrl);
        
        if($cStutas){
            $imCut->open($maxImgUrl);
            $picFixArr=explode(',', C('GOODS_PIC_PREFIX'));
            foreach ($picFixArr as $pFixK => $pFixV) {
                if($pFixK > 0){
                    $imSizeW = picSize($pFixK,'width');
					$imSizeH = picSize($pFixK,'height');
                    $imCut->thumb($imSizeW,$imSizeH,\Think\Image::IMAGE_THUMB_FIXED)->save($upFixPath.picRep($cutImgP,$pFixK));
                }
            }
        }

        echo json_encode(array(
            'status'=>1
            ));
    }

    public function category() {
        if (IS_POST) {
            echo json_encode(D("Goods")->category());
        } else {
            $this->assign("list", D("Goods")->category());
            
            $this->cateW = C('CATE_ICO_WIDTH');
            $this->cateH = C('CATE_ICO_HEIGHT');
            $this->display();
        }
    }
    
    public function delIco(){
        M('Goods_category')->where('cid='.I('post.cid'))->setField('ico','');
        @unlink(C('UPLOADS_PICPATH').I('post.imgUrl'));
        echo json_encode(array("status" => 1, "info" => "已删除"));
    }
    
    public function filtrate(){
        if (IS_POST) {
            echo json_encode(D("Goods")->filtrate());
        } else {
            $this->assign("list", D("Goods")->filtrate());
            $this->display();
        }
    }
    
    public function order_filtrate() {
        if (IS_POST) {
            $getInfo = I('post.');
            $M = M('goods_filtrate');
            $where=array('fid'=>$getInfo['odAid']);
            if($getInfo['odType'] == 'rising'){
                if($M->where($where)->setInc('sort')){
                    echo json_encode(array('status'=>'1','msg'=>'排序写入数据库成功'));
                }
            }elseif($getInfo['odType'] == 'drop'){
                if($M->where($where)->setDec('sort')){
                    echo json_encode(array('status'=>'1','msg'=>'排序写入数据库成功'));
                }
            }
        } else {
            echo json_encode(array('status'=>'0','msg'=>'什么情况'));
        }
    }

    public function cate_filt(){
        if (IS_POST) {
            echo json_encode(D("Goods")->cate_filt());
        } else {
            $c_f = M('Goods_category_filtrate');
            $cfMap = $c_f->select();
            $cMap = $c_f->getField('cid',true);
            $cMap = array_unique($cMap); 
            sort($cMap); 

            
            $newMap = array();
            $i = 0;
            foreach ($cMap as $cK => $cV) {
               foreach ($cfMap as $fK => $fV) {
                    if($cV ==$fV['cid']){
                        $newMap[$i]['cid']=$cV;
                        $newMap[$i]['fid'][]=$fV['fid'];
                    }
                } 
                $i +=1;
            }
            
            $filtMap = M('Goods_filtrate')->select();
            foreach ($newMap as $mK => $mV) {
                foreach ($mV['fid'] as $sfk => $sfv) {
                    foreach($filtMap as $v){
                      if($v['pid']==$sfv){
                        $newMap[$mK]['sid'][$sfk][]=$v['fid'];
                      }
                    }
                }
            }
            $this->map=$newMap;
            $this->cate = D("Goods")->category();
            $this->filt = D("Goods")->filtrate();
            $this->display();
        }
    }
    
    public function getChild(){
        if (IS_POST) {
            if(I('post.fid') != ''){
                echo json_encode(array('status' => 1, 'msg' => getChildHtml(I('post.fid'))));
            }
        } else {
            E('哎哟！怎么到这里了?');
        }
    }
    
    public function delLink(){
        if (IS_POST) {
            $where = array('cid'=>I('post.cid'));
            if(I('post.fid') != 0){
                $where['fid'] = I('post.fid');
            }
            if(M('Goods_category_filtrate')->where($where)->delete()){
               echo json_encode(array('status' => 1, 'msg' => '解除关联成功')); 
            }else{
               echo json_encode(array('status' => 0, 'msg' => '解除关联失败，请刷新重试')); 
            }
        } else {
            E('哎哟！怎么到这里了?');
        }
    }
    
    public function fields_list(){
        $this->gdcof = include APP_PATH . 'Common/Conf/SetExtend.php';
        $list = M('goods_extend')->order('rank desc')->select();
        $this->list=$list;
        $this->display();
    }
    
    public function fields_add(){
        if (IS_POST) {
            echo json_encode(D('goods')->fields_add());
        }else{
            $info = M('Goods_extend')->where(array('eid'=>I('get.eid')))->find();
            $info['default']=stripslashes($info['default']);
            $this->info=$info;
            $this->display();
        }
    }
    
    public function delField(){
        if (M("Goods_extend")->where("eid=" . (int) $_GET['id'])->delete()) {
            $this->success("成功删除");
            
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }
    
    public function order_fields() {
        if (IS_POST) {
            $getInfo = I('post.');
            $M = M('Goods_extend');
            $where=array('id'=>$getInfo['odAid']);
            if($getInfo['odType'] == 'rising'){
                if($M->where($where)->setInc('rank')){
                    echo json_encode(array('status'=>'1','msg'=>'排序写入数据库成功'));
                }
            }elseif($getInfo['odType'] == 'drop'){
                if($M->where($where)->setDec('rank')){
                    echo json_encode(array('status'=>'0','msg'=>'排序写入数据库失败'));
                }
            }
        } else {
            E('页面不存在');
        }
    }
    
    public function onOff_fields() {

        if (IS_POST) {
            $data = array(
                'eid'=>I('post.eid'),
                'status'=>I('post.val')
                );
            $sta = $data['status'] == 0 ? '关闭':'开启';
            if(M('Goods_extend')->save($data)){
                echo json_encode(array('status'=>'1','msg'=>'成功'.$sta)); 
            }else{
                echo json_encode(array('status'=>'0','msg'=>$sta.'失败')); 
            }
        } else {
            E('页面不存在');
        }
    }
    
    public function region_fields() {
        if (IS_POST) {
            $config = APP_PATH . "Common/Conf/SetExtend.php";
            $config = file_exists($config) ? include "$config" : array();
            $config = is_array($config) ? $config : array();
            $data = array(I('post.key')=>I('post.val'));
            if (set_config("SetExtend", $data, APP_PATH . "Common/Conf/")) {
                delDirAndFile(WEB_CACHE_PATH . "Cache/Admin/");
                echo json_encode(array('status' => 1, 'msg' => '设置成功'));
            } else {
                echo json_encode(array('status' => 0, 'msg' => '设置失败，请检查'));
            }
        } else {
            E('页面不存在');
        }
    }
    
    public function region(){
        if (IS_POST) {
            $region = M('region');
            $field = array('region_id','region_name');
            if (I('post.tier') == 1) {
                $tier = 2;
                $selected = '——选择城市——';
            }elseif (I('post.tier') == 2) {
                $tier = 3;
                $selected = '——选择区、县——';
            }
            $option = $region->field($field)->where(array('parent_id'=>I('post.pid')))->select();
            $optionHtml = '<option selected="selected" tier="'.$tier.'" value="0">'.$selected.'</option>';
            foreach ($option as $ok => $ov) {
                $optionHtml .= '<option tier="'.$tier.'" value="'.$ov['region_id'].'">'.$ov['region_name'].'</option>';
            }
            echo json_encode(array('status' => 1, 'msg' => $optionHtml)); 
        }
    }
    
     public function cate_extend(){
        if (IS_POST) {
            echo json_encode(D("Goods")->cate_extend());
        } else {
            $extend = M('goods_extend');

            $c_e = M('Goods_category_extend');
            $ceMap = $c_e->select();
            $cMap = $c_e->getField('cid',true);
            $cMap = array_unique($cMap); 
            sort($cMap); 
            
            $newMap = array();
            $i = 0;
            foreach ($cMap as $cK => $cV) {
               foreach ($ceMap as $fK => $fV) {
                    if($fV['eid']!=0){  
                        if($cV ==$fV['cid']){
                            $newMap[$i]['cid']=$cV;
                            $newMap[$i]['extend'][$fV['eid']]=$extend->where('eid='.$fV['eid'])->getField('name');
                        }  
                    }else{
                        if($cV ==$fV['cid']){
                            $newMap[$i]['cid']=$cV;
                            $newMap[$i]['extend'][0]='地区';
                        }
                    }
                } 
                $i +=1;
            }

            $this->map=$newMap;
            $this->cate = D("Goods")->category(); 
            $this->fdlist = $extend->field('eid,name')->select(); 
            $this->display();
        }
     }
    
    public function delExtend(){
        if (IS_POST) {
            $where = array('cid'=>I('post.cid'));
            if(I('post.eid') != ''){
                $where['eid'] = I('post.eid');
            }
            if(M('Goods_category_extend')->where($where)->delete()){
               echo json_encode(array('status' => 1, 'msg' => '解除关联成功')); 
            }else{
               echo json_encode(array('status' => 0, 'msg' => '解除关联失败，请刷新重试')); 
            }
        } else {
            E('哎哟！怎么到这里了?');
        }
    }
}?>
