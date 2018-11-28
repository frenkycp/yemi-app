<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AssetTbl;

/**
* AssetTblSearch represents the model behind the search form about `app\models\AssetTbl`.
*/
class AssetTblSearch extends AssetTbl
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['asset_id', 'qr', 'ip_address', 'computer_name', 'jenis', 'manufacture', 'manufacture_desc', 'cpu_desc', 'ram_desc', 'rom_desc', 'os_desc', 'nik', 'NAMA_KARYAWAN', 'fixed_asst_account', 'asset_category', 'purchase_date', 'LAST_UPDATE', 'network', 'display', 'camera', 'battery', 'note', 'location', 'area', 'department_pic', 'project'], 'safe'],
            [['report_type'], 'integer'],
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
$query = AssetTbl::find();

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
            'purchase_date' => $this->purchase_date,
            'report_type' => $this->report_type,
            'LAST_UPDATE' => $this->LAST_UPDATE,
            'asset_category' => $this->asset_category,
        ]);

        $query->andFilterWhere(['like', 'asset_id', $this->asset_id])
            ->andFilterWhere(['like', 'qr', $this->qr])
            ->andFilterWhere(['like', 'project', $this->project])
            ->andFilterWhere(['like', 'ip_address', $this->ip_address])
            ->andFilterWhere(['like', 'computer_name', $this->computer_name])
            ->andFilterWhere(['like', 'jenis', $this->jenis])
            ->andFilterWhere(['like', 'manufacture', $this->manufacture])
            ->andFilterWhere(['like', 'manufacture_desc', $this->manufacture_desc])
            ->andFilterWhere(['like', 'cpu_desc', $this->cpu_desc])
            ->andFilterWhere(['like', 'ram_desc', $this->ram_desc])
            ->andFilterWhere(['like', 'rom_desc', $this->rom_desc])
            ->andFilterWhere(['like', 'os_desc', $this->os_desc])
            ->andFilterWhere(['like', 'nik', $this->nik])
            ->andFilterWhere(['like', 'NAMA_KARYAWAN', $this->NAMA_KARYAWAN])
            ->andFilterWhere(['like', 'fixed_asst_account', $this->fixed_asst_account])
            ->andFilterWhere(['like', 'network', $this->network])
            ->andFilterWhere(['like', 'display', $this->display])
            ->andFilterWhere(['like', 'camera', $this->camera])
            ->andFilterWhere(['like', 'battery', $this->battery])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'department_pic', $this->department_pic]);

return $dataProvider;
}
}