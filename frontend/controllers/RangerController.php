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
    public function actionRangerScript()
    {
        $method = Yii::$app->request->post('method');
        $params = Yii::$app->request->post('params');
        $params['format'] = 'json';
        echo RangerWeb::api($method,$params);
        Yii::$app->end();
    }

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
                //['id'=>12],
                ['<>','id',10]
            ],
            'access_token' => '0mcZIy285iWeFXiJV9ArhrMQinlMcCwZ',
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

    public function actionUserUpdate()
    {
        print_r(RangerWeb::api('ranger.user.update',[
            'username' => 'STARR',
            'access_token' => '0mcZIy285iWeFXiJV9ArhrMQinlMcCwZ',
        ]));
    }

    public function actionUserDelete()
    {
        print_r(RangerWeb::api('ranger.user.delete',[
            'username' => 'STARR',
            'access_token' => '0mcZIy285iWeFXiJV9ArhrMQinlMcCwZ',
        ]));
    }

    public function actionArticleList()
    {
        print_r(RangerWeb::api('ranger.article.list',[
            'page_size' => 10,
            'page' => 1,
            'where' => [
                //['id'=>12],
                ['<>','id',10]
            ],
        ]));
    }

    public function actionArticleDetail()
    {
        print_r(RangerWeb::api('ranger.article.detail',[
            'where'=>[
                'id' => 1
            ]
        ]));
    }

    public function actionArticleCategoryList()
    {
        print_r(RangerWeb::api('ranger.article-category.list',[]));
    }
}