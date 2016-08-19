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

    public function checkoutLogin($params)
    {
        if(!isset($params['query']['token'])){
            RangerException::throwException(RangerException::APP_NEED_LOGIN);
        }
        $token = User::find()->select('token')->where(['token'=>$params['query']['token']])->one();
        if($params['query']['token'] != $token){
            RangerException::throwException(RangerException::APP_ERROR_TOKEN);
        }

        return true;
    }
}