<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'action')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent')->dropDownList($model->getMenuOptions(),['prompt'=>'设为主菜单']);?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'visible')->radioList($model->getVisibleOptions());?>

    <?= $form->field($model, 'audit')->radioList($model->getAuditOptions());?>

    <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_keyword')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> 创建' : '<i class="fa fa-save"></i> 更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
