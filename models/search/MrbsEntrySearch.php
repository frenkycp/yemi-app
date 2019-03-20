<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MrbsEntry;

/**
* MrbsEntrySearch represents the model behind the search form about `app\models\MrbsEntry`.
*/
class MrbsEntrySearch extends MrbsEntry
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'start_time', 'end_time', 'entry_type', 'repeat_id', 'room_id', 'status', 'reminded', 'info_time', 'ical_sequence'], 'integer'],
            [['timestamp', 'create_by', 'modified_by', 'name', 'type', 'description', 'info_user', 'info_text', 'ical_uid', 'ical_recur_id', 'meeting_status', 'tgl_start', 'tgl_end'], 'safe'],
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
$query = MrbsEntry::find();

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
            'DATE(from_unixtime(start_time))' => $this->tgl_start,
            //'end_time' => $this->end_time,
            'entry_type' => $this->entry_type,
            'repeat_id' => $this->repeat_id,
            'room_id' => $this->room_id,
            'timestamp' => $this->timestamp,
            'status' => $this->status,
            'reminded' => $this->reminded,
            'info_time' => $this->info_time,
            'ical_sequence' => $this->ical_sequence,
        ]);

        $query->andFilterWhere(['like', 'create_by', $this->create_by])
            //->andFilterWhere(['like', 'start_time', $this->start_time])
            //->andFilterWhere(['like', 'end_time', $this->end_time])
            ->andFilterWhere(['like', 'modified_by', $this->modified_by])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'info_user', $this->info_user])
            ->andFilterWhere(['like', 'info_text', $this->info_text])
            ->andFilterWhere(['like', 'ical_uid', $this->ical_uid])
            ->andFilterWhere(['like', 'ical_recur_id', $this->ical_recur_id])
            ->andFilterWhere(['like', 'meeting_status', $this->meeting_status]);

return $dataProvider;
}
}