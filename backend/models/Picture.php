<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%picture}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $category
 * @property string $url
 * @property integer $width
 * @property integer $height
 * @property string $type
 * @property string $ratio
 * @property string $path
 * @property integer $file_size
 * @property integer $status
 * @property integer $source
 * @property integer $user_id
 * @property integer $created_at
 */
class Picture extends \yii\db\ActiveRecord
{
    const STATUS_ENABLE = 0;
    const STATUS_DISABLE = 1;

    const SOURCE_BACKEND = 0;
    const SOURCE_FRONTEND = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%picture}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'type', 'path'], 'required'],
            [['width', 'height', 'file_size', 'status', 'source', 'user_id', 'created_at'], 'integer'],
            [['ratio'], 'number'],
            [['name', 'category', 'type'], 'string', 'max' => 50],
            [['url', 'path'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '图片编号',
            'name' => '图片名称',
            'category' => '图片分类',
            'url' => '链接',
            'width' => '宽度',
            'height' => '高度',
            'type' => '图片类型',
            'ratio' => '宽高比例',
            'path' => '保存路径',
            'file_size' => '图片大小',
            'status' => '状态',           //0有效1无效
            'source' => '前/后台',         //0后台1前台
            'user_id' => '上传图片者的ID',
            'created_at' => '创建时间',
        ];
    }
}
