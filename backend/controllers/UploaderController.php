<?php

namespace backend\controllers;

use Yii;
use yii\base\Exception;
use common\helpers\UploadHelper;
use backend\models\Picture;
use yii\data\ActiveDataProvider;

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

    //uploader modal view for jquery load
    public function actionModal($category = null, $max = 1)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Picture::find()->where(['user_id'=>Yii::$app->user->id])->orderBy(['id'=>SORT_DESC]),
            'pagination' => ['pageSize' => 12],
        ]);
        return $this->renderAjax('_modal', [
            'dataProvider' => $dataProvider,
            'category' => $category,
            'max' => $max
        ]);
    }

    //update a picture from a remote picture url
    public function actionRemote()
    {
        $url = Yii::$app->request->post('remote_url');
        $category = Yii::$app->request->post('category');

        try{
            $picture = UploadHelper::remote($url,$category);
            $result = ['status'=>'success','picture_id'=>$picture->id,'url'=>'http://'.Yii::$app->params['domain']['image'].$picture->path,'message'=>'上传成功'];
        }catch (Exception $e){
            $result = ['status'=>'false','picture_id'=>'0','url'=>$url,'message'=>$e->getMessage()];
        }
        echo json_encode($result);
    }
}