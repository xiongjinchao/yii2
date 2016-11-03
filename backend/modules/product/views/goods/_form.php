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

    <?= $form->field($model, 'content')->textarea(['rows' => 6, 'class' => 'ueditor']) ?>

    <?= $form->field($model, 'audit')->radioList($model->getAuditOptions());?>

    <?= $form->field($model, 'hot')->radioList($model->getHotOptions());?>

    <?= $form->field($model, 'recommend')->radioList($model->getRecommendOptions());?>

    <?= $form->field($model, 'hit')->textInput() ?>

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
        <?php $this->endBlock(); ?>
    </script>
<?php $this->registerJs($this->blocks['js'],\yii\web\View::POS_END);
