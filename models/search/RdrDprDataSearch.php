<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RdrDprData;

/**
* RdrDprDataSearch represents the model behind the search form about `app\models\RdrDprData`.
*/
class RdrDprDataSearch extends RdrDprData
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['material_document_number', 'material_document_number_barcode', 'period', 'rcv_date', 'vendor_code', 'vendor_name', 'pic', 'division', 'NOTE', 'inv_no', 'material', 'description', 'um', 'rdr_dpr', 'category', 'normal_urgent', 'user_id', 'user_desc', 'user_issue_date', 'korlap', 'korlap_desc', 'korlap_confirm_date', 'purc_approve', 'purc_approve_desc', 'purc_approve_date', 'discrepancy_treatment', 'payment_treatment', 'purc_approve_remark', 'user_close', 'user_close_desc', 'user_close_date', 'close_open'], 'safe'],
            [['do_inv_qty', 'act_rcv_qty', 'discrepancy_qty', 'standard_price', 'standard_amount'], 'number'],
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
      if ($params['approval_type'] == 'korlap') {
            $query = RdrDprData::find()->where('korlap IS NULL');
      } else {
            $query = RdrDprData::find();
      }


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
            'rcv_date' => $this->rcv_date,
            'do_inv_qty' => $this->do_inv_qty,
            'act_rcv_qty' => $this->act_rcv_qty,
            'discrepancy_qty' => $this->discrepancy_qty,
            'standard_price' => $this->standard_price,
            'standard_amount' => $this->standard_amount,
            'user_issue_date' => $this->user_issue_date,
            'purc_approve_date' => $this->purc_approve_date,
            'user_close_date' => $this->user_close_date,
        ]);

        $query->andFilterWhere(['like', 'material_document_number', $this->material_document_number])
            ->andFilterWhere(['like', 'material_document_number_barcode', $this->material_document_number_barcode])
            ->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'vendor_code', $this->vendor_code])
            ->andFilterWhere(['like', 'vendor_name', $this->vendor_name])
            ->andFilterWhere(['like', 'pic', $this->pic])
            ->andFilterWhere(['like', 'division', $this->division])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE])
            ->andFilterWhere(['like', 'inv_no', $this->inv_no])
            ->andFilterWhere(['like', 'material', $this->material])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'um', $this->um])
            ->andFilterWhere(['like', 'rdr_dpr', $this->rdr_dpr])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'normal_urgent', $this->normal_urgent])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'user_desc', $this->user_desc])
            ->andFilterWhere(['like', 'korlap', $this->korlap])
            ->andFilterWhere(['like', 'korlap_desc', $this->korlap_desc])
            ->andFilterWhere(['like', 'korlap_confirm_date', $this->korlap_confirm_date])
            ->andFilterWhere(['like', 'purc_approve', $this->purc_approve])
            ->andFilterWhere(['like', 'purc_approve_desc', $this->purc_approve_desc])
            ->andFilterWhere(['like', 'discrepancy_treatment', $this->discrepancy_treatment])
            ->andFilterWhere(['like', 'payment_treatment', $this->payment_treatment])
            ->andFilterWhere(['like', 'purc_approve_remark', $this->purc_approve_remark])
            ->andFilterWhere(['like', 'user_close', $this->user_close])
            ->andFilterWhere(['like', 'user_close_desc', $this->user_close_desc])
            ->andFilterWhere(['like', 'close_open', $this->close_open]);

return $dataProvider;
}
}