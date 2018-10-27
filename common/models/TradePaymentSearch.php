<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TradePayment;

/**
 * TradePaymentSearch represents the model behind the search form about `common\models\TradePayment`.
 */
class TradePaymentSearch extends TradePayment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'payment_status', 'created_at', 'paid_at', 'expire_at'], 'integer'],
            [['trade_no', 'channel', 'subject', 'body', 'meta', 'transaction_no', 'failure_code', 'failure_message', 'client_ip'], 'safe'],
            [['paid_amount'], 'number'],
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
        $query = TradePayment::find();

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
            'paid_amount' => $this->paid_amount,
            'payment_status' => $this->payment_status,
            'created_at' => $this->created_at,
            'paid_at' => $this->paid_at,
            'expire_at' => $this->expire_at,
        ]);

        $query->andFilterWhere(['like', 'trade_no', $this->trade_no])
            ->andFilterWhere(['like', 'channel', $this->channel])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'meta', $this->meta])
            ->andFilterWhere(['like', 'transaction_no', $this->transaction_no])
            ->andFilterWhere(['like', 'failure_code', $this->failure_code])
            ->andFilterWhere(['like', 'failure_message', $this->failure_message])
            ->andFilterWhere(['like', 'client_ip', $this->client_ip]);

        return $dataProvider;
    }
}
