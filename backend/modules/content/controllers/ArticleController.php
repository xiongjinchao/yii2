<?php

namespace backend\modules\content\controllers;

use yii;
use common\models\Article;
use common\models\ArticleSearch;
use common\models\ArticleSection;
use common\models\ArticleSectionPicture;
use backend\models\Picture;
use backend\controllers\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    private $auth = '文章管理';

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
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->request->post('hasEditable')) {
            $model = $this->findModel(Yii::$app->request->post('editableKey'));
            if ($model->load( $_POST ) && $model->load( ['Article' => current($_POST['Article'])] ) && $model->save()) {
                $result = ['output'=>'', 'message'=>''];
                Yii::$app->session->setFlash('info','文章更新成功！');
            }else{
                $result = ['output'=>'', 'message'=> current($model->getFirstErrors())];
                Yii::$app->session->setFlash('danger','文章更新失败！');
            }
            echo Json::encode($result);
            Yii::$app->end();
        }

        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();
        $model->audit = Article::AUDIT_ENABLE;
        $model->hot = Article::HOT_DISABLE;
        $model->recommend = Article::RECOMMEND_DISABLE;

        if ($model->load(Yii::$app->request->post())) {
            $model->category_id = !empty($_POST['Article']['category_id'])?','.implode(',',$_POST['Article']['category_id']).',':'';
            if($model->save()){
                Yii::$app->session->setFlash('info','文章创建成功！');
                return $this->redirect(['view', 'id' => $model->id]);

            }else{
                Yii::$app->session->setFlash('danger','文章创建失败！');
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->category_id = explode(',',trim($model->category_id,','));

        if ($model->load(Yii::$app->request->post())) {
            $model->category_id = !empty($_POST['Article']['category_id'])?','.implode(',',$_POST['Article']['category_id']).',':'';
            if($model->save()){
                Yii::$app->session->setFlash('info','文章更新成功！');
                return $this->redirect(['view', 'id' => $model->id]);

            }else{
                Yii::$app->session->setFlash('danger','文章更新失败！');
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionAudit($id)
    {
        $model = $this->findModel($id);
        $model->audit = 1- $model->audit;
        if($model->save()){
            Yii::$app->session->setFlash('info','审核提交成功！');
        }else{
            Yii::$app->session->setFlash('danger','审核提交失败！');
        }
        return $this->redirect(['index']);
    }

    public function actionHot($id)
    {
        $model = $this->findModel($id);
        $model->hot = 1- $model->hot;
        if($model->save()){
            Yii::$app->session->setFlash('info','热门提交成功！');
        }else{
            Yii::$app->session->setFlash('danger','热门提交失败！');
        }
        return $this->redirect(['index']);
    }

    public function actionRecommend($id)
    {
        $model = $this->findModel($id);
        $model->recommend = 1- $model->recommend;
        if($model->save()){
            Yii::$app->session->setFlash('info','推荐提交成功！');
        }else{
            Yii::$app->session->setFlash('danger','推荐提交失败！');
        }
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        ArticleSection::deleteAll('article_id = :article_id', [':article_id' => $id]);
        $sectionPictures = ArticleSectionPicture::find()->where(['article_id'=>$id])->all();
        if($sectionPictures!=null){
            foreach($sectionPictures as $item){
                $picture = Picture::findOne($item->picture_id);
                $picture->status = Picture::STATUS_ENABLE;
                $picture->save();
            }
        }
        ArticleSectionPicture::deleteAll('article_id = :article_id', [':article_id' => $id]);
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('info','文章删除成功！');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
