<?php
namespace common\helpers\weather;

use yii\helpers\ArrayHelper;

class Weather implements WeatherInterface
{
    protected $weather;

    public function __construct(array $params)
    {
        $xinZhiWeatherCode = ArrayHelper::getValue($params, 'xinZhiWeatherCode',1);
        $qiCaiWeatherCode = ArrayHelper::getValue($params, 'qiCaiWeatherCode',2);

        if($xinZhiWeatherCode){
            $this->weather = new XinZhiWeather($xinZhiWeatherCode);
        }else{
            $this->weather = new QiCaiWeather($qiCaiWeatherCode);
        }
    }

    public function getWeather()
    {
        return $this->weather->getWeather();
    }
}