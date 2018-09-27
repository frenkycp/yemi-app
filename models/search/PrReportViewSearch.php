<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PrReportView;

/**
* AbsensiTblSearch represents the model behind the search form about `app\models\AbsensiTbl`.
*/
class PrReportViewSearch extends PrReportView
{
/**
* @inheritdoc
*/
public function rules()
{
return [
            [['PR_HDR_NO', 'PR_DEP', 'DEP_DESC', 'PR_USER', 'NAMA', 'PR_ATASAN1', 'PR_ATASAN2', 'PR_ATASAN3', 'ITEM', 'NAMA_BARANG_01', 'NAMA_BARANG_02', 'NAMA_BARANG_03', 'NAMA_BARANG_04', 'NAMA_BARANG_05', 'NAMA_BARANG_06', 'NAMA_BARANG_07', 'NAMA_BARANG_08', 'NAMA_BARANG_09', 'NAMA_BARANG_10', 'JENIS_BARANG', 'SATUAN', 'SPEC', 'DIPAKAI', 'MERK', 'NAMA_BARANG', 'PR_CLOSE', 'PR_REQUEST_TYPE', 'REQUEST_TYPE_DESC', 'PR_REQUEST_TYPE_B3', 'PR_REQUEST_TYPE_FA', 'PR_REQUEST_TYPE_MT', 'PR_REQUEST_TYPE_NF', 'PR_REQUEST_TYPE_NM', 'PR_REQUEST_TYPE_UG', 'PR_HDR_NOTE', 'RCV_STAT', 'PR_COST_DEP', 'DEP_ALOCATION', 'PUR_LOC', 'PUR_LOC_DESC', 'NICK_NAME', 'NICK_ACC', 'VALIDASI', 'ACCOUNT', 'BUDGET_ID'], 'string'],
            [['PR_HDR_REQUEST_DATE', 'PR_HDR_PLACE_DATE', 'PR_HDR_POST_DATE', 'BATAS_WAKTU', 'CONFIRM_BY_PCH'], 'safe'],
            [['PR_NO', 'NO'], 'integer'],
            [['JUMLAH', 'STOK', 'RENCANA', 'JML_DIPENUHI', 'SISA_JML', 'RCV_QTY', 'RCV_BO_QTY', 'PR_USD_AMT'], 'number']
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
$query = PrReportView::find();

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
            'BUDGET_ID' => $this->BUDGET_ID,
        ]);

        /*$query->andFilterWhere(['like', 'NIK_DATE_ID', $this->NIK_DATE_ID])
            ->andFilterWhere(['like', 'NO', $this->NO])
            ->andFilterWhere(['like', 'NIK', $this->NIK])
            ->andFilterWhere(['like', 'CC_ID', $this->CC_ID])
            ->andFilterWhere(['like', 'SECTION', $this->SECTION])
            ->andFilterWhere(['like', 'DIRECT_INDIRECT', $this->DIRECT_INDIRECT])
            ->andFilterWhere(['like', 'NAMA_KARYAWAN', $this->NAMA_KARYAWAN])
            ->andFilterWhere(['like', 'PERIOD', $this->PERIOD])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE])
            ->andFilterWhere(['like', 'DAY_STAT', $this->DAY_STAT])
            ->andFilterWhere(['like', 'CATEGORY', $this->CATEGORY]);*/

return $dataProvider;
}
}