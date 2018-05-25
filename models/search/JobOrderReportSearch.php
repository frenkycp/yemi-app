<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\JobOrderToday;
use app\models\JobOrder;
use app\models\JobOrderMonth;

/**
* JobOrderSearch represents the model behind the search form about `app\models\JobOrder`.
*/
class JobOrderReportSearch extends JobOrder
{
/**
* @inheritdoc
*/
/* public function rules()
{
return [
[['JOB_ORDER_NO', 'JOB_ORDER_BARCODE', 'LOC', 'LOC_DESC', 'LINE', 'SCH_DATE', 'NIK', 'NAMA_KARYAWAN', 'SMT_SHIFT', 'KELOMPOK', 'ITEM', 'ITEM_DESC', 'UM', 'MODEL', 'DESTINATION', 'START_DATE', 'PAUSE_DATE', 'CONTINUED_DATE', 'END_DATE', 'USER_ID', 'USER_DESC', 'LAST_UPDATE', 'STAGE', 'STATUS', 'JOB_ORDER_LOT_NO', 'USER_ID_START', 'USER_DESC_START', 'USER_ID_PAUSE', 'USER_DESC_PAUSE', 'USER_ID_CONTINUED', 'USER_DESC_CONTINUED', 'USER_ID_ENDED', 'USER_DESC_ENDED', 'NOTE', 'CONFORWARD'], 'safe'],
            [['MAN_POWER'], 'integer'],
            [['LOT_QTY', 'ORDER_QTY', 'COMMIT_QTY', 'OPEN_QTY', 'STD_TIME_VAR', 'STD_TIME', 'INSERT_POINT_VAR', 'INSERT_POINT', 'LOST_TIME'], 'number'],
];
}*/

public function rules()
{
return [
[['LOC_DESC', 'SCH_DATE', 'MODEL', 'DESTINATION'], 'safe'],
            [['ORDER_QTY', 'COMMIT_QTY', 'OPEN_QTY'], 'number'],
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
      $time = new \DateTime('now');

      if(isset($_GET['index_type']))
      {
            
            if($_GET['index_type'] == 1)
            {
                  //$today = $time->format('Y-m-d');
                  //$query = JobOrder::find()->where(['SCH_DATE' => $today])->orderBy('SCH_DATE ASC');
                  //$thisMonth = $time->format('n');
                  //$query = JobOrderMonth::find()->where(['like', 'MONTH(SCH_DATE)', $thisMonth]);
                  $thisMonth = date('Ym');
                  $query = JobOrderMonth::find()->where(['PERIODE' => $thisMonth]);
            }
      }else{
            //$thisMonth = $time->format('Ym');
            //$query = JobOrderMonth::find()->orderBy('SCH_DATE ASC');
            $today = $time->format('Y-m-d');
            $query = JobOrderToday::find()->where(['SCH_DATE' => $today]);
      }


$dataProvider = new ActiveDataProvider([
      /*'pagination' => [
            'pagesize' => 20,
      ],*/
      'query' => $query,
      'sort' => ['attributes' => ['SCH_DATE']],
]);

$this->load($params);

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
//$query->where('0=1');
return $dataProvider;
}

$query->andFilterWhere([
            'SCH_DATE' => $this->SCH_DATE,
            //'MAN_POWER' => $this->MAN_POWER,
            //'LOT_QTY' => $this->LOT_QTY,
            'ORDER_QTY' => $this->ORDER_QTY,
            'COMMIT_QTY' => $this->COMMIT_QTY,
            'OPEN_QTY' => $this->OPEN_QTY,
            /* 'OPEN_QTY' => $this->OPEN_QTY,
            'START_DATE' => $this->START_DATE,
            'PAUSE_DATE' => $this->PAUSE_DATE,
            'CONTINUED_DATE' => $this->CONTINUED_DATE,
            'END_DATE' => $this->END_DATE,
            'STD_TIME_VAR' => $this->STD_TIME_VAR,
            'STD_TIME' => $this->STD_TIME,
            'INSERT_POINT_VAR' => $this->INSERT_POINT_VAR,
            'INSERT_POINT' => $this->INSERT_POINT,
            'LOST_TIME' => $this->LOST_TIME,
            'LAST_UPDATE' => $this->LAST_UPDATE, */
        ]);

        /*$query->andFilterWhere(['like', 'JOB_ORDER_NO', $this->JOB_ORDER_NO])
            ->andFilterWhere(['like', 'JOB_ORDER_BARCODE', $this->JOB_ORDER_BARCODE])
            ->andFilterWhere(['like', 'LOC', $this->LOC])*/
            $query->andFilterWhere(['like', 'LOC_DESC', $this->LOC_DESC])
            /*->andFilterWhere(['like', 'LINE', $this->LINE])
            ->andFilterWhere(['like', 'NIK', $this->NIK])
            ->andFilterWhere(['like', 'NAMA_KARYAWAN', $this->NAMA_KARYAWAN])
            ->andFilterWhere(['like', 'SMT_SHIFT', $this->SMT_SHIFT])
            ->andFilterWhere(['like', 'KELOMPOK', $this->KELOMPOK])
            ->andFilterWhere(['like', 'ITEM', $this->ITEM])
            ->andFilterWhere(['like', 'ITEM_DESC', $this->ITEM_DESC])
            ->andFilterWhere(['like', 'UM', $this->UM]) */
            ->andFilterWhere(['like', 'MODEL', $this->MODEL])
            ->andFilterWhere(['like', 'DESTINATION', $this->DESTINATION]);
            /*->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'USER_DESC', $this->USER_DESC])
            ->andFilterWhere(['like', 'STAGE', $this->STAGE])
            ->andFilterWhere(['like', 'STATUS', $this->STATUS])
            ->andFilterWhere(['like', 'JOB_ORDER_LOT_NO', $this->JOB_ORDER_LOT_NO])
            ->andFilterWhere(['like', 'USER_ID_START', $this->USER_ID_START])
            ->andFilterWhere(['like', 'USER_DESC_START', $this->USER_DESC_START])
            ->andFilterWhere(['like', 'USER_ID_PAUSE', $this->USER_ID_PAUSE])
            ->andFilterWhere(['like', 'USER_DESC_PAUSE', $this->USER_DESC_PAUSE])
            ->andFilterWhere(['like', 'USER_ID_CONTINUED', $this->USER_ID_CONTINUED])
            ->andFilterWhere(['like', 'USER_DESC_CONTINUED', $this->USER_DESC_CONTINUED])
            ->andFilterWhere(['like', 'USER_ID_ENDED', $this->USER_ID_ENDED])
            ->andFilterWhere(['like', 'USER_DESC_ENDED', $this->USER_DESC_ENDED])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE])
            ->andFilterWhere(['like', 'CONFORWARD', $this->CONFORWARD]);*/

return $dataProvider;
}
}