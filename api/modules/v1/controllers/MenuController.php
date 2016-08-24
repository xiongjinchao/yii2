<?php

namespace api\modules\v1\controllers;

use yii;
use common\models\Menu;
use api\controllers\RangerController;
use api\components\RangerException;

class MenuController extends RangerController
{

    public function actionList(array $params)
    {
        $query = Menu::find();
        if(isset($params['query']['where']) && is_array($params['query']['where'])) {
            foreach ($params['query']['where'] as $where) {
                $query->andWhere($where);
            }
        }
        $result = array_map(function($record) {
            return $record;
        },$query->orderBy(['left'=>SORT_ASC])->all());
        return $result;
    }

    public function actionDetail(array $params)
    {
        if(!isset($params['query']['where']) || !is_array($params['query']['where'])){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS,'where[]');
        }
        $query = Menu::find();
        foreach ($params['query']['where'] as $where) {
            $query->andWhere($where);
        }
        $result = $query->one();
        return $result->attributes;
    }

    public function actionCreate(array $params)
    {
        RangerException::throwException(RangerException::APP_ERROR_CREATE);
    }

    public function actionUpdate(array $params)
    {
        RangerException::throwException(RangerException::APP_ERROR_UPDATE);
    }

    public function actionDelete(array $params)
    {
        RangerException::throwException(RangerException::APP_ERROR_DELETE);
    }
}