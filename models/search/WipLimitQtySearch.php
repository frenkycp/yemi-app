<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WipLimitQty;

/**
* WipLimitQtySearch represents the model behind the search form about `app\models\WipLimitQty`.
*/
class WipLimitQtySearch extends WipLimitQty
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['child_analyst', 'child_analyst_desc'], 'safe'],
            [['limit_qty'], 'number'],
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
$query = WipLimitQty::find();

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
        'defaultOrder' => [
            //'cust_desc' => SORT_ASC,
            'child_analyst_desc' => SORT_ASC,
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
            'limit_qty' => $this->limit_qty,
        ]);

        $query->andFilterWhere(['like', 'child_analyst', $this->child_analyst])
            ->andFilterWhere(['like', 'child_analyst_desc', $this->child_analyst_desc]);

return $dataProvider;
}
}