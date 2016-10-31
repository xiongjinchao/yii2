<?php

use yii\helpers\Html;
use kartik\widgets\Select2;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '推荐管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recommendation-category-index">

    <p>
        <?= Html::a('<i class="fa fa-plus-circle"></i> 创建推荐', ['create'], ['class' => 'btn btn-success']) ?>
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
                'attribute' => 'name',
                'class' => 'kartik\grid\EditableColumn',
                'refreshGrid' => true,
                'editableOptions' => function ($model, $key, $index) {
                    return [
                        'header' => '名称',
                        'size' => 'md',
                        'afterInput'=>function ($form, $widget) use ($model, $index) {
                            return $form->field($model, "tag")->textInput(['maxlength' => true])
                            .$form->field($model, 'audit')->widget(Select2::classname(), [
                                'data' => \common\models\ArticleCategory::getAuditOptions(),
                                'options' => ['id'=>"audit-{$index}",'prompt' => '请选择'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ]
                            ]);
                        }
                    ];
                },
                'value'=>function($model){
                    return $model->getSpace().$model->name;
                }
            ],
            'tag',
            [
                'attribute'=>'created_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
                'filter'=>false,
            ],
            [
                'attribute'=>'updated_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
                'filter'=>false,
            ],
            [
                'label'=>'审核',
                'attribute'=>'audit',
                'filter' => Select2::widget([
                    'model'=> $searchModel,
                    'attribute'=> 'audit',
                    'data'=> \common\models\ArticleCategory::getAuditOptions(),
                    'hideSearch' => true,
                    'options' => ['prompt' => '所有类别'],
                    'pluginOptions' => ['allowClear' => 'true'],
                ]),
                'format'=>'raw',
                'value'=>function($model){
                    return Html::a($model->audit == $model::AUDIT_ENABLE?'<span class="glyphicon glyphicon-ok"></span>':'<span class="glyphicon glyphicon-remove"></span>', ['audit','id'=>$model->id], ['title' => '审核']) ;
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],

            [
                'format'=>'raw',
                'value'=>function($model){
                    $parent = $model->getParent();
                    if($model->lft>1&&($model->lft!=$parent->lft+1)){
                        return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up','id'=>$model->id], ['title' => '上移']) ;
                    }else{
                        return '';
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
                        return '';
                    }
                }
            ],
        ],
    ]); ?>
</div>
