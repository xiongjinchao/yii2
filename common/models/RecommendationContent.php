<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%recommendation_content}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $description
 * @property string $code
 * @property string $content
 * @property integer $sort
 * @property integer $created_at
 * @property integer $updated_at
 */
class RecommendationContent extends \yii\db\ActiveRecord
{

    const AUDIT_ENABLE = 1;
    const AUDIT_DISABLE = 0;
    
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
            [['category_id'], 'required'],
            [['category_id', 'sort', 'audit', 'created_at', 'updated_at'], 'integer'],
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
            'id' => '编号',
            'category_id' => '所属分类',
            'title' => '标题',
            'description' => '描述',
            'code' => '代码',
            'content' => '内容',
            'sort' => '排序',
            'audit' => '审核',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    public function getAuditOptions($audit = null)
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

    public function getCategory()
    {
        return $this->hasOne(RecommendationCategory::className(), ['id' => 'category_id']);
    }
}
