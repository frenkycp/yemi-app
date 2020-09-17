<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StoreOnhandWsus;

/**
* StockTakeProgressDataSearch represents the model behind the search form about `app\models\StoreOnhandWsus`.
*/
class StockTakeProgressDataSearch extends StoreOnhandWsus
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['ITEM', 'ITEM_DESC', 'UM', 'PI_PERIOD', 'PI_AUDIT_LAST_UPDATE', 'PI_STAT', 'PI_DUMMY', 'model', 'VMS_VERSION', 'MAT_CLASS', 'category', 'dandory_date'], 'safe'],
            [['STD_PRICE', 'PI_VALUE', 'ONHAND_QTY', 'PI_VARIANCE', 'PI_VARIANCE_ABSOLUTE', 'ONHAND_AMT', 'PI_VALUE_AMT', 'PI_VARIANCE_AMT', 'PI_VARIANCE_ABSOLUTE_AMT', 'PI_RATE', 'PI_COUNT_1', 'PI_COUNT_2', 'PI_AUDIT_1', 'PI_AUDIT_2', 'LOC_ONHAND_QTY', 'BALANCE'], 'number'],
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
$query = StoreOnhandWsus::find();

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
            'STD_PRICE' => $this->STD_PRICE,
            'PI_VALUE' => $this->PI_VALUE,
            'ONHAND_QTY' => $this->ONHAND_QTY,
            'PI_VARIANCE' => $this->PI_VARIANCE,
            'PI_VARIANCE_ABSOLUTE' => $this->PI_VARIANCE_ABSOLUTE,
            'ONHAND_AMT' => $this->ONHAND_AMT,
            'PI_VALUE_AMT' => $this->PI_VALUE_AMT,
            'PI_VARIANCE_AMT' => $this->PI_VARIANCE_AMT,
            'PI_VARIANCE_ABSOLUTE_AMT' => $this->PI_VARIANCE_ABSOLUTE_AMT,
            'PI_RATE' => $this->PI_RATE,
            'PI_COUNT_1' => $this->PI_COUNT_1,
            'PI_COUNT_2' => $this->PI_COUNT_2,
            'PI_AUDIT_1' => $this->PI_AUDIT_1,
            'PI_AUDIT_2' => $this->PI_AUDIT_2,
            'PI_AUDIT_LAST_UPDATE' => $this->PI_AUDIT_LAST_UPDATE,
            'LOC_ONHAND_QTY' => $this->LOC_ONHAND_QTY,
            'BALANCE' => $this->BALANCE,
            'dandory_date' => $this->dandory_date,
        ]);

        $query->andFilterWhere(['like', 'ITEM', $this->ITEM])
            ->andFilterWhere(['like', 'ITEM_DESC', $this->ITEM_DESC])
            ->andFilterWhere(['like', 'UM', $this->UM])
            ->andFilterWhere(['like', 'PI_PERIOD', $this->PI_PERIOD])
            ->andFilterWhere(['like', 'PI_STAT', $this->PI_STAT])
            ->andFilterWhere(['like', 'PI_DUMMY', $this->PI_DUMMY])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'VMS_VERSION', $this->VMS_VERSION])
            ->andFilterWhere(['like', 'MAT_CLASS', $this->MAT_CLASS])
            ->andFilterWhere(['like', 'category', $this->category]);

return $dataProvider;
}
}