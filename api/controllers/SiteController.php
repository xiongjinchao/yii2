<?php
namespace api\controllers;

use yii;
use yii\web\Controller;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    //http://api.yii2.com/?method=ranger.user.list&params[uid]=6218&params[page]=2&ip=192.168.1.1&timestamp=1470362650&key=9XNNXe66zOlSassjSKD5gry9BiN61IUEi8IpJmjBwvU07RXP0J3c4GnhZR3GKhMHa1A&sign=34A4C639B15718F3D8AF12EEE2B1BD47&device_id=100010&device_type=IOS&format=json&version=1.0

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $method = Yii::$app->request->get('method');
        $method = explode('.',$method);
        $version = explode('.',Yii::$app->request->get('version'))[0];
        $params = Yii::$app->request->get('params');
        $params = empty($params)?[]:$params;
        $params['version'] = Yii::$app->request->get('version');
        $params['device_type'] = Yii::$app->request->get('device_type');
        $params['device_id'] = Yii::$app->request->get('device_id');
        $params['timestamp'] = Yii::$app->request->get('timestamp');
        $params['ip'] = Yii::$app->request->get('ip');

        try {
            $data = Yii::$app->runAction('/v'.$version.'/'.$method[1].'/'.$method[2],['params'=>$params]);
            $result = [
                'status' => 'success',
                'code' => '0',
                'data' => $data
            ];
        }catch (\Exception $e){
            $result = [
                'status' => 'success',
                'code' => '0',
                'data' => $e->getMessage()
            ];
        }
        return $result;
    }


    public function beforeAction($action)
    {
        $query = Yii::$app->request->get();
        if(!isset($query['sign'])){
            throw new NotFoundHttpException();
        }
        $secret = '27e1be4fdcaa83d7f61c489994ff6ed6';

        $query['secret'] = $secret;
        $sign = $query['sign'];
        unset($query['sign']);

        ksort($query['params']);
        ksort($query);

        $query = http_build_query($query);
        if($sign === strtoupper(md5($query))) {
            return parent::beforeAction($action);
        }else{
            throw new NotFoundHttpException();
        }
    }

    public function afterAction($action,$result)
    {
        echo Json::encode($result);
    }

}
