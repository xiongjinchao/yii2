<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TradeOrder */

$this->title = 'Create Trade Order';
$this->params['breadcrumbs'][] = ['label' => 'Trade Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trade-order-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
