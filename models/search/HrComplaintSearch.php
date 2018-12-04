<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\HrComplaint;

/**
* HrComplaintSearch represents the model behind the search form about `app\models\HrComplaint`.
*/
class HrComplaintSearch extends HrComplaint
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'status'], 'integer'],
            [['period', 'input_datetime', 'response_datetime','nik', 'emp_name', 'department', 'section', 'sub_section', 'remark', 'remark_category', 'response'], 'safe'],
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
$query = HrComplaint::find();
$defaultOrder = [
    'status' => SORT_ASC,
    'input_datetime' => SORT_ASC,
];
if (isset($params['hr_sort'])) {
    $defaultOrder = [
        'input_datetime' => SORT_DESC,
    ];
    
};

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
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),input_datetime,120)', $this->input_datetime])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),response_datetime,120)', $this->response_datetime])
            ->andFilterWhere(['like', 'nik', $this->nik])
            ->andFilterWhere(['like', 'emp_name', $this->emp_name])
            ->andFilterWhere(['like', 'department', $this->department])
            ->andFilterWhere(['like', 'section', $this->section])
            ->andFilterWhere(['like', 'sub_section', $this->sub_section])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'remark_category', $this->remark_category])
            ->andFilterWhere(['like', 'response', $this->response]);

return $dataProvider;
}
}