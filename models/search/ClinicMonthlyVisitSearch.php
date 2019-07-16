<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ClinicMonthlyVisit;

/**
* ClinicMonthlyVisitSearch represents the model behind the search form about `app\models\ClinicMonthlyVisit`.
*/
class ClinicMonthlyVisitSearch extends ClinicMonthlyVisit
{
/**
* @inheritdoc
*/
public function rules()
{
return [
    [['period', 'nik'], 'safe'],
            [['total'], 'number'],
            [['nama', 'dept'], 'string', 'max' => 255]
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
$query = ClinicMonthlyVisit::find();

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
        'defaultOrder' => [
            //'cust_desc' => SORT_ASC,
            'total' => SORT_DESC,
            'dept' => SORT_ASC,
            'nama' => SORT_ASC,
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
            'period' => $this->period,
            'nik' => $this->nik,
        ]);

        $query->andFilterWhere(['like', 'dept', $this->dept]);

return $dataProvider;
}
}