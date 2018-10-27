<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TradeLogistical */

$this->title = 'Update Trade Logistical: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Trade Logisticals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="trade-logistical-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
