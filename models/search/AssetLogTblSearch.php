<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AssetLogView;

/**
* AssetLogTblSearch represents the model behind the search form about `app\models\AssetLogTbl`.
*/
class AssetLogTblSearch extends AssetLogView
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['trans_id'], 'integer'],
            [['trans_type', 'posting_date', 'asset_id', 'computer_name', 'from_loc', 'to_loc', 'user_id', 'user_desc', 'note', 'status', 'label', 'propose_scrap', 'schedule_id', 'schedule_status', 'jenis', 'cost_centre', 'section_name'], 'safe'],
            [['NBV'], 'number'],
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
$query = AssetLogView::find();

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
            'trans_id' => $this->trans_id,
            'posting_date' => $this->posting_date,
            'NBV' => $this->NBV,
            'propose_scrap' => $this->propose_scrap,
            'schedule_id' => $this->schedule_id,
            'schedule_status' => $this->schedule_status,
            'jenis' => $this->jenis,
            'cost_centre' => $this->cost_centre,
            'section_name' => $this->section_name,
        ]);

        $query->andFilterWhere(['like', 'trans_type', $this->trans_type])
            ->andFilterWhere(['like', 'asset_id', $this->asset_id])
            ->andFilterWhere(['like', 'computer_name', $this->computer_name])
            ->andFilterWhere(['like', 'from_loc', $this->from_loc])
            ->andFilterWhere(['like', 'to_loc', $this->to_loc])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'user_desc', $this->user_desc])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'label', $this->label]);

return $dataProvider;
}
}