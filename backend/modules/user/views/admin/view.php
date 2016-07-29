<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Admin */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => '员工管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-view">
    
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
                    'username',
                    'auth_key',
                    'password_hash',
                    'password_reset_token',
                    'email:email',
                    [
                        'attribute' => 'status',
                        'value' => $model->getStatusOptions($model->status),
                    ],
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
