<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RecommendationContent */

$this->title = '更新推荐';
$this->params['breadcrumbs'][] = ['label' => '推荐内容', 'url' => ['recommendation-content/index', 'category_id' => $category->id]];
$this->params['breadcrumbs'][] = ['label' => $content->title, 'url' =>['recommendation-content/update', 'category_id' => $content->id]];
$this->params['breadcrumbs'][] = ['label' => '图片', 'url' => ['edit', 'id' => $content->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="recommendation-content-update">

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
            <li class="active">
                <?=Html::a('推荐图片',['recommendation-picture/edit', 'id' => $content->id])?>
            </li>
            <li>
                <?=Html::a('推荐详情',['recommendation-content/update', 'id' => $content->id])?>
            </li>
            <li>
                <?=Html::a('推荐内容',['recommendation-content/index', 'category_id' => $category->id])?>
            </li>
            <li>
                <?=Html::a('基本信息',['recommendation-category/update', 'id' => $category->id])?>
            </li>
            <li>
                <?=Html::a('推荐分类',['recommendation-category/index'])?>
            </li>
            <li class="pull-left header">
                <?php echo $content->title; ?>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="recommendation-picture-form">
                    <?php $form = ActiveForm::begin(); ?>

                    <div class="form-group">
                        <label for="section_content" class="control-label"></label>
                        <div class="uploader">
                            <label class="control-label">
                                <?= Html::button('<i class="fa fa-image"></i> 选择图片', ['class' => 'btn btn-info file-picker']) ?>
                            </label>
                            <div class="uploader-list">
                                <?php
                                if($picture!=null){
                                    foreach($picture as $k=>$item){
                                        echo'<div class="file-item thumbnail upload-state-done">';
                                        echo'<div class="img-thumb"><img src="'.$item->picture->url.'"></div>';
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

                    <div class="form-group">
                        <label for="section_content" class="control-label"></label>
                        <?= Html::submitButton('<i class="fa fa-save"></i> 更新', ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class="fa fa-undo"></i> 返回', ['recommendation-content/update', 'id' => $content->id], ['class' => 'btn btn-default']) ?>
                        <div class="help-block"></div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>

</div>

<?php $this->registerCssFile('@web/plug-in/webuploader/webuploader.css');?>
<?php $this->registerCssFile('@web/plug-in/webuploader/style/simple.css');?>
<?php $this->registerJsFile('@web/plug-in/webuploader/webuploader.min.js',['position' => \yii\web\View::POS_END]);?>
<script>
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
            server: '<?= Yii::$app->urlManager->createUrl(['uploader/upload','category'=>'recommendation_picture']);?>',
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
                $.post('<?= Yii::$app->urlManager->createUrl(['content/recommendation-picture/delete']);?>', { id:recommendation_picture_id });
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
</script>
