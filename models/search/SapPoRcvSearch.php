<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SapPoRcv;

/**
* SapPoRcvSearch represents the model behind the search form about `app\models\SapPoRcv`.
*/
class SapPoRcvSearch extends SapPoRcv
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['seq_id'], 'integer'],
            [['local_import', 'currency', 'abc_indicator', 'vendor_code', 'vendor_name', 'payment_terms', 'freight_cond_type', 'insurance_cond_type', 'internal_exp_cond_type', 'no', 'rcv_date', 'material_document_number', 'item_no', 'inv_no', 'po_id', 'slip_no', 'acct_assig_cat', 'material', 'description', 'um', 'pur_um', 'direct_indirect', 'nat_acc', 'nat_acc_desc', 'cost_center', 'cost_center_desc', 'purchasing_group', 'vendor_country_code', 'order_date', 'order_delivery_date', 'relied_delivery_date', 'storage_location_po', 'movement_type', 'lt_po', 'grt_po', 'stock_type_po', 'delivery_completed', 'cust_doc_date', 'doc_type', 'cust_doc_no', 'po_no', 'po_line', 'upload', 'period', 'fix_add', 'voucher_no', 'invoice_act', 'kwitansi_act', 'status', 'bc_type', 'bc_no', 'bc_date', 'sign', 'upload_date', 'asano_doc', 'asano_invoice', 'pic', 'division', 'sinkron', 'Inspection_level', 'Judgement', 'Remark'], 'safe'],
            [['rate', 'freight', 'insurance', 'internal_exp', 'quantity', 'quantity_pur_unit', 'unit_price', 'amount_rcv', 'amount_ppn', 'amount_wh', 'amount_usd', 'amount_freight', 'amount_insurance', 'amount_internal_exp', 'amount_total_charges', 'amount_total', 'std_price', 'std_amount', 'order_quantity', 'relied_delivery_qty', 'price_act', 'amount_act', 'variance_act'], 'number'],
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
$query = SapPoRcv::find();

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
            'quantity' => $this->quantity,
            'rcv_date' => $this->rcv_date
        ]);

        $query->andFilterWhere(['like', 'vendor_name', $this->vendor_name])
            ->andFilterWhere(['like', 'inv_no', $this->inv_no])
            ->andFilterWhere(['like', 'material', $this->material])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'Inspection_level', $this->Inspection_level])
            ->andFilterWhere(['like', 'Judgement', $this->Judgement])
            ->andFilterWhere(['like', 'Remark', $this->Remark]);

return $dataProvider;
}
}