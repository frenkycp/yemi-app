<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\KlinikObatLog;

/**
* KlinikObatLogSearch represents the model behind the search form about `app\models\KlinikObatLog`.
*/
class KlinikObatLogSearch extends KlinikObatLog
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'flag'], 'integer'],
            [['klinik_input_pk', 'period', 'post_date', 'input_datetime', 'user_id', 'user_name', 'part_no', 'part_desc'], 'safe'],
            [['qty'], 'number'],
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
$query = KlinikObatLog::find();

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
            'post_date' => $this->post_date,
            'input_datetime' => $this->input_datetime,
            'qty' => $this->qty,
            'flag' => $this->flag,
        ]);

        $query->andFilterWhere(['like', 'klinik_input_pk', $this->klinik_input_pk])
            ->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'part_no', $this->part_no])
            ->andFilterWhere(['like', 'part_desc', $this->part_desc]);

return $dataProvider;
}
}