<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TradePayment */

$this->title = 'Create Trade Payment';
$this->params['breadcrumbs'][] = ['label' => 'Trade Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trade-payment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
