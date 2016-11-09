<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;

?>

<div class="attribute-value-content" style="width:92%;margin:0 auto;">
    <h4>属性值管理 <small>Attribute Value<?=$model->attribute_name_id;?></small></h4>
    <div class="row">
        <div class="col-lg-12">
            <p>
                <?php Modal::begin([
                    'id' => 'toggle-create-attribute-value_'.$model->attribute_name_id,
                    'toggleButton' => ['label' => '<i class="fa fa-plus-circle"></i> '.$attributeName->name, 'class' => 'btn btn-warning create-attribute-value','id'=>'create-attribute-value_'.$model->attribute_name_id],
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
                    ['class' => '\kartik\grid\SerialColumn'],
                    [
                        'attribute'=>'id',
                        'enableSorting'=>false,
                    ],
                    [
                        'attribute'=>'value',
                        'value'=> function($model){
                            return '<a class="update-attribute-value" data-value="'.$model->value.'" data-sort="'.$model->sort.'" data-id="'.$model->id.'" href="javascript:void(0)">'.$model->value.'</a>';
                        },
                        'enableSorting'=>false,
                        'format'=>'raw',
                    ],
                    [
                        'attribute'=>'sort',
                        'enableSorting'=>false,
                    ],
                    [
                        'attribute'=>'created_at',
                        'format'=>['datetime','php:Y-m-d H:i:s'],
                        'enableSorting'=>false,
                    ],
                    [
                        'attribute'=>'updated_at',
                        'format'=>['datetime','php:Y-m-d H:i:s'],
                        'enableSorting'=>false,
                    ],
                    [
                        'class' => '\kartik\grid\ActionColumn',
                        'template' => '{delete}',
                    ],
                ],
            ]); ?>

        </div>
    </div>
</div>