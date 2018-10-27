<?php

use yii\helpers\Html;
use common\models\ArticleSection;
use common\models\ArticleSectionPicture;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

$this->title = '文章段落';
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-file-text"></i> 文章管理', 'url' => ['article/index']];
$this->params['breadcrumbs'][] = ['label' => $article->title, 'url' => ['article/update', 'id' => $article->id]];
$this->params['breadcrumbs'][] = '更新';

?>
<div class="article-section-edit">
    <div class="row">
        <div class="col-lg-6 col-xs-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    <li>
                        <?=Html::a('文章评论',['comment/index', 'CommentSearch[model_name]' => 'article','CommentSearch[model_id]' => $article->id])?>
                    </li>
                    <li class="active">
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

                        <div class="article-section-form">
                            <?php $form = ActiveForm::begin(); ?>
                            <div class="section_group">
                            <?php if($dataProvider->models != null){?>
                                <?php foreach($dataProvider->models as $key=>$model){?>
                                    <div class="article_section">

                                        <div class="form-group field-section-title">
                                            <label for="section_title" class="control-label">段落标题</label>
                                            <input type="text" maxlength="200" value="<?=$model->section_title;?>" name="ArticleSection[<?=$key;?>][section_title]" class="form-control section_title">
                                            <input type="hidden" maxlength="200" value="<?=$model->id;?>" name="ArticleSection[<?=$key;?>][id]" class="form-control section_id">
                                            <div class="help-block"></div>
                                        </div>

                                        <div class="form-group required field-section-content">
                                            <label for="section_content" class="control-label">段落内容</label>
                                            <textarea class="form-control section_content" rows="6" name="ArticleSection[<?=$key;?>][section_content]"><?=$model->section_content;?></textarea>
                                            <div class="help-block"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="section_content" class="control-label"></label>
                                            <div class="uploader">
                                                <label class="control-label">
                                                    <?= Html::button('<i class="fa fa-image"></i> 选择图片', ['class' => 'btn btn-info file-picker']) ?>
                                                </label>
                                                <div class="uploader-list">
                                                    <?php
                                                    $pictures = ArticleSectionPicture::find()->where(['section_id'=>$model->id])->orderBy(['sort'=>SORT_DESC])->all();
                                                    if($pictures!=null){
                                                        foreach($pictures as $k=>$picture){
                                                            echo'<div class="file-item thumbnail upload-state-done">';
                                                            echo'<div class="img-thumb"><img src="http://'.Yii::$app->params['domain']['image'].$picture->picture->path.'"></div>';
                                                            echo'<div class="info"><span class="cancel"></span></div>';
                                                            echo'<input type="hidden" class="section_picture_id" value="'.$picture->id.'" name="ArticleSection['.$key.'][ArticleSectionPicture]['.$k.'][id]">';
                                                            echo'<input type="text" class="picture_title form-control" value="'.$picture->picture_title.'" placeholder="标题" name="ArticleSection['.$key.'][ArticleSectionPicture]['.$k.'][picture_title]">';
                                                            echo'<input type="hidden" class="picture_id" value="'.$picture->picture_id.'" name="ArticleSection['.$key.'][ArticleSectionPicture]['.$k.'][picture_id]">';
                                                            echo'<input type="hidden" class="sort" value="'.$picture->sort.'" name="ArticleSection['.$key.'][ArticleSectionPicture]['.$k.'][sort]">';
                                                            echo'</div>';
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="help-block"></div>
                                        </div>


                                        <div class="form-group text-right">
                                            <label for="section_content" class="control-label"></label>
                                            <?= Html::button('<i class="fa fa-plus-circle"></i> 添加一段', ['class' => 'btn btn-success add_section']) ?>
                                            <?= Html::button('<i class="fa fa-trash"></i> 删除该段', ['class' => 'btn btn-default delete_section']) ?>
                                            <div class="help-block"></div>
                                        </div>

                                    </div>
                                <?php }?>
                            <?php }else{?>
                                <?php $model = new ArticleSection;?>
                                <div class="article_section">

                                    <div class="form-group field-section-title">
                                        <label for="section_title" class="control-label">段落标题</label>
                                        <input type="text" maxlength="200" value="" name="ArticleSection[0][section_title]" class="form-control section_title">
                                        <input type="hidden" maxlength="200" value="<?=$model->id;?>" name="ArticleSection[0][id]" class="form-control section_id">
                                        <div class="help-block"></div>
                                    </div>

                                    <div class="form-group required field-section-content">
                                        <label for="section_content" class="control-label">段落内容</label>
                                        <textarea class="form-control section_content" rows="6" name="ArticleSection[0][section_content]"></textarea>
                                        <div class="help-block"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="section_content" class="control-label"></label>
                                        <div class="uploader">
                                            <label class="control-label">
                                                <?= Html::button('<i class="fa fa-image"></i> 选择图片', ['class' => 'btn btn-info file-picker']) ?>
                                            </label>
                                            <div class="uploader-list"></div>
                                        </div>
                                        <div class="help-block"></div>
                                    </div>

                                    <div class="form-group text-right">
                                        <label for="section_content" class="control-label"></label>
                                        <?= Html::button('<i class="fa fa-plus-circle"></i> 添加一段', ['class' => 'btn btn-success add_section']) ?>
                                        <?= Html::button('<i class="fa fa-trash"></i> 删除该段', ['class' => 'btn btn-default delete_section']) ?>
                                        <div class="help-block"></div>
                                    </div>

                                </div>

                            <?php }?>
                            </div>

                            <div class="uploader" style="display:none">
                                <label class="control-label"><div id="file-picker"><i class="fa fa-image"></i> 选择图片</div></label>
                            </div>

                            <div class="form-group">
                                <label for="section_content" class="control-label"></label>
                                <?= Html::submitButton('<i class="fa fa-save"></i> 更新', ['class' => 'btn btn-primary']) ?>
                                <?= Html::a('<i class="fa fa-undo"></i> 返回', ['article/update','id'=>$_GET['id']], ['class' => 'btn btn-default']) ?>
                                <div class="help-block"></div>
                            </div>

                            <?php ActiveForm::end(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->registerCssFile('@web/plug-in/webuploader/webuploader.css',['depends'=>['backend\assets\AppAsset'],'position' => \yii\web\View::POS_HEAD]);?>
<?php $this->registerCssFile('@web/plug-in/webuploader/style/simple.css',['depends'=>['backend\assets\AppAsset'],'position' => \yii\web\View::POS_HEAD]);?>
<?php $this->registerJsFile('@web/plug-in/webuploader/webuploader.min.js',['depends'=>['backend\assets\AppAsset'],'position' => \yii\web\View::POS_END]);?>

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
                server: '<?= \yii\helpers\Url::to(['/uploader/upload','category'=>'article_section_picture']);?>',
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
                var number = $('.article_section').index($li.parents('.article_section'));
                var key = $li.parents('.uploader-list').find('.file-item').index($li);
                $li.addClass('upload-state-done');
                if(response.status == 'success'){
                    $li.append('<input type="text" class="picture_title form-control" name="ArticleSection['+number+'][ArticleSectionPicture]['+key+'][picture_title]" placeholder="标题" value="">');
                    $li.append('<input type="hidden" class="section_picture_id" name="ArticleSection['+number+'][ArticleSectionPicture]['+key+'][id]" value="0">');
                    $li.append('<input type="hidden" class="picture_id" name="ArticleSection['+number+'][ArticleSectionPicture]['+key+'][picture_id]" value="'+response.picture_id+'">');
                    $li.append('<input type="hidden" class="sort" name="ArticleSection['+number+'][ArticleSectionPicture]['+key+'][sort]" value="0">');
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
            $(".section_group").on("click",".file-picker",function(){
                var number = $(".file-picker").index($(this));
                $list = $(".uploader-list").eq(number);
                $("#file-picker").trigger("click");
            });

            //增加段落
            $(".section_group").on("click",".add_section",function(){
                var new_section = $("div.article_section:last").clone();
                var number = $("div.article_section").length;
                new_section.find(".uploader-list").empty();
                new_section.find('input,textarea,select').each(function(){
                    $(this).val('');
                    var new_name = $(this).attr('name').replace(/ArticleSection\[\d+\]/gi, 'ArticleSection['+number+']');
                    $(this).attr('name',new_name);
                });
                console.log(new_section);
                $(".section_group").append(new_section);

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

            //删除段落
            $(".section_group").on("click",".delete_section",function(){
                var section_id = $(this).parents('.article_section').find('.section_id').val();
                if(section_id>0){
                    $.post('<?= \yii\helpers\Url::to(['/content/article-section/delete']);?>', { id:section_id });
                }
                $(this).parents('.article_section').remove();
                $('.article_section').each(function( index, item ){
                    $(item).find('input,textarea,select').each(function(){
                        var name = $(this).attr('name').replace(/ArticleSection\[\d+\]/gi, 'ArticleSection['+index+']');
                        $(this).attr('name',name);
                    });
                });

                if($(".article_section").length == 0){
                    window.location.reload();
                }
            });

            //删除图片
            $(".section_group").on("click",".cancel",function(){
                var section_picture_id = $(this).parents('.file-item').find('.section_picture_id').val();
                var uploader_list = $(this).parents('.uploader-list');
                if(section_picture_id>0){
                    $.post('<?= \yii\helpers\Url::to(['/content/article-section/delete-picture']);?>', { id:section_picture_id });
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