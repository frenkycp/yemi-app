<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SunfishAttendanceData;

/**
* TopOvertimeDataSearch represents the model behind the search form about `app\models\SunfishAttendanceData`.
*/
class TopOvertimeDataSearch extends SunfishAttendanceData
{
    /**
    * @inheritdoc
    */
    public function rules()
    {
    return [
                [['period', 'emp_no', 'full_name', 'cost_center'], 'safe'],
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
        ->select([
            'period' => 'FORMAT(shiftendtime, \'yyyyMM\')',
            'emp_no',
            'full_name',
            'cost_center',
            'total_ot' => 'SUM(total_ot)'
        ])
        ->where('total_ot IS NOT NULL')
        ->groupBy(['FORMAT(shiftendtime, \'yyyyMM\')', 'emp_no', 'full_name', 'cost_center']);
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
            	'defaultOrder' => [
                    //'PERIOD' => SORT_DESC,
                    'total_ot' => SORT_DESC,
                    //'NIK' => 'ASC'
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
            'cost_center' => $this->cost_center,
            'FORMAT(shiftendtime, \'yyyyMM\')' => $this->period,
        ]);

        $query->andFilterWhere(['like', 'emp_no', $this->emp_no])
        ->andFilterWhere(['like', 'full_name', $this->full_name]);

        return $dataProvider;
    }
}