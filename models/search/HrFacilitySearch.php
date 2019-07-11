<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\HrFacility;

/**
* HrFacilitySearch represents the model behind the search form about `app\models\HrFacility`.
*/
class HrFacilitySearch extends HrFacility
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'remark_category', 'status'], 'integer'],
            [['period', 'input_datetime', 'nik', 'emp_name', 'cc_id', 'dept', 'section', 'facility_name', 'remark', 'response', 'response_datetime', 'responder_id', 'responder_name'], 'safe'],
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
$query = HrFacility::find();
$defaultOrder = [
    'status' => SORT_ASC,
    'input_datetime' => SORT_DESC,
];

$dataProvider = new ActiveDataProvider([
    'query' => $query,
    'sort' => [
        'defaultOrder' => $defaultOrder
    ],
]);

$this->load($params);

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

$query->andFilterWhere([
            'id' => $this->id,
            'remark_category' => $this->remark_category,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),input_datetime,120)', $this->input_datetime])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),response_datetime,120)', $this->response_datetime])
            ->andFilterWhere(['like', 'nik', $this->nik])
            ->andFilterWhere(['like', 'emp_name', $this->emp_name])
            ->andFilterWhere(['like', 'cc_id', $this->cc_id])
            ->andFilterWhere(['like', 'dept', $this->dept])
            ->andFilterWhere(['like', 'section', $this->section])
            ->andFilterWhere(['like', 'facility_name', $this->facility_name])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'response', $this->response])
            ->andFilterWhere(['like', 'responder_id', $this->responder_id])
            ->andFilterWhere(['like', 'responder_name', $this->responder_name]);

return $dataProvider;
}
}