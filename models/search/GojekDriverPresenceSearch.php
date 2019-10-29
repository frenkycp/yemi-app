<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GojekTbl;

/**
* GojekDriverPresenceSearch represents the model behind the search form about `app\models\GojekTbl`.
*/
class GojekDriverPresenceSearch extends GojekTbl
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['GOJEK_ID', 'GOJEK_DESC', 'from_loc', 'to_loc', 'STAGE', 'LAST_UPDATE', 'TERMINAL', 'HADIR'], 'safe'],
            [['GOJEK_VALUE'], 'number'],
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
$query = GojekTbl::find()->where(['<>', 'HADIR', 'M']);

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
            'GOJEK_VALUE' => $this->GOJEK_VALUE,
            'LAST_UPDATE' => $this->LAST_UPDATE,
        ]);

        $query->andFilterWhere(['like', 'GOJEK_ID', $this->GOJEK_ID])
            ->andFilterWhere(['like', 'GOJEK_DESC', $this->GOJEK_DESC])
            ->andFilterWhere(['like', 'from_loc', $this->from_loc])
            ->andFilterWhere(['like', 'to_loc', $this->to_loc])
            ->andFilterWhere(['like', 'STAGE', $this->STAGE])
            ->andFilterWhere(['like', 'TERMINAL', $this->TERMINAL])
            ->andFilterWhere(['like', 'HADIR', $this->HADIR]);

return $dataProvider;
}
}