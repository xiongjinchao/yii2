<?php

namespace backend\modules\product\controllers;

use common\models\AttributeName;
use yii;
use common\models\AttributeValue;
use backend\controllers\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

/**
 * AttributeValueController implements the CRUD actions for AttributeValue model.
 */
class AttributeValueController extends Controller
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
     * Lists all AttributeValue models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AttributeValue::find()->where(['attribute_name_id'=>Yii::$app->request->post('expandRowKey')])->orderBy(['sort'=>SORT_DESC]),
            'pagination' => ['pageSize' => 20],
        ]);
        $model = new AttributeValue();
        $model->attribute_name_id = Yii::$app->request->post('expandRowKey');
        $attributeName = AttributeName::findOne($model->attribute_name_id);

        return $this->renderAjax('_index', [
            'model' => $model,
            'attributeName' => $attributeName,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new AttributeValue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSave($id = null)
    {
        if($id == null) {
            $model = new AttributeValue();
            $model->loadDefaultValues();
        }else{
            $model = $this->findModel($id);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('info','属性值保存成功！');
        } else {
            Yii::$app->session->setFlash('danger','属性值保存失败！');
        }
        return $this->redirect(['attribute-name/index']);
    }

    /**
     * Deletes an existing AttributeValue model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('info','属性值删除失败！');
        return $this->redirect(['attribute-name/index']);
    }

    /**
     * Finds the AttributeValue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AttributeValue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AttributeValue::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
