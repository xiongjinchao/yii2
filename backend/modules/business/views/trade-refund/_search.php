<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TradeRefundSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trade-refund-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'order_no') ?>

    <?= $form->field($model, 'payment_id') ?>

    <?= $form->field($model, 'refund_reson') ?>

    <?= $form->field($model, 'refund_amount') ?>

    <?php // echo $form->field($model, 'refund_status') ?>

    <?php // echo $form->field($model, 'meta') ?>

    <?php // echo $form->field($model, 'transaction_no') ?>

    <?php // echo $form->field($model, 'client_ip') ?>

    <?php // echo $form->field($model, 'failure_code') ?>

    <?php // echo $form->field($model, 'failure_message') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'refunded_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
