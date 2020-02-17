<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LiveCookingRequest;

/**
* LiveCookingDataSearch represents the model behind the search form about `app\models\LiveCookingRequest`.
*/
class LiveCookingDataSearch extends LiveCookingRequest
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['SEQ', 'qty_request', 'qty_actual', 'qty_diff', 'week_no'], 'integer'],
            [['NIK_AND_DATE', 'NIK', 'NAMA_KARYAWAN', 'post_date', 'close_open', 'close_open_note', 'USER_CLOSE', 'USER_DESC_CLOSE', 'USER_LAST_UPDATE_CLOSE', 'id', 'cc', 'cc_desc', 'type', 'start_date', 'end_date', 'USER_ID', 'USER_DESC', 'USER_LAST_UPDATE', 'from_date', 'to_date', 'order_status'], 'safe'],
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
$query = LiveCookingRequest::find();

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
  'defaultOrder' => [
      //'cust_desc' => SORT_ASC,
      'USER_LAST_UPDATE' => SORT_DESC,
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
            'post_date' => $this->post_date,
            'qty_request' => $this->qty_request,
            'qty_actual' => $this->qty_actual,
            'qty_diff' => $this->qty_diff,
            'USER_LAST_UPDATE_CLOSE' => $this->USER_LAST_UPDATE_CLOSE,
            'week_no' => $this->week_no,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'USER_LAST_UPDATE' => $this->USER_LAST_UPDATE,
        ]);

        $query->andFilterWhere(['like', 'NIK_AND_DATE', $this->NIK_AND_DATE])
            ->andFilterWhere(['like', 'NIK', $this->NIK])
            ->andFilterWhere(['like', 'NAMA_KARYAWAN', $this->NAMA_KARYAWAN])
            ->andFilterWhere(['like', 'close_open', $this->close_open])
            ->andFilterWhere(['like', 'USER_CLOSE', $this->USER_CLOSE])
            ->andFilterWhere(['like', 'USER_DESC_CLOSE', $this->USER_DESC_CLOSE])
            ->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'cc', $this->cc])
            ->andFilterWhere(['like', 'cc_desc', $this->cc_desc])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'USER_DESC', $this->USER_DESC])
            ->andFilterWhere(['>=', 'post_date', $this->from_date])
            ->andFilterWhere(['<=', 'post_date', $this->to_date]);

            if ($this->order_status == 'OPEN') {
                  $query->andFilterWhere([
                        'is', 'close_open_note', new \yii\db\Expression('null')
                    ]);
            } elseif ($this->order_status == 'CLOSE') {
                  $query->andFilterWhere([
                        'close_open_note' => 'NORMAL',
                    ]);
            } elseif ($this->order_status == 'CANCEL') {
                  $query->andFilterWhere([
                        'close_open_note' => 'CANCEL',
                    ]);
            } 

return $dataProvider;
}
}