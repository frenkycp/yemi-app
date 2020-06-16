<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SernoInputAll;

/**
* SernoInputSearch represents the model behind the search form about `app\models\SernoInput`.
*/
class SernoInputSearch extends SernoInputAll
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['flo', 'adv'], 'integer'],
            [['pk', 'gmc', 'proddate', 'sernum', 'qa_ok', 'qa_ok_date', 'plan', 'status', 'invoice', 'vms', 'etd_ship', 'line', 'port', 'speaker_model', 'so', 'loct'], 'safe'],
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
$query = SernoInputAll::find()
->joinWith('sernoOutput')
->joinWith('sernoMaster')
->where('flo <> 0');
$this->load($params);
/*$query1 = (new \yii\db\Query())
    ->select("*")
    ->from('tb_serno_input')
    ->where('proddate LIKE \'' . $this->proddate . '\'');

$query2 = (new \yii\db\Query())
    ->select("*")
    ->from('tb_serno_input_backup')
    ->where('proddate LIKE \'' . $this->proddate . '\'');

$query1->union($query2, false);//false is UNION, true is UNION ALL
$sql = $query1->createCommand()->getRawSql();
//$sql .= ' LIMIT 100';
$query = SernoInput::findBySql($sql);*/

$dataProvider = new ActiveDataProvider([
'query' => $query,
]);



if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

$query->andFilterWhere([
            'flo' => $this->flo,
            'adv' => $this->adv,
            'loct' => $this->loct,
        ]);

        $query->andFilterWhere(['like', 'pk', $this->pk])
            ->andFilterWhere(['like', 'tb_serno_input_all.gmc', $this->gmc])
            ->andFilterWhere(['like', 'tb_serno_master.model', $this->speaker_model])
            ->andFilterWhere(['like', 'tb_serno_input_all.line', $this->line])
            ->andFilterWhere(['like', 'tb_serno_output.dst', $this->port])
            ->andFilterWhere(['like', 'proddate', $this->proddate])
            ->andFilterWhere(['like', 'sernum', $this->sernum])
            ->andFilterWhere(['like', 'qa_ng_date', $this->qa_ng_date])
            ->andFilterWhere(['like', 'qa_ok_date', $this->qa_ok_date])
            ->andFilterWhere(['like', 'plan', $this->plan])
            ->andFilterWhere(['like', 'tb_serno_output.invo', $this->invoice])
            ->andFilterWhere(['like', 'tb_serno_output.etd', $this->etd_ship])
            ->andFilterWhere(['like', 'tb_serno_output.vms', $this->vms])
            ->andFilterWhere(['like', 'tb_serno_output.so', $this->so]);

        if ($this->status == 'OK') {
            $query->andWhere([
                'qa_ng' => '',
                'qa_ok' => 'OK'
            ]);
        } else if ($this->status == 'LOT OUT') {
            $query->andWhere(['<>', 'qa_ng', ''])->andWhere(['<>', 'qa_result', 2]);
        } else if ($this->status == 'REPAIR') {
            $query->andWhere(['<>', 'qa_ng', ''])->andWhere(['qa_result' => 2]);
        } elseif ($this->status == 'OPEN') {
            $query->andFilterWhere([
                'qa_ng' => '',
                'qa_ok' => ''
            ]);
        }

return $dataProvider;
}
}