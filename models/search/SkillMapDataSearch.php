<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SkillMasterKaryawan;

/**
* SkillMapDataSearch represents the model behind the search form about `app\models\SkillMasterKaryawan`.
*/
class SkillMapDataSearch extends SkillMasterKaryawan
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['ID', 'NIK', 'NAMA_KARYAWAN', 'TGL_MASUK_YEMI', 'kelompok', 'skill_id', 'skill_desc', 'skill_group', 'skill_group_desc', 'USER_ID', 'USER_DESC', 'USER_LAST_UPDATE'], 'safe'],
            [['skill_value', 'WW01', 'WW02', 'WW03', 'WW04', 'WI01', 'WI02', 'WI03', 'WP01', 'WM01', 'WM02', 'WM03', 'WU01', 'WS01', 'WF01', 'TIPE'], 'number'],
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
$query = SkillMasterKaryawan::find();

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
            'TGL_MASUK_YEMI' => $this->TGL_MASUK_YEMI,
            'skill_value' => $this->skill_value,
            'WW01' => $this->WW01,
            'WW02' => $this->WW02,
            'WW03' => $this->WW03,
            'WW04' => $this->WW04,
            'WI01' => $this->WI01,
            'WI02' => $this->WI02,
            'WI03' => $this->WI03,
            'WP01' => $this->WP01,
            'WM01' => $this->WM01,
            'WM02' => $this->WM02,
            'WM03' => $this->WM03,
            'WU01' => $this->WU01,
            'WS01' => $this->WS01,
            'WF01' => $this->WF01,
            'TIPE' => $this->TIPE,
            'USER_LAST_UPDATE' => $this->USER_LAST_UPDATE,
        ]);

        $query->andFilterWhere(['like', 'ID', $this->ID])
            ->andFilterWhere(['like', 'NIK', $this->NIK])
            ->andFilterWhere(['like', 'NAMA_KARYAWAN', $this->NAMA_KARYAWAN])
            ->andFilterWhere(['like', 'kelompok', $this->kelompok])
            ->andFilterWhere(['like', 'skill_id', $this->skill_id])
            ->andFilterWhere(['like', 'skill_desc', $this->skill_desc])
            ->andFilterWhere(['like', 'skill_group', $this->skill_group])
            ->andFilterWhere(['like', 'skill_group_desc', $this->skill_group_desc])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'USER_DESC', $this->USER_DESC]);

return $dataProvider;
}
}