$(document).ready(function() {initMenu();});
// 用户中心菜单
function initMenu() {
  $('.user_li_pg').parents('li ul').addClass('sel');
  $('#menu ul').hide();
  $('#menu ul.sel').show();
  $('#menu li a').click(
    function() {
      var checkElement = $(this).next();
      if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
        return false;
        }
      if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
        $('#menu ul:visible').slideUp('normal');
        checkElement.slideDown('normal');
        return false;
        }
      }
    );
  }

// 结束倒计时
function endDown(etime,ntime,boxobj,day_elem,hour_elem,minute_elem,second_elem){
    var now_time = new Date(ntime*1000);
    var end_time = new Date(etime*1000);
    var sys_second = (end_time-now_time)/1000;
    var timer = setInterval(function(){
        if (sys_second > 0) {
            sys_second -= 1;
            var day = Math.floor((sys_second / 3600) / 24);
            var hour = Math.floor((sys_second / 3600) % 24);
            var minute = Math.floor((sys_second / 60) % 60);
            var second = Math.floor(sys_second % 60);
            day_elem && $(day_elem).text(day);//计算天
            $(hour_elem).text(hour<10?"0"+hour:hour);//计算小时
            $(minute_elem).text(minute<10?"0"+minute:minute);//计算分
            $(second_elem).text(second<10?"0"+second:second);// 计算秒
        } else { 
            clearInterval(timer);
            $('#bidTimeStatus').remove();
            $(boxobj).html('');
            $(boxobj).addClass('end');
        }
    }, 1000);
}
// 开始倒计时
function startDown(etime,ntime,boxobj,day_elem,hour_elem,minute_elem,second_elem){
    var now_time = new Date(ntime*1000);
    var end_time = new Date(etime*1000);
    var sys_second = (end_time-now_time)/1000;
    var timer = setInterval(function(){
        if (sys_second > 0) {
            sys_second -= 1;
            var day = Math.floor((sys_second / 3600) / 24);
            var hour = Math.floor((sys_second / 3600) % 24);
            var minute = Math.floor((sys_second / 60) % 60);
            var second = Math.floor(sys_second % 60);
            day_elem && $(day_elem).text(day);//计算天
            $(hour_elem).text(hour<10?"0"+hour:hour);//计算小时
            $(minute_elem).text(minute<10?"0"+minute:minute);//计算分
            $(second_elem).text(second<10?"0"+second:second);// 计算秒
        } else { 
            $('.noStartBidTbox .th').html('拍卖已开始');
            $(boxobj).html('');
            $(boxobj).addClass('into');
        }
    }, 1000);
}