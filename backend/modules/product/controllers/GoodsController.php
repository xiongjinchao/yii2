<?php

namespace backend\modules\product\controllers;

use Yii;
use common\models\Goods;
use common\models\GoodsSearch;
use backend\controllers\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use common\helpers\UploadHelper;

/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class GoodsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Goods models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->request->post('hasEditable')) {
            $model = $this->findModel(Yii::$app->request->post('editableKey'));
            if ($model->load( $_POST ) && $model->load( ['Goods' => current($_POST['Goods'])] ) && $model->save()) {
                $result = ['output'=>'', 'message'=>''];
                Yii::$app->session->setFlash('info','商品更新成功！');
            }else{
                $result = ['output'=>'', 'message'=> current($model->getFirstErrors())];
                Yii::$app->session->setFlash('danger','商品更新失败！');
            }
            echo Json::encode($result);
            Yii::$app->end();
        }

        $searchModel = new GoodsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Goods model.
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
     * Creates a new Goods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Goods();
        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post())) {
            try {
                $picture = UploadHelper::upload($model, 'master_picture', null, 'goods');
            }catch (\Exception $e){
                $picture = '';
            }
            if($picture!=''){
                $model->picture_id = $picture->id;
            }
            if($model->save()){
                Yii::$app->session->setFlash('info','商品创建成功！');
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                Yii::$app->session->setFlash('danger','商品创建失败！');
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Goods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            try {
                $picture = UploadHelper::upload($model, 'master_picture', null, 'goods');
            }catch (\Exception $e){
                $picture = '';
            }
            if($picture!=''){
                $model->picture_id = $picture->id;
            }
            if($model->save()){
                Yii::$app->session->setFlash('info','商品更新成功！');
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                Yii::$app->session->setFlash('danger','商品更新失败！');
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionAudit($id)
    {
        $model = $this->findModel($id);
        $model->audit = 1- $model->audit;
        if($model->save()){
            Yii::$app->session->setFlash('info','上下架提交成功！');
        }else{
            Yii::$app->session->setFlash('danger','上下架提交失败！');
        }
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Goods model.
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
     * Finds the Goods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Goods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goods::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
