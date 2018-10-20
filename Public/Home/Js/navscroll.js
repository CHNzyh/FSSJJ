
//滚动导航
$(function () {
    var fobj = $('.navleft').eq(0);
    var fpos = fobj.offset();
    $(window).scroll(function () {
        checkPos(fobj, fpos);
        var Scroll_tab = $('.title').offset().top; //滚动切换
        $('.titcontentbox').each(function (i, n) {
            var tab_infor = $(n).offset().top;
            if (tab_infor > 0 && Scroll_tab >= tab_infor) {
                $('.title a').eq(i).addClass('active').siblings().removeClass('active');
            }
        });
    });
});

function checkPos(fobj, fpos) {
    if ($.browser.msie && $.browser.version == '6.0') {
        var scTop = $(window).scrollTop();
        scTop > fpos.top ? fobj.css({ 'position': 'absolute', 'z-index': 3, 'top': scTop - fpos.top }) : fobj.attr('style', '');
    } else {
        ($(window).scrollTop() > fpos.top) ? fobj.css({ 'position': 'fixed', 'z-index': 3, 'top': 0,'bottom': 0 }) : fobj.css({ 'position': 'relative' });
    }
}
