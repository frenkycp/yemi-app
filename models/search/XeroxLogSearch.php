<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FotocopyLogTbl;

/**
* XeroxLogSearch represents the model behind the search form about `app\models\FotocopyLogTbl`.
*/
class XeroxLogSearch extends FotocopyLogTbl
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['machine', 'period', 'post_date', 'date_completed', 'NIK', 'NIK_DESC', 'COST_CENTER', 'COST_CENTER_DESC', 'EMAIL_ADDRESS', 'date', 'year', 'month', 'day', 'year_month', 'month_day', 'time_completed', 'job_type', 'job_type_details', 'input_send_type', 'input_port', 'pc_name', 'user_id', 'user_name', 'account_id', 'document_name', 'output_destination', 'pdl', 'job_status', 'fault_code', 'related_job', 'job_number_id1', 'document_number', 'folder_number', 'fax_recipient_name', 'fax_remote_terminal_name', 'fax_remote_id', 'fax_number', 'fax_start_date', 'fax_start_time', 'fax_duration', 'fax_communication_protocol', 'fax_communication_result', 'fax_speed_dial', 'nama_file', 'last_update'], 'safe'],
            [['page_1', 'pages_2', 'pages_4', 'pages_per_side', 'sided_1', 'sided_2', 'color_a4', 'color_b4', 'color_a3', 'color_letter', 'color_legal', 'color_ledger', 'color_others', 'black_white_a4', 'black_white_b4', 'black_white_a3', 'black_white_letter', 'black_white_legal', 'black_white_ledger', 'black_white_others', 'a4_plain', 'a4_plain_reload', 'a4_others', 'b4_plain', 'b4_plain_reload', 'b4_others', 'a3_plain', 'a3_plain_reload', 'a3_others', 'letter_plain', 'letter_plain_reload', 'letter_others', 'legal_plain', 'legal_plain_reload', 'legal_others', 'ledger_plain', 'ledger_plain_reload', 'ledger_others', 'others_plain', 'others_plain_reload', 'others_others', 'color_original_a4', 'color_original_b4', 'color_original_a3', 'color_original_letter', 'color_original_legal', 'color_original_ledger', 'color_original_others', 'black_white_original_a4', 'black_white_original_b4', 'black_white_original_a3', 'black_white_original_letter', 'black_white_original_legal', 'black_white_original_ledger', 'black_white_original_others', 'job_number_id2', 'fax_images_sent', 'fax_images_received', 'total_color_pages', 'total_black_white_pages', 'total_pages', 'total_sheets'], 'integer'],
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
$query = FotocopyLogTbl::find()->where([
      'job_type' => ['Print', 'Copy']
]);

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
            'post_date' => $this->post_date,
            'date_completed' => $this->date_completed,
            'page_1' => $this->page_1,
            'pages_2' => $this->pages_2,
            'pages_4' => $this->pages_4,
            'pages_per_side' => $this->pages_per_side,
            'sided_1' => $this->sided_1,
            'sided_2' => $this->sided_2,
            'color_a4' => $this->color_a4,
            'color_b4' => $this->color_b4,
            'color_a3' => $this->color_a3,
            'color_letter' => $this->color_letter,
            'color_legal' => $this->color_legal,
            'color_ledger' => $this->color_ledger,
            'color_others' => $this->color_others,
            'black_white_a4' => $this->black_white_a4,
            'black_white_b4' => $this->black_white_b4,
            'black_white_a3' => $this->black_white_a3,
            'black_white_letter' => $this->black_white_letter,
            'black_white_legal' => $this->black_white_legal,
            'black_white_ledger' => $this->black_white_ledger,
            'black_white_others' => $this->black_white_others,
            'a4_plain' => $this->a4_plain,
            'a4_plain_reload' => $this->a4_plain_reload,
            'a4_others' => $this->a4_others,
            'b4_plain' => $this->b4_plain,
            'b4_plain_reload' => $this->b4_plain_reload,
            'b4_others' => $this->b4_others,
            'a3_plain' => $this->a3_plain,
            'a3_plain_reload' => $this->a3_plain_reload,
            'a3_others' => $this->a3_others,
            'letter_plain' => $this->letter_plain,
            'letter_plain_reload' => $this->letter_plain_reload,
            'letter_others' => $this->letter_others,
            'legal_plain' => $this->legal_plain,
            'legal_plain_reload' => $this->legal_plain_reload,
            'legal_others' => $this->legal_others,
            'ledger_plain' => $this->ledger_plain,
            'ledger_plain_reload' => $this->ledger_plain_reload,
            'ledger_others' => $this->ledger_others,
            'others_plain' => $this->others_plain,
            'others_plain_reload' => $this->others_plain_reload,
            'others_others' => $this->others_others,
            'color_original_a4' => $this->color_original_a4,
            'color_original_b4' => $this->color_original_b4,
            'color_original_a3' => $this->color_original_a3,
            'color_original_letter' => $this->color_original_letter,
            'color_original_legal' => $this->color_original_legal,
            'color_original_ledger' => $this->color_original_ledger,
            'color_original_others' => $this->color_original_others,
            'black_white_original_a4' => $this->black_white_original_a4,
            'black_white_original_b4' => $this->black_white_original_b4,
            'black_white_original_a3' => $this->black_white_original_a3,
            'black_white_original_letter' => $this->black_white_original_letter,
            'black_white_original_legal' => $this->black_white_original_legal,
            'black_white_original_ledger' => $this->black_white_original_ledger,
            'black_white_original_others' => $this->black_white_original_others,
            'job_number_id2' => $this->job_number_id2,
            'fax_images_sent' => $this->fax_images_sent,
            'fax_images_received' => $this->fax_images_received,
            'total_color_pages' => $this->total_color_pages,
            'total_black_white_pages' => $this->total_black_white_pages,
            'total_pages' => $this->total_pages,
            'total_sheets' => $this->total_sheets,
            'last_update' => $this->last_update,
        ]);

        $query->andFilterWhere(['like', 'machine', $this->machine])
            ->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'NIK', $this->NIK])
            ->andFilterWhere(['like', 'NIK_DESC', $this->NIK_DESC])
            ->andFilterWhere(['like', 'COST_CENTER', $this->COST_CENTER])
            ->andFilterWhere(['like', 'COST_CENTER_DESC', $this->COST_CENTER_DESC])
            ->andFilterWhere(['like', 'EMAIL_ADDRESS', $this->EMAIL_ADDRESS])
            ->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'year', $this->year])
            ->andFilterWhere(['like', 'month', $this->month])
            ->andFilterWhere(['like', 'day', $this->day])
            ->andFilterWhere(['like', 'year_month', $this->year_month])
            ->andFilterWhere(['like', 'month_day', $this->month_day])
            ->andFilterWhere(['like', 'time_completed', $this->time_completed])
            ->andFilterWhere(['like', 'job_type', $this->job_type])
            ->andFilterWhere(['like', 'job_type_details', $this->job_type_details])
            ->andFilterWhere(['like', 'input_send_type', $this->input_send_type])
            ->andFilterWhere(['like', 'input_port', $this->input_port])
            ->andFilterWhere(['like', 'pc_name', $this->pc_name])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'account_id', $this->account_id])
            ->andFilterWhere(['like', 'document_name', $this->document_name])
            ->andFilterWhere(['like', 'output_destination', $this->output_destination])
            ->andFilterWhere(['like', 'pdl', $this->pdl])
            ->andFilterWhere(['like', 'job_status', $this->job_status])
            ->andFilterWhere(['like', 'fault_code', $this->fault_code])
            ->andFilterWhere(['like', 'related_job', $this->related_job])
            ->andFilterWhere(['like', 'job_number_id1', $this->job_number_id1])
            ->andFilterWhere(['like', 'document_number', $this->document_number])
            ->andFilterWhere(['like', 'folder_number', $this->folder_number])
            ->andFilterWhere(['like', 'fax_recipient_name', $this->fax_recipient_name])
            ->andFilterWhere(['like', 'fax_remote_terminal_name', $this->fax_remote_terminal_name])
            ->andFilterWhere(['like', 'fax_remote_id', $this->fax_remote_id])
            ->andFilterWhere(['like', 'fax_number', $this->fax_number])
            ->andFilterWhere(['like', 'fax_start_date', $this->fax_start_date])
            ->andFilterWhere(['like', 'fax_start_time', $this->fax_start_time])
            ->andFilterWhere(['like', 'fax_duration', $this->fax_duration])
            ->andFilterWhere(['like', 'fax_communication_protocol', $this->fax_communication_protocol])
            ->andFilterWhere(['like', 'fax_communication_result', $this->fax_communication_result])
            ->andFilterWhere(['like', 'fax_speed_dial', $this->fax_speed_dial])
            ->andFilterWhere(['like', 'nama_file', $this->nama_file]);

return $dataProvider;
}
}