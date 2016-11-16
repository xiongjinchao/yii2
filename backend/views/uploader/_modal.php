<?php
use yii\helpers\Html;

dmstr\web\AdminLteAsset::register($this);

?>
<div class="uploader-modal">
    <div class="nav-tabs-custom" style="box-shadow:none">
        <ul class="nav nav-tabs pull-right">
            <li>
                <a href="#remote-picture" data-toggle="tab">远程图片</a>
            </li>
            <li>
                <a href="#select-picture" data-toggle="tab">选择图片</a>
            </li>
            <li class="active">
                <a href="#upload-picture" data-toggle="tab">上传图片</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="upload-picture">

                <div class="text-center uploader_content"><?= Html::button('<i class="fa fa-image"></i> 选择图片', ['class' => 'btn btn-info file-picker']) ?></div>
                <div class="uploader" style="display:none">
                    <label class="control-label"><div id="file-picker"><i class="fa fa-image"></i> 选择图片</div></label>
                </div>
                <div class="uploader-list">
                </div>

            </div>
            <div class="tab-pane" id="select-picture">
                <div class="picture-list">
                    <div class="row">
                    <?php foreach($dataProvider->models as $key=>$model){?>
                        <p class="col-md-3 picture-wrapper">
                            <img class="img-responsive img-thumbnail" src="http://<?=Yii::$app->params['domain']['image'].$model->path;?>" data-picture_id="<?=$model->id?>">
                            <i class="picture_choose_icon glyphicon glyphicon-ok-sign text-success" ></i>
                        </p>
                        <?php if(($key+1)%4 == 0){?>
                            </div><div class="row">
                        <?php }?>
                    <?php }?>
                    </div>
                </div>
                <div class="text-center" style="font-size:80%;">
                    <?=\yii\widgets\LinkPager::widget([
                        'pagination'=>$dataProvider->pagination
                    ]);?>
                </div>
            </div>
            <div class="tab-pane" id="remote-picture">
                <div class="form-group field-remote-picture">
                    <label class="control-label" for="upload-remote-picture">远程地址</label>
                    <?= Html::Input('text','remote-picture','',['class' => 'form-control','placeholder' => 'http://']); ?>
                    <div class="help-block"></div>
                </div>
            </div>
        </div>
    </div>
    <input id="max" type="hidden" name="max" value="<?=$max?>">
</div>

<?php $this->registerCssFile('@web/plug-in/webuploader/webuploader.css');?>
<?php $this->registerCssFile('@web/plug-in/webuploader/style/modal.css');?>
<?php $this->registerJsFile('@web/plug-in/webuploader/webuploader.js',['position' => \yii\web\View::POS_END]);?>

<script>
    <?php $this->beginBlock('js') ?>
    $(function(){
        //选择图片库中的图片
        $("#select-picture").on('click', ".picture-wrapper", function(){
            var max = $("#max").val();
            if($(this).find("i:visible").length == 1){
                $(this).find("i").hide();
            }else if($("#select-picture").find("i:visible").length < max) {
                $(this).find("i").show();
            }else{
                alert("最多只能选择"+max+"张图片");
            }
        });
        //分页
        $("#select-picture").on('click', ".pagination a", function(e){
            e.preventDefault();
            $("#select-picture").load($(this).attr("href")+" #select-picture");
        });

        //WebUpload
        var $list = $('.uploader-list'),
            ratio = window.devicePixelRatio || 1,
            thumbnailWidth = 100 * ratio,
            thumbnailHeight = 100 * ratio,
            uploader;

        uploader = WebUploader.create({
            auto: true,
            swf: '<?='@web/plug-in/webuploader/';?>Uploader.swf',
            server: '<?= Yii::$app->urlManager->createUrl(['uploader/upload','category'=>$category]);?>',
            pick: '#file-picker',
            fileNumLimit: '<?=$max;?>',
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
                //$li.append('<input type="text" class="picture_title form-control" name="Picture['+key+'][picture_title]" placeholder="标题" value="">');
                $li.append('<input type="hidden" class="picture_id" name="Picture['+key+'][id]" value="0">');
                $li.append('<input type="hidden" class="picture_id" name="Picture['+key+'][picture_id]" value="'+response.picture_id+'">');
                $li.append('<input type="hidden" class="sort" name="Picture['+key+'][sort]" value="0">');
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

        $("#upload-picture").on("click",".file-picker",function(){
            $("#file-picker").trigger("click");
        });

        //删除图片
        $(".uploader-list").on("click",".cancel",function(){
            var picture_id = $(this).parents('.file-item').find('.picture_id').val();
            var uploader_list = $(this).parents('.uploader-list');
            if(picture_id>0){
                $.post('<?= Yii::$app->urlManager->createUrl(['content/recommendation-picture/delete']);?>', { id:picture_id });
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
    <?php $this->endBlock('js') ?>
</script>
<?php $this->registerJs($this->blocks['js'],\yii\web\View::POS_END);