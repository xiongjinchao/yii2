<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '属性管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <p>
        <?= Html::a('<i class="fa fa-plus-circle"></i> 创建属性', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '<div class="box box-primary">
            <div class="box-header with-border"><h3 class="box-title pull-left">'.$this->title.'</h3><span class=pull-right>{summary}</span></div>
            <div class="box-body">{items}</div>
            <div class="box-footer">{pager}</div>
            </div>',
        'export' => false,
        //'pjax'=>true,
        'tableOptions' => ['class'=>'table table-striped table-bordered table-hover'],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
            ],
            [
                'class' => '\kartik\grid\RadioColumn'
            ],
            [
                'attribute'=>'id',
                'width'=>'5%',
            ],
            [
                'attribute'=>'name',
                'class' => 'kartik\grid\EditableColumn',
                'refreshGrid' => true,
                'editableOptions' => function ($model, $key, $index) {
                    return [
                        'header' => '名称',
                        'size' => 'md',
                    ];
                }
            ],
            [
                'attribute'=>'created_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
                'width'=>'15%',
            ],
            [
                'attribute'=>'updated_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
                'width'=>'15%',
            ],
            [
                'label'=>'审核',
                'attribute'=>'audit',
                'filter' => Select2::widget([
                    'model'=> $searchModel,
                    'attribute'=> 'audit',
                    'data'=> \common\models\AttributeName::getAuditOptions(),
                    'hideSearch' => true,
                    'options' => ['placeholder' => '所有类别'],
                    'pluginOptions' => ['allowClear' => 'true'],
                ]),
                'format'=>'raw',
                'width'=>'8%',
                'value'=>function($model){
                    return Html::a($model->audit == $model::AUDIT_ENABLE?'<span class="glyphicon glyphicon-ok"></span>':'<span class="glyphicon glyphicon-remove"></span>', ['audit','id'=>$model->id], ['title' => '审核']) ;
                },
            ],
            [
                'label'=>'状态',
                'attribute'=>'status',
                'filter' => Select2::widget([
                    'model'=> $searchModel,
                    'attribute'=> 'status',
                    'data'=> \common\models\AttributeName::getStatusOptions(),
                    'hideSearch' => true,
                    'options' => ['placeholder' => '所有状态'],
                    'pluginOptions' => ['allowClear' => 'true'],
                ]),
                'format'=>'raw',
                'width'=>'8%',
                'value'=>function($model){
                    return Html::a($model->status == $model::STATUS_SKU?'<span class="glyphicon glyphicon-ok"></span>':'<span class="glyphicon glyphicon-remove"></span>', ['status','id'=>$model->id], ['title' => '状态']) ;
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
