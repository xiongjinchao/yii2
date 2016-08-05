<?php

namespace api\modules\v1\controllers;

use yii;
use yii\web\Controller;
use common\models\User;
use yii\helpers\ArrayHelper;

class UserController extends Controller
{
    public function actionList(array $params)
    {
        print_r($params);
        $result = array_map(function($record) {
            return $record->attributes;
        },User::find()->all());
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