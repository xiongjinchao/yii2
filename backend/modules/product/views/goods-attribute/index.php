<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\GoodsAttributeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'SKU管理';
$this->params['breadcrumbs'][] = '<i class="fa fa-globe"></i> '.$this->title;
?>
<div class="goods-attribute-index">

    <p>
        <?= Html::a('<i class="fa fa-plus-circle"></i> 创建SKU', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'id' => 'goods-attribute-grid',
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
                'class' => 'kartik\grid\SerialColumn',
                'vAlign'=>'middle'
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
                'header'=>'图片',
                'vAlign'=>'middle',
                'format'=> 'raw',
                'value' => function($model){
                    return isset($model->goods)&&isset($model->goods->picture)?Html::img('http://'.Yii::$app->params['domain']['image'].$model->goods->picture->path,['class'=>'img-responsive img-thumbnail','width'=>'60','height'=>'60']):'';
                },
            ],
            [
                'attribute'=>'goods_id',
                'vAlign'=>'middle',
                'format'=> 'raw',
                'value' => function($model){
                    return isset($model->goods)&&$model->goods!=null?$model->goods->name:'';
                }
            ],
            [
                'attribute'=>'attribute_name_id',
                'label' => '属性',
                'vAlign'=>'middle',
                'format'=> 'raw',
                'value' => function($model){
                    $value = isset($model->attributeName)&&$model->attributeName!=null?$model->attributeName->name.'：':'';
                    $value .= isset($model->attributeValue)&&$model->attributeValue!=null?$model->attributeValue->value:'';
                    return $value;
                }
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
                'filter'=> false
            ],
            [
                'attribute'=>'created_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'updated_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'status',
                'format'=>'raw',
                'vAlign'=>'middle',
                'hAlign'=>'center',
                'value'=>function($model){
                    return Html::a($model->status == $model::STATUS_ENABLE?'<span class="glyphicon glyphicon-ok text-success"></span>':'<span class="glyphicon glyphicon-remove text-danger"></span>', ['audit','id'=>$model->id], ['title' => '审核']) ;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter'=>\common\models\GoodsAttribute::getStatusOptions(),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'所有类别'],
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
            [
                'class'=>'kartik\grid\CheckboxColumn',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
            ],
        ],
    ]); ?>
</div>
