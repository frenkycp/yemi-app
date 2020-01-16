<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProdAttendanceDailyPlan;

/**
* ProdAttendanceDailyPlanSearch represents the model behind the search form about `app\models\ProdAttendanceDailyPlan`.
*/
class ProdAttendanceDailyPlanSearch extends ProdAttendanceDailyPlan
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'child_analyst', 'child_analyst_desc', 'nik', 'name', 'att_date', 'create_time', 'created_by_id', 'update_time', 'updated_by_id'], 'safe'],
            [['emp_shift', 'flag'], 'integer'],
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
$query = ProdAttendanceDailyPlan::find();

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
            'att_date' => $this->att_date,
            'emp_shift' => $this->emp_shift,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'flag' => $this->flag,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'child_analyst', $this->child_analyst])
            ->andFilterWhere(['like', 'child_analyst_desc', $this->child_analyst_desc])
            ->andFilterWhere(['like', 'nik', $this->nik])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'created_by_id', $this->created_by_id])
            ->andFilterWhere(['like', 'updated_by_id', $this->updated_by_id]);

return $dataProvider;
}
}