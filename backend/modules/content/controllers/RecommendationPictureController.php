<?php

namespace backend\modules\content\controllers;

use Yii;
use backend\models\Picture;
use common\models\RecommendationPicture;
use common\models\RecommendationCategory;
use common\models\RecommendationContent;
use yii\web\NotFoundHttpException;
use backend\controllers\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\base\Exception;

/**
 * RecommendationPictureController implements the CRUD actions for RecommendationPicture model.
 */
class RecommendationPictureController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge([
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ],parent::behaviors());
    }

    /**
     * Lists all RecommendationPicture models.
     * @return mixed
     */
    public function actionEdit($id)
    {
        $picture = RecommendationPicture::find()->where(['content_id'=>$id])->orderBy(['id'=>SORT_ASC])->all();
        $content = RecommendationContent::findOne($id);
        $category = RecommendationCategory::findOne($content->category_id);

        if (Yii::$app->request->post()) {
            $transaction = Yii::$app->db->beginTransaction();
            try{
                foreach($_POST['RecommendationPicture'] as $item){
                    $model = $item['id']>0?RecommendationPicture::findOne($item['id']):new RecommendationPicture;
                    $model->content_id = $id;
                    $model->category_id = $content->category_id;
                    $model->picture_id = $item['picture_id'];
                    $model->picture_title = $item['picture_title'];
                    $model->sort = $item['sort'];
                    $model->save();
                }
                $transaction->commit();
                Yii::$app->session->setFlash('info','推荐图片编辑成功！');
            }catch(Exception $e) {
                $transaction->rollback();
                Yii::$app->session->setFlash('danger','推荐图片编辑失败！');
            }
            return $this->redirect(['edit','id'=>$id]);
        }

        return $this->render('edit', [
            'category' => $category,
            'content' => $content,
            'picture' => $picture,
        ]);
    }

    /**
     * Deletes an existing ArticleSection model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        if(Yii::$app->request->isAjax) {
            try {
                $model = $this->findModel(Yii::$app->request->post('id'));
                $picture = Picture::findOne($model->picture_id);
                $picture->status = Picture::STATUS_DISABLE;
                $picture->save();
                $model->delete();
            }catch(Exception $e){
                return false;
            }
        }
    }

    /**
     * Finds the ArticleSection model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RecommendationPicture the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RecommendationPicture::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
