<?php

use backend\modules\content\models\ArticleCategory;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\content\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php
    $form = ActiveForm::begin();
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList((new ArticleCategory)->getArticleCategoryOptions(),['prompt'=>'请选择','multiple'=>'true']);?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6, 'class' => 'ueditor']) ?>

    <?= $form->field($model, 'audit')->radioList($model->getAuditOptions());?>

    <?= $form->field($model, 'hot')->radioList($model->getHotOptions());?>

    <?= $form->field($model, 'recommend')->radioList($model->getRecommendOptions());?>

    <?= $form->field($model, 'hit')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'author')->textInput() ?>

    <?= $form->field($model, 'source')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'source_url')->textInput(['maxlength' => true]) ?>

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
<script type="text/javascript">
    var ue = UE.getEditor('article-content',{
        initialFrameHeight:300
    });
</script>