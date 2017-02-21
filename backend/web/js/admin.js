$(function(){
	//角色权限全选
	$(".role_title :checkbox").click(function(){

		if($(this).prop('checked')){
			$(this).parents(".role_item").find(":checkbox").prop('checked',true);
		}else{
			$(this).parents(".role_item").find(":checkbox").prop('checked',false);

		}
	});

	$(".checkbox_permission").click(function(){
		var number = $(this).parents(".role_item").find(".checkbox_permission").length;
		var count = $(this).parents(".role_item").find(".checkbox_permission:checked").length;
        if(number == count){
            $(this).parents(".role_item").find(":checkbox").prop('checked',true);
        }
        if(number > count){
            $(this).parents(".role_item").find(".role_title :checkbox").prop('checked',false);
        }
        if(count == 0){
            $(this).parents(".role_item").find(":checkbox").prop('checked',false);
        }
	});

	//提示层间隔2S消失
	setTimeout(function(){
		$(".callout.alert").fadeOut()
	},2000);
});