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
    private $auth = '文章分类管理';

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
        if(Yii::$app->request->isPost) {
            $old = $model->oldAttributes;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $parentId = Yii::$app->request->post('ArticleCategory')['parent'];
                if ($parentId == $old['parent']) {
                    $model->load(Yii::$app->request->post());
                    $model->save();
                } else if ($parentId == 0) {
                    $tree = ArrayHelper::getColumn(ArticleCategory::find()->where('`lft` >="' . $model->lft . '" and `rgt` <="' . $model->rgt . '"')->asArray()->all(), 'id');
                    ArticleCategory::updateAllCounters(['lft' => -($model->rgt - $model->lft + 1)], '`lft`>:lft', [':lft' => $model->rgt]);
                    ArticleCategory::updateAllCounters(['rgt' => -($model->rgt - $model->lft + 1)], '`rgt`>:rgt', [':rgt' => $model->rgt]);
                    $max = ArticleCategory::find()->where(['not in', 'id', $tree])->orderBy('`rgt` DESC')->one();
                    ArticleCategory::updateAllCounters(['lft' => $max->rgt - $model->lft + 1, 'rgt' => $max->rgt - $model->lft + 1, 'depth' => -($model->depth - 1)], ['in', 'id', $tree]);
                    $model->load(Yii::$app->request->post());
                    $model->save();
                } else {
                    $parent = ArticleCategory::findOne($parentId);
                    $exist = ArticleCategory::find()->where('`lft` <:lft and `rgt` >:rgt and `id` = :id', [':lft' => $model->lft, ':rgt' => $model->rgt, ':id' => $parent->id])->one();
                    $tree = ArrayHelper::getColumn(ArticleCategory::find()->where('`lft` >="' . $model->lft . '" and `rgt` <="' . $model->rgt . '"')->asArray()->all(), 'id');
                    if (empty($tree) || in_array($parent->id, $tree)) {
                        Yii::$app->session->setFlash('danger', '信息提交失败！');
                        return $this->redirect(['index']);
                    }
                    if ($exist == null) {
                        if ($parent->lft > $model->lft) {
                            ArticleCategory::updateAllCounters(['lft' => -($model->rgt - $model->lft + 1)], '`lft`>:lft and `lft`<' . $parent->rgt, [':lft' => $model->rgt]);
                            ArticleCategory::updateAllCounters(['rgt' => -($model->rgt - $model->lft + 1)], '`rgt`>:rgt and `rgt`<' . $parent->rgt, [':rgt' => $model->rgt]);
                            ArticleCategory::updateAllCounters(['lft' => $parent->rgt - $model->rgt - 1, 'rgt' => $parent->rgt - $model->rgt - 1, 'depth' => $parent->depth - $model->depth + 1], ['in', 'id', $tree]);
                        } else {
                            ArticleCategory::updateAllCounters(['lft' => $model->rgt - $model->lft + 1], '`lft`>:lft and `lft`<' . $model->lft, [':lft' => $parent->rgt]);
                            ArticleCategory::updateAllCounters(['rgt' => $model->rgt - $model->lft + 1], '`rgt`>=:rgt and `rgt`<' . $model->lft, [':rgt' => $parent->rgt]);
                            ArticleCategory::updateAllCounters(['lft' => $parent->rgt - $model->lft, 'rgt' => $parent->rgt - $model->lft, 'depth' => $parent->depth - $model->depth + 1], ['in', 'id', $tree]);
                        }
                        $model->load(Yii::$app->request->post());
                        $model->save();
                    } else {
                        $oldParent =  ArticleCategory::findOne($old['parent']);
                        ArticleCategory::updateAllCounters(['lft' => -($model->rgt - $model->lft + 1),'rgt' => -($model->rgt - $model->lft + 1)], '`lft`>'.$model->lft.' and `rgt` < '.$oldParent->rgt);
                        ArticleCategory::updateAllCounters(['rgt' => -($model->rgt - $model->lft + 1)], '`lft`<'.$oldParent->lft.' and `rgt` < '.$parent->rgt.' and  `rgt` > '.$oldParent->rgt);
                        ArticleCategory::updateAllCounters(['lft' => -($model->rgt - $model->lft + 1),'rgt' => -($model->rgt - $model->lft + 1)], '`lft`>'.$oldParent->lft.' and `rgt` < '.$parent->rgt.' and  `rgt` > '.$oldParent->rgt);
                        ArticleCategory::updateAllCounters(['rgt' => -($model->rgt - $model->lft + 1)], '`id`=:id', [':id' => $oldParent->id]);
                        ArticleCategory::updateAllCounters(['lft' => $parent->rgt - $model->rgt-1, 'rgt' => $parent->rgt - $model->rgt-1, 'depth' => ($parent->depth - $model->depth + 1)], ['in', 'id', $tree]);
                        $model->load(Yii::$app->request->post());
                        $model->save();
                    }
                }
                $transaction->commit();
                Yii::$app->session->setFlash('info', '信息提交成功！');
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::$app->session->setFlash('danger', '信息提交失败！');
            }
            return $this->redirect(['index']);
        }else {
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
            $tree = ArrayHelper::getColumn(ArticleCategory::find()->where('`lft` >="' . $model->lft . '" and `rgt` <="' . $model->rgt . '"')->asArray()->all(), 'id');
            ArticleCategory::updateAllCounters(['lft'=>$model->rgt-$model->lft+1,'rgt'=>$model->rgt-$model->lft+1],'`lft`>=:lft and `rgt`<=:rgt',[':lft'=>$previousArticleCategory->lft,':rgt'=>$previousArticleCategory->rgt]);
            ArticleCategory::updateAllCounters(['lft'=>-($previousArticleCategory->rgt-$previousArticleCategory->lft+1),'rgt'=>-($previousArticleCategory->rgt-$previousArticleCategory->lft+1)],['in', 'id', $tree]);
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
            $tree = ArrayHelper::getColumn(ArticleCategory::find()->where('`lft` >="' . $model->lft . '" and `rgt` <="' . $model->rgt . '"')->asArray()->all(), 'id');

            ArticleCategory::updateAllCounters(['lft'=>-($model->rgt-$model->lft+1),'rgt'=>-($model->rgt-$model->lft+1)],'`lft`>=:lft and `rgt`<=:rgt',[':lft'=>$nextArticleCategory->lft,':rgt'=>$nextArticleCategory->rgt]);
            ArticleCategory::updateAllCounters(['lft'=>$nextArticleCategory->rgt-$nextArticleCategory->lft+1,'rgt'=>$nextArticleCategory->rgt-$nextArticleCategory->lft+1],['in', 'id', $tree]);
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

            Yii::$app->session->setFlash('info','分类删除成功！');
        }catch(Exception $e) {
            $transaction->rollback();
            Yii::$app->session->setFlash('danger','分类删除失败！');
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
