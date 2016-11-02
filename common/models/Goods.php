<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%goods}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $category_id
 * @property string $content
 * @property integer $audit
 * @property integer $hot
 * @property integer $recommend
 * @property integer $hit
 * @property string $color
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_keyword
 * @property integer $created_at
 * @property integer $updated_at
 */
class Goods extends \yii\db\ActiveRecord
{
    const AUDIT_ENABLE = 1;
    const AUDIT_DISABLE = 0;

    const HOT_ENABLE = 1;
    const HOT_DISABLE = 0;

    const RECOMMEND_ENABLE = 1;
    const RECOMMEND_DISABLE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods}}';
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
            [['name', 'category_id'], 'required'],
            [['category_id', 'audit', 'hot', 'recommend', 'hit', 'created_at', 'updated_at'], 'integer'],
            [['color','content'], 'string'],
            [['name', 'seo_title', 'seo_description', 'seo_keyword'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '商品编号',
            'name' => '商品名称',
            'category_id' => '所属分类',
            'content' => '商品详情',
            'audit' => '审核状态',
            'hot' => '热门状态',
            'recommend' => '推荐状态',
            'color' => '标记颜色',
            'hit' => '点击次数',
            'seo_title' => 'SEO标题',
            'seo_description' => 'SEO描述',
            'seo_keyword' => 'SEO关键字',
            'created_at' => '创建时间',
            'updated_at' => '更新时间'
        ];
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

    public static function getHotOptions($hot = null)
    {
        $arr = [
            self::HOT_ENABLE => '已置热',
            self::HOT_DISABLE => '未置热',
        ];
        if( $hot === null ){
            return $arr;
        }else{
            return isset($arr[$hot]) ? $arr[$hot] : $hot;
        }
    }

    public static function getRecommendOptions($recommend = null)
    {
        $arr = [
            self::RECOMMEND_ENABLE => '已推荐',
            self::RECOMMEND_DISABLE => '未推荐',
        ];
        if( $recommend === null ){
            return $arr;
        }else{
            return isset($arr[$recommend]) ? $arr[$recommend] : $recommend;
        }
    }

    public static function getColorOptions()
    {
        $arr = [
            "white", "black", "grey", "silver", "gold", "brown",
            "red", "orange", "yellow", "indigo", "maroon", "pink",
            "blue", "green", "violet", "cyan", "magenta", "purple"
        ];
        return $arr;
    }

    public function getCategory()
    {
        return $this->hasOne(GoodsCategory::className(), ['id' => 'category_id']);
    }
}
