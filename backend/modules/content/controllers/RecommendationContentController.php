<?php

namespace backend\modules\content\controllers;

use Yii;
use backend\models\Picture;
use common\models\RecommendationCategory;
use common\models\RecommendationContent;
use common\models\RecommendationPicture;
use common\models\RecommendationContentSearch;
use backend\controllers\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\base\Exception;

/**
 * RecommendationContentController implements the CRUD actions for RecommendationContent model.
 */
class RecommendationContentController extends Controller
{
    private $auth = '推荐内容管理';

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
     * Lists all RecommendationContent models.
     * @return mixed
     */
    public function actionIndex($category_id)
    {
        if (Yii::$app->request->post('hasEditable')) {
            $model = $this->findModel(Yii::$app->request->post('editableKey'));
            if ($model->load( $_POST ) && $model->load( ['RecommendationContent' => current($_POST['RecommendationContent'])] ) && $model->save()) {
                $result = ['output'=>'', 'message'=>''];
                Yii::$app->session->setFlash('info','推荐分类更新成功！');
            }else{
                $result = ['output'=>'', 'message'=> current($model->getFirstErrors())];
                Yii::$app->session->setFlash('danger','推荐分类更新失败！');
            }
            echo Json::encode($result);
            Yii::$app->end();
        }

        Yii::$app->request->setQueryParams(['RecommendationContentSearch'=>['category_id'=>$category_id]]);
        $searchModel = new RecommendationContentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);;

        return $this->render('index', [
            'category' => RecommendationCategory::findOne($category_id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new RecommendationContent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($category_id)
    {
        $model = new RecommendationContent();
        $model->loadDefaultValues();
        $model->category_id = $category_id;
        $category = RecommendationCategory::findOne($category_id);
        $picture = null;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(!empty($_POST['RecommendationPicture'])) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    foreach ($_POST['RecommendationPicture'] as $item) {
                        $recommendationPicture = $item['id'] > 0 ? RecommendationPicture::findOne($item['id']) : new RecommendationPicture;
                        $recommendationPicture->content_id = $model->id;
                        $recommendationPicture->category_id = $model->category_id;
                        $recommendationPicture->picture_id = $item['picture_id'];
                        $recommendationPicture->picture_title = $item['picture_title'];
                        $recommendationPicture->sort = $item['sort'];
                        $recommendationPicture->save();
                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                }
            }
            Yii::$app->session->setFlash('info', '推荐内容创建成功！');
            return $this->redirect(['index', 'category_id' => $model->category_id]);
        } else {
            return $this->render('create', [
                'category' => $category,
                'model' => $model,
                'picture' => $picture
            ]);
        }
    }

    /**
     * Updates an existing RecommendationContent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $category = $model->category;
        $picture = RecommendationPicture::find()->where(['content_id'=>$id])->orderBy(['id'=>SORT_ASC])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(!empty($_POST['RecommendationPicture'])) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    foreach ($_POST['RecommendationPicture'] as $item) {
                        $recommendationPicture = $item['id'] > 0 ? RecommendationPicture::findOne($item['id']) : new RecommendationPicture;
                        $recommendationPicture->content_id = $model->id;
                        $recommendationPicture->category_id = $model->category_id;
                        $recommendationPicture->picture_id = $item['picture_id'];
                        $recommendationPicture->picture_title = $item['picture_title'];
                        $recommendationPicture->sort = $item['sort'];
                        $recommendationPicture->save();
                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                }
            }
            Yii::$app->session->setFlash('info', '推荐内容更新成功！');
            return $this->redirect(['index', 'category_id' => $model->category_id]);
        } else {
            return $this->render('update', [
                'category' => $category,
                'model' => $model,
                'picture' => $picture
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
        return $this->redirect(['index', 'category_id' => $model->category_id]);
    }

    /**
     * Deletes an existing RecommendationContent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing RecommendationPicture model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDeletePicture()
    {
        if(Yii::$app->request->isAjax) {
            try {
                $model = RecommendationPicture::findOne(Yii::$app->request->post('id'));
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
     * Finds the RecommendationContent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RecommendationContent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RecommendationContent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
