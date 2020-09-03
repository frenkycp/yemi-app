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
            [['period', 'event_date', 'category', 'problem', 'description', 'inspector_id', 'inspector_name', 'cause', 'countermeasure', 'input_datetime', 'close_datetime', 'line_pic', 'CC_ID', 'CC_GROUP', 'CC_DESC', 'child', 'child_desc', 'child_analyst', 'due_date', 'reject_remark', 'reject_answer', 'case_no', 'rank_category', 'fa_line'], 'safe'],
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
$query = IpqaPatrolTbl::find()
->joinWith('statusTbl')
->where(['IPQA_PATROL_TBL.flag' => 1])
->andWhere([
      'OR', ['AND', ['<', 'event_date', '2019-12-09'], ['status' => 1]], ['>=', 'event_date', '2019-12-09']
])
->orderBy('IPQA_STATUS_TBL.status_order ASC');

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
      'defaultOrder' => [
            //'cust_desc' => SORT_ASC,
            //'status' => SORT_ASC,
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
            //'flag' => $this->flag,
            'CC_ID' => $this->CC_ID,
            'CC_GROUP' => $this->CC_GROUP,
            'CC_DESC' => $this->CC_DESC,
            'child' => $this->child,
            'child_analyst' => $this->child_analyst,
            'due_date' => $this->due_date,
            'fa_line' => $this->fa_line,
            'rank_category' => $this->rank_category,
        ]);

        $query->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'line_pic', $this->line_pic])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'problem', $this->problem])
            ->andFilterWhere(['like', 'case_no', $this->case_no])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'inspector_id', $this->inspector_id])
            ->andFilterWhere(['like', 'inspector_name', $this->inspector_name])
            ->andFilterWhere(['like', 'cause', $this->cause])
            ->andFilterWhere(['like', 'child_desc', $this->child_desc])
            ->andFilterWhere(['like', 'countermeasure', $this->countermeasure]);

return $dataProvider;
}
}