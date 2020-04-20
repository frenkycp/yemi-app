<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SunfishLeaveSummary;

/**
* AbsensiTblSearch represents the model behind the search form about `app\models\AbsensiTbl`.
*/
class SunfishLeaveSummarySearch extends SunfishLeaveSummary
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['emp_no', 'leave_code', 'valid_date'], 'safe'],
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
$query = SunfishLeaveSummary::find()->where('PATINDEX(\'%LONG%\', leave_code) > 0 OR PATINDEX(\'%ANL%\', leave_code) > 0');

$dataProvider = new ActiveDataProvider([
'query' => $query,
]);

$this->load($params);

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

/*$query->andFilterWhere([
            'leave_code' => $this->leave_code,
        ]);*/

        $query->andFilterWhere(['like', 'emp_no', $this->emp_no]);
        if ($this->valid_date != '' && $this->valid_date != null) {
              $query->andFilterWhere(['<=', 'startvaliddate', $this->valid_date])
              ->andFilterWhere(['>=', 'endvaliddate', $this->valid_date]);
        }
        if ($this->leave_code != '' && $this->leave_code != null) {
              $query->andFilterWhere(['like', 'CONVERT(VARCHAR(10), leave_code, 120)', $this->leave_code]);
        }

return $dataProvider;
}
}