<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'weibo' => [
                    'class' => 'common\components\authClients\Weibo',
                    'clientId' => 'wb_key',
                    'clientSecret' => 'wb_secret',
                ],
                'github' => [
                    'class' => 'yii\authclient\clients\GitHub',
                    'clientId' => 'github_appid',
                    'clientSecret' => 'github_appkey',
                ],
                'qq' => [
                    'class' => 'common\components\authClients\QQ',
                    'clientId' => 'qq_appid',
                    'clientSecret' => 'qq_appkey',
                ],
                /*
                'wechat' => [
                    'class' => 'common\components\authClients\WeChat',
                    'clientId' => 'weixin_appid',
                    'clientSecret' => 'weixin_appkey',
                ],
                */
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
