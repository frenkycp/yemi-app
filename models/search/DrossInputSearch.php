<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DrossInput;

/**
* DrossInputSearch represents the model behind the search form about `app\models\DrossInput`.
*/
class DrossInputSearch extends DrossInput
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id'], 'integer'],
            [['mesin', 'tgl_in', 'period'], 'safe'],
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
$query = DrossInput::find();

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
            'new' => $this->new,
            'recycle' => $this->recycle,
            'EXTRACT(year_month FROM tgl_in)' => $this->period,
        ]);

        $query->andFilterWhere(['like', 'mesin', $this->mesin])
            ->andFilterWhere(['like', 'tgl_in', $this->tgl_in]);

return $dataProvider;
}
}