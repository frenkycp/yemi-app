<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use app\models\ClinicDailyVisit;
use app\models\KlinikInput;
use app\models\ClinicMonthlyVisit01;
use app\models\AbsensiTbl;
use yii\web\JsExpression;

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

		//data by section
		$visit_by_section = ClinicMonthlyVisit01::find()
		->select([
			'section',
			'total_kunjungan' => 'SUM(total_kunjungan)',
			'total_periksa' => 'SUM(total_periksa)',
			'total_istirahat' => 'SUM(total_istirahat)',
			'total_laktasi' => 'SUM(total_laktasi)',
			'TOTAL_EMP' => 'COUNT(nik)'
		])
		->where([
			'period' => $period
		])
		->andWhere(['<>', 'section', ''])
		->groupBy('section')
		->orderBy('section')
		->all();

		$tmp_total_emp = AbsensiTbl::find()
		->select([
			'SECTION',
			'DATE',
			'total_karyawan' => 'COUNT(NIK)'
		])
		->where([
			'PERIOD' => $period
		])
		->groupBy('SECTION, DATE')
		->all();

		$section_categories = [];
		$tmp_data_section1 = $tmp_data_section2 = $tmp_data_section3 = $tmp_emp_arr = [];

		foreach ($visit_by_section as $key => $value) {
			$section_categories[] = strtoupper($value->section);
			$tmp_data_section1[] = [
				'y' => $value->TOTAL_EMP == 0 ? null : (int)$value->TOTAL_EMP,
				'url' => Url::to(['get-remark-by-section', 'section' => $value->section, 'opsi' => 1, 'period' => $period]),
			];

			$total_emp = 0;
			foreach ($tmp_total_emp as $key => $value2) {
				if ($value2->SECTION == $value->section && $value2->total_karyawan > $total_emp) {
					$total_emp = $value2->total_karyawan;
				}
			}
			$tmp_pct = 0;
			if ($total_emp > 0) {
				$tmp_pct = round(($value->TOTAL_EMP / $total_emp) * 100);
			}
			$tmp_emp_arr[] = [
				'y' => $tmp_pct
			];
		}

		$data_by_section = [
			[
				'name' => 'Jumlah Karyawan',
				'data' => $tmp_data_section1,
				'type' => 'column',
				'yAxis' => 1,
				'dataLabels' => [
					'enabled' => true
				],
				'showInLegend' => false
			],
			[
				'name' => 'Presentase Kunjungan',
				'data' => $tmp_emp_arr,
				'type' => 'line',
				'tooltip' => [
					'valueSuffix' => '%'
				],
				'dataLabels' => [
					'enabled' => true,
					'format' => '{y} %',
				],
				'showInLegend' => false
			],
		];

		return $this->render('index', [
			'section_categories' => $section_categories,
			'data_by_section' => $data_by_section,
			'year' => $year,
			'month' => $month,
			'checkup_by_diagnose' => $this->checkupByDiagnose($period, 1),
			'checkup_by_root_cause' => $this->checkupByRootCause($period, 1),
			'rest_by_diagnose' => $this->checkupByDiagnose($period, 2),
			'rest_by_root_cause' => $this->checkupByRootCause($period, 2),
		]);
	}

	public function checkupByDiagnose($period, $opsi)
	{
		$tmp_data = $categories = [];
		$diagnose_data = KlinikInput::find()
		->select([
			'diagnosa',
			'jumlah_karyawan' => 'COUNT(pk)'
		])
		->where([
			'EXTRACT(year_month FROM pk)' => $period,
			'opsi' => $opsi
		])
		->groupBy('diagnosa')
		->orderBy('jumlah_karyawan DESC')
		->asArray()
		->all();

		$data_count = 1;
		foreach ($diagnose_data as $key => $value) {
			
			$categories[] = $value['diagnosa'];
			if ($data_count == 1) {
				$color = \Yii::$app->params['bg-red'];
				
			} elseif ($data_count == 2){
				$color = \Yii::$app->params['bg-yellow'];
			}else {
				$color = new JsExpression('Highcharts.getOptions().colors[0]');
			}
			$tmp_data[] = [
				'y' => (int)$value['jumlah_karyawan'],
				'color' => $color,
			];
			$data_count++;
		}

		$data = [
			'categories' => $categories,
			'data' => [
				[
					'name' => 'DIAGNOSA',
					'data' => $tmp_data,
					'showInLegend' => false
				]
			],
		];

		return $data;
	}

	public function checkupByRootCause($period, $opsi)
	{
		$tmp_data = $categories = [];
		$diagnose_data = KlinikInput::find()
		->select([
			'root_cause',
			'jumlah_karyawan' => 'COUNT(pk)'
		])
		->where([
			'EXTRACT(year_month FROM pk)' => $period,
			'opsi' => $opsi
		])
		->groupBy('root_cause')
		->orderBy('jumlah_karyawan DESC')
		->asArray()
		->all();

		$data_count = 1;
		foreach ($diagnose_data as $key => $value) {
			$categories[] = $value['root_cause'];
			if ($data_count == 1) {
				$color = \Yii::$app->params['bg-red'];
				
			} elseif ($data_count == 2){
				$color = \Yii::$app->params['bg-yellow'];
			}else {
				$color = new JsExpression('Highcharts.getOptions().colors[0]');
			}
			$tmp_data[] = [
				'y' => (int)$value['jumlah_karyawan'],
				'color' => $color,
			];
			$data_count++;
		}

		$data = [
			'categories' => $categories,
			'data' => [
				[
					'name' => 'PENYEBAB',
					'data' => $tmp_data,
					'showInLegend' => false
				]
			],
		];

		return $data;
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