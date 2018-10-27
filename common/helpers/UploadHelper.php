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
            $image->name = md5(time().rand(100000,999999)).'.'.$image->getExtension();
            $category =  $category=== null?'images':$category;
            $path = '/'.$category;
            $path.='/'.date('Y').'/'.date('m').'/'.date('d');
            if(!is_dir(Yii::getAlias('@uploads').$path)){
                $mask = umask(0);
                mkdir(Yii::getAlias('@uploads').$path,0777,true);
                umask($mask);
            }
            $path.='/'.$image->name;
            if($image->saveAs(Yii::getAlias('@uploads').$path,true)){
                $info = getimagesize(Yii::getAlias('@uploads').$path);

                $picture = new Picture;
                $picture->loadDefaultValues();
                $picture->name = $image->name;
                $picture->category = $category;
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
                if(!$picture->save()){
                    throw new Exception(current($picture->getErrors()));
                }
                return $picture;
            }
        }catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param $url //the remote picture url
     * @param $category
     * @return Picture
     * @throws \yii\base\Exception
     */
    public static function remote($url, $category = 'images')
    {
        $preg = "/^(https?:\/\/)?(((www\.)?[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)?\.([a-zA-Z]+))|(([0-1]?[0-9]?[0-9]|2[0-5][0-5])\.([0-1]?[0-9]?[0-9]|2[0-5][0-5])\.([0-1]?[0-9]?[0-9]|2[0-5][0-5])\.([0-1]?[0-9]?[0-9]|2[0-5][0-5]))(\:\d{0,4})?)(\/[\w- .\/?%&=]*)?$/i";
        if(!preg_match($preg, $url)){
            throw new Exception('非法的远程地址');
        }
        $header = get_headers($url, 1);
        if(strripos($header['Content-Type'], "image") === false){
            throw new Exception('非法的图片地址');
        }
        try{
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            curl_close($ch);

            $name = md5(time().rand(100000,999999)).'.'.strtolower(pathinfo($url,PATHINFO_EXTENSION));
            $category =  $category=== null?'images':$category;
            $path = '/'.$category;
            $path.='/'.date('Y').'/'.date('m').'/'.date('d');
            if(!is_dir(Yii::getAlias('@uploads').$path)){
                $mask = umask(0);
                mkdir(Yii::getAlias('@uploads').$path,0777,true);
                umask($mask);
            }
            $path.='/'.$name;

            $handle = fopen(Yii::getAlias('@uploads').$path, 'w');
            if(fwrite($handle, $result)!=false) {

                $info = getimagesize(Yii::getAlias('@uploads') . $path);

                $picture = new Picture;
                $picture->loadDefaultValues();
                $picture->name = $name;
                $picture->category = $category;
                $picture->width = $info['0'];
                $picture->height = $info['1'];
                $picture->ratio = sprintf("%.2f", $info['0'] / $info['1']);
                $picture->path = $path;
                $picture->type = $header['Content-Type'];
                $picture->file_size = filesize(Yii::getAlias('@uploads') . $path);
                $picture->status = Picture::STATUS_DISABLE;
                $picture->source = Picture::SOURCE_BACKEND;
                $picture->user_id = Yii::$app->user->id;
                $picture->created_at = time();
                if(!$picture->save()){
                    throw new Exception(current($picture->getErrors()));
                }
                return $picture;
            }
            fclose($handle);
        }catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}