<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DrossOutput;

/**
* DrossOutputSearch represents the model behind the search form about `app\models\DrossOutput`.
*/
class DrossOutputSearch extends DrossOutput
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id'], 'integer'],
            [['mesin', 'tgl', 'period'], 'safe'],
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
$query = DrossOutput::find();

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
            'dross' => $this->dross,
            'dross_recycle' => $this->dross_recycle,
            'EXTRACT(year_month FROM tgl)' => $this->period,
        ]);

        $query->andFilterWhere(['like', 'mesin', $this->mesin])
            ->andFilterWhere(['like', 'tgl', $this->tgl]);

return $dataProvider;
}
}