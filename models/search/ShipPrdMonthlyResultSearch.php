<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ShipPrdMonthlyResult;

/**
* ShipPrdMonthlyResultSearch represents the model behind the search form about `app\models\ShipPrdMonthlyResult`.
*/
class ShipPrdMonthlyResultSearch extends ShipPrdMonthlyResult
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['PERIOD'], 'safe'],
            [['SHIP_PLAN_ORI_QTY', 'SHIP_PLAN_ORI_AMT', 'SHIP_PLAN_BO_QTY', 'SHIP_PLAN_BO_AMT', 'SHIP_PLAN_TOTAL_QTY', 'SHIP_PLAN_TOTAL_AMT', 'SHIP_ACT_ORI_QTY', 'SHIP_ACT_ORI_AMT', 'SHIP_ACT_BO_QTY', 'SHIP_ACT_BO_AMT', 'SHIP_ACT_TOTAL_QTY', 'SHIP_ACT_TOTAL_AMT', 'PRD_PLAN_ORI_QTY', 'PRD_PLAN_ORI_AMT', 'PRD_PLAN_DELAY_QTY', 'PRD_PLAN_DELAY_AMT', 'PRD_PLAN_TOTAL_QTY', 'PRD_PLAN_TOTAL_AMT', 'PRD_ACT_ORI_QTY', 'PRD_ACT_ORI_AMT', 'PRD_ACT_DELAY_QTY', 'PRD_ACT_DELAY_AMT', 'PRD_ACT_TOTAL_QTY', 'PRD_ACT_TOTAL_AMT'], 'number'],
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
$query = ShipPrdMonthlyResult::find();

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
            'SHIP_PLAN_ORI_QTY' => $this->SHIP_PLAN_ORI_QTY,
            'SHIP_PLAN_ORI_AMT' => $this->SHIP_PLAN_ORI_AMT,
            'SHIP_PLAN_BO_QTY' => $this->SHIP_PLAN_BO_QTY,
            'SHIP_PLAN_BO_AMT' => $this->SHIP_PLAN_BO_AMT,
            'SHIP_PLAN_TOTAL_QTY' => $this->SHIP_PLAN_TOTAL_QTY,
            'SHIP_PLAN_TOTAL_AMT' => $this->SHIP_PLAN_TOTAL_AMT,
            'SHIP_ACT_ORI_QTY' => $this->SHIP_ACT_ORI_QTY,
            'SHIP_ACT_ORI_AMT' => $this->SHIP_ACT_ORI_AMT,
            'SHIP_ACT_BO_QTY' => $this->SHIP_ACT_BO_QTY,
            'SHIP_ACT_BO_AMT' => $this->SHIP_ACT_BO_AMT,
            'SHIP_ACT_TOTAL_QTY' => $this->SHIP_ACT_TOTAL_QTY,
            'SHIP_ACT_TOTAL_AMT' => $this->SHIP_ACT_TOTAL_AMT,
            'PRD_PLAN_ORI_QTY' => $this->PRD_PLAN_ORI_QTY,
            'PRD_PLAN_ORI_AMT' => $this->PRD_PLAN_ORI_AMT,
            'PRD_PLAN_DELAY_QTY' => $this->PRD_PLAN_DELAY_QTY,
            'PRD_PLAN_DELAY_AMT' => $this->PRD_PLAN_DELAY_AMT,
            'PRD_PLAN_TOTAL_QTY' => $this->PRD_PLAN_TOTAL_QTY,
            'PRD_PLAN_TOTAL_AMT' => $this->PRD_PLAN_TOTAL_AMT,
            'PRD_ACT_ORI_QTY' => $this->PRD_ACT_ORI_QTY,
            'PRD_ACT_ORI_AMT' => $this->PRD_ACT_ORI_AMT,
            'PRD_ACT_DELAY_QTY' => $this->PRD_ACT_DELAY_QTY,
            'PRD_ACT_DELAY_AMT' => $this->PRD_ACT_DELAY_AMT,
            'PRD_ACT_TOTAL_QTY' => $this->PRD_ACT_TOTAL_QTY,
            'PRD_ACT_TOTAL_AMT' => $this->PRD_ACT_TOTAL_AMT,
        ]);

        $query->andFilterWhere(['like', 'PERIOD', $this->PERIOD]);

return $dataProvider;
}
}