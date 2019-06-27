<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SernoOutput;

/**
* SoAchievementDataSearch represents the model behind the search form about `app\models\SernoOutput`.
*/
class SoAchievementDataSearch extends SernoOutput
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['pk', 'uniq', 'stc', 'dst', 'gmc', 'vms', 'etd', 'ship', 'category', 'remark', 'invo', 'cont', 'etd_old'], 'safe'],
            [['id', 'so', 'num', 'qty', 'output', 'adv', 'cntr', 'm3', 'back_order'], 'integer'],
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
$query = SernoOutput::find()
->select([
      'id',
      'monthly_total_plan' => 'SUM(qty)',
      'monthly_progress_output' => 'SUM(output)',
      'is_minus' => 'SUM(CASE WHEN qty <> output THEN 1 ELSE 0 END)',
      'total_delay' => 'SUM(CASE WHEN DATE_FORMAT(etd, \'%Y%m\') > id THEN qty ELSE 0 END)',
])
->groupBy('id')
->orderBy('id DESC')
;

$dataProvider = new ActiveDataProvider([
'query' => $query,
'pagination' => [
        'pageSize' => 5,
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
            /*'so' => $this->so,
            'num' => $this->num,
            'qty' => $this->qty,
            'output' => $this->output,
            'adv' => $this->adv,
            'vms' => $this->vms,
            'etd' => $this->etd,
            'ship' => $this->ship,
            'cntr' => $this->cntr,
            'm3' => $this->m3,
            'back_order' => $this->back_order,*/
        ]);

        /*$query->andFilterWhere(['like', 'pk', $this->pk])
            ->andFilterWhere(['like', 'uniq', $this->uniq])
            ->andFilterWhere(['like', 'stc', $this->stc])
            ->andFilterWhere(['like', 'dst', $this->dst])
            ->andFilterWhere(['like', 'gmc', $this->gmc])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'invo', $this->invo])
            ->andFilterWhere(['like', 'cont', $this->cont])
            ->andFilterWhere(['like', 'etd_old', $this->etd_old]);*/

return $dataProvider;
}
}