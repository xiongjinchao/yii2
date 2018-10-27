<?php

use yii\helpers\Html;
use kartik\widgets\Select2;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '推荐内容';
$this->params['breadcrumbs'][] = '<i class="fa fa-rocket"></i> '.$this->title;
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
                    'filterModel' => $searchModel,
                    'export' => false,
                    'pjax'=>true,
                    'tableOptions' => ['class'=>'table table-striped table-bordered table-hover'],
                    'columns' => [
                        [
                            'class' => '\kartik\grid\SerialColumn',
                        ],
                        [
                            'class' => '\kartik\grid\RadioColumn'
                        ],
                        [
                            'attribute'=>'id',
                            'width'=>'5%',
                        ],
                        [
                            'attribute' => 'title',
                            'class' => 'kartik\grid\EditableColumn',
                            'refreshGrid' => true,
                            'editableOptions' => function ($model, $key, $index) {
                                return [
                                    'header' => '标题',
                                    'size' => 'md',
                                    'afterInput'=>function ($form, $widget) use ($model, $index) {
                                        return $form->field($model, 'audit')->widget(Select2::classname(), [
                                            'data' => \common\models\RecommendationContent::getAuditOptions(),
                                            'options' => ['id'=>"audit-{$index}",'placeholder' => '请选择'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ]
                                        ]);
                                    }
                                ];
                            }
                        ],
                        [
                            'attribute' => 'category_id',
                            'filter' => Select2::widget([
                                'model'=> $searchModel,
                                'attribute'=> 'category_id',
                                'data'=> \common\models\RecommendationCategory::getRecommendationCategoryOptions(),
                                'options' => ['placeholder' => '所有分类'],
                                'pluginOptions' => ['allowClear' => 'true'],
                            ]),
                            'value'=>function($model){
                                return  isset($model->category)&&$model->category!=null?$model->category->name:'';
                            }
                        ],
                        [
                            'attribute' => 'sort',
                            'filter' => false,
                        ],
                        [
                            'attribute'=>'created_at',
                            'format'=>['datetime','php:Y-m-d H:i:s'],
                        ],
                        [
                            'attribute'=>'updated_at',
                            'format'=>['datetime','php:Y-m-d H:i:s'],
                        ],
                        [
                            'label'=>'审核',
                            'attribute'=>'audit',
                            'format'=>'raw',
                            'hAlign'=>'center',
                            'value'=>function($model){
                                return Html::a($model->audit == $model::AUDIT_ENABLE?'<span class="glyphicon glyphicon-ok text-success"></span>':'<span class="glyphicon glyphicon-remove text-danger"></span>', ['audit','id'=>$model->id], ['title' => '审核']) ;
                            },
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter'=>\common\models\RecommendationContent::getAuditOptions(),
                            'filterWidgetOptions'=>[
                                'pluginOptions'=>['allowClear'=>true],
                            ],
                            'filterInputOptions'=>['placeholder'=>'所有类别'],
                        ],
                        [
                            'class' => '\kartik\grid\ActionColumn',
                            'template' => '{update} {delete}',
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
