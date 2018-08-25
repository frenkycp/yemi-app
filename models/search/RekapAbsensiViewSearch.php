<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RekapAbsensiView;

/**
* RekapAbsensiViewSearch represents the model behind the search form about `app\models\RekapAbsensiView`.
*/
class RekapAbsensiViewSearch extends RekapAbsensiView
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['PERIOD', 'NIK', 'NAMA_KARYAWAN', 'SECTION'], 'safe'],
            [['KEHADIRAN', 'TOTAL_KARYAWAN', 'ALPHA', 'IJIN', 'SAKIT', 'CUTI', 'CUTI_KHUSUS', 'CUTI_KHUSUS_IJIN', 'DISIPLIN'], 'integer'],
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
$query = RekapAbsensiView::find();

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
    'defaultOrder' => [
        'PERIOD' => SORT_ASC,
        'SECTION' => SORT_ASC,
        'NIK' => SORT_ASC
    ]
],
]);

$this->load($params);

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

/**/$query->andFilterWhere([
            //'YEAR' => $this->YEAR,
            //'WEEK' => $this->WEEK,
            //'DATE' => $this->DATE,
            //'TOTAL_KARYAWAN' => $this->TOTAL_KARYAWAN,
            //'KEHADIRAN' => $this->KEHADIRAN,
            //'BONUS' => $this->BONUS,
            'DISIPLIN' => $this->DISIPLIN,
        ]);

        $query->andFilterWhere(['like', 'PERIOD', $this->PERIOD])
            ->andFilterWhere(['like', 'NIK', $this->NIK])
            ->andFilterWhere(['like', 'NAMA_KARYAWAN', $this->NAMA_KARYAWAN])
            ->andFilterWhere(['like', 'SECTION', $this->SECTION]);

return $dataProvider;
}
}