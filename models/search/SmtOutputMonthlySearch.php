<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SmtOutputMonthlyInsertPoint02;

/**
* AbsensiTblSearch represents the model behind the search form about `app\models\AbsensiTbl`.
*/
class SmtOutputMonthlySearch extends SmtOutputMonthlyInsertPoint02
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['period', 'child_all', 'child_desc_all'], 'safe'],
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
$query = SmtOutputMonthlyInsertPoint02::find();

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
            'period' => $this->period,
        ]);

        $query->andFilterWhere(['like', 'child_all', $this->child_all])
            ->andFilterWhere(['like', 'child_desc_all', $this->child_desc_all]);

return $dataProvider;
}
}