<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EmpData;

/**
* EmpDataSearch represents the model behind the search form about `app\models\EmpData`.
*/
class EmpDataSearch extends EmpData
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['MP_ID', 'NIK', 'NAMA_KARYAWAN', 'JENIS_KELAMIN', 'STATUS_KARYAWAN', 'DIRECT_INDIRECT', 'CC_ID', 'DEPARTEMEN', 'SECTION', 'SUB_SECTION', 'PERIOD', 'TANGGAL', 'KONTRAK_START', 'KONTRAK_END', 'TINGKATAN', 'AKHIR_BULAN', 'PKWT', 'JABATAN_SR_GROUP', 'JABATAN_SR', 'GRADE'], 'safe'],
            [['KONTRAK_KE', 'SKILL', 'JUMLAH'], 'integer'],
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
$query = EmpData::find();

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
            'KONTRAK_KE' => $this->KONTRAK_KE,
            //'KONTRAK_START' => $this->KONTRAK_START,
            //'KONTRAK_END' => $this->KONTRAK_END,
            'SKILL' => $this->SKILL,
            'JUMLAH' => $this->JUMLAH,
        ]);

        $query->andFilterWhere(['like', 'MP_ID', $this->MP_ID])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),TANGGAL,120)', $this->TANGGAL])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),KONTRAK_START,120)', $this->KONTRAK_START])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),KONTRAK_END,120)', $this->KONTRAK_END])
            ->andFilterWhere(['like', 'NIK', $this->NIK])
            ->andFilterWhere(['like', 'NAMA_KARYAWAN', $this->NAMA_KARYAWAN])
            ->andFilterWhere(['like', 'GRADE', $this->GRADE])
            ->andFilterWhere(['like', 'JENIS_KELAMIN', $this->JENIS_KELAMIN])
            ->andFilterWhere(['like', 'STATUS_KARYAWAN', $this->STATUS_KARYAWAN])
            ->andFilterWhere(['like', 'DIRECT_INDIRECT', $this->DIRECT_INDIRECT])
            ->andFilterWhere(['like', 'CC_ID', $this->CC_ID])
            ->andFilterWhere(['like', 'DEPARTEMEN', $this->DEPARTEMEN])
            ->andFilterWhere(['like', 'SECTION', $this->SECTION])
            ->andFilterWhere(['like', 'SUB_SECTION', $this->SUB_SECTION])
            ->andFilterWhere(['like', 'PERIOD', $this->PERIOD])
            ->andFilterWhere(['like', 'TINGKATAN', $this->TINGKATAN])
            ->andFilterWhere(['like', 'PKWT', $this->PKWT])
            ->andFilterWhere(['like', 'JABATAN_SR_GROUP', $this->JABATAN_SR_GROUP])
            ->andFilterWhere(['like', 'JABATAN_SR', $this->JABATAN_SR])
            ->andFilterWhere(['like', 'AKHIR_BULAN', $this->AKHIR_BULAN]);

return $dataProvider;
}
}