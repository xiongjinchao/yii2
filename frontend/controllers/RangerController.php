<?php
namespace frontend\controllers;

use yii;
use yii\web\Controller;
use common\components\ranger\RangerApi;

/**
 * Ranger controller
 */
class RangerController extends Controller
{

    public static function api($method, array $query, $params = [], $type='post')
    {
        $params['method'] = $method;
        $params['params'] = $query;

        $params['key'] = Yii::$app->params['ranger.key'];
        $params['secret'] = Yii::$app->params['ranger.secret'];
        $params['device'] = 'computer';
        $params['device_id'] = '';
        $params['origin'] = 'web';

        return RangerApi::request($params, $type);
    }
}