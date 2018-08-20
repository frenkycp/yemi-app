<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SernoOutput;

/**
* ProductionContainerEvidenceSearch represents the model behind the search form about `app\models\SernoOutput`.
*/
class ProductionContainerEvidenceSearch extends SernoOutput
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['pk', 'uniq', 'stc', 'dst', 'gmc', 'vms', 'etd', 'ship', 'category', 'remark', 'invo', 'cont'], 'safe'],
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
$query = SernoOutput::find()->groupBy('cntr');

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
            'so' => $this->so,
            'num' => $this->num,
            'qty' => $this->qty,
            'output' => $this->output,
            'adv' => $this->adv,
            'vms' => $this->vms,
            //'etd' => $this->etd,
            'ship' => $this->ship,
            'cntr' => $this->cntr,
            'm3' => $this->m3,
            'back_order' => $this->back_order,
        ]);

        $query->andFilterWhere(['like', 'pk', $this->pk])
            ->andFilterWhere(['like', 'etd', $this->etd])
            ->andFilterWhere(['like', 'uniq', $this->uniq])
            ->andFilterWhere(['like', 'stc', $this->stc])
            ->andFilterWhere(['like', 'dst', $this->dst])
            ->andFilterWhere(['like', 'gmc', $this->gmc])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'invo', $this->invo])
            ->andFilterWhere(['like', 'cont', $this->cont]);

return $dataProvider;
}
}