<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GoMachine;

/**
* GoMachineSearch represents the model behind the search form about `app\models\GoMachine`.
*/
class GoMachineSearch extends GoMachine
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'man_power_req'], 'integer'],
            [['mesin_group', 'mesin_id', 'machine_desc', 'model', 'terminal', 'status'], 'safe'],
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
$query = GoMachine::find();

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
            'man_power_req' => $this->man_power_req,
        ]);

        $query->andFilterWhere(['like', 'mesin_group', $this->mesin_group])
            ->andFilterWhere(['like', 'mesin_id', $this->mesin_id])
            ->andFilterWhere(['like', 'machine_desc', $this->machine_desc])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'terminal', $this->terminal])
            ->andFilterWhere(['like', 'status', $this->status]);

return $dataProvider;
}
}