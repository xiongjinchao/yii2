<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TradeOrder */

$this->title = 'Update Trade Order: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Trade Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="trade-order-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
