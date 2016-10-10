<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RecommendationContent */

$this->title = '更新推荐: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '推荐内容', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="recommendation-content-update">

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
            <li>
                <?=Html::a('推荐图片',['recommendation-picture/index', 'content_id' => $model->id])?>
            </li>
            <li class="active">
                <?=Html::a('推荐内容',['recommendation-content/index', 'category_id' => $category->id])?>
            </li>
            <li>
                <?=Html::a('基本信息',['recommendation-category/update', 'id' => $category->id])?>
            </li>
            <li>
                <?=Html::a('推荐分类',['recommendation-category/index'])?>
            </li>
            <li class="pull-left header">
                <?php echo $this->title; ?>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>

</div>
