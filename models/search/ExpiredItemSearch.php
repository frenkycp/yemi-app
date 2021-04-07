<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TraceItemDtr;

/**
* ExpiredItemSearch represents the model behind the search form about `app\models\TraceItemDtr`.
*/
class ExpiredItemSearch extends TraceItemDtr
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['SERIAL_NO', 'ITEM', 'ITEM_DESC', 'SUPPLIER', 'SUPPLIER_DESC', 'UM', 'LOT_NO', 'RECEIVED_DATE', 'SURAT_JALAN', 'MANUFACTURED_DATE', 'EXPIRED_DATE', 'BENTUK_KEMASAN', 'USER_ID', 'USER_DESC', 'LAST_UPDATE', 'AVAILABLE', 'CATEGORY', 'LOC', 'LOC_DESC', 'POST_DATE', 'PERIOD', 'ID_STOK', 'SCRAP_REQUEST_STATUS'], 'safe'],
            [['EXPIRED_REVISION_NO'], 'integer'],
            [['LIFE_TIME', 'ISI_DALAM_KEMASAN', 'NILAI_INVENTORY', 'STD_PRICE', 'STD_AMT'], 'number'],
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
$query = TraceItemDtr::find()->where(['<', 'EXPIRED_DATE', date('Y-m-d', strtotime(' +1 month'))])->andWhere(['AVAILABLE' => 'Y']);

$dataProvider = new ActiveDataProvider([
      'query' => $query,
      'sort' => [
            'defaultOrder' => [
                  //'cust_desc' => SORT_ASC,
                  'EXPIRED_DATE' => SORT_ASC,
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
            'EXPIRED_REVISION_NO' => $this->EXPIRED_REVISION_NO,
            'LIFE_TIME' => $this->LIFE_TIME,
            'ISI_DALAM_KEMASAN' => $this->ISI_DALAM_KEMASAN,
            'NILAI_INVENTORY' => $this->NILAI_INVENTORY,
            'STD_PRICE' => $this->STD_PRICE,
            'STD_AMT' => $this->STD_AMT,
            'LAST_UPDATE' => $this->LAST_UPDATE,
            'POST_DATE' => $this->POST_DATE,
            'SCRAP_REQUEST_STATUS' => $this->SCRAP_REQUEST_STATUS,
        ]);

        $query->andFilterWhere(['like', 'SERIAL_NO', $this->SERIAL_NO])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),EXPIRED_DATE,120)', $this->EXPIRED_DATE])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),RECEIVED_DATE,120)', $this->RECEIVED_DATE])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),MANUFACTURED_DATE,120)', $this->MANUFACTURED_DATE])
            ->andFilterWhere(['like', 'ITEM', $this->ITEM])
            ->andFilterWhere(['like', 'ITEM_DESC', $this->ITEM_DESC])
            ->andFilterWhere(['like', 'SUPPLIER', $this->SUPPLIER])
            ->andFilterWhere(['like', 'SUPPLIER_DESC', $this->SUPPLIER_DESC])
            ->andFilterWhere(['like', 'UM', $this->UM])
            ->andFilterWhere(['like', 'LOT_NO', $this->LOT_NO])
            ->andFilterWhere(['like', 'SURAT_JALAN', $this->SURAT_JALAN])
            ->andFilterWhere(['like', 'BENTUK_KEMASAN', $this->BENTUK_KEMASAN])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'USER_DESC', $this->USER_DESC])
            ->andFilterWhere(['like', 'AVAILABLE', $this->AVAILABLE])
            ->andFilterWhere(['like', 'CATEGORY', $this->CATEGORY])
            ->andFilterWhere(['like', 'LOC', $this->LOC])
            ->andFilterWhere(['like', 'LOC_DESC', $this->LOC_DESC])
            ->andFilterWhere(['like', 'PERIOD', $this->PERIOD])
            ->andFilterWhere(['like', 'ID_STOK', $this->ID_STOK]);

return $dataProvider;
}
}