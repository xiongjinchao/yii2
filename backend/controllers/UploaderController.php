<?php

namespace backend\controllers;

use Yii;
use yii\base\Exception;
use common\helpers\UploadHelper;

/**
 * UploaderController
 */
class UploaderController extends Controller
{
    public $enableCsrfValidation = false;

    //for WebUploader ajax, other upload method must be use UploadHelper::upload
    public function actionUpload($category = null)
    {
        try{
            $picture = UploadHelper::upload(null,null,'file',$category);
            $result = ['status'=>'success','picture_id'=>$picture->id,'message'=>'上传成功'];
        }catch (Exception $e){
            $result = ['status'=>'false','picture_id'=>'0','message'=>$e->getMessage()];
        }
        echo json_encode($result);
    }
}