<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SupplierBillingVoucher;

/**
* SupplierBillingVoucherSearch represents the model behind the search form about `app\models\SupplierBillingVoucher`.
*/
class SupplierBillingVoucherSearch extends SupplierBillingVoucher
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['voucher_no', 'create_by_id', 'create_by_name', 'create_time', 'update_by_id', 'update_by_name', 'update_datetime', 'attachment', 'attached_by_id', 'attached_by_name', 'attached_time', 'handover_status', 'supplier_name'], 'safe'],
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
$query = SupplierBillingVoucher::find()
->select([
    'SUPPLIER_BILLING_VOUCHER.voucher_no', 'create_by_id', 'create_by_name', 'create_time', 'update_by_id', 'update_by_name', 'update_datetime', 'attachment', 'attached_by_id', 'attached_by_name', 'attached_time', 'handover_status', 'supplier_name' => 'SUPPLIER_BILLING.supplier_name', 'currency' => 'SUPPLIER_BILLING.cur', 'total_amount' => 'SUM(SUPPLIER_BILLING.amount)'
])
->joinWith('billingInvoice')
->where(['dihapus' => 'N'])
->groupBy([
    'SUPPLIER_BILLING_VOUCHER.voucher_no', 'create_by_id', 'create_by_name', 'create_time', 'update_by_id', 'update_by_name', 'update_datetime', 'attachment', 'attached_by_id', 'attached_by_name', 'attached_time', 'handover_status', 'SUPPLIER_BILLING.supplier_name', 'SUPPLIER_BILLING.cur'
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
            'create_time' => $this->create_time,
            'update_datetime' => $this->update_datetime,
            'attached_time' => $this->attached_time,
            'handover_status' => $this->handover_status,
        ]);

        $query->andFilterWhere(['like', 'voucher_no', $this->voucher_no])
            ->andFilterWhere(['like', 'create_by_id', $this->create_by_id])
            ->andFilterWhere(['like', 'SUPPLIER_BILLING.supplier_name', $this->supplier_name])
            ->andFilterWhere(['like', 'create_by_name', $this->create_by_name])
            ->andFilterWhere(['like', 'update_by_id', $this->update_by_id])
            ->andFilterWhere(['like', 'update_by_name', $this->update_by_name])
            ->andFilterWhere(['like', 'attachment', $this->attachment])
            ->andFilterWhere(['like', 'attached_by_id', $this->attached_by_id])
            ->andFilterWhere(['like', 'attached_by_name', $this->attached_by_name]);

return $dataProvider;
}
}