<?php

namespace backend\modules\content\controllers;

use Yii;
use common\models\RecommendationCategory;
use common\models\RecommendationCategorySearch;
use backend\controllers\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\db\Exception;

/**
 * RecommendationCategoryController implements the CRUD actions for RecommendationCategory model.
 */
class RecommendationCategoryController extends Controller
{
    private $auth = '菜单管理';

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
     * Lists all RecommendationCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->request->post('hasEditable')) {
            $model = $this->findModel(Yii::$app->request->post('editableKey'));
            if ($model->load( $_POST ) && $model->load( ['RecommendationCategory' => current($_POST['RecommendationCategory'])] ) && $model->save()) {
                $result = ['output'=>'', 'message'=>''];
                Yii::$app->session->setFlash('info','推荐分类更新成功！');
            }else{
                $result = ['output'=>'', 'message'=> current($model->getFirstErrors())];
                Yii::$app->session->setFlash('danger','推荐分类更新失败！');
            }
            echo Json::encode($result);
            Yii::$app->end();
        }

        $searchModel = new RecommendationCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new RecommendationCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RecommendationCategory();

        if ($model->load(Yii::$app->request->post())) {

            if($model->parent > 0){
                $parent = RecommendationCategory::findOne($model->parent);
                RecommendationCategory::updateAllCounters(['lft'=>2],'`lft`>=:lft',[':lft'=>$parent->rgt]);
                RecommendationCategory::updateAllCounters(['rgt'=>2],'`rgt`>=:rgt',[':rgt'=>$parent->rgt]);
                $model->lft = $parent->rgt;
                $model->rgt = $parent->rgt+1;
                $model->depth = $parent->depth+1;
            }else{
                $max = RecommendationCategory::find()->orderBy('`rgt` DESC')->one();
                $model->parent = 0;
                $model->lft = $max!=''?$max->rgt+1:1;
                $model->rgt = $max!=''?$max->rgt+2:2;
                $model->depth = 1;
            }

            if($model->save()){
                Yii::$app->session->setFlash('info','推荐创建成功！');
                return $this->redirect(['update', 'id' => $model->id]);
            }else{
                Yii::$app->session->setFlash('danger','推荐创建失败！');
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing RecommendationCategory model.
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
                $parentId = Yii::$app->request->post('RecommendationCategory')['parent'];
                if ($parentId == $old['parent']) {
                    $model->load(Yii::$app->request->post());
                    $model->save();
                } else if ($parentId == 0) {
                    $tree = ArrayHelper::getColumn(RecommendationCategory::find()->where('`lft` >="' . $model->lft . '" and `rgt` <="' . $model->rgt . '"')->asArray()->all(), 'id');
                    RecommendationCategory::updateAllCounters(['lft' => -($model->rgt - $model->lft + 1)], '`lft`>:lft', [':lft' => $model->rgt]);
                    RecommendationCategory::updateAllCounters(['rgt' => -($model->rgt - $model->lft + 1)], '`rgt`>:rgt', [':rgt' => $model->rgt]);
                    $max = RecommendationCategory::find()->where(['not in', 'id', $tree])->orderBy('`rgt` DESC')->one();
                    RecommendationCategory::updateAllCounters(['lft' => $max->rgt - $model->lft + 1, 'rgt' => $max->rgt - $model->lft + 1, 'depth' => -($model->depth - 1)], ['in', 'id', $tree]);
                    $model->load(Yii::$app->request->post());
                    $model->save();
                } else {
                    $parent = RecommendationCategory::findOne($parentId);
                    $exist = RecommendationCategory::find()->where('`lft` <:lft and `rgt` >:rgt and `id` = :id', [':lft' => $model->lft, ':rgt' => $model->rgt, ':id' => $parent->id])->one();
                    $tree = ArrayHelper::getColumn(RecommendationCategory::find()->where('`lft` >="' . $model->lft . '" and `rgt` <="' . $model->rgt . '"')->asArray()->all(), 'id');
                    if (empty($tree) || in_array($parent->id, $tree)) {
                        Yii::$app->session->setFlash('danger', '信息提交失败！');
                        return $this->redirect(['index']);
                    }
                    if ($exist == null) {
                        if ($parent->lft > $model->lft) {
                            RecommendationCategory::updateAllCounters(['lft' => -($model->rgt - $model->lft + 1)], '`lft`>:lft and `lft`<' . $parent->rgt, [':lft' => $model->rgt]);
                            RecommendationCategory::updateAllCounters(['rgt' => -($model->rgt - $model->lft + 1)], '`rgt`>:rgt and `rgt`<' . $parent->rgt, [':rgt' => $model->rgt]);
                            RecommendationCategory::updateAllCounters(['lft' => $parent->rgt - $model->rgt - 1, 'rgt' => $parent->rgt - $model->rgt - 1, 'depth' => $parent->depth - $model->depth + 1], ['in', 'id', $tree]);
                        } else {
                            RecommendationCategory::updateAllCounters(['lft' => $model->rgt - $model->lft + 1], '`lft`>:lft and `lft`<' . $model->lft, [':lft' => $parent->rgt]);
                            RecommendationCategory::updateAllCounters(['rgt' => $model->rgt - $model->lft + 1], '`rgt`>=:rgt and `rgt`<' . $model->lft, [':rgt' => $parent->rgt]);
                            RecommendationCategory::updateAllCounters(['lft' => $parent->rgt - $model->lft, 'rgt' => $parent->rgt - $model->lft, 'depth' => $parent->depth - $model->depth + 1], ['in', 'id', $tree]);
                        }
                        $model->load(Yii::$app->request->post());
                        $model->save();
                    } else {
                        $oldParent =  RecommendationCategory::findOne($old['parent']);
                        RecommendationCategory::updateAllCounters(['lft' => -($model->rgt - $model->lft + 1),'rgt' => -($model->rgt - $model->lft + 1)], '`lft`>'.$model->lft);
                        RecommendationCategory::updateAllCounters(['rgt' => -($model->rgt - $model->lft + 1)], '`lft`<'.$oldParent->lft.' and `rgt` < '.$parent->rgt.' and  `rgt` > '.$oldParent->rgt);
                        RecommendationCategory::updateAllCounters(['lft' => -($model->rgt - $model->lft + 1),'rgt' => -($model->rgt - $model->lft + 1)], '`lft`>'.$oldParent->lft.' and `rgt` < '.$parent->rgt.' and  `rgt` > '.$oldParent->rgt);
                        RecommendationCategory::updateAllCounters(['rgt' => -($model->rgt - $model->lft + 1)], '`id`=:id', [':id' => $oldParent->id]);
                        RecommendationCategory::updateAllCounters(['lft' => $parent->rgt - $model->rgt-1, 'rgt' => $parent->rgt - $model->rgt-1, 'depth' => ($parent->depth - $model->depth + 1)], ['in', 'id', $tree]);
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
            $previousRecommendationCategory = RecommendationCategory::findOne(['rgt'=>$model->lft-1]);
            $tree = ArrayHelper::getColumn(RecommendationCategory::find()->where('`lft` >="' . $model->lft . '" and `rgt` <="' . $model->rgt . '"')->asArray()->all(), 'id');
            RecommendationCategory::updateAllCounters(['lft'=>$model->rgt-$model->lft+1,'rgt'=>$model->rgt-$model->lft+1],'`lft`>=:lft and `rgt`<=:rgt',[':lft'=>$previousRecommendationCategory->lft,':rgt'=>$previousRecommendationCategory->rgt]);
            RecommendationCategory::updateAllCounters(['lft'=>-($previousRecommendationCategory->rgt-$previousRecommendationCategory->lft+1),'rgt'=>-($previousRecommendationCategory->rgt-$previousRecommendationCategory->lft+1)],['in', 'id', $tree]);
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
            $nextRecommendationCategory = RecommendationCategory::findOne(['lft'=>$model->rgt+1]);
            $tree = ArrayHelper::getColumn(RecommendationCategory::find()->where('`lft` >="' . $model->lft . '" and `rgt` <="' . $model->rgt . '"')->asArray()->all(), 'id');
            RecommendationCategory::updateAllCounters(['lft'=>-($model->rgt-$model->lft+1),'rgt'=>-($model->rgt-$model->lft+1)],'`lft`>=:lft and `rgt`<=:rgt',[':lft'=>$nextRecommendationCategory->lft,':rgt'=>$nextRecommendationCategory->rgt]);
            RecommendationCategory::updateAllCounters(['lft'=>$nextRecommendationCategory->rgt-$nextRecommendationCategory->lft+1,'rgt'=>$nextRecommendationCategory->rgt-$nextRecommendationCategory->lft+1],['in', 'id', $tree]);
            $transaction->commit();

            Yii::$app->session->setFlash('info','排序提交成功！');

        }catch(Exception $e) {
            $transaction->rollback();
            Yii::$app->session->setFlash('danger','排序提交失败！');
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
     * Deletes an existing RecommendationCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();
        try{
            RecommendationCategory::deleteAll('lft >=:lft and rgt <=:rgt',[':lft'=>$model->lft,':rgt'=>$model->rgt]);
            RecommendationCategory::updateAllCounters(['lft'=>-($model->rgt-$model->lft+1)],'lft>:lft',[':lft'=>$model->lft]);
            RecommendationCategory::updateAllCounters(['rgt'=>-($model->rgt-$model->lft+1)],'rgt>:rgt',[':rgt'=>$model->rgt]);
            $transaction->commit();

            Yii::$app->session->setFlash('info','推荐删除成功！');
        }catch(Exception $e) {
            $transaction->rollback();
            Yii::$app->session->setFlash('danger','推荐删除失败！');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the RecommendationCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RecommendationCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RecommendationCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
