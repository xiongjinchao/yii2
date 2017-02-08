<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use backend\models\Picture;

/**
 * This is the model class for table "{{%goods}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $category_id
 * @property string $content
 * @property integer $audit
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
    const AUDIT_DISABLE = 0;
    const AUDIT_ENABLE = 1;

    const SALE_MODE_APP = 0;
    const SALE_MODE_OUTSIDE = 1;

    const GOODS_TYPE_MATTER = 0;
    const GOODS_TYPE_VIRTUAL = 1;
    const GOODS_TYPE_CARD = 2;

    const PRESELL_DISABLE = 0;
    const PRESELL_ENABLE = 1;

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
            [['category_id', 'sale_mode', 'goods_type', 'presell', 'picture_id', 'audit', 'hot', 'recommend', 'hit', 'stock'], 'integer'],
            [['color', 'content', 'sale_url', 'picture_url'], 'string'],
            [['origin_price','sale_price'], 'double'],
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
            'sale_mode' => '售卖方式',
            'goods_type' => '商品类型',
            'presell' => '预售商品',
            'origin_price' => '商品原价',
            'sale_price' => '商品售价',
            'picture_id' => '商品主图',
            'picture_url' => '商品主图',
            'sale_url' => '购买地址',
            'audit' => '上架状态',
            'color' => '标记颜色',
            'hit' => '点击次数',
            'stock' => '总库存',
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
            self::AUDIT_ENABLE => '上架',
            self::AUDIT_DISABLE => '下架',
        ];
        if( $audit === null ){
            return $arr;
        }else{
            return isset($arr[$audit]) ? $arr[$audit] : $audit;
        }
    }

    public static function getSaleModeOptions($mode = null)
    {
        $arr = [
            self::SALE_MODE_APP => '应用内部',
            self::SALE_MODE_OUTSIDE => '应用外部',
        ];
        if( $mode === null ){
            return $arr;
        }else{
            return isset($arr[$mode]) ? $arr[$mode] : $mode;
        }
    }

    public static function getGoodsTypeOptions($type = null)
    {
        $arr = [
            self::GOODS_TYPE_MATTER => '实物商品',
            self::GOODS_TYPE_VIRTUAL => '虚拟商品',
            self::GOODS_TYPE_CARD => '电子卡券',
        ];
        if( $type === null ){
            return $arr;
        }else{
            return isset($arr[$type]) ? $arr[$type] : $type;
        }
    }

    public static function getPresellOptions($presell = null)
    {
        $arr = [
            self::PRESELL_DISABLE => '非预售',
            self::PRESELL_ENABLE => '预售商品',
        ];
        if( $presell === null ){
            return $arr;
        }else{
            return isset($arr[$presell]) ? $arr[$presell] : $presell;
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

    public function getPicture()
    {
        return $this->hasOne(Picture::className(), ['id' => 'picture_id']);
    }
}
