<?php
namespace frontend\controllers;

use yii;
use yii\web\Controller;
use common\components\ranger\RangerWeb;

/**
 * Site controller
 */
class TestController extends Controller
{
    public function actionIndex()
    {
        print_r(RangerWeb::api('ranger.user.list',[
            'username'=>'13311002524',
            'password'=>'123456',
            'token'=>'123',
        ]));
    }
}