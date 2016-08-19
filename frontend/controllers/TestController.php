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
    public function actionLogin()
    {
        print_r(RangerWeb::api('ranger.user.login',[
            'username'=>'13311002524',
            'password'=>'123456',
        ]));
    }

    public function actionList()
    {
        print_r(RangerWeb::api('ranger.article.list',[
            'page_size'=>10,
            'page'=>2,
        ]));
    }
}