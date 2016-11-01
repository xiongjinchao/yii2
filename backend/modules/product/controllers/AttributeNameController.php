<?php

namespace backend\modules\product\controllers;

use yii;
use common\models\AttributeName;
use common\models\AttributeNameSearch;
use common\models\AttributeValue;
use backend\controllers\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;

/**
 * AttributeNameController implements the CRUD actions for AttributeName model.
 */
class AttributeNameController extends Controller
{
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
     * Lists all AttributeName models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->request->post('hasEditable')) {
            $model = $this->findModel(Yii::$app->request->post('editableKey'));
            if ($model->load( $_POST ) && $model->load( ['AttributeName' => current($_POST['AttributeName'])] ) && $model->save()) {
                $result = ['output'=>'', 'message'=>''];
                Yii::$app->session->setFlash('info','属性更新成功！');
            }else{
                $result = ['output'=>'', 'message'=> current($model->getFirstErrors())];
                Yii::$app->session->setFlash('danger','属性更新失败！');
            }
            echo Json::encode($result);
            return;
        }

        $searchModel = new AttributeNameSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => new AttributeName(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new AttributeName model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AttributeName();
        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('info','属性创建成功！');
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('_create', [
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

    /**
     * Deletes an existing AttributeName model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('info','属性删除成功！');
        return $this->redirect(['index']);
    }

    /**
     * Finds the AttributeName model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AttributeName the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AttributeName::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
