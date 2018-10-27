<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TradeLogistical */

$this->title = 'Create Trade Logistical';
$this->params['breadcrumbs'][] = ['label' => 'Trade Logisticals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trade-logistical-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
