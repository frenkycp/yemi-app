<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TraceItemScrap;

/**
* ScrapRequestSearch represents the model behind the search form about `app\models\TraceItemScrap`.
*/
class ScrapRequestSearch extends TraceItemScrap
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['SERIAL_NO', 'ITEM', 'ITEM_DESC', 'SUPPLIER', 'SUPPLIER_DESC', 'UM', 'EXPIRED_DATE', 'LATEST_EXPIRED_DATE', 'USER_ID', 'USER_DESC', 'USER_LAST_UPDATE', 'STATUS', 'CLOSE_BY_ID', 'CLOSE_BY_NAME', 'CLOSE_DATETIME', 'REMARK'], 'safe'],
            [['QTY'], 'number'],
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
$query = TraceItemScrap::find();

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
            'QTY' => $this->QTY,
            'EXPIRED_DATE' => $this->EXPIRED_DATE,
            'LATEST_EXPIRED_DATE' => $this->LATEST_EXPIRED_DATE,
            'USER_LAST_UPDATE' => $this->USER_LAST_UPDATE,
            'CLOSE_DATETIME' => $this->CLOSE_DATETIME,
        ]);

        $query->andFilterWhere(['like', 'SERIAL_NO', $this->SERIAL_NO])
            ->andFilterWhere(['like', 'ITEM', $this->ITEM])
            ->andFilterWhere(['like', 'ITEM_DESC', $this->ITEM_DESC])
            ->andFilterWhere(['like', 'SUPPLIER', $this->SUPPLIER])
            ->andFilterWhere(['like', 'SUPPLIER_DESC', $this->SUPPLIER_DESC])
            ->andFilterWhere(['like', 'UM', $this->UM])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'USER_DESC', $this->USER_DESC])
            ->andFilterWhere(['like', 'STATUS', $this->STATUS])
            ->andFilterWhere(['like', 'CLOSE_BY_ID', $this->CLOSE_BY_ID])
            ->andFilterWhere(['like', 'CLOSE_BY_NAME', $this->CLOSE_BY_NAME])
            ->andFilterWhere(['like', 'REMARK', $this->REMARK]);

return $dataProvider;
}
}