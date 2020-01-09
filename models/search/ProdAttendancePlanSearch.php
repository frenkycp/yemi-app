<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProdAttendanceMpPlan;

/**
* ProdAttendancePlanSearch represents the model behind the search form about `app\models\ProdAttendanceMpPlan`.
*/
class ProdAttendancePlanSearch extends ProdAttendanceMpPlan
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'is_enable'], 'integer'],
            [['child_analyst', 'child_analyst_desc', 'nik', 'name', 'from_date', 'to_date', 'created_date', 'created_by_id', 'last_update', 'updated_by_id'], 'safe'],
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
$query = ProdAttendanceMpPlan::find();

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
            'id' => $this->id,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'created_date' => $this->created_date,
            'last_update' => $this->last_update,
            'is_enable' => $this->is_enable,
        ]);

        $query->andFilterWhere(['like', 'child_analyst', $this->child_analyst])
            ->andFilterWhere(['like', 'child_analyst_desc', $this->child_analyst_desc])
            ->andFilterWhere(['like', 'nik', $this->nik])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'created_by_id', $this->created_by_id])
            ->andFilterWhere(['like', 'updated_by_id', $this->updated_by_id]);

return $dataProvider;
}
}