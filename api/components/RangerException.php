<?php

namespace api\components;

use yii;
use yii\web\HttpException;

/**
 * This is the exception class for ranger.
 */
class RangerException
{
    const EMPTY_SIGN = 10001;
    const ERROR_SIGN = 10002;
    const ERROR_SECRET = 10003;

    private function getExceptionMessage($code)
    {
        $messages = [
            self::EMPTY_SIGN => '该请求需要签名',
            self::ERROR_SIGN => '签名未通过验证',
            self::ERROR_SECRET => '获取秘钥失败',
        ];
        if(isset($messages[$code])){
            return $messages[$code];
        }
        return '未知的错误';
    }

    public static function throwException($code)
    {
        throw new HttpException('403',self::getExceptionMessage($code),$code);
    }
}
