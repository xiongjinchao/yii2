<?php
namespace common\helpers\place;

use yii\helpers\ArrayHelper;

class Place implements PlaceInterface
{
    protected $place;

    public function __construct(array $params)
    {
        $id = ArrayHelper::getValue($params, 'id',1);
        $xinZhiCityCode = ArrayHelper::getValue($params, 'xinZhiCityCode',2);
        $baiDuCityCode = 3;

        if($id > 0){
            $this->place = new FunHanPlace($id);
        }else if($xinZhiCityCode != ''){
            $this->place = new XinZhiPlace($xinZhiCityCode);
        }else{
            $this->place = new BaiDuPlace($baiDuCityCode);
        }
    }

    public function getPlace()
    {
        return $this->place->getPlace();
    }
}