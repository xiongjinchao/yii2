<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsAttribute */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Goods Attributes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-attribute-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'goods_id',
            'attribute_name_id',
            'attribute_value_id',
            'origin_price',
            'sale_price',
            'stock',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
