<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsAttribute */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-attribute-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'goods_id')->textInput() ?>

    <?= $form->field($model, 'attribute_name_id')->textInput() ?>

    <?= $form->field($model, 'attribute_value_id')->textInput() ?>

    <?= $form->field($model, 'origin_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sale_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'stock')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
