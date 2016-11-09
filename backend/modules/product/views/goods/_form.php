<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\ColorInput;
use common\models\GoodsCategory;

/* @var $this yii\web\View */
/* @var $model common\models\Goods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

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

    <div class="form-group field-goods-master_picture">
        <label class="control-label" for="user-master_picture"><?= $model->getAttributeLabel('master_picture'); ?></label>
        <?= Html::activeHiddenInput($model,'master_picture',['id'=>null]); ?>
        <?= Html::activeFileInput($model,'master_picture',['style'=>'display:none']); ?>
        <div>
            <a class="btn btn-info upload"><i class="fa fa-image"></i> 选择图片</a>
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

<?php $this->registerJsFile('@web/plug-in/ueditor/ueditor.config.js',['position' => \yii\web\View::POS_HEAD]);?>
<?php $this->registerJsFile('@web/plug-in/ueditor/ueditor.all.js',['position' => \yii\web\View::POS_HEAD]);?>

    <script>
        <?php $this->beginBlock('js') ?>
        var ue = UE.getEditor('goods-content',{
            initialFrameHeight:300
        });
        $(".upload").click(function(){
            $("#goods-master_picture").trigger('click');
        });
        <?php $this->endBlock(); ?>
    </script>
<?php $this->registerJs($this->blocks['js'],\yii\web\View::POS_END);
