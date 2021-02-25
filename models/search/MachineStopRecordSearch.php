<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MachineStopRecord;

/**
* MachineStopRecordSearch represents the model behind the search form about `app\models\MachineStopRecord`.
*/
class MachineStopRecordSearch extends MachineStopRecord
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['ID', 'STATUS'], 'integer'],
            [['MESIN_ID', 'MESIN_DESC', 'START_TIME', 'START_BY_ID', 'START_BY_NAME', 'END_TIME', 'END_BY_ID', 'END_BY_NAME', 'CLOSING_TIME', 'CLOSING_BY_ID', 'CLOSING_BY_NAME', 'PERIOD', 'POST_DATE', 'REMARK'], 'safe'],
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
$query = MachineStopRecord::find();

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
        'defaultOrder' => [
            //'cust_desc' => SORT_ASC,
            'START_TIME' => SORT_DESC,
        ]
    ],
]);

$this->load($params);

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

$query->andFilterWhere([
            'ID' => $this->ID,
            'START_TIME' => $this->START_TIME,
            'END_TIME' => $this->END_TIME,
            'CLOSING_TIME' => $this->CLOSING_TIME,
            'STATUS' => $this->STATUS,
            'PERIOD' => $this->PERIOD,
            'POST_DATE' => $this->POST_DATE,
        ]);

        $query->andFilterWhere(['like', 'MESIN_ID', $this->MESIN_ID])
            ->andFilterWhere(['like', 'MESIN_DESC', $this->MESIN_DESC])
            ->andFilterWhere(['like', 'REMARK', $this->REMARK])
            ->andFilterWhere(['like', 'START_BY_ID', $this->START_BY_ID])
            ->andFilterWhere(['like', 'START_BY_NAME', $this->START_BY_NAME])
            ->andFilterWhere(['like', 'END_BY_ID', $this->END_BY_ID])
            ->andFilterWhere(['like', 'END_BY_NAME', $this->END_BY_NAME])
            ->andFilterWhere(['like', 'CLOSING_BY_ID', $this->CLOSING_BY_ID])
            ->andFilterWhere(['like', 'CLOSING_BY_NAME', $this->CLOSING_BY_NAME]);

return $dataProvider;
}
}