<?php

namespace api\modules\v1\controllers;

use yii;
use api\controllers\RangerController;
use common\models\User;

class UserController extends RangerController
{
    
    public function actionLogin(array $params)
    {

    }

    public function actionList(array $params)
    {
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