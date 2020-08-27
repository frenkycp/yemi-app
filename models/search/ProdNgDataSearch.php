<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProdNgData;

/**
* ProdNgDataSearch represents the model behind the search form about `app\models\ProdNgData`.
*/
class ProdNgDataSearch extends ProdNgData
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'ng_shift', 'ng_category_id', 'inj_set_parameter'], 'integer'],
            [['document_no', 'period', 'post_date', 'loc_id', 'loc_desc', 'line', 'emp_id', 'emp_name', 'gmc_no', 'gmc_desc', 'part_no', 'part_desc', 'ng_location', 'ng_root_cause', 'ng_detail', 'ng_cause_category', 'created_time', 'created_by_id', 'created_by_name', 'updated_time', 'updated_by_id', 'updated_by_name', 'detected_by_id', 'detected_by_name', 'attachment', 'fa_area_detec', 'fa_serno', 'fa_status', 'pcb_name', 'pcb_ng_found', 'pcb_side', 'pcb_problem', 'pcb_occu', 'pcb_process', 'pcb_part_section', 'pcb_pic', 'pcb_repair', 'smt_group', 'smt_pic_aoi', 'smt_group_pic', 'ww_unit_each', 'ng_category_detail', 'ng_category_desc', 'pcb_id', 'gmc_line', 'model_group', 'next_action', 'action_status'], 'safe'],
            [['ng_qty', 'total_output', 'ww_total_price'], 'number'],
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
$query = ProdNgData::find()->where(['<>', 'ng_category_id', 28])->andWhere(['flag' => 1]);

$dataProvider = new ActiveDataProvider([
'query' => $query,
'sort' => [
            'defaultOrder' => [
                  //'cust_desc' => SORT_ASC,
                  'created_time' => SORT_DESC,
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
            'id' => $this->id,
            'loc_id' => $this->loc_id,
            'post_date' => $this->post_date,
            'ng_shift' => $this->ng_shift,
            'ng_qty' => $this->ng_qty,
            'total_output' => $this->total_output,
            'ng_category_id' => $this->ng_category_id,
            'updated_time' => $this->updated_time,
            'inj_set_parameter' => $this->inj_set_parameter,
            'ww_total_price' => $this->ww_total_price,
            'next_action' => $this->next_action,
            'action_status' => $this->action_status,
        ]);

        $query->andFilterWhere(['like', 'document_no', $this->document_no])
            ->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'gmc_line', $this->gmc_line])
            ->andFilterWhere(['like', 'ng_category_detail', $this->ng_category_detail])
            ->andFilterWhere(['like', 'ng_category_desc', $this->ng_category_desc])
            ->andFilterWhere(['like', 'CONVERT(VARCHAR(10),created_time,120)', $this->created_time])
            ->andFilterWhere(['like', 'loc_desc', $this->loc_desc])
            ->andFilterWhere(['like', 'line', $this->line])
            ->andFilterWhere(['like', 'emp_id', $this->emp_id])
            ->andFilterWhere(['like', 'emp_name', $this->emp_name])
            ->andFilterWhere(['like', 'model_group', $this->model_group])
            ->andFilterWhere(['like', 'gmc_no', $this->gmc_no])
            ->andFilterWhere(['like', 'gmc_desc', $this->gmc_desc])
            ->andFilterWhere(['like', 'part_no', $this->part_no])
            ->andFilterWhere(['like', 'part_desc', $this->part_desc])
            ->andFilterWhere(['like', 'ng_location', $this->ng_location])
            ->andFilterWhere(['like', 'ng_root_cause', $this->ng_root_cause])
            ->andFilterWhere(['like', 'ng_detail', $this->ng_detail])
            ->andFilterWhere(['like', 'ng_cause_category', $this->ng_cause_category])
            ->andFilterWhere(['like', 'created_by_id', $this->created_by_id])
            ->andFilterWhere(['like', 'created_by_name', $this->created_by_name])
            ->andFilterWhere(['like', 'updated_by_id', $this->updated_by_id])
            ->andFilterWhere(['like', 'updated_by_name', $this->updated_by_name])
            ->andFilterWhere(['like', 'detected_by_id', $this->detected_by_id])
            ->andFilterWhere(['like', 'detected_by_name', $this->detected_by_name])
            ->andFilterWhere(['like', 'attachment', $this->attachment])
            ->andFilterWhere(['like', 'fa_area_detec', $this->fa_area_detec])
            ->andFilterWhere(['like', 'fa_serno', $this->fa_serno])
            ->andFilterWhere(['like', 'fa_status', $this->fa_status])
            ->andFilterWhere(['like', 'pcb_id', $this->pcb_id])
            ->andFilterWhere(['like', 'pcb_name', $this->pcb_name])
            ->andFilterWhere(['like', 'pcb_ng_found', $this->pcb_ng_found])
            ->andFilterWhere(['like', 'pcb_side', $this->pcb_side])
            ->andFilterWhere(['like', 'pcb_problem', $this->pcb_problem])
            ->andFilterWhere(['like', 'pcb_occu', $this->pcb_occu])
            ->andFilterWhere(['like', 'pcb_process', $this->pcb_process])
            ->andFilterWhere(['like', 'pcb_part_section', $this->pcb_part_section])
            ->andFilterWhere(['like', 'pcb_pic', $this->pcb_pic])
            ->andFilterWhere(['like', 'pcb_repair', $this->pcb_repair])
            ->andFilterWhere(['like', 'smt_group', $this->smt_group])
            ->andFilterWhere(['like', 'smt_pic_aoi', $this->smt_pic_aoi])
            ->andFilterWhere(['like', 'smt_group_pic', $this->smt_group_pic])
            ->andFilterWhere(['like', 'ww_unit_each', $this->ww_unit_each]);

return $dataProvider;
}
}