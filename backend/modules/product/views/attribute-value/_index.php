<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;

?>

<div class="attribute-value-content" style="width:92%;margin:0 auto;">
    <h4>属性值管理 <small>Attribute Value</small></h4>
    <div class="row">
        <div class="col-lg-12">
            <p>
                <?php Modal::begin([
                    'id' => 'toggle-create-attribute-value_'.$model->attribute_name_id,
                    'toggleButton' => ['label' => '<i class="fa fa-plus-circle"></i> '.$attributeName->name, 'class' => 'btn btn-warning'],
                    'header' => '<h4><i class="fa fa-edit"></i> '.$attributeName->name.'</h4>',
                    'headerOptions' => ['class'=>'modal-title'],
                    'footer' => '<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-undo"></i> 取消</button> <button type="button" class="btn btn-primary save-attribute-value" ><i class="fa fa-save"></i> 保存</button>',
                ]);?>

                <div class="attribute-value-form">

                    <?php $form = ActiveForm::begin();?>

                    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'sort')->textInput() ?>
                    <?= $form->field($model, 'attribute_name_id', ['options'=>['value'=>$model->attribute_name_id]])->hiddenInput()->label(false) ?>

                    <?php ActiveForm::end(); ?>

                </div>

                <?php Modal::end();?>
            </p>

            <?= GridView::widget([
                'id' => 'attribute-value-grid-view',
                'dataProvider' => $dataProvider,
                'layout' => '<div class="box box-primary">
                    <div class="box-header with-border"><h3 class="box-title pull-left">'.$this->title.'</h3><span class=pull-right>{summary}</span></div>
                    <div class="box-body">{items}</div>
                    <div class="box-footer">{pager}</div>
                    </div>',
                'export' => false,
                //'pjax'=>true,
                'tableOptions' => ['class'=>'table table-striped table-bordered table-hover small'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'id',
                    [
                        'attribute'=>'value',
                        'value'=> function($model){
                            return '<a class="update-attribute-value" data-value="'.$model->value.'" data-sort="'.$model->sort.'" data-id="'.$model->id.'" href="javascript:void(0)">'.$model->value.'</a>';
                        },
                        'format'=>'raw',
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
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{delete}',
                    ],
                ],
            ]); ?>

        </div>
    </div>
</div>

    <script>
        <?php $this->beginBlock('js') ?>
        $(function(){
            $(".btn.btn-warning").on('click', function(){
                var form = $(this).parents('.attribute-value-content').find(".modal-body form");
                var modal = $(this).parents('.attribute-value-content').find(".modal");
                modal.find('.modal-body #attributevalue-value').val('');
                modal.find('.modal-body #attributevalue-sort').val('');
                form.attr('action','<?= Url::to(['save']);?>');
            });

            $(".save-attribute-value").on('click', function(){
                var form = $(this).parents('.attribute-value-content').find(".modal-body form");

                var content = $(this).parents(".attribute-value-content").parent();
                var expandRowKey = $(this).parents(".attribute-value-content").find('#attributevalue-attribute_name_id').val();
                var url = '<?= Url::to(['index']);?>';
                if($(this).parents(".attribute-value-content").find('.pagination .active a').length == 1) {
                    url = $(this).parents(".attribute-value-content").find('.pagination .active a').attr('href');
                }

                $.post(form.attr('action'), form.serializeArray(), function(data){
                    var status = data.status;
                    $.post(url, {expandRowKey: expandRowKey}, function (data) {
                        $("body").find('.modal-backdrop:last').remove();
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

            $(".update-attribute-value").on('click',function(){
                var modal = $(this).parents('.attribute-value-content').find(".modal");
                var form = $(this).parents('.attribute-value-content').find(".modal-body form");
                modal.find('.modal-body #attributevalue-value').val($(this).data('value'));
                modal.find('.modal-body #attributevalue-sort').val($(this).data('sort'));
                form.attr('action','<?= Url::to(['save']);?>?id='+$(this).data('id'));
                modal.modal('show');
            });

            $(".attribute-value-content .pagination a").on('click', function(e){
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