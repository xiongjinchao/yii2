<?php


/* @var $this yii\web\View */
/* @var $model backend\models\Menu */

$this->title = '创建菜单';
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-list"></i> 菜单管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-create">

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
