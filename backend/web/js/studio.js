/*页面初始化*/
function init() {
    if($(".sidebar-main-menu li.active").length > 0){
        var items = $(".sidebar-main-menu li.active a").data('items');
        var title = $(".sidebar-main-menu li.active a").text();
        if(items.length > 0){
            $(".sub-menu-header").text(title);
            $(".sidebar-sub-wrapper ul").empty();
            $.each(items, function(i,item){
                var active = (window.location.href).indexOf(item.url) >= 0? 'class="active"':'';
                $(".sidebar-sub-wrapper ul").append('<li '+active+'><a href="'+item.url+'">'+item.label+'</a></li>');
            });
            $(".sidebar-sub-wrapper").show();
        }else{
            $(".sidebar-sub-wrapper").hide();
        }
    }
    var right_width = $(".right-wrapper:visible").length == 1 ? 180 : 0;
    var content_left = $(".sidebar-sub-wrapper:visible").length == 1? 160 : 70;
    var content_width = $(window).width() - right_width - content_left;
    $(".studio-content-wrapper").css({width: content_width + 'px', left: content_left});
    $(".content-header").css({width: content_width + 'px'});
}

$(function(){
    init();
    $(".sidebar-main-menu li").hover(function(){
        $(".sidebar-main-menu li").removeClass("active");
        $(this).addClass("active");
        init();
    });
    $(".right-content-header").click(function(){
        $(this).parent().hide();
        $(".content-header .header-help").show();
        init();
    });
    $(".content-header .header-help").click(function(){
        $(this).hide();
        $(".right-content-header").parent().show();
        init();
    });
    $("body").on("shown.bs.modal", ".modal", function(){
        init();
    });
    $("body").on("hidden.bs.modal", ".modal", function(){
        init();
    })
});
$(window).resize(function(){
    init();
});