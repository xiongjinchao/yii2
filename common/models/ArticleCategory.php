<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%article_category}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $action
 * @property integer $lft
 * @property integer $rgt
 * @property integer $parent
 * @property integer $depth
 * @property integer $audit
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_keyword
 * @property integer $created_at
 * @property integer $updated_at
 */
class ArticleCategory extends \yii\db\ActiveRecord
{
    const AUDIT_ENABLE = 1;
    const AUDIT_DISABLE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_category}}';
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
            ['name', 'required'],
            [['lft', 'rgt', 'parent', 'depth', 'audit'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['action'], 'string', 'max' => 50],
            [['seo_title', 'seo_description', 'seo_keyword'], 'string', 'max' => 255]
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
            'action' => '标示',
            'lft' => '左值',
            'rgt' => '右值',
            'parent' => '所属菜单',
            'depth' => '深度',
            'audit' => '审核',
            'seo_title' => 'SEO标题',
            'seo_description' => 'SEO描述',
            'seo_keyword' => 'SEO关键字',
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
            return ArticleCategory::findOne($this->parent);
        }else{
            return new ArticleCategory();
        }
    }

    public function getLastBrother()
    {
        return ArticleCategory::find()->where(['parent'=>$this->parent,'depth'=>$this->depth])->orderBy('`rgt` DESC')->one();
    }

    public static function getArticleCategoryOptions()
    {
        $arr = [];
        $articleCategories = ArticleCategory::find()->orderBy(['lft'=>SORT_ASC])->all();
        foreach($articleCategories as $articleCategory){
            $arr[$articleCategory->id] = $articleCategory->getSpace().$articleCategory->name;
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

