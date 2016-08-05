<?php

namespace common\components\ranger;

use yii;
use yii\web\HttpException;

/**
 * This is the exception class for ranger.
 */
class RangerApi
{
    public static function request(array $params, $type = 'post')
    {
        $params['sign'] = self::generateSign($params);
        $params = http_build_query($params);
        $url = Yii::$app->params['domain']['api'];

        $ch = curl_init();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, $type =='post'?1:0 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $params );
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
    
    public static function generateSign($params)
    {
        ksort($params['params']);
        ksort($params);

        $query = http_build_query($params);
        return strtoupper(md5($query));
    }
}