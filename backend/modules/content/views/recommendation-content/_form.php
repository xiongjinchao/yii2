<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\RecommendationCategory;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\RecommendationContent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recommendation-content-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
        'data' => RecommendationCategory::getRecommendationCategoryOptions(),
        'options' => ['prompt' => '请选择'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6, 'maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textarea(['rows' => 6, 'maxlength' => true]) ?>

    <?= $form->field($model, 'audit')->radioList($model->getAuditOptions());?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> 创建' : '<i class="fa fa-save"></i> 更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
