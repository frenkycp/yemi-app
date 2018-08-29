<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SernoInput;

/**
* SernoInputSearch represents the model behind the search form about `app\models\SernoInput`.
*/
class SernoInputSearch extends SernoInput
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['num', 'flo', 'palletnum', 'adv'], 'integer'],
            [['pk', 'gmc', 'proddate', 'sernum', 'qa_ok', 'qa_ok_date', 'plan', 'ship', 'status', 'invoice', 'vms', 'etd_ship', 'line', 'port', 'so'], 'safe'],
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
$query = SernoInput::find()->joinWith('sernoOutput');
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
            'num' => $this->num,
            'flo' => $this->flo,
            'palletnum' => $this->palletnum,
            'adv' => $this->adv,
        ]);

        $query->andFilterWhere(['like', 'pk', $this->pk])
            ->andFilterWhere(['like', 'tb_serno_input.gmc', $this->gmc])
            ->andFilterWhere(['like', 'line', $this->line])
            ->andFilterWhere(['like', 'tb_serno_output.dst', $this->port])
            ->andFilterWhere(['like', 'proddate', $this->proddate])
            ->andFilterWhere(['like', 'sernum', $this->sernum])
            //->andFilterWhere(['like', 'qa_ng', $this->qa_ng])
            ->andFilterWhere(['like', 'qa_ng_date', $this->qa_ng_date])
            //->andFilterWhere(['like', 'qa_ok', $this->qa_ok])
            ->andFilterWhere(['like', 'qa_ok_date', $this->qa_ok_date])
            ->andFilterWhere(['like', 'plan', $this->plan])
            ->andFilterWhere(['like', 'tb_serno_output.invo', $this->invoice])
            ->andFilterWhere(['like', 'tb_serno_output.etd', $this->etd_ship])
            ->andFilterWhere(['like', 'tb_serno_output.vms', $this->vms])
            ->andFilterWhere(['like', 'tb_serno_output.so', $this->so])
            ->andFilterWhere(['like', 'ship', $this->ship]);

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