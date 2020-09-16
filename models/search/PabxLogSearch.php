<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PabxLog;

/**
* PabxLogSearch represents the model behind the search form about `app\models\PabxLog`.
*/
class PabxLogSearch extends PabxLog
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['seq'], 'integer'],
            [['tanggal', 'ext', 'line', 'nik', 'nama_karyawan', 'departemen', 'jabatan', 'password', 'phone', 'durasi', 'provider_type', 'provider', 'provider_name', 'registered_name', 'note', 'last_update'], 'safe'],
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
$query = PabxLog::find();

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
    'defaultOrder' => [
        //'cust_desc' => SORT_ASC,
        'tanggal' => SORT_DESC,
    ]
],
]);

$this->load($params);

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

$query->andFilterWhere([
            'seq' => $this->seq,
            'durasi' => $this->durasi,
        ]);

        $query->andFilterWhere(['like', 'ext', $this->ext])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),tanggal,120)', $this->tanggal])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),last_update,120)', $this->last_update])
            ->andFilterWhere(['like', 'line', $this->line])
            ->andFilterWhere(['like', 'nik', $this->nik])
            ->andFilterWhere(['like', 'nama_karyawan', $this->nama_karyawan])
            ->andFilterWhere(['like', 'departemen', $this->departemen])
            ->andFilterWhere(['like', 'jabatan', $this->jabatan])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'provider_type', $this->provider_type])
            ->andFilterWhere(['like', 'provider', $this->provider])
            ->andFilterWhere(['like', 'provider_name', $this->provider_name])
            ->andFilterWhere(['like', 'registered_name', $this->registered_name])
            ->andFilterWhere(['like', 'note', $this->note]);

return $dataProvider;
}
}