<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\IpqaPatrolTbl;
use kartik\date\DatePicker;

/**
* IpqaPatrolTblSearch represents the model behind the search form about `app\models\IpqaPatrolTbl`.
*/
class IpqaPatrolTblSearch extends IpqaPatrolTbl
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'status', 'flag'], 'integer'],
            [['period', 'event_date', 'gmc', 'model_name', 'color', 'destination', 'category', 'problem', 'description', 'inspector_id', 'inspector_name', 'cause', 'countermeasure', 'input_datetime', 'close_datetime', 'line_pic'], 'safe'],
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
$query = IpqaPatrolTbl::find()->where(['flag' => 1]);

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
      'defaultOrder' => [
            //'cust_desc' => SORT_ASC,
            'status' => SORT_ASC,
            'event_date' => SORT_DESC,
            'input_datetime' => SORT_DESC
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
            'id' => $this->id,
            'event_date' => $this->event_date,
            'status' => $this->status,
            'input_datetime' => $this->input_datetime,
            'close_datetime' => $this->close_datetime,
            'flag' => $this->flag,
        ]);

        $query->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'gmc', $this->gmc])
            ->andFilterWhere(['like', 'line_pic', $this->line_pic])
            ->andFilterWhere(['like', 'model_name', $this->model_name])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'destination', $this->destination])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'problem', $this->problem])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'inspector_id', $this->inspector_id])
            ->andFilterWhere(['like', 'inspector_name', $this->inspector_name])
            ->andFilterWhere(['like', 'cause', $this->cause])
            ->andFilterWhere(['like', 'countermeasure', $this->countermeasure]);

return $dataProvider;
}
}