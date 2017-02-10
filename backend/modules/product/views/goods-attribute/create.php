<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\GoodsAttribute */

$this->title = 'Create Goods Attribute';
$this->params['breadcrumbs'][] = ['label' => 'Goods Attributes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-attribute-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
