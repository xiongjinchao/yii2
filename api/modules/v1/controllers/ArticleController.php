<?php

namespace api\modules\v1\controllers;

use yii;
use api\controllers\RangerController;
use yii\data\Pagination;

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
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();
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