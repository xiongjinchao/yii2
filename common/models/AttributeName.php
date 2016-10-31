<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%attribute_name}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $audit
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class AttributeName extends \yii\db\ActiveRecord
{
    const AUDIT_ENABLE = 1;
    const AUDIT_DISABLE = 0;

    const STATUS_SPU = 0;
    const STATUS_SKU = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%attribute_name}}';
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
            [['audit', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'name' => '属性名称',
            'audit' => '审核',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    public static function getAuditOptions($audit = null)
    {
        $arr = [
            self::AUDIT_ENABLE => '已审核',
            self::AUDIT_DISABLE => '未审核',
        ];
        if( $audit === null ){
            return $arr;
        }else{
            return isset($arr[$audit]) ? $arr[$audit] : $audit;
        }
    }

    public static function getStatusOptions($status = null)
    {
        $arr = [
            self::STATUS_SPU => 'SPU',
            self::STATUS_SKU => 'SKU',
        ];
        if( $status === null ){
            return $arr;
        }else{
            return isset($arr[$status]) ? $arr[$status] : $status;
        }
    }
}
