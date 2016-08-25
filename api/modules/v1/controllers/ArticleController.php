<?php

namespace api\modules\v1\controllers;

use yii;
use common\models\Article;
use api\controllers\RangerController;
use yii\data\Pagination;
use api\components\RangerException;

class ArticleController extends RangerController
{

    public function actionList(array $params)
    {
        $pageSize = isset($params['query']['page_size']) && $params['query']['page_size']>0?$params['query']['page_size']:self::PAGE_SIZE;
        $page = isset($params['query']['page']) && $params['query']['page']>0?$params['query']['page']-1:0;

        $query = \common\models\Article::find();

        if(isset($params['query']['where']) && is_array($params['query']['where'])) {
            foreach ($params['query']['where'] as $where) {
                $query->andWhere($where);
            }
        }
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' =>$countQuery->count(), 'pageSize' => $pageSize, 'page' => $page]);
        $models = array_map(function($model){
            $record = $model->attributes;
            $record['created_at'] = date('Y-m-d H:i:s',$record['created_at']);
            $record['updated_at'] = date('Y-m-d H:i:s',$record['updated_at']);
            return $record;
        },$query->offset($pages->offset)->limit($pages->limit)->orderBy(['id'=>SORT_DESC])->all());

        $result = [
            'models' => $models,
            'pages' => [
                'page' => $pages->getPage()+1,
                'page_size' => $pages->getPageSize(),
                'page_count' => $pages->getPageCount(),
                'total_count' => $pages->totalCount,
            ],
        ];
        return $result;
    }

    public function actionDetail(array $params)
    {
        if(!isset($params['query']['where']) || !is_array($params['query']['where'])){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS,'where[]');
        }
        $query = Article::find();
        foreach ($params['query']['where'] as $where) {
            $query->andWhere($where);
        }
        $model = $query->one();
        $result = $model->attributes;
        $result['created_at'] = date('Y-m-d H:i:s',$result['created_at']);
        $result['updated_at'] = date('Y-m-d H:i:s',$result['updated_at']);
        $result['sections'] = [];
        if(isset($model->sections) && $model->sections != null){
            foreach($model->sections as $key=>$section){
                $record = $section->attributes;
                unset($record['id'],$record['article_id']);
                $record['pictures'] = [];
                $result['sections'][] = $record;
                if(isset($section->pictures) && $section->pictures != null){
                    foreach($section->pictures as $picture){
                        $record = $picture->attributes;
                        unset($record['id'],$record['article_id'],$record['section_id']);
                        if(isset($picture->picture) && $picture->picture != null){
                            $record['url'] = $picture->picture->url;
                        }
                        $result['sections'][$key]['pictures'][] = $record;
                    }
                }
            }
        }
        return $result;
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