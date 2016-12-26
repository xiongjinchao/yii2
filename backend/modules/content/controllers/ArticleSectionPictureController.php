<?php

namespace backend\modules\content\controllers;

use yii;
use backend\models\Picture;
use common\models\Article;
use common\models\ArticleSectionPicture;
use backend\controllers\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ArticleSectionPictureController implements the CRUD actions for ArticleSectionPicture model.
 */
class ArticleSectionPictureController extends Controller
{
    private $auth = '文章图片管理';

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
     * Lists all ArticleSectionPicture models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ArticleSectionPicture::find()->where('article_id = :article_id',[':article_id'=>$id])->orderBy(['section_id'=>SORT_ASC,'sort'=>SORT_DESC]),
        ]);
        $article = Article::findOne($id);

        return $this->render('index', [
            'article' => $article,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing ArticleSectionPicture model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id = null)
    {
        $id = Yii::$app->request->isAjax?Yii::$app->request->post('id'):$id;
        $model=$this->findModel($id);
        $picture = Picture::findOne($model->picture_id);
        $picture->status = Picture::STATUS_DISABLE;
        $picture->save();
        $model->delete();
        if(!Yii::$app->request->isAjax){
            return $this->redirect(['index','id'=>$model->article_id]);
        }
    }

    /**
     * Finds the ArticleSectionPicture model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ArticleSectionPicture the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArticleSectionPicture::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
