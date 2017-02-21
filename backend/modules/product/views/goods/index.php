<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use kartik\widgets\ColorInput;

/* @var $this yii\web\View */
/* @var $searchModel common\models\GoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '商品管理';
$this->params['breadcrumbs'][] = '<i class="fa fa-cubes"></i> '.$this->title;
?>
<div class="goods-index">

    <p>
        <?= Html::a('<i class="fa fa-plus-circle"></i> 创建商品', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'id' => 'goods-grid',
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
                'class' => '\kartik\grid\SerialColumn'
            ],
            [
                'class' => '\kartik\grid\RadioColumn'
            ],
            [
                'attribute'=>'id',
                'width'=>'4%',
                'vAlign'=>'middle',
            ],
            [
                'attribute' => 'picture_id',
                'filter' => false,
                'value' => function($model){
                    return isset($model->picture)?Html::img('http://'.Yii::$app->params['domain']['image'].$model->picture->path,['class'=>'img-responsive img-thumbnail','width'=>'60','height'=>'60']):'';
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'name',
                'class' => 'kartik\grid\EditableColumn',
                'refreshGrid' => true,
                'vAlign'=>'middle',
                'editableOptions' => function ($model, $key, $index) {
                    return [
                        'header' => '商品名称',
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
                            ]).$form->field($model, 'category_id')->widget(Select2::classname(), [
                                'data' => \common\models\GoodsCategory::getGoodsCategoryOptions(),
                                'options' => ['id'=>"category_id-{$index}",'placeholder' => '请选择'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ]
                            ]).$form->field($model, 'audit')->widget(Select2::classname(), [
                                'data' => \common\models\Goods::getAuditOptions(),
                                'options' => ['id'=>"audit-{$index}",'placeholder' => '请选择'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ]
                            ]);
                        }
                    ];
                },
                'width'=>'10%',
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
                'width'=>'9%',
            ],
            [
                'attribute' => 'category_id',
                'vAlign'=>'middle',
                'value'=>function($model){
                    return isset($model->category)&&$model->category!=null?$model->category->name:'';
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter'=>\common\models\GoodsCategory::getGoodsCategoryOptions(),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'所有类别'],
            ],
            [
                'attribute' => 'updated_at',
                'format' =>['datetime','php:Y-m-d H:i:s'],
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions'=>[
                    'autoUpdateOnInit'=>false,
                    'convertFormat'=>true,
                    'pluginOptions'=>[
                        'opens'=>'left',
                        'locale'=>[
                            'format'=>'Y-m-d',
                            'separator'=>' - '
                        ],
                    ]
                ],
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'sale_mode',
                'format'=>'raw',
                'vAlign'=>'middle',
                'value'=>function($model){
                    return $model->getSaleModeOptions($model->sale_mode);
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter'=>\common\models\Goods::getSaleModeOptions(),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'所有类别'],
            ],
            [
                'attribute'=>'goods_type',
                'format'=>'raw',
                'vAlign'=>'middle',
                'value'=>function($model){
                    return $model->getGoodsTypeOptions($model->goods_type);
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter'=>\common\models\Goods::getGoodsTypeOptions(),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'所有类别'],
            ],
            [
                'attribute'=>'sale_price',
                'hAlign'=>'right',
                'vAlign'=>'middle',
                'format'=> 'raw',
                'value' => function($model){
                    return '<span>'.$model->sale_price.'</span><br/><span style="text-decoration:line-through;color:#999">'.$model->origin_price.'</span>';
                }
            ],
            [
                'attribute'=>'stock',
                'hAlign'=>'right',
                'vAlign'=>'middle',
                'format'=> 'raw',
            ],
            [
                'attribute'=>'audit',
                'format'=>'raw',
                'vAlign'=>'middle',
                'hAlign'=>'center',
                'value'=>function($model){
                    return Html::a($model->audit == $model::AUDIT_ENABLE?'<span class="glyphicon glyphicon-ok text-success"></span>':'<span class="glyphicon glyphicon-remove text-danger"></span>', ['audit','id'=>$model->id], ['title' => '上下架']) ;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter'=>\common\models\Goods::getAuditOptions(),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'所有类别'],
            ],
            ['class' => 'kartik\grid\ActionColumn'],
            [
                'class'=>'kartik\grid\CheckboxColumn',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
            ],
        ],
    ]); ?>
</div>
