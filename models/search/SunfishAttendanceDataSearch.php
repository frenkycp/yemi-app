<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SunfishEmpAttendance;

/**
* SunfishAttendanceDataSearch represents the model behind the search form about `app\models\SunfishEmpAttendance`.
*/
class SunfishAttendanceDataSearch extends SunfishEmpAttendance
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['emp_no', 'Attend_Code', 'post_date', 'period', 'shiftdaily_code', 'present'], 'safe'],
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
$query = SunfishEmpAttendance::find();

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
            'Attend_Code' => $this->Attend_Code,
            'shiftdaily_code' => $this->shiftdaily_code
        ]);

        $query->andFilterWhere(['like', 'CONVERT(VARCHAR(10), shiftstarttime, 120)', $this->post_date])
        ->andFilterWhere(['like', 'emp_no', $this->emp_no])
        ->andFilterWhere(['like', 'FORMAT(shiftstarttime, \'yyyyMM\')', $this->period]);

return $dataProvider;
}
}