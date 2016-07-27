<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '角色管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <p>
        <?= Html::a('更新', ['update', 'name' => $model->name], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('授权', ['assignment', 'name' => $model->name], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('删除', ['delete', 'name' => $model->name], [
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
            'name:text:角色名称',
            'type:text:权限类型',
            'description:text:描述',
            'data:text:级别',
            'createdAt:datetime:创建时间',
            'updatedAt:datetime:更新时间',
        ],
    ]) ?>

</div>
