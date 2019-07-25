<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GoSaTbl;

/**
* GoSaTblSearch represents the model behind the search form about `app\models\GoSaTbl`.
*/
class GoSaTblSearch extends GoSaTbl
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['ID', 'TOTAL_MP', 'FLAG'], 'integer'],
            [['REQUESTOR_NIK', 'REQUESTOR_NAME', 'START_TIME', 'END_TIME', 'REMARK'], 'safe'],
            [['LT'], 'number'],
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
$query = GoSaTbl::find();

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
            'ID' => $this->ID,
            'START_TIME' => $this->START_TIME,
            'END_TIME' => $this->END_TIME,
            'TOTAL_MP' => $this->TOTAL_MP,
            'LT' => $this->LT,
            'FLAG' => $this->FLAG,
        ]);

        $query->andFilterWhere(['like', 'REQUESTOR_NIK', $this->REQUESTOR_NIK])
            ->andFilterWhere(['like', 'REQUESTOR_NAME', $this->REQUESTOR_NAME])
            ->andFilterWhere(['like', 'REMARK', $this->REMARK]);

return $dataProvider;
}
}