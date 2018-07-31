<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MntShiftCode;

/**
* MntShiftCodeSearch represents the model behind the search form about `app\models\MntShiftCode`.
*/
class MntShiftCodeSearch extends MntShiftCode
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'flag'], 'integer'],
            [['shift_code', 'shift_desc'], 'safe'],
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
$query = MntShiftCode::find();

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
            'flag' => $this->flag,
        ]);

        $query->andFilterWhere(['like', 'shift_code', $this->shift_code])
            ->andFilterWhere(['like', 'shift_desc', $this->shift_desc]);

return $dataProvider;
}
}