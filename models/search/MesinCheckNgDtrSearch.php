<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MesinCheckNgDtr;

/**
* MesinCheckNgDtrSearch represents the model behind the search form about `app\models\MesinCheckNgDtr`.
*/
class MesinCheckNgDtrSearch extends MesinCheckNgDtr
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['SEQ', 'urutan', 'color_stat', 'down_time'], 'integer'],
            [['stat_last_update', 'stat_description'], 'safe'],
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
$query = MesinCheckNgDtr::find();

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
            'SEQ' => $this->SEQ,
            'urutan' => $this->urutan,
            'color_stat' => $this->color_stat,
            'stat_last_update' => $this->stat_last_update,
            'down_time' => $this->down_time,
        ]);

        $query->andFilterWhere(['like', 'stat_description', $this->stat_description]);

return $dataProvider;
}
}