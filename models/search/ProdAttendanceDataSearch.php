<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProdAttendanceData;

/**
* ProdAttendanceDataSearch represents the model behind the search form about `app\models\ProdAttendanceData`.
*/
class ProdAttendanceDataSearch extends ProdAttendanceData
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['att_data_id', 'period', 'posting_date', 'posting_shift', 'nik', 'name', 'check_in', 'check_out', 'child_analyst', 'child_analyst_desc', 'machine_id', 'machine_desc', 'last_update', 'current_status'], 'safe'],
            [['line'], 'integer'],
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
$query = ProdAttendanceData::find();

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
            'posting_date' => $this->posting_date,
            'posting_shift' => $this->posting_shift,
            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
            'line' => $this->line,
            'last_update' => $this->last_update,
        ]);

        $query->andFilterWhere(['like', 'att_data_id', $this->att_data_id])
            ->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'nik', $this->nik])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'child_analyst', $this->child_analyst])
            ->andFilterWhere(['like', 'child_analyst_desc', $this->child_analyst_desc])
            ->andFilterWhere(['like', 'machine_id', $this->machine_id])
            ->andFilterWhere(['like', 'machine_desc', $this->machine_desc])
            ->andFilterWhere(['like', 'current_status', $this->current_status]);

return $dataProvider;
}
}