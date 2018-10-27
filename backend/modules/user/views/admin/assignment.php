<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $admin->username;
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-user-secret"></i> 员工管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $admin->username;
?>
<div class="assignment-role">

    <?=Html::beginForm(['assignment','id'=>$admin->id])?>
    <div class="list-view">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title pull-left">授权</h3>
                <span class="pull-right">
                    <div class="summary">第<b>1-<?=$dataProvider->totalCount?></b>条，共<b><?=$dataProvider->totalCount?></b>条数据.</div>
                </span>
            </div>

            <div class="box-body">
                <div class="content">
                    <div class="role_list row">
                    <?php foreach($dataProvider->models as $key=>$model){?>
                        <div class="role_item col-md-2">
                            <h4 class="role_title">
                                <input type="checkbox" name="roles[]" value="<?=$model['name']?>" <?php echo isset($roles[$model['name']])?'checked':''; ?>/>
                                <?=$model['name'];?>
                            </h4>
                            <?php foreach($auth->getChildren($model['name']) as $item){?>
                                <div><?php echo $item->type == \yii\rbac\Item::TYPE_ROLE?'[角色]':'[权限]';?><?php echo $item->description; ?></div>
                            <?php }?>
                        </div>
                        <?php if(($key+1)%6==0 && ($key+1)<$dataProvider->totalCount){?>
                            </div><div class="role_list row">
                        <?php }?>
                    <?php }?>
                </div>
            </div>
            <div class="box-footer">
                <?= Html::submitButton('<i class="fa fa-save"></i> 保存', ['class'=>'btn btn-primary']) ?>
            </div>
        </div>

    </div>
    <?=Html::endForm();?>

</div>

