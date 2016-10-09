<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\RecommendationPicture */

$this->title = 'Create Recommendation Picture';
$this->params['breadcrumbs'][] = ['label' => 'Recommendation Pictures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recommendation-picture-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
