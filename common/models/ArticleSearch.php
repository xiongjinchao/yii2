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

    public $startTime;
    public $endTime;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'category_id', 'content_type', 'audit', 'hot', 'recommend', 'hit', 'created_at', 'updated_at'], 'integer'],
            [['title', 'content','source', 'source_url', 'seo_title', 'seo_description', 'author', 'seo_keyword'], 'safe'],
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
            // $query->where('0=1');
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
        ]);

        if($this->startTime!='' && $this->endTime!=''){
            $query->andWhere('created_at>=:startTime and created_at<:endTime',[':startTime'=>strtotime($this->startTime),':endTime'=>strtotime($this->endTime)]);
        }else{
            if($this->startTime!=''){
                $query->andWhere('created_at>=:startTime',[':startTime'=>strtotime($this->startTime)]);
            }else if($this->endTime!=''){
                $query->andWhere('created_at<:endTime',[':endTime'=>strtotime($this->endTime)]);
            }
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
