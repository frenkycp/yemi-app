<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use app\models\ClinicDailyVisit;
use app\models\KlinikInput;
use app\models\ClinicMonthlyVisit01;

class ClinicDailyVisitController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionIndex()
	{
		$year = date('Y');
		$month = date('m');

		if (\Yii::$app->request->get('year') != null) {
            $year = \Yii::$app->request->get('year');
        }

        if (\Yii::$app->request->get('month') != null) {
            $month = \Yii::$app->request->get('month');
        }

        $period = $year . $month;

        //data by date
		$daily_visit = ClinicDailyVisit::find()
		->where([
			'period' => $period
		])
		->all();

		$tmp_data1 = $tmp_data2 = $tmp_data3 = [];
		foreach ($daily_visit as $key => $value) {
			$proddate = (strtotime($value->input_date . " +7 hours") * 1000);
			$tmp_data1[] = [
				'x' => $proddate,
				'y' => (int)$value->total_periksa,
				'url' => Url::to(['get-remark', 'input_date' => $value->input_date, 'opsi' => 1]),
			];
			$tmp_data2[] = [
				'x' => $proddate,
				'y' => (int)$value->total_istirahat,
				'url' => Url::to(['get-remark', 'input_date' => $value->input_date, 'opsi' => 2]),
			];
			$tmp_data3[] = [
				'x' => $proddate,
				'y' => (int)$value->total_laktasi,
				'url' => Url::to(['get-remark', 'input_date' => $value->input_date, 'opsi' => 3]),
			];
		}

		$data = [
			[
				'name' => 'Total Periksa',
				'data' => $tmp_data1
			],
			[
				'name' => 'Total Istirahat',
				'data' => $tmp_data2
			],
			[
				'name' => 'Total Laktasi',
				'data' => $tmp_data3
			],
		];

		//data by section
		$visit_by_section = ClinicMonthlyVisit01::find()
		->select([
			'period',
			'section',
			'total_kunjungan' => 'SUM(total_kunjungan)',
			'total_periksa' => 'SUM(total_periksa)',
			'total_istirahat' => 'SUM(total_istirahat)',
			'total_laktasi' => 'SUM(total_laktasi)'
		])
		->groupBy('period, section')
		->orderBy('total_kunjungan DESC')
		->all();

		$section_categories = [];
		$tmp_data_section1 = $tmp_data_section2 = $tmp_data_section3 = [];
		foreach ($visit_by_section as $key => $value) {
			$section_categories[] = $value->section;
			$tmp_data_section1[] = [
				'y' => $value->total_periksa == 0 ? null : (int)$value->total_periksa,
				'url' => Url::to(['get-remark-by-section', 'section' => $value->section, 'opsi' => 1, 'period' => $period]),
			];
			$tmp_data_section2[] = [
				'y' => $value->total_istirahat == 0 ? null : (int)$value->total_istirahat,
				'url' => Url::to(['get-remark-by-section', 'section' => $value->section, 'opsi' => 2, 'period' => $period]),
			];
			$tmp_data_section3[] = [
				'y' => $value->total_laktasi == 0 ? null : (int)$value->total_laktasi,
				'url' => Url::to(['get-remark-by-section', 'section' => $value->section, 'opsi' => 3, 'period' => $period]),
			];
		}

		$data_by_section = [
			[
				'name' => 'Total Periksa',
				'data' => $tmp_data_section1
			],
			[
				'name' => 'Total Istirahat',
				'data' => $tmp_data_section2
			],
			[
				'name' => 'Total Laktasi',
				'data' => $tmp_data_section3
			],
		];

		return $this->render('index', [
			'data' => $data,
			'section_categories' => $section_categories,
			'data_by_section' => $data_by_section,
			'year' => $year,
			'month' => $month,
		]);
	}

	public function actionGetRemark($input_date, $opsi)
	{
		if ($opsi == 1) {
    		$keperluan = 'PERIKSA';
    	} elseif ($opsi == 2) {
    		$keperluan = 'ISTIRAHAT SAKIT';
    	} else {
    		$keperluan = 'LAKSTASI';
    	}
		$remark = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>' . $keperluan . ' <small>(' . $input_date . ')</small></h3>
		</div>
		<div class="modal-body">
		';
		
	    $remark .= '<table class="table table-bordered table-striped table-hover">';
	    $remark .= '<tr style="font-size: 12px;">
	    	<th>No.</th>
	    	<th class="text-center">NIK</th>
	    	<th>Nama</th>
	    	<th>Departemen</th>
	    	<th class="text-center">Masuk</th>
	    	<th class="text-center">Keluar</th>
	    	<th>Anamnesa</th>
	    	<th class="text-center">Diagnosa</th>
	    </tr>';

	    $data_arr = KlinikInput::find()
	    ->where([
	    	'date(pk)' => $input_date,
	    	'opsi' => $opsi,
	    ])
	    ->orderBy('masuk')
	    ->all();

	    $no = 1;
	    foreach ($data_arr as $key => $value) {
	    	if ($value->opsi == 1) {
	    		$keperluan = 'PERIKSA';
	    	} elseif ($value->opsi == 2) {
	    		$keperluan = 'ISTIRAHAT SAKIT';
	    	} else {
	    		$keperluan = 'LAKSTASI';
	    	}
	    	$remark .= '<tr style="font-size: 12px;">
	    		<td class="text-center">' . $no . '</td>
	    		<td class="text-center">' . $value->nik . '</td>
	    		<td>' . $value->nama . '</td>
	    		<td>' . $value->dept . '</td>
	    		<td class="text-center">' . $value->masuk . '</td>
	    		<td class="text-center">' . $value->keluar . '</td>
	    		<td>' . $value->anamnesa . '</td>
	    		<td class="text-center">' . $value->diagnosa . '</td>
	    	</tr>';
	    	$no++;
	    }

	    $remark .= '</table>';
	    $remark .= '</div>';

	    return $remark;
	}

	public function actionGetRemarkBySection($section, $opsi, $period)
	{
		if ($opsi == 1) {
    		$keperluan = 'PERIKSA';
    		$order_by = 'total1 DESC, nama ASC';
    	} elseif ($opsi == 2) {
    		$keperluan = 'ISTIRAHAT SAKIT';
    		$order_by = 'total2 DESC, nama ASC';
    	} else {
    		$keperluan = 'LAKSTASI';
    		$order_by = 'total3 DESC, nama ASC';
    	}
		$remark = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>' . $section . ' <small>(' . $keperluan . ')</small></h3>
		</div>
		<div class="modal-body">
		';
		
	    $remark .= '<table class="table table-bordered table-striped table-hover">';
	    $remark .= '<tr style="font-size: 12px;">
	    	<th>No.</th>
	    	<th class="text-center">NIK</th>
	    	<th>Nama</th>
	    	<th class="text-center">' . $keperluan . '</th>
	    </tr>';

	    $data_arr = KlinikInput::find()
	    ->select([
	    	'nik', 'nama',
	    	'total1' => 'SUM(CASE WHEN opsi=1 THEN 1 ELSE 0 END)',
	    	'total2' => 'SUM(CASE WHEN opsi=2 THEN 1 ELSE 0 END)',
	    	'total3' => 'SUM(CASE WHEN opsi=3 THEN 1 ELSE 0 END)',
	    ])
	    ->where([
	    	'section' => $section,
	    	'opsi' => $opsi,
	    	'extract(year_month from pk)' => $period
	    ])
	    ->groupBy('nik, nama')
	    ->orderBy($order_by)
	    ->all();

	    $no = 1;
	    foreach ($data_arr as $key => $value) {
	    	$total = null;
	    	if ($opsi == 1) {
	    		$keperluan = 'PERIKSA';
	    		$total = $value->total1;
	    	} elseif ($opsi == 2) {
	    		$keperluan = 'ISTIRAHAT SAKIT';
	    		$total = $value->total2;
	    	} else {
	    		$keperluan = 'LAKSTASI';
	    		$total = $value->total3;
	    	}
	    	$remark .= '<tr style="font-size: 12px;">
	    		<td class="text-center">' . $no . '</td>
	    		<td class="text-center">' . $value->nik . '</td>
	    		<td>' . $value->nama . '</td>
	    		<td class="text-center">' . $total . '</td>
	    	</tr>';
	    	$no++;
	    }

	    $remark .= '</table>';
	    $remark .= '</div>';

	    return $remark;
	}
}