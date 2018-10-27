<?php

use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="attribute-name-form">

    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'audit')->widget(Select2::classname(), [
        'data' => \common\models\AttributeName::getAuditOptions(),
        'hideSearch' => true,
        'options' => ['placeholder' => '请选择'],
        'pluginOptions' => [
            'allowClear' => true
        ]
    ])?>

    <?= $form->field($model, 'status')->widget(Select2::classname(), [
        'data' => \common\models\AttributeName::getStatusOptions(),
        'hideSearch' => true,
        'options' => ['placeholder' => '请选择'],
        'pluginOptions' => [
            'allowClear' => true
        ]
    ])?>

    <?php ActiveForm::end(); ?>

</div>


