<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\content\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('段落', ['article-section/edit', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('评论', ['comment/index', 'CommentSearch[model_name]' => 'article','CommentSearch[model_id]' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
                'attribute'=>'category_id',
                'value'=>$model->getArticleCategoryValues(),
            ],
            'content:ntext',
            [
                'attribute'=>'audit',
                'value'=>$model->getAuditOptions($model->audit),
            ],
            [
                'attribute'=>'hot',
                'value'=>$model->getHotOptions($model->hot),
            ],
            [
                'attribute'=>'recommend',
                'value'=>$model->getRecommendOptions($model->recommend),
            ],
            'hit',
            'user_id',
            'author',
            'source',
            'source_url:url',
            'seo_title',
            'seo_description',
            'seo_keyword',
            [
                'attribute'=>'created_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
            ],
            [
                'attribute'=>'updated_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
            ],
        ],
    ]) ?>

</div>
