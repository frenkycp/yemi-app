<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WipDtr;

/**
* WipBlueListSearch2 represents the model behind the search form about `app\models\WipDtr`.
*/
class WipBlueListSearch2 extends WipDtr
{
/**
* @inheritdoc
*/
public function rules()
{
return [
            [['dtr_id', 'hdr_id_item_due_date', 'hdr_id_item', 'hdr_id', 'upload_id', 'period', 'period_line', 'child', 'urut', 'slip_id', 'slip_id_barcode_label', 'stage', 'created_user_id', 'created_user_desc', 'start_job_user_id', 'start_job_user_desc', 'end_job_user_id', 'end_job_user_desc', 'hand_over_job_user_id', 'hand_over_job_user_desc', 'order_release_user_id', 'order_release_user_desc', 'start_cancel_job_user_id', 'start_cancel_job_user_desc', 'end_cancel_job_user_id', 'end_cancel_job_user_desc', 'stat', 'slip_id_reference', 'problem', 'fullfilment_stat', 'ipc_ok_ng', 'ipc_ok_ng_desc', 'ipc_in_id', 'ipc_in_id_user_desc', 'ipc_close_id', 'ipc_close_id_user_desc', 'calculated_close', 'recreate_close', 're_handover_close', 'repair_job_user_id', 'repair_job_user_desc', 'hand_over_cancel_job_user_id', 'hand_over_cancel_job_user_desc', 'note', 'completed_split_id', 'completed_split_desc'], 'string'],
            [['start_date', 'due_date', 'post_date', 'created_date', 'start_job', 'end_job', 'hand_over_job', 'order_release_date', 'start_cancel_job', 'end_cancel_job', 'source_date', 'repair_job', 'hand_over_cancel_job', 'completed_split', 'location', 'speaker_model', 'gmc', 'parent_desc'], 'safe'],
            [['plan_qty', 'act_qty', 'balance_act_qty', 'balance_by_day', 'plan_acc_qty', 'act_acc_qty', 'balance_acc_qty', 'source_qty', 'ipc_in_qty', 'lt_ipc', 'lt_started', 'lt_completed', 'lt_handover', 'bom_level'], 'number'],
            [['session_id'], 'integer'],
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
$query = WipDtr::find()
->joinWith('wipHdr')
->where([
    'stage' => '03-COMPLETED'
]);

$dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    //'cust_desc' => SORT_ASC,
                    'source_date' => SORT_DESC,
                ]
            ],
]);

$this->load($params);

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

/*$query->andFilterWhere([
            'plan_qty_hdr' => $this->plan_qty_hdr,
            'act_qty_hdr' => $this->act_qty_hdr,
            'balance_qty_hdr' => $this->balance_qty_hdr,
            'child_fx_lt' => $this->child_fx_lt,
            'child_dts_lt' => $this->child_dts_lt,
        ]);

        $query->andFilterWhere(['like', 'hdr_id_item', $this->hdr_id_item])
            ->andFilterWhere(['like', 'hdr_id', $this->hdr_id])
            ->andFilterWhere(['like', 'upload_id', $this->upload_id])
            ->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'period_line', $this->period_line])
            ->andFilterWhere(['like', 'child_analyst', $this->child_analyst])
            ->andFilterWhere(['like', 'child_analyst_desc', $this->child_analyst_desc])
            ->andFilterWhere(['like', 'child', $this->child])
            ->andFilterWhere(['like', 'child_desc', $this->child_desc])
            ->andFilterWhere(['like', 'model_group', $this->model_group])
            ->andFilterWhere(['like', 'parent', $this->parent])
            ->andFilterWhere(['like', 'parent_desc', $this->parent_desc]);*/

        $query->andFilterWhere([
            'slip_id' => $this->slip_id,
            'session_id' => $this->session_id,
            'WIP_DTR.period_line' => $this->period_line,
            'WIP_DTR.child' => $this->child,
            'source_date' => $this->source_date,
            'due_date' => $this->due_date,
            'WIP_HDR.parent' => $this->gmc
        ]);

        $query->andFilterWhere(['like', 'WIP_HDR.child_analyst', $this->location])
        ->andFilterWhere(['like', 'WIP_HDR.parent_desc', $this->parent_desc])
        ->andFilterWhere(['like', 'WIP_HDR.model_group', $this->speaker_model]);

return $dataProvider;
}
}