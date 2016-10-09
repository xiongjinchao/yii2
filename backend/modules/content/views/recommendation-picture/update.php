<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RecommendationPicture */

$this->title = 'Update Recommendation Picture: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Recommendation Pictures', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="recommendation-picture-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
