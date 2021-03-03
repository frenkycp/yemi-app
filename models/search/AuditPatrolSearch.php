<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AuditPatrolTbl;

/**
* AuditPatrolSearch represents the model behind the search form about `app\models\AuditPatrolTbl`.
*/
class AuditPatrolSearch extends AuditPatrolTbl
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['ID', 'CATEGORY'], 'integer'],
            [['PATROL_PERIOD', 'PATROL_DATE', 'PATROL_DATETIME', 'LOC_ID', 'LOC_DESC', 'LOC_DETAIL', 'TOPIC', 'DESCRIPTION', 'ACTION', 'AUDITOR', 'AUDITEE', 'PIC_ID', 'PIC_NAME', 'USER_ID', 'USER_NAME', 'IMAGE_BEFORE_1', 'IMAGE_AFTER_1', 'STATUS', 'CC_ID', 'CC_DESC'], 'safe'],
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
$query = AuditPatrolTbl::find();

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
            'ID' => $this->ID,
            'CC_ID' => $this->CC_ID,
            'CC_DESC' => $this->CC_DESC,
            'PATROL_DATE' => $this->PATROL_DATE,
            'PATROL_DATETIME' => $this->PATROL_DATETIME,
            'CATEGORY' => $this->CATEGORY,
        ]);

        $query->andFilterWhere(['like', 'PATROL_PERIOD', $this->PATROL_PERIOD])
            ->andFilterWhere(['like', 'LOC_ID', $this->LOC_ID])
            ->andFilterWhere(['like', 'LOC_DESC', $this->LOC_DESC])
            ->andFilterWhere(['like', 'LOC_DETAIL', $this->LOC_DETAIL])
            ->andFilterWhere(['like', 'TOPIC', $this->TOPIC])
            ->andFilterWhere(['like', 'DESCRIPTION', $this->DESCRIPTION])
            ->andFilterWhere(['like', 'ACTION', $this->ACTION])
            ->andFilterWhere(['like', 'AUDITOR', $this->AUDITOR])
            ->andFilterWhere(['like', 'AUDITEE', $this->AUDITEE])
            ->andFilterWhere(['like', 'PIC_ID', $this->PIC_ID])
            ->andFilterWhere(['like', 'PIC_NAME', $this->PIC_NAME])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'USER_NAME', $this->USER_NAME])
            ->andFilterWhere(['like', 'IMAGE_BEFORE_1', $this->IMAGE_BEFORE_1])
            ->andFilterWhere(['like', 'IMAGE_AFTER_1', $this->IMAGE_AFTER_1])
            ->andFilterWhere(['like', 'STATUS', $this->STATUS]);

return $dataProvider;
}
}