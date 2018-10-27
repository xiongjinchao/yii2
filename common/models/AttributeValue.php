<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%attribute_value}}".
 *
 * @property integer $id
 * @property integer $attribute_name_id
 * @property string $value
 * @property integer $sort
 * @property integer $created_at
 * @property integer $updated_at
 */
class AttributeValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%attribute_value}}';
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
            [['attribute_name_id', 'value'], 'required'],
            [['attribute_name_id', 'sort'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['value'], 'unique'],
            ['sort', 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'attribute_name_id' => '所属属性',
            'value' => '属性值',
            'sort' => '排序',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    public static function getAttributeValueOptions($attribute_name_id)
    {
        $arr = self::find()->where(['attribute_name_id'=>$attribute_name_id])->orderBy(['id'=>SORT_DESC])->all();
        return ArrayHelper::map($arr, 'id', 'value');
    }
}
