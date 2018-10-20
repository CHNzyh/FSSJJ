    
// 筛选条件右侧的高度控制
function rightHeight(){
    var n1h = Math.floor($('#fielt_box').height()/2);
    var n2h = $('#fielt_box').height()-n1h;

    $('.notice li.n1').css({ 'height': n1h, 'line-height': n1h+'px' });
    $('.notice li.n2').css({ 'height': n2h, 'line-height': n2h+'px' });
}
// ------点击获取子级条件
$(document).on('click','.filtParent',function(){
    var filtFid = $(this).attr('fid');
    var newFilt = $(this).parents('ul');

    newFilt.nextUntil('ul').each(function(i, o){
        if($(o).attr('fid')==filtFid){
            $(o).css("display", "block");
        }else{
            $(o).css("display", "none");
            $(o).find('.filtParent').removeClass('current');
        }
    });
    newFilt.find('.filtParent').removeClass('current');
    $(this).addClass('current');
    getFiltArr(); 
    rightHeight();
});
// -----生成条件表单info[filtrate]的值
function getFiltArr(){
    var filtId = '';
    $('.filtParent.current').each(function(i, o){
        filtId += $(o).attr('fid')+',';
    });
    filtId=filtId.substring(0,filtId.length-1);
    $('input[name="info[filtrate]"]').val(filtId);  
}
$(function() {
    //用户关注拍品
    $('.auctionbox').on('mouseenter','.att',function(){
        if($(this).attr('yn')=='y'){
            $(this).html('取消');
        }
    });
    $('.auctionbox').on('mouseout','.att',function(){
        if($(this).attr('yn')=='y'){
            $(this).html('已关注');
        }
    });
    $('.auctionbox ').on("click",".att",function(){
        if(login == 1){
            var thisObj = $(this);
            var gid = $(this).attr('pid');
            var rela = $(this).attr('rela');
            var yn = $(this).attr('yn');
            $.post(attUrl,{'gid':gid , 'rela':rela, 'yn':yn},function(data){
                if (data.status) {
                    if(yn =='n'){
                        thisObj.addClass('on');
                        thisObj.html('已关注');
                        thisObj.attr('yn','y');
                    }else if(yn =='y'){
                        thisObj.removeClass('on');
                        thisObj.html('关注');
                        thisObj.attr('yn','n');
                    }
                } else {
                    popup.error(data.msg);
                    setTimeout(function(){
                        popup.close("asyncbox_error");
                    },2000);
                }
            },'json');  
            
        }else{
            popup.alert('<div class="sayOnelin">您没有登录！请登录</div>');
        }
         
    });
	// 地区鼠标事件二级菜单
    $('.list_region li').hover(function(){
        $(this).find("ul").first().show();
    },function(){
        $(this).find("ul").first().hide();
    });
	// 选项卡操作
    var $tabs = $(".tab_menu a");
    $tabs.bind("click", function(){
        var tabId = $(this).attr("href");
        var tabIdStr = tabId.split("#");
        var currentTabId = '#'+tabIdStr[1];
        $(currentTabId).show().siblings(".tab_con").hide();
        $(this).parent("li").addClass("on").siblings().removeClass("on");
        return false;
    })
    .focus(function(){
        $(this).blur();
    });
	// 初始化筛选条件右侧高度
    rightHeight();
	// 分类鼠标事件
    var btb=$(".bla");
    var tempS;
    $(".bla").hover(function(){
            var thisObj = $(this);
            tempS = setTimeout(function(){
            thisObj.find(".brand").each(function(i){
                var tA=$(this);
                var childs=tA.children("ul").children();
                var length=childs.length>0?childs.length:1;
                length=length>10?length-1:length;
                var ht=Math.ceil(length/10)*57;
                length>10?$('.brmore').hide():$('.brmore').html('没有更多拍卖');
                setTimeout(function(){ tA.animate({height:ht},300);},50*i);
            });
        },200);

    }
    ,function(){
        if(tempS){ clearTimeout(tempS); }
        $(this).find(".brand").each(function(i){
            var tA=$(this);
            length<10?$('.brmore').show():$('.brmore').html('更多拍卖');
            setTimeout(function(){ tA.animate({height:"57"},300,function(){
            });},50*i);
        });

    });
    // 分类鼠标事件——end
});












	
	
	
	
	