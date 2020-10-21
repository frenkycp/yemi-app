<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AssetDtrTbl;

/**
* SubFixAssetSearch represents the model behind the search form about `app\models\AssetDtrTbl`.
*/
class SubFixAssetSearch extends AssetDtrTbl
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['dateacqledger', 'faid', 'subexp', 'fixed_asset_subid', 'voucher_number', 'deliveryorder', 'invoice', 'type', 'partnumberfa', 'kategori', 'description', 'date_of_payment', 'vendorid', 'vendor', 'currency', 'depr_date', 'order_numb', 'proposalnumb', 'budgetnumber', 'docbc', 'vouhpayment', 'proposalno', 'invoicescan', 'smartid'], 'safe'],
            [['qty', 'price_unit', 'rate', 'at_cost'], 'number'],
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
$query = AssetDtrTbl::find();

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
            'dateacqledger' => $this->dateacqledger,
            'qty' => $this->qty,
            'price_unit' => $this->price_unit,
            'rate' => $this->rate,
            'at_cost' => $this->at_cost,
            'depr_date' => $this->depr_date,
        ]);

        $query->andFilterWhere(['like', 'faid', $this->faid])
            ->andFilterWhere(['like', 'subexp', $this->subexp])
            ->andFilterWhere(['like', 'fixed_asset_subid', $this->fixed_asset_subid])
            ->andFilterWhere(['like', 'voucher_number', $this->voucher_number])
            ->andFilterWhere(['like', 'deliveryorder', $this->deliveryorder])
            ->andFilterWhere(['like', 'invoice', $this->invoice])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'partnumberfa', $this->partnumberfa])
            ->andFilterWhere(['like', 'kategori', $this->kategori])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'date_of_payment', $this->date_of_payment])
            ->andFilterWhere(['like', 'vendorid', $this->vendorid])
            ->andFilterWhere(['like', 'vendor', $this->vendor])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'order_numb', $this->order_numb])
            ->andFilterWhere(['like', 'proposalnumb', $this->proposalnumb])
            ->andFilterWhere(['like', 'budgetnumber', $this->budgetnumber])
            ->andFilterWhere(['like', 'docbc', $this->docbc])
            ->andFilterWhere(['like', 'vouhpayment', $this->vouhpayment])
            ->andFilterWhere(['like', 'proposalno', $this->proposalno])
            ->andFilterWhere(['like', 'invoicescan', $this->invoicescan])
            ->andFilterWhere(['like', 'smartid', $this->smartid]);

return $dataProvider;
}
}