<?php

namespace api\modules\v1\controllers;

use yii;
use common\models\Page;
use api\controllers\RangerController;
use api\components\RangerException;

class PageController extends RangerController
{

    public function actionList(array $params)
    {
        $query = Page::find();
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
        $query = Page::find();
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