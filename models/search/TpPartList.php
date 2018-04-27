<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TpPartList as TpPartListModel;

/**
* TpPartList represents the model behind the search form about `app\models\TpPartList`.
*/
class TpPartList extends TpPartListModel
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['tp_part_list_id', 'rev_no'], 'integer'],
            [['speaker_model', 'part_no', 'part_name', 'pc_remarks', 'present_po', 'present_due_date', 'dcn_no', 'part_type', 'part_status', 'caf_no', 'direct_po_trf', 'purch_status', 'pc_status', 'delivery_conf_etd', 'delivery_conf_eta', 'act_delivery_etd', 'act_delivery_eta', 'invoice', 'transport_by', 'pe_confirm', 'status', 'qa_judgement', 'qa_remark', 'last_modified', 'last_modified_by'], 'safe'],
            [['total_product', 'total_assy', 'total_spare_part', 'total_requirement', 'present_qty', 'qty', 'transportation_cost'], 'number'],
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
$query = TpPartListModel::find();

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
            'tp_part_list_id' => $this->tp_part_list_id,
            'rev_no' => $this->rev_no,
            'total_product' => $this->total_product,
            'total_assy' => $this->total_assy,
            'total_spare_part' => $this->total_spare_part,
            'total_requirement' => $this->total_requirement,
            'present_due_date' => $this->present_due_date,
            'present_qty' => $this->present_qty,
            'qty' => $this->qty,
            'transportation_cost' => $this->transportation_cost,
            'last_modified' => $this->last_modified,
        ]);

        $query->andFilterWhere(['like', 'speaker_model', $this->speaker_model])
            ->andFilterWhere(['like', 'part_no', $this->part_no])
            ->andFilterWhere(['like', 'part_name', $this->part_name])
            ->andFilterWhere(['like', 'pc_remarks', $this->pc_remarks])
            ->andFilterWhere(['like', 'present_po', $this->present_po])
            ->andFilterWhere(['like', 'dcn_no', $this->dcn_no])
            ->andFilterWhere(['like', 'part_type', $this->part_type])
            ->andFilterWhere(['like', 'part_status', $this->part_status])
            ->andFilterWhere(['like', 'caf_no', $this->caf_no])
            ->andFilterWhere(['like', 'direct_po_trf', $this->direct_po_trf])
            ->andFilterWhere(['like', 'purch_status', $this->purch_status])
            ->andFilterWhere(['like', 'pc_status', $this->pc_status])
            ->andFilterWhere(['like', 'delivery_conf_etd', $this->delivery_conf_etd])
            ->andFilterWhere(['like', 'delivery_conf_eta', $this->delivery_conf_eta])
            ->andFilterWhere(['like', 'act_delivery_etd', $this->act_delivery_etd])
            ->andFilterWhere(['like', 'act_delivery_eta', $this->act_delivery_eta])
            ->andFilterWhere(['like', 'invoice', $this->invoice])
            ->andFilterWhere(['like', 'transport_by', $this->transport_by])
            ->andFilterWhere(['like', 'pe_confirm', $this->pe_confirm])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'qa_judgement', $this->qa_judgement])
            ->andFilterWhere(['like', 'qa_remark', $this->qa_remark])
            ->andFilterWhere(['like', 'last_modified_by', $this->last_modified_by]);

return $dataProvider;
}
}