<?php

namespace api\components;

use yii;
use yii\web\HttpException;

/**
 * This is the exception class for ranger.
 */
class RangerException extends HttpException
{
    const SYS_EMPTY_SIGN = 10001;
    const SYS_ERROR_SIGN = 10002;
    const SYS_ERROR_SECRET = 10003;

    const APP_ERROR_PARAMS = 10101;
    const APP_EMPTY_RECORD = 10102;
    const APP_NEED_ACCESS_TOKEN = 10103;
    const APP_ERROR_ACCESS_TOKEN = 10104;

    const APP_ERROR_PASSWORD = 10105;
    const APP_ERROR_CREATE = 10106;
    const APP_ERROR_UPDATE = 10107;
    const APP_ERROR_DELETE = 10108;

    private function getExceptionMessage($code)
    {
        $messages = [
            self::SYS_EMPTY_SIGN => '该请求需要签名',
            self::SYS_ERROR_SIGN => '签名未通过验证',
            self::SYS_ERROR_SECRET => '获取秘钥失败',

            self::APP_ERROR_PARAMS => '参数不合法',
            self::APP_EMPTY_RECORD => '查询记录为空',
            self::APP_NEED_ACCESS_TOKEN => '需要令牌认证',
            self::APP_ERROR_ACCESS_TOKEN => '令牌认证失败',
            self::APP_ERROR_PASSWORD => '密码错误',
            self::APP_ERROR_CREATE => '创建失败',
            self::APP_ERROR_UPDATE => '更新失败',
            self::APP_ERROR_UPDATE => '更新失败',
            self::APP_ERROR_DELETE => '删除失败',
        ];
        if(isset($messages[$code])){
            return $messages[$code];
        }

        return '未知的错误';
    }

    public static function throwException($code, $message = '', $http_status = 400)
    {
        if($message != ''){
            $message = '(#'.$code.')'.self::getExceptionMessage($code).':'.$message;
        }else{
            $message = '(#'.$code.')'.self::getExceptionMessage($code);
        }
        throw new HttpException($http_status, $message, $code);
    }
}
