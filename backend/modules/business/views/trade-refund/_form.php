<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TradeRefund */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trade-refund-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_id')->textInput() ?>

    <?= $form->field($model, 'refund_reson')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'refund_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'refund_status')->textInput() ?>

    <?= $form->field($model, 'meta')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'transaction_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'client_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'failure_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'failure_message')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'refunded_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
