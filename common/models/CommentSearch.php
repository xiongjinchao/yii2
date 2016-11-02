<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CommentSearch represents the model behind the search form about `backend\modules\content\models\Comment`.
 */
class CommentSearch extends Comment
{

    public $onlyShowParent = false;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'user_id', 'model_id', 'created_at', 'updated_at'], 'integer'],
            [['model_name', 'content'], 'safe'],
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
        $query = Comment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10],
            'sort'=>[
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        if($this->onlyShowParent){
            $query->andWhere('parent_id=:parent_id',[':parent_id'=>0]);
        }else{
            $query->andFilterWhere(['parent_id' => $this->parent_id]);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            //'parent_id' => $this->parent_id,
            'user_id' => $this->user_id,
            'model_name' => $this->model_name,
            'model_id' => $this->model_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
