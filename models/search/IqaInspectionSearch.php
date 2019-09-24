<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StoreInOutWsus;

/**
* IqaInspectionSearch represents the model behind the search form about `app\models\StoreInOutWsus`.
*/
class IqaInspectionSearch extends StoreInOutWsus
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['SEQ_LOG', 'SEQ_ID'], 'integer'],
            [['POST_DATE', 'TAG_SLIP', 'SLIP_REF', 'NO', 'LOC', 'LOC_DESC', 'ITEM', 'ITEM_DESC', 'UM', 'PROD_USE', 'USER_ID', 'USER_DESC', 'LAST_UPDATE', 'STATUS', 'TRANS_ID', 'TRANS_DESC', 'BC_NO', 'LOT_CODE', 'BACTH_NO', 'CSI_NO', 'KURIR', 'NOTE', 'PIC', 'RACK', 'RACK_LOC', 'IQA', 'sap_post_date_sinkron', 'olah', 'AUTO_REPORT', 'CANCEL', 'Inspection_level', 'Judgement', 'Remark', 'inspect_by_id', 'inspect_by_name', 'inspect_datetime', 'inspect_period'], 'safe'],
            [['QTY_IN', 'QTY_OUT'], 'number'],
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
$query = StoreInOutWsus::find();

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
            'SEQ_LOG' => $this->SEQ_LOG,
            'POST_DATE' => $this->POST_DATE,
            'SEQ_ID' => $this->SEQ_ID,
            'QTY_IN' => $this->QTY_IN,
            'QTY_OUT' => $this->QTY_OUT,
            'LAST_UPDATE' => $this->LAST_UPDATE,
            'inspect_datetime' => $this->inspect_datetime,
        ]);

        $query->andFilterWhere(['like', 'TAG_SLIP', $this->TAG_SLIP])
            ->andFilterWhere(['like', 'SLIP_REF', $this->SLIP_REF])
            ->andFilterWhere(['like', 'NO', $this->NO])
            ->andFilterWhere(['like', 'LOC', $this->LOC])
            ->andFilterWhere(['like', 'LOC_DESC', $this->LOC_DESC])
            ->andFilterWhere(['like', 'ITEM', $this->ITEM])
            ->andFilterWhere(['like', 'ITEM_DESC', $this->ITEM_DESC])
            ->andFilterWhere(['like', 'UM', $this->UM])
            ->andFilterWhere(['like', 'PROD_USE', $this->PROD_USE])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'USER_DESC', $this->USER_DESC])
            ->andFilterWhere(['like', 'STATUS', $this->STATUS])
            ->andFilterWhere(['like', 'TRANS_ID', $this->TRANS_ID])
            ->andFilterWhere(['like', 'TRANS_DESC', $this->TRANS_DESC])
            ->andFilterWhere(['like', 'BC_NO', $this->BC_NO])
            ->andFilterWhere(['like', 'LOT_CODE', $this->LOT_CODE])
            ->andFilterWhere(['like', 'BACTH_NO', $this->BACTH_NO])
            ->andFilterWhere(['like', 'CSI_NO', $this->CSI_NO])
            ->andFilterWhere(['like', 'KURIR', $this->KURIR])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE])
            ->andFilterWhere(['like', 'PIC', $this->PIC])
            ->andFilterWhere(['like', 'RACK', $this->RACK])
            ->andFilterWhere(['like', 'RACK_LOC', $this->RACK_LOC])
            ->andFilterWhere(['like', 'IQA', $this->IQA])
            ->andFilterWhere(['like', 'sap_post_date_sinkron', $this->sap_post_date_sinkron])
            ->andFilterWhere(['like', 'olah', $this->olah])
            ->andFilterWhere(['like', 'AUTO_REPORT', $this->AUTO_REPORT])
            ->andFilterWhere(['like', 'CANCEL', $this->CANCEL])
            ->andFilterWhere(['like', 'Inspection_level', $this->Inspection_level])
            //->andFilterWhere(['like', 'Judgement', $this->Judgement])
            ->andFilterWhere(['like', 'Remark', $this->Remark])
            ->andFilterWhere(['like', 'inspect_by_id', $this->inspect_by_id])
            ->andFilterWhere(['like', 'inspect_by_name', $this->inspect_by_name])
            ->andFilterWhere(['like', 'inspect_period', $this->inspect_period]);

      if ($this->Judgement == 'PENDING') {
            $query->andFilterWhere(['is', 'Judgement', new \yii\db\Expression('null')]);
      } else {
            $query->andFilterWhere(['like', 'Judgement', $this->Judgement]);
      }

return $dataProvider;
}
}