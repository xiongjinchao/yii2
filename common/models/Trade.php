<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "{{%trade}}".
 *
 * @property integer $id
 * @property string $trade_no
 * @property integer $user_id
 * @property integer $trade_status
 * @property integer $payment_id
 * @property integer $payment_status
 * @property integer $logistical_status
 * @property string $total_amount
 * @property string $paid_amount
 * @property string $balance_amount
 * @property string $discount_amount
 * @property string $logistical_amount
 * @property string $point_amount
 * @property string $refund_amount
 * @property integer $earn_point
 * @property string $contact_name
 * @property string $contact_phone
 * @property string $contact_address
 * @property string $contact_postcode
 * @property string $user_remark
 * @property integer $cancel_reason
 * @property integer $paid_at
 * @property integer $rated_at
 * @property integer $created_at
 * @property integer $updated_at
 */
class Trade extends \yii\db\ActiveRecord
{
    const TRADE_WAIT_PAY = 1;
    const TRADE_HAS_PAID = 2;
    const TRADE_HAS_CANCEL = 3;
    const TRADE_IS_DOING = 4;
    const TRADE_HAS_REFUND = 5;
    const TRADE_HAS_COMPLETE = 6;

    const PAYMENT_WAIT_PAY = 1;
    const PAYMENT_HAS_PAID = 2;
    const PAYMENT_IS_FAILED = 3;

    const LOGISTICAL_WAIT_EXPRESS = 1;
    const LOGISTICAL_HAS_EXPRESS = 2;
    const LOGISTICAL_TAKE_DELIVERY = 3;
    const LOGISTICAL_REFUSE_DELIVERY = 4;
    const LOGISTICAL_LOST_GOODS = 5;
    const LOGISTICAL_RETURN_GOODS = 6;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%trade}}';
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
            [['user_id', 'trade_status', 'payment_id', 'payment_status', 'logistical_status', 'earn_point', 'cancel_reason', 'paid_at', 'rated_at', 'created_at', 'updated_at'], 'integer'],
            [['trade_status', 'payment_id', 'payment_status', 'user_remark', 'created_at', 'updated_at'], 'required'],
            [['total_amount', 'paid_amount', 'balance_amount', 'discount_amount', 'logistical_amount', 'point_amount', 'refund_amount'], 'number'],
            [['user_remark'], 'string'],
            [['trade_no'], 'string', 'max' => 32],
            [['contact_name'], 'string', 'max' => 64],
            [['contact_phone', 'contact_postcode'], 'string', 'max' => 16],
            [['contact_address'], 'string', 'max' => 255],
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
            'user_id' => '用户编号',
            'trade_status' => '交易状态', //1待付款，2已付款，3已取消，4退款中，5已退款，6已完成
            'payment_id' => '支付凭证编号',
            'payment_status' => '支付状态', //同支付表中的支付状态 1未支付，2已支付，3支付异常
            'logistical_status' => '配送状态', //同物流表中的配送状态 1待发货，2已发货，3已收货，4拒收货，5货物丢失，6已退货
            'total_amount' => '商品总金额',
            'paid_amount' => '已付金额',
            'balance_amount' => '余额支付',
            'discount_amount' => '优惠金额',
            'logistical_amount' => '配送费用',
            'point_amount' => '积分抵用金额',
            'refund_amount' => '退款金额',
            'earn_point' => '获得积分',
            'contact_name' => '收货人姓名',
            'contact_phone' => '收货人手机号',
            'contact_address' => '收货人地址',
            'contact_postcode' => '收货人邮编',
            'user_remark' => '客户备注',
            'cancel_reason' => '取消原因',
            'paid_at' => '支付成功时间',
            'rated_at' => '评价时间',
            'created_at' => '交易创建时间',
            'updated_at' => '交易修改时间',
        ];
    }

    public static function getTradeStatusOptions($trade_status = null)
    {
        $arr = [
            self::TRADE_WAIT_PAY => '待付款',
            self::TRADE_HAS_PAID => '已付款',
            self::TRADE_HAS_CANCEL => '已取消',
            self::TRADE_IS_DOING => '处理中',
            self::TRADE_HAS_REFUND => '已退款',
            self::TRADE_HAS_COMPLETE => '已完成',
        ];
        if( $trade_status === null ){
            return $arr;
        }else{
            return isset($arr[$trade_status]) ? $arr[$trade_status] : $trade_status;
        }
    }

    public static function getPaymentStatusOptions($payment_status = null)
    {
        $arr = [
            self::PAYMENT_WAIT_PAY => '已支付',
            self::PAYMENT_HAS_PAID => '未支付'
        ];
        if( $payment_status === null ){
            return $arr;
        }else{
            return isset($arr[$payment_status]) ? $arr[$payment_status] : $payment_status;
        }
    }

    public static function getLogisticalStatusOptions($logistical_status = null)
    {
        $arr = [
            self::LOGISTICAL_WAIT_EXPRESS => '待发货',
            self::LOGISTICAL_HAS_EXPRESS => '已发货',
            self::LOGISTICAL_TAKE_DELIVERY => '已收货',
            self::LOGISTICAL_REFUSE_DELIVERY => '拒收货',
            self::LOGISTICAL_LOST_GOODS => '货物丢失',
            self::LOGISTICAL_RETURN_GOODS => '已退货',
        ];
        if( $logistical_status === null ){
            return $arr;
        }else{
            return isset($arr[$logistical_status]) ? $arr[$logistical_status] : '无';
        }
    }

    public function getOrders()
    {
        return $this->hasMany(TradeOrder::className(), ['trade_no' => 'trade_no']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
