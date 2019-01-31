$(function(){
	//角色权限全选
	$(".role_title :checkbox").on('ifClicked',function(){
		if($(this).is(':checked')) {
            $(this).closest(".role_item").find(":checkbox").iCheck('uncheck');
		}else{
            $(this).closest(".role_item").find(":checkbox").iCheck('check');
		}
	});

	$(".checkbox_permission").on('ifChanged',function(){
		var number = $(this).parents(".role_item").find(".checkbox_permission").length;
		var count = $(this).parents(".role_item").find(".checkbox_permission:checked").length;
        if(number == count){
            $(this).parents(".role_item").find(":checkbox").iCheck('check');
        }
        if(number > count){
            $(this).parents(".role_item").find(".role_title :checkbox").iCheck('uncheck');
        }
        if(count == 0){
            $(this).parents(".role_item").find(":checkbox").iCheck('uncheck');
        }
	});

	//提示层间隔2S消失
	setTimeout(function(){
		$(".callout.alert").fadeOut();
	},2000);

	//左侧退出登陆
	$(".logout a").attr('data-method','post');
});