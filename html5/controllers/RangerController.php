<?php
namespace html5\controllers;

use yii;
use yii\web\Controller;
use common\components\ranger\RangerApi;

/**
 * Ranger controller
 */
class RangerController extends Controller
{

    const CACHE = false;
    const CACHE_TIME = 60*30;

    const KEY = '9XNNXe66zOlSassjSKD5gry9BiN61IUEi8IpJmjBwvU07RXP0J3c4GnhZR3GKhMHa1A';
    const SECRET = '27e1be4fdcaa83d7f61c489994ff6ed6';

    public static function api($method, array $query, $params = [], $type='post')
    {
        $params['method'] = $method;
        $params['params'] = $query;

        $params['key'] = self::KEY;
        $params['secret'] = self::SECRET;
        $params['device'] = 'system';
        $params['device_id'] = '';
        $params['origin'] = 'api';

        return RangerApi::request($params, $type);
    }
}