<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TemperatureOverAction;

/**
* TemperatureOverActionSearch represents the model behind the search form about `app\models\TemperatureOverAction`.
*/
class TemperatureOverActionSearch extends TemperatureOverAction
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['ID', 'POST_DATE', 'EMP_ID', 'EMP_NAME', 'LAST_CHECK'], 'safe'],
            [['SHIFT', 'NEXT_ACTION'], 'integer'],
            [['OLD_TEMPERATURE', 'NEW_TEMPERATURE'], 'number'],
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
$query = TemperatureOverAction::find();

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
            'POST_DATE' => $this->POST_DATE,
            'SHIFT' => $this->SHIFT,
            'LAST_CHECK' => $this->LAST_CHECK,
            'OLD_TEMPERATURE' => $this->OLD_TEMPERATURE,
            'NEW_TEMPERATURE' => $this->NEW_TEMPERATURE,
            'NEXT_ACTION' => $this->NEXT_ACTION,
        ]);

        $query->andFilterWhere(['like', 'ID', $this->ID])
            ->andFilterWhere(['like', 'EMP_ID', $this->EMP_ID])
            ->andFilterWhere(['like', 'EMP_NAME', $this->EMP_NAME]);

return $dataProvider;
}
}