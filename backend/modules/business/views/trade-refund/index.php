<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TradeRefundSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trade Refunds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trade-refund-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Trade Refund', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'order_no',
            'payment_id',
            'refund_reson',
            'refund_amount',
            // 'refund_status',
            // 'meta:ntext',
            // 'transaction_no',
            // 'client_ip',
            // 'failure_code',
            // 'failure_message',
            // 'created_at',
            // 'refunded_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
