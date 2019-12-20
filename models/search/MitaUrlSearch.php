<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MitaUrl;

/**
* MitaUrlSearch represents the model behind the search form about `app\models\MitaUrl`.
*/
class MitaUrlSearch extends MitaUrl
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'order_no', 'flag'], 'integer'],
            [['location', 'url', 'title'], 'safe'],
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
$query = MitaUrl::find();

$dataProvider = new ActiveDataProvider([
	'query' => $query,
	'sort' => [
        'defaultOrder' => [
            //'cust_desc' => SORT_ASC,
            'location' => SORT_ASC,
            'title' => SORT_ASC,
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
            'order_no' => $this->order_no,
            'flag' => $this->flag,
        ]);

        $query->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'title', $this->title]);

return $dataProvider;
}
}