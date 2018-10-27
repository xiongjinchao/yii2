<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Goods;

/**
 * GoodsSearch represents the model behind the search form about `common\models\Goods`.
 */
class GoodsSearch extends Goods
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'audit', 'sale_mode', 'goods_type',  'presell', 'picture_id', 'hit', 'created_at', 'updated_at'], 'integer'],
            [['name', 'color', 'content', 'origin_price', 'sale_price', 'sale_url', 'seo_title', 'seo_description', 'seo_keyword'], 'safe'],
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
        $query = Goods::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'audit' => $this->audit,
            'sale_mode' => $this->sale_mode,
            'goods_type' => $this->goods_type,
            'presell' => $this->presell,
            'color' => $this->color,
        ]);

        if($this->created_at!=''){
            $query->andWhere('created_at>=:created_at_start and created_at<:created_at_end',[':created_at_start'=>strtotime(explode(' - ',$this->created_at)[0]),':created_at_end'=>strtotime(explode(' - ',$this->created_at)[1])]);
        }

        if($this->updated_at!=''){
            $query->andWhere('updated_at>=:updated_at_start and updated_at<:updated_at_end',[':updated_at_start'=>strtotime(explode(' - ',$this->updated_at)[0]),':updated_at_end'=>strtotime(explode(' - ',$this->updated_at)[1])]);
        }

        if($this->category_id!=''){
            $query->andFilterWhere(['like', 'category_id', ','.$this->category_id.',']);
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'seo_description', $this->seo_description])
            ->andFilterWhere(['like', 'seo_keyword', $this->seo_keyword]);

        return $dataProvider;
    }
}
