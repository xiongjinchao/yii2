<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Menu */

$this->title = '更新菜单: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '菜单管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="menu-update">

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
