<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Karyawan;

/**
* HrgaDataKaryawanSearch represents the model behind the search form about `app\models\Karyawan`.
*/
class HrgaDataKaryawanSearch extends Karyawan
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['NIK', 'NAMA_KARYAWAN', 'TGL_LAHIR', 'JENIS_KELAMIN', 'STATUS_PERKAWINAN', 'ALAMAT', 'ALAMAT_SEMENTARA', 'TELP', 'NPWP', 'KTP', 'BPJS_KESEHATAN', 'BPJS_KETENAGAKERJAAN', 'TGL_MASUK_YEMI', 'STATUS_KARYAWAN', 'CC_ID', 'DEPARTEMEN', 'SECTION', 'SUB_SECTION', 'JABATAN_SR', 'JABATAN_SR_GROUP', 'GRADE', 'DIRECT_INDIRECT', 'JENIS_PEKERJAAN', 'SERIKAT_PEKERJA', 'K1_START', 'K1_END', 'K2_START', 'K2_END', 'ACTIVE_STAT', 'PASSWORD', 'NIK_SUN_FISH', 'AKTIF'], 'safe'],
            [['SKILL', 'KONTRAK_KE'], 'integer'],
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
$query = Karyawan::find();

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
            'TGL_LAHIR' => $this->TGL_LAHIR,
            'TGL_MASUK_YEMI' => $this->TGL_MASUK_YEMI,
            'SKILL' => $this->SKILL,
            'KONTRAK_KE' => $this->KONTRAK_KE,
            'K1_START' => $this->K1_START,
            'K1_END' => $this->K1_END,
            'K2_START' => $this->K2_START,
            'K2_END' => $this->K2_END,
            'AKTIF' => $this->AKTIF,
        ]);

        $query->andFilterWhere(['like', 'NIK', $this->NIK])
            ->andFilterWhere(['like', 'NAMA_KARYAWAN', $this->NAMA_KARYAWAN])
            ->andFilterWhere(['like', 'NIK_SUN_FISH', $this->NIK_SUN_FISH])
            ->andFilterWhere(['like', 'JENIS_KELAMIN', $this->JENIS_KELAMIN])
            ->andFilterWhere(['like', 'STATUS_PERKAWINAN', $this->STATUS_PERKAWINAN])
            ->andFilterWhere(['like', 'ALAMAT', $this->ALAMAT])
            ->andFilterWhere(['like', 'ALAMAT_SEMENTARA', $this->ALAMAT_SEMENTARA])
            ->andFilterWhere(['like', 'TELP', $this->TELP])
            ->andFilterWhere(['like', 'NPWP', $this->NPWP])
            ->andFilterWhere(['like', 'KTP', $this->KTP])
            ->andFilterWhere(['like', 'BPJS_KESEHATAN', $this->BPJS_KESEHATAN])
            ->andFilterWhere(['like', 'BPJS_KETENAGAKERJAAN', $this->BPJS_KETENAGAKERJAAN])
            ->andFilterWhere(['like', 'STATUS_KARYAWAN', $this->STATUS_KARYAWAN])
            ->andFilterWhere(['like', 'CC_ID', $this->CC_ID])
            ->andFilterWhere(['like', 'DEPARTEMEN', $this->DEPARTEMEN])
            ->andFilterWhere(['like', 'SECTION', $this->SECTION])
            ->andFilterWhere(['like', 'SUB_SECTION', $this->SUB_SECTION])
            ->andFilterWhere(['like', 'JABATAN_SR', $this->JABATAN_SR])
            ->andFilterWhere(['like', 'JABATAN_SR_GROUP', $this->JABATAN_SR_GROUP])
            ->andFilterWhere(['like', 'GRADE', $this->GRADE])
            ->andFilterWhere(['like', 'DIRECT_INDIRECT', $this->DIRECT_INDIRECT])
            ->andFilterWhere(['like', 'JENIS_PEKERJAAN', $this->JENIS_PEKERJAAN])
            ->andFilterWhere(['like', 'SERIKAT_PEKERJA', $this->SERIKAT_PEKERJA])
            ->andFilterWhere(['like', 'ACTIVE_STAT', $this->ACTIVE_STAT])
            ->andFilterWhere(['like', 'PASSWORD', $this->PASSWORD]);

return $dataProvider;
}
}