<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VmsPlanActualView;

/**
* VmsPlanActualSearch represents the model behind the search form about `app\models\VmsPlanActual`.
*/
class VmsPlanActualSearch extends VmsPlanActualView
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['ID', 'ID_PERIOD', 'PRODUCT_TYPE', 'BU', 'LINE', 'MODEL', 'FG_KD', 'ITEM', 'ITEM_DESC', 'DESTINATION', 'VMS_PERIOD', 'VMS_DAY', 'VMS_DATE', 'VMS_VERSION', 'SESSION_DATE', 'ACT_QTY_LAST_UPDATE', 'LINE_LAST_UPDATE', 'PCUT', 'NOTE'], 'safe'],
            [['PLAN_QTY', 'ACTUAL_QTY', 'BALANCE_QTY'], 'number'],
            [['SEESION_NO'], 'integer'],
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
$query = VmsPlanActualView::find()->where(['<>', 'LINE', 'SPC']);

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
            'VMS_DATE' => $this->VMS_DATE,
            'PLAN_QTY' => $this->PLAN_QTY,
            'ACTUAL_QTY' => $this->ACTUAL_QTY,
            'BALANCE_QTY' => $this->BALANCE_QTY,
            'SEESION_NO' => $this->SEESION_NO,
            'SESSION_DATE' => $this->SESSION_DATE,
            'ACT_QTY_LAST_UPDATE' => $this->ACT_QTY_LAST_UPDATE,
            'LINE_LAST_UPDATE' => $this->LINE_LAST_UPDATE,
        ]);

        $query->andFilterWhere(['like', 'ID', $this->ID])
            ->andFilterWhere(['like', 'ID_PERIOD', $this->ID_PERIOD])
            ->andFilterWhere(['like', 'PRODUCT_TYPE', $this->PRODUCT_TYPE])
            ->andFilterWhere(['like', 'BU', $this->BU])
            ->andFilterWhere(['like', 'LINE', $this->LINE])
            ->andFilterWhere(['like', 'MODEL', $this->MODEL])
            ->andFilterWhere(['like', 'FG_KD', $this->FG_KD])
            ->andFilterWhere(['like', 'ITEM', $this->ITEM])
            ->andFilterWhere(['like', 'ITEM_DESC', $this->ITEM_DESC])
            ->andFilterWhere(['like', 'DESTINATION', $this->DESTINATION])
            ->andFilterWhere(['like', 'VMS_PERIOD', $this->VMS_PERIOD])
            ->andFilterWhere(['like', 'VMS_DAY', $this->VMS_DAY])
            ->andFilterWhere(['like', 'VMS_VERSION', $this->VMS_VERSION])
            ->andFilterWhere(['like', 'PCUT', $this->PCUT])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE]);

return $dataProvider;
}
}