<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '角色管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-index">

    <p>
        <?= Html::a('<i class="fa fa-plus-circle"></i> 创建角色', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '<div class="box box-primary">
            <div class="box-header with-border"><h3 class="box-title pull-left">'.$this->title.'</h3><span class=pull-right>{summary}</span></div>
            <div class="box-body">{items}</div>
            <div class="box-footer">{pager}</div>
            </div>',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name:text:角色名称',
            'description:text:描述',
            [
                'label'=>'级别',
                'value'=>function($model){
                    return unserialize($model['data']);
                },
            ],
            [
                'label'=>'创建时间',
                'attribute'=>'created_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
            ],
            [
                'label'=>'更新时间',
                'attribute'=>'updated_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view','name'=>$model['name']], ['title' => '查看']) ;
                        },
                    'update' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update','name'=>$model['name']], ['title' => '编辑']) ;
                        },
                    'delete' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete','name'=>$model['name']], ['title' => '删除','data-method' => 'post']) ;
                        },
                ],
            ],
            [
                'format'=>'raw',
                'value'=>function($model){
                        return Html::a('<span class="glyphicon glyphicon-cog"></span>', ['assignment','name'=>$model['name']], ['title' => '权限分配']) ;
                    }
            ],

        ],
    ]); ?>

</div>
