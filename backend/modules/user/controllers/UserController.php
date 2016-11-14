<?php

namespace backend\modules\user\controllers;

use yii;
use common\models\User;
use common\models\UserSearch;
use backend\controllers\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\helpers\UploadHelper;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    private $auth = [
        0  => '员工管理',
        'Index' => '列表',
        'Create' => '创建',
        'Update' => '更新',
        'Status' => '状态',
        'View' => '查看',
        'Delete' => '删除',
    ];

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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            $model->password = $_POST['User']['password'];
            try {
                $picture = UploadHelper::upload($model, 'avatar', null, 'avatar');
            }catch (\Exception $e){
                $picture = '';
            }
            if($picture!=''){
                $model->picture_id = $picture->id;
            }
            if($model->password!=''){
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
                $model->auth_key = Yii::$app->security->generateRandomString();
            }
            if($model->save()) {
                Yii::$app->session->setFlash('info', '用户创建成功！');
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                Yii::$app->session->setFlash('danger', '用户创建失败！');
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->password = $_POST['User']['password'];
            try {
                $picture = UploadHelper::upload($model, 'avatar', null, 'avatar');
            }catch (\Exception $e){
                $picture = '';
            }
            if($picture!=''){
                $model->picture_id = $picture->id;
            }
            if($model->password!=''){
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
                $model->auth_key = Yii::$app->security->generateRandomString();
            }
            if($model->save()){
                Yii::$app->session->setFlash('info','用户更新成功！');
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                Yii::$app->session->setFlash('danger','用户更新失败！');
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionStatus($id)
    {
        $model = $this->findModel($id);
        $model->status = 10- $model->status;
        if($model->save()){
            Yii::$app->session->setFlash('info','状态提交成功！');
        }else{
            Yii::$app->session->setFlash('danger','状态提交失败！');
        }
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('info','用户删除成功！');
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
