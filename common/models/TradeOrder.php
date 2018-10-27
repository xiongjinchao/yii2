<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use backend\models\Picture;

/**
 * This is the model class for table "{{%trade_order}}".
 *
 * @property integer $id
 * @property string $trade_no
 * @property integer $user_id
 * @property integer $product_id
 * @property string $product_name
 * @property integer $picture_id
 * @property string $picture_url
 * @property integer $sku_id
 * @property string $sku_name
 * @property string $price
 * @property integer $num
 * @property string $subtotal
 * @property integer $activity_id
 * @property double $discount
 * @property integer $created_at
 * @property integer $updated_at
 */
class TradeOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%trade_order}}';
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
            [['trade_no', 'user_id'], 'required'],
            [['user_id', 'product_id', 'picture_id', 'sku_id', 'num', 'activity_id', 'created_at', 'updated_at'], 'integer'],
            [['price', 'subtotal', 'discount'], 'number'],
            [['trade_no'], 'string', 'max' => 32],
            [['product_name', 'picture_url'], 'string', 'max' => 255],
            [['sku_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '订单编号',
            'trade_no' => '交易编号',
            'user_id' => '用户编号',
            'product_id' => '产品编号',
            'product_name' => '商品名称',
            'picture_id' => '商品主图编号',
            'picture_url' => '商品主图',
            'sku_id' => 'SKU',
            'sku_name' => 'SKU名称',
            'price' => '单价',
            'num' => '数量',
            'subtotal' => '小计',
            'activity_id' => '活动编号',
            'discount' => '折扣',
            'created_at' => '创建订单时间',
            'updated_at' => '订单修改时间',
        ];
    }

    public function getTrade()
    {
        return $this->hasOne(Trade::className(), ['trade_no' => 'trade_no']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getPicture()
    {
        return $this->hasOne(Picture::className(), ['id' => 'picture_id']);
    }

    public function getLogistical()
    {
        return $this->hasOne(TradeLogistical::className(), ['order_id' => 'id']);
    }
}
