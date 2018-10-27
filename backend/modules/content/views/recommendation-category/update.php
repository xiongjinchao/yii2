<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RecommendationCategory */

$this->title = '更新推荐';
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-rocket"></i> 推荐管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="recommendation-category-update">
    <div class="row">
        <div class="col-lg-6 col-xs-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    <li>
                        <?=Html::a('推荐内容',['recommendation-content/index', 'category_id' => $model->id])?>
                    </li>
                    <li class="active">
                        <?=Html::a('基本信息',['recommendation-category/update', 'id' => $model->id])?>
                    </li>
                    <li>
                        <?=Html::a('推荐分类',['recommendation-category/index'])?>
                    </li>
                    <li class="pull-left header">
                        <?php echo $model->name; ?>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active">

                        <?= $this->render('_form', [
                            'model' => $model,
                        ]) ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
