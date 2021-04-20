<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InjMachineTbl;

/**
* InjMachineTblSearch represents the model behind the search form about `app\models\InjMachineTbl`.
*/
class InjMachineTblSearch extends InjMachineTbl
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['MACHINE_ID', 'MACHINE_DESC', 'MACHINE_ALIAS', 'MOLDING_ID', 'MOLDING_NAME', 'ITEM', 'ITEM_DESC', 'LAST_UPDATE'], 'safe'],
            [['TOTAL_COUNT'], 'integer'],
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
$query = InjMachineTbl::find();

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
            'TOTAL_COUNT' => $this->TOTAL_COUNT,
            'LAST_UPDATE' => $this->LAST_UPDATE,
        ]);

        $query->andFilterWhere(['like', 'MACHINE_ID', $this->MACHINE_ID])
            ->andFilterWhere(['like', 'MACHINE_DESC', $this->MACHINE_DESC])
            ->andFilterWhere(['like', 'MACHINE_ALIAS', $this->MACHINE_ALIAS])
            ->andFilterWhere(['like', 'MOLDING_ID', $this->MOLDING_ID])
            ->andFilterWhere(['like', 'MOLDING_NAME', $this->MOLDING_NAME])
            ->andFilterWhere(['like', 'ITEM', $this->ITEM])
            ->andFilterWhere(['like', 'ITEM_DESC', $this->ITEM_DESC]);

return $dataProvider;
}
}