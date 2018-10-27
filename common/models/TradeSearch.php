<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Trade;

/**
 * TradeSearch represents the model behind the search form about `common\models\Trade`.
 */
class TradeSearch extends Trade
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'trade_status', 'payment_id', 'payment_status', 'logistical_status', 'earn_point', 'cancel_reason', 'paid_at', 'rated_at', 'created_at', 'updated_at'], 'integer'],
            [['trade_no', 'contact_name', 'contact_phone', 'contact_address', 'contact_postcode', 'user_remark'], 'safe'],
            [['total_amount', 'paid_amount', 'balance_amount', 'discount_amount', 'logistical_amount', 'point_amount', 'refund_amount'], 'number'],
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
        $query = Trade::find();

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
            'trade_status' => $this->trade_status,
            'payment_id' => $this->payment_id,
            'payment_status' => $this->payment_status,
            'logistical_status' => $this->logistical_status,
            'total_amount' => $this->total_amount,
            'paid_amount' => $this->paid_amount,
            'balance_amount' => $this->balance_amount,
            'discount_amount' => $this->discount_amount,
            'logistical_amount' => $this->logistical_amount,
            'point_amount' => $this->point_amount,
            'refund_amount' => $this->refund_amount,
            'earn_point' => $this->earn_point,
            'cancel_reason' => $this->cancel_reason,
            'paid_at' => $this->paid_at,
            'rated_at' => $this->rated_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'trade_no', $this->trade_no])
            ->andFilterWhere(['like', 'contact_name', $this->contact_name])
            ->andFilterWhere(['like', 'contact_phone', $this->contact_phone])
            ->andFilterWhere(['like', 'contact_address', $this->contact_address])
            ->andFilterWhere(['like', 'contact_postcode', $this->contact_postcode])
            ->andFilterWhere(['like', 'user_remark', $this->user_remark]);

        return $dataProvider;
    }
}
