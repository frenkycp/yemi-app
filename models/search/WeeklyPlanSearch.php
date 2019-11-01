<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WeeklySummaryView;

/**
* WeeklyPlanSearch represents the model behind the search form about `app\models\WeeklySummaryView`.
*/
class WeeklyPlanSearch extends WeeklySummaryView
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['week', 'week_no', 'plan_qty', 'actual_qty', 'balance_qty', 'flag'], 'integer'],
            [['category', 'period'], 'safe'],
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
$query = WeeklySummaryView::find();

$dataProvider = new ActiveDataProvider([
    'query' => $query,
    'sort' => [
        'defaultOrder' => [
            'period' => SORT_DESC,
            'week_no' => SORT_DESC
        ],
    ]
]);

$this->load($params);

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

$query->andFilterWhere([
            'week' => $this->week,
            'week_no' => $this->week_no,
            'plan_qty' => $this->plan_qty,
            'actual_qty' => $this->actual_qty,
            'balance_qty' => $this->balance_qty,
            'flag' => $this->flag,
        ]);

        $query->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'period', $this->period]);

return $dataProvider;
}
}