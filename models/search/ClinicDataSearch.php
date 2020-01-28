<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\KlinikInput;

/**
* ClinicDataSearch represents the model behind the search form about `app\models\KlinikInput`.
*/
class ClinicDataSearch extends KlinikInput
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['pk', 'nama', 'dept', 'masuk', 'keluar', 'anamnesa', 'root_cause', 'diagnosa', 'obat1', 'obat2', 'obat3', 'obat4', 'obat5', 'handleby', 'input_date', 'section', 'last_status', 'nik_sun_fish'], 'safe'],
            [['nik', 'opsi', 'confirm'], 'integer'],
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
$query = KlinikInput::find();

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
            'nik' => $this->nik,
            'opsi' => $this->opsi,
            'masuk' => $this->masuk,
            'keluar' => $this->keluar,
            'confirm' => $this->confirm,
            'dept' => $this->dept,
            'section' => $this->section,
            'last_status' => $this->last_status,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'date(pk)', $this->input_date])
            ->andFilterWhere(['like', 'anamnesa', $this->anamnesa])
            ->andFilterWhere(['like', 'root_cause', $this->root_cause])
            ->andFilterWhere(['like', 'diagnosa', $this->diagnosa])
            ->andFilterWhere(['like', 'nik_sun_fish', $this->nik_sun_fish])
            ->andFilterWhere(['like', 'obat1', $this->obat1])
            ->andFilterWhere(['like', 'obat2', $this->obat2])
            ->andFilterWhere(['like', 'obat3', $this->obat3])
            ->andFilterWhere(['like', 'obat4', $this->obat4])
            ->andFilterWhere(['like', 'obat5', $this->obat5])
            ->andFilterWhere(['like', 'handleby', $this->handleby]);

return $dataProvider;
}
}