<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'name', ['template' => '{label}<div class="input-group"><div class="input-group-addon"><i class="fa fa-header"></i></div>{input}</div>{hint}{error}'])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'action', ['template' => '{label}<div class="input-group"><div class="input-group-addon"><i class="fa fa-tag"></i></div>{input}</div>{hint}{error}'])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link', ['template' => '{label}<div class="input-group"><div class="input-group-addon"><i class="fa fa-internet-explorer"></i></div>{input}</div>{hint}{error}'])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent', ['template' => '{label}<div class="input-group"><div class="input-group-addon"><i class="fa fa-sitemap"></i></div>{input}</div>{hint}{error}'])->dropDownList($model->getMenuOptions(),['prompt'=>'设为主菜单']);?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'visible')->radioList($model->getVisibleOptions(), ['class'=>'radio-lable']);?>

    <?= $form->field($model, 'audit')->radioList($model->getAuditOptions(), ['class'=>'radio-lable']);?>

    <?= $form->field($model, 'seo_title', ['template' => '{label}<div class="input-group"><div class="input-group-addon"><i class="fa fa-header"></i></div>{input}</div>{hint}{error}'])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_description')->textarea(['rows' => 2, 'maxlength' => true]) ?>

    <?= $form->field($model, 'seo_keyword', ['template' => '{label}<div class="input-group"><div class="input-group-addon"><i class="fa fa-tags"></i></div>{input}</div>{hint}{error}'])->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> 创建' : '<i class="fa fa-save"></i> 更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
