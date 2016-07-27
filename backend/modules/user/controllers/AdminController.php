<?php

namespace backend\modules\user\controllers;


use Yii;
use yii\db\Query;
use yii\rbac\Item;
use backend\modules\user\models\Admin;
use backend\modules\user\models\AdminSearch;
use yii\data\ActiveDataProvider;
use backend\controllers\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class AdminController extends Controller
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
     * Lists all Admin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Admin model.
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
     * Creates a new Admin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Admin();

        if ($model->load(Yii::$app->request->post())) {
            $model->password = $_POST['Admin']['password'];
            if($model->password!=''){
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
                $model->auth_key = Yii::$app->security->generateRandomString();
            }
            $model->save();
            Yii::$app->session->setFlash('info','管理员创建成功！');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Admin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if($id <= 2){
            return $this->redirect(['index']);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->password = $_POST['Admin']['password'];
            if($model->password!=''){
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
                $model->auth_key = Yii::$app->security->generateRandomString();
            }
            $model->save();
            Yii::$app->session->setFlash('info','管理员更新成功！');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Admin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $auth = yii::$app->authManager;
        $auth->revokeAll($id);
        Yii::$app->session->setFlash('info','管理员删除成功！');
        return $this->redirect(['index']);
    }

    public function actionTest(){}

    public function actionReset()
    {
        $auth = yii::$app->authManager;
        $auth->removeAll();
        $superAdmin = $auth->createRole('超级管理员');
        $superAdmin->description = 'SuperAdmin';
        $superAdmin->data = 'core';
        $auth->add($superAdmin);

        $admin = $auth->createRole('管理员');
        $admin->description = 'Admin';
        $admin->data = 'core';
        $auth->add($admin);

        $dir = Yii::$app->basePath.'/modules/';
        $this->getControllers($dir);

        $auth->assign($superAdmin, 1);
        $auth->assign($admin, 2);
        Yii::$app->session->setFlash('info','权限重置成功！');
        return $this->redirect(['index']);
    }

    public function actionAssignment($id)
    {
        $auth = yii::$app->authManager;
        if(Yii::$app->request->isPost){
            $auth->revokeAll($id);
            $roles = Yii::$app->request->post('roles');
            if(!empty($roles)){
                foreach($roles as $item){
                    $role = $auth->getRole($item);
                    $auth->assign($role, $id);
                }
                Yii::$app->session->setFlash('info','权限设置成功！');
                return $this->redirect(['index']);
            }
        }

        $dataProvider =  new ActiveDataProvider([
            'query' => (new Query())->from($auth->itemTable)->where('type = :type and (data = :data or name = :admin)',[':type'=>Item::TYPE_ROLE,':data'=>serialize('application'),':admin'=>'管理员'])->orderBy(['created_at'=>SORT_DESC]),
        ]);

        $roles = $auth->getRolesByUser($id);
        $admin = Admin::findOne($id);

        return $this->render('assignment', [
            'dataProvider' => $dataProvider,
            'auth' => $auth,
            'roles' => $roles,
            'admin' => $admin,
        ]);
    }

    /**
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if($id <= 2){
            return $this->redirect(['index']);
        }
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
