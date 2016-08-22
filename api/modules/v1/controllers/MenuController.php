<?php

namespace api\modules\v1\controllers;

use yii;
use api\controllers\RangerController;

class MenuController extends RangerController
{

    public function actionList(array $params)
    {
        $query = \common\models\Menu::find();
        if(isset($params['query']['where']) && is_array($params['query']['where'])) {
            foreach ($params['query']['where'] as $where) {
                $query->where($where);
            }
        }
        $result = array_map(function($record) {
            return $record;
        },$query->all());
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