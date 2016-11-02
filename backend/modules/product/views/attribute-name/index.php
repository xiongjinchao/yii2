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


        $(function(){
            $(".attribute-name-index").on('click', '.create-attribute-value', function(){
                var form = $(this).parents('.attribute-value-content').find(".modal-body form");
                var modal = $(this).parents('.attribute-value-content').find(".modal");
                modal.find('.modal-body #attributevalue-value').val('');
                modal.find('.modal-body #attributevalue-sort').val('');
                form.attr('action','<?= Url::to(['attribute-value/save']);?>');
            });

            $(".attribute-name-index").on('click', '.save-attribute-value', function(){
                var form = $(this).parents('.attribute-value-content').find(".modal-body form");

                var content = $(this).parents(".attribute-value-content").parent();
                var expandRowKey = $(this).parents(".attribute-value-content").find('#attributevalue-attribute_name_id').val();
                var url = '<?= Url::to(['attribute-value/index']);?>';
                if($(this).parents(".attribute-value-content").find('.pagination .active a').length == 1) {
                    url = $(this).parents(".attribute-value-content").find('.pagination .active a').attr('href');
                }

                $.post(form.attr('action'), form.serializeArray(), function(data){
                    var status = data.status;
                    $("body").find('.modal-backdrop:last').remove();
                    $("body").removeClass('modal-open');
                    $.post(url, {expandRowKey: expandRowKey}, function (data) {
                        content.find(".attribute-value-content").remove();
                        content.append(data);
                        if(status == 'success'){
                            content.find(".attribute-value-content h4:first").after(
                                '<div class="alert-info callout alert fade in">' +
                                '<button class="close" aria-hidden="true" type="button" data-dismiss="alert">×</button>' +
                                '<i class="icon fa fa-info"></i>保存成功！'+
                                '</div>'
                            );
                        }else{
                            content.find(".attribute-value-content h4:first").after(
                                '<div class="alert-danger callout alert fade in">' +
                                '<button class="close" aria-hidden="true" type="button" data-dismiss="alert">×</button>' +
                                '<i class="icon fa fa-info"></i>保存失败！'+
                                '</div>'
                            );
                        }
                    });

                },'json');
            });

            $(".attribute-name-index").on('click', '.update-attribute-value', function(){
                var modal = $(this).parents('.attribute-value-content').find(".modal");
                var form = $(this).parents('.attribute-value-content').find(".modal-body form");
                modal.find('.modal-body #attributevalue-value').val($(this).data('value'));
                modal.find('.modal-body #attributevalue-sort').val($(this).data('sort'));
                form.attr('action','<?= Url::to(['attribute-value/save']);?>?id='+$(this).data('id'));
                modal.modal('show');
            });

            $(".attribute-name-index").on('click', '.attribute-value-content .pagination a', function(e){
                e.preventDefault();
                var content = $(this).parents(".attribute-value-content");
                var expandRowKey = $(this).parents(".attribute-value-content").find('#attributevalue-attribute_name_id').val();
                var url = $(this).attr('href');

                $.post(url, {expandRowKey:expandRowKey}, function(data){
                    content.parent().append(data);
                    content.remove();
                });
            });
        });
        <?php $this->endBlock(); ?>
    </script>
<?php $this->registerJs($this->blocks['js'],\yii\web\View::POS_END);
