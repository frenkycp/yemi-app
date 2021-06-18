<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ShipLiner;

/**
* ShipCarrierDataSearch represents the model behind the search form about `app\models\ShipLiner`.
*/
class ShipCarrierDataSearch extends ShipLiner
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['SEQ', 'FLAG_PRIORITY'], 'integer'],
            [['COUNTRY', 'POD', 'FLAG_DESC', 'CARRIER'], 'safe'],
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
$query = ShipLiner::find();

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
    'defaultOrder' => [
        //'cust_desc' => SORT_ASC,
        'COUNTRY' => SORT_ASC,
        'POD' => SORT_ASC,
        'FLAG_PRIORITY' => SORT_ASC,
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
            'SEQ' => $this->SEQ,
            'FLAG_PRIORITY' => $this->FLAG_PRIORITY,
        ]);

        $query->andFilterWhere(['like', 'COUNTRY', $this->COUNTRY])
            ->andFilterWhere(['like', 'POD', $this->POD])
            ->andFilterWhere(['like', 'FLAG_DESC', $this->FLAG_DESC])
            ->andFilterWhere(['like', 'CARRIER', $this->CARRIER]);

return $dataProvider;
}
}