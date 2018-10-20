<?php

namespace Common\Controller;
use Think\Controller;
class TaglibController extends Controller {
    
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
}?>
