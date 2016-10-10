<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%recommendation_picture}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $content_id
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
            [['category_id', 'content_id', 'picture_id', 'sort'], 'integer'],
            [['picture_title'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'category_id' => '所属分类',
            'content_id' => '所属推荐',
            'picture_id' => '图片编号',
            'picture_title' => '图片标题',
            'sort' => '排序',
        ];
    }
}
