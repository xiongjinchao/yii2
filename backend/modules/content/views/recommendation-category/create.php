<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\RecommendationCategory */

$this->title = 'Create Recommendation Category';
$this->params['breadcrumbs'][] = ['label' => 'Recommendation Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recommendation-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
