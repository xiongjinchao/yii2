<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RecommendationContent */

$this->title = 'Update Recommendation Content: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Recommendation Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="recommendation-content-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
