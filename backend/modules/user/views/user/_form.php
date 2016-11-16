<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <div class="form-group field-user-avatar">
        <label class="control-label" for="user-avatar"><?= $model->getAttributeLabel('avatar'); ?></label>
        <?= Html::activeFileInput($model,'avatar',['style'=>'display:none']); ?>
        <div>
            <a class="btn btn-info upload"><i class="fa fa-image"></i> 选择图片</a>
        </div>
        <div class="help-block"></div>
    </div>

    <div class="form-group field-user-avatar">
        <label class="control-label" for="user-avatar"><?= $model->getAttributeLabel('avatar'); ?></label>
        <div>
            <?php Modal::begin([
                'toggleButton' => ['label' => '<i class="fa fa-image"></i> 上传图片', 'class' => 'btn btn-info', 'id' => 'uploader','data-url'=> Url::to(['/uploader/modal','category'=>'user_face','max'=>20])],
                'header' => '<h4><i class="fa fa-image"></i> 上传图片</h4>',
                'id' => 'uploader-modal',
                'headerOptions' => ['class'=>'modal-title'],
                'footer' => '<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-undo"></i> 取消</button> <button type="button" class="btn btn-primary" id="create-attribute-name"><i class="fa fa-save"></i> 确认</button>',
            ]);
            Modal::end();
            ?>
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
        <?php $this->beginBlock('js') ?>
        $(".upload").click(function(){
            $("#user-avatar").trigger('click');
        });
        $("#uploader").click(function(){
            $("#uploader-modal .modal-body").load($(this).data('url'));
        });
        <?php $this->endBlock(); ?>
    </script>
<?php $this->registerJs($this->blocks['js'],\yii\web\View::POS_END);
