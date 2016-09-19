var Ranger = Ranger || {};

/**
 * API类目
 */
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

/**
 * 通用类目
 */
Ranger.common = Ranger.common || {};
Ranger.common.checkMobileDevice = function(){
    var agent = navigator.userAgent;
    var device = /(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i;

    return device.test(agent);
};

/**
 * 正则类目
 */
Ranger.regular = Ranger.regular || {};
Ranger.regular.check = function(type, value){
    var regular = {
        username : /^[a-zA-Z\u4e00-\u9fa5]+$/,
        mobile : /^((\(\d{2,3}\))|(\d{3}\-))?1[3578]\d{9}$/,
        email : /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/,
        postCode : /^[1-9][0-9]{5}$/
    };

    return regular[type].test(value);
};