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
            [['period', 'input_datetime', 'nik', 'emp_name', 'department', 'section', 'sub_section', 'remark', 'remark_category', 'response'], 'safe'],
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

$dataProvider = new ActiveDataProvider([
    'query' => $query,
    'sort' => [
        'defaultOrder' => [
            //'cust_desc' => SORT_ASC,
            'input_datetime' => isset($params['hr_sort']) ? SORT_DESC : SORT_ASC,
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
            'id' => $this->id,
            'input_datetime' => $this->input_datetime,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'period', $this->period])
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