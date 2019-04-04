<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MachinePerformanceView03;

/**
* MttrMtbfSearch represents the model behind the search form about `app\models\MachinePerformanceView03`.
*/
class MttrMtbfSearch extends MachinePerformanceView03
{
/**
* @inheritdoc
*/
public function rules()
{
return [
            [['down_time', 'non_down_time', 'down_time_number', 'working_days', 'mttr', 'mtbf', 'period'], 'safe']
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
$query = MachinePerformanceView03::find();

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
	'defaultOrder' => [
        'period' => SORT_ASC,
        //'NILAI_LEMBUR_ACTUAL' => SORT_DESC
    ]
],
]);

$this->load($params);

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

$query->andFilterWhere(['like', 'period', $this->period]);

return $dataProvider;
}
}