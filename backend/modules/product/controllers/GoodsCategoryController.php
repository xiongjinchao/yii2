<?php

namespace backend\modules\product\controllers;

use yii;
use common\models\GoodsCategory;
use common\models\GoodsCategorySearch;
use backend\controllers\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\db\Exception;

/**
 * GoodsCategoryController implements the CRUD actions for GoodsCategory model.
 */
class GoodsCategoryController extends Controller
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
     * Lists all GoodsCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->request->post('hasEditable')) {
            $model = $this->findModel(Yii::$app->request->post('editableKey'));
            if ($model->load( $_POST ) && $model->load( ['GoodsCategory' => current($_POST['GoodsCategory'])] ) && $model->save()) {
                $result = ['output'=>'', 'message'=>''];
                Yii::$app->session->setFlash('info','分类更新成功！');
            }else{
                $result = ['output'=>'', 'message'=> current($model->getFirstErrors())];
                Yii::$app->session->setFlash('danger','分类更新失败！');
            }
            echo Json::encode($result);
            Yii::$app->end();
        }

        $searchModel = new GoodsCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GoodsCategory model.
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
     * Creates a new GoodsCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GoodsCategory();
        $model->audit = GoodsCategory::AUDIT_ENABLE;

        if ($model->load(Yii::$app->request->post())) {

            if($model->parent > 0){
                $parent = GoodsCategory::findOne($model->parent);
                GoodsCategory::updateAllCounters(['lft'=>2],'`lft`>=:lft',[':lft'=>$parent->rgt]);
                GoodsCategory::updateAllCounters(['rgt'=>2],'`rgt`>=:rgt',[':rgt'=>$parent->rgt]);
                $model->lft = $parent->rgt;
                $model->rgt = $parent->rgt+1;
                $model->depth = $parent->depth+1;
            }else{
                $max = GoodsCategory::find()->orderBy('`rgt` DESC')->one();
                $model->parent = 0;
                $model->lft = $max!=''?$max->rgt+1:1;
                $model->rgt = $max!=''?$max->rgt+2:2;
                $model->depth = 1;
            }

            if($model->save()){
                Yii::$app->session->setFlash('info','信息提交成功！');
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                Yii::$app->session->setFlash('danger','信息提交失败！');
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing GoodsCategory model.
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
                    $treeGoodsCategory = GoodsCategory::find()->where('`lft` >="'.$model->lft.'" and `rgt` <="'.$model->rgt.'"')->all();
                    $treeGoodsCategory = ArrayHelper::toArray($treeGoodsCategory);
                    $treeId = ArrayHelper::getColumn($treeGoodsCategory,'id');
                    GoodsCategory::updateAllCounters(['lft'=>-($model->rgt-$model->lft+1)],'`lft`>:lft',[':lft'=>$model->rgt]);
                    GoodsCategory::updateAllCounters(['rgt'=>-($model->rgt-$model->lft+1)],'`rgt`>:rgt',[':rgt'=>$model->rgt]);
                    $max = GoodsCategory::find()->where("`id` not in (".implode(',',$treeId).")")->orderBy('`rgt` DESC')->one();
                    GoodsCategory::updateAllCounters(['lft'=>$max->rgt-$model->lft+1,'rgt'=>$max->rgt-$model->lft+1,'depth'=>-($model->depth-1)],"`id` in (".implode(',',$treeId).")");
                }else{
                    $parent = GoodsCategory::findOne($model->parent);
                    $exist = GoodsCategory::find()->where('`lft` <:lft and `rgt` >:rgt and `id` = :id',[':lft'=>$model->lft,':rgt'=>$model->rgt,':id'=>$parent->id])->one();
                    $treeGoodsCategory = GoodsCategory::find()->where('`lft` >="'.$model->lft.'" and `rgt` <="'.$model->rgt.'"')->all();
                    $treeGoodsCategory = ArrayHelper::toArray($treeGoodsCategory);
                    $treeId = ArrayHelper::getColumn($treeGoodsCategory,'id');

                    if($model->id==$parent->parent||$treeGoodsCategory==null||in_array($model->parent,$treeId)||$exist!=null){
                        Yii::$app->session->setFlash('danger','信息提交失败！');
                        return $this->redirect(['index']);
                    }else{
                        $model->save();
                        if($parent->lft>$model->lft){
                            $between=$parent->rgt-$model->rgt-1;
                            GoodsCategory::updateAllCounters(['lft'=>-($model->rgt-$model->lft+1)],'`lft`>:lft and `lft`<'.$parent->rgt,[':lft'=>$model->rgt]);
                            GoodsCategory::updateAllCounters(['rgt'=>-($model->rgt-$model->lft+1)],'`rgt`>:rgt and `rgt`<'.$parent->rgt,[':rgt'=>$model->rgt]);
                        }else{
                            $between=$parent->rgt-$model->lft;
                            GoodsCategory::updateAllCounters(['lft'=>$model->rgt-$model->lft+1],'`lft`>:lft and `lft`<'.$model->lft,[':lft'=>$parent->rgt]);
                            GoodsCategory::updateAllCounters(['rgt'=>$model->rgt-$model->lft+1],'`rgt`>=:rgt and `rgt`<'.$model->lft,[':rgt'=>$parent->rgt]);

                        }
                        GoodsCategory::updateAllCounters(['lft'=>$between,'rgt'=>$between,'depth'=>$parent->depth-$model->depth+1],"`id` in (".implode(',',$treeId).")");
                    }
                }
                $transaction->commit();
                Yii::$app->session->setFlash('info','信息提交成功！');

            }catch(Exception $e) {
                $transaction->rollback();
                Yii::$app->session->setFlash('danger','信息提交失败！');
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
            $previousGoodsCategory = GoodsCategory::findOne(['rgt'=>$model->lft-1]);
            $treeGoodsCategory = GoodsCategory::find()->where('`lft` >="'.$model->lft.'" and `rgt` <="'.$model->rgt.'"')->all();

            $treeGoodsCategory = ArrayHelper::toArray($treeGoodsCategory);
            $treeId = ArrayHelper::getColumn($treeGoodsCategory,'id');
            GoodsCategory::updateAllCounters(['lft'=>$model->rgt-$model->lft+1,'rgt'=>$model->rgt-$model->lft+1],'`lft`>=:lft and `rgt`<=:rgt',[':lft'=>$previousGoodsCategory->lft,':rgt'=>$previousGoodsCategory->rgt]);
            GoodsCategory::updateAllCounters(['lft'=>-($previousGoodsCategory->rgt-$previousGoodsCategory->lft+1),'rgt'=>-($previousGoodsCategory->rgt-$previousGoodsCategory->lft+1)],"`id` in (".implode(',',$treeId).")");
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
            $nextGoodsCategory = GoodsCategory::findOne(['lft'=>$model->rgt+1]);
            $treeGoodsCategory = GoodsCategory::find()->where('`lft` >="'.$model->lft.'" and `rgt` <="'.$model->rgt.'"')->all();
            $treeGoodsCategory = ArrayHelper::toArray($treeGoodsCategory);
            $treeId = ArrayHelper::getColumn($treeGoodsCategory,'id');

            GoodsCategory::updateAllCounters(['lft'=>-($model->rgt-$model->lft+1),'rgt'=>-($model->rgt-$model->lft+1)],'`lft`>=:lft and `rgt`<=:rgt',[':lft'=>$nextGoodsCategory->lft,':rgt'=>$nextGoodsCategory->rgt]);
            GoodsCategory::updateAllCounters(['lft'=>$nextGoodsCategory->rgt-$nextGoodsCategory->lft+1,'rgt'=>$nextGoodsCategory->rgt-$nextGoodsCategory->lft+1],"id in (".implode(',',$treeId).")");
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
            Yii::$app->session->setFlash('danger','可见提交成功！');
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
     * Deletes an existing GoodsCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();
        try{
            GoodsCategory::deleteAll('lft >=:lft and rgt <=:rgt',[':lft'=>$model->lft,':rgt'=>$model->rgt]);
            GoodsCategory::updateAllCounters(['lft'=>-($model->rgt-$model->lft+1)],'lft>:lft',[':lft'=>$model->lft]);
            GoodsCategory::updateAllCounters(['rgt'=>-($model->rgt-$model->lft+1)],'rgt>:rgt',[':rgt'=>$model->rgt]);
            $transaction->commit();

            Yii::$app->session->setFlash('info','菜单删除成功！');
        }catch(Exception $e) {
            $transaction->rollback();
            Yii::$app->session->setFlash('danger','菜单删除失败！');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the GoodsCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GoodsCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GoodsCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
