<?php
namespace api\controllers;

use yii;
use yii\web\Controller;
use common\models\User;
use common\components\ranger\RangerApi;
use yii\helpers\Inflector;
use api\components\RangerException;

/**
 * Ranger controller
 */
class RangerController extends Controller
{

    const CACHE = false;
    const CACHE_TIME = 60*30;
    const PAGE_SIZE = 20;

    const KEY = '9XNNXe66zOlSassjSKD5gry9BiN61IUEi8IpJmjBwvU07RXP0J3c4GnhZR3GKhMHa1A';
    const SECRET = '27e1be4fdcaa83d7f61c489994ff6ed6';

    public $enableCsrfValidation = false;

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function checkAccessToken($params)
    {
        if(!isset($params['query']['access_token']) || $params['query']['access_token'] == ''){
            RangerException::throwException(RangerException::APP_NEED_ACCESS_TOKEN,'',401);
        }
        $accessToken = $params['query']['access_token'];
        $userId = Yii::$app->cache->get($accessToken);
        if(!$userId){
            RangerException::throwException(RangerException::APP_ERROR_ACCESS_TOKEN,'',401);
        }
        $user = User::findOne($userId);
        $duration = 3600*24*30;
        Yii::$app->cache->set($accessToken, $userId, $duration);

        return $user->attributes;
    }

    public function generationQuery($model,$params)
    {
        $query = $model::find();
        if(isset($params['query']['where']) && is_array($params['query']['where']) && !empty($params['query']['where'])) {
            foreach ($params['query']['where'] as $where) {
                $query->andWhere($where);
            }
        }
        return $query;
    }

    protected function execute($method, $version ,$params)
    {
        $key = $method.'#'.$version.'#'.md5(json_encode($params['query']));
        $method = explode('.',Inflector::camel2id($method));

        if($params['cache'] == true ) {
            if(Yii::$app->cache->exists($key)) {
                $result['data'] = Yii::$app->cache->get($key);
                $result['cache'] = $params['cache'];
            }else{
                $result['data'] = Yii::$app->runAction('/v' . $version . '/' . $method[1] . '/' . $method[2], ['params' => $params]);
                Yii::$app->cache->set($key, $result['data'], $params['cache_time']);
                $result['cache'] = self::CACHE;
            }
        } else {
            $result['data'] = Yii::$app->runAction('/v' . $version . '/' . $method[1] . '/' . $method[2], ['params' => $params]);
            $result['cache'] = self::CACHE;
        }
        return $result;
    }

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