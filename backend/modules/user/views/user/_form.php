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

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <div class="form-group field-user-picture_id">
        <label class="control-label" for="user-avatar"><?= $model->getAttributeLabel('picture_id'); ?></label>
        <div>
            <?= Html::activeInput('hidden',$model,'picture_id'); ?>
            <?php Modal::begin([
                'toggleButton' => ['label' => '<i class="fa fa-image"></i> 上传图片', 'class' => 'btn btn-info', 'id' => 'uploader','data-url'=> Url::to(['/uploader/modal','category'=>'user_face','max'=>1])],
                'header' => '<h4><i class="fa fa-image"></i> 上传图片</h4>',
                'id' => 'uploader-modal',
                'headerOptions' => ['class'=>'modal-title'],
                'footer' => '<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-undo"></i> 取消</button> <button type="button" class="btn btn-primary" id="modal-submit"><i class="fa fa-save"></i> 确认</button>',
            ]);
            Modal::end();
            ?>
        </div>
        <div class="selected-picture" id="selected-picture">
            <?=isset($model->picture)?Html::img('http://'.Yii::$app->params['domain']['image'].$model->picture->path,['class'=>'img-responsive img-thumbnail','width'=>100,'height'=>100]):'';?>
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
        $("#uploader").click(function(){
            $("#uploader-modal .modal-body").load($(this).data('url'));
        });
        $("#modal-submit").click(function(){
            if($("#uploader-modal .uploader-list .file-item").length == 0){
                $(".alert").remove();
                $(".uploader-modal").prepend( '<div class="alert-warning callout alert fade in">'
                +'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
                +'<i class="icon fa fa-ban"></i> 请上传图片'
                +'</div>');
                return false;
            }else if($("#uploader-modal .uploader-list .file-item").length > $("#max").val()){
                $(".alert").remove();
                $(".uploader-modal").prepend( '<div class="alert-warning callout alert fade in">'
                +'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
                +'<i class="icon fa fa-ban"></i> 最多允许使用 '+$("#max").val()+' 张图片'
                +'</div>');
                return false;
            }

            $("#selected-picture").empty();
            $("#user-picture_id").val('');
            var picture_id = [];
            $("#uploader-modal .uploader-list .file-item").each(function(i,item){
                picture_id.push($(item).find(".picture_id").val());
                $("#selected-picture").append('<img class="img-responsive img-thumbnail" src="'+$(item).find("img").attr("src")+'" width="100" height="100">');
            });
            $("#user-picture_id").val(picture_id.join(','));
            $("#uploader-modal").modal('hide');
        });
        <?php $this->endBlock(); ?>
    </script>
<?php $this->registerJs($this->blocks['js'],\yii\web\View::POS_END);
