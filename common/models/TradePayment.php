<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%trade_payment}}".
 *
 * @property integer $id
 * @property string $trade_no
 * @property string $channel
 * @property string $paid_amount
 * @property string $subject
 * @property string $body
 * @property string $meta
 * @property string $transaction_no
 * @property integer $payment_status
 * @property string $failure_code
 * @property string $failure_message
 * @property string $client_ip
 * @property integer $created_at
 * @property integer $paid_at
 * @property integer $expire_at
 */
class TradePayment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%trade_payment}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trade_no', 'paid_amount', 'meta', 'transaction_no', 'failure_code', 'failure_message'], 'required'],
            [['paid_amount'], 'number'],
            [['meta'], 'string'],
            [['payment_status', 'created_at', 'paid_at', 'expire_at'], 'integer'],
            [['trade_no', 'client_ip'], 'string', 'max' => 32],
            [['channel'], 'string', 'max' => 100],
            [['subject', 'body', 'failure_message'], 'string', 'max' => 255],
            [['transaction_no', 'failure_code'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trade_no' => '交易编号',
            'channel' => '支付渠道',
            'paid_amount' => '支付金额',
            'subject' => '支付标题',
            'body' => '支付描述',
            'meta' => '支付元数据',
            'transaction_no' => '交易流水号',
            'payment_status' => '支付状态', //支付状态，1未支付，2已支付，3支付异常
            'failure_code' => '失败编号',
            'failure_message' => '失败消息',
            'client_ip' => '客户端IP',
            'created_at' => '发起支付时间',
            'paid_at' => '支付成功时间',
            'expire_at' => '支付过期时间',
        ];
    }
}
