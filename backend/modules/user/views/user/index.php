<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '客户管理';
$this->params['breadcrumbs'][] = '<i class="fa fa-user"></i> '.$this->title;
?>
<div class="admin-index">

    <p>
        <?= Html::a('<i class="fa fa-plus-circle"></i> 创建客户', ['create'], ['class' => 'btn btn-success']) ?>
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
                'headerOptions'=>['width'=>'4%'],
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'picture_id',
                'value'=>function($model){
                    return isset($model->picture)?Html::img('http://'.Yii::$app->params['domain']['image'].$model->picture->path,['class'=>'img-responsive img-thumbnail','width'=>'60','height'=>'60']):'';
                },
                'headerOptions'=>['width'=>'80px'],
                'vAlign'=>'middle',
                'filter'=>false,
                'format'=>'raw',
            ],
            [
                'attribute'=>'username',
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'mobile',
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'email',
                'vAlign'=>'middle',
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
                'format'=>'raw',
                'value'=>function($model){
                    return Html::a($model->status ==$model::STATUS_ACTIVE?'<span class="glyphicon glyphicon-ok text-success"></span>':'<span class="glyphicon glyphicon-remove text-danger"></span>', ['status','id'=>$model->id], ['title' => '状态']) ;
                },
                'headerOptions'=>['width'=>'80px'],
                'vAlign'=>'middle',
                'hAlign'=>'center',
                'filter'=>false
            ],
            ['class' => '\kartik\grid\ActionColumn'],
        ],
    ]); ?>

</div>
