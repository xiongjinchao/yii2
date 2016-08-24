<?php

namespace api\modules\v1\controllers;

use common\models\User;
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
            $accessToken = Yii::$app->security->generateRandomString();
            $duration = 3600*24*30;
            Yii::$app->cache->set($accessToken, $user->id, $duration);
            Yii::$app->user->login($user, $duration);
            $result = $user->attributes;
            unset($result['auth_key'], $result['password_hash'], $result['password_reset_token']);
            $result['access_token'] = $accessToken;
            return $result;
        }
    }

    public function actionList(array $params)
    {
        $query = User::find();
        if(isset($params['query']['where']) && is_array($params['query']['where'])) {
            foreach ($params['query']['where'] as $where) {
                $query->andWhere($where);
            }
        }
        $result = array_map(function($record){
            unset($record['auth_key'], $record['password_hash'], $record['password_reset_token']);
            return $record;
        },$query->orderBy(['id'=>SORT_DESC])->all());
        return $result;
    }

    public function actionDetail(array $params)
    {
        $user = parent::checkAccessToken($params);
        unset($user['auth_key'], $user['password_hash'], $user['password_reset_token']);
        return $user;
    }

    public function actionCreate(array $params)
    {
        $model = new User();
        if(!$model->load($params,'query')){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS);
        }
        $password = isset($params['query']['password'])?$params['query']['password']:'';
        if(!$password){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS,'password');
        }
        $model->password_hash = Yii::$app->security->generatePasswordHash($password);
        $model->auth_key = Yii::$app->security->generateRandomString();
        if(!$model->validate() ){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS,json_encode($model->getErrors()));
        }
        try{
            $model->save();
            $result = [
                'id' => $model->id
            ];
            return $result;
        }catch(\yii\db\Exception $e){
            RangerException::throwException(RangerException::APP_ERROR_CREATE,$e->getMessage());
        }
    }

    public function actionUpdate(array $params)
    {
        $user = parent::checkAccessToken($params);
        $model = User::findOne($user['id']);
        if(isset($params['query']['id'])){
            unset($params['query']['id']);
        }
        if(!$model->load($params,'query')){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS);
        }
        $password = isset($params['query']['password'])?$params['query']['password']:'';
        if($password){
            $model->password_hash = Yii::$app->security->generatePasswordHash($password);
            $model->auth_key = Yii::$app->security->generateRandomString();
        }

        try {
            $model->save();
        } catch (\yii\db\Exception $e) {
            RangerException::throwException(RangerException::APP_ERROR_UPDATE, $e->getMessage());
        }
        $result = $model->attributes;
        unset($result['auth_key'], $result['password_hash'], $result['password_reset_token']);
        return $model->attributes;
    }

    public function actionDelete(array $params)
    {
        RangerException::throwException(RangerException::APP_ERROR_DELETE);
    }
}