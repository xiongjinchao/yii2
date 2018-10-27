<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TradeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '交易管理';
$this->params['breadcrumbs'][] = '<i class="fa fa-paypal"></i> '.$this->title;
?>
<div class="trade-index">

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
                'attribute'=>'trade_no',
                'width'=>'4%',
                'vAlign'=>'middle',
            ],
            [
                'class'=>'kartik\grid\ExpandRowColumn',
                'width'=>'50px',
                'value'=>function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail'=>function ($model, $key, $index, $column) {
                    return Yii::$app->controller->renderPartial('detail', ['model'=>$model]);
                },
                'headerOptions' => ['class'=>'kartik-sheet-style'],
                'expandOneOnly' => true
            ],
            [
                'attribute'=>'user_id',
                'vAlign'=>'middle',
            ],
            [
                'attribute' => 'trade_status',
                'vAlign'=>'middle',
                'value'=>function($model){
                    return \common\models\Trade::getTradeStatusOptions($model->trade_status);
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter'=>\common\models\Trade::getTradeStatusOptions(),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'所有类别'],
                'width'=>'5%'
            ],
            [
                'attribute' => 'payment_status',
                'vAlign'=>'middle',
                'value'=>function($model){
                    return \common\models\Trade::getPaymentStatusOptions($model->payment_status);
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter'=>\common\models\Trade::getPaymentStatusOptions(),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'所有类别'],
                'width'=>'5%'
            ],
            [
                'attribute' => 'logistical_status',
                'vAlign'=>'middle',
                'value'=>function($model){
                    return \common\models\Trade::getLogisticalStatusOptions($model->logistical_status);
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter'=>\common\models\Trade::getLogisticalStatusOptions(),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'所有类别'],
                'width'=>'5%'
            ],
            [
                'attribute'=>'total_amount',
                'hAlign'=>'right',
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'paid_amount',
                'hAlign'=>'right',
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'logistical_amount',
                'hAlign'=>'right',
                'vAlign'=>'middle',
                'filter'=>false
            ],
            [
                'attribute'=>'discount_amount',
                'hAlign'=>'right',
                'vAlign'=>'middle',
                'filter'=>false
            ],
            [
                'attribute'=>'balance_amount',
                'hAlign'=>'right',
                'vAlign'=>'middle',
                'filter'=>false
            ],
            [
                'attribute'=>'contact_phone',
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'created_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
                'vAlign'=>'middle',
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update}'
            ]
        ],
    ]); ?>
</div>
