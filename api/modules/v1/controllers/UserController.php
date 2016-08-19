<?php

namespace api\modules\v1\controllers;

use yii;
use api\controllers\RangerController;
use api\components\RangerException;

class UserController extends RangerController
{
    
    public function actionLogin(array $params)
    {
        if(isset($params['query']['username'])) {
            $username = $params['query']['username'];
        }else if(isset($params['query']['mobile'])){
            $username = $params['query']['mobile'];
        }else if(isset($params['query']['email'])){
            $username = $params['query']['email'];
        }else{
            $username = '';
        }
        if(!$username){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS,'username or mobile or email');
        }
        $user = \api\models\User::find()->where(['username'=>$username])->orWhere(['mobile'=>$username])->orWhere(['email'=>$username])->one();
        if(!$user){
            RangerException::throwException(RangerException::APP_EMPTY_RECORD);
        }

        $password = isset($params['query']['password'])?$params['query']['password']:'';
        if(!$password){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS,'password');
        }
        if(!Yii::$app->getSecurity()->validatePassword($password, $user->password_hash)){
            RangerException::throwException(RangerException::APP_ERROR_PASSWORD);
        }else{
            Yii::$app->user->login($user, 3600 * 24 * 30);
            return [
                'token' => $user->auth_key
            ];
        }
    }

    public function actionList(array $params)
    {
        parent::checkoutLogin($params);
        $result = array_map(function($record) {
            return $record->attributes;
        },\common\models\User::find()->all());
        return $result;
    }

    public function actionCreate(array $params)
    {

    }

    public function actionUpdate(array $params)
    {

    }

    public function actionDelete(array $params)
    {

    }
}