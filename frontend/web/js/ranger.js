var Ranger = Ranger || {};

/**
 * API类目
 */
Ranger.api = {
    url:'/site/api',
    //Ranger API
    request:function(method, query, params){
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
    }
};

/**
 * 通用类目
 */
Ranger.common = {
    //获取当前浏览器代理头
    device:function(){
        var agent = navigator.userAgent;

        return agent;
    },
    //当前设备是否是移动设备
    mobile:function(){
        var agent = navigator.userAgent;
        var device = /(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i;

        return device.test(agent);
    }
};

/**
 * 正则类目
 */
Ranger.regular = {
    //正则验证
    validate:function(type, value) {
        var regular = {
            username: /^[a-zA-Z\u4e00-\u9fa5]+$/,
            mobile: /^((\(\d{2,3}\))|(\d{3}\-))?1[3578]\d{9}$/,
            email: /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/,
            postcode: /^[1-9][0-9]{5}$/,
            integer:/^-?[1-9]\\d*$/,
            number:/^[1-9]\\d*|0$/,
            ascii:/^[\\x00-\\xFF]+$/,
            chinese:/^[\\u4e00-\\u9fa5]+$/,
            color:/^[a-fA-F0-9]{6}$/,
            date:/^\d{4}(\-|\/|\.)\d{1,2}\1\d{1,2}$/,
            ip:/^(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)\\.(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)\\.(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)\\.(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)$/,
            letter:/^[A-Za-z]+$/,
            picture:/(.*)\\.(jpg|bmp|gif|ico|pcx|jpeg|tif|png|raw|tga)$/,
            qq:/^[1-9]*[1-9][0-9]*$/,
            telephone:/^[0-9\-()（）]{7,18}$/,
            url:/(((^https?:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)$/g,
        };

        return regular[type].test(value);
    }
};