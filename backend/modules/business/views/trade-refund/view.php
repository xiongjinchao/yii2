<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\TradeRefund */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Trade Refunds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trade-refund-view">

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
            'order_no',
            'payment_id',
            'refund_reson',
            'refund_amount',
            'refund_status',
            'meta:ntext',
            'transaction_no',
            'client_ip',
            'failure_code',
            'failure_message',
            'created_at',
            'refunded_at',
        ],
    ]) ?>

</div>
