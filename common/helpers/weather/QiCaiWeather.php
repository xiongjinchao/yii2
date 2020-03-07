<?php
namespace common\helpers\weather;

use yii\base\BaseObject;

class QiCaiWeather extends BaseObject implements WeatherInterface
{
    protected $qiCaiWeatherCode;

    public function __construct($qiCaiWeatherCode, $config = [])
    {
        $this->qiCaiWeatherCode = $qiCaiWeatherCode;
        parent::__construct($config);
    }

    public function getWeather()
    {
        return "七彩天气".$this->qiCaiWeatherCode;
    }
}