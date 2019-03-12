<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SernoSlipLog;

/**
* PalletTransporterDataSearch represents the model behind the search form about `app\models\SernoSlipLog`.
*/
class PalletTransporterDataSearch extends SernoSlipLog
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['pk', 'line', 'start', 'end', 'arrival_time', 'nik', 'order_date'], 'safe'],
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
$query = SernoSlipLog::find()->where(['<>', 'line', 'MIS'])->andWhere(['<>', 'nik', ''])->orderBy('pk');

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => false
]);

$this->load($params);

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

$query->andFilterWhere([
            'pk' => $this->pk,
            'start' => $this->start,
            'end' => $this->end,
            'arrival_time' => $this->arrival_time,
        ]);

        $query->andFilterWhere(['like', 'line', $this->line])
        	->andFilterWhere(['like', 'date(pk)', $this->order_date])
            ->andFilterWhere(['like', 'nik', $this->nik]);

return $dataProvider;
}
}