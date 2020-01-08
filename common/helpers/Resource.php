<?php
namespace common\helpers;

use yii\base\BaseObject;
use common\helpers\place\PlaceInterface;
use common\helpers\weather\WeatherInterface;

class Resource extends BaseObject
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