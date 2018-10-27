<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TradePaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trade Payments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trade-payment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Trade Payment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'trade_no',
            'channel',
            'paid_amount',
            'subject',
            // 'body',
            // 'meta:ntext',
            // 'transaction_no',
            // 'payment_status',
            // 'failure_code',
            // 'failure_message',
            // 'client_ip',
            // 'created_at',
            // 'paid_at',
            // 'expire_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
