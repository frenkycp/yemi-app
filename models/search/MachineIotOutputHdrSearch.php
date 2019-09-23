<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MachineIotOutputHdr;

/**
* MachineIotOutputHdrSearch represents the model behind the search form about `app\models\MachineIotOutputHdr`.
*/
class MachineIotOutputHdrSearch extends MachineIotOutputHdr
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['lot_number', 'gmc', 'gmc_desc', 'start_date', 'end_date', 'parent', 'parent_desc'], 'safe'],
            [['lot_qty'], 'number'],
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
$query = MachineIotOutputHdr::find();

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
            'lot_qty' => $this->lot_qty,
            'man_power_qty' => $this->man_power_qty,
        ]);

        $query->andFilterWhere(['like', 'lot_number', $this->lot_number])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10), start_date, 120)', $this->start_date])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10), end_date, 120)', $this->end_date])
            ->andFilterWhere(['like', 'gmc', $this->gmc])
            ->andFilterWhere(['like', 'parent', $this->parent])
            ->andFilterWhere(['like', 'parent_desc', $this->parent_desc])
            ->andFilterWhere(['like', 'gmc_desc', $this->gmc_desc]);

return $dataProvider;
}
}