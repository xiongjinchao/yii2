<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\TradeOrder */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Trade Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trade-order-view">

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
            'product_id',
            'product_name',
            'picture_id',
            'picture_url:url',
            'sku_id',
            'sku_name',
            'price',
            'num',
            'subtotal',
            'activity_id',
            'discount',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
