<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\bootstrap\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\content\models\Article */

$this->title = '更新文章: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';

?>

<div class="article-update">
	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs pull-right">
			<li>
				<?=Html::a('文章评论',['comment/index', 'CommentSearch[model_name]' => 'article','CommentSearch[model_id]' => $model->id])?>
			</li>
			<li>
				<?=Html::a('文章图片',['article-section-picture/index', 'id' => $model->id])?>
			</li>
			<li>
				<?=Html::a('文章段落',['article-section/edit', 'id' => $model->id])?>
			</li>
			<li class="active">
				<?=Html::a('基本信息',['article/update', 'id' => $model->id])?>
			</li>
			<li class="pull-left header">
				<?php echo $this->title; ?>
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

