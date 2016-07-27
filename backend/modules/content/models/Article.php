<?php

namespace backend\modules\content\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $menu_id
 * @property integer $category_id
 * @property string $content
 * @property integer $audit
 * @property integer $hot
 * @property integer $recommend
 * @property integer $hit
 * @property string $source
 * @property string $source_url
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_keyword
 * @property integer $created_at
 * @property integer $updated_at
 */
class Article extends \yii\db\ActiveRecord
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
        return '{{%article}}';
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
            [['user_id','hit'], 'default', 'value' => 0],
            [['audit', 'hot', 'recommend', 'hit', 'user_id'], 'integer'],
            [['content'], 'string'],
            [['author'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 200],
            [['source_url'], 'string', 'max' => 150],
            [['source'], 'string', 'max' => 100],
            [['author', 'seo_title', 'seo_description', 'seo_keyword'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '文章编号',
            'title' => '文章标题',
            'category_id' => '所属分类',
            'content' => '文章内容',
            'audit' => '审核状态',
            'hot' => '热门状态',
            'recommend' => '推荐状态',
            'hit' => '点击次数',
            'user_id' => '作者编号',
            'author' => '来源作者',
            'source' => '文章来源',
            'source_url' => '来源链接',
            'seo_title' => 'SEO标题',
            'seo_description' => 'SEO描述',
            'seo_keyword' => 'SEO关键字',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',

            'startTime' => '开始时间',
            'endTime' => '结束时间',
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

    public function getHotOptions($hot = null)
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

    public function getRecommendOptions($recommend = null)
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

    public function getArticleCategoryValues()
    {
        $str = '';
        if($this->category_id){
            $category_id = explode(',',trim($this->category_id,','));
            $articleCategories = ArticleCategory::find()->all();
            foreach($articleCategories as $articleCategory){
                if(in_array($articleCategory->id,$category_id)){
                    $str.=$articleCategory->name.' ';
                }
            }
        }
        return $str;
    }
}
