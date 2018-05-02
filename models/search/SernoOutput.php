<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SernoOutput as SernoOutputModel;

/**
* SernoOutput represents the model behind the search form about `app\models\SernoOutput`.
*/
class SernoOutput extends SernoOutputModel
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['pk', 'stc', 'dst', 'gmc', 'etd'], 'safe'],
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
$query = SernoOutputModel::find();

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
            'id' => $this->id,
            'num' => $this->num,
            'qty' => $this->qty,
            'output' => $this->output,
            'adv' => $this->adv,
            'etd' => $this->etd,
            'cntr' => $this->cntr,
        ]);

        $query->andFilterWhere(['like', 'pk', $this->pk])
            ->andFilterWhere(['like', 'stc', $this->stc])
            ->andFilterWhere(['like', 'dst', $this->dst])
            ->andFilterWhere(['like', 'gmc', $this->gmc]);

return $dataProvider;
}
}