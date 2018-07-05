<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SplOvertimeBudget;

/**
* SplOvertimeBudgetSearch represents the model behind the search form about `app\models\SplOvertimeBudget`.
*/
class SplOvertimeBudgetSearch extends SplOvertimeBudget
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['period'], 'safe'],
            [['overtime_budget', 'category_id'], 'number'],
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
$query = SplOvertimeBudget::find();

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
	'defaultOrder' => [
        'period' => SORT_ASC,
        'category_id' => SORT_ASC
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
            'overtime_budget' => $this->overtime_budget,
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'period', $this->period]);

return $dataProvider;
}
}