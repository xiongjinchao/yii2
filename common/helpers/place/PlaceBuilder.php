<?php
namespace common\helpers\place;

use yii\helpers\ArrayHelper;

class PlaceBuilder {

    public static function build($params)
    {
        $id = ArrayHelper::getValue($params, 'id',1);
        $xinZhiCityCode = ArrayHelper::getValue($params, 'xinZhiCityCode',2);
        $baiDuCityCode = 3;

        if($id > 0){
            $place = new FunHanPlace($id);
        }else if($xinZhiCityCode != ''){
            $place = new XinZhiPlace($xinZhiCityCode);
        }else{
            $place = new BaiDuPlace($baiDuCityCode);
        }
        return $place;
    }
}