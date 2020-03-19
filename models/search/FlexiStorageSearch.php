<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FlexiStorage;

/**
* FlexiStorageSearch represents the model behind the search form about `app\models\FlexiStorage`.
*/
class FlexiStorageSearch extends FlexiStorage
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['kode_area', 'area', 'rack', 'kolom_level', 'posisi', 'storage_type', 'storage_status'], 'safe'],
            [['panjang_cm', 'lebar_cm', 'tinggi_cm', 'kubikasi_m3', 'kubikasi_m3_act', 'kubikasi_m3_balance', 'percent_used'], 'number'],
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
$query = FlexiStorage::find();

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
            'panjang_cm' => $this->panjang_cm,
            'lebar_cm' => $this->lebar_cm,
            'tinggi_cm' => $this->tinggi_cm,
            'kubikasi_m3' => $this->kubikasi_m3,
            'kubikasi_m3_act' => $this->kubikasi_m3_act,
            'kubikasi_m3_balance' => $this->kubikasi_m3_balance,
            'percent_used' => $this->percent_used,
        ]);

if ($this->storage_status == 0) {
    $query->andFilterWhere([
            'percent_used' => 0,
        ]);
} elseif ($this->storage_status == 1) {
    $query->andFilterWhere(['<>', 'percent_used', 0]);
}

        $query->andFilterWhere(['like', 'kode_area', $this->kode_area])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'rack', $this->rack])
            ->andFilterWhere(['like', 'kolom_level', $this->kolom_level])
            ->andFilterWhere(['like', 'posisi', $this->posisi])
            ->andFilterWhere(['like', 'storage_type', $this->storage_type]);

return $dataProvider;
}
}