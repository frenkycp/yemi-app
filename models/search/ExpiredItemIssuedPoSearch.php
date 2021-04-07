<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TraceItemRequestPcView;

/**
* ExpiredItemIssuedPoSearch represents the model behind the search form about `app\models\TraceItemRequestPcView`.
*/
class ExpiredItemIssuedPoSearch extends TraceItemRequestPcView
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['REQUEST_ID', 'LOT_NO', 'CREATE_BY_ID', 'CREATE_BY_NAME', 'CREATE_DATETIME', 'PO_NO', 'ITEM', 'ITEM_DESC', 'SUPPLIER_DESC', 'TOTAL_QTY', 'UM', 'PLAN_QTY', 'STATUS', 'SCRAP_QTY'], 'safe'],
            [['CATEGORY'], 'integer'],
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
$query = TraceItemRequestPcView::find();

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
            'CATEGORY' => $this->CATEGORY,
            'TOTAL_QTY' => $this->TOTAL_QTY,
            'PLAN_QTY' => $this->PLAN_QTY,
            'SCRAP_QTY' => $this->SCRAP_QTY,
            'STATUS' => $this->STATUS,
            'UM' => $this->UM,
        ]);

        $query->andFilterWhere(['like', 'REQUEST_ID', $this->REQUEST_ID])
        	->andFilterWhere(['like', 'CONVERT(VARCHAR(10),CREATE_DATETIME,120)', $this->CREATE_DATETIME])
            ->andFilterWhere(['like', 'LOT_NO', $this->LOT_NO])
            ->andFilterWhere(['like', 'ITEM', $this->ITEM])
            ->andFilterWhere(['like', 'ITEM_DESC', $this->ITEM_DESC])
            ->andFilterWhere(['like', 'SUPPLIER_DESC', $this->SUPPLIER_DESC])
            ->andFilterWhere(['like', 'CREATE_BY_ID', $this->CREATE_BY_ID])
            ->andFilterWhere(['like', 'CREATE_BY_NAME', $this->CREATE_BY_NAME])
            ->andFilterWhere(['like', 'PO_NO', $this->PO_NO]);

return $dataProvider;
}
}