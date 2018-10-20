<?php

namespace Admin\Controller;
use Think\Controller;
class UploadController extends Controller {
    
    public function _initialize() {
        header("Content-Type:text/html; charset=utf-8");
        header("Content-Type:text/html; charset=utf-8");
        if (!$_SESSION['my_info']['aid']) {
            E('哎哟！怎么到这里了?');
        }
    }

    
    Public function upGoodsPic () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_upload();
        echo json_encode($upload);
    }
    
    Public function upAdvFile () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_uploadAdv();
        echo json_encode($upload);
    }
    
    Public function upCateIco () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_upCateIco();
        echo json_encode($upload);
    }
    
    Public function upLinkIco () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_upLinkIco();
        echo json_encode($upload);
    }
    
    Public function upNewsIco () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_upNewsIco();
        echo json_encode($upload);
    }
    
    
    Private function _upload () {
        $config = array(
            'maxSize' => 3145728,
            'rootPath' => C('UPLOADS_PICPATH'),
            'savePath' => C('GOODS_PICPATH') . '/',
            'saveName' => array('uniqid',''),
            'exts' => array('jpg', 'gif', 'jpeg'),
            'autoSub' => true,
            'subName' => array('date','Ymd'),
        );

        $upload = new \Think\Upload($config);
        $info   =   $upload->upload();
        $info = $info['Filedata'];
        if(!$info) {
            return array('status' => 0, 'msg' => $upload->getError());
        }else{
            $uploadImg = $info['savepath'] . $info['savename'];
            $cutImgUrl = C('UPLOADS_PICPATH').$info['savepath'] . $info['savename'];

            
            $imgThumb = new \Think\Image(); 
            $imgThumb->open($cutImgUrl);
            $picFixArr=explode(',', C('GOODS_PIC_PREFIX'));
            foreach ($picFixArr as $pFixK => $pFixV) {
				$imSizeW = picSize($pFixK,'width');
				$imSizeH = picSize($pFixK,'height');
                $imgThumb->thumb($imSizeW,$imSizeH,\Think\Image::IMAGE_THUMB_FILLED)->save(C('UPLOADS_PICPATH').$info['savepath'] . $pFixV . $info['savename']);

            }
            
            $goodsId = I('post.goodsId');
            if($goodsId){ 
                
                $goods = M('Goods');
                $gdPic = $goods->where(array('id'=>$goodsId))->getField('pictures');
                $newPicStr = trim($gdPic.'|'.$uploadImg,'|');

                
                $data = array(
                    'id' => $goodsId,
                    'pictures' => $newPicStr
                    );
                if($goods->save($data)){
                    return array(
                        'status' => 1,
                        'path' => $uploadImg,
                        'prepath' => picRep($uploadImg,0),
                        'maxpath' => picRep($uploadImg,1),
                        'minipath'=> picRep($uploadImg,3),
                        'msg' => '上传成功并保存到了数据库！'
                        );
                }
            }else{ 
                return array(
                    'status' => 1,
                    'path' => $uploadImg,
                    'prepath' => picRep($uploadImg,0),
                    'maxpath' => picRep($uploadImg,1),
                    'minipath'=> picRep($uploadImg,3),
                    'msg' => '上传成功！'
                    );  
            }
            

            
        }
    }
    
    Private function _uploadAdv () {
        if(I('post.up_type') == '1'){
            $fileExts = array('jpg', 'gif', 'jpeg');
        }else{
            $fileExts = array('swf');
        }
        $config = array(
            'maxSize' => 3145728,
            'rootPath' => C('UPLOADS_PICPATH'),
            'savePath' => C('ADV_PICPATH') . '/',
            'saveName' => array('uniqid',''),
            'allowExts' => $fileExts,
            'autoSub' => true,
            'subName' => array('date','Ymd'),
        );

        $upload = new \Think\Upload($config);
        $info   =   $upload->upload();
        $info = $info['Filedata'];
        if(!$info) {
            return array('status' => 0, 'msg' => $upload->getError());
        }else{
            $uploadFile = $info['savepath'] . $info['savename'];
            $cutImgUrl = C('UPLOADS_PICPATH').$info['savepath'] . $info['savename'];
            
            if(I('post.up_type') == '1'){
                
                $imgAdv = new \Think\Image(); 
                $imgAdv->open($cutImgUrl);
                $advWidth = $imgAdv->width(); 
                $advHeight = $imgAdv->height(); 
                if($advWidth > C('ADV_MAX_WIDTH') || $advHeight > C('ADV_MAX_HEIGHT')){
                    $imgAdv->thumb(C('ADV_MAX_WIDTH'),C('ADV_MAX_HEIGHT'),\Think\Image::IMAGE_THUMB_CENTER)->save($cutImgUrl);
                }
            }
            
            $advId = I('post.advId');
            if($advId){ 
                $Advertising = M('Advertising');
                $deladvFile = $Advertising->where(array('id'=>$advId))->getField('code');
                @unlink(C('UPLOADS_PICPATH') . $deladvFile);
                
                $data = array(
                    'id' => $advId,
                    'code' => $uploadFile
                    );
                if($Advertising->save($data)){
                    return array(
                        'status' => 1,
                        'path' => $uploadFile,
                        'msg' => '上传成功并保存到了数据库！'
                        );
                }
            }else{ 
                return array(
                    'status' => 1,
                    'path' => $uploadFile,
                    'msg' => '上传成功！'
                    );  
            }
        }
    }
    
    
    Private function _upCateIco () {
        $config = array(
            'maxSize' => 3145728,
            'rootPath' => C('UPLOADS_PICPATH'),
            'savePath' => C('CATE_PICPATH') . '/',
            'saveName' => array('uniqid',''),
            'exts' => array('jpg', 'gif', 'jpeg'),
            'autoSub' => false,
        );

        $upload = new \Think\Upload($config);
        $info   =   $upload->upload();
        $info = $info['Filedata'];
        if(!$info) {
            return array('status' => 0, 'msg' => $upload->getError());
        }else{
            $uploadImg = $info['savepath'] . $info['savename'];
            $thumbImgUrl = C('UPLOADS_PICPATH').$info['savepath'] . $info['savename'];
            
            $imgCate = new \Think\Image(); 
            $imgCate->open($thumbImgUrl);
            $cateWidth = $imgCate->width(); 
            $cateHeight = $imgCate->height(); 
            if($cateWidth > C('CATE_ICO_WIDTH') || $cateHeight > C('CATE_ICO_HEIGHT')){
                $imgCate->thumb(C('CATE_ICO_WIDTH'),C('CATE_ICO_HEIGHT'),\Think\Image::IMAGE_THUMB_CENTER)->save($thumbImgUrl);
            }
            return array(
            'status' => 1,
            'path' => $uploadImg,
            'msg' => '上传成功！'
            );   
        }
    }
    
    Private function _upLinkIco () {
        $config = array(
            'maxSize' => 3145728,
            'rootPath' => C('UPLOADS_PICPATH'),
            'savePath' => C('LINK_PICPATH') . '/',
            'saveName' => array('uniqid',''),
            'exts' => array('jpg', 'gif', 'jpeg'),
            'autoSub' => false,
        );

        $upload = new \Think\Upload($config);
        $info   =   $upload->upload();
        $info = $info['Filedata'];
        if(!$info) {
            return array('status' => 0, 'msg' => $upload->getError());
        }else{
            $uploadImg = $info['savepath'] . $info['savename'];
            $thumbImgUrl = C('UPLOADS_PICPATH').$info['savepath'] . $info['savename'];
            
            $imgCate = new \Think\Image(); 
            $imgCate->open($thumbImgUrl);
            $cateWidth = $imgCate->width(); 
            $cateHeight = $imgCate->height(); 
            if($cateWidth > C('LINK_ICO_WIDTH') || $cateHeight > C('LINK_ICO_HEIGHT')){
                $imgCate->thumb(C('LINK_ICO_WIDTH'),C('LINK_ICO_HEIGHT'),\Think\Image::IMAGE_THUMB_CENTER)->save($thumbImgUrl);
            }
            return array(
            'status' => 1,
            'path' => $uploadImg,
            'msg' => '上传成功！'
            );   
        }
    }
    
    Private function _upNewsIco () {
        $config = array(
            'maxSize' => 3145728,
            'rootPath' => C('UPLOADS_PICPATH'),
            'savePath' => C('NEWS_PICPATH') . '/',
            'saveName' => array('uniqid',''),
            'exts' => array('jpg', 'gif', 'jpeg'),
            'autoSub' => false,
        );
        $upload = new \Think\Upload($config);
        $info   =   $upload->upload();
        $info = $info['Filedata'];
        if(!$info) {
            return array('status' => 0, 'msg' => $upload->getError());
        }else{
            $uploadImg = $info['savepath'] . $info['savename'];
            $thumbImgUrl = C('UPLOADS_PICPATH').$info['savepath'] . $info['savename'];
            
            $imgCate = new \Think\Image(); 
            $imgCate->open($thumbImgUrl);
            $cateWidth = $imgCate->width(); 
            $cateHeight = $imgCate->height(); 
            if($cateWidth > C('NEWS_ICO_WIDTH') || $cateHeight > C('NEWS_ICO_HEIGHT')){
                $imgCate->thumb(C('NEWS_ICO_WIDTH'),C('NEWS_ICO_HEIGHT'),\Think\Image::IMAGE_THUMB_CENTER)->save($thumbImgUrl);
            }
            return array(
            'status' => 1,
            'path' => $uploadImg,
            'msg' => '上传成功！'
            );   
        }
    }
    
    Public function editorUpload () {
        if (!IS_POST) E('页面不存在');
        $upload = $this->_editorUpload();
        echo json_encode($upload);
    }
    
    Private function _editorUpload () {
        $config = array(
            'maxSize' => 3145728,
            'rootPath' => C('UPLOADS_PICPATH'),
            'savePath' => C('ARTICLE_PICPATH') . '/',
            'saveName' => array('uniqid',''),
            'exts' => array('jpg', 'gif', 'jpeg'),
            'autoSub' => true,
            'subName' => array('date','Ymd'),
        );
        
        $upload = new \Think\Upload($config);
        $info   =   $upload->upload();
        $info = $info['upfile'];
        if(!$info) {
            return array('status' => 0, 'msg' => $upload->getError());
        }else{
            $uploadImg = $info['savepath'] . $info['savename'];
            return array(
                'url'      =>$info['savepath'] . $info['savename'],   
                'title'    => htmlspecialchars($_POST['pictitle'], ENT_QUOTES),   
                'original' => $info['name'],   
                'state'    =>'SUCCESS'  
            );
        }
    }
}?>
