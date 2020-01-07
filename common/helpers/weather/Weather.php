<?php
namespace common\helpers\weather;

use yii\base\BaseObject;
use common\helpers\place\PlaceInterface;

class Weather extends BaseObject
{
    public $place;
    public $weather;

    public function __construct(PlaceInterface $place, WeatherInterface $weather, $config = [])
    {
        $this->place = $place;
        $this->weather = $weather;
        parent::__construct($config);
    }
}