<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\KaryawanSuhuView;

/**
* AbsensiTblSearch represents the model behind the search form about `app\models\AbsensiTbl`.
*/
class KaryawanSuhuViewSearch extends KaryawanSuhuView
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['sysid', 'emp_no', 'mac_no', 'port', 'iomode', 'verifymode', 'temperature', 'swipetime', 'NIK', 'Full_name', 'cost_center_name'], 'safe'],
[['from_time', 'to_time'], 'required'],
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
$query = KaryawanSuhuView::find()->where('NIK IS NOT NULL');

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
            'YEAR' => $this->YEAR,
            'WEEK' => $this->WEEK,
            'DATE' => $this->DATE,
            'TOTAL_KARYAWAN' => $this->TOTAL_KARYAWAN,
            'KEHADIRAN' => $this->KEHADIRAN,
            'BONUS' => $this->BONUS,
            'DISIPLIN' => $this->DISIPLIN,
        ]);*/

        $query->andFilterWhere(['like', 'NIK', $this->NIK])
            ->andFilterWhere(['like', 'cost_center_name', $this->cost_center_name])
            ->andFilterWhere(['like', 'Full_name', $this->Full_name]);

            $query->andFilterWhere(['>=', 'swipetime', $this->from_time])
            ->andFilterWhere(['<=', 'swipetime', $this->to_time]);

return $dataProvider;
}
}