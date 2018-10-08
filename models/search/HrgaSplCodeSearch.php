<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SplCode;

/**
* HrgaSplCodeSearch represents the model behind the search form about `app\models\SplCode`.
*/
class HrgaSplCodeSearch extends SplCode
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['KODE_LEMBUR', 'START_LEMBUR_PLAN', 'END_LEMBUR_PLAN', 'JENIS_LEMBUR'], 'safe'],
            [['NILAI_LEMBUR_PLAN'], 'number'],
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
$query = SplCode::find();

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
            'START_LEMBUR_PLAN' => $this->START_LEMBUR_PLAN,
            'END_LEMBUR_PLAN' => $this->END_LEMBUR_PLAN,
            'NILAI_LEMBUR_PLAN' => $this->NILAI_LEMBUR_PLAN,
        ]);

        $query->andFilterWhere(['like', 'KODE_LEMBUR', $this->KODE_LEMBUR])
            ->andFilterWhere(['like', 'JENIS_LEMBUR', $this->JENIS_LEMBUR]);

return $dataProvider;
}
}