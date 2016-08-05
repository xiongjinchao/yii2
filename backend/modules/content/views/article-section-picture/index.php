<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章图片';
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['article/index']];
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
                    //'filterModel' => $searchModel,
                    'layout' => '<div class="box box-primary">
                        <div class="box-header with-border"><h3 class="box-title pull-left">'.$this->title.'</h3><span class=pull-right>{summary}</span></div>
                        <div class="box-body">{items}</div>
                        <div class="box-footer">{pager}</div>
                        </div>',
                    'tableOptions' => ['class'=>'table table-striped table-bordered table-hover'],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute'=>'id',
                            'headerOptions'=>['style'=>'width:80px'],
                        ],
                        [
                            'attribute'=>'picture_id',
                            'value'=>function($model){
                                if(isset($model->picture)){
                                    return Html::img($model->picture->url,['height'=>'50']);
                                }
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
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
            </div>
        </div>
    </div>

</div>
