<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StoreOnhandWsus;

/**
* StoreOnhandWsusSearch represents the model behind the search form about `app\models\StoreOnhandWsus`.
*/
class StoreOnhandWsusSearch extends StoreOnhandWsus
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['ITEM', 'ITEM_DESC', 'UM', 'PI_DUMMY'], 'safe'],
            [['ONHAND_QTY'], 'number'],
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
$query = StoreOnhandWsus::find();

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
            'ONHAND_QTY' => $this->ONHAND_QTY,
        ]);

        $query->andFilterWhere(['like', 'ITEM', $this->ITEM])
            ->andFilterWhere(['like', 'ITEM_DESC', $this->ITEM_DESC])
            ->andFilterWhere(['like', 'UM', $this->UM])
            ->andFilterWhere(['like', 'PI_DUMMY', $this->PI_DUMMY]);

return $dataProvider;
}
}