<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use yii\di\Container;

class WeatherController extends Controller
{
    public function actionQuery()
    {
        $params = Yii::$app->request->get();

        $container = new Container;

        $container->set('common\helpers\place\PlaceInterface', 'common\helpers\place\FunHanPlace');
        $container->set('common\helpers\weather\WeatherInterface', 'common\helpers\weather\QiCaiWeather');

        $container->set('weather', 'common\helpers\weather\Weather');
        $weather = $container->get('weather');

        $result[0] = $params;
        $result[1] = $weather->place->getPlace();
        $result[2] = $weather->weather->getWeather();

        return $this->asJson($result);
    }
}