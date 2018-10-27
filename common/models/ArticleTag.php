<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%article_tag}}".
 *
 * @property integer $id
 * @property integer $article_id
 * @property integer $tag_id
 * @property integer $total
 * @property integer $created_at
 * @property integer $updated_at
 */
class ArticleTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_tag}}';
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
            [['id', 'article_id', 'tag_id'], 'required'],
            [['id', 'article_id', 'tag_id', 'total'], 'integer'],
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
            'tag_id' => '标签编号',
            'total' => '数量',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }
}
