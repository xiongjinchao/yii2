<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%goods_attribute}}".
 *
 * @property integer $id
 * @property integer $goods_id
 * @property integer $attribute_name_id
 * @property integer $attribute_value_id
 * @property string $origin_price
 * @property string $sale_price
 * @property integer $stock
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class GoodsAttribute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_attribute}}';
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
            [['goods_id', 'attribute_name_id', 'attribute_value_id', 'created_at', 'updated_at'], 'required'],
            [['goods_id', 'attribute_name_id', 'attribute_value_id', 'stock', 'status'], 'integer'],
            [['origin_price', 'sale_price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'SKU编号',
            'goods_id' => '商品ID',
            'attribute_name_id' => '属性编号',
            'attribute_value_id' => '属性值',
            'origin_price' => '市场价',
            'sale_price' => '售价',
            'stock' => '库存',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间'
        ];
    }
}
