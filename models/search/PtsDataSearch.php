<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SapPickingList;

/**
* PtsDataSearch represents the model behind the search form about `app\models\SapPickingList`.
*/
class PtsDataSearch extends SapPickingList
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['barcode', 'set_list_no', 'no', 'parent', 'parent_desc', 'parent_um', 'parent_valcl', 'child', 'child_desc', 'child_um', 'valcl', 'req_date', 'issue_type', 'pic', 'rack_no', 'loc', 'analyst', 'analyst_desc', 'last_update', 'user_id', 'user_desc', 'status', 'tahap', 'add_slip', 'barcode_label', 'last_update1', 'user_id1', 'user_desc1', 'add_date', 'posting_date', 'storage', 'pts', 'PUR_LOC', 'PUR_LOC_DESC', 'pic_delivery', 'division', 'pts_print', 'hand', 'req_date_ori', 'eta_desc', 'eta_qty', 'eta_time', 'trans_mthd', 'wh_note', 'pch_note', 'stat_ok_ng', 'user_pts', 'user_desc_pts', 'last_update_pts', 'sap_post_date_sinkron', 'mrp', 'dcn_note', 'wh_valid', 'release_date', 'release_user', 'release_user_desc', 'VMS_PERIOD', 'VMS_DATE', 'hapus', 'hand_scan', 'hand_scan_datetime', 'hand_scan_user', 'hand_scan_desc', 'cek'], 'safe'],
            [['Id'], 'integer'],
            [['plan_qty', 'qty', 'req_qty', 'compl_qty', 'bo_qty'], 'number'],
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
$query = SapPickingList::find();

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
            'Id' => $this->Id,
            'req_date' => $this->req_date,
            'plan_qty' => $this->plan_qty,
            'qty' => $this->qty,
            'req_qty' => $this->req_qty,
            'last_update' => $this->last_update,
            'compl_qty' => $this->compl_qty,
            'bo_qty' => $this->bo_qty,
            'last_update1' => $this->last_update1,
            'add_date' => $this->add_date,
            'posting_date' => $this->posting_date,
            'req_date_ori' => $this->req_date_ori,
            'last_update_pts' => $this->last_update_pts,
            'release_date' => $this->release_date,
            'VMS_DATE' => $this->VMS_DATE,
            'hand_scan_datetime' => $this->hand_scan_datetime,
        ]);

        $query->andFilterWhere(['like', 'barcode', $this->barcode])
            ->andFilterWhere(['like', 'set_list_no', $this->set_list_no])
            ->andFilterWhere(['like', 'no', $this->no])
            ->andFilterWhere(['like', 'parent', $this->parent])
            ->andFilterWhere(['like', 'parent_desc', $this->parent_desc])
            ->andFilterWhere(['like', 'parent_um', $this->parent_um])
            ->andFilterWhere(['like', 'parent_valcl', $this->parent_valcl])
            ->andFilterWhere(['like', 'child', $this->child])
            ->andFilterWhere(['like', 'child_desc', $this->child_desc])
            ->andFilterWhere(['like', 'child_um', $this->child_um])
            ->andFilterWhere(['like', 'valcl', $this->valcl])
            ->andFilterWhere(['like', 'issue_type', $this->issue_type])
            ->andFilterWhere(['like', 'pic', $this->pic])
            ->andFilterWhere(['like', 'rack_no', $this->rack_no])
            ->andFilterWhere(['like', 'loc', $this->loc])
            ->andFilterWhere(['like', 'analyst', $this->analyst])
            ->andFilterWhere(['like', 'analyst_desc', $this->analyst_desc])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'user_desc', $this->user_desc])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'tahap', $this->tahap])
            ->andFilterWhere(['like', 'add_slip', $this->add_slip])
            ->andFilterWhere(['like', 'barcode_label', $this->barcode_label])
            ->andFilterWhere(['like', 'user_id1', $this->user_id1])
            ->andFilterWhere(['like', 'user_desc1', $this->user_desc1])
            ->andFilterWhere(['like', 'storage', $this->storage])
            ->andFilterWhere(['like', 'pts', $this->pts])
            ->andFilterWhere(['like', 'PUR_LOC', $this->PUR_LOC])
            ->andFilterWhere(['like', 'PUR_LOC_DESC', $this->PUR_LOC_DESC])
            ->andFilterWhere(['like', 'pic_delivery', $this->pic_delivery])
            ->andFilterWhere(['like', 'division', $this->division])
            ->andFilterWhere(['like', 'pts_print', $this->pts_print])
            ->andFilterWhere(['like', 'hand', $this->hand])
            ->andFilterWhere(['like', 'eta_desc', $this->eta_desc])
            ->andFilterWhere(['like', 'eta_qty', $this->eta_qty])
            ->andFilterWhere(['like', 'eta_time', $this->eta_time])
            ->andFilterWhere(['like', 'trans_mthd', $this->trans_mthd])
            ->andFilterWhere(['like', 'wh_note', $this->wh_note])
            ->andFilterWhere(['like', 'pch_note', $this->pch_note])
            ->andFilterWhere(['like', 'stat_ok_ng', $this->stat_ok_ng])
            ->andFilterWhere(['like', 'user_pts', $this->user_pts])
            ->andFilterWhere(['like', 'user_desc_pts', $this->user_desc_pts])
            ->andFilterWhere(['like', 'sap_post_date_sinkron', $this->sap_post_date_sinkron])
            ->andFilterWhere(['like', 'mrp', $this->mrp])
            ->andFilterWhere(['like', 'dcn_note', $this->dcn_note])
            ->andFilterWhere(['like', 'wh_valid', $this->wh_valid])
            ->andFilterWhere(['like', 'release_user', $this->release_user])
            ->andFilterWhere(['like', 'release_user_desc', $this->release_user_desc])
            ->andFilterWhere(['like', 'VMS_PERIOD', $this->VMS_PERIOD])
            ->andFilterWhere(['like', 'hapus', $this->hapus])
            ->andFilterWhere(['like', 'hand_scan', $this->hand_scan])
            ->andFilterWhere(['like', 'hand_scan_user', $this->hand_scan_user])
            ->andFilterWhere(['like', 'hand_scan_desc', $this->hand_scan_desc])
            ->andFilterWhere(['like', 'cek', $this->cek]);

return $dataProvider;
}
}