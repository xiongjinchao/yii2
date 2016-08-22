<?php

namespace api\modules\v1\controllers;

use yii;
use api\controllers\RangerController;
use api\components\RangerException;

class UserController extends RangerController
{
    
    public function actionLogin(array $params)
    {
        $username = '';
        if(isset($params['query']['username'])) {
            $username = $params['query']['username'];
        }else if(isset($params['query']['mobile'])){
            $username = $params['query']['mobile'];
        }else if(isset($params['query']['email'])){
            $username = $params['query']['email'];
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
            //可以使用redis缓存数据
            $user->access_token = Yii::$app->security->generateRandomString();
            $user->expire_at = time()+3600*24*30;
            $user->save();
            Yii::$app->user->login($user, 3600*24*30);
            return [
                'access_token' => $user->access_token
            ];
        }
    }

    public function actionList(array $params)
    {
        $query = \common\models\User::find();
        if(isset($params['query']['where']) && is_array($params['query']['where'])) {
            foreach ($params['query']['where'] as $where) {
                $query->where($where);
            }
        }
        $result = array_map(function($record){
            return $record;
        },$query->all());
        return $result;
    }

    public function actionCreate(array $params)
    {
        $model = new \common\models\User();
        if($model->load($params,'query')){
            $password = isset($params['query']['password'])?$params['query']['password']:'';
            if(!$password){
                RangerException::throwException(RangerException::APP_ERROR_PARAMS,'password');
            }
            $model->password_hash = Yii::$app->security->generatePasswordHash($password);
            $model->auth_key = Yii::$app->security->generateRandomString();
            if($model->validate() ){
                try{
                    $model->save();
                    $result = [
                        'id' => $model->id
                    ];
                    return $result;
                }catch(\yii\db\Exception $e){
                    RangerException::throwException(RangerException::APP_ERROR_CREATE,$e->getMessage());
                }
            }else{
                RangerException::throwException(RangerException::APP_ERROR_PARAMS,json_encode($model->getErrors()));
            }
        }else{
            RangerException::throwException(RangerException::APP_ERROR_PARAMS);
        }
    }

    public function actionUpdate(array $params)
    {
        parent::checkAccessToken($params);
    }

    public function actionDelete(array $params)
    {

    }
}