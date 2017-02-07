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
$this->params['breadcrumbs'][] = '<i class="fa fa-file-text"></i> '.$this->title;
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
        'pjax'=>true,
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
                'vAlign'=>'middle',
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
                },
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'color',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->color == ''? '' : "<span class='badge' style='background-color: ".$model->color."'> </span>  <code>".$model->color.'</code>';
                },
                'filterType'=>GridView::FILTER_COLOR,
                'filterWidgetOptions'=>[
                    'showDefaultPalette'=>false,
                    'pluginOptions'=>[
                        'showPalette' => true,
                        'showPaletteOnly' => true,
                        'showSelectionPalette' => true,
                        'showAlpha' => false,
                        'allowEmpty' => false,
                        'preferredFormat' => 'name',
                        'palette' => array_chunk(\common\models\Article::getColorOptions(),6),
                    ],
                ],
                'vAlign'=>'middle',
                'format'=>'raw',
                'width'=>'10%',
            ],
            [
                'attribute' => 'user_id',
                'value'=>function($model){
                    return isset($model->user)?$model->user->username:'';
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter'=>\common\models\User::getUserOptions(),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'所有作者'],
                'vAlign'=>'middle',
            ],
            [
                'attribute' => 'category_id',
                'value'=>function($model){
                    return $model->getArticleCategoryNames();
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter'=>\common\models\ArticleCategory::getArticleCategoryOptions(),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'所有分类'],
                'vAlign'=>'middle',
            ],
            [
                'attribute' => 'content_type',
                'value'=>function($model){
                    return $model->getContentTypeOptions($model->content_type);
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter'=>\common\models\Article::getContentTypeOptions(),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'所有类别'],
                'vAlign'=>'middle',
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
                'vAlign'=>'middle',
            ],
            [
                'label'=>'审核',
                'attribute'=>'audit',
                'format'=>'raw',
                'hAlign'=>'center',
                'value'=>function($model){
                    return Html::a($model->audit == $model::AUDIT_ENABLE?'<span class="glyphicon glyphicon-ok text-success"></span>':'<span class="glyphicon glyphicon-remove text-danger"></span>', ['audit','id'=>$model->id], ['title' => '审核']) ;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter'=>\common\models\Article::getAuditOptions(),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'所有类别'],
                'vAlign'=>'middle',
            ],
            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{update} {delete}',
            ]
        ],
    ]); ?>

</div>
