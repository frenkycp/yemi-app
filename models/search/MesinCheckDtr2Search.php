<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MachineMpPlanViewMaster02;

/**
* MesinCheckDtrSearch represents the model behind the search form about `app\models\MachineMpPlanViewMaster02`.
*/
class MesinCheckDtr2Search extends MachineMpPlanViewMaster02
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['master_id', 'mesin_id', 'machine_desc', 'location', 'area', 'mesin_periode', 'user_id', 'user_desc', 'master_plan_maintenance', 'mesin_last_update'], 'safe'],
            [['count_list'], 'integer'],
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
$query = MachineMpPlanViewMaster02::find()->where(['not', ['master_plan_maintenance' => null]]);
if (isset($_GET['status'])) {
      if ($_GET['status'] == 0) {
            $query = MachineMpPlanViewMaster02::find()->where(['not', ['master_plan_maintenance' => null]])->andWhere(['mesin_last_update' => null]);
      }else {
            $query = MachineMpPlanViewMaster02::find()->where(['not', ['master_plan_maintenance' => null]])->andWhere(['not', ['mesin_last_update' => null]]);
      }
}

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
            'count_list' => $this->count_list,
        ]);

        $query->andFilterWhere(['like', 'master_id', $this->master_id])
            ->andFilterWhere(['like', 'mesin_id', $this->mesin_id])
            ->andFilterWhere(['like', 'machine_desc', $this->machine_desc])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'mesin_periode', $this->mesin_periode])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),master_plan_maintenance,120)', $this->master_plan_maintenance])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),mesin_last_update,120)', $this->mesin_last_update])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'user_desc', $this->user_desc]);

return $dataProvider;
}
}