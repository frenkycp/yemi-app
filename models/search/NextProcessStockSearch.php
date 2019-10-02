<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WwStockWaitingProcess02;

/**
* AbsensiTblSearch represents the model behind the search form about `app\models\AbsensiTbl`.
*/
class NextProcessStockSearch extends WwStockWaitingProcess02
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['start_date', 'end_date', 'next_process_date', 'mesin_id', 'kelompok', 'lot_number', 'model_group', 'gmc_desc', 'mesin_description', 'parent', 'parent_desc', 'gmc', 'plan_stats', 'plan_run'], 'safe'],
            [['lot_qty', 'days_waiting', 'hours_waiting', 'total_next_process'], 'number'],
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
$query = WwStockWaitingProcess02::find();

$dataProvider = new ActiveDataProvider([
'query' => $query,
]);

$this->load($params);

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

$query->andFilterWhere([
            'mesin_id' => $this->mesin_id,
            'lot_qty' => $this->lot_qty,
            'days_waiting' => $this->days_waiting,
        ]);

        $query->andFilterWhere(['like', 'mesin_description', $this->mesin_description])
        ->andFilterWhere(['like', 'kelompok', $this->kelompok])
        ->andFilterWhere(['like', 'lot_number', $this->lot_number])
        ->andFilterWhere(['like', 'gmc', $this->gmc])
        ->andFilterWhere(['like', 'gmc_desc', $this->gmc_desc])
        ->andFilterWhere(['like', 'parent', $this->parent])
        ->andFilterWhere(['like', 'parent_desc', $this->parent_desc])
        ->andFilterWhere(['like', 'plan_stats', $this->plan_stats])
        ->andFilterWhere(['like', 'plan_run', $this->plan_run])
        ->andFilterWhere(['like', 'model_group', $this->model_group]);

return $dataProvider;
}
}