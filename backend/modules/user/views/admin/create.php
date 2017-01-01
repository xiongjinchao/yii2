<?php


/* @var $this yii\web\View */
/* @var $model backend\models\Admin */

$this->title = '创建员工';
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-user-secret"></i> 员工管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-create">

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
