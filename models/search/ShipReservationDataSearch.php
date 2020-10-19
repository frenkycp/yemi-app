<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ShipReservationDtr;

/**
* ShipReservationDataSearch represents the model behind the search form about `app\models\ShipReservationDtr`.
*/
class ShipReservationDataSearch extends ShipReservationDtr
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['BL_NO', 'RESERVATION_NO', 'HELP', 'STATUS', 'SHIPPER', 'POL', 'POD', 'CARRIER', 'FLAG_DESC', 'ETD', 'APPLIED_RATE', 'INVOICE', 'NOTE', 'YCJ_REF_NO'], 'safe'],
            [['CNT_40HC', 'CNT_40', 'CNT_20'], 'number'],
            [['FLAG_PRIORTY'], 'integer'],
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
$query = ShipReservationDtr::find();

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
            'CNT_40HC' => $this->CNT_40HC,
            'CNT_40' => $this->CNT_40,
            'CNT_20' => $this->CNT_20,
            'FLAG_PRIORTY' => $this->FLAG_PRIORTY,
            'ETD' => $this->ETD,
        ]);

        $query->andFilterWhere(['like', 'BL_NO', $this->BL_NO])
            ->andFilterWhere(['like', 'RESERVATION_NO', $this->RESERVATION_NO])
            ->andFilterWhere(['like', 'HELP', $this->HELP])
            ->andFilterWhere(['like', 'YCJ_REF_NO', $this->YCJ_REF_NO])
            ->andFilterWhere(['like', 'STATUS', $this->STATUS])
            ->andFilterWhere(['like', 'SHIPPER', $this->SHIPPER])
            ->andFilterWhere(['like', 'POL', $this->POL])
            ->andFilterWhere(['like', 'POD', $this->POD])
            ->andFilterWhere(['like', 'CARRIER', $this->CARRIER])
            ->andFilterWhere(['like', 'FLAG_DESC', $this->FLAG_DESC])
            ->andFilterWhere(['like', 'APPLIED_RATE', $this->APPLIED_RATE])
            ->andFilterWhere(['like', 'INVOICE', $this->INVOICE])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE]);

return $dataProvider;
}
}