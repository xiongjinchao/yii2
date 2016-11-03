<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Goods */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '商品管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-view">

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
                    [
                        'attribute'=>'category_id',
                        'value'=>isset($model->category->name)?$model->category->name:'',
                    ],
                    'content:ntext',
                    [
                        'attribute'=>'audit',
                        'value'=>$model->getAuditOptions($model->audit),
                    ],
                    [
                        'attribute'=>'hot',
                        'value'=>$model->getHotOptions($model->hot),
                    ],
                    [
                        'attribute'=>'recommend',
                        'value'=>$model->getRecommendOptions($model->recommend),
                    ],
                    'hit',
                    [
                        'attribute'=>'color',
                        'value'=>$model->color == ''? '' : "<span class='badge' style='background-color: ".$model->color."'> </span>  <code>".$model->color.'</code>',
                        'format'=>'raw',
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