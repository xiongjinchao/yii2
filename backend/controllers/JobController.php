<?php

namespace backend\controllers;

use Yii;
use backend\components\job\DownloadJob;
use backend\components\job\EmailTextJob;
use backend\components\job\EmailHtmlJob;

/**
 * JobController
 */
class JobController extends Controller
{
    public function actionDownload()
    {
        $id = Yii::$app->queue->push(new DownloadJob([
            'url' => 'http://www.baidu.com/img/baidu_jgylogo3.gif',
            'file' => Yii::getAlias('@uploads').'/job.jpg',
        ]));
        echo '成功加入队列，当前ID为'.$id;
    }

    public function actionEmailText()
    {
        $id = Yii::$app->queue->push(new EmailTextJob([
            'to' => '67218027@qq.com',
            'subject' => 'Welcome',
            'htmlBody' => 'Welcome to china'
        ]));
        echo '成功加入队列，当前ID为'.$id;
    }

    public function actionEmailHtml()
    {
        $id = Yii::$app->queue->push(new EmailHtmlJob([
            'to' => 'xiongjinchao@hotmail.com',
            'subject' => 'Welcome',
            'template' => 'register_success',
            'params' => ['key' => 'value']
        ]));
        echo '成功加入队列，当前ID为'.$id;
    }
}