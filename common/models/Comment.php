<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $model_name
 * @property integer $model_id
 * @property string $content
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $parent_id
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
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
            [['parent_id', 'user_id', 'model_id', 'audit'], 'integer'],
            [['content'], 'string'],
            [['model_name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '评论编号',
            'parent_id' => '所属评论',
            'user_id' => '用户编号',
            'model_name' => '模型名称',
            'model_id' => '模型编号',
            'content' => '评论内容',
            'audit' => '审核',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['parent_id' => 'id']);
    }
}
