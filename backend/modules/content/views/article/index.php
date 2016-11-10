<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\Select2;
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
                'class' => '\kartik\grid\SerialColumn',
            ],
            [
                'class' => '\kartik\grid\RadioColumn'
            ],
            [
                'attribute'=>'id',
                'width'=>'4%',
            ],
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
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->color == ''? '' : "<span class='badge' style='background-color: ".$model->color."'> </span>  <code>".$model->color.'</code>';
                },
                'format'=>'raw',
                'width'=>'9%',
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
                },
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
                'attribute' => 'created_at',
                'format' =>['datetime','php:Y-m-d H:i:s'],
                'filter' => DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
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
                'width'=>'10%',
            ],
            /*
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
                'width'=>'10%',
            ],
            */
            /*
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
                    return Html::a($model->hot == $model::HOT_ENABLE?'<span class="glyphicon glyphicon-ok text-success"></span>':'<span class="glyphicon glyphicon-remove text-danger"></span>', ['hot','id'=>$model->id], ['title' => '审核']) ;
                },
            ],
            */
            /*
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
                    return Html::a($model->recommend == $model::RECOMMEND_ENABLE?'<span class="glyphicon glyphicon-ok text-success"></span>':'<span class="glyphicon glyphicon-remove text-danger"></span>', ['recommend','id'=>$model->id], ['title' => '审核']) ;
                },
            ],
            */
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
                'hAlign'=>'center',
                'value'=>function($model){
                    return Html::a($model->audit == $model::AUDIT_ENABLE?'<span class="glyphicon glyphicon-ok text-success"></span>':'<span class="glyphicon glyphicon-remove text-danger"></span>', ['audit','id'=>$model->id], ['title' => '审核']) ;
                },
            ],
            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{update} {delete}',
            ]
        ],
    ]); ?>

</div>
