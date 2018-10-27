<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%recommendation_category}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $tag
 * @property integer $lft
 * @property integer $rgt
 * @property integer $parent
 * @property integer $depth
 * @property string $description
 * @property integer $audit
 * @property integer $created_at
 * @property integer $updated_at
 */
class RecommendationCategory extends \yii\db\ActiveRecord
{

    const AUDIT_ENABLE = 1;
    const AUDIT_DISABLE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%recommendation_category}}';
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
            [['lft', 'rgt', 'parent', 'depth', 'audit'], 'integer'],
            [['name', 'tag', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'name' => '名称',
            'tag' => '标示',
            'lft' => '左值',
            'rgt' => '右值',
            'parent' => '所属推荐',
            'depth' => '深度',
            'description' => '描述',
            'audit' => '审核',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    public function getSpace()
    {
        $space = '';
        $lastBrother = $this->getLastBrother();
        $space.= str_repeat('┃ ',$this->depth-1);
        $space.=$this->id == $lastBrother->id?'┗ ':'┣ ';
        return $space;
    }

    public function getParent()
    {
        if($this->parent>0){
            return RecommendationCategory::findOne($this->parent);
        }else{
            return new Page();
        }
    }

    public function getLastBrother()
    {
        return RecommendationCategory::find()->where(['parent'=>$this->parent,'depth'=>$this->depth])->orderBy('`rgt` DESC')->one();
    }

    public static function getRecommendationCategoryOptions()
    {
        $arr = [];
        $recommendationCategories = RecommendationCategory::find()->orderBy(['lft'=>SORT_ASC])->all();
        foreach($recommendationCategories as $recommendationCategory){
            $arr[$recommendationCategory->id] = $recommendationCategory->getSpace().$recommendationCategory->name;
        }
        return $arr;
    }

    public static function getAuditOptions($audit = null)
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
}
