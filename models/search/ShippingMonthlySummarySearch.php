<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ShippingMonthlySummary;

/**
* ShippingMonthlySummarySearch represents the model behind the search form about `app\models\ShippingMonthlySummary`.
*/
class ShippingMonthlySummarySearch extends ShippingMonthlySummary
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['period', 'sent_email_datetime'], 'safe'],
            [['final_product_so', 'final_product_act', 'final_product_ratio', 'kd_so', 'kd_act', 'kd_ratio'], 'number'],
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
$query = ShippingMonthlySummary::find();

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
        'defaultOrder' => [
            //'cust_desc' => SORT_ASC,
            'period' => SORT_DESC,
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
            'final_product_so' => $this->final_product_so,
            'final_product_act' => $this->final_product_act,
            'final_product_ratio' => $this->final_product_ratio,
            'kd_so' => $this->kd_so,
            'kd_act' => $this->kd_act,
            'kd_ratio' => $this->kd_ratio,
            'sent_email_datetime' => $this->sent_email_datetime,
        ]);

        $query->andFilterWhere(['like', 'period', $this->period]);

return $dataProvider;
}
}