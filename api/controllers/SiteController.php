<?php
namespace api\controllers;

use yii;
use yii\helpers\Json;
use yii\helpers\Inflector;
use api\components\RangerException;

/**
 * Site controller
 */
class SiteController extends RangerController
{
    const CACHE = false;
    const CACHE_TIME = 60*30;

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $method = Yii::$app->request->post('method');
        $method = explode('.',Inflector::camel2id($method));
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
        $params['cache'] = (bool)Yii::$app->request->post('cache', self::CACHE);
        $params['cache_time'] = Yii::$app->request->post('cache_time', self::CACHE_TIME);

        try {
            $data = $this->execute($method, $version ,$params);
            $result = [
                'status' => 'success',
                'code' => '0',
                'data' => $data['data'],
                'cache' => $data['cache'],
            ];
        } catch (RangerException $e) {
            $result = [
                'status' => 'error',
                'code' => $e->getCode(),
                'data' => $e->getMessage()
            ];
        }
        return $result;
    }

    private function execute($method, $version ,$params)
    {
        if($params['cache'] == true ) {
            $key = implode('.',$method).'#'.$version.'#'.md5(json_encode($params['query']));
            if(Yii::$app->cache->exists($key)) {
                $result['data'] = Yii::$app->cache->get($key);
                $result['cache'] = $params['cache'];
            }else{
                $result['data'] = Yii::$app->runAction('/v' . $version . '/' . $method[1] . '/' . $method[2], ['params' => $params]);
                Yii::$app->cache->set($key, $result['data'], $params['cache_time']);
                $result['cache'] = self::CACHE;
            }
        } else {
            $result['data'] = Yii::$app->runAction('/v' . $version . '/' . $method[1] . '/' . $method[2], ['params' => $params]);
            $result['cache'] = self::CACHE;
        }
        return $result;
    }

    public function beforeAction($action)
    {
        if(!Yii::$app->request->post('sign')){
            RangerException::throwException(RangerException::SYS_EMPTY_SIGN,'',401);
        }
        $params = Yii::$app->request->post();
        $sign = $params['sign'];
        unset($params['sign']);

        if(isset(Yii::$app->params['device'][$params['device']][$params['origin']]) && Yii::$app->params['device'][$params['device']][$params['origin']]['key'] == $params['key']){
            $query['secret'] = Yii::$app->params['device'][$params['device']][$params['origin']]['secret'];
        }else{
            RangerException::throwException(RangerException::SYS_ERROR_SECRET,'',401);
        }
        if(!empty($params['params'])) {
            ksort($params['params']);
        }
        ksort($params);

        $query = http_build_query($params);
        if($sign === strtoupper(md5($query))) {
            return parent::beforeAction($action);
        }else{
            RangerException::throwException(RangerException::SYS_ERROR_SIGN,'',401);
        }
    }

    public function afterAction($action, $result)
    {
        echo Json::encode($result);
    }

}
