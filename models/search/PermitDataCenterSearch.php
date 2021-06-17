<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EmpPermitTbl;

/**
* PermitDataCenterSearch represents the model behind the search form about `app\models\EmpPermitTbl`.
*/
class PermitDataCenterSearch extends EmpPermitTbl
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['ID', 'FLAG'], 'integer'],
            [['NIK', 'NAMA_KARYAWAN', 'DIVISION', 'DEPARTMENT', 'SECTION', 'COST_CENTER_CODE', 'COST_CENTER_NAME', 'EMPLOY_CODE', 'PERIOD', 'POST_DATE', 'REASON', 'STATUS', 'LAST_UPDATED'], 'safe'],
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
$query = EmpPermitTbl::find()->where(['FLAG' => 1]);

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
    'defaultOrder' => [
        //'cust_desc' => SORT_ASC,
        'STATUS' => SORT_DESC,
        'LAST_UPDATED' => SORT_DESC,
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
            'ID' => $this->ID,
            'POST_DATE' => $this->POST_DATE,
            'LAST_UPDATED' => $this->LAST_UPDATED,
            'FLAG' => $this->FLAG,
        ]);

        $query->andFilterWhere(['like', 'NIK', $this->NIK])
            ->andFilterWhere(['like', 'NAMA_KARYAWAN', $this->NAMA_KARYAWAN])
            ->andFilterWhere(['like', 'DIVISION', $this->DIVISION])
            ->andFilterWhere(['like', 'DEPARTMENT', $this->DEPARTMENT])
            ->andFilterWhere(['like', 'SECTION', $this->SECTION])
            ->andFilterWhere(['like', 'COST_CENTER_CODE', $this->COST_CENTER_CODE])
            ->andFilterWhere(['like', 'COST_CENTER_NAME', $this->COST_CENTER_NAME])
            ->andFilterWhere(['like', 'EMPLOY_CODE', $this->EMPLOY_CODE])
            ->andFilterWhere(['like', 'PERIOD', $this->PERIOD])
            ->andFilterWhere(['like', 'REASON', $this->REASON])
            ->andFilterWhere(['like', 'STATUS', $this->STATUS]);

return $dataProvider;
}
}