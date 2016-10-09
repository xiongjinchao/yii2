<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\RecommendationContent */

$this->title = 'Create Recommendation Content';
$this->params['breadcrumbs'][] = ['label' => 'Recommendation Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recommendation-content-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
