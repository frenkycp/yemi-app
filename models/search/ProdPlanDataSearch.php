<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WipEffTbl;

/**
* ProdPlanDataSearch represents the model behind the search form about `app\models\WipEffTbl`.
*/
class ProdPlanDataSearch extends WipEffTbl
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['lot_id', 'child_analyst', 'child_analyst_desc', 'LINE', 'SMT_SHIFT', 'KELOMPOK', 'slip_id_01', 'child_01', 'child_desc_01', 'slip_id_02', 'child_02', 'child_desc_02', 'slip_id_03', 'child_03', 'child_desc_03', 'slip_id_04', 'child_04', 'child_desc_04', 'slip_id_05', 'child_05', 'child_desc_05', 'slip_id_06', 'child_06', 'child_desc_06', 'slip_id_07', 'child_07', 'child_desc_07', 'slip_id_08', 'child_08', 'child_desc_08', 'slip_id_09', 'child_09', 'child_desc_09', 'slip_id_10', 'child_10', 'child_desc_10', 'child_all', 'child_desc_all', 'start_date', 'end_date', 'post_date', 'period', 'USER_ID', 'USER_DESC', 'LAST_UPDATE', 'note01', 'note02', 'note03', 'note04', 'note05', 'note06', 'note07', 'note08', 'note09', 'note10', 'note11', 'note12', 'note13', 'note14', 'note15', 'note16', 'note17', 'note18', 'post_date_original', 'period_original', 'plan_item', 'plan_date', 'plan_stats', 'plan_run'], 'safe'],
            [['act_qty_01', 'std_time_01', 'act_qty_02', 'std_time_02', 'act_qty_03', 'std_time_03', 'act_qty_04', 'std_time_04', 'act_qty_05', 'std_time_05', 'act_qty_06', 'std_time_06', 'act_qty_07', 'std_time_07', 'act_qty_08', 'std_time_08', 'act_qty_09', 'std_time_09', 'act_qty_10', 'std_time_10', 'qty_all', 'std_all', 'lt_gross', 'lt_loss', 'lt_nett', 'lt_std', 'efisiensi_gross', 'efisiensi', 'long01', 'long02', 'long03', 'long04', 'long05', 'long06', 'long07', 'long08', 'long09', 'long10', 'long11', 'long12', 'long13', 'long14', 'long15', 'long16', 'long17', 'long18', 'long_total', 'break_time', 'nozzle_maintenance', 'change_schedule', 'air_pressure_problem', 'power_failure', 'part_shortage', 'set_up_1st_time_running_tp', 'part_arrangement_dcn', 'meeting', 'dandori', 'porgram_error', 'm_c_problem', 'feeder_problem', 'quality_problem', 'pcb_transfer_problem', 'profile_problem', 'pick_up_error', 'other', 'plan_qty', 'plan_balance', 'slip_count'], 'number'],
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
$query = WipEffTbl::find()->where('child_analyst_desc IS NOT NULL');

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
            'act_qty_01' => $this->act_qty_01,
            'std_time_01' => $this->std_time_01,
            'act_qty_02' => $this->act_qty_02,
            'std_time_02' => $this->std_time_02,
            'act_qty_03' => $this->act_qty_03,
            'std_time_03' => $this->std_time_03,
            'act_qty_04' => $this->act_qty_04,
            'std_time_04' => $this->std_time_04,
            'act_qty_05' => $this->act_qty_05,
            'std_time_05' => $this->std_time_05,
            'act_qty_06' => $this->act_qty_06,
            'std_time_06' => $this->std_time_06,
            'act_qty_07' => $this->act_qty_07,
            'std_time_07' => $this->std_time_07,
            'act_qty_08' => $this->act_qty_08,
            'std_time_08' => $this->std_time_08,
            'act_qty_09' => $this->act_qty_09,
            'std_time_09' => $this->std_time_09,
            'act_qty_10' => $this->act_qty_10,
            'std_time_10' => $this->std_time_10,
            'qty_all' => $this->qty_all,
            'std_all' => $this->std_all,
            'lt_gross' => $this->lt_gross,
            'lt_loss' => $this->lt_loss,
            'lt_nett' => $this->lt_nett,
            'lt_std' => $this->lt_std,
            'efisiensi_gross' => $this->efisiensi_gross,
            'efisiensi' => $this->efisiensi,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'post_date' => $this->post_date,
            'long01' => $this->long01,
            'long02' => $this->long02,
            'long03' => $this->long03,
            'long04' => $this->long04,
            'long05' => $this->long05,
            'long06' => $this->long06,
            'long07' => $this->long07,
            'long08' => $this->long08,
            'long09' => $this->long09,
            'long10' => $this->long10,
            'long11' => $this->long11,
            'long12' => $this->long12,
            'long13' => $this->long13,
            'long14' => $this->long14,
            'long15' => $this->long15,
            'long16' => $this->long16,
            'long17' => $this->long17,
            'long18' => $this->long18,
            'long_total' => $this->long_total,
            'break_time' => $this->break_time,
            'nozzle_maintenance' => $this->nozzle_maintenance,
            'change_schedule' => $this->change_schedule,
            'air_pressure_problem' => $this->air_pressure_problem,
            'power_failure' => $this->power_failure,
            'part_shortage' => $this->part_shortage,
            'set_up_1st_time_running_tp' => $this->set_up_1st_time_running_tp,
            'part_arrangement_dcn' => $this->part_arrangement_dcn,
            'meeting' => $this->meeting,
            'dandori' => $this->dandori,
            'porgram_error' => $this->porgram_error,
            'm_c_problem' => $this->m_c_problem,
            'feeder_problem' => $this->feeder_problem,
            'quality_problem' => $this->quality_problem,
            'pcb_transfer_problem' => $this->pcb_transfer_problem,
            'profile_problem' => $this->profile_problem,
            'pick_up_error' => $this->pick_up_error,
            'other' => $this->other,
            'LAST_UPDATE' => $this->LAST_UPDATE,
            'post_date_original' => $this->post_date_original,
            'plan_qty' => $this->plan_qty,
            'plan_date' => $this->plan_date,
            'plan_balance' => $this->plan_balance,
            'slip_count' => $this->slip_count,
        ]);

        $query->andFilterWhere(['like', 'lot_id', $this->lot_id])
            ->andFilterWhere(['like', 'child_analyst', $this->child_analyst])
            ->andFilterWhere(['like', 'child_analyst_desc', $this->child_analyst_desc])
            ->andFilterWhere(['like', 'LINE', $this->LINE])
            ->andFilterWhere(['like', 'SMT_SHIFT', $this->SMT_SHIFT])
            ->andFilterWhere(['like', 'KELOMPOK', $this->KELOMPOK])
            ->andFilterWhere(['like', 'slip_id_01', $this->slip_id_01])
            ->andFilterWhere(['like', 'child_01', $this->child_01])
            ->andFilterWhere(['like', 'child_desc_01', $this->child_desc_01])
            ->andFilterWhere(['like', 'slip_id_02', $this->slip_id_02])
            ->andFilterWhere(['like', 'child_02', $this->child_02])
            ->andFilterWhere(['like', 'child_desc_02', $this->child_desc_02])
            ->andFilterWhere(['like', 'slip_id_03', $this->slip_id_03])
            ->andFilterWhere(['like', 'child_03', $this->child_03])
            ->andFilterWhere(['like', 'child_desc_03', $this->child_desc_03])
            ->andFilterWhere(['like', 'slip_id_04', $this->slip_id_04])
            ->andFilterWhere(['like', 'child_04', $this->child_04])
            ->andFilterWhere(['like', 'child_desc_04', $this->child_desc_04])
            ->andFilterWhere(['like', 'slip_id_05', $this->slip_id_05])
            ->andFilterWhere(['like', 'child_05', $this->child_05])
            ->andFilterWhere(['like', 'child_desc_05', $this->child_desc_05])
            ->andFilterWhere(['like', 'slip_id_06', $this->slip_id_06])
            ->andFilterWhere(['like', 'child_06', $this->child_06])
            ->andFilterWhere(['like', 'child_desc_06', $this->child_desc_06])
            ->andFilterWhere(['like', 'slip_id_07', $this->slip_id_07])
            ->andFilterWhere(['like', 'child_07', $this->child_07])
            ->andFilterWhere(['like', 'child_desc_07', $this->child_desc_07])
            ->andFilterWhere(['like', 'slip_id_08', $this->slip_id_08])
            ->andFilterWhere(['like', 'child_08', $this->child_08])
            ->andFilterWhere(['like', 'child_desc_08', $this->child_desc_08])
            ->andFilterWhere(['like', 'slip_id_09', $this->slip_id_09])
            ->andFilterWhere(['like', 'child_09', $this->child_09])
            ->andFilterWhere(['like', 'child_desc_09', $this->child_desc_09])
            ->andFilterWhere(['like', 'slip_id_10', $this->slip_id_10])
            ->andFilterWhere(['like', 'child_10', $this->child_10])
            ->andFilterWhere(['like', 'child_desc_10', $this->child_desc_10])
            ->andFilterWhere(['like', 'child_all', $this->child_all])
            ->andFilterWhere(['like', 'child_desc_all', $this->child_desc_all])
            ->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'USER_DESC', $this->USER_DESC])
            ->andFilterWhere(['like', 'note01', $this->note01])
            ->andFilterWhere(['like', 'note02', $this->note02])
            ->andFilterWhere(['like', 'note03', $this->note03])
            ->andFilterWhere(['like', 'note04', $this->note04])
            ->andFilterWhere(['like', 'note05', $this->note05])
            ->andFilterWhere(['like', 'note06', $this->note06])
            ->andFilterWhere(['like', 'note07', $this->note07])
            ->andFilterWhere(['like', 'note08', $this->note08])
            ->andFilterWhere(['like', 'note09', $this->note09])
            ->andFilterWhere(['like', 'note10', $this->note10])
            ->andFilterWhere(['like', 'note11', $this->note11])
            ->andFilterWhere(['like', 'note12', $this->note12])
            ->andFilterWhere(['like', 'note13', $this->note13])
            ->andFilterWhere(['like', 'note14', $this->note14])
            ->andFilterWhere(['like', 'note15', $this->note15])
            ->andFilterWhere(['like', 'note16', $this->note16])
            ->andFilterWhere(['like', 'note17', $this->note17])
            ->andFilterWhere(['like', 'note18', $this->note18])
            ->andFilterWhere(['like', 'period_original', $this->period_original])
            ->andFilterWhere(['like', 'plan_item', $this->plan_item])
            ->andFilterWhere(['like', 'plan_stats', $this->plan_stats])
            ->andFilterWhere(['like', 'plan_run', $this->plan_run]);

return $dataProvider;
}
}