<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RecommendationContent */

$this->title = '更新推荐';
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-rocket"></i> 推荐内容', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="recommendation-content-update">
    <div class="row">
        <div class="col-lg-6 col-xs-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    <li class="active">
                        <?=Html::a('推荐内容',['recommendation-content/index', 'category_id' => $category->id])?>
                    </li>
                    <li>
                        <?=Html::a('基本信息',['recommendation-category/update', 'id' => $category->id])?>
                    </li>
                    <li>
                        <?=Html::a('推荐分类',['recommendation-category/index'])?>
                    </li>
                    <li class="pull-left header">
                        <?php echo $model->title; ?>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active">
                        <?= $this->render('_form', [
                            'model' => $model,
                            'picture' => $picture,
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
