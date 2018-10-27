<?php


/* @var $this yii\web\View */
/* @var $model backend\models\ArticleCategory */

$this->title = '创建分类';
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-navicon"></i> 商品分类', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-create">
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
