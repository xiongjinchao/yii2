<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%page}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $action
 * @property integer $lft
 * @property integer $rgt
 * @property integer $parent
 * @property integer $depth
 * @property string $content
 * @property integer $audit
 * @property integer $visible
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_keyword
 * @property integer $created_at
 * @property integer $updated_at
 */
class Page extends \yii\db\ActiveRecord
{
    const AUDIT_ENABLE = 1;
    const AUDIT_DISABLE = 0;

    const VISIBLE_ENABLE = 1;
    const VISIBLE_DISABLE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page}}';
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
            [['lft', 'rgt', 'parent', 'depth', 'audit', 'visible'], 'integer'],
            [['content'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['link'], 'string', 'max' => 200],
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
            'link' => '链接',
            'lft' => '左值',
            'rgt' => '右值',
            'parent' => '所属页面',
            'depth' => '深度',
            'content' => '内容',
            'audit' => '审核',
            'visible' => '可见',
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
            return Page::findOne($this->parent);
        }else{
            return new Page();
        }
    }

    public function getLastBrother()
    {
        return Page::find()->where(['parent'=>$this->parent,'depth'=>$this->depth])->orderBy('`rgt` DESC')->one();
    }

    public function getPageOptions()
    {
        $arr = [];
        $pages = Page::find()->orderBy(['lft'=>SORT_ASC])->all();
        foreach($pages as $page){
            $arr[$page->id] = $page->getSpace().$page->name;
        }
        return $arr;
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

    public function getVisibleOptions($visible = null)
    {
        $arr = [
            self::AUDIT_ENABLE => '显示',
            self::AUDIT_DISABLE => '隐藏',
        ];
        if( $visible === null ){
            return $arr;
        }else{
            return isset($arr[$visible]) ? $arr[$visible] : $visible;
        }
    }
}

