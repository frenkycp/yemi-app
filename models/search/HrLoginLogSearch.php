<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\HrLoginLog;

/**
* HrLoginLogSearch represents the model behind the search form about `app\models\HrLoginLog`.
*/
class HrLoginLogSearch extends HrLoginLog
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'nik', 'emp_name', 'department', 'section', 'sub_section', 'period', 'login_date', 'last_login'], 'safe'],
            [['login_count'], 'integer'],
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
$query = HrLoginLog::find();

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
            'login_date' => $this->login_date,
            'last_login' => $this->last_login,
            'login_count' => $this->login_count,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'nik', $this->nik])
            ->andFilterWhere(['like', 'emp_name', $this->emp_name])
            ->andFilterWhere(['like', 'department', $this->department])
            ->andFilterWhere(['like', 'section', $this->section])
            ->andFilterWhere(['like', 'sub_section', $this->sub_section])
            ->andFilterWhere(['like', 'period', $this->period]);

return $dataProvider;
}
}