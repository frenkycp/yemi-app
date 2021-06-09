<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\HikTemperatureView;

/**
* AbsensiTblSearch represents the model behind the search form about `app\models\AbsensiTbl`.
*/
class KaryawanSuhuViewSearch extends HikTemperatureView
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['NIK', 'PERIOD', 'POST_DATE', 'PersonName', 'from_time', 'to_time'], 'safe'],
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
$query = HikTemperatureView::find()->where('NIK IS NOT NULL');

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
    'defaultOrder' => [
        //'cust_desc' => SORT_ASC,
        'LAST_UPDATE' => SORT_DESC,
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
            'PERIOD' => $this->PERIOD,
            'POST_DATE' => $this->POST_DATE,
        ]);

        $query->andFilterWhere(['like', 'NIK', $this->NIK])
            ->andFilterWhere(['like', 'PersonName', $this->PersonName]);

        $query->andFilterWhere(['>=', 'LAST_UPDATE', $this->from_time])
        ->andFilterWhere(['<=', 'LAST_UPDATE', $this->to_time]);

return $dataProvider;
}
}