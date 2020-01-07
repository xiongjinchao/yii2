<?php
namespace common\helpers\weather;

use yii\base\BaseObject;

class XinZhiWeather extends BaseObject implements WeatherInterface
{
    function getWeather()
    {
        return "心知天气";
    }
}