<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $role->name;
$this->params['breadcrumbs'][] = ['label' => '角色管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $role->name;
?>
<div class="assignment-role">
    <p>
        <?= Html::a('<i class="fa fa-search"></i> 权限检索', ['auth-initialize','name'=>$role->name], ['class' => 'btn btn-success']) ?>
    </p>

    <?=Html::beginForm(['assignment','name'=>$_GET['name']])?>
    <div class="list-view">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title pull-left">权限列表</h3>
                <span class="pull-right">
                    <div class="summary">第<b>1-<?=$dataProvider->totalCount?></b>条，共<b><?=$dataProvider->totalCount?></b>条数据.</div>
                </span>
            </div>

            <div class="box-body">
                <div class="role_list row">
                <?php foreach($dataProvider->models as $key=>$model){?>
                    <div class="role_item col-md-4">
                        <h4 class="role_title">
                            <input type="checkbox" name="roles[]" value="<?=$model['name']?>"/>
                            <?=$model['name'];?>
                        </h4>
                        <?php foreach($auth->getChildren($model['name']) as $item){?>
                            <div>
                                <input type="checkbox" class="checkbox_permission" name="permissions[]" value="<?php echo $item->name; ?>" <?php echo $auth->hasChild($role,$auth->getPermission($item->name))?'checked':''; ?> />
                                <?php echo $item->name; ?>
                            </div>
                        <?php }?>
                    </div>
                    <?php if(($key+1)%3==0 && ($key+1)<$dataProvider->totalCount){?>
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

