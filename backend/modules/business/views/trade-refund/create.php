<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TradeRefund */

$this->title = 'Create Trade Refund';
$this->params['breadcrumbs'][] = ['label' => 'Trade Refunds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trade-refund-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
