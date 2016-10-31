<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ArticleSearch represents the model behind the search form about `backend\modules\content\models\Article`.
 */
class ArticleSearch extends Article
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'category_id', 'content_type', 'audit', 'hot', 'recommend', 'hit'], 'integer'],
            [['title', 'content','source', 'source_url', 'seo_title', 'seo_description', 'author', 'seo_keyword', 'color', 'created_at', 'updated_at'], 'safe'],
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
        $query = Article::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 20],
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

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'content_type' => $this->content_type,
            'audit' => $this->audit,
            'hot' => $this->hot,
            'recommend' => $this->recommend,
            'hit' => $this->hit,
            'color' => $this->color,
        ]);
        if($this->updated_at!=''){
            $query->andWhere('updated_at>=:updated_at_start and updated_at<:updated_at_end',[':updated_at_start'=>strtotime(explode(' - ',$this->updated_at)[0]),':updated_at_end'=>strtotime(explode(' - ',$this->updated_at)[1])]);
        }

        if($this->category_id!=''){
            $query->andFilterWhere(['like', 'category_id', ','.$this->category_id.',']);
        }

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'source', $this->source])
            ->andFilterWhere(['like', 'source_url', $this->source_url])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'seo_description', $this->seo_description])
            ->andFilterWhere(['like', 'seo_keyword', $this->seo_keyword]);

        return $dataProvider;
    }
}
