<?php
namespace common\helpers\place;

use yii\base\BaseObject;

class XinZhiPlace extends BaseObject implements PlaceInterface
{
    protected $xinZhiCityCode;

    public function __construct($xinZhiCityCode, $config = [])
    {
        $this->xinZhiCityCode = $xinZhiCityCode;
        parent::__construct($config);
    }

    public function getPlace()
    {
        return "心知：北京市朝阳区".$this->xinZhiCityCode;
    }
}