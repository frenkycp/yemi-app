<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MesinCheckNg;

/**
* MesinCheckNgSearch represents the model behind the search form about `app\models\MesinCheckNg`.
*/
class MesinCheckNgSearch extends MesinCheckNg
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['urutan', 'down_time', 'non_down_time'], 'integer'],
            [['location', 'area', 'mesin_id', 'mesin_nama', 'mesin_no', 'mesin_bagian', 'mesin_bagian_ket', 'mesin_status', 'mesin_catatan', 'mesin_periode', 'user_id', 'user_desc', 'mesin_last_update', 'repair_plan', 'repair_aktual', 'repair_user_id', 'repair_user_desc', 'repair_status', 'repair_pic', 'repair_note'], 'safe'],
];
/*return [
[['urutan'], 'integer'],
            [['location', 'area', 'mesin_id', 'mesin_nama', 'mesin_no', 'mesin_bagian', 'mesin_bagian_ket', 'mesin_status', 'mesin_catatan', 'mesin_periode', 'user_id', 'user_desc', 'mesin_last_update', 'repair_plan', 'repair_aktual', 'repair_user_id', 'repair_user_desc', 'repair_status', 'repair_pic', 'repair_note', 'closing_day_total'], 'safe'],
];*/
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
$query = MesinCheckNg::find();

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
            'down_time' => $this->down_time,
            'non_down_time' => $this->non_down_time,
        ]);

        $query->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),mesin_last_update,120)', $this->mesin_last_update])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),repair_plan,120)', $this->repair_plan])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),repair_aktual,120)', $this->repair_aktual])
            ->andFilterWhere(['like', 'mesin_id', $this->mesin_id])
            ->andFilterWhere(['like', 'mesin_nama', $this->mesin_nama])
            ->andFilterWhere(['like', 'mesin_no', $this->mesin_no])
            ->andFilterWhere(['like', 'mesin_bagian', $this->mesin_bagian])
            ->andFilterWhere(['like', 'mesin_bagian_ket', $this->mesin_bagian_ket])
            ->andFilterWhere(['like', 'mesin_status', $this->mesin_status])
            ->andFilterWhere(['like', 'mesin_catatan', $this->mesin_catatan])
            ->andFilterWhere(['like', 'mesin_periode', $this->mesin_periode])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'user_desc', $this->user_desc])
            ->andFilterWhere(['like', 'repair_user_id', $this->repair_user_id])
            ->andFilterWhere(['like', 'repair_user_desc', $this->repair_user_desc])
            ->andFilterWhere(['like', 'repair_status', $this->repair_status])
            ->andFilterWhere(['like', 'repair_pic', $this->repair_pic])
            ->andFilterWhere(['like', 'repair_note', $this->repair_note]);

            /*if (strpos($this->closing_day_total, '>') !== false) {
                  $day = str_replace('>', '', $this->closing_day_total);
                  $query->andFilterWhere(['>', 'DATEDIFF(d, mesin_last_update, ISNULL(repair_aktual,GETDATE()))', $day]);
            }else {
                  $query->andFilterWhere(['DATEDIFF(d, mesin_last_update, ISNULL(repair_aktual,GETDATE()))' => $this->closing_day_total]);
            }*/

return $dataProvider;
}
}