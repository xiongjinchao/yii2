<?php
namespace api\controllers;

use yii;
use yii\helpers\Json;
use api\components\RangerException;

/**
 * Site controller
 */
class SiteController extends RangerController
{
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

    //http://api.yii2.com/?method=ranger.user.list&params[uid]=6218&params[page]=2&ip=192.168.1.1&timestamp=1470362650&key=9XNNXe66zOlSassjSKD5gry9BiN61IUEi8IpJmjBwvU07RXP0J3c4GnhZR3GKhMHa1A&sign=7AC10545EC3380508EC1AF8D950380A5&device_id=100010&device=computer&origin=html5&format=json&version=1.0

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $method = Yii::$app->request->post('method');
        $method = explode('.',$method);
        $version = explode('.',Yii::$app->request->post('version'))[0];
        $params['query'] = Yii::$app->request->post('params');
        $params['query'] = empty($params['query'])?[]:$params['query'];

        $params['version'] = Yii::$app->request->post('version');
        $params['device'] = Yii::$app->request->post('device');
        $params['device_id'] = Yii::$app->request->post('device_id');
        $params['origin'] = Yii::$app->request->post('origin');
        $params['timestamp'] = Yii::$app->request->post('timestamp');
        $params['ip'] = Yii::$app->request->post('ip');
        $params['agent'] = Yii::$app->request->post('agent');

        try {
            $data = Yii::$app->runAction('/v'.$version.'/'.$method[1].'/'.$method[2],['params'=>$params]);
            $result = [
                'status' => 'success',
                'code' => '0',
                'data' => $data
            ];
        }catch (\Exception $e){
            $result = [
                'status' => 'error',
                'code' => $e->getCode(),
                'data' => $e->getMessage()
            ];
        }
        return $result;
    }

    public function beforeAction($action)
    {
        if(!Yii::$app->request->post('sign')){
            RangerException::throwException(RangerException::EMPTY_SIGN);
        }
        $query = Yii::$app->request->post();
        $sign = $query['sign'];
        unset($query['sign']);

        if(isset(Yii::$app->params['device'][$query['device']][$query['origin']]) && Yii::$app->params['device'][$query['device']][$query['origin']]['key'] == $query['key']){
            $query['secret'] = Yii::$app->params['device'][$query['device']][$query['origin']]['secret'];
        }else{
            RangerException::throwException(RangerException::ERROR_SECRET);
        }

        ksort($query['params']);
        ksort($query);

        $query = http_build_query($query);
        if($sign === strtoupper(md5($query))) {
            return parent::beforeAction($action);
        }else{
            RangerException::throwException(RangerException::ERROR_SIGN);
        }
    }

    public function afterAction($action, $result)
    {
        echo Json::encode($result);
    }

}
