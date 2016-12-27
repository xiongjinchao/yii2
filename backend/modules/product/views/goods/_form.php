<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\ColorInput;
use common\models\GoodsCategory;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model common\models\Goods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
        'data' => GoodsCategory::getGoodsCategoryOptions(),
        'options' => ['placeholder' => '请选择'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'origin_price')->textInput() ?>

    <?= $form->field($model, 'sale_price')->textInput() ?>

    <div class="form-group field-goods-picture_id">
        <label class="control-label" for="goods-picture_id"><?= $model->getAttributeLabel('picture_id'); ?></label>
        <div>
            <?= Html::activeInput('hidden',$model,'picture_id'); ?>
            <?php Modal::begin([
                'toggleButton' => ['label' => '<i class="fa fa-image"></i> 上传图片', 'class' => 'btn btn-info', 'id' => 'uploader','data-url'=> Url::to(['/uploader/modal','category'=>'goods','max'=>1])],
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

    <?= $form->field($model, 'content')->textarea(['rows' => 6, 'class' => 'ueditor']) ?>

    <?= $form->field($model, 'sale_mode')->radioList($model->getSaleModeOptions());?>

    <?= $form->field($model, 'goods_type')->radioList($model->getGoodsTypeOptions());?>

    <?= $form->field($model, 'presell')->radioList($model->getPresellOptions());?>

    <?= $form->field($model, 'audit')->radioList($model->getAuditOptions());?>

    <?= $form->field($model, 'hit')->textInput() ?>

    <?= $form->field($model, 'sale_url')->textInput(['placeholder'=>'http://']) ?>

    <?= $form->field($model, "color")->widget(ColorInput::classname(), [
        'showDefaultPalette'=>false,
        'pluginOptions'=>[
            'showPalette' => true,
            'showPaletteOnly' => true,
            'showSelectionPalette' => true,
            'showAlpha' => false,
            'allowEmpty' => false,
            'preferredFormat' => 'name',
            'palette' => array_chunk(\common\models\Article::getColorOptions(),6),
        ]
    ]);?>

    <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_keyword')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> 创建' : '<i class="fa fa-save"></i> 更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->registerJsFile('@web/plug-in/ueditor/ueditor.config.js',['depends'=>['backend\assets\AppAsset'],'position' => \yii\web\View::POS_HEAD]);?>
<?php $this->registerJsFile('@web/plug-in/ueditor/ueditor.all.js',['depends'=>['backend\assets\AppAsset'],'position' => \yii\web\View::POS_HEAD]);?>

    <script>
        <?php $this->beginBlock('js') ?>
        var ue = UE.getEditor('goods-content',{
            initialFrameHeight:300
        });
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
            $("#goods-picture_id").val('');
            var picture_id = [];
            $("#uploader-modal .uploader-list .file-item").each(function(i,item){
                picture_id.push($(item).find(".picture_id").val());
                $("#selected-picture").append('<img class="img-responsive img-thumbnail" src="'+$(item).find("img").attr("src")+'" width="100" height="100">');
            });
            $("#goods-picture_id").val(picture_id.join(','));
            $("#uploader-modal").modal('hide');
        });
        <?php $this->endBlock(); ?>
    </script>
<?php $this->registerJs($this->blocks['js'],\yii\web\View::POS_END);
