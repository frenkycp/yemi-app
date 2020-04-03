<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SernoInput;

/**
* SernoInputSearch represents the model behind the search form about `app\models\SernoInput`.
*/
class OutputLocationDataSearch extends SernoInput
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['flo', 'adv'], 'integer'],
            [['pk', 'gmc', 'proddate', 'sernum', 'qa_ok', 'qa_ok_date', 'plan', 'status', 'invoice', 'vms', 'etd_ship', 'line', 'port', 'so', 'loct', 'speaker_model', 'rfid_no', 'cntr', 'loct_time'], 'safe'],
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
$query = SernoInput::find()
->select([
    'plan',
    'proddate',
    'tb_serno_input.flo',
    'tb_serno_input.gmc',
    'total' => 'COUNT(sernum)',
    'loct',
    'loct_time',
])
->joinWith('sernoRfid')
->joinWith('sernoMaster')
->joinWith('sernoOutput')
->where('tb_serno_input.flo <> 0')
->groupBy('tb_serno_input.flo');
$this->load($params);

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
        'defaultOrder' => [
            //'cust_desc' => SORT_ASC,
            'loct_time' => SORT_DESC,
        ]
    ],
]);



if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

$query->andFilterWhere([
            'tb_serno_input.flo' => $this->flo,
            'rfid' => $this->rfid_no,
            'adv' => $this->adv,
            'loct' => $this->loct,
            'tb_serno_output.cntr' => $this->cntr,
        ]);

        $query->andFilterWhere(['like', 'pk', $this->pk])
            ->andFilterWhere(['like', 'tb_serno_input.gmc', $this->gmc])
            ->andFilterWhere(['like', 'line', $this->line])
            ->andFilterWhere(['like', 'tb_serno_output.etd', $this->etd_ship])
            ->andFilterWhere(['like', 'model', $this->speaker_model])
            ->andFilterWhere(['like', 'proddate', $this->proddate])
            ->andFilterWhere(['like', 'sernum', $this->sernum])
            ->andFilterWhere(['like', 'loct_time', $this->loct_time])
            ->andFilterWhere(['like', 'qa_ng_date', $this->qa_ng_date])
            ->andFilterWhere(['like', 'qa_ok_date', $this->qa_ok_date])
            ->andFilterWhere(['like', 'plan', $this->plan]);

return $dataProvider;
}
}