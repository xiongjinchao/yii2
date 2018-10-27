<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Trade */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Trades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trade-view">

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
            'user_id',
            'trade_status',
            'payment_id',
            'payment_status',
            'logistical_status',
            'total_amount',
            'paid_amount',
            'balance_amount',
            'discount_amount',
            'logistical_amount',
            'point_amount',
            'refund_amount',
            'earn_point',
            'contact_name',
            'contact_phone',
            'contact_address',
            'contact_postcode',
            'user_remark:ntext',
            'cancel_reason',
            'paid_at',
            'rated_at',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
