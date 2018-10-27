<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\TradePayment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Trade Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trade-payment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'trade_no',
            'channel',
            'paid_amount',
            'subject',
            'body',
            'meta:ntext',
            'transaction_no',
            'payment_status',
            'failure_code',
            'failure_message',
            'client_ip',
            'created_at',
            'paid_at',
            'expire_at',
        ],
    ]) ?>

</div>
