<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PrdMonthlyEff02;

/**
* PrdEffPtSearch represents the model behind the search form about `app\models\PrdMonthlyEff02`.
*/
class PrdEffPtSearch extends PrdMonthlyEff02
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['PERIOD', 'ITEM', 'ITEM_DESC'], 'safe'],
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
$query = PrdMonthlyEff02::find()->where(['>', 'TOTAL_QTY', 0]);

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
            'ITEM' => $this->ITEM,
        ]);

        $query->andFilterWhere(['like', 'ITEM_DESC', $this->ITEM_DESC]);

return $dataProvider;
}
}