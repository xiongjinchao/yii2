<?php

namespace api\modules\v1\controllers;

use yii;
use api\controllers\RangerController;
use yii\data\Pagination;
use api\components\Ranger;
use api\components\RangerException;
use yii\helpers\ArrayHelper;

class ArticleController extends RangerController implements Ranger
{

    public function actionList(array $params)
    {
        $pageSize = isset($params['query']['page_size']) && $params['query']['page_size']>0?$params['query']['page_size']:Yii::$app->params['pageSize'];
        $page = isset($params['query']['page']) && $params['query']['page']>0?$params['query']['page']-1:0;

        $query = parent::generationQuery(\common\models\Article::class,$params);
        $countQuery = clone $query;
        try {
            $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $pageSize, 'page' => $page]);
            $models = $query->offset($pages->offset)->limit($pages->limit)->orderBy(['id' => SORT_DESC])->all();
        }catch (\yii\db\Exception $e){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS,$e->getMessage());
        }
        $pages = [
            'page' => $pages->getPage()+1,
            'page_size' => $pages->getPageSize(),
            'page_count' => $pages->getPageCount(),
            'total_count' => $pages->totalCount,
        ];
        $result = [
            'list' => [],
            'pages' => $pages
        ];
        if(!empty($models)) {
            $list = array_map(function ($model) {
                $record = $model->attributes;
                $record['created_at'] = date('Y-m-d H:i:s', $record['created_at']);
                $record['updated_at'] = date('Y-m-d H:i:s', $record['updated_at']);
                return $record;
            }, $models);

            $result = [
                'list' => $list,
                'pages' => $pages
            ];
        }
        return $result;
    }

    public function actionDetail(array $params)
    {
        if(!isset($params['query']['where']) || !is_array($params['query']['where'])){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS,'where[]');
        }
        $query = parent::generationQuery(\common\models\Article::class,$params);
        try {
            $model = $query->one();
        }catch (\yii\db\Exception $e){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS,$e->getMessage());
        }
        $result = [];
        if(!empty($model)) {
            $result = $model->attributes;
            $result['created_at'] = date('Y-m-d H:i:s', $result['created_at']);
            $result['updated_at'] = date('Y-m-d H:i:s', $result['updated_at']);
            $result['sections'] = [];
            if (isset($model->sections) && $model->sections != null) {
                foreach ($model->sections as $key => $section) {
                    $record = $section->attributes;
                    unset($record['id'], $record['article_id']);
                    $record['pictures'] = [];
                    $result['sections'][] = $record;
                    if (isset($section->pictures) && $section->pictures != null) {
                        foreach ($section->pictures as $picture) {
                            $record = $picture->attributes;
                            unset($record['id'], $record['article_id'], $record['section_id']);
                            if (isset($picture->picture) && $picture->picture != null) {
                                $record['url'] = $picture->picture->url;
                            }
                            $result['sections'][$key]['pictures'][] = $record;
                        }
                    }
                }
            }
            $result['tags'] = [];
            if (isset($model->tags) && $model->tags != null) {
                foreach ($model->tags as $key => $tag) {
                    $record = $tag->tag;
                    if($record!= null){
                        $record = $record->attributes;
                        unset($record['created_at'], $record['updated_at']);
                        $result['tags'][]  = $record;
                    }
                }
            }
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