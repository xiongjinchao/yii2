<?php
namespace api\controllers;

use yii;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        //http://api.yii2.com/?method=ranger.user.get&params[uid]=6218&params[type]=H5&ip=192.168.1.1&timestamp=2015-06-21 17:18:09&key=9XNNXe66zOlSassjSKD5gry9BiN61IUEi8IpJmjBwvU07RXP0J3c4GnhZR3GKhMHa1A&sign=72624458773C56CDA8C5C2896F881011&chanel=IOS&format=json&version=1.0
        $result = $this->runAction('api\modules\v1\TestAction',[]);
        print_r($result);
    }

    public function beforeAction($action)
    {
        echo 'before';
        return parent::beforeAction($action);
    }

    public function afterAction($action)
    {
        print_r($action);
    }

    public function actionTest()
    {
        echo 'test';
    }
}
