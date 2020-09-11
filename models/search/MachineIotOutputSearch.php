<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MachineIotOutput;
use app\models\MachineIotCurrent;

/**
* MachineIotOutputSearch represents the model behind the search form about `app\models\MachineIotOutput`.
*/
class MachineIotOutputSearch extends MachineIotOutput
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['seq', 'shift', 'lama_proses', 'man_power_qty', 'oven_time', 'is_seasoning', 'act_qty'], 'integer'],
            [['mesin_id', 'mesin_description', 'kelompok', 'lot_number', 'model_group', 'parent', 'parent_desc', 'gmc', 'gmc_desc', 'start_date', 'end_date', 'posting_shift', 'man_power_name', 'start_by_id', 'start_by_name', 'end_by_id', 'end_by_name', 'minor', 'child_analyst'], 'safe'],
            [['lot_qty', 'ng_qty'], 'number'],
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
$query = MachineIotOutput::find();

$dataProvider = new ActiveDataProvider([
'query' => $query,
]);

$this->load($params);

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

if ($this->child_analyst != '' && $this->child_analyst !== null) {
      $tmp_kelompok = MachineIotCurrent::find()->select('kelompok')->where(['child_analyst' => $this->child_analyst])->groupBy('kelompok')->all();
      $tmp_kelompok_arr = [];
      foreach ($tmp_kelompok as $key => $value) {
            $tmp_kelompok_arr[] = $value->kelompok;
      }
      $query->andFilterWhere([
            'kelompok' => $tmp_kelompok_arr,
        ]);
}

$query->andFilterWhere([
            'seq' => $this->seq,
            'lot_qty' => $this->lot_qty,
            'ng_qty' => $this->ng_qty,
            'posting_shift' => $this->posting_shift,
            'shift' => $this->shift,
            'lama_proses' => $this->lama_proses,
            'man_power_qty' => $this->man_power_qty,
            'oven_time' => $this->oven_time,
            'is_seasoning' => $this->is_seasoning,
            'act_qty' => $this->act_qty,
            'kelompok' => $this->kelompok,
        ]);

        $query->andFilterWhere(['like', 'mesin_id', $this->mesin_id])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),start_date,120)', $this->start_date])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),end_date,120)', $this->end_date])
            ->andFilterWhere(['like', 'mesin_description', $this->mesin_description])
            ->andFilterWhere(['like', 'kelompok', $this->kelompok])
            ->andFilterWhere(['like', 'lot_number', $this->lot_number])
            ->andFilterWhere(['like', 'model_group', $this->model_group])
            ->andFilterWhere(['like', 'parent', $this->parent])
            ->andFilterWhere(['like', 'parent_desc', $this->parent_desc])
            ->andFilterWhere(['like', 'gmc', $this->gmc])
            ->andFilterWhere(['like', 'gmc_desc', $this->gmc_desc])
            ->andFilterWhere(['like', 'man_power_name', $this->man_power_name])
            ->andFilterWhere(['like', 'start_by_id', $this->start_by_id])
            ->andFilterWhere(['like', 'start_by_name', $this->start_by_name])
            ->andFilterWhere(['like', 'end_by_id', $this->end_by_id])
            ->andFilterWhere(['like', 'end_by_name', $this->end_by_name])
            ->andFilterWhere(['like', 'minor', $this->minor]);

return $dataProvider;
}
}