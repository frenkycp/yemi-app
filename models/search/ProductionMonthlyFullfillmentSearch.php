<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SernoOutput as SernoOutputModel;

/**
* SernoOutput represents the model behind the search form about `app\models\SernoOutput`.
*/
class ProductionMonthlyFullfillmentSearch extends SernoOutputModel
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['pk', 'stc', 'gmc', 'etd', 'category', 'description', 'line', 'vms', 'dst'], 'safe'],
            [['id', 'num', 'qty', 'output', 'adv', 'cntr'], 'integer'],
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
$query = SernoOutputModel::find()
->where([
    'back_order' => 1
]);

$query->joinWith('sernoMaster');

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
            'tb_serno_output.id' => $this->id,
            'num' => $this->num,
            'qty' => $this->qty,
            'output' => $this->output,
            'adv' => $this->adv,
            'cntr' => $this->cntr,
        ]);

        $query->andFilterWhere(['like', 'pk', $this->pk])
            ->andFilterWhere(['like', 'stc', $this->stc])
            ->andFilterWhere(['like', 'etd', $this->etd])
            ->andFilterWhere(['like', 'tb_serno_master.model', $this->description])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'dst', $this->dst])
            ->andFilterWhere(['like', 'tb_serno_output.gmc', $this->gmc]);

return $dataProvider;
}
}