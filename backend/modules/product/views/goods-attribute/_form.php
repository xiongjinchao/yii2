<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\models\Goods;
use common\models\AttributeName;
use common\models\AttributeValue;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsAttribute */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-attribute-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'goods_id')->widget(Select2::classname(), [
        'data' => Goods::getGoodsOptions(),
        'options' => ['placeholder' => '请选择'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'attribute_name_id')->widget(Select2::classname(), [
        'data' => AttributeName::getAttributeNameOptions(),
        'options' => ['placeholder' => '请选择'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'attribute_value_id')->widget(Select2::classname(), [
        'data' => AttributeValue::getAttributeValueOptions($model->attribute_name_id),
        'options' => ['placeholder' => '请选择'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'origin_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sale_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'stock')->textInput() ?>
    
    <?= $form->field($model, 'status')->radioList($model->getStatusOptions());?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> 创建' : '<i class="fa fa-save"></i> 更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <script>
        $("select[name='GoodsAttribute[attribute_name_id]']").on('change',function(){
            $("select[name='GoodsAttribute[attribute_value_id]'] option").remove();
            $.post('<?=Url::to(['/product/attribute-value/ajax-get-attribute-value']);?>',{attribute_name_id:$(this).val()},function(result){
                $("select[name='GoodsAttribute[attribute_value_id]']").select2({
                    data: result,
                    placeholder:'请选择',
                    allowClear:true,
                    width:'100%',
                    theme: 'krajee'
                });
            },'json');
        });
    </script>

</div>
