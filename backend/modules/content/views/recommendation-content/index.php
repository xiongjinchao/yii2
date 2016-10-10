<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '推荐内容';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recommendation-content-index">

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
            <li class="active">
                <?=Html::a('推荐内容',['recommendation-content/index', 'category_id' => $category->id])?>
            </li>
            <li>
                <?=Html::a('基本信息',['recommendation-category/update', 'id' => $category->id])?>
            </li>
            <li>
                <?=Html::a('推荐分类',['recommendation-category/index'])?>
            </li>
            <li class="pull-left header">
                <?php echo $this->title; ?>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active">

                <p>
                    <?= Html::a('创建推荐', ['create','category_id' => $category->id], ['class' => 'btn btn-success']) ?>
                </p>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class'=>'table table-striped table-bordered table-hover'],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute'=>'id',
                            'headerOptions'=>['style'=>'width:5%'],
                        ],
                        'title',
                        [
                            'attribute'=>'category_id',
                            'value'=>function($model){
                                if(isset($model->category)){
                                    return $model->category->name;
                                }
                            },
                        ],
                        'sort',
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
                            'value'=>function($model){
                                return Html::a($model->audit == $model::AUDIT_ENABLE?'<span class="glyphicon glyphicon-ok"></span>':'<span class="glyphicon glyphicon-remove"></span>', ['audit','id'=>$model->id], ['title' => '审核']) ;
                            },
                            'headerOptions'=>['style'=>'width:5%']
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update} {delete}',
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
