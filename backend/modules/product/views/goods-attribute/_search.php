<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsAttributeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-attribute-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'goods_id') ?>

    <?= $form->field($model, 'attribute_name_id') ?>

    <?= $form->field($model, 'attribute_value_id') ?>

    <?= $form->field($model, 'origin_price') ?>

    <?php // echo $form->field($model, 'sale_price') ?>

    <?php // echo $form->field($model, 'stock') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
