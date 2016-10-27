<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\Article;
use kartik\widgets\Select2;
use kartik\widgets\DateTimePicker;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ArticleSearch */
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
        'export' => false,
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
                'class' => '\kartik\grid\RadioColumn'
            ],
            [
                'attribute'=>'id',
                'headerOptions'=>['style'=>'width:5%'],
            ],
            /*
            [
                'class'=>'kartik\grid\ExpandRowColumn',
                'width'=>'50px',
                'value'=>function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail'=>function ($model, $key, $index, $column) {
                    return Yii::$app->controller->renderPartial('_detail', ['model'=>$model]);
                },
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'expandOneOnly'=>true
            ],
            */
            [
                'attribute' => 'title',
                'class' => 'kartik\grid\EditableColumn',
                'refreshGrid' => true,
                'editableOptions' => function ($model, $key, $index) {
                    return [
                        'header' => '文章标题',
                        'size' => 'md',
                    ];
                }
            ],
            [
                'attribute' => 'category_id',
                'filter' => Select2::widget([
                    'model'=> $searchModel,
                    'attribute'=> 'category_id',
                    'data'=> \common\models\ArticleCategory::getArticleCategoryOptions(),
                    'options' => ['placeholder' => '所有分类'],
                    'pluginOptions' => ['allowClear' => 'true'],
                ]),
                'value'=>function($model){
                    return $model->getArticleCategoryNames();
                }
            ],
            [
                'attribute' => 'content_type',
                'filter' => Select2::widget([
                    'model'=> $searchModel,
                    'attribute'=> 'content_type',
                    'data'=> \common\models\Article::getContentTypeOptions(),
                    'hideSearch' => true,
                    'options' => ['placeholder' => '所有类别'],
                    'pluginOptions' => ['allowClear' => 'true'],
                ]),
                'value'=>function($model){
                    return $model->getContentTypeOptions($model->content_type);
                },
            ],
            [
                'attribute' => 'updated_at',
                'format' =>['datetime','php:Y-m-d H:i:s'],
                'filter' => DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'updated_at',
                    'convertFormat'=>true,
                    'pluginOptions'=>[
                        'timePicker'=>false,
                        'timePickerIncrement'=>15,
                        'locale'=>[
                            'format'=>'Y-m-d',
                            'separator'=>' - ',
                        ],
                    ]
                ]),
            ],
            /*
            [
                'attribute' => 'updated_at',
                'format' =>['datetime','php:Y-m-d H:i:s'],
                'filter' => DateTimePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'updated_at',
                    'type' => DateTimePicker::TYPE_INPUT,
                ]),
            ],
            */
            [
                'label'=>'热门',
                'attribute'=>'hot',
                'filter' => Select2::widget([
                    'model'=> $searchModel,
                    'attribute'=> 'hot',
                    'data'=> \common\models\Article::getHotOptions(),
                    'hideSearch' => true,
                    'options' => ['placeholder' => '所有类别'],
                    'pluginOptions' => ['allowClear' => 'true'],
                ]),
                'format'=>'raw',
                'value'=>function($model){
                    return Html::a($model->hot == $model::HOT_ENABLE?'<span class="glyphicon glyphicon-ok"></span>':'<span class="glyphicon glyphicon-remove"></span>', ['hot','id'=>$model->id], ['title' => '审核']) ;
                },
            ],
            [
                'label'=>'推荐',
                'attribute'=>'recommend',
                'filter' => Select2::widget([
                    'model'=> $searchModel,
                    'attribute'=> 'recommend',
                    'data'=> \common\models\Article::getRecommendOptions(),
                    'hideSearch' => true,
                    'options' => ['placeholder' => '所有类别'],
                    'pluginOptions' => ['allowClear' => 'true'],
                ]),
                'format'=>'raw',
                'value'=>function($model){
                    return Html::a($model->recommend == $model::RECOMMEND_ENABLE?'<span class="glyphicon glyphicon-ok"></span>':'<span class="glyphicon glyphicon-remove"></span>', ['recommend','id'=>$model->id], ['title' => '审核']) ;
                },
            ],
            [
                'label'=>'审核',
                'attribute'=>'audit',
                'filter' => Select2::widget([
                    'model'=> $searchModel,
                    'attribute'=> 'audit',
                    'data'=> \common\models\Article::getAuditOptions(),
                    'hideSearch' => true,
                    'options' => ['placeholder' => '所有类别'],
                    'pluginOptions' => ['allowClear' => 'true'],
                ]),
                'format'=>'raw',
                'value'=>function($model){
                    return Html::a($model->audit == $model::AUDIT_ENABLE?'<span class="glyphicon glyphicon-ok"></span>':'<span class="glyphicon glyphicon-remove"></span>', ['audit','id'=>$model->id], ['title' => '审核']) ;
                },
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
