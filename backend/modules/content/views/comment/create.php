<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\content\models\Comment */

$this->title = '创建评论';
$this->params['breadcrumbs'][] = ['label' => '评论管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-create">

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
