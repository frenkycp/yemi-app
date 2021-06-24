<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaxHdr;

/**
* TaxHdrSearch represents the model behind the search form about `app\models\TaxHdr`.
*/
class TaxHdrSearch extends TaxHdr
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['no_seri', 'no_seri_val', 'kdJenisTransaksi', 'fgPengganti', 'nomorFaktur', 'period', 'tanggalFaktur', 'npwpPenjual', 'namaPenjual', 'alamatPenjual', 'npwpLawanTransaksi', 'namaLawanTransaksi', 'alamatLawanTransaksi', 'statusApproval', 'statusFaktur', 'referensi', 'last_updated', 'status_upload'], 'safe'],
            [['jumlahDpp', 'jumlahPpn', 'jumlahPpnBm'], 'number'],
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
$query = TaxHdr::find();

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
            'tanggalFaktur' => $this->tanggalFaktur,
            'jumlahDpp' => $this->jumlahDpp,
            'jumlahPpn' => $this->jumlahPpn,
            'jumlahPpnBm' => $this->jumlahPpnBm,
            'last_updated' => $this->last_updated,
        ]);

        $query->andFilterWhere(['like', 'no_seri', $this->no_seri])
            ->andFilterWhere(['like', 'no_seri_val', $this->no_seri_val])
            ->andFilterWhere(['like', 'kdJenisTransaksi', $this->kdJenisTransaksi])
            ->andFilterWhere(['like', 'fgPengganti', $this->fgPengganti])
            ->andFilterWhere(['like', 'nomorFaktur', $this->nomorFaktur])
            ->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'npwpPenjual', $this->npwpPenjual])
            ->andFilterWhere(['like', 'namaPenjual', $this->namaPenjual])
            ->andFilterWhere(['like', 'alamatPenjual', $this->alamatPenjual])
            ->andFilterWhere(['like', 'npwpLawanTransaksi', $this->npwpLawanTransaksi])
            ->andFilterWhere(['like', 'namaLawanTransaksi', $this->namaLawanTransaksi])
            ->andFilterWhere(['like', 'alamatLawanTransaksi', $this->alamatLawanTransaksi])
            ->andFilterWhere(['like', 'statusApproval', $this->statusApproval])
            ->andFilterWhere(['like', 'statusFaktur', $this->statusFaktur])
            ->andFilterWhere(['like', 'referensi', $this->referensi])
            ->andFilterWhere(['like', 'status_upload', $this->status_upload]);

return $dataProvider;
}
}