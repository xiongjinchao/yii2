<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TradePayment */

$this->title = 'Update Trade Payment: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Trade Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="trade-payment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
