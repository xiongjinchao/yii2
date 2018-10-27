<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TradePayment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trade-payment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'trade_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'channel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'paid_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'transaction_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_status')->textInput() ?>

    <?= $form->field($model, 'failure_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'failure_message')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'client_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'paid_at')->textInput() ?>

    <?= $form->field($model, 'expire_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
