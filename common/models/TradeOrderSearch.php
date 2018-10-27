<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TradeOrder;

/**
 * TradeOrderSearch represents the model behind the search form about `common\models\TradeOrder`.
 */
class TradeOrderSearch extends TradeOrder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'product_id', 'picture_id', 'sku_id', 'num', 'activity_id', 'created_at', 'updated_at'], 'integer'],
            [['trade_no', 'product_name', 'picture_url', 'sku_name'], 'safe'],
            [['price', 'subtotal', 'discount'], 'number'],
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
        $query = TradeOrder::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'picture_id' => $this->picture_id,
            'sku_id' => $this->sku_id,
            'price' => $this->price,
            'num' => $this->num,
            'subtotal' => $this->subtotal,
            'activity_id' => $this->activity_id,
            'discount' => $this->discount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'trade_no', $this->trade_no])
            ->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'picture_url', $this->picture_url])
            ->andFilterWhere(['like', 'sku_name', $this->sku_name]);

        return $dataProvider;
    }
}
