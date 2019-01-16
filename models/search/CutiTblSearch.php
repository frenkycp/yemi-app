<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CutiTbl;

/**
* CutiTblSearch represents the model behind the search form about `app\models\CutiTbl`.
*/
class CutiTblSearch extends CutiTbl
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['CUTI_ID', 'NIK', 'NAMA_KARYAWAN', 'CATEGORY'], 'safe'],
            [['TAHUN'], 'integer'],
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
$query = CutiTbl::find();

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
            'TAHUN' => $this->TAHUN,
            'JUMLAH_CUTI' => $this->JUMLAH_CUTI,
        ]);

        $query->andFilterWhere(['like', 'CUTI_ID', $this->CUTI_ID])
            ->andFilterWhere(['like', 'NIK', $this->NIK])
            ->andFilterWhere(['like', 'NAMA_KARYAWAN', $this->NAMA_KARYAWAN])
            ->andFilterWhere(['like', 'CATEGORY', $this->CATEGORY]);

return $dataProvider;
}
}