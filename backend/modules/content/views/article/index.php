<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\Article;
use kartik\widgets\Select2;
use kartik\widgets\DateTimePicker;
use kartik\daterange\DateRangePicker;
use kartik\widgets\ColorInput;

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
        'id' => 'article-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '<div class="box box-primary">
            <div class="box-header with-border"><h3 class="box-title pull-left">'.$this->title.'</h3><span class=pull-right>{summary}</span></div>
            <div class="box-body">{items}</div>
            <div class="box-footer">{pager}</div>
            </div>',
        'export' => false,
        //'pjax'=>true,
        'tableOptions' => ['class'=>'table table-striped table-bordered table-hover'],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
            ],
            [
                'class' => '\kartik\grid\RadioColumn'
            ],
            [
                'attribute'=>'id',
                'width'=>'5%',
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
                        'header' => '标题',
                        'size' => 'md',
                        'afterInput'=>function ($form, $widget) use ($model, $index) {
                            return $form->field($model, "color")->widget(ColorInput::classname(), [
                                'showDefaultPalette'=>false,
                                'options'=>['id'=>"color-{$index}",'placeholder' => '请选择'],
                                'pluginOptions'=>[
                                    'showPalette' => true,
                                    'showPaletteOnly' => true,
                                    'showSelectionPalette' => true,
                                    'showAlpha' => false,
                                    'allowEmpty' => false,
                                    'preferredFormat' => 'name',
                                    'palette' => array_chunk(\common\models\Article::getColorOptions(),6),
                                ]
                            ]).$form->field($model, 'user_id')->widget(Select2::classname(), [
                                'data' => \common\models\User::getUserOptions(),
                                'options' => ['id'=>"user_id-{$index}",'placeholder' => '请选择'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ]
                            ]);
                        }
                    ];
                }
            ],
            [
                'attribute'=>'color',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->color == ''? '' : "<span class='badge' style='background-color: ".$model->color."'> </span>  <code>".$model->color.'</code>';
                },
                'filter' => ColorInput::widget([
                    'model'=> $searchModel,
                    'attribute'=> 'color',
                    'showDefaultPalette'=>false,
                    'pluginOptions'=>[
                        'showPalette' => true,
                        'showPaletteOnly' => true,
                        'showSelectionPalette' => true,
                        'showAlpha' => false,
                        'allowEmpty' => false,
                        'preferredFormat' => 'name',
                        'palette' => array_chunk(\common\models\Article::getColorOptions(),6),
                    ]
                ]),
                'format'=>'raw',
                'width'=>'10%',
            ],
            [
                'attribute' => 'user_id',
                'filter' => Select2::widget([
                    'model'=> $searchModel,
                    'attribute'=> 'user_id',
                    'data'=> \common\models\User::getUserOptions(),
                    'options' => ['placeholder' => '所有作者'],
                    'pluginOptions' => ['allowClear' => 'true'],
                ]),
                'value'=>function($model){
                    return isset($model->user)?$model->user->username:'';
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
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
            [
                'format'=>'raw',
                'value'=>function($model){
                        return Html::a('<span class="glyphicon glyphicon-th-list"></span>', ['article-section/edit','id'=>$model->id], ['title' => '段落']) ;
                    }
            ],
        ],
    ]); ?>

</div>
