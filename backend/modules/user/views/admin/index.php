<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '员工管理';
$this->params['breadcrumbs'][] = '<i class="fa fa-user-secret"></i> '.$this->title;
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
        'export' => false,
        'pjax'=>true,
        'tableOptions' => ['class'=>'table table-striped table-bordered table-hover'],
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => '\kartik\grid\SerialColumn'],
            [
                'class' => '\kartik\grid\RadioColumn'
            ],
            [
                'attribute'=>'id',
                'headerOptions'=>['style'=>'width:80px'],
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'username',
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'auth_key',
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'email',
                'vAlign'=>'middle',
                'value' => function($model){
                    return \Yii::$app->formatter->asEmail($model->email);
                },
                'format'=>'raw',
            ],
            [
                'attribute'=>'created_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'updated_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'status',
                'hAlign'=>'center',
                'format'=>'raw',
                'value'=>function($model){
                    return Html::a($model->status ==$model::STATUS_ACTIVE?'<span class="glyphicon glyphicon-ok text-success"></span>':'<span class="glyphicon glyphicon-remove text-danger"></span>', ['status','id'=>$model->id], ['title' => '状态']) ;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter'=>\common\models\Admin::getStatusOptions(),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'所有类别'],
                'headerOptions'=>['width'=>'80px'],
                'vAlign'=>'middle',
            ],
            ['class' => '\kartik\grid\ActionColumn'],
            [
                'format'=>'raw',
                'value'=>function($model){
                    return Html::a('<span class="glyphicon glyphicon-cog"></span>', ['assignment','id'=>$model->id], ['title' => '权限分配']) ;
                },
                'vAlign'=>'middle',
            ],
        ],
    ]); ?>

</div>
