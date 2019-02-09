<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\JsExpression;

use app\models\SplView;
use app\models\Karyawan;

class EmpOvertimeMonthlyController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
    	$year = date('Y');
    	$data = [];
    	$nik = '';

    	if (\Yii::$app->request->get('year') !== null) {
			$year = \Yii::$app->request->get('year');
		}

		if (\Yii::$app->request->get('nik') !== null) {
			$nik = \Yii::$app->request->get('nik');
		}

		$nama_karyawan = 'Please input registered NIK...';
		$karyawan = Karyawan::find()
		->where([
			'NIK' => $nik
		])
		->one();
		if ($karyawan->NIK != null) {
			$nama_karyawan = $karyawan->NAMA_KARYAWAN;
		}

		$overtime_data = SplView::find()
		->select([
			'NIK',
			'PERIOD',
			'NILAI_LEMBUR_ACTUAL' => 'SUM(NILAI_LEMBUR_ACTUAL)'
		])
		->where([
			'NIK' => $nik,
			'LEFT(PERIOD, 4)' => $year
		])
		->groupBy('NIK, PERIOD')
		->all();

		$tmp_data = [];
		$categories = [];
		$total_hour = 0;
		for ($i = 1; $i <= 12; $i++) {
			$bulan = str_pad($i, 2, '0', STR_PAD_LEFT);
			$period = $year . $bulan;

			$categories[] = $period;

			$hour = 0;
			foreach ($overtime_data as $key => $value) {
				if ($value->PERIOD == $period) {
					$hour = $value->NILAI_LEMBUR_ACTUAL;
				}
			}

			$total_hour += $hour;

			$tmp_data[] = [
				'y' => round($hour, 1),
				'url' => Url::to(['get-remark', 'nik' => $nik, 'nama_karyawan' => $nama_karyawan, 'period' => $period])
			];
			//$data[] = $period;

		}

		$data[] = [
			'name' => 'Monthly Overtime Total',
			'data' => $tmp_data
		];

    	return $this->render('index', [
			'data' => $data,
			'year' => $year,
			'nik' => $nik,
			'nama_karyawan' => $nama_karyawan,
			'categories' => $categories,
			'total_hour' => $total_hour,
		]);
    }

    public function actionGetRemark($nik, $nama_karyawan, $period)
	{
		$remark = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>' . $nama_karyawan . ' <small>(' . $period . ')</small></h3>
		</div>
		<div class="modal-body">
		';
		
	    $remark .= '<table class="table table-bordered table-striped table-hover">';
	    $remark .= '<tr style="font-size: 12px;">
	    	<th class="text-center">Date</th>
	    	<th class="text-center">Check In</th>
	    	<th class="text-center">Check Out</th>
	    	<th class="text-center">Total Hour</th>
	    	<th>Job Desc.</th>
	    </tr>';

	    $overtime_data_arr = SplView::find()
	    ->where([
	    	'NIK' => $nik,
	    	'PERIOD' => $period,
	    ])
	    ->orderBy('TGL_LEMBUR')
	    ->all();

	    $no = 1;
	    foreach ($overtime_data_arr as $key => $value) {

	    	$remark .= '<tr style="font-size: 12px;">
	    		<td class="text-center">' . date('Y-m-d', strtotime($value->TGL_LEMBUR)) . '</td>
	    		<td class="text-center">' . $value->START_LEMBUR_ACTUAL . '</td>
	    		<td class="text-center">' . $value->END_LEMBUR_ACTUAL . '</td>
	    		<td class="text-center">' . $value->NILAI_LEMBUR_ACTUAL . '</td>
	    		<td>' . $value->KETERANGAN . '</td>
	    	</tr>';
	    	$no++;
	    }

	    $remark .= '</table>';
	    $remark .= '</div>';

	    return $remark;
	}
}