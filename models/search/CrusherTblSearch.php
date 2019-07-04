<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CrusherTbl;

/**
* CrusherTblSearch represents the model behind the search form about `app\models\CrusherTbl`.
*/
class CrusherTblSearch extends CrusherTbl
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['trans_id'], 'integer'],
            [['date', 'model', 'part'], 'safe'],
            [['qty', 'bom', 'consume'], 'number'],
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
$query = CrusherTbl::find();

$dataProvider = new ActiveDataProvider([
    'query' => $query,
    'sort' => [
        'defaultOrder' => [
            //'cust_desc' => SORT_ASC,
            'date' => SORT_ASC,
            'model' => SORT_ASC,
            'part' => SORT_ASC,
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
            'trans_id' => $this->trans_id,
            'date' => $this->date,
            'qty' => $this->qty,
            'bom' => $this->bom,
            'consume' => $this->consume,
        ]);

        $query->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'part', $this->part]);

return $dataProvider;
}
}