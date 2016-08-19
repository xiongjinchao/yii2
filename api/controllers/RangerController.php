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

    const PER_PAGE = 20;

    public function checkAccessToken($params)
    {
        if(!isset($params['query']['access_token']) || $params['query']['access_token'] == ''){
            RangerException::throwException(RangerException::APP_NEED_ACCESS_TOKEN);
        }
        $user = User::find()->where(['access_token'=>$params['query']['access_token']])->one();
        if(!$user){
            RangerException::throwException(RangerException::APP_ERROR_ACCESS_TOKEN);
        }
        if($params['query']['access_token'] != $user->access_token){
            RangerException::throwException(RangerException::APP_ERROR_ACCESS_TOKEN);
        }else if(time() > $user->expire_at){
            RangerException::throwException(RangerException::APP_ACCESS_TOKEN_EXPIRE);
        }
        //可以使用redis缓存数据
        $user->expire_at = time()+3600*24*30;
        $user->save();

        return true;
    }
}