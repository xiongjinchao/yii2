<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $role->name;
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-anchor"></i> 角色管理', 'url' => ['index']];
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
                <div class="content">
                    <div class="role_list row">
                    <?php foreach($dataProvider->models as $key=>$model){?>
                        <div class="role_item col-md-2">
                            <h4 class="role_title">
                                <input type="checkbox" name="roles[]" value="<?=$model['name']?>"/>
                                <?=$model['description'];?>
                            </h4>
                            <?php foreach($auth->getChildren($model['name']) as $item){?>
                                <div>
                                    <input type="checkbox" class="checkbox_permission" name="permissions[]" value="<?php echo $item->name; ?>" <?php echo $auth->hasChild($role,$auth->getPermission($item->name))?'checked':''; ?> />
                                    <?php echo $item->description; ?>
                                </div>
                            <?php }?>
                        </div>
                        <?php if(($key+1)%6==0 && ($key+1)<$dataProvider->totalCount){?>
                            </div><div class="role_list row">
                        <?php }?>
                    <?php }?>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <?= Html::submitButton('<i class="fa fa-save"></i> 保存', ['class'=>'btn btn-primary']) ?>
            </div>

        </div>

    </div>
    <?=Html::endForm();?>

</div>

<!--iCheck js and css-->
<?php Yii::$app->assetManager->publish('@vendor/almasaeed2010/adminlte/plugins/iCheck');?>
<?php $url = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/plugins/iCheck');?>
<?php $this->registerJsFile($url.'/icheck.min.js',['depends'=>['backend\assets\AppAsset'],'position' => \yii\web\View::POS_HEAD]);?>
<?php $this->registerCssFile($url.'/all.css',['depends'=>['backend\assets\AppAsset'],'position' => \yii\web\View::POS_HEAD]);?>
<script>
    $('input').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue',
        increaseArea: '0%' /* optional */
    });
</script>
