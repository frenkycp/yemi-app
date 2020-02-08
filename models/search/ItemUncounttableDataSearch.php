<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ItemUncounttable;

/**
* ItemUncounttableDataSearch represents the model behind the search form about `app\models\ItemUncounttable`.
*/
class ItemUncounttableDataSearch extends ItemUncounttable
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['POST_DATE_ITEM', 'POST_DATE', 'ITEM', 'ITEM_DESC', 'ITEM_UM', 'SUPPLIER', 'SUPPLIER_DESC', 'KELOMPOK', 'TIPE', 'SHOW'], 'safe'],
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
$query = ItemUncounttable::find();

$dataProvider = new ActiveDataProvider([
      'query' => $query,
      'sort' => [
        'defaultOrder' => [
            //'cust_desc' => SORT_ASC,
            'POST_DATE' => SORT_DESC,
            'SHOW' => SORT_DESC
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
            'SHOW' => $this->SHOW,
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