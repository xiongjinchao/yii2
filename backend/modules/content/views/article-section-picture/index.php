<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章图片';
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-file-text"></i> 文章管理', 'url' => ['article/index']];
$this->params['breadcrumbs'][] = ['label' => $article->title, 'url' => ['article/update', 'id' => $article->id]];
$this->params['breadcrumbs'][] = '更新';
?>

<div class="article-section-picture-index">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
            <li>
                <?=Html::a('文章评论',['comment/index', 'CommentSearch[model_name]' => 'article','CommentSearch[model_id]' => $article->id])?>
            </li>
            <li class="active">
                <?=Html::a('文章图片',['article-section-picture/index', 'id' => $article->id])?>
            </li>
            <li>
                <?=Html::a('文章段落',['article-section/edit', 'id' => $article->id])?>
            </li>
            <li>
                <?=Html::a('基本信息',['article/update', 'id' => $article->id])?>
            </li>
            <li class="pull-left header">
                <?php echo $article->title; ?>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class'=>'table table-striped table-bordered table-hover'],
                    'export' => false,
                    //'pjax'=>true,
                    'columns' => [
                        ['class' => '\kartik\grid\SerialColumn'],
                        [
                            'class' => '\kartik\grid\RadioColumn'
                        ],
                        [
                            'attribute'=>'id',
                            'headerOptions'=>['style'=>'width:80px'],
                        ],
                        [
                            'attribute'=>'picture_id',
                            'value'=>function($model){
                                return isset($model->picture)?Html::img('http://'.Yii::$app->params['domain']['image'].$model->picture->path,['class'=>'img-responsive img-thumbnail','width'=>'60','height'=>'60']):'';
                            },
                            'format'=>'raw',
                        ],
                        'picture_title',
                        [
                            'attribute'=>'article_id',
                            'value'=>function($model){
                                if(isset($model->article)){
                                    return $model->article->title;
                                }
                            },
                        ],
                        [
                            'attribute'=>'section_id',
                            'value'=>function($model){
                                if(isset($model->section)){
                                    return $model->section->section_title;
                                }
                            },
                        ],
                        'sort',
                        ['class' => '\kartik\grid\ActionColumn'],
                    ],
                ]); ?>
            </div>
        </div>
    </div>

</div>
