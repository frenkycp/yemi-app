<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DailyProductionOutput01;

/**
* AbsensiTblSearch represents the model behind the search form about `app\models\AbsensiTbl`.
*/
class FaDailyOutputSearch extends DailyProductionOutput01
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'period', 'proddate', 'gmc', 'plan_qty', 'act_qty', 'balance_qty', 'description'], 'safe'],
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
$query = DailyProductionOutput01::find();

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
            'gmc' => $this->gmc,
            'proddate' => $this->proddate,
        ]);

        $query->andFilterWhere(['like', 'period', $this->period])
        ->andFilterWhere(['like', 'description', $this->description]);

return $dataProvider;
}
}