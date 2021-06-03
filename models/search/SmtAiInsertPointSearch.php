<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SmtAiInsertPoint;

/**
* SmtAiInsertPointSearch represents the model behind the search form about `app\models\SmtAiInsertPoint`.
*/
class SmtAiInsertPointSearch extends SmtAiInsertPoint
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['PART_NO', 'PARENT_PART_NO', 'LAST_UPDATE'], 'safe'],
            [['POINT_SMT', 'POINT_RG', 'POINT_AV', 'POINT_JV', 'POINT_TOTAL', 'FLAG'], 'integer'],
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
$query = SmtAiInsertPoint::find();

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
            'POINT_SMT' => $this->POINT_SMT,
            'POINT_RG' => $this->POINT_RG,
            'POINT_AV' => $this->POINT_AV,
            'POINT_JV' => $this->POINT_JV,
            'POINT_TOTAL' => $this->POINT_TOTAL,
            'LAST_UPDATE' => $this->LAST_UPDATE,
            'FLAG' => $this->FLAG,
        ]);

        $query->andFilterWhere(['like', 'PART_NO', $this->PART_NO])
            ->andFilterWhere(['like', 'PARENT_PART_NO', $this->PARENT_PART_NO]);

return $dataProvider;
}
}