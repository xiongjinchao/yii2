<?php
namespace common\helpers\weather;

use yii\base\BaseObject;

class QiCaiWeather extends BaseObject implements WeatherInterface
{
    function getWeather()
    {
        return "七彩天气";
    }
}