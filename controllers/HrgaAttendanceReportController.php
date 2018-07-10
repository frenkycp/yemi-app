<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\PlanReceivingPeriod;
use app\models\AbsensiTbl;

class HrgaAttendanceReportController extends Controller
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
			'total_kehadiran' => 'SUM(KEHADIRAN)'
		])
		->where([
			//'PERIOD' => $model->year . $model->month
			'PERIOD' => $period
		])
		->groupBy('DATE')
		->orderBy('DATE')
		->all();

		$tmp_data_open = [];
		$tmp_data_close = [];
		foreach ($attendance_report_arr as $attendance_report) {
			$presentase_close = 0;
			if ($attendance_report->total_karyawan > 0) {
				$presentase_close = floor((($attendance_report->total_kehadiran / $attendance_report->total_karyawan) * 100));
			}
			$category[] = date('j', strtotime($attendance_report->DATE));
			$presentase_open = 100 - $presentase_close;
			$tmp_data_open[] = [
				'y' => $presentase_open,
				'remark' => $this->getRemark($attendance_report->DATE, 0),
				'qty' => $attendance_report->total_karyawan - $attendance_report->total_kehadiran,
				'year_month' => date('M Y', strtotime($period)),
			];
			$tmp_data_close[] = [
				'y' => $presentase_close,
				'remark' => $this->getRemark($attendance_report->DATE, 1),
				'qty' => $attendance_report->total_kehadiran,
				'year_month' => date('M Y', strtotime($period)),
			];
			
		}

		$data = [
    		[
    			'name' => 'ABSENT',
    			'data' => $tmp_data_open,
    			'dataLabels' => [
    				'enabled' => false
    			],
    			'color' => 'rgba(200, 200, 200, 0.4)',
    			'showInLegend' => false,
    		],[
    			'name' => 'PRESENT',
    			'data' => $tmp_data_close,
    			'color' => 'rgba(72,61,139,0.6)',
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

    public function getRemark($date, $kehadiran)
    {
    	$attendance_report_arr = AbsensiTbl::find()->where([
			'DATE' => $date,
			'KEHADIRAN' => $kehadiran
		])
		->orderBy('SECTION, NIK')
		->all();

		$data = '<table class="table table-bordered table-striped table-hover">';
		$data .= 
		'<tr>
			<th class="text-center">NIK</th>
			<th>Nama Karyawan</th>
			<th class="text-center">Section</th>
			<th class="text-center">Keterangan</th>
            <th class="text-center">Bonus</th>
            <th class="text-center">Disiplin</th>
            <th class="text-center" style="width: 100px;">Hari Kerja/<br/>Libur</th>
		</tr>'
		;

		foreach ($attendance_report_arr as $attendance_report) {
			$data .= '
				<tr>
					<td class="text-center">' . $attendance_report['NIK'] . '</td>
					<td>' . $attendance_report['NAMA_KARYAWAN'] . '</td>
					<td class="text-center">' . $attendance_report['SECTION'] . '</td>
                    <td class="text-center">' . $attendance_report['CATEGORY'] . '</td>
					<td class="text-center">' . $attendance_report['BONUS'] . '</td>
					<td class="text-center">' . $attendance_report['DISIPLIN'] . '</td>
					<td class="text-center">' . $attendance_report['DAY_STAT'] . '</td>
				</tr>
			';
		}

		$data .= '</table>';

		return $data;
    }
}