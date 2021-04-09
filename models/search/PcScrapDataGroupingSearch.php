<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ScrapSummaryView02;

/**
* PcScrapDataGroupingSearch represents the model behind the search form about `app\models\ScrapSummaryView02`.
*/
class PcScrapDataGroupingSearch extends ScrapSummaryView02
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['period', 'model', 'material', 'descriptions', 'storage_loc_new', 'storage_loc_desc_new'], 'safe'],
            [['in_qty', 'in_amt'], 'number'],
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
$query = ScrapSummaryView02::find();

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
        'defaultOrder' => [
            //'cust_desc' => SORT_ASC,
            'in_amt' => SORT_DESC,
        ]
    ],
]);

$this->load($params);

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

/*$query->andFilterWhere([
            'price' => $this->price,
            'begin_qty' => $this->begin_qty,
            'begin_amt' => $this->begin_amt,
            'receipt_qty' => $this->receipt_qty,
            'receipt_amt' => $this->receipt_amt,
            'issue_qty' => $this->issue_qty,
            'issue_qty_amt' => $this->issue_qty_amt,
            'issue_other_qty' => $this->issue_other_qty,
            'issue_other_amt' => $this->issue_other_amt,
            'std_price_var' => $this->std_price_var,
            'ending_qty' => $this->ending_qty,
            'ending_amt' => $this->ending_amt,
        ]);*/

        $query->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'material', $this->material])
            ->andFilterWhere(['like', 'descriptions', $this->descriptions])
            ->andFilterWhere(['like', 'storage_loc_new', $this->storage_loc_new])
            ->andFilterWhere(['like', 'storage_loc_desc_new', $this->storage_loc_desc_new]);

return $dataProvider;
}
}