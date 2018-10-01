<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\PlanReceivingPeriod;
use app\models\AbsensiTbl;
use yii\web\JsExpression;

class HrgaAttendanceReportController extends Controller
{
	public $category_masuk = ['SHIFT-01', 'SHIFT-02', 'SHIFT-03', 'PULANG TIDAK ABSEN', 'PULANG CEPAT', 'DATANG TERLAMBAT', 'DINAS'];
	public $category_cuti = ['CUTI', 'CUTI KHUSUS', 'CUTI KHUSUS IJIN', 'KELUARGA MENINGGAL', 'MELAHIRKAN', 'KEGUGURAN', 'MENIKAH', 'MENGHITANKAN', 'ISTRI KEGUGURAN/MELAHIRKAN'];
	
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
    	$title = '';
    	$subtitle = '';
    	$data = [];
    	$category = [];
    	$year_arr = [];
		$month_arr = [];
		

		for ($month = 1; $month <= 12; $month++) {
            $month_arr[date("m", mktime(0, 0, 0, $month, 10))] = date("F", mktime(0, 0, 0, $month, 10));
        }

        $min_year = AbsensiTbl::find()->select('MIN(YEAR) as min_year')->one();

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

		$period = $model->year . $model->month;

		$attendance_report_arr = AbsensiTbl::find()
		->select([
			'DATE' => 'DATE',
			'total_karyawan' => 'SUM(TOTAL_KARYAWAN)',
			'total_kehadiran' => 'SUM(CASE WHEN CATEGORY IN (\'SHIFT-01\', \'SHIFT-02\', \'SHIFT-03\', \'PULANG TIDAK ABSEN\', \'PULANG CEPAT\', \'DATANG TERLAMBAT\', \'DINAS\') THEN 1 ELSE 0 END)',
			'total_cuti' => 'SUM(CASE WHEN CATEGORY IN (\'CUTI\', \'CUTI KHUSUS\', \'KELUARGA MENINGGAL\', \'MELAHIRKAN\', \'KEGUGURAN\', \'MENIKAH\', \'MENGHITANKAN\', \'ISTRI KEGUGURAN/MELAHIRKAN\', \'CUTI KHUSUS IJIN\') THEN 1 ELSE 0 END)'
			//'total_cuti' => 'SUM(CASE WHEN CATEGORY=\'CUTI\' OR CATEGORY=\'CUTI KHUSUS\' OR CATEGORY=\'KELUARGA MENINGGAL\' OR CATEGORY=\'CUTI KHUSUS IJIN\' THEN 1 ELSE 0 END)'
		])
		->where([
			'PERIOD' => $period
		])
		->groupBy('DATE')
		->orderBy('DATE')
		->all();

		$tmp_data_absen = [];
		$tmp_data_hadir = [];
		$tmp_data_cuti = [];
		foreach ($attendance_report_arr as $attendance_report) {

			$presentase_hadir = 0;
			$presentase_cuti = 0;
			if ($attendance_report->total_karyawan > 0) {
				$presentase_hadir = floor((($attendance_report->total_kehadiran / $attendance_report->total_karyawan) * 100));
				$presentase_cuti = round((($attendance_report->total_cuti / $attendance_report->total_karyawan) * 100));
			}

			$category[] = date('j', strtotime($attendance_report->DATE));
			$presentase_absent = 100 - ($presentase_hadir + $presentase_cuti);
			$tmp_data_absen[] = [
				'y' => $presentase_absent == 0 ? null : $presentase_absent,
				'remark' => $this->getRemark($attendance_report->DATE, 0),
				'qty' => $attendance_report->total_karyawan - ($attendance_report->total_kehadiran + $attendance_report->total_cuti),
				'year_month' => date('M Y', strtotime($period)),
			];
			$tmp_data_cuti[] = [
				'y' => $presentase_cuti == 0 ? null : $presentase_cuti,
				'remark' => $this->getRemark($attendance_report->DATE, 2),
				'qty' => $attendance_report->total_cuti,
				'year_month' => date('M Y', strtotime($period)),
			];
			$tmp_data_hadir[] = [
				'y' => $presentase_hadir == 0 ? null : $presentase_hadir,
				'remark' => $this->getRemark($attendance_report->DATE, 1),
				'qty' => $attendance_report->total_kehadiran,
				'year_month' => date('M Y', strtotime($period)),
			];
			
			
		}

