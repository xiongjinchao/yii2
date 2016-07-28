<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <div class="form-group field-user-user_face">
        <label class="control-label" for="user-user_face"><?= $model->getAttributeLabel('user_face'); ?></label>
        <?= Html::activeHiddenInput($model,'user_face',['id'=>null]); ?>
        <?= Html::activeFileInput($model,'user_face',['style'=>'display:none']); ?>
        <div>
            <a class="btn btn-info upload"><i class="fa fa-image"></i> 选择图片</a>
        </div>
        <div class="help-block"></div>
    </div>

    <?= $form->field($model, 'status')->dropDownList($model->getStatusOptions());?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> 创建' : '<i class="fa fa-save"></i> 更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(".upload").click(function(){
        $("#user-user_face").trigger('click');
    })
</script>
