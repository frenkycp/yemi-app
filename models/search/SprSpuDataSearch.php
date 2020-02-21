<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SprPcb;

/**
* SprSpuDataSearch represents the model behind the search form about `app\models\SprPcb`.
*/
class SprSpuDataSearch extends SprPcb
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'qty'], 'integer'],
            [['item', 'tgl', 'line'], 'safe'],
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
$query = SprPcb::find()->where([
	'line' => ['Woofer 1', 'Woofer 2', 'Woofer 3', 'Tweeter']
]);

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
    'defaultOrder' => [
        //'cust_desc' => SORT_ASC,
        'tgl' => SORT_ASC,
        'line' => SORT_ASC,
        'id' => SORT_ASC
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
            'qty' => $this->qty,
        ]);

        $query->andFilterWhere(['like', 'item', $this->item])
        ->andFilterWhere(['like', 'line', $this->line])
        ->andFilterWhere(['like', 'tgl', $this->tgl]);

return $dataProvider;
}
}