<?php
namespace frontend\controllers;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\di\Container;

class WeatherController extends Controller
{
    public function actionContainer()
    {
        $params = Yii::$app->request->get();

        $container = new Container;

        $container->set('yii\db\Connection',[
            'dsn' => 'mysql:host=127.0.0.1;dbname=gin-blog',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ]);

        //$container->set('common\helpers\place\PlaceInterface', 'common\helpers\place\FunHanPlace',['FunHan_1']);
        /*
        $container->set('common\helpers\place\PlaceInterface',function()use($params){
            // 根据参数设置不同依赖
            $id = ArrayHelper::getValue($params, 'id');
            $xinZhiCityCode = ArrayHelper::getValue($params, 'xinZhiCityCode');
            $baiDuCityCode = '100000';

            if($id > 0){
                $place = new \common\helpers\place\FunHanPlace($id);
            }else if($xinZhiCityCode != ''){
                $place = new \common\helpers\place\XinZhiPlace($xinZhiCityCode);
            }else{
                $place = new \common\helpers\place\BaiDuPlace($baiDuCityCode);
            }
            return $place;
        });
        */
        $container->set('common\helpers\place\PlaceInterface', ['common\helpers\place\PlaceBuilder','build']);
        $container->set('common\helpers\weather\WeatherInterface', 'common\helpers\weather\QiCaiWeather');
        $container->set('resource', 'common\helpers\Resource');

        $resource = $container->get('resource');

        $result[0] = $params;
        $result[1] = $resource->place->getPlace();
        $result[2] = $resource->weather->getWeather();

        return $this->asJson($result);
    }

    public function actionCommon()
    {
        $params = Yii::$app->request->get();

        $id = ArrayHelper::getValue($params, 'id');
        $xinZhiCityCode = ArrayHelper::getValue($params, 'xinZhiCityCode');
        $baiDuCityCode = '100000';

        if($id > 0){
            $place = new \common\helpers\place\FunHanPlace($id);
        }else if($xinZhiCityCode != ''){
            $place = new \common\helpers\place\XinZhiPlace($xinZhiCityCode);
        }else{
            $place = new \common\helpers\place\BaiDuPlace($baiDuCityCode);
        }

        $weather = new \common\helpers\weather\QiCaiWeather();
        $resource = new \common\helpers\Resource($place,$weather);

        $result[0] = $params;
        $result[1] = $resource->place->getPlace();
        $result[2] = $resource->weather->getWeather();

        return $this->asJson($result);
    }
}