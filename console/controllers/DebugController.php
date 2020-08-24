<?php

namespace console\controllers;

use common\helpers\Test;
use Yii;
use yii\console\Controller;

class DebugController extends Controller
{
    public function actionTest()
    {
        $a = new Test(1);
        $a->addOne();
        $a::addTow();
        print_r($a::$count."\n");

        $b = new Test(1);
        $b::addTow();
        print_r($b::$count."\n");
    }

    public function actionTest2()
    {
        $b = new Test(1);
        $b->addThree();
        print_r($b::$count);

        $a = new Test(1);
        $a->addOne();
        print_r($a::$count);
    }
}