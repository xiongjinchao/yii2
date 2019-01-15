<?php

namespace backend\components\job;

use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class EmailTextJob extends BaseObject implements JobInterface
{
    public $to;
    public $subject;
    public $htmlBody;

    public function execute($queue)
    {
        $mail = Yii::$app->mailer->compose();
        $mail->setTo($this->to);
        $mail->setSubject($this->subject);
        $mail->setHtmlBody($this->htmlBody);
        $mail->send();
    }
}