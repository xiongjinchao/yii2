<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\RecommendationCategory;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\RecommendationContent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recommendation-content-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
        'data' => RecommendationCategory::getRecommendationCategoryOptions(),
        'options' => ['prompt' => '请选择'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6, 'maxlength' => true]) ?>

    <div class="form-group">
        <label for="section_content" class="control-label">推荐图片</label>
        <div class="uploader">
            <label class="control-label">
                <?= Html::button('<i class="fa fa-image"></i> 选择图片', ['class' => 'btn btn-info file-picker']) ?>
            </label>
            <div class="uploader-list">
                <?php
                if($picture!=null){
                    foreach($picture as $k=>$item){
                        echo'<div class="file-item thumbnail upload-state-done">';
                        echo'<div class="img-thumb"><img src="http://'.Yii::$app->params['domain']['image'].$item->picture->path.'"></div>';
                        echo'<div class="info"><span class="cancel"></span></div>';
                        echo'<input type="hidden" class="recommendation_picture_id" value="'.$item->id.'" name="RecommendationPicture['.$k.'][id]">';
                        echo'<input type="text" class="picture_title form-control" value="'.$item->picture_title.'" placeholder="标题" name="RecommendationPicture['.$k.'][picture_title]">';
                        echo'<input type="hidden" class="picture_id" value="'.$item->picture_id.'" name="RecommendationPicture['.$k.'][picture_id]">';
                        echo'<input type="hidden" class="sort" value="'.$item->sort.'" name="RecommendationPicture['.$k.'][sort]">';
                        echo'</div>';
                    }
                }
                ?>
            </div>
        </div>
        <div class="help-block"></div>
    </div>

    <div class="uploader" style="display:none">
        <label class="control-label"><div id="file-picker"><i class="fa fa-image"></i> 选择图片</div></label>
    </div>

    <?= $form->field($model, 'code')->textarea(['rows' => 6, 'maxlength' => true]) ?>

    <?= $form->field($model, 'audit')->radioList($model->getAuditOptions());?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> 创建' : '<i class="fa fa-save"></i> 更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->registerCssFile('@web/plug-in/webuploader/webuploader.css',['depends'=>['backend\assets\AppAsset'],'position' => \yii\web\View::POS_HEAD]);?>
<?php $this->registerCssFile('@web/plug-in/webuploader/style/simple.css',['depends'=>['backend\assets\AppAsset'],'position' => \yii\web\View::POS_HEAD]);?>
<?php $this->registerJsFile('@web/plug-in/webuploader/webuploader.min.js',['depends'=>['backend\assets\AppAsset'],'position' => \yii\web\View::POS_HEAD]);?>

    <script>
        <?php $this->beginBlock('js') ?>
        $(function() {
            //批量上传插件
            var $list = $('.uploader-list'),
                ratio = window.devicePixelRatio || 1,
                thumbnailWidth = 100 * ratio,
                thumbnailHeight = 100 * ratio,
                uploader;

            uploader = WebUploader.create({
                auto: true,
                swf: '<?= '@web/plug-in/webuploader/';?>Uploader.swf',
                server: '<?= \yii\helpers\Url::to(['/uploader/upload','category'=>'recommendation_picture']);?>',
                pick: '#file-picker',
                //fileNumLimit: 3,
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                }
            });

            uploader.on( 'fileQueued', function( file ) {
                var $li = $('<div id="' + file.id + '" class="file-item thumbnail"><div class="img-thumb">' +'<img>' + '</div></div>'),
                    $img = $li.find('img');
                $list.append( $li );
                var $cancel = $('<div class="info">'+'<span class="cancel">'+'</span>'+'</div>').appendTo( $li );
                uploader.makeThumb( file, function( error, src ) {
                    if ( error ) {
                        $img.replaceWith('<span>不能预览</span>');
                        return;
                    }
                    $img.attr( 'src', src );
                }, thumbnailWidth, thumbnailHeight );
                $cancel.on( 'click', 'span', function() {
                    uploader.removeFile( file,true);
                    //$li.off().find('.info').off().end().remove();
                })
            });

            uploader.on( 'uploadProgress', function( file, percentage ) {
                var $li = $( '#'+file.id ),
                    $percent = $li.find('.progress span');
                if ( !$percent.length ) {
                    $percent = $('<p class="progress"><span></span></p>').appendTo( $li ).find('span');
                }
                $percent.css( 'width', percentage * 100 + '%' );
            });

            uploader.on( 'uploadSuccess', function( file, response ) {
                var $li = $( '#'+file.id );
                var key = $li.parents('.uploader-list').find('.file-item').index($li);
                $li.addClass('upload-state-done');
                if(response.status == 'success'){
                    $li.append('<input type="text" class="picture_title form-control" name="RecommendationPicture['+key+'][picture_title]" placeholder="标题" value="">');
                    $li.append('<input type="hidden" class="recommendation_picture_id" name="RecommendationPicture['+key+'][id]" value="0">');
                    $li.append('<input type="hidden" class="picture_id" name="RecommendationPicture['+key+'][picture_id]" value="'+response.picture_id+'">');
                    $li.append('<input type="hidden" class="sort" name="RecommendationPicture['+key+'][sort]" value="0">');
                }
            });

            uploader.on( 'uploadError', function( file ) {
                var $li = $( '#'+file.id ),
                    $error = $li.find('div.error');
                if ( !$error.length ) {
                    $error = $('<div class="error"></div>').appendTo( $li );
                }
                $error.text('上传失败');
            });

            uploader.on( 'uploadComplete', function( file ) {
                var $li = $( '#'+file.id );
                $li.find('.progress').remove();
                var length = $li.parents('.uploader-list').find('.file-item').length;
                $li.parents('.uploader-list').find('.file-item').each(function( index, item ){
                    $(item).find('.sort').val(length-index);
                });
            });

            //确定图片列表
            $(".form-group").on("click",".file-picker",function(){
                var number = $(".file-picker").index($(this));
                $list = $(".uploader-list").eq(number);
                $("#file-picker").trigger("click");
            });

            //删除图片
            $(".form-group").on("click",".cancel",function(){
                var recommendation_picture_id = $(this).parents('.file-item').find('.recommendation_picture_id').val();
                var uploader_list = $(this).parents('.uploader-list');
                if(recommendation_picture_id>0){
                    $.post('<?= \yii\helpers\Url::to(['/content/recommendation-content/delete-picture']);?>', { id:recommendation_picture_id });
                }
                $(this).parents('.file-item').remove();
                var length = uploader_list.find('.file-item').length;
                uploader_list.find('.file-item').each(function( index, item ){
                    $(item).find('.sort').val(length-index);
                });
            });

            //排序
            $(".uploader-list").sortable({
                cursor: "move",
                items :"div.file-item",
                opacity: 0.6,
                revert: true,
                stop:function(event,ui){
                    var length = ui.item.parents(".uploader-list").find(".file-item").length;
                    ui.item.parents(".uploader-list").find(".file-item").each(function(index,item){
                        $(item).find(".sort").val(length-index);
                    })
                }
            });

        });
        <?php $this->endBlock(); ?>
    </script>
<?php $this->registerJs($this->blocks['js'],\yii\web\View::POS_END);
