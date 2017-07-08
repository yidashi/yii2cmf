<?php

namespace backend\models\search;

use common\models\Comment;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Comment represents the model behind the search form about `common\models\Article`.
 */
class CommentSearch extends Comment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'entity_id', 'user_id'], 'integer'],
            [['entity'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied.
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
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
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
            'entity' => $this->entity,
            'entity_id' => $this->entity_id,
            'user_id' => $this->user_id,
        ]);

        return $dataProvider;
    }
}
