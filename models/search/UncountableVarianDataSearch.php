<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ItemUncountableSummaryReport2;

/**
* ItemUncountableSummaryReport2DataSearch represents the model behind the search form about `app\models\ItemUncountableSummaryReport2`.
*/
class ItemUncountableSummaryReport2DataSearch extends ItemUncountableSummaryReport2
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['ITEM', 'ITEM_DESC', 'ITEM_UM', 'SUPPLIER', 'SUPPLIER_DESC', 'KELOMPOK', 'TIPE'], 'safe'],
            [['MAT_SAP', 'MAT_WSUS', 'MAT_DIFF', 'WIP_SAP', 'WIP_PI', 'WIP_DIFF', 'TOT_SAP', 'TOT_WSUS_PI', 'TOT_DIFF'], 'number'],
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
$query = ItemUncountableSummaryReport2::find();

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
            'POST_DATE' => $this->POST_DATE,
            'MAT_SAP' => $this->MAT_SAP,
            'MAT_WSUS' => $this->MAT_WSUS,
            'MAT_DIFF' => $this->MAT_DIFF,
            'WIP_SAP' => $this->WIP_SAP,
            'WIP_PI' => $this->WIP_PI,
            'WIP_DIFF' => $this->WIP_DIFF,
            'TOT_SAP' => $this->TOT_SAP,
            'TOT_WSUS_PI' => $this->TOT_WSUS_PI,
            'TOT_DIFF' => $this->TOT_DIFF,
        ]);

        $query->andFilterWhere(['like', 'POST_DATE_ITEM', $this->POST_DATE_ITEM])
            ->andFilterWhere(['like', 'ITEM', $this->ITEM])
            ->andFilterWhere(['like', 'ITEM_DESC', $this->ITEM_DESC])
            ->andFilterWhere(['like', 'ITEM_UM', $this->ITEM_UM])
            ->andFilterWhere(['like', 'SUPPLIER', $this->SUPPLIER])
            ->andFilterWhere(['like', 'SUPPLIER_DESC', $this->SUPPLIER_DESC])
            ->andFilterWhere(['like', 'KELOMPOK', $this->KELOMPOK])
            ->andFilterWhere(['like', 'TIPE', $this->TIPE]);

return $dataProvider;
}
}