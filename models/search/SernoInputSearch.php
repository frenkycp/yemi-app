<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SernoInput;

/**
* SernoInputSearch represents the model behind the search form about `app\models\SernoInput`.
*/
class SernoInputSearch extends SernoInput
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['num', 'flo', 'palletnum', 'adv'], 'integer'],
            [['pk', 'gmc', 'line', 'proddate', 'sernum', 'qa_ng', 'qa_ng_date', 'qa_ok', 'qa_ok_date', 'plan', 'ship'], 'safe'],
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
$query = SernoInput::find();

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
            'num' => $this->num,
            'flo' => $this->flo,
            'palletnum' => $this->palletnum,
            'adv' => $this->adv,
        ]);

        $query->andFilterWhere(['like', 'pk', $this->pk])
            ->andFilterWhere(['like', 'gmc', $this->gmc])
            ->andFilterWhere(['like', 'line', $this->line])
            ->andFilterWhere(['like', 'proddate', $this->proddate])
            ->andFilterWhere(['like', 'sernum', $this->sernum])
            ->andFilterWhere(['like', 'qa_ng', $this->qa_ng])
            ->andFilterWhere(['like', 'qa_ng_date', $this->qa_ng_date])
            ->andFilterWhere(['like', 'qa_ok', $this->qa_ok])
            ->andFilterWhere(['like', 'qa_ok_date', $this->qa_ok_date])
            ->andFilterWhere(['like', 'plan', $this->plan])
            ->andFilterWhere(['like', 'ship', $this->ship]);

return $dataProvider;
}
}