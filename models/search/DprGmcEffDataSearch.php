<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SernoInput;

/**
* AbsensiTblSearch represents the model behind the search form about `app\models\AbsensiTbl`.
*/
class DprGmcEffDataSearch extends SernoInput
{
/**
* @inheritdoc
*/
public function rules()
{
return [
            [['proddate', 'line', 'gmc', 'part_name'], 'safe'],
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
//$query = DprGmcEffView::find();
$query = SernoInput::find()
->select([
    'proddate', 'tb_serno_input.line', 'tb_serno_input.gmc',
    'qty_product' => 'COUNT(tb_serno_input.gmc)',
    'qty_time' => 'ROUND(SUM(qty_time),2)',
    'mp_time' => 'ROUND(SUM(mp_time),2)',
    'mp_time_single' => 'mp_time',
    'start_time' => 'MIN(waktu)',
    'end_time' => 'MAX(waktu)',
])
->groupBy('proddate, line, tb_serno_input.gmc');
$query->joinWith('sernoMaster');

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
            //'proddate' => $this->proddate,
            'tb_serno_input.line' => $this->line,
            'tb_serno_input.gmc' => $this->gmc,
        ]);

$query->andFilterWhere(['like', 'proddate', $this->proddate]);

$query->andFilterWhere(['like', 'tb_serno_master.model', $this->part_name]);

return $dataProvider;
}
}