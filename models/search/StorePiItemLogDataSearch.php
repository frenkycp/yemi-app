<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StorePiItem;

/**
* StorePiItemLogDataSearch represents the model behind the search form about `app\models\StorePiItemLog`.
*/
class StorePiItemLogDataSearch extends StorePiItem
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['SLIP', 'BARCODE', 'BARCODE_QTY', 'PI_PERIOD', 'ITEM', 'ITEM_DESC', 'UM', 'AREA', 'STORAGE', 'STORAGE_DESC', 'PIC', 'RACK', 'RACK_LOC', 'PI_CREATED_BY', 'PI_CREATED', 'PI_COUNT_01_ID', 'PI_COUNT_01_DESC', 'PI_COUNT_01_STAT', 'PI_COUNT_01_TIMER', 'PI_COUNT_01_LAST_UPDATE', 'PI_COUNT_02_ID', 'PI_COUNT_02_DESC', 'PI_COUNT_02_STAT', 'PI_COUNT_02_TIMER', 'PI_COUNT_02_LAST_UPDATE', 'PI_AUDIT_01_ID', 'PI_AUDIT_01_DESC', 'PI_AUDIT_01_STAT', 'PI_AUDIT_01_TIMER', 'PI_AUDIT_01_LAST_UPDATE', 'PI_AUDIT_02_ID', 'PI_AUDIT_02_DESC', 'PI_AUDIT_02_STAT', 'PI_AUDIT_02_TIMER', 'PI_AUDIT_02_LAST_UPDATE', 'NOTE_01', 'NOTE_02', 'NOTE_03', 'NOTE_04', 'NOTE_05', 'NOTE_06', 'NOTE_07', 'NOTE_08', 'NOTE_09', 'NOTE_10', 'SLIP_STAT', 'PI_DUMMY', 'PI_MISTAKE', 'CATEGORY', 'SLIP_SAP'], 'safe'],
            [['SLIP_INT', 'SESSION', 'PI_STAGE'], 'integer'],
            [['PI_VALUE', 'PI_COUNT_01', 'PI_COUNT_01_PROGRESS', 'PI_COUNT_01_TIMER_SECOND', 'PI_COUNT_02', 'PI_COUNT_02_PROGRESS', 'PI_COUNT_02_TIMER_SECOND', 'PI_AUDIT_01', 'PI_AUDIT_01_PROGRESS', 'PI_AUDIT_01_TIMER_SECOND', 'PI_AUDIT_02', 'PI_AUDIT_02_PROGRESS', 'PI_AUDIT_02_TIMER_SECOND', 'Q01_NO', 'Q01_QTY', 'Q01_TOT', 'Q02_NO', 'Q02_QTY', 'Q02_TOT', 'Q03_NO', 'Q03_QTY', 'Q03_TOT', 'Q04_NO', 'Q04_QTY', 'Q04_TOT', 'Q05_NO', 'Q05_QTY', 'Q05_TOT', 'Q06_NO', 'Q06_QTY', 'Q06_TOT', 'Q07_NO', 'Q07_QTY', 'Q07_TOT', 'Q08_NO', 'Q08_QTY', 'Q08_TOT', 'Q09_NO', 'Q09_QTY', 'Q09_TOT', 'Q10_NO', 'Q10_QTY', 'Q10_TOT'], 'number'],
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
$query = StorePiItem::find();

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
            'SLIP_INT' => $this->SLIP_INT,
            'SESSION' => $this->SESSION,
            'PI_VALUE' => $this->PI_VALUE,
            'PI_CREATED' => $this->PI_CREATED,
            'PI_COUNT_01' => $this->PI_COUNT_01,
            'PI_COUNT_01_PROGRESS' => $this->PI_COUNT_01_PROGRESS,
            'PI_COUNT_01_TIMER_SECOND' => $this->PI_COUNT_01_TIMER_SECOND,
            'PI_COUNT_01_LAST_UPDATE' => $this->PI_COUNT_01_LAST_UPDATE,
            'PI_COUNT_02' => $this->PI_COUNT_02,
            'PI_COUNT_02_PROGRESS' => $this->PI_COUNT_02_PROGRESS,
            'PI_COUNT_02_TIMER_SECOND' => $this->PI_COUNT_02_TIMER_SECOND,
            'PI_COUNT_02_LAST_UPDATE' => $this->PI_COUNT_02_LAST_UPDATE,
            'PI_AUDIT_01' => $this->PI_AUDIT_01,
            'PI_AUDIT_01_PROGRESS' => $this->PI_AUDIT_01_PROGRESS,
            'PI_AUDIT_01_TIMER_SECOND' => $this->PI_AUDIT_01_TIMER_SECOND,
            'PI_AUDIT_01_LAST_UPDATE' => $this->PI_AUDIT_01_LAST_UPDATE,
            'PI_AUDIT_02' => $this->PI_AUDIT_02,
            'PI_AUDIT_02_PROGRESS' => $this->PI_AUDIT_02_PROGRESS,
            'PI_AUDIT_02_TIMER_SECOND' => $this->PI_AUDIT_02_TIMER_SECOND,
            'PI_AUDIT_02_LAST_UPDATE' => $this->PI_AUDIT_02_LAST_UPDATE,
            'Q01_NO' => $this->Q01_NO,
            'Q01_QTY' => $this->Q01_QTY,
            'Q01_TOT' => $this->Q01_TOT,
            'Q02_NO' => $this->Q02_NO,
            'Q02_QTY' => $this->Q02_QTY,
            'Q02_TOT' => $this->Q02_TOT,
            'Q03_NO' => $this->Q03_NO,
            'Q03_QTY' => $this->Q03_QTY,
            'Q03_TOT' => $this->Q03_TOT,
            'Q04_NO' => $this->Q04_NO,
            'Q04_QTY' => $this->Q04_QTY,
            'Q04_TOT' => $this->Q04_TOT,
            'Q05_NO' => $this->Q05_NO,
            'Q05_QTY' => $this->Q05_QTY,
            'Q05_TOT' => $this->Q05_TOT,
            'Q06_NO' => $this->Q06_NO,
            'Q06_QTY' => $this->Q06_QTY,
            'Q06_TOT' => $this->Q06_TOT,
            'Q07_NO' => $this->Q07_NO,
            'Q07_QTY' => $this->Q07_QTY,
            'Q07_TOT' => $this->Q07_TOT,
            'Q08_NO' => $this->Q08_NO,
            'Q08_QTY' => $this->Q08_QTY,
            'Q08_TOT' => $this->Q08_TOT,
            'Q09_NO' => $this->Q09_NO,
            'Q09_QTY' => $this->Q09_QTY,
            'Q09_TOT' => $this->Q09_TOT,
            'Q10_NO' => $this->Q10_NO,
            'Q10_QTY' => $this->Q10_QTY,
            'Q10_TOT' => $this->Q10_TOT,
            'PI_STAGE' => $this->PI_STAGE,
        ]);

        $query->andFilterWhere(['like', 'SLIP', $this->SLIP])
            ->andFilterWhere(['like', 'BARCODE', $this->BARCODE])
            ->andFilterWhere(['like', 'BARCODE_QTY', $this->BARCODE_QTY])
            ->andFilterWhere(['like', 'PI_PERIOD', $this->PI_PERIOD])
            ->andFilterWhere(['like', 'ITEM', $this->ITEM])
            ->andFilterWhere(['like', 'ITEM_DESC', $this->ITEM_DESC])
            ->andFilterWhere(['like', 'UM', $this->UM])
            ->andFilterWhere(['like', 'AREA', $this->AREA])
            ->andFilterWhere(['like', 'STORAGE', $this->STORAGE])
            ->andFilterWhere(['like', 'STORAGE_DESC', $this->STORAGE_DESC])
            ->andFilterWhere(['like', 'PIC', $this->PIC])
            ->andFilterWhere(['like', 'RACK', $this->RACK])
            ->andFilterWhere(['like', 'RACK_LOC', $this->RACK_LOC])
            ->andFilterWhere(['like', 'PI_CREATED_BY', $this->PI_CREATED_BY])
            ->andFilterWhere(['like', 'PI_COUNT_01_ID', $this->PI_COUNT_01_ID])
            ->andFilterWhere(['like', 'PI_COUNT_01_DESC', $this->PI_COUNT_01_DESC])
            ->andFilterWhere(['like', 'PI_COUNT_01_STAT', $this->PI_COUNT_01_STAT])
            ->andFilterWhere(['like', 'PI_COUNT_01_TIMER', $this->PI_COUNT_01_TIMER])
            ->andFilterWhere(['like', 'PI_COUNT_02_ID', $this->PI_COUNT_02_ID])
            ->andFilterWhere(['like', 'PI_COUNT_02_DESC', $this->PI_COUNT_02_DESC])
            ->andFilterWhere(['like', 'PI_COUNT_02_STAT', $this->PI_COUNT_02_STAT])
            ->andFilterWhere(['like', 'PI_COUNT_02_TIMER', $this->PI_COUNT_02_TIMER])
            ->andFilterWhere(['like', 'PI_AUDIT_01_ID', $this->PI_AUDIT_01_ID])
            ->andFilterWhere(['like', 'PI_AUDIT_01_DESC', $this->PI_AUDIT_01_DESC])
            ->andFilterWhere(['like', 'PI_AUDIT_01_STAT', $this->PI_AUDIT_01_STAT])
            ->andFilterWhere(['like', 'PI_AUDIT_01_TIMER', $this->PI_AUDIT_01_TIMER])
            ->andFilterWhere(['like', 'PI_AUDIT_02_ID', $this->PI_AUDIT_02_ID])
            ->andFilterWhere(['like', 'PI_AUDIT_02_DESC', $this->PI_AUDIT_02_DESC])
            ->andFilterWhere(['like', 'PI_AUDIT_02_STAT', $this->PI_AUDIT_02_STAT])
            ->andFilterWhere(['like', 'PI_AUDIT_02_TIMER', $this->PI_AUDIT_02_TIMER])
            ->andFilterWhere(['like', 'NOTE_01', $this->NOTE_01])
            ->andFilterWhere(['like', 'NOTE_02', $this->NOTE_02])
            ->andFilterWhere(['like', 'NOTE_03', $this->NOTE_03])
            ->andFilterWhere(['like', 'NOTE_04', $this->NOTE_04])
            ->andFilterWhere(['like', 'NOTE_05', $this->NOTE_05])
            ->andFilterWhere(['like', 'NOTE_06', $this->NOTE_06])
            ->andFilterWhere(['like', 'NOTE_07', $this->NOTE_07])
            ->andFilterWhere(['like', 'NOTE_08', $this->NOTE_08])
            ->andFilterWhere(['like', 'NOTE_09', $this->NOTE_09])
            ->andFilterWhere(['like', 'NOTE_10', $this->NOTE_10])
            ->andFilterWhere(['like', 'SLIP_STAT', $this->SLIP_STAT])
            ->andFilterWhere(['like', 'PI_DUMMY', $this->PI_DUMMY])
            ->andFilterWhere(['like', 'PI_MISTAKE', $this->PI_MISTAKE])
            ->andFilterWhere(['like', 'CATEGORY', $this->CATEGORY])
            ->andFilterWhere(['like', 'SLIP_SAP', $this->SLIP_SAP]);

return $dataProvider;
}
}