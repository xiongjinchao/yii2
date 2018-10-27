<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TradeLogisticalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trade Logisticals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trade-logistical-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Trade Logistical', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'trade_no',
            'order_id',
            'logistical_name',
            'logistical_sn',
            // 'logistical_status',
            // 'created_at',
            // 'update_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
