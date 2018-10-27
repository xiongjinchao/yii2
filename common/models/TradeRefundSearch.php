<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TradeRefund;

/**
 * TradeRefundSearch represents the model behind the search form about `common\models\TradeRefund`.
 */
class TradeRefundSearch extends TradeRefund
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'payment_id', 'refund_status', 'created_at', 'refunded_at'], 'integer'],
            [['order_no', 'refund_reson', 'meta', 'transaction_no', 'client_ip', 'failure_code', 'failure_message'], 'safe'],
            [['refund_amount'], 'number'],
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
        $query = TradeRefund::find();

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
            'payment_id' => $this->payment_id,
            'refund_amount' => $this->refund_amount,
            'refund_status' => $this->refund_status,
            'created_at' => $this->created_at,
            'refunded_at' => $this->refunded_at,
        ]);

        $query->andFilterWhere(['like', 'order_no', $this->order_no])
            ->andFilterWhere(['like', 'refund_reson', $this->refund_reson])
            ->andFilterWhere(['like', 'meta', $this->meta])
            ->andFilterWhere(['like', 'transaction_no', $this->transaction_no])
            ->andFilterWhere(['like', 'client_ip', $this->client_ip])
            ->andFilterWhere(['like', 'failure_code', $this->failure_code])
            ->andFilterWhere(['like', 'failure_message', $this->failure_message]);

        return $dataProvider;
    }
}
