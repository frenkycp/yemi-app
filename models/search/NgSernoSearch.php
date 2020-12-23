<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProdNgSernoView;

/**
* NgSernoSearch represents the model behind the search form about `app\models\ProdNgSernoView`.
*/
class NgSernoSearch extends ProdNgSernoView
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['flag'], 'integer'],
            [['loc_id', 'period', 'post_date', 'document_no', 'serial_no', 'img_before', 'img_after', 'create_date', 'last_update', 'repair_id', 'repair_name', 'user_id', 'user_name', 'gmc_no', 'gmc_desc', 'gmc_line'], 'safe'],
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
$query = ProdNgSernoView::find();

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
            'post_date' => $this->post_date,
            'create_date' => $this->create_date,
            'last_update' => $this->last_update,
            'flag' => $this->flag,
        ]);

        $query->andFilterWhere(['like', 'loc_id', $this->loc_id])
            ->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'gmc_no', $this->gmc_no])
            ->andFilterWhere(['like', 'gmc_desc', $this->gmc_desc])
            ->andFilterWhere(['like', 'gmc_line', $this->gmc_line])
            ->andFilterWhere(['like', 'document_no', $this->document_no])
            ->andFilterWhere(['like', 'serial_no', $this->serial_no])
            ->andFilterWhere(['like', 'img_before', $this->img_before])
            ->andFilterWhere(['like', 'img_after', $this->img_after])
            ->andFilterWhere(['like', 'repair_id', $this->repair_id])
            ->andFilterWhere(['like', 'repair_name', $this->repair_name])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'user_name', $this->user_name]);

return $dataProvider;
}
}