<?php


/* @var $this yii\web\View */
/* @var $model common\models\GoodsAttribute */

$this->title = 'SKU管理';
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-globe"></i> SKU管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->goods->name.' '.$model->attributeValue->value, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="goods-attribute-update">
    <div class="row">
        <div class="col-lg-6 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title pull-left"><?php echo $this->title;?></h3>
                </div>
                <div class="box-body">
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
