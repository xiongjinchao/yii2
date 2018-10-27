<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TradeOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单管理';
$this->params['breadcrumbs'][] = '<i class="fa fa-google-wallet"></i> '.$this->title;
?>
<div class="trade-order-index">

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
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'trade_no',
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'user_id',
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'product_name',
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'sku_name',
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'price',
                'hAlign'=>'right',
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'num',
                'hAlign'=>'right',
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'subtotal',
                'hAlign'=>'right',
                'vAlign'=>'middle',
            ],
            // 'activity_id',
            // 'discount',
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
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update}'
            ],
        ],
    ]); ?>
</div>
