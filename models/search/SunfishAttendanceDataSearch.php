<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SunfishAttendanceData;

/**
* SunfishAttendanceDataSearch represents the model behind the search form about `app\models\SunfishAttendanceData`.
*/
class SunfishAttendanceDataSearch extends SunfishAttendanceData
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['emp_no', 'post_date', 'period', 'shift', 'attend_judgement', 'come_late'], 'safe'],
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
$query = SunfishAttendanceData::find()
->leftJoin('VIEW_YEMI_Emp_OrgUnit', 'VIEW_YEMI_Emp_OrgUnit.Emp_no = VIEW_YEMI_ATTENDANCE.emp_no')
->where('PATINDEX(\'YE%\', UPPER(VIEW_YEMI_ATTENDANCE.emp_no)) > 0 AND cost_center NOT IN (\'Expatriate\') AND shiftdaily_code <> \'OFF\'');
$filter_shift = [
	1 => 'PATINDEX(\'%SHIFT_1%\', UPPER(shiftdaily_code)) > 0',
	2 => '(PATINDEX(\'%SHIFT_2%\', UPPER(shiftdaily_code)) > 0 OR PATINDEX(\'%MAINTENANCE%\', UPPER(shiftdaily_code)) > 0)',
	3 => 'PATINDEX(\'%SHIFT_3%\', UPPER(shiftdaily_code)) > 0'
];
/*$filter_shift1 = 'PATINDEX(\'%SHIFT_1%\', UPPER(shiftdaily_code)) > 0';
$filter_shift2 = '(PATINDEX(\'%SHIFT_2%\', UPPER(shiftdaily_code)) > 0 OR PATINDEX(\'%MAINTENANCE%\', UPPER(shiftdaily_code)) > 0)';
$filter_shift3 = 'PATINDEX(\'%SHIFT_3%\', UPPER(shiftdaily_code)) > 0';*/

$dataProvider = new ActiveDataProvider([
'query' => $query,
]);

$this->load($params);

if ($this->shift != null && $this->shift != '') {
	$query->andWhere($filter_shift[$this->shift]);
}

if ($this->post_date != null && $this->post_date != '') {
	$query->andWhere([
        'OR',
        'end_date IS NULL',
        ['>=', 'end_date', $this->post_date]
    ])
    ->andWhere(['<=', 'start_date', $this->post_date]);
}

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

$query->andFilterWhere([
            'come_late' => $this->come_late,
        ]);

        $query->andFilterWhere(['like', 'CONVERT(VARCHAR(10), shiftendtime, 120)', $this->post_date])
        ->andFilterWhere(['like', 'VIEW_YEMI_ATTENDANCE.emp_no', $this->emp_no])
        ->andFilterWhere(['like', 'FORMAT(shiftendtime, \'yyyyMM\')', $this->period]);

        if ($this->attend_judgement == 'C_ALL') {
        	$query->andFilterWhere([
	            'attend_judgement' => ['C', 'CKX'],
	        ]);
        } elseif ($this->attend_judgement == 'A') {
        	$query->andWhere('attend_judgement = \'A\' OR attend_judgement IS NULL');
        } else {
        	if ($this->attend_judgement != null && $this->attend_judgement != '') {
        		$query->andFilterWhere([
		            'attend_judgement' => $this->attend_judgement,
		        ]);
        	}
        }


return $dataProvider;
}
}