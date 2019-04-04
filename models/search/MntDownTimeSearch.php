<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MachinePerformanceView01;

/**
* MntDownTimeSearch represents the model behind the search form about `app\models\MachinePerformanceView01`.
*/
class MntDownTimeSearch extends MachinePerformanceView01
{
/**
* @inheritdoc
*/
public function rules()
{
return [
	[['down_time', 'non_down_time', 'down_time_number', 'period', 'mesin_id', 'mesin_nama', 'location', 'area'], 'safe']
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
$query = MachinePerformanceView01::find();

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
	'defaultOrder' => [
		'down_time' => SORT_DESC,
		'down_time_number' => SORT_DESC,
		'non_down_time' => SORT_DESC,
        'period' => SORT_ASC,
        //'NILAI_LEMBUR_ACTUAL' => SORT_DESC
    ]
],
]);
$dataProvider->pagination->pageSize = 10;

$this->load($params);

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

$query->andFilterWhere([
            'location' => $this->location,
            'area' => $this->area,
        ]);

$query->andFilterWhere(['like', 'period', $this->period])
->andFilterWhere(['like', 'mesin_nama', $this->mesin_nama]);

return $dataProvider;
}
}