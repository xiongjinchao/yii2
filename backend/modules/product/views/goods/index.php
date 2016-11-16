<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use kartik\daterange\DateRangePicker;
use kartik\widgets\ColorInput;

/* @var $this yii\web\View */
/* @var $searchModel common\models\GoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '商品管理';
$this->params['breadcrumbs'][] = $this->title;
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
        //'pjax'=>true,
        'tableOptions' => ['class'=>'table table-striped table-bordered table-hover'],
        'columns' => [
            [
                'class' => '\kartik\grid\SerialColumn',
                'vAlign'=>'middle',
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
                'value' => function($model){
                    return isset($model->picture)?Html::img('http://'.Yii::$app->params['domain']['image'].$model->picture->path,['height'=>'50']):'';
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
                        'palette' => array_chunk(\common\models\Goods::getColorOptions(),6),
                    ]
                ]),
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->color == ''? '' : "<span class='badge' style='background-color: ".$model->color."'> </span>  <code>".$model->color.'</code>';
                },
                'vAlign'=>'middle',
                'format'=>'raw',
                'width'=>'9%',
            ],
            [
                'attribute' => 'category_id',
                'filter' => Select2::widget([
                    'model'=> $searchModel,
                    'attribute'=> 'category_id',
                    'data'=> \common\models\GoodsCategory::getGoodsCategoryOptions(),
                    'options' => ['placeholder' => '所有分类'],
                    'pluginOptions' => ['allowClear' => 'true'],
                ]),
                'vAlign'=>'middle',
                'value'=>function($model){
                    return isset($model->category->name)?$model->category->name:'';
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
                'vAlign'=>'middle',
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
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'sale_mode',
                'filter' => Select2::widget([
                    'model'=> $searchModel,
                    'attribute'=> 'sale_mode',
                    'data'=> \common\models\Goods::getSaleModeOptions(),
                    'hideSearch' => true,
                    'options' => ['placeholder' => '所有类别'],
                    'pluginOptions' => ['allowClear' => 'true'],
                ]),
                'format'=>'raw',
                'vAlign'=>'middle',
                'value'=>function($model){
                    return $model->getSaleModeOptions($model->sale_mode);
                },
            ],
            [
                'attribute'=>'goods_type',
                'filter' => Select2::widget([
                    'model'=> $searchModel,
                    'attribute'=> 'goods_type',
                    'data'=> \common\models\Goods::getGoodsTypeOptions(),
                    'hideSearch' => true,
                    'options' => ['placeholder' => '所有类别'],
                    'pluginOptions' => ['allowClear' => 'true'],
                ]),
                'format'=>'raw',
                'vAlign'=>'middle',
                'value'=>function($model){
                    return $model->getGoodsTypeOptions($model->goods_type);
                },
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
            /*
            [
                'attribute'=>'presell',
                'filter' => Select2::widget([
                    'model'=> $searchModel,
                    'attribute'=> 'presell',
                    'data'=> \common\models\Goods::getPresellOptions(),
                    'hideSearch' => true,
                    'options' => ['placeholder' => '所有类别'],
                    'pluginOptions' => ['allowClear' => 'true'],
                ]),
                'format'=>'raw',
                'vAlign'=>'middle',
                'value'=>function($model){
                    return $model->getPresellOptions($model->sale_mode);
                },
            ],
            */
            [
                'attribute'=>'audit',
                'filter' => Select2::widget([
                    'model'=> $searchModel,
                    'attribute'=> 'audit',
                    'data'=> \common\models\Goods::getAuditOptions(),
                    'hideSearch' => true,
                    'options' => ['placeholder' => '所有状态'],
                    'pluginOptions' => ['allowClear' => 'true'],
                ]),
                'format'=>'raw',
                'vAlign'=>'middle',
                'hAlign'=>'center',
                'value'=>function($model){
                    return Html::a($model->audit == $model::AUDIT_ENABLE?'<span class="glyphicon glyphicon-ok text-success"></span>':'<span class="glyphicon glyphicon-remove text-danger"></span>', ['audit','id'=>$model->id], ['title' => '上下架']) ;
                },
            ],
            ['class' => 'kartik\grid\ActionColumn'],
            [
                'class'=>'kartik\grid\CheckboxColumn',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
            ],
        ],
    ]); ?>
</div>
