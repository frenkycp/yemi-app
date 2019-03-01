<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DrsView03;

/**
* DrsDataSearch represents the model behind the search form about `app\models\DrsView03`.
*/
class DrsDataSearch extends DrsView03
{
/**
* @inheritdoc
*/
public function rules()
{
return [
            [['DRS_NO', 'NG_LOC', 'NG_LOC_DESC', 'ITEM', 'ITEM_DESC', 'UM', 'REASON_ID', 'REASON_DESC', 'REMARK', 'DRS_PUR_LOC', 'DRS_PUR_LOC_DESC', 'DRS_CURR', 'PIC_DELIVERY', 'DSR_STAT', 'DRS_USER_ID', 'DRS_USER_DESC', 'DEBIT_PUR_LOC', 'DEBIT_PUR_LOC_DESC', 'DEBIT_NO', 'DEBIT_URUT', 'DEBIT_CURR', 'DEBIT_STAT', 'DEBIT_REASON', 'DEBIT_REASON_DESC', 'DEBIT_NOTE', 'DEBIT_NOTE2', 'DEBIT_USER_ID', 'DEBIT_USER_DESC'], 'string'],
            [['DRS_DATE', 'DRS_LAST_UPDATE', 'DEBIT_DATE', 'DEBIT_LAST_UPDATE'], 'safe'],
            [['NG_QTY', 'LOT_QTY', 'DRS_UNIT_PRICE', 'DRS_AMOUNT', 'DEBIT_QTY', 'DEBIT_PRICE', 'DEBIT_AMOUNT'], 'number']
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
$query = DrsView03::find();

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
            'NG_LOC' => $this->NG_LOC,
            'ITEM' => $this->ITEM,
            'UM' => $this->UM,
            'NG_QTY' => $this->NG_QTY,
            'LOT_QTY' => $this->LOT_QTY,
            'REASON_ID' => $this->REASON_ID,
            'DRS_NO' => $this->DRS_NO,
        ]);

$query->andFilterWhere(['like', 'CONVERT(VARCHAR(10),DRS_DATE,120)', $this->DRS_DATE])
      ->andFilterWhere(['like', 'REMARK', $this->REMARK])
      ->andFilterWhere(['like', 'DEBIT_PUR_LOC_DESC', $this->DEBIT_PUR_LOC_DESC])
      ->andFilterWhere(['like', 'DRS_PUR_LOC_DESC', $this->DRS_PUR_LOC_DESC])
      ->andFilterWhere(['like', 'ITEM_DESC', $this->ITEM_DESC]);

/*$query->andFilterWhere([
            'YEAR' => $this->YEAR,
            'WEEK' => $this->WEEK,
            'DATE' => $this->DATE,
            'TOTAL_KARYAWAN' => $this->TOTAL_KARYAWAN,
            'KEHADIRAN' => $this->KEHADIRAN,
            'BONUS' => $this->BONUS,
            'DISIPLIN' => $this->DISIPLIN,
        ]);

        $query->andFilterWhere(['like', 'NIK_DATE_ID', $this->NIK_DATE_ID])
            ->andFilterWhere(['like', 'NO', $this->NO])
            ->andFilterWhere(['like', 'NIK', $this->NIK])
            ->andFilterWhere(['like', 'CC_ID', $this->CC_ID])
            ->andFilterWhere(['like', 'SECTION', $this->SECTION])
            ->andFilterWhere(['like', 'DIRECT_INDIRECT', $this->DIRECT_INDIRECT])
            ->andFilterWhere(['like', 'NAMA_KARYAWAN', $this->NAMA_KARYAWAN])
            ->andFilterWhere(['like', 'PERIOD', $this->PERIOD])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE])
            ->andFilterWhere(['like', 'DAY_STAT', $this->DAY_STAT])
            ->andFilterWhere(['like', 'CATEGORY', $this->CATEGORY]);*/

return $dataProvider;
}
}