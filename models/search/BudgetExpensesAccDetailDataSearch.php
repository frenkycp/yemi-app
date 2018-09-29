<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PoRcvAcc03Bgt;

/**
* AbsensiTblSearch represents the model behind the search form about `app\models\AbsensiTbl`.
*/
class BudgetExpensesAccDetailDataSearch extends PoRcvAcc03Bgt
{
/**
* @inheritdoc
*/
public function rules()
{
return [
            [['RCV_ID', 'POST_QTY', 'UNIT_PRICE', 'AMOUNT', 'MONTHLY_RATE', 'AMOUNT_USD', 'VAT', 'AMOUNT_AFTER_TAX'], 'number'],
            [['MONTH', 'POST_DATE'], 'safe'],
            [['PERIOD', 'ITEM_EQ', 'ITEM_DESC', 'ITEM_EQ_UM', 'SLIP', 'PO_HDR_NO_EQ', 'NO_EQ', 'PUR_LOC_EQ', 'PUR_LOC_DESC', 'CURR', 'DEP_DESC', 'PR_COST_DEP', 'PR_HDR_NO', 'RATE_ID', 'INVOICE_NO', 'VOUCHER', 'ACCOUNT_DESC', 'BUDGET_PERIOD', 'NOTE', 'BUDGET_ID', 'ACCOUNT', 'BUDGET_ID_ACC', 'STATUS', 'CONTROL', 'TYPE'], 'string'],
            [['NO', 'PR_NO'], 'integer']
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
$query = PoRcvAcc03Bgt::find();

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
            'BUDGET_ID_ACC' => $this->BUDGET_ID,
        ]);

return $dataProvider;
}
}