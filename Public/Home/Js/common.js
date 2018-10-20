$(function() {
// wide二级导航
    $('.navmain .menu_onelayer li').hover(function(){
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


});











	
	
	
	
	