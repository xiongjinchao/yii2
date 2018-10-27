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
use yii\helpers\Json;

/**
 * AttributeValueController implements the CRUD actions for AttributeValue model.
 */
class AttributeValueController extends Controller
{
    private $auth = '属性值管理';

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
            'query' => AttributeValue::find()->where(['attribute_name_id'=>Yii::$app->request->post('expandRowKey')])->orderBy(['sort'=>SORT_DESC, 'id'=>SORT_ASC]),
            'pagination' => ['pageSize' => 10],
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
            $result = [
                'status' => 'success',
                'data' => ''
            ];
        } else {
            $result = [
                'status' => 'error',
                'data' => $model->getErrors()
            ];
        }
        echo Json::encode($result);
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
        Yii::$app->session->setFlash('info','属性值删除成功！');
        return $this->redirect(['attribute-name/index']);
    }

    public function actionAjaxGetAttributeValue()
    {
        if(Yii::$app->request->isAjax) {
            $data = AttributeValue::getAttributeValueOptions(Yii::$app->request->post('attribute_name_id'));
            $result = [];
            foreach($data as $key => $item){
                $result[] = [
                    'id' => $key,
                    'text' => $item
                ];
            }
            echo Json::encode($result);
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
