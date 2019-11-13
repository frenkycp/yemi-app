<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\KanbanHdr;

/**
* KanbanDataSearch represents the model behind the search form about `app\models\KanbanHdr`.
*/
class KanbanDataSearch extends KanbanHdr
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['job_hdr_no', 'job_desc', 'job_source', 'job_priority', 'job_type', 'job_flow_id', 'job_issued_date', 'job_issued_nik', 'job_issued_nik_name', 'request_date', 'request_to_nik', 'request_to_nik_name', 'job_stage_desc', 'confirm_schedule_date', 'confirm_to_nik', 'confirm_to_nik_name', 'confirm_cost_center', 'confirm_cost_center_desc', 'confirm_department', 'confirm_type', 'confirm_close_open', 'confirm_last_date', 'job_close_date', 'job_close_open', 'job_close_desc', 'attach_hdr_no'], 'safe'],
            [['job_dtr_step_close', 'job_dtr_step_open', 'job_dtr_step_total', 'job_stage', 'job_lead_time'], 'integer'],
            [['job_percentage'], 'number'],
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
$query = KanbanHdr::find();

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
            'job_dtr_step_close' => $this->job_dtr_step_close,
            'job_dtr_step_open' => $this->job_dtr_step_open,
            'job_dtr_step_total' => $this->job_dtr_step_total,
            'job_percentage' => $this->job_percentage,
            'job_issued_date' => $this->job_issued_date,
            'request_date' => $this->request_date,
            'job_stage' => $this->job_stage,
            'confirm_schedule_date' => $this->confirm_schedule_date,
            'confirm_last_date' => $this->confirm_last_date,
            'job_lead_time' => $this->job_lead_time,
            'job_close_date' => $this->job_close_date,
        ]);

        $query->andFilterWhere(['like', 'job_hdr_no', $this->job_hdr_no])
            ->andFilterWhere(['like', 'job_desc', $this->job_desc])
            ->andFilterWhere(['like', 'job_source', $this->job_source])
            ->andFilterWhere(['like', 'job_priority', $this->job_priority])
            ->andFilterWhere(['like', 'job_type', $this->job_type])
            ->andFilterWhere(['like', 'job_flow_id', $this->job_flow_id])
            ->andFilterWhere(['like', 'job_issued_nik', $this->job_issued_nik])
            ->andFilterWhere(['like', 'job_issued_nik_name', $this->job_issued_nik_name])
            ->andFilterWhere(['like', 'request_to_nik', $this->request_to_nik])
            ->andFilterWhere(['like', 'request_to_nik_name', $this->request_to_nik_name])
            ->andFilterWhere(['like', 'job_stage_desc', $this->job_stage_desc])
            ->andFilterWhere(['like', 'confirm_to_nik', $this->confirm_to_nik])
            ->andFilterWhere(['like', 'confirm_to_nik_name', $this->confirm_to_nik_name])
            ->andFilterWhere(['like', 'confirm_cost_center', $this->confirm_cost_center])
            ->andFilterWhere(['like', 'confirm_cost_center_desc', $this->confirm_cost_center_desc])
            ->andFilterWhere(['like', 'confirm_department', $this->confirm_department])
            ->andFilterWhere(['like', 'confirm_type', $this->confirm_type])
            ->andFilterWhere(['like', 'confirm_close_open', $this->confirm_close_open])
            ->andFilterWhere(['like', 'job_close_open', $this->job_close_open])
            ->andFilterWhere(['like', 'job_close_desc', $this->job_close_desc])
            ->andFilterWhere(['like', 'attach_hdr_no', $this->attach_hdr_no]);

return $dataProvider;
}
}