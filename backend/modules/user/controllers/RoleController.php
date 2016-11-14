<?php

namespace backend\modules\user\controllers;

use yii;
use yii\db\Query;
use yii\rbac\Item;
use yii\data\ActiveDataProvider;
use backend\controllers\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;


class RoleController extends Controller
{

    private $auth = [
        0  => '角色管理',
        'Index' => '列表',
        'Create' => '创建',
        'Update' => '更新',
        'Assignment' => '授权',
        'AuthInitialize' => '权限索引',
        'View' => '查看',
        'Delete' => '删除',
    ];

    public function behaviors()
    {
        return ArrayHelper::merge([
            'verbs' =>[
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ],parent::behaviors());
    }

    public function actionIndex()
    {
        $auth = \Yii::$app->authManager;
        $dataProvider = new ActiveDataProvider([
            'query' => (new Query())->from($auth->itemTable)->where(['type'=>Item::TYPE_ROLE,'data'=>serialize('application')])->orderBy(['created_at'=>SORT_DESC]),
            'pagination' => ['pageSize' => 15],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($name)
    {
        return $this->render('view', [
            'model' => $this->findModel($name),
        ]);
    }

    public function actionCreate()
    {
        $model = new Item();
        if($model->name === null && ($data = \Yii::$app->request->post())){
            $auth = yii::$app->authManager;
            $role = $auth->createRole($data['name']);
            $role->description = $data['description'];
            $role->data = 'application';
            if($auth->add($role)){
                Yii::$app->session->setFlash('info','角色创建成功！');
            }else{
                Yii::$app->session->setFlash('danger','角色创建失败！');
            }
            return $this->redirect(['index']);
        }else{
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate()
    {
        if ($data = \Yii::$app->request->post()){
            if($data['name']!=''){
                $auth = yii::$app->authManager;
                $role = $auth->createRole($data['name']);
                $role->description = $data['description'];
                $role->data = 'application';
                if($auth->update(Yii::$app->request->get('name'),$role)){
                    Yii::$app->session->setFlash('info','角色更新成功！');
                }else{
                    Yii::$app->session->setFlash('danger','角色更新失败！');
                }
            }
            return $this->redirect(['index']);
        }else{
            $auth = yii::$app->authManager;
            $model = $auth->getRole(Yii::$app->request->get('name'));
            return $this->render('update', [
                'model' => $model,
            ]); 
        }
    }

    public function actionAssignment()
    {
        $auth = Yii::$app->authManager;
        $name = Yii::$app->request->get('name');
        $role = $auth->getRole($name);
        if(Yii::$app->request->isPost){
            $permissions = Yii::$app->request->post('permissions');
            $auth->removeChildren($role);

            if(!empty($permissions)){
                foreach($permissions as $item){
                    $permission = $auth->getPermission($item);
                    $auth->addChild($role, $permission);
                }
            }
            Yii::$app->session->setFlash('info','权限分配成功！');
            return $this->redirect(['index']);
        }

        $dataProvider =  new ActiveDataProvider([
            'query' => (new Query())->from($auth->itemTable)->where(['type'=>Item::TYPE_ROLE,'data'=>serialize('system')])->orderBy(['name'=>SORT_ASC]),
        ]);

        return $this->render('assignment', [
            'dataProvider' => $dataProvider,
            'auth' => $auth,
            'role' => $role,
        ]);
    }

    public function actionDelete()
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole(Yii::$app->request->get('name'));
        if($auth->remove($role)){
            Yii::$app->session->setFlash('info','角色删除成功！');
        }else{
            Yii::$app->session->setFlash('danger','角色删除失败！');
        }
        return $this->redirect(['index']);
    }

    public function actionAuthInitialize($name)
    {
        $this->authInitialize();
        Yii::$app->session->setFlash('info','权限检索成功！');
        return $this->redirect(['assignment','name'=>$name]);
    }

    protected function findModel($name)
    {
        $auth = yii::$app->authManager;
        $model = $auth->getRole($name);
        if ($model !== null){
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