		$data = [
    		[
    			'name' => 'ABSENT',
    			'data' => $tmp_data_absen,
    			'dataLabels' => [
    				'enabled' => false
    			],
    			'color' => 'rgba(200, 200, 200, 0.4)',
    			'showInLegend' => false,
    		],
    		[
    			'name' => 'ON LEAVE',
    			'data' => $tmp_data_cuti,
    			'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
    			'showInLegend' => false,
    		],
    		[
    			'name' => 'PRESENT',
    			'data' => $tmp_data_hadir,
    			'color' => new JsExpression('Highcharts.getOptions().colors[1]'),
    			'showInLegend' => false,
    		]
    	];

    	return $this->render('index', [
    		'model' => $model,
    		'data' => $data,
    		'category' => $category,
    		'title' => $title,
    		'subtitle' => $subtitle,
    		'month_arr' => $month_arr,
    		'year_arr' => $year_arr,
    	]);
    }

    public function getRemark($date, $category)
    {
    	
    	$attendance_report_arr = AbsensiTbl::find()->where([
			'DATE' => $date,
		])
		->orderBy('SECTION, NIK')
		->all();

		if ($category == 1) {
			$filter_arr = $this->category_masuk;
		} elseif ($category == 2) {
			$filter_arr = $this->category_cuti;
		} else {
			$tmp = AbsensiTbl::find()->select('DISTINCT(CATEGORY)')->where([
				'DATE' => $date,
			])->all();

			$tmp_arr = [];
			$arr_merge = array_merge($this->category_masuk, $this->category_cuti);
			foreach ($tmp as $value) {
				if (!in_array($value->CATEGORY, $arr_merge)) {
					$tmp_arr[] = $value->CATEGORY;
				}
			}
			$filter_arr = $tmp_arr;
		}

		$total_shift_arr = AbsensiTbl::find()
		->select([
			'SHIFT',
			'total_karyawan' => 'COUNT(NIK)'
		])
		->where([
			'DATE' => $date,
			'CATEGORY' => $filter_arr
		])
		->groupBy('SHIFT')
		->orderBy('SHIFT')
		->all();

		$data = '<p><b>Date : ' . date('Y-m-d', strtotime($date)) . '</b></p>';

		foreach ($total_shift_arr as $total_shift) {
			$shift_name = $total_shift->SHIFT != '' ? $total_shift->SHIFT : '[?]';
			$data .= '<p>Total Shift ' . $shift_name . ' : ' . $total_shift->total_karyawan . '</p>';
		}

		$data .= '<table class="table table-bordered table-striped table-hover">';
		$data .= 
		'<tr>
			<th class="text-center">NO</th>
			<th class="text-center">NIK</th>
			<th>Nama Karyawan</th>
			<th class="text-center">Section</th>
			<th class="text-center">Shift</th>
			<th class="text-center">Keterangan</th>
            <th class="text-center">Bonus</th>
            <th class="text-center">Disiplin</th>
            <th class="text-center" style="width: 100px;">Hari Kerja/<br/>Libur</th>
		</tr>'
		;

		$i = 1;
		foreach ($attendance_report_arr as $attendance_report) {
			if (in_array($attendance_report->CATEGORY, $filter_arr)) {

				$bonus = '<i class="fa fa-fw fa-close text-red"></i>';
				if ($attendance_report['BONUS'] == 1) {
					$bonus = '<i class="fa fa-fw fa-check text-green"></i>';
				}

				$disiplin = '<i class="fa fa-fw fa-close text-red"></i>';
				if ($attendance_report['DISIPLIN'] == 1) {
					$disiplin = '<i class="fa fa-fw fa-check text-green"></i>';
				}
				$data .= '
					<tr>
						<td class="text-center">' . $i . '</td>
						<td class="text-center">' . $attendance_report['NIK'] . '</td>
						<td>' . $attendance_report['NAMA_KARYAWAN'] . '</td>
						<td class="text-center">' . $attendance_report['SECTION'] . '</td>
						<td class="text-center">' . $attendance_report['SHIFT'] . '</td>
	                    <td class="text-center">' . $attendance_report['CATEGORY'] . '</td>
						<td class="text-center">' . $bonus . '</td>
						<td class="text-center">' . $disiplin . '</td>
						<td class="text-center">' . $attendance_report['DAY_STAT'] . '</td>
					</tr>
				';
				$i++;
			}
			
		}

		$data .= '</table>';

		return $data;
    }
}