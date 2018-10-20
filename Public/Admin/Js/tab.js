        // 选显卡
$('#tab_menu').on('click','li',function(){
      $(this).addClass("selected").siblings().removeClass("selected");
      var div_index = $(this).index();

      $("#tab_box>div").eq(div_index).show().siblings().hide();

}).hover(function(){
      $(this).addClass("hover");
},function(){
      $(this).removeClass("hover");
});
