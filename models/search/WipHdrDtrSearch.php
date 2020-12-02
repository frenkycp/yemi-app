<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WipHdrDtrUnion;

/**
* CisClientIpAddressSearch represents the model behind the search form about `app\models\CisClientIpAddress`.
*/
class WipHdrDtrSearch extends WipHdrDtrUnion
{
	/**
	* @inheritdoc
	*/
	public function rules()
	{
		return [
		    [['dtr_id', 'hdr_id_item', 'hdr_id', 'upload_id', 'period', 'period_line', 'child_analyst', 'child_analyst_desc', 'child', 'child_desc', 'model_group', 'parent', 'parent_desc', 'urut', 'slip_id', 'stage', 'slip_id_barcode_label', 'created_user_id', 'created_user_desc', 'start_job_user_id', 'start_job_user_desc', 'end_job_user_id', 'end_job_user_desc', 'hand_over_job_user_id', 'hand_over_job_user_desc', 'order_release_user_id', 'order_release_user_desc', 'start_cancel_job_user_id', 'start_cancel_job_user_desc', 'end_cancel_job_user_id', 'end_cancel_job_user_desc', 'stat', 'slip_id_reference', 'problem', 'fullfilment_stat', 'ipc_ok_ng', 'ipc_in_id', 'ipc_ok_ng_desc', 'ipc_in_id_user_desc', 'ipc_close_id', 'ipc_close_id_user_desc', 'calculated_close', 'recreate_close', 'hdr_id_item_due_date', 're_handover_close', 'repair_job_user_id', 'repair_job_user_desc', 'hand_over_cancel_job_user_id', 'hand_over_cancel_job_user_desc', 'note', 'completed_split_id', 'completed_split_desc', 'reservation', 'reservation_number', 'delay_category', 'delay_detail', 'delay_userid', 'delay_userid_desc'], 'string'],
            [['start_date', 'due_date', 'created_date', 'start_job', 'end_job', 'hand_over_job', 'source_date', 'order_release_date', 'start_cancel_job', 'end_cancel_job', 'post_date', 'repair_job', 'hand_over_cancel_job', 'completed_split', 'delay_last_update', 'fa_lot_no', 'fa_lot_qty', 'LINE'], 'safe'],
            [['plan_qty', 'act_qty', 'balance_by_day', 'plan_acc_qty', 'act_acc_qty', 'balance_acc_qty', 'plan_qty_hdr', 'act_qty_hdr', 'balance_qty_hdr', 'child_fx_lt', 'child_dts_lt', 'balance_act_qty', 'source_qty', 'ipc_in_qty', 'lt_ipc', 'lt_started', 'lt_completed', 'lt_handover', 'bom_level', 'gojek_req_qty', 'std_time', 'std_time_x_act_qty'], 'number'],
            [['session_id'], 'integer']
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
		$query = WipHdrDtrUnion::find()
		->where('(act_qty - balance_by_day_2) <> 0');

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
		        'defaultOrder' => [
		            //'cust_desc' => SORT_ASC,
		            //'source_date' => SORT_DESC,
		            'model_group' => SORT_ASC,
		            'child_desc' => SORT_ASC,
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
            'session_id' => $this->session_id,
            'delay_category' => $this->delay_category,
            'fa_lot_no' => $this->fa_lot_no,
            'fa_lot_qty' => $this->fa_lot_qty,
            'LINE' => $this->LINE,
        ]);

        $query->andFilterWhere(['like', 'period', $this->period])
        ->andFilterWhere(['like', 'slip_id', $this->slip_id])
        ->andFilterWhere(['like', 'upload_id', $this->upload_id])
        ->andFilterWhere(['like', 'child_analyst', $this->child_analyst])
        ->andFilterWhere(['like', 'child_analyst_desc', $this->child_analyst_desc])
        ->andFilterWhere(['like', 'model_group', $this->model_group])
        ->andFilterWhere(['like', 'parent', $this->parent])
        ->andFilterWhere(['like', 'parent_desc', $this->parent_desc])
        ->andFilterWhere(['like', 'child', $this->child])
        ->andFilterWhere(['like', 'child_desc', $this->child_desc])
        ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),start_date,120)', $this->start_date])
        ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),delay_last_update,120)', $this->delay_last_update])
        ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),due_date,120)', $this->due_date])
        ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),post_date,120)', $this->post_date])
        ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),source_date,120)', $this->source_date])
        ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),end_job,120)', $this->end_job])
        ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),hand_over_job,120)', $this->hand_over_job])
        ->andFilterWhere(['like', 'stage', $this->stage])
        ->andFilterWhere(['like', 'problem', $this->problem])
        ->andFilterWhere(['like', 'slip_id_reference', $this->slip_id_reference])
        ->andFilterWhere(['like', 'period_line', $this->period_line])
        ->andFilterWhere(['like', 'delay_userid', $this->delay_userid])
        ->andFilterWhere(['like', 'delay_userid_desc', $this->delay_userid_desc])
        ->andFilterWhere(['like', 'delay_detail', $this->delay_detail])
        ->andFilterWhere(['like', 'fullfilment_stat', $this->fullfilment_stat]);

		return $dataProvider;
	}
}