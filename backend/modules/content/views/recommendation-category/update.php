<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RecommendationCategory */

$this->title = 'Update Recommendation Category: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Recommendation Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="recommendation-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
