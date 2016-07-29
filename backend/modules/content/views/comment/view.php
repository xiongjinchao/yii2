<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\content\models\Comment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '评论管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-view">
    
    <div class="box box-primary">
        <div class="box-header with-border">
            <span class="pull-right">
                <?= Html::a('<i class="fa fa-save"></i> 更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<i class="glyphicon glyphicon-trash"></i> 删除', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-default',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </span>
        </div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped table-bordered table-hover detail-view'],
                'template' => '<tr><th width="200">{label}</th><td>{value}</td></tr>',
                'attributes' => [
                    'id',
                    'parent_id',
                    'user_id',
                    'model_name',
                    'model_id',
                    'content:ntext',
                    'created_at',
                    'updated_at',
                ],
            ]) ?>
        </div>
        <div class="box-footer"></div>
    </div>
</div>
