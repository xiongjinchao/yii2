var Ranger = Ranger || {};
Ranger.api = Ranger.api || {};
Ranger.api.url = '/site/api';
Ranger.api.request = function(method, query, params){
    $.ajax({
        url:Ranger.api.url,
        data:{method:method,query:query,params:params},
        dataType:'json',
        type:'post',
        async:false,
        success: function(response){
            Ranger.api.response = response;
        }
    });

    return Ranger.api.response;
};