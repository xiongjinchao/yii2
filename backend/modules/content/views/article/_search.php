<?php

use common\models\ArticleCategory;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'form-inline form-search'],
    ]); ?>
    <div class="well">
    <table class="table table-condensed">
        <tbody>
            <tr>
                <td>
                    <?= $form->field($model, 'id') ?>
                </td>
                <td>
                    <?= $form->field($model, 'title') ?>
                </td>
                <td>
                    <?= $form->field($model, 'category_id')->dropDownList(ArticleCategory::getArticleCategoryOptions(),['prompt'=>'全部']);?>
                </td>
                <td>
                    <?= $form->field($model, 'user_id') ?>
                </td>
                <td>
                    <?= $form->field($model, 'author') ?>
                </td>
                <td>
                    <?= $form->field($model, 'source') ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= $form->field($model, 'audit')->dropDownList($model->getAuditOptions(),['prompt'=>'全部']);?>
                </td>
                <td>
                    <?= $form->field($model, 'hot')->dropDownList($model->getHotOptions(),['prompt'=>'全部']);?>
                </td>
                <td>
                    <?= $form->field($model, 'recommend')->dropDownList($model->getRecommendOptions(),['prompt'=>'全部']);?>
                </td>
                <td>
                    <?= $form->field($model, 'startTime')->widget(DatePicker::className(),[
                        'dateFormat' => 'yyyy-MM-dd',
                        'options'=>['class'=>'form-control']
                    ])
                    ?>
                </td>
                <td>
                    <?= $form->field($model, 'endTime')->widget(DatePicker::className(),[
                        'dateFormat' => 'yyyy-MM-dd',
                        'options'=>['class'=>'form-control']
                    ])
                    ?>
                </td>
                <td>
                    <?= $form->field($model, 'source_url') ?>
                </td>
            </tr>
        </tbody>
    </table>
    </div>
    <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
    <?= Html::a('重置', ['index'],['class' => 'btn btn-default']) ?>
    <?= Html::a('创建文章', ['create'],['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end(); ?>
</div>
