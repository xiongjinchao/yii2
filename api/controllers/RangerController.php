<?php
namespace api\controllers;

use yii;
use yii\web\Controller;
use common\models\User;
use api\components\RangerException;

/**
 * Site controller
 */
class RangerController extends Controller
{
    public $enableCsrfValidation = false;

    const PAGE_SIZE = 20;

    public function checkAccessToken($params)
    {
        if(!isset($params['query']['access_token']) || $params['query']['access_token'] == ''){
            RangerException::throwException(RangerException::APP_NEED_ACCESS_TOKEN);
        }
        $accessToken = $params['query']['access_token'];
        $userId = Yii::$app->cache->get($accessToken);
        if(!$userId){
            RangerException::throwException(RangerException::APP_ERROR_ACCESS_TOKEN);
        }
        $user = User::findOne($userId);
        $duration = 3600*24*30;
        Yii::$app->cache->set($accessToken, $userId, $duration);

        return $user->attributes;
    }
}