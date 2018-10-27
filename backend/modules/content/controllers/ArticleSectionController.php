<?php

namespace backend\modules\content\controllers;

use yii;
use backend\models\Picture;
use common\models\Article;
use common\models\ArticleSection;
use common\models\ArticleSectionPicture;
use yii\data\ActiveDataProvider;
use backend\controllers\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\base\Exception;

/**
 * ArticleSectionController implements the CRUD actions for ArticleSection model.
 */
class ArticleSectionController extends Controller
{
    private $auth = '文章段落管理';

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
     * Edit an existing Article model.
     * If update is successful, the browser will be redirected to the 'article view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ArticleSection::find()->where(['article_id'=>$id])->orderBy(['id'=>SORT_ASC]),
        ]);
        $article = Article::findOne($id);
        if (Yii::$app->request->post()) {
            $transaction = Yii::$app->db->beginTransaction();
            try{
                foreach($_POST['ArticleSection'] as $item){
                    $section = $item['id']>0?ArticleSection::findOne($item['id']):new ArticleSection;
                    $section->article_id = $id;
                    $section->section_title = $item['section_title'];
                    $section->section_content = $item['section_content'];
                    $section->save();
                    if(isset($item['ArticleSectionPicture'])&&$item['ArticleSectionPicture']!=''){
                        foreach($item['ArticleSectionPicture'] as $value){
                            $sectionPicture = $value['id']>0?ArticleSectionPicture::findOne($value['id']):new ArticleSectionPicture;
                            $sectionPicture->article_id = $id;
                            $sectionPicture->section_id = $section->id;
                            $sectionPicture->picture_id = $value['picture_id'];
                            $sectionPicture->picture_title = $value['picture_title'];
                            $sectionPicture->sort = $value['sort'];
                            $sectionPicture->save();

                            $picture = Picture::findOne($value['picture_id']);
                            $picture->status = Picture::STATUS_ENABLE;
                            $picture->save();
                        }
                    }
                }
                $transaction->commit();
                Yii::$app->session->setFlash('info','段落编辑成功！');
            }catch(Exception $e) {
                $transaction->rollback();
                Yii::$app->session->setFlash('danger','段落编辑失败！');
            }
            return $this->redirect(['edit','id'=>$id]);
        }

        return $this->render('edit', [
            'dataProvider' => $dataProvider,
            'article' => $article
        ]);

    }

    /**
     * Deletes an existing ArticleSection model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id = null)
    {
        $id = Yii::$app->request->post('id', $id);
        $sectionPictures = ArticleSectionPicture::find()->where(['section_id'=>$id])->all();
        if($sectionPictures!=null){
            foreach($sectionPictures as $item){
                $picture = Picture::findOne($item->picture_id);
                $picture->status = Picture::STATUS_ENABLE;
                $picture->save();
            }
        }
        ArticleSectionPicture::deleteAll('section_id = :section_id', [':section_id' => $id]);
        $this->findModel($id)->delete();
    }

    /**
     * Deletes an existing ArticleSectionPicture model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeletePicture($id = null)
    {
        $id = Yii::$app->request->post('id', $id);
        $model= ArticleSectionPicture::findOne($id);
        $picture = Picture::findOne($model->picture_id);
        $picture->status = Picture::STATUS_DISABLE;
        $picture->save();
        $model->delete();
        if(!Yii::$app->request->isAjax){
            return $this->redirect(['index','id'=>$model->article_id]);
        }
    }

    /**
     * Finds the ArticleSection model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ArticleSection the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArticleSection::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
