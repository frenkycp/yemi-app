<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SapGrGiByLocLog;

/**
* PcScrapDataSearch represents the model behind the search form about `app\models\SapGrGiByLocLog`.
*/
class PcScrapDataSearch extends SapGrGiByLocLog
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'period', 'category', 'category_desc', 'val_cls', 'val_cls_desc', 'plant', 'plant_desc', 'process', 'process_desc', 'storage_loc', 'storage_loc_desc', 'currency', 'material', 'descriptions', 'price_type', 'uom', 'flg', 'analyst', 'analyst_desc', 'delivery_pic', 'division', 'model', 'product_type', 'scrap_centre', 'dom_imp', 'dg', 'fiscal'], 'safe'],
            [['price', 'begin_qty', 'begin_amt', 'receipt_qty', 'receipt_amt', 'issue_qty', 'issue_qty_amt', 'issue_other_qty', 'issue_other_amt', 'std_price_var', 'ending_qty', 'ending_amt'], 'number'],
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
$query = SapGrGiByLocLog::find();

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
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'category_desc', $this->category_desc])
            ->andFilterWhere(['like', 'val_cls', $this->val_cls])
            ->andFilterWhere(['like', 'val_cls_desc', $this->val_cls_desc])
            ->andFilterWhere(['like', 'plant', $this->plant])
            ->andFilterWhere(['like', 'plant_desc', $this->plant_desc])
            ->andFilterWhere(['like', 'process', $this->process])
            ->andFilterWhere(['like', 'process_desc', $this->process_desc])
            ->andFilterWhere(['like', 'storage_loc', $this->storage_loc])
            ->andFilterWhere(['like', 'storage_loc_desc', $this->storage_loc_desc])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'material', $this->material])
            ->andFilterWhere(['like', 'descriptions', $this->descriptions])
            ->andFilterWhere(['like', 'price_type', $this->price_type])
            ->andFilterWhere(['like', 'uom', $this->uom])
            ->andFilterWhere(['like', 'flg', $this->flg])
            ->andFilterWhere(['like', 'analyst', $this->analyst])
            ->andFilterWhere(['like', 'analyst_desc', $this->analyst_desc])
            ->andFilterWhere(['like', 'delivery_pic', $this->delivery_pic])
            ->andFilterWhere(['like', 'division', $this->division])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'product_type', $this->product_type])
            ->andFilterWhere(['like', 'scrap_centre', $this->scrap_centre])
            ->andFilterWhere(['like', 'dom_imp', $this->dom_imp])
            ->andFilterWhere(['like', 'dg', $this->dg])
            ->andFilterWhere(['like', 'fiscal', $this->fiscal]);

return $dataProvider;
}
}