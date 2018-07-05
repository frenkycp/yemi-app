<?php

namespace app\controllers;
use yii\web\Controller;
use app\models\SplView;
use app\models\PlanReceivingPeriod;

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
            'min_year' => 'FORMAT(TGL_LEMBUR, \'yyyy\')'
        ])->one();

        $year_now = date('Y');
        $star_year = $min_year->min_year;
        for ($year = $star_year; $year <= $year_now; $year++) {
            $year_arr[$year] = $year;
        }

        $model = new PlanReceivingPeriod();
        $model->month = date('m');
        $model->year = date('Y');
        if ($model->load($_POST))
        {

        }

        $period = $model->year . '-' . $model->month;

        $spl_data = SplView::find()
        ->select([
            'TGL_LEMBUR' => 'TGL_LEMBUR',
            'CC_GROUP' => 'CC_GROUP',
            'JUMLAH' => 'COUNT(NIK)',
            'total_lembur' => 'SUM(NILAI_LEMBUR_PLAN)'
        ])
        ->where('NIK IS NOT NULL')
        ->andWhere('CC_GROUP IS NOT NULL')
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

        foreach ($cc_group_arr as $cc_group) {
            $tmp_data = [];
            $tmp_data2 = [];
            foreach ($tgl_lembur_arr as $tgl_lembur) {
                $is_found = false;
                
                foreach ($spl_data as $value) {
                    if ($tgl_lembur == $value->TGL_LEMBUR && $cc_group == $value->CC_GROUP) {
                        
                        $tmp_data[] = [
                            'y' => (int)$value->JUMLAH,
                            'remark' => $this->getDetailEmpRemark($tgl_lembur, $cc_group)
                        ];
                        $tmp_data2[] = [
                            'y' => (int)$value->total_lembur,
                            'remark' => $this->getDetailEmpRemark($tgl_lembur, $cc_group)
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
            $category_arr[$key] = date('d-M-Y', strtotime($value));
        }

    	return $this->render('index', [
            'model' => $model,
    		'title' => $title,
    		'subtitle' => $subtitle,
    		'category' => $category_arr,
    		'data' => $data,
            'data2' => $data2,
            'year_arr' => $year_arr,
            'month_arr' => $month_arr
    	]);
    }

    public function getDetailEmpRemark($tgl_lembur, $cc_group)
    {
        $detail_data = $spl_data = SplView::find()
        ->where('NIK IS NOT NULL')
        ->andWhere(['TGL_LEMBUR' => $tgl_lembur, 'CC_GROUP' => $cc_group])
        ->orderBy('CC_GROUP ASC, CC_DESC ASC, NIK ASC')
        ->all();
        $remark = '<h4>' . $cc_group . ' on ' . date('d M\' Y', strtotime($tgl_lembur)) .'</h4>';
        $remark .= '<table class="table table-bordered table-striped table-hover">';
        $remark .= '
        <tr>
            <th style="text-align: center;">NO</th>
            <th style="width:100px; text-align: center;">NIK</th>
            <th>Nama</th>
            <th>Section</th>
        </tr>
        ';
        $i = 1;
        foreach ($detail_data as $detail) {
            if ($tgl_lembur == $detail->TGL_LEMBUR && $cc_group == $detail->CC_GROUP) {
                $remark .= '
                <tr>
                    <td style="text-align: center;">' . $i . '</td>
                    <td style="text-align: center;">' . $detail->NIK . '</td>
                    <td>' . $detail->NAMA_KARYAWAN . '</td>
                    <td>' . $detail->CC_DESC . '</td>
                </tr>
                ';
                $i++;
            }
        }

        return $remark;
    }
}