<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GojekOrderTbl;

/**
* GojekOrderTblSearch represents the model behind the search form about `app\models\GojekOrderTbl`.
*/
class GojekOrderTblSearch extends GojekOrderTbl
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id'], 'integer'],
            [['slip_id', 'item', 'item_desc', 'from_loc', 'to_loc', 'source', 'GOJEK_ID', 'GOJEK_DESC', 'NIK_REQUEST', 'NAMA_KARYAWAN', 'STAT', 'model_group', 'period_line', 'session_no', 'period'], 'safe'],
            [['GOJEK_VALUE'], 'number'],
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
$query = GojekOrderTbl::find()->joinWith('wipPlanActualReport');

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
            'id' => $this->id,
            //'issued_date' => $this->issued_date,
            //'daparture_date' => $this->daparture_date,
            //'arrival_date' => $this->arrival_date,
            'GOJEK_VALUE' => $this->GOJEK_VALUE,
            'WIP_PLAN_ACTUAL_REPORT.period_line' => $this->period_line,
            'WIP_PLAN_ACTUAL_REPORT.session_id' => $this->session_no,
            'FORMAT(daparture_date, \'yyyyMM\')' => $this->period
        ]);

        $query->andFilterWhere(['like', 'GOJEK_ORDER_TBL.slip_id', $this->slip_id])
            ->andFilterWhere(['like', 'item', $this->item])
            ->andFilterWhere(['like', 'WIP_PLAN_ACTUAL_REPORT.model_group', $this->model_group])
            ->andFilterWhere(['like', 'item_desc', $this->item_desc])
            ->andFilterWhere(['like', 'from_loc', $this->from_loc])
            ->andFilterWhere(['like', 'to_loc', $this->to_loc])
            ->andFilterWhere(['like', 'source', $this->source])
            ->andFilterWhere(['like', 'GOJEK_ID', $this->GOJEK_ID])
            ->andFilterWhere(['like', 'GOJEK_DESC', $this->GOJEK_DESC])
            ->andFilterWhere(['like', 'NIK_REQUEST', $this->NIK_REQUEST])
            ->andFilterWhere(['like', 'NAMA_KARYAWAN', $this->NAMA_KARYAWAN])
            ->andFilterWhere(['like', 'STAT', $this->STAT]);

return $dataProvider;
}
}