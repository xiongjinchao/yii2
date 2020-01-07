<?php
namespace common\helpers\place;

use yii\base\BaseObject;

class BaiDuPlace extends BaseObject implements PlaceInterface
{
    function getPlace()
    {
        return "百度：北京市朝阳区";
    }
}