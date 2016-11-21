/*页面初始化*/
function init() {
    var right_width = $(".right-wrapper").length == 1 ? 180 : 0;
    var content_left = $(".sidebar-sub-wrapper").length == 1? 160 : 70;
    var content_width = $(window).width() - right_width - content_left;
    $(".content-wrapper").css({width: content_width + 'px', left: content_left});
    $(".content-header").css({width: content_width + 'px'});
}
init();
$(window).resize(function(){
    init();
});