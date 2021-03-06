<?php

namespace app\controllers;
use yii\web\Controller;
use app\models\SplView;
use yii\helpers\Url;
use app\models\PlanReceivingPeriod;
use app\models\SplOvertimeBudget;

/**
 * summary
 */
class HrgaSplReportDailyController extends Controller
{
    public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
    	$title = '';
    	$subtitle = '';
    	$category = [];
    	$data = [];
        $data2 = [];
    	$cc_group_arr = [];
    	$category_arr = [];
    	$tgl_lembur_arr = [];

        $year_arr = [];
        $month_arr = [];

        for ($month = 1; $month <= 12; $month++) {
            $month_arr[date("m", mktime(0, 0, 0, $month, 10))] = date("F", mktime(0, 0, 0, $month, 10));
        }

        $min_year = SplView::find()->select([
            'min_year' => 'MIN(FORMAT(TGL_LEMBUR, \'yyyy\'))'
        ])->one();

        $year_now = date('Y');
        $star_year = $min_year->min_year;
        for ($year = $star_year; $year <= $year_now; $year++) {
            $year_arr[$year] = $year;
        }

        $model = new PlanReceivingPeriod();
        $model->month = date('m');
        $model->year = date('Y');
        if ($model->load($_GET))
        {

        }

        $period = $model->year . '-' . $model->month;

        $spl_data = SplView::find()
        ->select([
            'TGL_LEMBUR' => 'TGL_LEMBUR',
            'CC_GROUP' => 'CC_GROUP',
            'JUMLAH' => 'COUNT(NIK)',
            'total_lembur' => 'SUM(NILAI_LEMBUR_ACTUAL)'
        ])
        ->where('NIK IS NOT NULL')
        ->andWhere('CC_GROUP IS NOT NULL')
        ->andWhere('NILAI_LEMBUR_ACTUAL IS NOT NULL')
        ->andWhere([
            'FORMAT(TGL_LEMBUR, \'yyyy-MM\')' => $period
        ])
        ->groupBy('CC_GROUP, TGL_LEMBUR')
        ->orderBy('TGL_LEMBUR, CC_GROUP')
        ->all();

        foreach ($spl_data as $value) {
            if(!in_array($value->CC_GROUP, $cc_group_arr)){
                $cc_group_arr[] = $value->CC_GROUP;
            }
            if (!in_array($value->TGL_LEMBUR, $tgl_lembur_arr)) {
                $tgl_lembur_arr[] = $value->TGL_LEMBUR;
            }
        }

        $prod_total_jam_lembur = 0;
        $others_total_jam_lembur = 0;
        foreach ($cc_group_arr as $cc_group) {
            $tmp_data = [];
            $tmp_data2 = [];
            foreach ($tgl_lembur_arr as $tgl_lembur) {
                $is_found = false;
                
                foreach ($spl_data as $value) {
                    if ($tgl_lembur == $value->TGL_LEMBUR && $cc_group == $value->CC_GROUP) {
                        if ($value->CC_GROUP == 'PRODUCTION') {
                            $prod_total_jam_lembur += $value->total_lembur;
                        } else {
                            $others_total_jam_lembur += $value->total_lembur;
                        }
                        $tmp_data[] = [
                            'y' => (int)$value->JUMLAH,
                            'url' => Url::to(['get-remark', 'tgl_lembur' => $tgl_lembur, 'cc_group' => $cc_group])
                            //'remark' => $this->getDetailEmpRemark($tgl_lembur, $cc_group)
                        ];
                        $tmp_data2[] = [
                            'y' => (float)$value->total_lembur,
                            'url' => Url::to(['get-remark', 'tgl_lembur' => $tgl_lembur, 'cc_group' => $cc_group])
                            //'remark' => $this->getDetailEmpRemark($tgl_lembur, $cc_group)
                        ];
                        $is_found = true;
                    }
                }
                if (!$is_found) {
                    $tmp_data[] = null;
                    $tmp_data2[] = null;
                }
                if (!in_array($tgl_lembur, $category_arr)) {
                    $category_arr[] = $tgl_lembur;
                }
            }
            $data[] = [
                'name' => $cc_group,
                'data' => $tmp_data,
            ];
            $data2[] = [
                'name' => $cc_group,
                'data' => $tmp_data2,
            ];
        }

