<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MntShiftSch;

/**
* MntShiftSchSearch represents the model behind the search form about `app\models\MntShiftSch`.
*/
class MntShiftSchSearch extends MntShiftSch
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'shift_emp_id'], 'integer'],
            [['period', 'shift_date', 'shift_code', 'emp_name'], 'safe'],
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
$query = MntShiftSch::find()
->joinWith('mntShiftEmp');

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
            'shift_emp_id' => $this->shift_emp_id,
            'shift_date' => $this->shift_date,
        ]);

        $query->andFilterWhere(['like', 'period', $this->period])
        	->andFilterWhere(['like', 'name', $this->emp_name])
            ->andFilterWhere(['like', 'shift_code', $this->shift_code]);

return $dataProvider;
}
}