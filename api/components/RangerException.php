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
    const APP_NEED_LOGIN = 10103;
    const APP_ERROR_PASSWORD = 10104;
    const APP_ERROR_TOKEN = 10105;

    private function getExceptionMessage($code)
    {
        $messages = [
            self::SYS_EMPTY_SIGN => '该请求需要签名',
            self::SYS_ERROR_SIGN => '签名未通过验证',
            self::SYS_ERROR_SECRET => '获取秘钥失败',

            self::APP_ERROR_PARAMS => '缺少必要的参数',
            self::APP_EMPTY_RECORD => '查询记录为空',
            self::APP_NEED_LOGIN => '需要令牌认证',
            self::APP_ERROR_TOKEN => '令牌认证失败',
            self::APP_ERROR_PASSWORD => '密码错误',
        ];
        if(isset($messages[$code])){
            return $messages[$code];
        }

        return '未知的错误';
    }

    public static function throwException($code, $message = '')
    {
        if($message === ''){
            $message = self::getExceptionMessage($code).$message;
        }
        throw new HttpException('403',$message,$code);
    }
}
