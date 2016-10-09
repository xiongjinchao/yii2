<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%recommendation_category}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $title
 * @property string $tag
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 */
class RecommendationCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%recommendation_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'created_at', 'updated_at'], 'required'],
            [['parent_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'tag', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'title' => 'Title',
            'tag' => 'Tag',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
