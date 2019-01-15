<?php

namespace backend\components\job;

use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class EmailHtmlJob extends BaseObject implements JobInterface

{
    public $to;
    public $subject;
    public $template;
    public $params;

    public function execute($queue)
    {
        $mail = Yii::$app->mailer->compose();
        $mail->setTo($this->to);
        $mail->setSubject($this->subject);
        $mail = Yii::$app->mailer->compose($this->template, $this->parmas);
        $mail->send();
    }
}