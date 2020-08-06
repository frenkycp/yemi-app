<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ScanTemperature;

/**
* ScanTemperatureSearch represents the model behind the search form about `app\models\ScanTemperature`.
*/
class ScanTemperatureSearch extends ScanTemperature
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['SEQ'], 'integer'],
            [['HOST', 'ID', 'STATUS', 'NIK', 'NAMA_KARYAWAN', 'COST_CENTER', 'COST_CENTER_DESC', 'POST_DATE', 'PERIOD', 'LAST_UPDATE'], 'safe'],
            [['from_time', 'to_time'], 'required'],
            [['SUHU'], 'number'],
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
$query = ScanTemperature::find();

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
            'SEQ' => $this->SEQ,
            'SUHU' => $this->SUHU,
            'POST_DATE' => $this->POST_DATE,
            'LAST_UPDATE' => $this->LAST_UPDATE,
        ]);

        $query->andFilterWhere(['like', 'HOST', $this->HOST])
            ->andFilterWhere(['like', 'ID', $this->ID])
            ->andFilterWhere(['like', 'STATUS', $this->STATUS])
            ->andFilterWhere(['like', 'NIK', $this->NIK])
            ->andFilterWhere(['like', 'NAMA_KARYAWAN', $this->NAMA_KARYAWAN])
            ->andFilterWhere(['like', 'COST_CENTER', $this->COST_CENTER])
            ->andFilterWhere(['like', 'COST_CENTER_DESC', $this->COST_CENTER_DESC])
            ->andFilterWhere(['like', 'PERIOD', $this->PERIOD]);

            $query->andFilterWhere(['>=', 'LAST_UPDATE', $this->from_time])
            ->andFilterWhere(['<=', 'LAST_UPDATE', $this->to_time]);

return $dataProvider;
}
}