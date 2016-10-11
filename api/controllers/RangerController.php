<?php
namespace api\controllers;

use yii;
use yii\web\Controller;
use common\models\User;
use api\components\RangerException;

/**
 * Ranger controller
 */
class RangerController extends Controller
{

    public $enableCsrfValidation = false;

    const PAGE_SIZE = 20;

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
}