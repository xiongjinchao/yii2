<?php

namespace common\models;

use yii;
use backend\models\Picture;

/**
 * This is the model class for table "{{%article_section_picture}}".
 *
 * @property integer $id
 * @property integer $article_id
 * @property integer $section_id
 * @property integer $picture_id
 * @property string $picture_title
 */
class ArticleSectionPicture extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_section_picture}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'section_id', 'picture_id','sort'], 'integer'],
            [['picture_title'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'article_id' => '文章编号',
            'section_id' => '段落编号',
            'picture_id' => '图片编号',
            'picture_title' => '图片标题',
            'sort' => '排序',
        ];
    }

    public function getPicture()
    {
        return $this->hasOne(Picture::className(), ['id' => 'picture_id']);
    }

    public function getSection()
    {
        return $this->hasOne(ArticleSection::className(), ['id' => 'section_id']);
    }

    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }
}
