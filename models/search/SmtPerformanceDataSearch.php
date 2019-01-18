<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WipEff03;

/**
* AbsensiTblSearch represents the model behind the search form about `app\models\AbsensiTbl`.
*/
class SmtPerformanceDataSearch extends WipEff03
{
    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['period', 'hari', 'child_analyst', 'child_analyst_desc', 'LINE', 'SMT_SHIFT', 'child_01', 'child_desc_01'], 'string'],
            [['post_date'], 'safe'],
            [['std_all', 'qty_all', 'machine_run_std_second', 'break_time_second', 'nozzle_maintenance_second', 'change_schedule_second', 'air_pressure_problem_second', 'power_failure_second', 'part_shortage_second', 'set_up_1st_time_running_tp_second', 'part_arrangement_dcn_second', 'meeting_second', 'dandori_second', 'porgram_error_second', 'm_c_problem_second', 'feeder_problem_second', 'quality_problem_second', 'pcb_transfer_problem_second', 'profile_problem_second', 'pick_up_error_second', 'other_second', 'loss_planned', 'loss_out_section', 'loss_in_section', 'loss_planned_outsection', 'total_lost', 'machine_utilization', 'gross_minus_planned_loss', 'nett1_minus_planned_outsection_loss', 'nett2_minus_all_loss', 'efisiensi_working_ratio'], 'number'],
            [['machine_run_act_second'], 'integer']
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
        $query = WipEff03::find();

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