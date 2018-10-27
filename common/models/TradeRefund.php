<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%trade_refund}}".
 *
 * @property integer $id
 * @property string $order_no
 * @property integer $payment_id
 * @property string $refund_reson
 * @property string $refund_amount
 * @property integer $refund_status
 * @property string $meta
 * @property string $transaction_no
 * @property string $client_ip
 * @property string $failure_code
 * @property string $failure_message
 * @property integer $created_at
 * @property integer $refunded_at
 */
class TradeRefund extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%trade_refund}}';
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
            [['order_no', 'payment_id', 'refund_reson', 'refund_amount', 'meta', 'transaction_no', 'client_ip', 'failure_code', 'failure_message'], 'required'],
            [['payment_id', 'refund_status', 'created_at', 'refunded_at'], 'integer'],
            [['refund_amount'], 'number'],
            [['meta'], 'string'],
            [['order_no', 'transaction_no', 'client_ip'], 'string', 'max' => 100],
            [['refund_reson', 'failure_message'], 'string', 'max' => 255],
            [['failure_code'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_no' => '交易编号',
            'payment_id' => '支付凭证编号',
            'refund_reson' => '退款原因',
            'refund_amount' => '退款金额',
            'refund_status' => '退款状态：1客户申请，2退款处理中，3退款成功，4退款失败',
            'meta' => '退款元数据',
            'transaction_no' => '退款流水号',
            'client_ip' => '客户端IP',
            'failure_code' => '退款失败编号',
            'failure_message' => '退款失败消息',
            'created_at' => '创建时间',
            'refunded_at' => '退款时间',
        ];
    }
}
