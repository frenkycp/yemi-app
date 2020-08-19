<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AssetTblView;

/**
* FixAssetDataSearch represents the model behind the search form about `app\models\AssetTblView`.
*/
class FixAssetDataSearch extends AssetTblView
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['asset_id', 'qr', 'ip_address', 'computer_name', 'jenis', 'manufacture', 'manufacture_desc', 'cpu_desc', 'ram_desc', 'rom_desc', 'os_desc', 'fixed_asst_account', 'asset_category', 'purchase_date', 'LAST_UPDATE', 'network', 'display', 'camera', 'battery', 'note', 'location', 'area', 'project', 'cur', 'manager_name', 'department_pic', 'cost_centre', 'department_name', 'section_name', 'nik', 'NAMA_KARYAWAN', 'primary_picture', 'FINANCE_ASSET', 'Discontinue', 'DateDisc', 'status', 'label', 'loc_type', 'LOC', 'propose_scrap'], 'safe'],
            [['report_type'], 'integer'],
            [['price', 'price_usd', 'qty', 'AtCost'], 'number'],
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
$query = AssetTblView::find()->where(['FINANCE_ASSET' => 'Y']);

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
            'price' => $this->price,
            'price_usd' => $this->price_usd,
            'qty' => $this->qty,
            'AtCost' => $this->AtCost,
            'DateDisc' => $this->DateDisc,
            'loc_type' => $this->loc_type,
            'LOC' => $this->LOC,
            'propose_scrap' => $this->propose_scrap,
        ]);

        $query->andFilterWhere(['like', 'asset_id', $this->asset_id])
            ->andFilterWhere(['like', 'qr', $this->qr])
            ->andFilterWhere(['like', 'ip_address', $this->ip_address])
            ->andFilterWhere(['like', 'computer_name', $this->computer_name])
            ->andFilterWhere(['like', 'jenis', $this->jenis])
            ->andFilterWhere(['like', 'manufacture', $this->manufacture])
            ->andFilterWhere(['like', 'manufacture_desc', $this->manufacture_desc])
            ->andFilterWhere(['like', 'cpu_desc', $this->cpu_desc])
            ->andFilterWhere(['like', 'ram_desc', $this->ram_desc])
            ->andFilterWhere(['like', 'rom_desc', $this->rom_desc])
            ->andFilterWhere(['like', 'os_desc', $this->os_desc])
            ->andFilterWhere(['like', 'fixed_asst_account', $this->fixed_asst_account])
            ->andFilterWhere(['like', 'asset_category', $this->asset_category])
            ->andFilterWhere(['like', 'network', $this->network])
            ->andFilterWhere(['like', 'display', $this->display])
            ->andFilterWhere(['like', 'camera', $this->camera])
            ->andFilterWhere(['like', 'battery', $this->battery])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'project', $this->project])
            ->andFilterWhere(['like', 'cur', $this->cur])
            ->andFilterWhere(['like', 'manager_name', $this->manager_name])
            ->andFilterWhere(['like', 'department_pic', $this->department_pic])
            ->andFilterWhere(['like', 'cost_centre', $this->cost_centre])
            ->andFilterWhere(['like', 'department_name', $this->department_name])
            ->andFilterWhere(['like', 'section_name', $this->section_name])
            ->andFilterWhere(['like', 'nik', $this->nik])
            ->andFilterWhere(['like', 'NAMA_KARYAWAN', $this->NAMA_KARYAWAN])
            ->andFilterWhere(['like', 'primary_picture', $this->primary_picture])
            ->andFilterWhere(['like', 'Discontinue', $this->Discontinue])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'label', $this->label]);

return $dataProvider;
}
}