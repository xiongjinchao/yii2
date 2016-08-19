<?php

namespace api\modules\v1\controllers;

use yii;
use api\controllers\RangerController;
use api\components\RangerException;

class MenuController extends RangerController
{

    public function actionList(array $params)
    {
        $result = array_map(function($record) {
            return $record;
        },\common\models\Menu::find()->all());
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