// 地区标签相关——字段异步排序
$(function(){
    $('.region').on("change",function(){
        var thisObj = $(this);
        var thisNex = $(this).next('.region');
        var pid = thisObj.children('option:selected').val();
        var tier = thisObj.children('option:selected').attr('tier');
        if (tier<3) {
            if(tier == 1){
                thisNex.next('.region').html('<option value="0" selected="selected">——选择区、县——</option>');
            }
            if(pid == 0){
                    thisNex.html('<option value="0" selected="selected">——选择城市——</option>');
            }else{
                $.post(regionUrl,{'pid':pid,'tier':tier},function(data){      //ajax后台
                    if (data.status) {
                        thisNex.html(data.msg);
                    } else {
                        alert(data.msg);
                    }
                },'json');   
            }
            
        };
        
    });
});