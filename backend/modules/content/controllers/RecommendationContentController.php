<?php

namespace backend\modules\content\controllers;

use Yii;
use common\models\RecommendationCategory;
use common\models\RecommendationContent;
use yii\data\ActiveDataProvider;
use backend\controllers\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * RecommendationContentController implements the CRUD actions for RecommendationContent model.
 */
class RecommendationContentController extends Controller
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
     * Lists all RecommendationContent models.
     * @return mixed
     */
    public function actionIndex($category_id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => RecommendationContent::find()->where('category_id = :category_id',[':category_id'=>$category_id])->orderBy(['sort'=>SORT_ASC]),
        ]);
        $category = RecommendationCategory::findOne($category_id);

        return $this->render('index', [
            'category' => $category,
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
        $model->category_id = $category_id;
        $category = RecommendationCategory::findOne($category_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'category' => $category,
                'model' => $model,
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'category' => $category,
                'model' => $model,
            ]);
        }
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
