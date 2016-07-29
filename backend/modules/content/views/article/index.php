<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \backend\modules\content\models\Article;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <p>
        <?= Html::a('<i class="fa fa-plus-circle"></i> 创建文章', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '<div class="box box-primary">
            <div class="box-header with-border"><h3 class="box-title pull-left">'.$this->title.'</h3><span class=pull-right>{summary}</span></div>
            <div class="box-body">{items}</div>
            <div class="box-footer">{pager}</div>
            </div>',
        'tableOptions' => ['class'=>'table table-striped table-bordered table-hover'],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                //自定义单元格样式
                'contentOptions' => function($model){
                    if($model->hot == Article::HOT_ENABLE && $model->recommend == Article::RECOMMEND_ENABLE){
                        return ['class'=>'success'];
                    }else if($model->hot == Article::HOT_ENABLE){
                        return ['class'=>'warning'];
                    }else if($model->recommend == Article::RECOMMEND_ENABLE){
                        return ['class'=>'info'];
                    }else{
                        return [];
                    }
                },
            ],
            [
                'attribute'=>'id',
                'headerOptions'=>['style'=>'width:5%'],
            ],
            'title',
            [
                'attribute'=>'category_id',
                'value'=>function($model){
                    return $model->getArticleCategoryValues();
                }
            ],
            //'content:ntext',
            //'hot',
            //'recommend',
            // 'hit',
            // 'source',
            // 'source_url:url',
            // 'seo_title',
            // 'seo_description',
            // 'seo_keyword',
            [
                'attribute'=>'created_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
            ],
            [
                'attribute'=>'updated_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
            ],
            [
                'label'=>'热门',
                'attribute'=>'hot',
                'format'=>'raw',
                'value'=>function($model){
                        return Html::a($model->hot == $model::HOT_ENABLE?'<span class="glyphicon glyphicon-ok"></span>':'<span class="glyphicon glyphicon-remove"></span>', ['hot','id'=>$model->id], ['title' => '审核']) ;
                    },
                'headerOptions'=>['style'=>'width:5%']
            ],
            [
                'label'=>'推荐',
                'attribute'=>'recommend',
                'format'=>'raw',
                'value'=>function($model){
                        return Html::a($model->recommend == $model::RECOMMEND_ENABLE?'<span class="glyphicon glyphicon-ok"></span>':'<span class="glyphicon glyphicon-remove"></span>', ['recommend','id'=>$model->id], ['title' => '审核']) ;
                    },
                'headerOptions'=>['style'=>'width:5%']

            ],
            [
                'label'=>'审核',
                'attribute'=>'audit',
                'format'=>'raw',
                'value'=>function($model){
                        return Html::a($model->audit == $model::AUDIT_ENABLE?'<span class="glyphicon glyphicon-ok"></span>':'<span class="glyphicon glyphicon-remove"></span>', ['audit','id'=>$model->id], ['title' => '审核']) ;
                    },
                'headerOptions'=>['style'=>'width:5%']
            ],
            ['class' => 'yii\grid\ActionColumn'],
            [
                'format'=>'raw',
                'value'=>function($model){
                        return Html::a('<span class="glyphicon glyphicon-th-list"></span>', ['article-section/edit','id'=>$model->id], ['title' => '段落']) ;
                    }
            ],
        ],
    ]); ?>

</div>
