<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '评论管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="fa fa-plus-circle"></i> 创建评论', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '<div class="box box-primary">
            <div class="box-header with-border"><h3 class="box-title pull-left">'.$this->title.'</h3><span class=pull-right>{summary}</span></div>
            <div class="box-body">{items}</div>
            <div class="box-footer">{pager}</div>
            </div>',
        'tableOptions' => ['class'=>'table table-striped table-bordered table-hover'],
        'afterRow' => function($model){
            if(isset($model->comments)&&$model->comments!=null){
                $comments = '';
                foreach($model->comments as $comment){
                    $class = $comment->audit == 1?'glyphicon glyphicon-ok':'glyphicon glyphicon-remove';
                    $comments.='<tr><td class="warning">&nbsp;</td><td>'.$comment->id.'</td><td>'.$comment->parent_id.'</td><td>'.$comment->user_id.'</td><td>'.$comment->model_name.'</td><td>'.$comment->model_id.'</td><td>'.date("Y-m-d H:i:s",$comment->created_at).'</td><td>'.date("Y-m-d H:i:s",$comment->updated_at).'</td><td><a title="审核" href="/index.php?r=content%2Fcomment%2Faudit&amp;id='.$comment->id.'"><span class="'.$class.'"></span></a></td><td><a data-pjax="0" aria-label="查看" title="查看" href="/index.php?r=content%2Fcomment%2Fview&amp;id='.$comment->id.'"><span class="glyphicon glyphicon-eye-open"></span></a> <a data-pjax="0" aria-label="更新" title="更新" href="/index.php?r=content%2Fcomment%2Fupdate&amp;id='.$comment->id.'"><span class="glyphicon glyphicon-pencil"></span></a> <a data-pjax="0" data-method="post" data-confirm="您确定要删除此项吗？" aria-label="删除" title="删除" href="/index.php?r=content%2Fcomment%2Fdelete&amp;id='.$comment->id.'"><span class="glyphicon glyphicon-trash"></span></a></td></tr>';
                }
                return $comments;
            }
        },
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'id',
                'headerOptions'=>['style'=>'width:10%'],
            ],
            [
                'attribute'=>'parent_id',
                'headerOptions'=>['style'=>'width:10%'],
            ],
            [
                'attribute'=>'user_id',
                'headerOptions'=>['style'=>'width:10%'],
            ],
            [
                'attribute'=>'model_name',
                'filter'=>false
            ],
            [
                'attribute'=>'model_id',
                'filter'=>false
            ],
            //'parent_id',
            //'user_id',
            //'model_name',
            //'model_id',
            // 'content:ntext',
            [
                'attribute'=>'created_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
                'filter'=>false
            ],
            [
                'attribute'=>'updated_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
                'filter'=>false
            ],
            [
                'label'=>'审核',
                'attribute'=>'audit',
                'format'=>'raw',
                'value'=>function($model){
                    return Html::a($model->audit == 1?'<span class="glyphicon glyphicon-ok"></span>':'<span class="glyphicon glyphicon-remove"></span>', ['audit','id'=>$model->id], ['title' => '审核']) ;
                },
                'headerOptions'=>['style'=>'width:5%']
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
