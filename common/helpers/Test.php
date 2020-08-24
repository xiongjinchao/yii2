<?php

namespace common\helpers;

use Yii;

class Test
{
    public static $count = 0;
    public function __construct($i = 0)
    {
        static::$count += $i;
    }

    public function addOne()
    {
        static::$count += 1;
    }

    public static function addTow()
    {
        static::$count += 2;
    }

    public function addThree()
    {
        (new self())->addOne();
        self::addTow();
    }
}