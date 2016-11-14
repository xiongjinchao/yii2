<?php

namespace backend\modules\content\controllers;

use yii;
use common\models\ArticleCategory;
use backend\controllers\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\db\Exception;

/**
 * ArticleCategoryController implements the CRUD actions for ArticleCategory model.
 */
class ArticleCategoryController extends Controller
{
    private $auth = [
        0  => '文章分类管理',
        'Index' => '列表',
        'Create' => '创建',
        'Update' => '更新',
        'MoveUp' => '上移',
        'MoveDown' => '下移',
        'Audit' => '审核',
        'Visible' => '可见',
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
     * Lists all ArticleCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ArticleCategory::find()->orderBy(['lft'=>SORT_ASC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ArticleCategory model.
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
     * Creates a new ArticleCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ArticleCategory();
        $model->audit = ArticleCategory::AUDIT_ENABLE;

        if ($model->load(Yii::$app->request->post())) {

            if($model->parent > 0){
                $parent = ArticleCategory::findOne($model->parent);
                ArticleCategory::updateAllCounters(['lft'=>2],'`lft`>=:lft',[':lft'=>$parent->rgt]);
                ArticleCategory::updateAllCounters(['rgt'=>2],'`rgt`>=:rgt',[':rgt'=>$parent->rgt]);
                $model->lft = $parent->rgt;
                $model->rgt = $parent->rgt+1;
                $model->depth = $parent->depth+1;
            }else{
                $max = ArticleCategory::find()->orderBy('`rgt` DESC')->one();
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
     * Updates an existing ArticleCategory model.
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
                    $treeArticleCategory = ArticleCategory::find()->where('`lft` >="'.$model->lft.'" and `rgt` <="'.$model->rgt.'"')->all();
                    $treeArticleCategory = ArrayHelper::toArray($treeArticleCategory);
                    $treeId = ArrayHelper::getColumn($treeArticleCategory,'id');
                    ArticleCategory::updateAllCounters(['lft'=>-($model->rgt-$model->lft+1)],'`lft`>:lft',[':lft'=>$model->rgt]);
                    ArticleCategory::updateAllCounters(['rgt'=>-($model->rgt-$model->lft+1)],'`rgt`>:rgt',[':rgt'=>$model->rgt]);
                    $max = ArticleCategory::find()->where("`id` not in (".implode(',',$treeId).")")->orderBy('`rgt` DESC')->one();
                    ArticleCategory::updateAllCounters(['lft'=>$max->rgt-$model->lft+1,'rgt'=>$max->rgt-$model->lft+1,'depth'=>-($model->depth-1)],"`id` in (".implode(',',$treeId).")");
                }else{
                    $parent = ArticleCategory::findOne($model->parent);
                    $exist = ArticleCategory::find()->where('`lft` <:lft and `rgt` >:rgt and `id` = :id',[':lft'=>$model->lft,':rgt'=>$model->rgt,':id'=>$parent->id])->one();
                    $treeArticleCategory = ArticleCategory::find()->where('`lft` >="'.$model->lft.'" and `rgt` <="'.$model->rgt.'"')->all();
                    $treeArticleCategory = ArrayHelper::toArray($treeArticleCategory);
                    $treeId = ArrayHelper::getColumn($treeArticleCategory,'id');

                    if($model->id==$parent->parent||$treeArticleCategory==null||in_array($model->parent,$treeId)||$exist!=null){
                        Yii::$app->session->setFlash('danger','信息提交失败！');
                        return $this->redirect(['index']);
                    }else{
                        $model->save();
                        if($parent->lft>$model->lft){
                            $between=$parent->rgt-$model->rgt-1;
                            ArticleCategory::updateAllCounters(['lft'=>-($model->rgt-$model->lft+1)],'`lft`>:lft and `lft`<'.$parent->rgt,[':lft'=>$model->rgt]);
                            ArticleCategory::updateAllCounters(['rgt'=>-($model->rgt-$model->lft+1)],'`rgt`>:rgt and `rgt`<'.$parent->rgt,[':rgt'=>$model->rgt]);
                        }else{
                            $between=$parent->rgt-$model->lft;
                            ArticleCategory::updateAllCounters(['lft'=>$model->rgt-$model->lft+1],'`lft`>:lft and `lft`<'.$model->lft,[':lft'=>$parent->rgt]);
                            ArticleCategory::updateAllCounters(['rgt'=>$model->rgt-$model->lft+1],'`rgt`>=:rgt and `rgt`<'.$model->lft,[':rgt'=>$parent->rgt]);

                        }
                        ArticleCategory::updateAllCounters(['lft'=>$between,'rgt'=>$between,'depth'=>$parent->depth-$model->depth+1],"`id` in (".implode(',',$treeId).")");
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
            $previousArticleCategory = ArticleCategory::findOne(['rgt'=>$model->lft-1]);
            $treeArticleCategory = ArticleCategory::find()->where('`lft` >="'.$model->lft.'" and `rgt` <="'.$model->rgt.'"')->all();

            $treeArticleCategory = ArrayHelper::toArray($treeArticleCategory);
            $treeId = ArrayHelper::getColumn($treeArticleCategory,'id');
            ArticleCategory::updateAllCounters(['lft'=>$model->rgt-$model->lft+1,'rgt'=>$model->rgt-$model->lft+1],'`lft`>=:lft and `rgt`<=:rgt',[':lft'=>$previousArticleCategory->lft,':rgt'=>$previousArticleCategory->rgt]);
            ArticleCategory::updateAllCounters(['lft'=>-($previousArticleCategory->rgt-$previousArticleCategory->lft+1),'rgt'=>-($previousArticleCategory->rgt-$previousArticleCategory->lft+1)],"`id` in (".implode(',',$treeId).")");
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
            $nextArticleCategory = ArticleCategory::findOne(['lft'=>$model->rgt+1]);
            $treeArticleCategory = ArticleCategory::find()->where('`lft` >="'.$model->lft.'" and `rgt` <="'.$model->rgt.'"')->all();
            $treeArticleCategory = ArrayHelper::toArray($treeArticleCategory);
            $treeId = ArrayHelper::getColumn($treeArticleCategory,'id');

            ArticleCategory::updateAllCounters(['lft'=>-($model->rgt-$model->lft+1),'rgt'=>-($model->rgt-$model->lft+1)],'`lft`>=:lft and `rgt`<=:rgt',[':lft'=>$nextArticleCategory->lft,':rgt'=>$nextArticleCategory->rgt]);
            ArticleCategory::updateAllCounters(['lft'=>$nextArticleCategory->rgt-$nextArticleCategory->lft+1,'rgt'=>$nextArticleCategory->rgt-$nextArticleCategory->lft+1],"id in (".implode(',',$treeId).")");
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
     * Deletes an existing ArticleCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();
        try{
            ArticleCategory::deleteAll('lft >=:lft and rgt <=:rgt',[':lft'=>$model->lft,':rgt'=>$model->rgt]);
            ArticleCategory::updateAllCounters(['lft'=>-($model->rgt-$model->lft+1)],'lft>:lft',[':lft'=>$model->lft]);
            ArticleCategory::updateAllCounters(['rgt'=>-($model->rgt-$model->lft+1)],'rgt>:rgt',[':rgt'=>$model->rgt]);
            $transaction->commit();

            Yii::$app->session->setFlash('info','菜单删除成功！');
        }catch(Exception $e) {
            $transaction->rollback();
            Yii::$app->session->setFlash('danger','菜单删除失败！');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the ArticleCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ArticleCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArticleCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
