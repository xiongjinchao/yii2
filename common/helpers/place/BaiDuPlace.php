<?php
namespace common\helpers\place;

use yii\base\BaseObject;

class BaiDuPlace extends BaseObject implements PlaceInterface
{
    public $baiDuCityCode;

    public function __construct($baiDuCityCode, $config = [])
    {
        $this->baiDuCityCode = $baiDuCityCode;
        parent::__construct($config);
    }

    function getPlace()
    {
        return "百度：北京市朝阳区".$this->baiDuCityCode;
    }
}