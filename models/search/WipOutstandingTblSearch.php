<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WipHdrDtrOutstanding;

/**
* WipOutstandingTblSearch represents the model behind the search form about `app\models\WipHdrDtrOutstanding`.
*/
class WipOutstandingTblSearch extends WipHdrDtrOutstanding
{
/**
* @inheritdoc
*/
public function rules()
{
return [
      [['period', 'child_analyst', 'child_analyst_desc', 'child', 'child_desc', 'model_group'], 'string'],
            [['start_date'], 'safe'],
            [['total_qty'], 'number']
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
$query = WipHdrDtrOutstanding::find();

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
    'defaultOrder' => [
        'period' => SORT_ASC,
        'start_date' => SORT_ASC,
        'child_analyst_desc' => SORT_ASC,
        'child_desc' => SORT_ASC,
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
            'period' => $this->period,
            'child_analyst' => $this->child_analyst,
            'child' => $this->child,
        ]);

        $query->andFilterWhere(['like', 'child_analyst_desc', $this->child_analyst_desc])
            ->andFilterWhere(['like', 'child_desc', $this->child_desc])
            ->andFilterWhere(['like', 'model_group', $this->model_group])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),start_date,120)', $this->start_date]);

return $dataProvider;
}
}