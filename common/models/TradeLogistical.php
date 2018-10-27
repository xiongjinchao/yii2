<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%trade_logistical}}".
 *
 * @property integer $id
 * @property string $trade_no
 * @property integer $order_id
 * @property string $logistical_name
 * @property integer $logistical_no
 * @property integer $logistical_status
 * @property integer $created_at
 * @property integer $update_at
 */
class TradeLogistical extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%trade_logistical}}';
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
            [['trade_no', 'order_id', 'logistical_name', 'logistical_no', 'created_at', 'update_at'], 'required'],
            [['order_id', 'logistical_no', 'logistical_status', 'created_at', 'update_at'], 'integer'],
            [['trade_no'], 'string', 'max' => 50],
            [['logistical_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trade_no' => '交易单号',
            'order_id' => '订单号',
            'logistical_name' => '物流名称',
            'logistical_no' => '物流单号',
            'logistical_status' => '物流状态', //1待发货，2已发货，3已收货，4拒收货，5货物丢失，6已退货
            'created_at' => '创建时间',
            'update_at' => '更新时间',
        ];
    }
}
