<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '属性管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attribute-name-index">

    <p>
        <?php Modal::begin([
                'toggleButton' => ['label' => '<i class="fa fa-plus-circle"></i> 创建属性', 'class' => 'btn btn-success'],
                'header' => '<h4><i class="fa fa-edit"></i> 创建属性</h4>',
                'headerOptions' => ['class'=>'modal-title'],
                'footer' => '<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-undo"></i> 取消</button> <button type="button" class="btn btn-primary" id="create-attribute-name"><i class="fa fa-save"></i> 保存</button>',
            ]);
        Modal::end();
        ?>
    </p>


    <?= GridView::widget([
        'id' => 'attribute-name-grid-view',
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
                'class'=>'kartik\grid\ExpandRowColumn',
                'width'=>'50px',
                'value'=>function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detailUrl' => Url::to(['attribute-value/index']),
                'headerOptions' => ['class'=>'kartik-sheet-style'],
                'expandOneOnly' => true
            ],
            [
                'attribute'=>'name',
                'class' => 'kartik\grid\EditableColumn',
                'refreshGrid' => true,
                'editableOptions' => function ($model, $key, $index) {
                    return [
                        'header' => '名称',
                        'size' => 'md',
                        'afterInput'=>function ($form, $widget) use ($model, $index) {
                            return $form->field($model, 'audit')->widget(Select2::classname(), [
                                'data' => \common\models\AttributeName::getAuditOptions(),
                                'options' => ['id'=>"audit-{$index}",'placeholder' => '请选择'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ]
                            ]).$form->field($model, 'status')->widget(Select2::classname(), [
                                'data' => \common\models\AttributeName::getStatusOptions(),
                                'options' => ['id'=>"status-{$index}",'placeholder' => '请选择'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ]
                            ]);
                        }
                    ];
                }
            ],
            [
                'attribute'=>'status',
                'filter' => Select2::widget([
                    'model'=> $searchModel,
                    'attribute'=> 'status',
                    'data'=> \common\models\AttributeName::getStatusOptions(),
                    'hideSearch' => true,
                    'options' => ['prompt' => '所有状态'],
                    'pluginOptions' => ['allowClear' => 'true'],
                ]),
                'format'=>'raw',
                'width'=>'8%',
                'value'=>function($model){
                    return $model->status == $model::STATUS_SKU?'SKU':'SPU';
                },
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
                'attribute'=>'audit',
                'filter' => Select2::widget([
                    'model'=> $searchModel,
                    'attribute'=> 'audit',
                    'data'=> \common\models\AttributeName::getAuditOptions(),
                    'hideSearch' => true,
                    'options' => ['prompt' => '所有类别'],
                    'pluginOptions' => ['allowClear' => 'true'],
                ]),
                'format'=>'raw',
                'width'=>'8%',
                'value'=>function($model){
                    return Html::a($model->audit == $model::AUDIT_ENABLE?'<span class="glyphicon glyphicon-ok"></span>':'<span class="glyphicon glyphicon-remove"></span>', ['audit','id'=>$model->id], ['title' => '审核']) ;
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ],
        ],
    ]); ?>
</div>

    <script>
        <?php $this->beginBlock('js') ?>
        $(function(){
            $.get("<?= Url::to(['create'])?>", {}, function (data) {
                $(".modal-body").html(data);
            });
            $("#create-attribute-name").on('click', function(){
                $(this).parents('.modal-content').find(".modal-body form").submit();
            });
        });
        <?php $this->endBlock(); ?>
    </script>
<?php $this->registerJs($this->blocks['js'],\yii\web\View::POS_END);
