<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WipEffView;

/**
* AbsensiTblSearch represents the model behind the search form about `app\models\AbsensiTbl`.
*/
class SmtPerformanceDataSearch extends WipEffView
{
/**
* @inheritdoc
*/
public function rules()
{
return [
      [['start_date', 'end_date', 'post_date'], 'safe'],
      [['lot_id', 'LINE', 'SMT_SHIFT', 'KELOMPOK', 'slip_id_01', 'child_01', 'child_desc_01', 'slip_id_02', 'child_02', 'child_desc_02', 'slip_id_03', 'child_03', 'child_desc_03', 'slip_id_04', 'child_04', 'child_desc_04', 'slip_id_05', 'child_05', 'child_desc_05', 'slip_id_06', 'child_06', 'child_desc_06', 'slip_id_07', 'child_07', 'child_desc_07', 'slip_id_08', 'child_08', 'child_desc_08', 'slip_id_09', 'child_09', 'child_desc_09', 'slip_id_10', 'child_10', 'child_desc_10', 'period', 'child_analyst', 'child_analyst_desc'], 'string'],
            [['act_qty_01', 'std_time_01', 'act_qty_02', 'std_time_02', 'act_qty_03', 'std_time_03', 'act_qty_04', 'std_time_04', 'act_qty_05', 'std_time_05', 'act_qty_06', 'std_time_06', 'act_qty_07', 'std_time_07', 'act_qty_08', 'std_time_08', 'act_qty_09', 'std_time_09', 'act_qty_10', 'std_time_10', 'qty_all', 'std_all', 'lt_gross', 'lt_loss', 'lt_nett', 'lt_std', 'efisiensi', 'long01', 'long02', 'long03', 'long04', 'long05', 'long06', 'long07', 'long08', 'long09', 'long10', 'long11', 'long12', 'long13', 'long14', 'long15', 'long16', 'long17', 'long18', 'long_total', 'break_time', 'nozzle_maintenance', 'change_schedule', 'air_pressure_problem', 'power_failure', 'part_shortage', 'set_up_1st_time_running_tp', 'part_arrangement_dcn', 'meeting', 'dandori', 'porgram_error', 'm_c_problem', 'feeder_problem', 'quality_problem', 'pcb_transfer_problem', 'profile_problem', 'pick_up_error', 'other', 'efisiensi_gross'], 'number'],
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
$query = WipEffView::find();

$dataProvider = new ActiveDataProvider([
    'query' => $query,
    'sort' => [
        'defaultOrder' => [
            //'cust_desc' => SORT_ASC,
            'post_date' => SORT_DESC,
            'LINE' => SORT_ASC,
            'SMT_SHIFT' => SORT_ASC,
            'child_01' => SORT_ASC,
        ]
    ],
]);

$this->load($params);

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

$query->andFilterWhere([
            'post_date' => $this->post_date,
            'LINE' => $this->LINE,
            'SMT_SHIFT' => $this->SMT_SHIFT,
            'child_01' => $this->child_01,
        ]);
/*$query->andFilterWhere([
            'YEAR' => $this->YEAR,
            'WEEK' => $this->WEEK,
            'DATE' => $this->DATE,
            'TOTAL_KARYAWAN' => $this->TOTAL_KARYAWAN,
            'KEHADIRAN' => $this->KEHADIRAN,
            'BONUS' => $this->BONUS,
            'DISIPLIN' => $this->DISIPLIN,
        ]);

        $query->andFilterWhere(['like', 'NIK_DATE_ID', $this->NIK_DATE_ID])
            ->andFilterWhere(['like', 'NO', $this->NO])
            ->andFilterWhere(['like', 'NIK', $this->NIK])
            ->andFilterWhere(['like', 'CC_ID', $this->CC_ID])
            ->andFilterWhere(['like', 'SECTION', $this->SECTION])
            ->andFilterWhere(['like', 'DIRECT_INDIRECT', $this->DIRECT_INDIRECT])
            ->andFilterWhere(['like', 'NAMA_KARYAWAN', $this->NAMA_KARYAWAN])
            ->andFilterWhere(['like', 'PERIOD', $this->PERIOD])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE])
            ->andFilterWhere(['like', 'DAY_STAT', $this->DAY_STAT])
            ->andFilterWhere(['like', 'CATEGORY', $this->CATEGORY]);*/

return $dataProvider;
}
}