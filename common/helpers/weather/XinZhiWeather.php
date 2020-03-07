<?php
namespace common\helpers\weather;

use yii\base\BaseObject;

class XinZhiWeather extends BaseObject implements WeatherInterface
{
    protected $xinZhiWeatherCode;

    public function __construct($xinZhiWeatherCode, $config = [])
    {
        $this->xinZhiWeatherCode = $xinZhiWeatherCode;
        parent::__construct($config);
    }
    
    public function getWeather()
    {
        return "心知天气".$this->xinZhiWeatherCode;
    }
}