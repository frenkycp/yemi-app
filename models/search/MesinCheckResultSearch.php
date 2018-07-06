<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MesinCheckResult;

/**
* MesinCheckResultSearch represents the model behind the search form about `app\models\MesinCheckResult`.
*/
class MesinCheckResultSearch extends MesinCheckResult
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['urutan', 'hasil_ok', 'hasil_ng', 'total_cek'], 'integer'],
            [['location', 'area', 'mesin_id', 'mesin_nama', 'mesin_no', 'mesin_bagian', 'mesin_bagian_ket', 'mesin_status', 'mesin_catatan', 'mesin_periode', 'user_id', 'user_desc', 'mesin_last_update'], 'safe'],
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
$query = MesinCheckResult::find();

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
            'urutan' => $this->urutan,
            'hasil_ok' => $this->hasil_ok,
            'hasil_ng' => $this->hasil_ng,
            'total_cek' => $this->total_cek,
        ]);

        $query->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),mesin_last_update,120)', $this->mesin_last_update])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'mesin_id', $this->mesin_id])
            ->andFilterWhere(['like', 'mesin_nama', $this->mesin_nama])
            ->andFilterWhere(['like', 'mesin_no', $this->mesin_no])
            ->andFilterWhere(['like', 'mesin_bagian', $this->mesin_bagian])
            ->andFilterWhere(['like', 'mesin_bagian_ket', $this->mesin_bagian_ket])
            ->andFilterWhere(['like', 'mesin_status', $this->mesin_status])
            ->andFilterWhere(['like', 'mesin_catatan', $this->mesin_catatan])
            ->andFilterWhere(['like', 'mesin_periode', $this->mesin_periode])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'user_desc', $this->user_desc]);

return $dataProvider;
}
}