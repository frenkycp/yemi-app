<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserSupplement;

/**
* UserSupplementSearch represents the model behind the search form about `app\models\UserSupplement`.
*/
class UserSupplementSearch extends UserSupplement
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id_user'], 'integer'],
            [['username', 'nm_user', 'password', 'level'], 'safe'],
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
$query = UserSupplement::find();

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
            'id_user' => $this->id_user,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'nm_user', $this->nm_user])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'level', $this->level]);

return $dataProvider;
}
}