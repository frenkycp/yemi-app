<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MinimumStock;

/**
* MinimumStockDataSearch represents the model behind the search form about `app\models\MinimumStock`.
*/
class MinimumStockDataSearch extends MinimumStock
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['ID_ITEM_LOC', 'ITEM', 'ITEM_EQ_DESC_01', 'ITEM_EQ_UM', 'LOC', 'LOC_DESC', 'PIC', 'PIC_DESC', 'DEP', 'DEP_DESC', 'HIGH_RISK', 'CATEGORY', 'USER_ID', 'USER_DESC', 'LAST_UPDATE', 'MACHINE', 'MACHINE_NAME', 'RACK'], 'safe'],
            [['MIN_STOCK_QTY'], 'number'],
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
$query = MinimumStock::find()->where([
      'LOC' => 'MNT'
]);

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
            'MIN_STOCK_QTY' => $this->MIN_STOCK_QTY,
            'LAST_UPDATE' => $this->LAST_UPDATE,
        ]);

        $query->andFilterWhere(['like', 'ID_ITEM_LOC', $this->ID_ITEM_LOC])
            ->andFilterWhere(['like', 'ITEM', $this->ITEM])
            ->andFilterWhere(['like', 'ITEM_EQ_DESC_01', $this->ITEM_EQ_DESC_01])
            ->andFilterWhere(['like', 'ITEM_EQ_UM', $this->ITEM_EQ_UM])
            ->andFilterWhere(['like', 'LOC', $this->LOC])
            ->andFilterWhere(['like', 'LOC_DESC', $this->LOC_DESC])
            ->andFilterWhere(['like', 'PIC', $this->PIC])
            ->andFilterWhere(['like', 'PIC_DESC', $this->PIC_DESC])
            ->andFilterWhere(['like', 'DEP', $this->DEP])
            ->andFilterWhere(['like', 'DEP_DESC', $this->DEP_DESC])
            ->andFilterWhere(['like', 'HIGH_RISK', $this->HIGH_RISK])
            ->andFilterWhere(['like', 'CATEGORY', $this->CATEGORY])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'USER_DESC', $this->USER_DESC])
            ->andFilterWhere(['like', 'MACHINE', $this->MACHINE])
            ->andFilterWhere(['like', 'MACHINE_NAME', $this->MACHINE_NAME])
            ->andFilterWhere(['like', 'RACK', $this->RACK]);

return $dataProvider;
}
}