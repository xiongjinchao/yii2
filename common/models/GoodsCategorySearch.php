<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

const AUDIT_ENABLE = 1;
const AUDIT_DISABLE = 0;

/**
 * This is the model class for table "{{%goods_category}}".
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
class GoodsCategorySearch extends GoodsCategory
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lft', 'rgt', 'parent', 'depth', 'audit'], 'integer'],
            [['name', 'action', 'seo_title', 'seo_description', 'seo_keyword', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = GoodsCategory::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 20],
            'sort'=>[
                'defaultOrder' => [
                    'lft' => SORT_ASC,
                ]
            ]
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'audit' => $this->audit,
            'parent' => $this->parent,
            'depth' => $this->depth,
        ]);

        if($this->created_at!=''){
            $query->andWhere('created_at>=:created_at_start and created_at<:created_at_end',[':created_at_start'=>strtotime(explode(' - ',$this->created_at)[0]),':created_at_end'=>strtotime(explode(' - ',$this->created_at)[1])]);
        }

        if($this->updated_at!=''){
            $query->andWhere('updated_at>=:updated_at_start and updated_at<:updated_at_end',[':updated_at_start'=>strtotime(explode(' - ',$this->updated_at)[0]),':updated_at_end'=>strtotime(explode(' - ',$this->updated_at)[1])]);
        }

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'action', $this->action]);
        return $dataProvider;
    }
}
