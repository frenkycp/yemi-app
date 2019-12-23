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
            [['proddate', 'line', 'gmc'], 'safe'],
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
    'proddate', 'line', 'gmc',
    'qty_product' => 'COUNT(gmc)',
    'qty_time' => 'ROUND(SUM(qty_time),2)',
    'mp_time' => 'ROUND(SUM(mp_time),2)',
    'mp_time_single' => 'mp_time',
    'start_time' => 'MIN(waktu)',
    'end_time' => 'MAX(waktu)',
])
->groupBy('proddate, line, gmc');

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
            'line' => $this->line,
            'gmc' => $this->gmc,
        ]);

$query->andFilterWhere(['like', 'proddate', $this->proddate]);

/*$query->andFilterWhere(['like', 'NIK_DATE_ID', $this->NIK_DATE_ID])
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