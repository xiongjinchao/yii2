<?php

namespace common\helpers;

use Yii;
use yii\base\Exception;
use yii\web\UploadedFile;
use backend\models\Picture;

class UploadHelper
{
    /**
     * @param null $model
     * @param null $attribute
     * @param null $name
     * @param string $category
     * @return Picture
     * @throws \yii\base\Exception
     */
    public static function upload($model = null, $attribute = null, $name = null, $category = 'images')
    {
        if($model && $attribute){
            $image = UploadedFile::getInstance($model, $attribute);
        }else if($name!=null){
            $image = UploadedFile::getInstanceByName($name);
        }else{
            throw new Exception('参数错误');
        }
        if(!$image){
            throw new Exception('未选择图片');
        }
        try{
            $image->name = time().rand(100000,999999).'.'.$image->getExtension();
            $path = $category!=null?'/'.$category:'';
            $path.='/'.date('Y').'/'.date('m').'/'.date('d');
            if(!is_dir(Yii::$app->params['uploads'].$path)){
                $mask = umask(0);
                mkdir(Yii::$app->params['uploads'].$path,0777,true);
                umask($mask);
            }
            $path.='/'.$image->name;
            if($image->saveAs(Yii::$app->params['uploads'].$path,true)){
                $info = getimagesize(Yii::$app->params['uploads'].$path);
                $url = 'http://'.Yii::$app->params['domain']['image'].$path;

                $picture = new Picture;
                $picture->name = $image->name;
                $picture->category = $category;
                $picture->url = $url;
                $picture->width = $info['0'];
                $picture->height = $info['1'];
                $picture->ratio = sprintf("%.2f",$info['0']/$info['1']);
                $picture->path = $path;
                $picture->type = $image->type;
                $picture->file_size = $image->size;
                $picture->status = Picture::STATUS_DISABLE;
                $picture->source = Picture::SOURCE_BACKEND;
                $picture->user_id = Yii::$app->user->id;
                $picture->created_at = time();
                $picture->save();
                return $picture;
            }
        }catch (Exception $e){
            throw new Exception('上传失败');
        }
    }
}