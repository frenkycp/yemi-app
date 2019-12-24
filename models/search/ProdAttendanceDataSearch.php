<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProdAttendanceView01;

/**
* ProdAttendanceDataSearch represents the model behind the search form about `app\models\ProdAttendanceData`.
*/
class ProdAttendanceDataSearch extends ProdAttendanceView01
{
/**
* @inheritdoc
*/
public function rules()
{
return [
    [['period', 'posting_shift', 'nik', 'name', 'child_analyst', 'child_analyst_desc'], 'safe'],
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
$query = ProdAttendanceView01::find();

$dataProvider = new ActiveDataProvider([
    'query' => $query,
    'sort' => [
        'defaultOrder' => [
            //'cust_desc' => SORT_ASC,
            'name' => SORT_ASC,
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
            'posting_shift' => $this->posting_shift,
        ]);

        $query->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'nik', $this->nik])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'child_analyst', $this->child_analyst])
            ->andFilterWhere(['like', 'child_analyst_desc', $this->child_analyst_desc]);

return $dataProvider;
}
}