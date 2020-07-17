<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BentolManagerTripSummary;

/**
* ManagerTripSummarySearch represents the model behind the search form about `app\models\BentolManagerTripSummary`.
*/
class ManagerTripSummarySearch extends BentolManagerTripSummary
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'period', 'post_date', 'emp_id', 'emp_name', 'account_type', 'status_last_update', 'validation_last_update'], 'safe'],
            [['start_status', 'end_status', 'start_validation', 'end_validation'], 'integer'],
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
$query = BentolManagerTripSummary::find();

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
            'post_date' => $this->post_date,
            'start_status' => $this->start_status,
            'end_status' => $this->end_status,
            'start_validation' => $this->start_validation,
            'end_validation' => $this->end_validation,
            'status_last_update' => $this->status_last_update,
            'validation_last_update' => $this->validation_last_update,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'emp_id', $this->emp_id])
            ->andFilterWhere(['like', 'emp_name', $this->emp_name])
            ->andFilterWhere(['like', 'account_type', $this->account_type]);

return $dataProvider;
}
}