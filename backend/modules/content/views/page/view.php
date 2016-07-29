<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Page */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '单页管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-view">
    
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
                    'name',
                    'tag',
                    'lft',
                    'rgt',
                    'parent',
                    'depth',
                    'content:ntext',
                    [
                        'attribute' => 'visible',
                        'value' => $model->getVisibleOptions($model->visible),
                    ],
                    [
                        'attribute' => 'audit',
                        'value' => $model->getAuditOptions($model->audit),
                    ],
                    'seo_title',
                    'seo_description',
                    'seo_keyword',
                    [
                        'attribute'=>'created_at',
                        'format'=>['datetime','php:Y-m-d H:i:s'],
                    ],
                    [
                        'attribute'=>'updated_at',
                        'format'=>['datetime','php:Y-m-d H:i:s'],
                    ],
                ],
            ]) ?>
        </div>
        <div class="box-footer"></div>
    </div>
</div>
