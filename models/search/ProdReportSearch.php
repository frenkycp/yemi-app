<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProdReport;

/**
* ProdReportSearch represents the model behind the search form about `app\models\ProdReport`.
*/
class ProdReportSearch extends ProdReport
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'prod_qty'], 'integer'],
            [['model_name', 'prod_date'], 'safe'],
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
$query = ProdReport::find();

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
            'prod_date' => $this->prod_date,
            'prod_qty' => $this->prod_qty,
        ]);

        $query->andFilterWhere(['like', 'model_name', $this->model_name]);

return $dataProvider;
}
}