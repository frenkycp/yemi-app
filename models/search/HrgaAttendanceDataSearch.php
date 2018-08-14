<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AbsensiTbl;

/**
* HrgaAttendanceDataSearch represents the model behind the search form about `app\models\AbsensiTbl`.
*/
class HrgaAttendanceDataSearch extends AbsensiTbl
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['NIK_DATE_ID', 'NO', 'NIK', 'CC_ID', 'SECTION', 'DIRECT_INDIRECT', 'NAMA_KARYAWAN', 'PERIOD', 'DATE', 'NOTE', 'DAY_STAT', 'CATEGORY', 'SHIFT'], 'safe'],
            [['YEAR', 'WEEK', 'TOTAL_KARYAWAN', 'KEHADIRAN', 'BONUS', 'DISIPLIN'], 'integer'],
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
$query = AbsensiTbl::find();

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
            'YEAR' => $this->YEAR,
            'WEEK' => $this->WEEK,
            'DATE' => $this->DATE,
            'TOTAL_KARYAWAN' => $this->TOTAL_KARYAWAN,
            'KEHADIRAN' => $this->KEHADIRAN,
            'BONUS' => $this->BONUS,
            'DISIPLIN' => $this->DISIPLIN,
            'SHIFT' => $this->SHIFT
        ]);

        $query->andFilterWhere(['like', 'NIK_DATE_ID', $this->NIK_DATE_ID])
            ->andFilterWhere(['like', 'NO', $this->NO])
            ->andFilterWhere(['like', 'NIK', $this->NIK])
            ->andFilterWhere(['like', 'CC_ID', $this->CC_ID])
            ->andFilterWhere(['like', 'SECTION', $this->SECTION])
            ->andFilterWhere(['like', 'DIRECT_INDIRECT', $this->DIRECT_INDIRECT])
            ->andFilterWhere(['like', 'NAMA_KARYAWAN', $this->NAMA_KARYAWAN])
            ->andFilterWhere(['like', 'PERIOD', $this->PERIOD])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE])
            ->andFilterWhere(['like', 'DAY_STAT', $this->DAY_STAT])
            ->andFilterWhere(['like', 'CATEGORY', $this->CATEGORY]);

return $dataProvider;
}
}