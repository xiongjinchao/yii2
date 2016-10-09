<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%recommendation_content}}".
 *
 * @property integer $id
 * @property integer $recommendation_category_id
 * @property string $title
 * @property string $description
 * @property string $code
 * @property string $content
 * @property integer $created_at
 * @property integer $updated_at
 */
class RecommendationContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%recommendation_content}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recommendation_category_id', 'content', 'created_at', 'updated_at'], 'required'],
            [['recommendation_category_id', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['title', 'description', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'recommendation_category_id' => 'Recommendation Category ID',
            'title' => 'Title',
            'description' => 'Description',
            'code' => 'Code',
            'content' => 'Content',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
