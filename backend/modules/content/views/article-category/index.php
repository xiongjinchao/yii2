<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章分类';
$this->params['breadcrumbs'][] = '<i class="fa fa fa-navicon"></i> '.$this->title;
?>
<div class="menu-index">

    <p>
        <?= Html::a('<i class="fa fa-plus-circle"></i> 创建分类', ['create'], ['class' => 'btn btn-success']) ?>
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
        'columns' => [
            ['class' => '\kartik\grid\SerialColumn'],
            [
                'class' => '\kartik\grid\RadioColumn'
            ],
            [
                'attribute'=>'id',
                'headerOptions'=>['style'=>'width:5%'],
            ],
            [
                'attribute'=>'name',
                'value'=>function($model){
                    return $model->getSpace().$model->name;
                }
            ],
            'action',
            'lft',
            'rgt',
            'parent',
            'depth',
            [
                'attribute'=>'created_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
            ],
            [
                'attribute'=>'updated_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
            ],
            [
                'attribute'=>'audit',
                'format'=>'raw',
                'hAlign'=>'center',
                'value'=>function($model){
                    return Html::a($model->audit == 1?'<span class="glyphicon glyphicon-ok text-success"></span>':'<span class="glyphicon glyphicon-remove text-danger"></span>', ['audit','id'=>$model->id], ['title' => '审核']) ;
                },
                'headerOptions'=>['style'=>'width:5%']
            ],
            // 'seo_title',
            // 'seo_description',
            // 'seo_keyword',

            ['class' => '\kartik\grid\ActionColumn'],
            [
                'format'=>'raw',
                'value'=>function($model){
                    $parent = $model->getParent();
                    if($model->lft>1&&($model->lft!=$parent->lft+1)){
                        return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up','id'=>$model->id], ['title' => '上移']) ;
                    }else{
                        return '<span class="glyphicon glyphicon-arrow-up text-gray"></span>';
                    }
                }
            ],
            [
                'format'=>'raw',
                'value'=>function($model){
                    $parent = $model->getParent();
                    $lastBrother = $model->getLastBrother();
                    if($model->id!=$lastBrother->id&&($model->rgt!=$parent->rgt-1)){
                        return Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down','id'=>$model->id], ['title' => '下移']) ;
                    }else{
                        return '<span class="glyphicon glyphicon-arrow-down text-gray"></span>';
                    }
                }
            ],
        ],
    ]); ?>

</div>
