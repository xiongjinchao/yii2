<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\GoodsAttributeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'SKU管理';
$this->params['breadcrumbs'][] = $this->title;
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
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'goods_id',
            'attribute_name_id',
            'attribute_value_id',
            [
                'attribute'=>'sale_price',
                'hAlign'=>'right',
                'vAlign'=>'middle',
                'format'=> 'raw',
                'value' => function($model){
                    return '<span>'.$model->sale_price.'</span><br/><span style="text-decoration:line-through;color:#999">'.$model->origin_price.'</span>';
                }
            ],
            // 'stock',
            // 'status',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
