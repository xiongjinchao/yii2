<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-index">

    <p>
        <?= Html::a('<i class="fa fa-plus-circle"></i> 创建用户', ['create'], ['class' => 'btn btn-success']) ?>
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
                'headerOptions'=>['width'=>'80px'],
            ],
            [
                'attribute'=>'picture_id',
                'value'=>function($model){
                    return $model->picture_id>0?'<img src="'.$model->picture->url.'" height="30">':'';
                },
                'headerOptions'=>['width'=>'80px'],
                'format'=>'raw',
            ],
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            // 'email:email',
            [
                'attribute'=>'created_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
            ],
            [
                'attribute'=>'updated_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
            ],
            [
                'attribute'=>'status',
                'format'=>'raw',
                'value'=>function($model){
                    return Html::a($model->status ==$model::STATUS_ACTIVE?'<span class="glyphicon glyphicon-ok"></span>':'<span class="glyphicon glyphicon-remove"></span>', ['status','id'=>$model->id], ['title' => '状态']) ;
                },
                'headerOptions'=>['width'=>'80px'],
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
