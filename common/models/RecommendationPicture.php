<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%recommendation_picture}}".
 *
 * @property integer $id
 * @property integer $recommendation_category_id
 * @property integer $recommendation_content_id
 * @property integer $picture_id
 * @property string $picture_title
 * @property integer $sort
 */
class RecommendationPicture extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%recommendation_picture}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recommendation_category_id', 'recommendation_content_id', 'picture_id', 'sort'], 'integer'],
            [['picture_title'], 'string', 'max' => 150],
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
            'recommendation_content_id' => 'Recommendation Content ID',
            'picture_id' => 'Picture ID',
            'picture_title' => 'Picture Title',
            'sort' => 'Sort',
        ];
    }
}
