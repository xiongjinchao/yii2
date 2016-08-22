<?php
namespace frontend\controllers;

use yii;
use yii\web\Controller;
use common\components\ranger\RangerWeb;

/**
 * Site controller
 */
class RangerController extends Controller
{
    public function actionUserLogin()
    {
        print_r(RangerWeb::api('ranger.user.login',[
            'username'=>'STARR',
            'password'=>'123456',
        ]));
    }

    public function actionUserList()
    {
        print_r(RangerWeb::api('ranger.user.list',[
            'page_size' => 10,
            'page' => 1,
            'where' => [
                ['id'=>12],
                ['<>','id',10]
            ],
        ]));
    }

    public function actionUserCreate()
    {
        print_r(RangerWeb::api('ranger.user.create',[
            'username' => 'STARR',
            'password' => '123456',
            'email' => '67218315@qq.com',
            'mobile' => '18600945045',
        ]));
    }

    public function actionArticleList()
    {
        print_r(RangerWeb::api('ranger.article.list',[
            'page_size' => 10,
            'page' => 1,
            'where' => [
                ['id'=>12],
                ['<>','id',10]
            ],
        ]));
    }
}