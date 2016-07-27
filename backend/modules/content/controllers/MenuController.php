<?php

namespace backend\modules\content\controllers;

use Yii;
use backend\modules\content\models\Menu;
use backend\controllers\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\db\Exception;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller
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
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Menu::find()->orderBy(['lft'=>SORT_ASC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
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
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menu();
        $model->audit = Menu::AUDIT_ENABLE;
        $model->visible = Menu::VISIBLE_ENABLE;

        if ($model->load(Yii::$app->request->post())) {

            if($model->parent > 0){
                $parent = Menu::findOne($model->parent);
                Menu::updateAllCounters(['lft'=>2],'`lft`>=:lft',[':lft'=>$parent->rgt]);
                Menu::updateAllCounters(['rgt'=>2],'`rgt`>=:rgt',[':rgt'=>$parent->rgt]);
                $model->lft = $parent->rgt;
                $model->rgt = $parent->rgt+1;
                $model->depth = $parent->depth+1;
            }else{
                $max = Menu::find()->orderBy('`rgt` DESC')->one();
                $model->parent = 0;
                $model->lft = $max!=''?$max->rgt+1:1;
                $model->rgt = $max!=''?$max->rgt+2:2;
                $model->depth = 1;
            }

            if($model->save()){
                Yii::$app->session->setFlash('info','菜单创建成功！');
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                Yii::$app->session->setFlash('danger','菜单创建失败！');
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try{
                if($model->parent == $model->getOldAttribute('parent')){
                    $model->save();
                }else if($model->parent == 0){
                    $model->update();
                    $treeMenu = Menu::find()->where('`lft` >="'.$model->lft.'" and `rgt` <="'.$model->rgt.'"')->all();
                    $treeMenu = ArrayHelper::toArray($treeMenu);
                    $treeId = ArrayHelper::getColumn($treeMenu,'id');
                    Menu::updateAllCounters(['lft'=>-($model->rgt-$model->lft+1)],'`lft`>:lft',[':lft'=>$model->rgt]);
                    Menu::updateAllCounters(['rgt'=>-($model->rgt-$model->lft+1)],'`rgt`>:rgt',[':rgt'=>$model->rgt]);
                    $max = Menu::find()->where("`id` not in (".implode(',',$treeId).")")->orderBy('`rgt` DESC')->one();
                    Menu::updateAllCounters(['lft'=>$max->rgt-$model->lft+1,'rgt'=>$max->rgt-$model->lft+1,'depth'=>-($model->depth-1)],"`id` in (".implode(',',$treeId).")");
                }else{
                    $parent = Menu::findOne($model->parent);
                    $exist = Menu::find()->where('`lft` <:lft and `rgt` >:rgt and `id` = :id',[':lft'=>$model->lft,':rgt'=>$model->rgt,':id'=>$parent->id])->one();
                    $treeMenu = Menu::find()->where('`lft` >="'.$model->lft.'" and `rgt` <="'.$model->rgt.'"')->all();
                    $treeMenu = ArrayHelper::toArray($treeMenu);
                    $treeId = ArrayHelper::getColumn($treeMenu,'id');

                    if($model->id==$parent->parent||$treeMenu==null||in_array($model->parent,$treeId)||$exist!=null){
                        Yii::$app->session->setFlash('danger','菜单更新失败！');
                        return $this->redirect(['index']);
                    }else{
                        $model->save();
                        if($parent->lft>$model->lft){
                            $between=$parent->rgt-$model->rgt-1;
                            Menu::updateAllCounters(['lft'=>-($model->rgt-$model->lft+1)],'`lft`>:lft and `lft`<'.$parent->rgt,[':lft'=>$model->rgt]);
                            Menu::updateAllCounters(['rgt'=>-($model->rgt-$model->lft+1)],'`rgt`>:rgt and `rgt`<'.$parent->rgt,[':rgt'=>$model->rgt]);
                        }else{
                            $between=$parent->rgt-$model->lft;
                            Menu::updateAllCounters(['lft'=>$model->rgt-$model->lft+1],'`lft`>:lft and `lft`<'.$model->lft,[':lft'=>$parent->rgt]);
                            Menu::updateAllCounters(['rgt'=>$model->rgt-$model->lft+1],'`rgt`>=:rgt and `rgt`<'.$model->lft,[':rgt'=>$parent->rgt]);

                        }
                        Menu::updateAllCounters(['lft'=>$between,'rgt'=>$between,'depth'=>$parent->depth-$model->depth+1],"`id` in (".implode(',',$treeId).")");
                    }
                }
                $transaction->commit();
                Yii::$app->session->setFlash('info','菜单更新成功！');
            }catch(Exception $e) {
                $transaction->rollback();
                Yii::$app->session->setFlash('danger','菜单更新失败！');
            }
            return $this->redirect(['index']);

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }

    }

    public function actionMoveUp($id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $model = $this->findModel($id);
            $previousMenu = Menu::findOne(['rgt'=>$model->lft-1]);
            $treeMenu = Menu::find()->where('`lft` >="'.$model->lft.'" and `rgt` <="'.$model->rgt.'"')->all();

            $treeMenu = ArrayHelper::toArray($treeMenu);
            $treeId = ArrayHelper::getColumn($treeMenu,'id');
            Menu::updateAllCounters(['lft'=>$model->rgt-$model->lft+1,'rgt'=>$model->rgt-$model->lft+1],'`lft`>=:lft and `rgt`<=:rgt',[':lft'=>$previousMenu->lft,':rgt'=>$previousMenu->rgt]);
            Menu::updateAllCounters(['lft'=>-($previousMenu->rgt-$previousMenu->lft+1),'rgt'=>-($previousMenu->rgt-$previousMenu->lft+1)],"`id` in (".implode(',',$treeId).")");
            $transaction->commit();

            Yii::$app->session->setFlash('info','排序提交成功！');

        }catch(Exception $e) {
            $transaction->rollback();
            Yii::$app->session->setFlash('danger','排序提交失败！');
        }
        return $this->redirect(['index']);
    }

    public function actionMoveDown($id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $model = $this->findModel($id);
            $nextMenu = Menu::findOne(['lft'=>$model->rgt+1]);
            $treeMenu = Menu::find()->where('`lft` >="'.$model->lft.'" and `rgt` <="'.$model->rgt.'"')->all();
            $treeMenu = ArrayHelper::toArray($treeMenu);
            $treeId = ArrayHelper::getColumn($treeMenu,'id');

            Menu::updateAllCounters(['lft'=>-($model->rgt-$model->lft+1),'rgt'=>-($model->rgt-$model->lft+1)],'`lft`>=:lft and `rgt`<=:rgt',[':lft'=>$nextMenu->lft,':rgt'=>$nextMenu->rgt]);
            Menu::updateAllCounters(['lft'=>$nextMenu->rgt-$nextMenu->lft+1,'rgt'=>$nextMenu->rgt-$nextMenu->lft+1],"id in (".implode(',',$treeId).")");
            $transaction->commit();

            Yii::$app->session->setFlash('info','排序提交成功！');

        }catch(Exception $e) {
            $transaction->rollback();
            Yii::$app->session->setFlash('danger','排序提交失败！');
        }
        return $this->redirect(['index']);
    }

    public function actionVisible($id)
    {
        $model = $this->findModel($id);
        $model->visible = 1- $model->visible;
        if($model->save()){
            Yii::$app->session->setFlash('info','可见提交成功！');
        }else{
            Yii::$app->session->setFlash('danger','可见提交失败！');
        }
        return $this->redirect(['index']);
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
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();
        try{
            Menu::deleteAll('lft >=:lft and rgt <=:rgt',[':lft'=>$model->lft,':rgt'=>$model->rgt]);
            Menu::updateAllCounters(['lft'=>-($model->rgt-$model->lft+1)],'lft>:lft',[':lft'=>$model->lft]);
            Menu::updateAllCounters(['rgt'=>-($model->rgt-$model->lft+1)],'rgt>:rgt',[':rgt'=>$model->rgt]);
            $transaction->commit();

            Yii::$app->session->setFlash('info','菜单删除成功！');
        }catch(Exception $e) {
            $transaction->rollback();
            Yii::$app->session->setFlash('danger','菜单删除失败！');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
