<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SupplierBilling;

/**
* SBillingSearch represents the model behind the search form about `app\models\SupplierBilling`.
*/
class SBillingSearch extends SupplierBilling
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['no', 'supplier_name', 'UserName', 'Email', 'supplier_pic', 'receipt_no', 'invoice_no', 'delivery_no', 'tax_no', 'cur', 'doc_upload_by', 'doc_upload_date', 'doc_upload_stat', 'doc_received_by', 'doc_received_date', 'doc_received_stat', 'doc_finance_handover_by', 'doc_finance_handover_date', 'doc_finance_handover_stat', 'open_close', 'remark', 'voucher_no', 'dihapus'], 'safe'],
            [['id', 'stage'], 'integer'],
            [['amount'], 'number'],
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
$query = SupplierBilling::find();

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
            'id' => $this->id,
            'dihapus' => $this->dihapus,
            'amount' => $this->amount,
            'doc_upload_date' => $this->doc_upload_date,
            'doc_received_date' => $this->doc_received_date,
            'doc_finance_handover_date' => $this->doc_finance_handover_date,
            'stage' => $this->stage,
        ]);

        $query->andFilterWhere(['like', 'no', $this->no])
            ->andFilterWhere(['like', 'voucher_no', $this->voucher_no])
            ->andFilterWhere(['like', 'supplier_name', $this->supplier_name])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'Email', $this->Email])
            ->andFilterWhere(['like', 'supplier_pic', $this->supplier_pic])
            ->andFilterWhere(['like', 'receipt_no', $this->receipt_no])
            ->andFilterWhere(['like', 'invoice_no', $this->invoice_no])
            ->andFilterWhere(['like', 'delivery_no', $this->delivery_no])
            ->andFilterWhere(['like', 'tax_no', $this->tax_no])
            ->andFilterWhere(['like', 'cur', $this->cur])
            ->andFilterWhere(['like', 'doc_upload_by', $this->doc_upload_by])
            ->andFilterWhere(['like', 'doc_upload_stat', $this->doc_upload_stat])
            ->andFilterWhere(['like', 'doc_received_by', $this->doc_received_by])
            ->andFilterWhere(['like', 'doc_received_stat', $this->doc_received_stat])
            ->andFilterWhere(['like', 'doc_finance_handover_by', $this->doc_finance_handover_by])
            ->andFilterWhere(['like', 'doc_finance_handover_stat', $this->doc_finance_handover_stat])
            ->andFilterWhere(['like', 'open_close', $this->open_close])
            ->andFilterWhere(['like', 'remark', $this->remark]);

return $dataProvider;
}
}