<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ShiftPatrolTbl;

/**
* ShiftPatrolTblSearch represents the model behind the search form about `app\models\ShiftPatrolTbl`.
*/
class ShiftPatrolTblSearch extends ShiftPatrolTbl
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'flag'], 'integer'],
            [['input_time', 'patrol_time', 'NIK', 'NAMA_KARYAWAN', 'CC_ID', 'CC_GROUP', 'CC_DESC', 'category_id', 'category_detail', 'location', 'location_detail', 'description', 'action', 'posting_date', 'patrol_type', 'status', 'section_id', 'cause', 'countermeasure', 'case_no'], 'safe'],
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
$query = ShiftPatrolTbl::find()
->joinWith('statusTbl')
->where(['SHIFT_PATROL_TBL.flag' => 1])
->orderBy('IPQA_STATUS_TBL.status_order ASC');

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
            'id' => $this->id,
            'input_time' => $this->input_time,
            'flag' => $this->flag,
            'category_id' => $this->category_id,
            'patrol_type' => $this->patrol_type,
            'status' => $this->status,
            'section_id' => $this->section_id,
        ]);

        $query->andFilterWhere(['like', 'NIK', $this->NIK])
            ->andFilterWhere(['like', 'NAMA_KARYAWAN', $this->NAMA_KARYAWAN])
            ->andFilterWhere(['like', 'case_no', $this->case_no])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),patrol_time,120)', $this->patrol_time])
            ->andFilterWhere(['like', 'CC_ID', $this->CC_ID])
            ->andFilterWhere(['like', 'CC_GROUP', $this->CC_GROUP])
            ->andFilterWhere(['like', 'CC_DESC', $this->CC_DESC])
            ->andFilterWhere(['like', 'category_detail', $this->category_detail])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'location_detail', $this->location_detail])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'action', $this->action]);

return $dataProvider;
}
}