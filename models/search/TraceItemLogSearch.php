<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TraceItemDtrLog;

/**
* TraceItemLogSearch represents the model behind the search form about `app\models\TraceItemDtrLog`.
*/
class TraceItemLogSearch extends TraceItemDtrLog
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['SEQ', 'EXPIRED_REVISION_NO'], 'integer'],
            [['SERIAL_NO', 'ITEM', 'ITEM_DESC', 'SUPPLIER', 'SUPPLIER_DESC', 'UM', 'LOT_NO', 'RECEIVED_DATE', 'SURAT_JALAN', 'MANUFACTURED_DATE', 'EXPIRED_DATE', 'BENTUK_KEMASAN', 'USER_ID', 'USER_DESC', 'LAST_UPDATE', 'AVAILABLE', 'CATEGORY', 'TRANS_ID', 'LOC', 'LOC_DESC', 'POST_DATE', 'PERIOD', 'NOTE', 'ID_STOK'], 'safe'],
            [['LIFE_TIME', 'ISI_DALAM_KEMASAN', 'NILAI_INVENTORY', 'STD_PRICE', 'STD_AMT', 'QTY_IN', 'QTY_OUT'], 'number'],
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
$query = TraceItemDtrLog::find()->where('POST_DATE IS NOT NULL')->andWhere(['TRANS_ID' => ['IN', 'OUT', 'TRANSFER']]);

$dataProvider = new ActiveDataProvider([
      'query' => $query,
      'sort' => [
            'defaultOrder' => [
                  'LAST_UPDATE' => SORT_DESC,
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
            'RECEIVED_DATE' => $this->RECEIVED_DATE,
            'MANUFACTURED_DATE' => $this->MANUFACTURED_DATE,
            'EXPIRED_DATE' => $this->EXPIRED_DATE,
            'EXPIRED_REVISION_NO' => $this->EXPIRED_REVISION_NO,
            'LIFE_TIME' => $this->LIFE_TIME,
            'ISI_DALAM_KEMASAN' => $this->ISI_DALAM_KEMASAN,
            'NILAI_INVENTORY' => $this->NILAI_INVENTORY,
            'STD_PRICE' => $this->STD_PRICE,
            'STD_AMT' => $this->STD_AMT,
            'QTY_IN' => $this->QTY_IN,
            'QTY_OUT' => $this->QTY_OUT,
            'POST_DATE' => $this->POST_DATE,
        ]);

        $query->andFilterWhere(['like', 'SERIAL_NO', $this->SERIAL_NO])
            ->andFilterWhere(['like', 'ITEM', $this->ITEM])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),LAST_UPDATE,120)', $this->LAST_UPDATE])
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
            ->andFilterWhere(['like', 'TRANS_ID', $this->TRANS_ID])
            ->andFilterWhere(['like', 'LOC', $this->LOC])
            ->andFilterWhere(['like', 'LOC_DESC', $this->LOC_DESC])
            ->andFilterWhere(['like', 'PERIOD', $this->PERIOD])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE])
            ->andFilterWhere(['like', 'ID_STOK', $this->ID_STOK]);

return $dataProvider;
}
}