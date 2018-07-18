<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CisClientIpAddress;

/**
* CisClientIpAddressSearch represents the model behind the search form about `app\models\CisClientIpAddress`.
*/
class CisClientIpAddressSearch extends CisClientIpAddress
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id'], 'integer'],
            [['ip_address', 'login_datetime'], 'safe'],
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
$query = CisClientIpAddress::find();

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
            'id' => $this->id,
            'login_datetime' => $this->login_datetime,
        ]);

        $query->andFilterWhere(['like', 'ip_address', $this->ip_address]);

return $dataProvider;
}
}