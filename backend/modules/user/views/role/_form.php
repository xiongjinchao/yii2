<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="role-form">

    <?= $model->name === null?Html::beginForm(['create']):Html::beginForm(['update','name'=>$_GET['name']]);?>

    <div class="form-group required">
        <?=Html::label('角色名称：',null,['class'=>'control-label']);?>
        <?=Html::textInput('name',$model->name,['class'=>'form-control']);?>
        <div class="help-block"></div>
    </div>

    <div class="form-group required">
        <?=Html::label('描述：',null,['class'=>'control-label']);?>
        <?=Html::textInput('description',$model->description,['class'=>'form-control']);?>
        <div class="help-block"></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->name === null ? '<i class="fa fa-save"></i> 创建' : '<i class="fa fa-save"></i> 更新', ['class' => $model->name === null ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?=Html::endForm();?>

</div>
