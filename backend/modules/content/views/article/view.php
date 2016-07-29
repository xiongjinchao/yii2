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

    <div class="box box-primary">
        <div class="box-header with-border">
            <span class="pull-right">
                <?= Html::a('<i class="fa fa-save"></i> 更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<i class="glyphicon glyphicon-th-list"></i> 段落', ['article-section/edit', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                <?= Html::a('<i class="fa fa-comments"></i> 评论', ['comment/index', 'CommentSearch[model_name]' => 'article','CommentSearch[model_id]' => $model->id], ['class' => 'btn btn-warning']) ?>
                <?= Html::a('<i class="glyphicon glyphicon-trash"></i> 删除', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-default',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </span>
        </div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped table-bordered table-hover detail-view'],
                'template' => '<tr><th width="200">{label}</th><td>{value}</td></tr>',
                'attributes' => [
                    'id',
                    'title',
                    [
                        'attribute'=>'category_id',
                        'value'=>$model->getArticleCategoryValues(),
                    ],
                    'content:raw',
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
        <div class="box-footer"></div>
    </div>
</div>
<?php $this->registerJsFile('@web/plug-in/ueditor/third-party/SyntaxHighlighter/shCore.js',['position' => \yii\web\View::POS_HEAD]);?>
<?php $this->registerCssFile('@web/plug-in/ueditor/third-party/SyntaxHighlighter/shCoreDefault.css',['position' => \yii\web\View::POS_HEAD]);?>
<script type="text/javascript">
    SyntaxHighlighter.all();
</script>
