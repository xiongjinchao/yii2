<?php

namespace api\modules\v1\controllers;

use yii;
use yii\web\Controller;
use common\models\User;
use yii\helpers\Json;

class UserController extends Controller
{
    public function actionList()
    {
        $result = User::find()->all();
        echo 'ttttttt';
        return $result;
    }

    public function actionCreate()
    {

    }

    public function actionUpdate()
    {

    }

    public function actionDelete()
    {

    }
}