        foreach ($category_arr as $key => $value) {
            $category_arr[$key] = date('j', strtotime($value));
        }

        $overtime_budget = $this->getOvertimeBudget($model->year . $model->month, 1);
        $overtime_budget2 = $this->getOvertimeBudget($model->year . $model->month, 2);

    	return $this->render('index', [
            'model' => $model,
    		'title' => $title,
    		'subtitle' => $subtitle,
    		'category' => $category_arr,
    		'data' => $data,
            'data2' => $data2,
            'year_arr' => $year_arr,
            'month_arr' => $month_arr,
            'prod_total_jam_lembur' => $prod_total_jam_lembur,
            'others_total_jam_lembur' => $others_total_jam_lembur,
            'overtime_budget' => $overtime_budget,
            'overtime_budget2' => $overtime_budget2,
            //'budget_progress' => 120,
            'budget_progress' => $overtime_budget == 0 ? 0 : round((($prod_total_jam_lembur / $overtime_budget) * 100), 2),
            'budget_progress2' => $overtime_budget2 == 0 ? 0 : round((($others_total_jam_lembur / $overtime_budget2) * 100), 2)
    	]);
    }

    public function getOvertimeBudget($period, $category_id)
    {
        $data = SplOvertimeBudget::find()
        ->where([
            'period' => $period,
            'category_id' => $category_id
        ])
        ->one();

        return $data->overtime_budget != null ? $data->overtime_budget : 0;
    }

    public function actionGetRemark($tgl_lembur, $cc_group)
    {
        $detail_data = SplView::find()
        ->where('NIK IS NOT NULL')
        ->andWhere(['TGL_LEMBUR' => $tgl_lembur, 'CC_GROUP' => $cc_group])
        ->andWhere('NILAI_LEMBUR_ACTUAL IS NOT NULL')
        ->orderBy('CC_GROUP ASC, CC_DESC ASC, NIK ASC')
        ->all();

        $remark = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>Department : ' . $cc_group . '<small> (' . date('Y-m-d', strtotime($tgl_lembur)) . ')' . count($detail_data) . '</small></h3>
        </div>
        <div class="modal-body">
        ';

        $remark .= '<table class="table table-bordered table-striped table-hover" style="font-size: 12px;">';
        $remark .= '
        <tr>
            <th style="text-align: center;">NO</th>
            <th style="width:100px; text-align: center;">NIK</th>
            <th>Nama</th>
            <th>Section</th>
            <th class="text-center">Check In</th>
            <th class="text-center">Check Out</th>
            <th class="text-center">Plan Lembur<br/>(Jam)</th>
            <th class="text-center">Aktual Lembur<br/>(Jam)</th>
        </tr>
        ';
        $i = 1;
        foreach ($detail_data as $detail) {
            $start_lembur = '-';
            if ($detail->START_LEMBUR_ACTUAL !== null) {
                $start_lembur = date('H:i', strtotime($detail->START_LEMBUR_ACTUAL));
            }
            $end_lembur = '-';
            if ($detail->END_LEMBUR_ACTUAL !== null) {
                $end_lembur = date('H:i', strtotime($detail->END_LEMBUR_ACTUAL));
            }
            if ($tgl_lembur == $detail->TGL_LEMBUR && $cc_group == $detail->CC_GROUP) {
                $remark .= '
                <tr>
                    <td style="text-align: center;">' . $i . '</td>
                    <td style="text-align: center;">' . $detail->NIK . '</td>
                    <td>' . $detail->NAMA_KARYAWAN . '</td>
                    <td>' . $detail->CC_DESC . '</td>
                    <td class="text-center">' . $start_lembur . '</td>
                    <td class="text-center">' . $end_lembur . '</td>
                    <td class="text-center">' . $detail->NILAI_LEMBUR_PLAN . '</td>
                    <td class="text-center">' . $detail->NILAI_LEMBUR_ACTUAL . '</td>
                </tr>
                ';
                $i++;
            }
        }

        $remark .= '</table>';
        $remark .= '</div>';

        return $remark;
    }

}