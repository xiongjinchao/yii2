<?php

namespace common\components\ranger;

use yii;
use yii\web\HttpException;

/**
 * This is the exception class for ranger.
 */
class RangerHtml5 extends RangerApi
{
    const KEY = '9XNNXe66zOlSassjSKD5gry9BiN61IUEi8IpJmjBwvU07RXP0J3c4GnhZR3GKhMHa1A';
    const SECRET = '27e1be4fdcaa83d7f61c489994ff6ed6';

    public static function api($method, array $query, $type = 'post', $params = [])
    {
        $params['method'] = $method;
        $params['params'] = $query;
        
        $params['key'] = self::KEY;
        $params['secret'] = self::SECRET;
        $params['device'] = 'computer';
        $params['device_id'] = '';
        $params['origin'] = 'html5';
        $params['agent'] = Yii::$app->request->getUserAgent();
        $params['ip'] = Yii::$app->request->getUserHost();
        $params['timestamp'] = time();
        $params['version'] = isset($params['version'])?$params['version']:'1.0';
        $params['format'] = isset($params['format'])?$params['format']:'json';

        return parent::request($params, $type);
    }
}