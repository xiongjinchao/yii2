<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Goods */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-cubes"></i> 商品管理', 'url' => ['index']];
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
                    'origin_price',
                    'sale_price',
                    [
                        'attribute' => 'picture_id',
                        'value' => $model->picture_id>0?'<img src="http://'.Yii::$app->params['domain']['image'].$model->picture->path.'" height="100">':'',
                        'format' => 'raw',
                    ],
                    'content:ntext',
                    [
                        'attribute'=>'sale_mode',
                        'value'=>$model->getSaleModeOptions($model->sale_mode),
                    ],
                    [
                        'attribute'=>'goods_type',
                        'value'=>$model->getGoodsTypeOptions($model->goods_type),
                    ],
                    [
                        'attribute'=>'audit',
                        'value'=>$model->getAuditOptions($model->audit),
                    ],
                    [
                        'attribute'=>'presell',
                        'value'=>$model->getPresellOptions($model->presell),
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