<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SalesBudgetCompare;

/**
* SalesBudgetCompareSearch represents the model behind the search form about `app\models\SalesBudgetCompare`.
*/
class SalesBudgetCompareSearch extends SalesBudgetCompare
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['ITEM_INDEX', 'ITEM', 'DESC', 'NO', 'MODEL', 'MODEL_GROUP', 'BU', 'TYPE', 'FISCAL', 'PERIOD'], 'safe'],
            [['QTY_BGT', 'AMOUNT_BGT', 'QTY_ACT_FOR', 'AMOUNT_ACT_FOR', 'QTY_BALANCE', 'AMOUNT_BALANCE'], 'number'],
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
$query = SalesBudgetCompare::find();

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
            'QTY_BGT' => $this->QTY_BGT,
            'AMOUNT_BGT' => $this->AMOUNT_BGT,
            'QTY_ACT_FOR' => $this->QTY_ACT_FOR,
            'AMOUNT_ACT_FOR' => $this->AMOUNT_ACT_FOR,
            'QTY_BALANCE' => $this->QTY_BALANCE,
            'AMOUNT_BALANCE' => $this->AMOUNT_BALANCE,
        ]);

        $query->andFilterWhere(['like', 'ITEM_INDEX', $this->ITEM_INDEX])
            ->andFilterWhere(['like', 'ITEM', $this->ITEM])
            ->andFilterWhere(['like', 'DESC', $this->DESC])
            ->andFilterWhere(['like', 'NO', $this->NO])
            ->andFilterWhere(['like', 'MODEL', $this->MODEL])
            ->andFilterWhere(['like', 'MODEL_GROUP', $this->MODEL_GROUP])
            ->andFilterWhere(['like', 'BU', $this->BU])
            ->andFilterWhere(['like', 'TYPE', $this->TYPE])
            ->andFilterWhere(['like', 'FISCAL', $this->FISCAL])
            ->andFilterWhere(['like', 'PERIOD', $this->PERIOD]);

return $dataProvider;
}
}