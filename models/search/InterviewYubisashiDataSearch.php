<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EmpInterviewYubisashi;

/**
* InterviewYubisashiDataSearch represents the model behind the search form about `app\models\EmpInterviewYubisashi`.
*/
class InterviewYubisashiDataSearch extends EmpInterviewYubisashi
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['ID', 'EMP_ID', 'EMP_NAME', 'DEPARTMENT', 'COST_CENTER_CODE', 'COST_CENTER_NAME', 'LAST_UPDATE'], 'safe'],
            [['FISCAL_YEAR', 'YAMAHA_DIAMOND', 'K3', 'SLOGAN_KUALITAS', 'KESELAMATAN_LALU_LINTAS', 'KOMITMENT_BERKENDARA', 'BUDAYA_KERJA'], 'integer'],
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
$query = EmpInterviewYubisashi::find();

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
            'FISCAL_YEAR' => $this->FISCAL_YEAR,
            'YAMAHA_DIAMOND' => $this->YAMAHA_DIAMOND,
            'K3' => $this->K3,
            'SLOGAN_KUALITAS' => $this->SLOGAN_KUALITAS,
            'KESELAMATAN_LALU_LINTAS' => $this->KESELAMATAN_LALU_LINTAS,
            'KOMITMENT_BERKENDARA' => $this->KOMITMENT_BERKENDARA,
            'BUDAYA_KERJA' => $this->BUDAYA_KERJA,
            'LAST_UPDATE' => $this->LAST_UPDATE,
        ]);

        $query->andFilterWhere(['like', 'ID', $this->ID])
            ->andFilterWhere(['like', 'EMP_ID', $this->EMP_ID])
            ->andFilterWhere(['like', 'EMP_NAME', $this->EMP_NAME])
            ->andFilterWhere(['like', 'DEPARTMENT', $this->DEPARTMENT])
            ->andFilterWhere(['like', 'COST_CENTER_CODE', $this->COST_CENTER_CODE])
            ->andFilterWhere(['like', 'COST_CENTER_NAME', $this->COST_CENTER_NAME]);

return $dataProvider;
}
}