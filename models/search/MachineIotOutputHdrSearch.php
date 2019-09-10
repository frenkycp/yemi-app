<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MachineIotOutputHdr;

/**
* MachineIotOutputHdrSearch represents the model behind the search form about `app\models\MachineIotOutputHdr`.
*/
class MachineIotOutputHdrSearch extends MachineIotOutputHdr
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['lot_number', 'gmc', 'gmc_desc', 'start_date', 'end_date'], 'safe'],
            [['lot_qty'], 'number'],
            [['run_time', 'iddle_time', 'total_lead_time', 'man_power_qty'], 'integer'],
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
$query = MachineIotOutputHdr::find();

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
            'lot_qty' => $this->lot_qty,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'run_time' => $this->run_time,
            'iddle_time' => $this->iddle_time,
            'total_lead_time' => $this->total_lead_time,
            'man_power_qty' => $this->man_power_qty,
        ]);

        $query->andFilterWhere(['like', 'lot_number', $this->lot_number])
            ->andFilterWhere(['like', 'gmc', $this->gmc])
            ->andFilterWhere(['like', 'gmc_desc', $this->gmc_desc]);

return $dataProvider;
}
}