<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RecommendationPicture */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recommendation-picture-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'recommendation_category_id')->textInput() ?>

    <?= $form->field($model, 'recommendation_content_id')->textInput() ?>

    <?= $form->field($model, 'picture_id')->textInput() ?>

    <?= $form->field($model, 'picture_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
