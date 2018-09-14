<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SplViewReport03;

/**
* HrgaSplDataSearch represents the model behind the search form about `app\models\SplView`.
*/
class HrgaSplMonthlyReportSearch extends SplViewReport03
{
/**
* @inheritdoc
*/
public function rules()
{
return [
            [['PERIOD', 'CC_ID', 'DEPARTEMEN', 'SECTION', 'NIK', 'NAMA_KARYAWAN'], 'string'],
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
$query = SplViewReport03::find()->where('NIK IS NOT NULL');

$dataProvider = new ActiveDataProvider([
'query' => $query,
/**/'sort' => [
    'defaultOrder' => [
        'PERIOD' => SORT_ASC,
        'DEPARTEMEN' => SORT_ASC,
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

/*$query->andFilterWhere([
            'TGL_LEMBUR' => $this->TGL_LEMBUR,
        ]);*/

        $query->andFilterWhere(['like', 'PERIOD', $this->PERIOD])
            ->andFilterWhere(['like', 'DEPARTEMEN', $this->DEPARTEMEN])
            ->andFilterWhere(['like', 'SECTION', $this->SECTION])
            ->andFilterWhere(['like', 'SUB_SECTION', $this->SUB_SECTION])
            ->andFilterWhere(['like', 'NIK', $this->NIK])
            ->andFilterWhere(['like', 'NAMA_KARYAWAN', $this->NAMA_KARYAWAN]);

return $dataProvider;
}
}