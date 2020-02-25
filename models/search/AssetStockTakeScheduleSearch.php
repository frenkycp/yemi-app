<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AssetStockTakeSchedule;

/**
* AssetStockTakeScheduleSearch represents the model behind the search form about `app\models\AssetStockTakeSchedule`.
*/
class AssetStockTakeScheduleSearch extends AssetStockTakeSchedule
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['schedule_id', 'total_open', 'total_close', 'flag'], 'integer'],
            [['start_date', 'end_date', 'create_by_id', 'create_by_name', 'create_time', 'update_by_id', 'update_by_name', 'update_time'], 'safe'],
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
$query = AssetStockTakeSchedule::find();

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
            'schedule_id' => $this->schedule_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'total_open' => $this->total_open,
            'total_close' => $this->total_close,
            'flag' => $this->flag,
        ]);

        $query->andFilterWhere(['like', 'create_by_id', $this->create_by_id])
            ->andFilterWhere(['like', 'create_by_name', $this->create_by_name])
            ->andFilterWhere(['like', 'update_by_id', $this->update_by_id])
            ->andFilterWhere(['like', 'update_by_name', $this->update_by_name]);

return $dataProvider;
}
}