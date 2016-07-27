<?php

namespace backend\modules\content\models;

use Yii;

/**
 * This is the model class for table "{{%article_section}}".
 *
 * @property integer $id
 * @property integer $article_id
 * @property string $section_title
 * @property string $section_content
 */
class ArticleSection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_section}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'section_content'], 'required'],
            [['article_id'], 'integer'],
            [['section_content'], 'string'],
            [['section_title'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '段落编号',
            'article_id' => '文章编号',
            'section_title' => '段落标题',
            'section_content' => '段落内容',
        ];
    }
}
