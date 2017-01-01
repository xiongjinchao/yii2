<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Page */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-file"></i> 单页管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="page-update">

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
