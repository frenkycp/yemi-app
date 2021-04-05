<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SupplierBillingVoucherView;

/**
* SupplierBillingVoucherSearch represents the model behind the search form about `app\models\SupplierBillingVoucher`.
*/
class SupplierBillingVoucherSearch extends SupplierBillingVoucherView
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['voucher_period', 'create_time', 'voucher_no', 'handover_status', 'supplier_name', 'cur', 'payment_status'], 'safe'],
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
$query = SupplierBillingVoucherView::find();

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
            'voucher_period' => $this->voucher_period,
            'handover_status' => $this->handover_status,
            'payment_status' => $this->payment_status,
            'cur' => $this->cur,
        ]);

        $query->andFilterWhere(['like', 'voucher_no', $this->voucher_no])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),create_time,120)', $this->create_time])
            ->andFilterWhere(['like', 'supplier_name', $this->supplier_name]);

return $dataProvider;
}
}