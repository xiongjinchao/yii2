<?php

namespace api\modules\v1\controllers;

use yii;
use api\controllers\RangerController;
use api\components\Ranger;
use api\components\RangerException;

class ArticleCategoryController extends RangerController implements Ranger
{

    public function actionList(array $params)
    {
        $query = parent::generationQuery(\common\models\ArticleCategory::class,$params);
        try {
            $models = $query->orderBy(['lft' => SORT_ASC])->all();
        }catch(\yii\db\Exception $e){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS,$e->getMessage());
        }
        $result = [];
        if(!empty($models)) {
            $result = array_map(function ($model) {
                $record = $model->attributes;
                $record['created_at'] = date('Y-m-d H:i:s', $record['created_at']);
                $record['updated_at'] = date('Y-m-d H:i:s', $record['updated_at']);
                return $record;
            }, $models);
        }
        return $result;
    }

    public function actionDetail(array $params)
    {
        if(!isset($params['query']['where']) || !is_array($params['query']['where'])){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS,'where[]');
        }
        $query = parent::generationQuery(\common\models\ArticleCategory::class,$params);
        try {
            $model = $query->one();
        }catch(\yii\db\Exception $e){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS,$e->getMessage());
        }
        $result = [];
        if(!empty($model)) {
            $result = $model->attributes;
            $result['created_at'] = date('Y-m-d H:i:s', $result['created_at']);
            $result['updated_at'] = date('Y-m-d H:i:s', $result['updated_at']);
        }
        return $result;
    }

    public function actionCreate(array $params)
    {
        RangerException::throwException(RangerException::APP_FORBID_CREATE);
    }

    public function actionUpdate(array $params)
    {
        RangerException::throwException(RangerException::APP_FORBID_UPDATE);
    }

    public function actionDelete(array $params)
    {
        RangerException::throwException(RangerException::APP_FORBID_DELETE);
    }
}