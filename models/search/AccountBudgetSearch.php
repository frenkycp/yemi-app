<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AccountBudget;

/**
* AccountBudgetSearch represents the model behind the search form about `app\models\AccountBudget`.
*/
class AccountBudgetSearch extends AccountBudget
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['BUDGET_ID', 'ACCOUNT', 'ACCOUNT_DESC', 'DEP', 'DEP_DESC', 'STATUS', 'CONTROL'], 'safe'],
            [['PERIOD'], 'integer'],
            [['BUDGET_AMT', 'CONSUME_AMT', 'BALANCE_AMT'], 'number'],
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
$query = AccountBudget::find();

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
            'PERIOD' => $this->PERIOD,
            'BUDGET_AMT' => $this->BUDGET_AMT,
            'CONSUME_AMT' => $this->CONSUME_AMT,
            'BALANCE_AMT' => $this->BALANCE_AMT,
        ]);

        $query->andFilterWhere(['like', 'BUDGET_ID', $this->BUDGET_ID])
            ->andFilterWhere(['like', 'ACCOUNT', $this->ACCOUNT])
            ->andFilterWhere(['like', 'ACCOUNT_DESC', $this->ACCOUNT_DESC])
            ->andFilterWhere(['like', 'DEP', $this->DEP])
            ->andFilterWhere(['like', 'DEP_DESC', $this->DEP_DESC])
            ->andFilterWhere(['like', 'STATUS', $this->STATUS])
            ->andFilterWhere(['like', 'CONTROL', $this->CONTROL]);

return $dataProvider;
}
}