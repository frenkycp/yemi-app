<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MachineIotOutputDtr;

/**
* MachineIotOutputDtrSearch represents the model behind the search form about `app\models\MachineIotOutputDtr`.
*/
class MachineIotOutputDtrSearch extends MachineIotOutputDtr
{
/**
* @inheritdoc
*/
public function rules()
{
return [
            [['lot_number', 'mesin_id', 'mesin_description', 'kelompok', 'gmc', 'gmc_desc', 'start_date', 'end_date', 'status', 'parent', 'parent_desc'], 'safe'],
            [['lot_qty'], 'number'],
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
$query = MachineIotOutputDtr::find();

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
            'trans_id' => $this->trans_id,
            'seq' => $this->seq,
            'lot_qty' => $this->lot_qty,
            'lead_time' => $this->lead_time,
        ]);

        $query->andFilterWhere(['like', 'lot_number', $this->lot_number])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10), start_date, 120)', $this->start_date])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10), end_date, 120)', $this->end_date])
            ->andFilterWhere(['like', 'mesin_id', $this->mesin_id])
            ->andFilterWhere(['like', 'mesin_description', $this->mesin_description])
            ->andFilterWhere(['like', 'kelompok', $this->kelompok])
            ->andFilterWhere(['like', 'gmc', $this->gmc])
            ->andFilterWhere(['like', 'gmc_desc', $this->gmc_desc])
            ->andFilterWhere(['like', 'parent', $this->parent])
            ->andFilterWhere(['like', 'parent_desc', $this->parent_desc])
            ->andFilterWhere(['like', 'status', $this->status]);

return $dataProvider;
}
}