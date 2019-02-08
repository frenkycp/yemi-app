<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SernoLosstimeView;

/**
 * LineLosstimeDataSearch represents the model behind the search form about `app\models\SernoLosstimeView`.
 */
class LineLosstimeDataSearch extends SernoLosstimeView
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pk', 'line', 'proddate', 'start_time', 'end_time', 'category', 'model'], 'safe'],
            [['mp'], 'integer'],
            [['losstime'], 'number'],
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
        $query = SernoLosstimeView::find()->where([
            '<>', 'category', 'CH'
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                /*'attributes' => [
                    'proddate',
                    'line',
                    'model',
                    'category',
                ],*/
                'defaultOrder' => [
                    'proddate' => SORT_ASC,
                    'line' => SORT_ASC,
                    'model' => SORT_ASC,
                    'category' => SORT_ASC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'mp' => $this->mp,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'losstime' => $this->losstime,
            'line' => $this->line,
        ]);

        $query->andFilterWhere(['like', 'pk', $this->pk])
            ->andFilterWhere(['like', 'proddate', $this->proddate])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'model', $this->model]);

        return $dataProvider;
    }
}