<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InjMoldingTbl;

/**
* InjMoldingTblSearch represents the model behind the search form about `app\models\InjMoldingTbl`.
*/
class InjMoldingTblSearch extends InjMoldingTbl
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['MOLDING_ID', 'MOLDING_NAME', 'MACHINE_ID', 'MACHINE_DESC', 'LAST_UPDATE', 'SHOT_PCT'], 'safe'],
            [['TOTAL_COUNT', 'TARGET_COUNT', 'MOLDING_STATUS'], 'integer'],
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
$query = InjMoldingTbl::find();

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
    'defaultOrder' => [
        //'cust_desc' => SORT_ASC,
        'SHOT_PCT' => SORT_DESC,
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
            'TOTAL_COUNT' => $this->TOTAL_COUNT,
            'SHOT_PCT' => $this->SHOT_PCT,
            'TARGET_COUNT' => $this->TARGET_COUNT,
            'MOLDING_STATUS' => $this->MOLDING_STATUS,
            'LAST_UPDATE' => $this->LAST_UPDATE,
        ]);

        $query->andFilterWhere(['like', 'MOLDING_ID', $this->MOLDING_ID])
            ->andFilterWhere(['like', 'MOLDING_NAME', $this->MOLDING_NAME])
            ->andFilterWhere(['like', 'MACHINE_ID', $this->MACHINE_ID])
            ->andFilterWhere(['like', 'MACHINE_DESC', $this->MACHINE_DESC]);

return $dataProvider;
}
}