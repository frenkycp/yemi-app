<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SernoInput;

/**
* ProductionInspectionHistorySearch represents the model behind the search form about `app\models\SernoInput`.
*/
class ProductionInspectionHistorySearch extends SernoInput
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['num', 'flo', 'palletnum', 'adv', 'qa_result'], 'integer'],
            [['pk', 'gmc', 'line', 'proddate', 'waktu', 'sernum', 'plan', 'qa_ok', 'qa_ok_date', 'qa_ng', 'qa_ng_date', 'ship'], 'safe'],
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
$query = SernoInput::find()->groupBy('qa_ng')->where([
    '<>', 'qa_ng', ''
]);

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

$this->load($params);

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

$query->andFilterWhere([
            'num' => $this->num,
            'waktu' => $this->waktu,
            'flo' => $this->flo,
            'palletnum' => $this->palletnum,
            'adv' => $this->adv,
            'qa_result' => $this->qa_result,
        ]);

        $query->andFilterWhere(['like', 'pk', $this->pk])
            ->andFilterWhere(['like', 'gmc', $this->gmc])
            ->andFilterWhere(['like', 'line', $this->line])
            ->andFilterWhere(['like', 'proddate', $this->proddate])
            ->andFilterWhere(['like', 'sernum', $this->sernum])
            ->andFilterWhere(['like', 'plan', $this->plan])
            ->andFilterWhere(['like', 'qa_ok', $this->qa_ok])
            ->andFilterWhere(['like', 'qa_ok_date', $this->qa_ok_date])
            ->andFilterWhere(['like', 'qa_ng', $this->qa_ng])
            ->andFilterWhere(['like', 'qa_ng_date', $this->qa_ng_date])
            ->andFilterWhere(['like', 'ship', $this->ship]);

return $dataProvider;
}
}