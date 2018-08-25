<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ItrnHisTbl;

/**
* ItrnHisTblSearch represents the model behind the search form about `app\models\ItrnHisTbl`.
*/
class ItrnHisTblSearch extends ItrnHisTbl
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['ITRN_SEQ', 'POST_QTY_IN', 'POST_QTY_OUT', 'RCV_ID'], 'number'],
            [['LOC', 'FROM_LOC', 'TO_LOC', 'ITEM_EQ', 'POST_DATE', 'TRANS_CODE', 'PO_HDR_NO_EQ', 'PO_LINE_NO', 'PR_HDR_NO', 'PUR_LOC', 'PUR_LOC_DESC', 'NOTE', 'USER_ID', 'USER_DESC', 'LAST_UPDATE', 'BC_NUMBER', 'BC_FORM', 'SLIP', 'PR_COST_DEP', 'NIP_RCV', 'NAMA_RCV', 'PHONE_RCV'], 'safe'],
            [['PO_LINE', 'PR_LINE', 'PR_LINE_NO'], 'integer'],
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
$query = ItrnHisTbl::find()->where(['LOC' => 'MNT', 'TRANS_CODE' => 'LOC-ISS']);

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
            'ITRN_SEQ' => $this->ITRN_SEQ,
            //'POST_DATE' => $this->POST_DATE,
            'POST_QTY_IN' => $this->POST_QTY_IN,
            'POST_QTY_OUT' => $this->POST_QTY_OUT,
            'RCV_ID' => $this->RCV_ID,
            'PO_LINE' => $this->PO_LINE,
            'PR_LINE' => $this->PR_LINE,
            'PR_LINE_NO' => $this->PR_LINE_NO,
            'LAST_UPDATE' => $this->LAST_UPDATE,
        ]);

        $query->andFilterWhere(['like', 'LOC', $this->LOC])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),POST_DATE,120)', $this->POST_DATE])
            ->andFilterWhere(['like', 'FROM_LOC', $this->FROM_LOC])
            ->andFilterWhere(['like', 'TO_LOC', $this->TO_LOC])
            ->andFilterWhere(['like', 'ITEM_EQ', $this->ITEM_EQ])
            ->andFilterWhere(['like', 'TRANS_CODE', $this->TRANS_CODE])
            ->andFilterWhere(['like', 'PO_HDR_NO_EQ', $this->PO_HDR_NO_EQ])
            ->andFilterWhere(['like', 'PO_LINE_NO', $this->PO_LINE_NO])
            ->andFilterWhere(['like', 'PR_HDR_NO', $this->PR_HDR_NO])
            ->andFilterWhere(['like', 'PUR_LOC', $this->PUR_LOC])
            ->andFilterWhere(['like', 'PUR_LOC_DESC', $this->PUR_LOC_DESC])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'USER_DESC', $this->USER_DESC])
            ->andFilterWhere(['like', 'BC_NUMBER', $this->BC_NUMBER])
            ->andFilterWhere(['like', 'BC_FORM', $this->BC_FORM])
            ->andFilterWhere(['like', 'SLIP', $this->SLIP])
            ->andFilterWhere(['like', 'PR_COST_DEP', $this->PR_COST_DEP])
            ->andFilterWhere(['like', 'NIP_RCV', $this->NIP_RCV])
            ->andFilterWhere(['like', 'NAMA_RCV', $this->NAMA_RCV])
            ->andFilterWhere(['like', 'PHONE_RCV', $this->PHONE_RCV]);

return $dataProvider;
}
}