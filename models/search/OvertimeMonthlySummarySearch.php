<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SplViewMonthlySection02;

/**
* OvertimeMonthlySummarySearch represents the model behind the search form about `app\models\SplViewMonthlySection02`.
*/
class OvertimeMonthlySummarySearch extends SplViewMonthlySection02
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['PERIOD', 'CC_GROUP', 'CC_DESC'], 'string'],
            [['lembur_total', 'lembur_min', 'lembur_max', 'lembur_avg'], 'number']
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
$query = SplViewMonthlySection02::find();

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
	'defaultOrder' => [
        //'PERIOD' => SORT_DESC,
        'lembur_total' => SORT_DESC
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
            'PERIOD' => $this->PERIOD,
            'CC_GROUP' => $this->CC_GROUP,
            'CC_DESC' => $this->CC_DESC,
        ]);

return $dataProvider;
}
}