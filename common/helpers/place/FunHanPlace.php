<?php
namespace common\helpers\place;

use yii\base\BaseObject;

class FunHanPlace extends BaseObject implements PlaceInterface
{
    protected $id;

    public function __construct($id, $config = [])
    {
        $this->id = $id;
        parent::__construct($config);
    }

    public function getPlace()
    {
        return "方瀚：北京市朝阳区".$this->id;
    }
}