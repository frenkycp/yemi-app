<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PcbInsertPointData;

/**
* PcbInsertPointSearch represents the model behind the search form about `app\models\PcbInsertPointData`.
*/
class PcbInsertPointSearch extends PcbInsertPointData
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['part_no', 'model_name', 'pcb', 'destination', 'sap_bu', 'last_update', 'bu'], 'safe'],
            [['smt_a', 'smt_b', 'smt', 'jv2', 'av131', 'rg131', 'ai', 'mi', 'total'], 'integer'],
            [['price'], 'number'],
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
$query = PcbInsertPointData::find();

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
            'smt_a' => $this->smt_a,
            'smt_b' => $this->smt_b,
            'smt' => $this->smt,
            'jv2' => $this->jv2,
            'av131' => $this->av131,
            'rg131' => $this->rg131,
            'ai' => $this->ai,
            'mi' => $this->mi,
            'total' => $this->total,
            'price' => $this->price,
            'last_update' => $this->last_update,
            'bu' => $this->bu,
        ]);

        $query->andFilterWhere(['like', 'part_no', $this->part_no])
            ->andFilterWhere(['like', 'model_name', $this->model_name])
            ->andFilterWhere(['like', 'pcb', $this->pcb])
            ->andFilterWhere(['like', 'destination', $this->destination]);

return $dataProvider;
}
}