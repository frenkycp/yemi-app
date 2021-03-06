<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VisualPickingList;

/**
* MaterialBlueListSearch represents the model behind the search form about `app\models\VisualPickingList`.
*/
class MaterialBlueListSearch extends VisualPickingList
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['seq_no', 'part_count', 'man_power', 'priority', 'stage_id', 'pts_part', 'delay_days', 'slip_count', 'slip_open', 'slip_close'], 'integer'],
            [['set_list_no', 'parent', 'parent_desc', 'parent_um', 'req_date', 'req_date_original', 'analyst', 'analyst_desc', 'create_date', 'create_user_id', 'create_user_desc', 'confirm_date', 'confirm_user_id', 'confirm_user_desc', 'start_date', 'start_user_id', 'start_user_desc', 'completed_user_id', 'completed_user_desc', 'hand_over_date', 'hand_over_user_id', 'hand_over_user_desc', 'stage_desc', 'condition_desc', 'stat', 'catatan', 'pts_stat', 'set_list_type', 'id_01', 'id_01_desc', 'id_02', 'id_02_desc', 'id_03', 'id_03_desc', 'id_04', 'id_04_desc', 'id_05', 'id_05_desc', 'id_06', 'id_06_desc', 'id_07', 'id_07_desc', 'id_08', 'id_08_desc', 'id_09', 'id_09_desc', 'id_10', 'id_10_desc', 'id_update', 'id_update_desc', 'id_update_date', 'sudah_cetak', 'id_prioty', 'id_prioty_desc', 'id_prioty_date', 'id_hc', 'id_hc_desc', 'id_hc_date', 'id_hc_stat', 'id_hc_open', 'id_hc_open_desc', 'id_hc_open_date', 'id_hc_open_stat', 'pts_note', 'show', 'closing_date', 'back_up_period', 'back_up', 'id_11', 'id_11_desc', 'id_12', 'id_12_desc', 'id_13', 'id_13_desc', 'id_14', 'id_14_desc', 'id_15', 'id_15_desc', 'id_16', 'id_16_desc', 'id_17', 'id_17_desc', 'id_18', 'id_18_desc', 'id_19', 'id_19_desc', 'id_20', 'id_20_desc', 'model'], 'safe'],
            [['progress_pct', 'pick_lt'], 'number'],
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
$query = VisualPickingList::find()
->where(['stage_id' => 4])
->andWhere([
      'analyst' => ['WF01', 'WS01']
]);

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
      'defaultOrder' => [
            //'cust_desc' => SORT_ASC,
            'completed_date' => SORT_DESC,
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
            'seq_no' => $this->seq_no,
            //'req_date' => $this->req_date,
            'req_date_original' => $this->req_date_original,
            'plan_qty' => $this->plan_qty,
            'part_count' => $this->part_count,
            'man_power' => $this->man_power,
            'create_date' => $this->create_date,
            'confirm_date' => $this->confirm_date,
            'start_date' => $this->start_date,
            'hand_over_date' => $this->hand_over_date,
            'priority' => $this->priority,
            'stage_id' => $this->stage_id,
            'progress_pct' => $this->progress_pct,
            'pts_part' => $this->pts_part,
            'pick_lt' => $this->pick_lt,
            'delay_days' => $this->delay_days,
            'id_update_date' => $this->id_update_date,
            'id_prioty_date' => $this->id_prioty_date,
            'id_hc_date' => $this->id_hc_date,
            'id_hc_open_date' => $this->id_hc_open_date,
            'slip_count' => $this->slip_count,
            'slip_open' => $this->slip_open,
            'slip_close' => $this->slip_close,
            'closing_date' => $this->closing_date,
        ]);

        $query->andFilterWhere(['like', 'set_list_no', $this->set_list_no])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),req_date,120)', $this->req_date])
            ->andFilterWhere(['like', 'parent', $this->parent])
            ->andFilterWhere(['like', 'parent_desc', $this->parent_desc])
            ->andFilterWhere(['like', 'parent_um', $this->parent_um])
            ->andFilterWhere(['like', 'analyst', $this->analyst])
            ->andFilterWhere(['like', 'analyst_desc', $this->analyst_desc])
            ->andFilterWhere(['like', 'create_user_id', $this->create_user_id])
            ->andFilterWhere(['like', 'create_user_desc', $this->create_user_desc])
            ->andFilterWhere(['like', 'confirm_user_id', $this->confirm_user_id])
            ->andFilterWhere(['like', 'confirm_user_desc', $this->confirm_user_desc])
            ->andFilterWhere(['like', 'start_user_id', $this->start_user_id])
            ->andFilterWhere(['like', 'start_user_desc', $this->start_user_desc])
            ->andFilterWhere(['like', 'completed_user_id', $this->completed_user_id])
            ->andFilterWhere(['like', 'completed_user_desc', $this->completed_user_desc])
            ->andFilterWhere(['like', 'hand_over_user_id', $this->hand_over_user_id])
            ->andFilterWhere(['like', 'hand_over_user_desc', $this->hand_over_user_desc])
            ->andFilterWhere(['like', 'stage_desc', $this->stage_desc])
            ->andFilterWhere(['like', 'condition_desc', $this->condition_desc])
            ->andFilterWhere(['like', 'stat', $this->stat])
            ->andFilterWhere(['like', 'catatan', $this->catatan])
            ->andFilterWhere(['like', 'pts_stat', $this->pts_stat])
            ->andFilterWhere(['like', 'set_list_type', $this->set_list_type])
            ->andFilterWhere(['like', 'id_01', $this->id_01])
            ->andFilterWhere(['like', 'id_01_desc', $this->id_01_desc])
            ->andFilterWhere(['like', 'id_02', $this->id_02])
            ->andFilterWhere(['like', 'id_02_desc', $this->id_02_desc])
            ->andFilterWhere(['like', 'id_03', $this->id_03])
            ->andFilterWhere(['like', 'id_03_desc', $this->id_03_desc])
            ->andFilterWhere(['like', 'id_04', $this->id_04])
            ->andFilterWhere(['like', 'id_04_desc', $this->id_04_desc])
            ->andFilterWhere(['like', 'id_05', $this->id_05])
            ->andFilterWhere(['like', 'id_05_desc', $this->id_05_desc])
            ->andFilterWhere(['like', 'id_06', $this->id_06])
            ->andFilterWhere(['like', 'id_06_desc', $this->id_06_desc])
            ->andFilterWhere(['like', 'id_07', $this->id_07])
            ->andFilterWhere(['like', 'id_07_desc', $this->id_07_desc])
            ->andFilterWhere(['like', 'id_08', $this->id_08])
            ->andFilterWhere(['like', 'id_08_desc', $this->id_08_desc])
            ->andFilterWhere(['like', 'id_09', $this->id_09])
            ->andFilterWhere(['like', 'id_09_desc', $this->id_09_desc])
            ->andFilterWhere(['like', 'id_10', $this->id_10])
            ->andFilterWhere(['like', 'id_10_desc', $this->id_10_desc])
            ->andFilterWhere(['like', 'id_update', $this->id_update])
            ->andFilterWhere(['like', 'id_update_desc', $this->id_update_desc])
            ->andFilterWhere(['like', 'sudah_cetak', $this->sudah_cetak])
            ->andFilterWhere(['like', 'id_prioty', $this->id_prioty])
            ->andFilterWhere(['like', 'id_prioty_desc', $this->id_prioty_desc])
            ->andFilterWhere(['like', 'id_hc', $this->id_hc])
            ->andFilterWhere(['like', 'id_hc_desc', $this->id_hc_desc])
            ->andFilterWhere(['like', 'id_hc_stat', $this->id_hc_stat])
            ->andFilterWhere(['like', 'id_hc_open', $this->id_hc_open])
            ->andFilterWhere(['like', 'id_hc_open_desc', $this->id_hc_open_desc])
            ->andFilterWhere(['like', 'id_hc_open_stat', $this->id_hc_open_stat])
            ->andFilterWhere(['like', 'pts_note', $this->pts_note])
            ->andFilterWhere(['like', 'show', $this->show])
            ->andFilterWhere(['like', 'back_up_period', $this->back_up_period])
            ->andFilterWhere(['like', 'back_up', $this->back_up])
            ->andFilterWhere(['like', 'id_11', $this->id_11])
            ->andFilterWhere(['like', 'id_11_desc', $this->id_11_desc])
            ->andFilterWhere(['like', 'id_12', $this->id_12])
            ->andFilterWhere(['like', 'id_12_desc', $this->id_12_desc])
            ->andFilterWhere(['like', 'id_13', $this->id_13])
            ->andFilterWhere(['like', 'id_13_desc', $this->id_13_desc])
            ->andFilterWhere(['like', 'id_14', $this->id_14])
            ->andFilterWhere(['like', 'id_14_desc', $this->id_14_desc])
            ->andFilterWhere(['like', 'id_15', $this->id_15])
            ->andFilterWhere(['like', 'id_15_desc', $this->id_15_desc])
            ->andFilterWhere(['like', 'id_16', $this->id_16])
            ->andFilterWhere(['like', 'id_16_desc', $this->id_16_desc])
            ->andFilterWhere(['like', 'id_17', $this->id_17])
            ->andFilterWhere(['like', 'id_17_desc', $this->id_17_desc])
            ->andFilterWhere(['like', 'id_18', $this->id_18])
            ->andFilterWhere(['like', 'id_18_desc', $this->id_18_desc])
            ->andFilterWhere(['like', 'id_19', $this->id_19])
            ->andFilterWhere(['like', 'id_19_desc', $this->id_19_desc])
            ->andFilterWhere(['like', 'id_20', $this->id_20])
            ->andFilterWhere(['like', 'id_20_desc', $this->id_20_desc])
            ->andFilterWhere(['like', 'model', $this->model]);

return $dataProvider;
}
}