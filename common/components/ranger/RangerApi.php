<?php

namespace common\components\ranger;

use yii;

/**
 * This is the exception class for ranger.
 */
class RangerApi
{
    public static function request(array $params, $type = 'post')
    {
        $params['agent'] = Yii::$app->request->getUserAgent();
        $params['ip'] = Yii::$app->request->getUserHost();
        $params['timestamp'] = time();
        $params['version'] = isset($params['version'])?$params['version']:'1.0';
        $params['format'] = isset($params['format'])?$params['format']:'array';
        
        $params['sign'] = self::generateSign($params);
        $format = $params['format'];
        $params = http_build_query($params);
        $url = Yii::$app->params['domain']['api'];

        $ch = curl_init();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, $type =='post'?1:0 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $params );
        $data = curl_exec($ch);
        curl_close($ch);
        if($format == 'array') {
            try {
                $result = yii\helpers\Json::decode($data);
            } catch (\Exception $e) {
                $result = $data;
            }
        }else{
            $result = $data;
        }
        return $result;
    }
    
    public static function generateSign($params)
    {
        if(!empty($params['params'])) {
            ksort($params['params']);
        }
        ksort($params);

        $query = http_build_query($params);
        return strtoupper(md5($query));
    }
}