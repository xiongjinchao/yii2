<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '员工管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-index">
    <p>
        <?= Html::a('<i class="fa fa-plus-circle"></i> 创建员工', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fa  fa-refresh"></i> 重置权限', ['reset'], ['class' => 'btn btn-warning','data'=>['confirm' => 'Are you sure you want to reset RBAC?',]]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '<div class="box box-primary">
            <div class="box-header with-border"><h3 class="box-title pull-left">'.$this->title.'</h3><span class=pull-right>{summary}</span></div>
            <div class="box-body">{items}</div>
            <div class="box-footer">{pager}</div>
            </div>',
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'id',
                'headerOptions'=>['style'=>'width:80px'],
            ],
            'username',
            'auth_key',
            //'password_hash',
            //'password_reset_token',
            // 'email:email',
            // 'status',
            [
                'attribute'=>'created_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
            ],
            [
                'attribute'=>'updated_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
            ],

            ['class' => 'yii\grid\ActionColumn'],
            [
                'format'=>'raw',
                'value'=>function($model){
                    return Html::a('<span class="glyphicon glyphicon-cog"></span>', ['assignment','id'=>$model->id], ['title' => '权限分配']) ;
                }
            ],
        ],
    ]); ?>

</div>
